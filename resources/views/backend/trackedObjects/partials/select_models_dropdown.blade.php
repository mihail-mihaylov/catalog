
<div class="form-group">
    <label class="col-sm-2 control-label">Модел</label>
    <div class="col-sm-10">
        <select id='modelSelectBox' class='form-control fix-select2' name='tracked_object_model_id'>
            @foreach($models as $model)
                <option value='{{ $model->id }}'
                        @if (isset($trackedObject))
                            @if ($trackedObject->tracked_object_model_id == $model->id)
                                selected='selected'
                            @endif
                        @endif
                        >
                    {{{ $model->translation[0]->name }}}
                </option>
            @endforeach
        </select>
    </div>
</div>
<div class="hr-line-dashed"></div>

<script type="text/javascript">
    $('#modelSelectBox').select2({
        width: "100%",
        language: {
           "noResults": function(){
               return translations.no_data;
           }
        }
    });
</script>

