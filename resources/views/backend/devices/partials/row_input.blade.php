<tr id='input-row-{{ $input->id }}' class="gradeX">
    <td>{{ $input->order }}</td>
    <td>{{ $input->name }}</td>
    <td>{{ $input->type->type }}</td>
    <td class="pull-left">
        <button class="btn btn-xs btn-warning" data-title="{{ trans('general.edit') }}" data-action="" type="button" data-get>
            <i class="fa fa-edit"></i>
            {{ trans('general.edit') }}
        </button>
        <button class="btn btn-xs btn-danger" data-action=""  type="button" data-delete>
            <i class="fa fa-trash-o"></i>
            {{ trans('general.delete') }}
        </button>
        <button class="btn btn-xs btn-success" data-action=""  type="button" data-update>
            <i class="fa fa-refresh"></i>
            {{ trans('general.restore') }}
        </button>
    </td>
</tr>
