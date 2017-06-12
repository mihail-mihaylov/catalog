<tr id='sharedReminderRow{{ $sharedReminder->id }}' class="gradeX">
    <td></td>
    <td>{{ $sharedReminder->name ? $sharedReminder->name : '' }}</td>
    <td>
        @if ($sharedReminder->priority == 'low')
            <span class="badge badge-success">{{ trans('reminders.priority_low') }}</span>
        @endif
        @if ($sharedReminder->priority == 'normal')
            <span class="badge badge-warning">{{ trans('reminders.priority_normal') }}</span>
        @endif
        @if ($sharedReminder->priority == 'high')
            <span class="badge badge-danger">{{ trans('reminders.priority_high') }}</span>
        @endif
    </td>
    <td>
        @if ($sharedReminder->is_global)
            <span class="badge badge-success">{{ trans('reminders.scope_global') }}</span>
        @else
            <span class="badge badge-success">{{ trans('reminders.scope_personal') }}</span>
        @endif
    </td>
    <td>
        @if ($sharedReminder->deleted_at !== null)
            {{-- deleted reminders --}}
            @can('deleteReminder', $sharedReminder)
                {{-- Restore Button --}}
                <button class='btn btn-success btn-xs restoreSharedReminder' data-action='{{ route('reminders.restore', $sharedReminder->id) }}' data-update>
                    <i class="fa fa-refresh"></i>&nbsp;
                    {{ trans('general.restore') }}
                </button>
            @endcan
        @else
            {{-- not deleted reminders --}}
            @if ( $sharedReminder->is_global)
                @if($sharedReminder->is_done)
                    {{-- Disabled Finished reminder Button --}}
                    <button class='btn btn-info btn-xs disabled'>
                        <i class="fa fa-check"></i>&nbsp;
                        {{ trans('reminders.status_finished') }}
                    </button>
                @else
                    {{-- Finish reminder button --}}
                    @can('finishReminder', $sharedReminder)
                        <button class='btn btn-info btn-xs finishSharedReminder' data-action='{{ route('reminders.finish', $sharedReminder->id) }}' data-update>
                            <i class="fa fa-flag-checkered"></i>&nbsp;
                            {{trans('reminders.finish_reminder')}}
                        </button>
                    @endcan
                    @can('editReminder', $sharedReminder)
                        {{-- Edit reminder button --}}
                        <button class='btn btn-warning btn-xs editSharedReminder' data-action='{{ route('reminders.edit', $sharedReminder->id) }}' data-get data-title="{{ trans('general.edit') }}">
                            <i class="fa fa-edit"></i>&nbsp;
                            {{ trans('general.edit') }}
                        </button>
                    @endcan
                @endif
            @else
                @if ( ! $sharedReminder->is_done_by_user)
                    @can('finishReminder', $sharedReminder)
                        {{-- Finish reminder button --}}
                        <button class='btn btn-info btn-xs finishSharedReminder' data-action='{{ route('reminders.finish', $sharedReminder->id) }}' data-update>
                            <i class="fa fa-flag-checkered"></i>&nbsp;
                            {{trans('reminders.finish_reminder')}}
                        </button>
                    @endcan
                    @can('editReminder', $sharedReminder)
                        {{-- Edit reminder button --}}
                        <button class='btn btn-warning btn-xs editSharedReminder' data-action='{{ route('reminders.edit', $sharedReminder->id) }}' data-get data-title="{{ trans('general.edit') }}">
                            <i class="fa fa-edit"></i>&nbsp;
                            {{ trans('general.edit') }}
                        </button>
                    @endcan
                @else
                    {{-- Disabled Finished reminder Button --}}
                    <button class='btn btn-info btn-xs disabled'>
                        <i class="fa fa-check"></i>&nbsp;
                        {{ trans('reminders.status_finished') }}
                    </button>
                @endif
            @endif
            @can('deleteReminder', $sharedReminder)
                {{-- Delete reminder button --}}
                <button class='btn btn-danger btn-xs deleteSharedReminder' data-action='{{ route('reminders.destroy', $sharedReminder->id) }}' data-delete>
                    <i class="fa fa-trash-o"></i>&nbsp;
                    {{ trans('general.delete') }}
                </button>
            @endcan
        @endif
        @can('viewReminder', $sharedReminder)
            {{-- Show reminder Button --}}
            <button class='btn btn-success btn-xs showSharedReminder' data-action='{{ route('reminders.show', $sharedReminder->id) }}' data-title="{{ trans('general.show') }}" data-get>
                <i class="fa fa-eye"></i>&nbsp;
                {{ trans('general.show') }}
            </button>
        @endcan
    </td>
</tr>