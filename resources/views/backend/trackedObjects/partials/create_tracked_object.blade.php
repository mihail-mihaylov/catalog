<form class="form-horizontal" role="form" method="POST" action=" {{ route('trackedobjects.groups.store') }} ">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="company_id" value="{{$company->company_id}}">
    <label>Бранд</label>
    <br>
    <select name="model">
        @foreach($company->brands as $brand)
        <option value="{{$brand->id}}" >{{$brand->translation[0]->name}}</option>
        @endforeach
    </select>
    <br>
    <label>Модел</label>
    <br>
    {{--
    <select name="model">
    @foreach($brands as $brand)
    <option value="{{$brand->id}}">{{{$brand->translation[0]->name}}}</option>
    @endforeach
    </select>

    <br>
    <label>Тип</label>
    <br>
    <select name="model">
        @foreach($types as $type)
        <option value="{{$type->id}}">{{{$type->translation[0]->name}}}</option>
        @endforeach
    </select>
    <br>
    --}}
    <label>Индетификационен номер</label>
    <br>
    <input type="text" name="identification_number">
</form>
