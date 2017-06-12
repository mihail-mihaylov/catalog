{{-- @can('listUsers', $userCompany)
<div class="ibox-title">
    <h5>Списък с потребители на {{$userCompany->name}}</h5>
    <div class="ibox-tools">
        @can('createUser', $userCompany)
            <a href="{{route('user.create', ['company_id' => $userCompany->id])}}">
                <div class="btn btn-info">
                        Добавете потребител
                </div>
            </a>
        @endcan
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
            <th>Email</th>
            <th>Телефон</th>
            <th>Роля</th>
            <th>Последно вписал се:</th>
            @can('update_company_users')
                <th>Действия</th>
            @endcan
        </tr>
        </thead>
        <tbody>
        @foreach($userCompany->allUsers as $user)
        	<tr class="gradeX">
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
                <td class="center">
                    @can('manageRole', $user->role)
                    @can('updateUser', $userCompany)
                	<a class="btn btn-warning" href="{{ route('user.edit', ['user' => $user->id]) }}">Редакция</a>
                    @endcan
                    @if($user->deleted_at !== null)
                        @can('restoreUser', $userCompany)
                        <a class="btn btn-info" href="{{ route('user.restore', ['id' => $user->id]) }}">Възстановяване</a>
                        @endcan
                    @else
                        @can('deleteUser', $userCompany)
                    {!! Form::open([
                        'url' => route('user.destroy', ['id' => $user->id]),
                        'method' => 'delete',
                        'class' => 'form-horizontal'
                    ]) !!}
                        <button type="submit" class="btn btn-danger" href="{{ route('user.destroy', ['id' => $user->id]) }}">
                        Изтриване
                        </button>
                    {!! Form::close() !!}    
                        @endcan
                    @endif
                    @endcan
                </td>
            </tr>
        @endforeach
        </tbody>
        </table>
    </div>
</div>
@endcan --}}