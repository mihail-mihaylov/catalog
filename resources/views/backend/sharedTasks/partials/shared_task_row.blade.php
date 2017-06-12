@can ('viewTask', $task)
    <tr id='sharedTaskRow{{$task->id}}' class="gradeX">
        <td></td>
        <td>{{ $task->translation->first()->name }}</td>
        <td>
            @if ($task->priority == 'low')
                <span class="badge badge-success">{{ trans('tasks.priority_low') }}</span>
            @endif
            @if ($task->priority == 'normal')
                <span class="badge badge-warning">{{ trans('tasks.priority_medium') }}</span>
            @endif
            @if ($task->priority == 'high')
                <span class="badge badge-danger">{{ trans('tasks.priority_high') }}</span>
            @endif
        </td>
        <td>
            @if ($task->task_type == 0)
                <span class="badge badge-success">{{ trans('tasks.scope_global') }}</span>
            @endif
            @if ($task->task_type == 1)
                <span class="badge badge-success">{{ trans('tasks.scope_personal') }}</span>
            @endif
        </td>
        <td>
            @if ($task->deleted_at !== null)
                @can ('deleteTask',$task)
                    <button class='btn btn-success btn-xs' data-action='{{ route('shared_tasks.restore', $task->id) }}' data-update>
                        <i class="fa fa-refresh"></i>&nbsp;
                        {{ trans('general.restore') }}
                    </button>
                @endcan
            @else
                @if (($task->task_type == 0 && $task->is_done == 0) || ($task->task_type == 1 && ! $task->isDone(auth()->user()->id)))
                    @can ('finishTask', $task)
                        <button class='btn btn-info btn-xs' data-action='{{ route('shared_tasks.finish', $task->id) }}' data-update>
                            <i class="fa fa-flag-checkered"></i>&nbsp;
                            {{ trans('tasks.finish_task') }}
                        </button>
                    @endcan
                    <button class='btn btn-success btn-xs' data-action='{{ route('shared_tasks.show', $task->id) }}' data-title="{{ trans('general.show') }}" data-get>
                        <i class="fa fa-eye"></i>&nbsp;
                        {{ trans('general.show') }}
                    </button>

                    @can ('editTask', $task)
                        <button class='btn btn-warning btn-xs' data-action='{{ route('shared_tasks.edit', $task->id) }}' data-get data-title="{{ trans('general.edit') }}">
                            <i class="fa fa-edit"></i>&nbsp;
                            {{ trans('general.edit') }}
                        </button>
                    @endcan
                @else
                    <button class='btn btn-info btn-xs disabled'>
                        <i class="fa fa-check"></i>&nbsp;
                        {{ trans('tasks.status_finished') }}
                    </button>

                    <button class='btn btn-success btn-xs' data-action='{{ route('shared_tasks.show', $task->id) }}' data-title="{{ trans('general.show') }}" data-get>
                        <i class="fa fa-eye"></i>&nbsp;
                        {{ trans('general.show') }}
                    </button>
                @endif

                @can ('deleteTask', $task)
                    <button class='btn btn-danger btn-xs' data-action='{{ route('shared_tasks.destroy', $task->id) }}' data-delete>
                        <i class="fa fa-trash-o"></i>&nbsp;
                        {{ trans('general.delete') }}
                    </button>
                @endcan
            @endif
        </td>
    </tr>
@endcan