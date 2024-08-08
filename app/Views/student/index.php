<?php $this->extend('layout/app') ?>

<?php $this->section('content') ?>
<style>
    .pagination {
        --bs-pagination-active-bg: black;
        --bs-pagination-active-border-color: black;
        --bs-pagination-color: black;
    }

    div.dt-processing>div:last-child>div {
        background: black !important;
    }
</style>
<div class="card mt-3">
    <div class="card-header ">
        <div class="card-title fw-3">
            <h5 class="d-inline">STUDENTS</h5>
            <button class="btn btn-sm btn-dark float-end d-inline" data-bs-toggle="modal"
                data-bs-target="#studentModal">Add</button>
        </div>

    </div>
    <div class="card-body">
        <div class="table-responsive w-100">
            <table id="sample" class="table table-bordered w-100">
                <thead>
                    <tr>     
                        <th>ID</th>                        
                        <th>NAME</th>
                        <th>SUBJECT</th>
                        <th>MARK</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<?php include ('modal.php') ?>

<?php $this->endSection() ?>

<?php $this->section('scripts') ?>

<script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.css">
<script src="https://markcell.github.io/jquery-tabledit/assets/js/tabledit.min.js"></script>

<script>
    var dataTable = $('#sample').DataTable({
        processing: true,
        serverSide: true,
        order: [],
        ajax: {
            url: "<?= route_to('student.list') ?>",
            type: "GET",
        },        
    });

    $('#sample').on('draw.dt', function () {

        $('#sample').Tabledit({
            url: '<?= route_to('student.action') ?>',
            data: { "<?= csrf_token() ?>": "<?= csrf_hash() ?>" },
            method: "GET",
            dataType: 'json',
            columns: {
                identifier: [0, 'id'],
                editable: [[1, 'name'], [2, 'subject'], [3, 'mark']]
            },
            hideIdentifier: true,
            groupClass: 'btn-group btn-group-sm mb-1',
            buttons: {
                edit: {
                    class: 'btn btn-sm btn-light',
                    html: '<span><i class="bi bi-pencil-square"></i></span>',
                    action: 'edit'
                },
                delete: {
                    class: 'btn btn-sm btn-light',
                    html: '<span><i class="bi bi-trash"></i></span>',
                    action: 'delete'
                },
                save: {
                    class: 'btn btn-sm btn-success w-100',
                    html: 'Update'
                },
                restore: {
                    class: 'btn btn-sm btn-warning w-100',
                    html: 'Restore',
                    action: 'restore'
                },
                confirm: {
                    class: 'btn btn-sm btn-danger w-100',
                    html: 'Confirm'
                }
            },
            restoreButton: false,
            onSuccess: function (data, textStatus, jqXHR) {
                if (data.action == 'delete') {
                    $('#' + data.id).remove();
                    dataTable.ajax.reload(null, false);
                    toastr.success('Student deleted successfully.');
                }
                if (data.action == 'edit') {
                    dataTable.ajax.reload(null, false);
                    toastr.success('Student updated successfully.');
                }
            },
            onFail: function (jqXHR, textStatus, errorThrown) {
                console.log('Error: (' + textStatus + ') ' + errorThrown);
                console.log(jqXHR);
            },
            onAjax: function (action, serialize) {
                // open your xhr here 
                console.log("action : ", action);
                console.log("data : ", serialize);

            }
        });
    });

    $('#student_add_form').on('submit', function (e) {
        e.preventDefault();

        let csrfName = $('.ci-csrf').attr('name');
        let csrfToken = $('.ci-csrf').val();
        let form = this;
        let formData = new FormData(form);
        formData.append(csrfName, csrfToken);

        $.ajax({
            url: $(form).attr('action'),
            method: $(form).attr('method'),
            data: formData,
            dataType: 'json',
            processData: false,
            contentType: false,
            beforeSend: function () {
                toastr.remove();
                $(form).find('input.is-invalid').removeClass('is-invalid');
                $('#add_student').html(`<span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
                                        <span role="status">Saving...</span>`).attr('disabled', true);
            },
            success: function (response) {
                $('.ci-csrf').val(response.token);
                $('#add_student').text('Save').attr('disabled', false);

                if (!$.isEmptyObject(response.errors)) {
                    $.each(response.errors, function (prefix, value) {
                        $('#' + prefix).addClass('is-invalid');
                        $('.' + prefix + '_error').text(value);
                    });
                }

                if (response.status == true) {
                    toastr.success(response.message);
                    $(form)[0].reset();
                    $('#studentModal').modal('hide');
                    dataTable.ajax.reload(null, false);
                }
            }
        });

    });

    $('body').on('keypress keyup', function (e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            return false;
        }
    });
</script>
<?php $this->endSection() ?>