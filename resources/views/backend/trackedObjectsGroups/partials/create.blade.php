<div class="tabs-container">
    <form class="form-horizontal" role="form" method="POST" data-submit data-table-name="groups_table" action="{{ route('trackedobjects.groups.store') }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        @include('backend.providers.compose_translation_tabs_create')

        <div class="form-group">
            <div class="col-sm-offset-2 pull-right m-r">
                <button type="button" class="btn btn-white" data-dismiss="modal">{{trans('general.cancel')}}</button>
                <button class="inline btn btn-primary" type="submit">{{trans('general.save')}}</button>
            </div>
        </div>
    </form>
</div>