<div class="tabs-container">
    <form class="form-horizontal" role="form" data-submit data-table-name="groups_table" method="POST" action="{{route('trackedobjects.groups.update',$group->id)}}" id="updateTrackedObjectGroupForm">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="_method" value="PUT">

        @include('backend.providers.compose_translation_tabs_edit')

        <div class="form-group">
            <div class="col-sm-offset-2 pull-right m-r">
                <button type="button" class="btn btn-white" data-dismiss="modal">{{trans('general.cancel')}}</button>
                <button class="inline btn btn-primary" type="submit">{{trans('general.save')}}</button>
            </div>
        </div>
    </form>
</div>
