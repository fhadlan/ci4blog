<div class="modal fade" id="category_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" style="display: none;" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="category_modal_form_title">
                    Add Category
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    ×
                </button>
            </div>
            <form action="<?= route_to('add-category')?>" method="post" id="add_category_form">
                <div class="modal-body">
                    <?= csrf_field() ?>
                    <input type="text" name="category_id" id="category_id" class="form-control" value="" hidden>
                    <div class="form-group">
                        <label for="">Category</label>
                        <input type="text" name="category_name" id="category_name" class="form-control" value="">
                        <span class="text-danger error-text category_name_error"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Close
                    </button>
                    <button type="submit" class="btn btn-primary" id='btnSubmit'>
                        Add
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>