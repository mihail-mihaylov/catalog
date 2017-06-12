<tr>
    <td>
        {{{$trackedObject->brand->translation[0]->name}}} \ {{{$trackedObject->identification_number}}}
    </td>
    <td>
        @if(!in_array($tracedObjectSharedReminderList[$trackedObject->id],$doneSharedRemindersIds))
        <button class='btn btn-success pull-right  finishSharedReminderForTrackedObject'
                data-tracked-object-id='{{$trackedObject->id}}'
                data-reminder-id='{{$reminder->id}}'
                data-action='{{route('reminders.trackedObject.finish',$reminder->id)}}'>
            Приключи
        </button>
        @else
        <span class="badge badge-primary pull-right">Задачата е изпълнена</span>
        @endif
    </td>
</tr>