<div class="ibox-title">
    <h5>Списък с групите на {{$userCompany->name}}</h5>
    <div class="ibox-tools">
        <a class="collapse-link">
            <i class="fa fa-chevron-up"></i>
        </a>
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
            <i class="fa fa-wrench"></i>
        </a>
        <ul class="dropdown-menu dropdown-user">
            <li><a href="#">Config option 1</a>
            </li>
            <li><a href="#">Config option 2</a>
            </li>
        </ul>
        <a class="close-link">
            <i class="fa fa-times"></i>
        </a>
    </div>
</div>
<div class="ibox-content">
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover dataTables-example" >
            <thead>
                <tr>
                    <th>{{trans('general.email')}}<th>
                    <th>{{trans('general.phone')}}</th>
                    <th>{{trans('general.user_role')}}</th>
                    <th>{{trans('users.last_login')}}</th>
                    @can('update_company_users')
                    <th>{{trans('general.actions')}}</th>
                    @endcan
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>{{trans('general.email')}}<th>
                    <th>{{trans('general.phone')}}</th>
                    <th>{{trans('general.user_role')}}</th>
                    <th>{{trans('users.last_login')}}</th>
                    @can('update_company_users')
                    <th>{{trans('general.actions')}}</th>
                    @endcan
                </tr>
            </tfoot>
            <tbody>
                @foreach($userCompany->groups as $group)
                {{-- <tr class="gradeX">
                <td>
                    {{ $user->email }}
                </td>
            <td>
                {{ $user->phone }}
            </td>
            <td>
                {{ $user->role->slug }}
            </td>
            <td class="center">
                {{ $user->last_login }}
            </td>
            @can('update_company_users')
            <td class="center">
                <a class="btn btn-warning" href="{{ route('user.edit', ['user' => $user->id]) }}">Редакция</a>
                @can('delete_company_users')
                @if($user->deleted_at !== null)
                <a class="btn btn-info" href="{{ route('user.restore', ['id' => $user->id]) }}">Възстановяване</a>
                @else
                {!! Form::open([
                'url' => route('user.destroy', ['id' => $user->id]),
                'method' => 'delete',
                'class' => 'form-horizontal'
                ]) !!}
                <button type="submit" class="btn btn-danger" href="{{ route('user.destroy', ['id' => $user->id]) }}">
                    Изтриване
                </button>

                {!! Form::close() !!}    
                @endif
                @endcan
            </td>
            @endcan
            </tr> --}}
            @endforeach
            </tbody>
        </table>
    </div>
</div>