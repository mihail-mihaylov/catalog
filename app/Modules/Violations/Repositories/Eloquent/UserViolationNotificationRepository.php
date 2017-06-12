<?php
namespace App\Modules\Violations\Repositories\Eloquent;

use App\Events\ViolationEnacted;
use App\Modules\Users\Repositories\Eloquent\EloquentRepository;
use App\Modules\Violations\Interfaces\UserViolationNotificationInterface;
use App\Modules\Violations\Models\UserViolationNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Event;

class UserViolationNotificationRepository extends EloquentRepository implements UserViolationNotificationInterface
{
    public function __construct(UserViolationNotification $model)
    {
        $this->model = $model;
    }

    public function whereEquals(array $parameters, $order_by = ['id' => 'ASC'])
    {
        foreach ($parameters as $column => $value) {
            $this->model = $this->model->where($column, $value);
        }

        foreach ($order_by as $key => $value) {
            $this->model = $this->model->orderBy($key, $value);
        }

        return $this->model->get();
    }

    /**
     * Store violation notifications
     *
     * @param $id
     */
    public function storeViolationNotifications($id)
    {
        // Get users in the tracked object groups
        $users = DB::connection('slave')
            ->table('limit_violations')
            ->select(DB::raw('DISTINCT(users.id) as user_id, users.master_user_id as master_user_id'))
            ->leftJoin('devices', 'devices.id', '=', 'limit_violations.device_id')
            ->leftJoin('tracked_objects', 'tracked_objects.id', '=', 'devices.tracked_object_id')
            ->leftJoin('groups_tracked_objects', 'groups_tracked_objects.tracked_object_id', '=', 'tracked_objects.id')
            ->leftJoin('groups', 'groups.id', '=', 'groups_tracked_objects.group_id')
            ->leftJoin('users_groups', 'users_groups.group_id', '=', 'groups.id')
            ->leftJoin('users', 'users.id', '=', 'users_groups.user_id')
            ->where('limit_violations.id', $id)
            ->get();

        // get all notifications' user ids
        $notificationsList = $this->model->whereViolationId($id)->lists('user_id')->toArray();

        // Array with users ids which will receive the notification
        $users_ids = [];
        foreach ($users as $user) {
            // create a notification only if
            // there is none for this
            // user and violation
            if ( ! in_array($user->user_id, $notificationsList)) {
                // Add user to array
                $users_ids[] = $user->master_user_id;
                $this->model->create([
                    'user_id'      => $user->user_id,
                    'violation_id' => $id,
                ]);
            }
        }

        // Send notification(Sockets)
        Event::fire(new ViolationEnacted([
            'users_ids' => $users_ids,
            'type' => 'violation',
            'date_time' => Carbon::now()->format('Y-m-d H:i')
        ]));
    }
}
