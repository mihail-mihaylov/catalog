<div class="tabs-container">
    {!! Form::open([
            'url'    => route('trains.store'),
            'method' => 'POST',
            'class'  => 'form-horizontal',
            'data-submit' => '',
            'data-table-name' => ''
        ]) !!}

        {!! Form::hidden('tracked_object_id', $trackedObjectId) !!}

        <div class="row m-r">
            <div class="form-group">
                <div class="col-md-3 col-md-offset-1">
                    {!! Form::label('train_name', trans("dashboard.train_number"), ['class' => 'control-label']) !!}
                </div>
                <div class="col-md-8">
                    {!! Form::select('train_name', $trainsNames, isset($train->train_name_id) ? $train->train_name_id : null, ['id' => 'train_name', 'class' => 'select-train form-control fix-select2']) !!}
                </div>
            </div>
        </div>

        <div class="row m-r">
            <div class="form-group">
                <div class="col-md-3 col-md-offset-1">
                    {!! Form::label('train_role', trans("dashboard.train_role"), ['class' => 'control-label']) !!}
                </div>
                <div class="col-md-8">
                    {!! Form::select('train_role', $trackedObjectsRoles, isset($train->train_role) ? $train->train_role : null, ['id' => 'train_role', 'class' => 'select-role form-control']) !!}
                </div>
            </div>
        </div>

        <div class="row m-r">
            <div class="form-group">
                <div class="col-md-offset-2 pull-right m-r">
                    <button type="button" class="btn btn-white" data-dismiss="modal">{{trans('general.cancel')}}</button>
                    <button class="inline btn btn-primary" type="submit">{{trans('general.save')}}</button>
                </div>
            </div>
        </div>
    {!! Form::close() !!}
</div>

<script type="text/javascript">
    $(document).ready(function()
    {
        $(".select-train").select2({
            width: '100%',
            language: {
                "noResults": function () {
                    return translations.no_data;
                }
            },
            tags: true,
            createTag: function (params) {
                return {
                    id: params.term,
                    text: params.term,
                    newOption: true
                }
            },
            templateResult: function (data) {
                var $result = $("<span></span>");

                $result.text(data.text);

                if (data.newOption) {
                    $result.append(" <em>(" + translations.new + ")</em>");
                }

                return $result;
            }
        });

        $(".select-role").select2({
            width: '100%',
            language: {
                "noResults": function () {
                    return translations.no_data;
                }
            }
        });
    });
</script>