<div class="tabs-container">
    {!! Form::open([
        'url'    => route('group.store'),
        'method' => 'POST',
        'class'  => 'form-horizontal',
        'data-submit' => '',
        'data-table-name' => 'groups_table'
    ]) !!}
        @include('backend.providers.compose_translation_tabs_create')
        <div class="form-group">
            <div class="col-sm-offset-2 pull-right m-r">
                <button type="button" class="btn btn-white" data-dismiss="modal">{{trans('general.cancel')}}</button>
                <button class="inline btn btn-primary" type="submit">{{trans('general.save')}}</button>
            </div>
        </div>
    {!! Form::close() !!}
</div>