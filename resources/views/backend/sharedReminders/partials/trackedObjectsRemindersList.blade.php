<input type='hidden' name='reminder_row_url' value="{{route('reminders.trackedObjects.get_row',$reminder->id)}}">
<table class="table table-hover margin bottom">
    <thead>
        <tr>
            <th>{{ trans_choice('trackedObjects.trackedObject', 2) }}</th>
            <th class='text-right'>{{trans('general.actions')}}</th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <th>{{trans_choice('trackedObjects.trackedObject', 2) }}</th>
            <th class='text-right'>{{trans('general.actions')}}</th>
        </tr>
    </tfoot>
    <tbody>
        @forelse($reminder->trackedObjects as $trackedObject)
            @include('backend.sharedReminders.partials.trackedObjectReminderRow',[
                'reminder'=>$reminder,
                'trackedObject'=>$trackedObject,
                'tracedObjectSharedReminderList' => $tracedObjectSharedReminderList,
                'doneSharedRemindersIds' => $doneSharedRemindersIds,
            ])
        @empty
            {{trans('general.no_data')}}
        @endforelse
    </tbody>
</table>
