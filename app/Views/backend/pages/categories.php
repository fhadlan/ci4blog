<?php $this->extend('backend/layout/page-layout'); ?>
<?php $this->section('content') ?>

<link rel="stylesheet" href="/backend/src/plugins/datatables/css/dataTables.bootstrap4.min.css" />
<link rel="stylesheet" href="/backend/src/plugins/datatables/css/responsive.bootstrap4.min.css" />

<div class="page-header">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="title">
                <h4>Categories</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?= route_to('admin.home') ?>">Home</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Categories
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-12 mb-4">
        <div class="card card-box">
            <div class="card-header">
                <div class="clearfix">
                    <div class="pull-left">Categories</div>
                    <div class="pull-right">
                        <a href="" class="btn btn-default p-0" role="button" id="add_category_btn" data-toggle="modal" data-target="#category_modal">
                            <i class="bi bi-plus-circle"></i>
                            Add Categories
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table class="table data-table table-sm table-borderless table-hover table-stripe" id="categories_table">
                    <thead>
                        <tr>
                            <td scope='col'>#</td>
                            <td scope='col'>Name</td>
                            <!-- <td scope='col'>Sub Categories</td> -->
                            <td scope='col'>Actions</td>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 mb-4">
        <div class="card card-box">
            <div class="card-header">
                <div class="clearfix">
                    <div class="pull-left">Sub Categories</div>
                    <div class="pull-right">
                        <a href="" class="btn btn-default p-0" role="button" id="add_sub_category_btn" data-toggle="modal" data-target="#sub_category_modal">
                            <i class="bi bi-plus-circle "></i>
                            Add Sub Categories
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-small table-borderless table-hover table-striped" id="sub_categories_table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Parent Category</th>
                            <!--    <th scope="col">Posts</th> -->
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

//include
<?php include('modals/category-modal-form.php') ?>
<?php include('modals/sub-category-modal-form.php') ?>

<?php $this->endSection() ?>


<?php $this->section('stylesheets') ?>

<?php $this->endSection() ?>


<?php $this->section('scripts') ?>

<!-- <script src="//cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
<script src="/backend/src/plugins/datatables/js/buttons.bootstrap4.min.js"></script> -->

<script src="/backend/src/plugins/datatables/js/jquery.dataTables.min.js"></script>
<script src="/backend/src/plugins/datatables/js/dataTables.bootstrap4.min.js"></script>
<script src="/backend/src/plugins/datatables/js/dataTables.responsive.min.js"></script>
<script src="/backend/src/plugins/datatables/js/responsive.bootstrap4.min.js"></script>

<script>
    let dataTable = $('#categories_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "<?= route_to('get-categories') ?>",
        columns: [{
                data: 'id'
            },
            {
                data: 'name'
            },
            {
                data: 'id',
                "render": function(data) {
                    let id = data;
                    return `<button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#category_modal" id="edit" onclick="editCategory(` + id + `)"><i class="bi bi-pencil"></i></button>
                                    <button class="btn btn-danger btn-sm" id="delete" onclick="deleteCategory(` + id + `)"><i class="bi bi-trash"/></i></button>`;
                },
                orderable: false
                // className: 'dt-center editor-delete',
                // defaultContent: '<button class="btn btn-danger btn-sm"><i class="bi bi-trash"/></button>',
                // orderable: false
            }
        ]
    })

    let subdataTable = $('#sub_categories_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "<?= route_to('get-sub-categories') ?>",
        columns: [{
                data: 'id'
            },
            {
                data: 'sbname'
            },
            {
                data: 'name'
            },
            {
                data: 'id',
                "render": function(data) {
                    let id = data;
                    return `<button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#sub_category_modal" id="edit" onclick="editSubCategory(` + id + `)"><i class="bi bi-pencil"></i></button>
                                    <button class="btn btn-danger btn-sm" id="delete" onclick="deleteSubCategory(` + id + `)"><i class="bi bi-trash"/></i></button>`;
                },
                orderable: false
                // className: 'dt-center editor-delete',
                // defaultContent: '<button class="btn btn-danger btn-sm"><i class="bi bi-trash"/></button>',
                // orderable: false
            }
        ]
    })


    function populateParentCat(){
        $.get("<?= route_to('get-parent-categories') ?>", function(response) {
            $('#parent_cat').html(response.data);
        })
    }

    $(document).ready(function() {
        dataTable
        subdataTable
        populateParentCat();
    })

    //fungsi hapus kategory (tombol delete)
    function deleteCategory(id) {
        if (confirm(`Hapus data id ` + id)) {
            $.ajax({
                url: "/admin/delete-category/" + id,
                method: 'get',
                success: function(response) {
                    alert(response.msg)
                    if (response.status = 1) {
                        dataTable.ajax.reload();
                    }
                }
            })
        }
    }

    //fungsi hapus sub kategory (tombol delete)
    function deleteSubCategory(id) {
        if (confirm(`Hapus data id ` + id)) {
            $.get("<?= route_to('delete-subcategory')?>", {
            'id': id
        }, function(response) {
            alert(response.msg);
            subdataTable.ajax.reload();
        })
        }
    }
    //fungsi ketika modal category diclose
    $('#category_modal').on('hidden.bs.modal', function(e) {
        e.preventDefault();
        $('#category_modal').find('.modal-title').html('Add Category');
        $('#btnSubmit').text('Add');
        $('#category_id').val('');
        $('#category_name').val('');
        $('#category_modal').find('span.error-text').text('');

        dataTable.ajax.reload();
    })

    $('#sub_category_modal').on('hidden.bs.modal', function(e) {
        e.preventDefault();
        $('#sub_category_modal').find('.modal-title').html('Add Sub Category');
        $('#add_sub_category_form').find('#btnSubmit').text('Add');
        $('#sub_category_modal').find('span.error-text').text('');
        $('#add_sub_category_form')[0].reset();
        subdataTable.ajax.reload();
    })

    //fungsi tambah kategori
    $('#add_category_form').on('submit', function(e) {
        e.preventDefault();
        let form = this;
        let formData = new FormData(form);
        $.ajax({
            url: $(form).attr('action'),
            method: $(form).attr('method'),
            data: formData,
            processData: false,
            dataType: 'json',
            contentType: false,
            cache: false,
            beforeSend: function() {
                $(form).find('span.error-text').text('');
            },
            success: function(response) {
                if ($.isEmptyObject(response.error)) {
                    if (response.status == 1) {
                        alert(response.msg);
                        $(form)[0].reset();
                    } else {
                        alert(response.msg);
                    }
                } else {
                    $.each(response.error, function(prefix, val) {
                        $(form).find('span.' + prefix + '_error').text(val);
                    })
                }
            }
        });
    });

    //untuk membuka form category dan populate data untuk diedit
    function editCategory(id) {
        event.preventDefault();
        $('#category_modal').find('.modal-title').html('Edit Data Category');
        $('#btnSubmit').text('Edit');
        url = "<?= route_to('get-category-name') ?>";
        $.get(url, {
            'id': id
        }, function(response) {
            $('#category_name').val(response.name);
            $('#category_id').val(id);
        })
    }

    function editSubCategory(id){
        event.preventDefault();
        
        $('#sub_category_modal').find('.modal-title').html('Edit Data Sub Category');
        $('#sub_category_modal').find('#btnSubmit').text('Edit');
        url = "<?= route_to('get-sub-category-edit') ?>";
        $.get(url, {
            'id': id
        }, function(response) {
            $('#sub_category_id').val(response.id);
            $('#parent_cat').val(response.parent_cat);
            $('#sub_category_name').val(response.name);
            $('#sub_category_description').val(response.description);
            
            console.log(response)
        })
    }

    $('#add_sub_category_form').on('submit', function() {
        event.preventDefault();
        let form = this;
        let formData = new FormData(form);

        $.ajax({
            url: $(form).attr('action'),
            method: $(form).attr('method'),
            data: formData,
            processData: false,
            dataType: 'json',
            contentType: false,
            cache: false,
            beforeSend: function() {
                $(form).find('span.error-text').text('');
            },
            success: function(response) {
                if ($.isEmptyObject(response.error)) {
                    alert(response.msg);
                } else {
                    $.each(response.error, function(prefix, msg) {
                        $(form).find('span.' + prefix + '_error').text(msg);
                    })
                }
            }
        })
    })
</script>
<?php $this->endSection() ?>