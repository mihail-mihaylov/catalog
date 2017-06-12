<tr id='company-row-{{$company->id}}' class="gradeX">
    <td></td>
    <td>{{ $company->translation->isEmpty() ? null : $company->translation->first()->name }}</td>
    <td>{{ $company->translation->isEmpty() ? null : $company->translation->first()->responsible_person_name }}</td>
    <td>
        @can('manageCompany', $company)
            @if($company->deleted_at == null)
                <button class="btn btn-xs btn-warning" data-action="{{ route('companies.edit', ['id'=>$company->id]) }}" data-get data-title="{{ trans('companies.edit') }}" type="button">
                    <i class="fa fa-edit"></i>
                    {{ trans('general.edit') }}
                </button>
                <button class="btn btn-xs btn-danger" data-action="{{ route('companies.destroy', ['id'=>$company->id]) }}" data-delete  type="button">
                    <i class="fa fa-trash-o"></i>
                    {{trans('general.delete')}}
                </button>
            @else
                <button class="btn btn-xs btn-success" data-action="{{ route('companies.restore',['company'=>$company->id]) }}" data-update type="button">
                    <i class="fa fa-refresh"></i>
                    {{trans('general.restore')}}
                </button>
            @endif
        @endcan
    </td>
</tr>
