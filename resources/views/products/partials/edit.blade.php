<div class="modal fade" id="edit_product_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myModalLabel">Edit product</h4>
            </div>
            <div class="modal-body">

                <form class="edit_product_form" role="form">
                    {{ csrf_field() }}
                    <input type="hidden" class="id" name="id">
                    <div class="form-group">
                        <label class="control-label" for="name">Name:</label>
                        <input type="text" name="name" class="form-control name" data-error="Please enter name."  />
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="description">Description:</label>
                        <textarea name="description" class="form-control description" data-error="Please enter description." ></textarea>
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="price">Price</label>
                        <input name="price" class="form-control price">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success edit_product">Submit</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
