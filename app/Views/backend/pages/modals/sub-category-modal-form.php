<div class="modal fade" id="sub_category_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" style="display: none;" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="sub_category_modal_form_title">
                    Add Sub Category
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    ×
                </button>
            </div>
            <form action="<?= route_to('add-sub-category') ?>" method="post" id="add_sub_category_form">
                <div class="modal-body">
                    <?= csrf_field() ?>
                    <input type="text" name="sub_category_id" id="sub_category_id" class="form-control" value="" hidden>

                    <div class="form-group">
                        <label for="">Parent Category</label>
                        <select name="parent_cat" id="parent_cat" class="form-control">
                            <option value="">Uncategorized</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Sub Category Name</label>
                        <input type="text" name="sub_category_name" id="sub_category_name" class="form-control" value="">
                        <span class="text-danger error-text sub_category_name_error"></span>
                    </div>
                    <div class="form-group">
                        <label for="">Description</label>
                        <textarea name="sub_category_description" id="sub_category_description" class="form-control" placeholder="Description..."></textarea>
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