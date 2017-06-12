<div class="tabs-container">
    {!! Form::open([
            'url'    => route('group.update', ['id' => $group->id]),
            'method' => 'put',
            'class'  => 'form-horizontal put_group',
            'id'     => 'group_edit_' . $group->id,
            'data-submit' => '',
            'data-table-name' => 'groups_table'
        ]) !!}
        @include('backend.providers.compose_translation_tabs_edit')
        <div class="form-group">
            <div class="col-sm-offset-2 pull-right m-r">
                <button class="btn btn-white" type="button" data-dismiss="modal">{{trans('general.cancel')}}</button>
                <button class="btn btn-primary" type="submit">{{trans('general.save')}}</button>
            </div>
        </div>
    {!! Form::close() !!}
</div>
