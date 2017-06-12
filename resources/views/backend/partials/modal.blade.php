
<!-- Modal -->
<div class="modal inmodal global_modal" id="baseModal" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="baseModalTitle"></h4>
            </div>
            <div class="modal-body">
                <div class='modal-body-loading'>
                    <div id="sk-restriction-spinner" class="sk-spinner sk-spinner-wave">
                        <div class="sk-rect1"></div>
                        <div class="sk-rect2"></div>
                        <div class="sk-rect3"></div>
                        <div class="sk-rect4"></div>
                        <div class="sk-rect5"></div>
                    </div>
                </div>

                <div class='modal-body-content'>
                    <div id="sk-restriction-spinner base-modal-submit" class="sk-spinner hidden sk-spinner-wave">
                        <div class="sk-rect1"></div>
                        <div class="sk-rect2"></div>
                        <div class="sk-rect3"></div>
                        <div class="sk-rect4"></div>
                        <div class="sk-rect5"></div>
                    </div>
                </div>
            </div>

            {{--<div class="modal-footer">--}}
                {{--<button type="button" class="btn btn-default" id="doneModalButton">OK</button>--}}
                {{--<button type="button" class="btn btn-default" id="closeModalButton" data-dismiss="modal">{{trans('general.cancel')}}</button>--}}
            {{--</div>--}}
        </div>
    </div>
</div>