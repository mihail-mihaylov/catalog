<ul class="sortable-list connectList agile-list ui-sortable" id="inprogress">
    @forelse($inputs as $input)
    @include('backend.devices.partials.input_widget_' . $input->type->type)

    @empty
    <li class="success-element">
        {{trans('devices.missing_inputs')}}
    </li>
    @endforelse    
</ul>
{{-- @if(count($inputs))
    <div class="btn manage_inputs add_input btn-custom btn-sm col-lg-12 col-md-12 col-sm-12 col-xs-12" data-get="{{route('installer.get.input', ['device' => $device])}}">
{{ trans('general.create') }}
</div>
@endif --}}