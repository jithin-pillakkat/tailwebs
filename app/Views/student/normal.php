<?php $this->extend('layout/app') ?>

<?php $this->section('content') ?>
<style>
    .pagination {
        --bs-pagination-active-bg: black;
        --bs-pagination-active-border-color: black;
        --bs-pagination-color: black;
    }

    .page-link:focus {
        color: black;
        background-color: var(--bs-pagination-focus-bg);
        outline: 0;
        box-shadow: none;
    }

    .page-link:hover {
        color: black;
    }
</style>
<div class="card mt-3">
    <div class="card-header ">
        <div class="card-title fw-3">
            <h5 class="d-inline">STUDENTS NORMAL TABLE</h5>
            <button class="btn btn-sm btn-dark float-end d-inline" data-bs-toggle="modal"
                data-bs-target="#studentModal">Add</button>
        </div>

    </div>
    <div class="card-body">
        <div class="col-md-3 col-sm-5 float-end mb-2">
            <form action="">
                <input type="text" name="search" class="form-control"
                    value="<?= isset($_GET['search']) ? $_GET['search'] : '' ?>" placeholder="search">
            </form>
        </div>
        <div class="table-responsive w-100">
            <table id="sample" class="table table-bordered w-100">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>NAME</th>
                        <th>SUBJECT</th>
                        <th>MARK</th>
                        <th>ACTION</th>
                    </tr>
                </thead>
                <tbody id="studetData">
                    <?php $i = 1 ?>
                    <?php foreach ($students as $student): ?>
                        <tr id="<?= $student->id ?>">
                            <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>"
                                class="ci-csrf-token editInput">
                            <td><?= $i++ ?></td>
                            <td>
                                <span class="editSpan name"><?= $student->name ?></span>
                                <input class="form-control editInput name" type="text" name="name"
                                    value="<?= $student->name ?>" style="display: none;">
                                <span class="name_error validation text-danger"></span>
                            </td>
                            <td>
                                <span class="editSpan subject"><?= $student->subject ?></span>
                                <input class="form-control editInput subject" type="text" name="subject"
                                    value="<?= $student->subject ?>" style="display: none;">
                                <span class="subject_error validation text-danger"></span>
                            </td>
                            <td>
                                <span class="editSpan marks"><?= $student->mark ?></span>
                                <input class="form-control editInput marks" type="text" name="marks"
                                    value="<?= $student->mark ?>" style="display: none;">
                                <span class="marks_error validation text-danger"></span>
                            </td>
                            <td>
                                <button type="button" class="btn btn-light btn-sm editBtn"><i
                                        class="bi bi-pencil-square"></i></button>
                                <button type="button" class="btn btn-light btn-sm deleteBtn"><i
                                        class="bi bi-trash"></i></button>

                                <button type="button" class="btn btn-success saveBtn" style="display: none;">Save</button>
                                <button type="button" class="btn btn-danger confirmBtn"
                                    style="display: none;">Confirm</button>
                                <button type="button" class="btn btn-secondary cancelBtn"
                                    style="display: none;">Cancel</button>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>

            <?= $pager->only(['search'])->links() ?>

        </div>
    </div>
</div>

<?php include ('modal.php') ?>

<?php $this->endSection() ?>

<?php $this->section('scripts') ?>
<script>
    $(document).ready(function () {
        $('.editBtn').on('click', function () {
            //hide edit span
            $(this).closest("tr").find(".editSpan").hide();

            //show edit input
            $(this).closest("tr").find(".editInput").show();

            //hide edit button
            $(this).closest("tr").find(".editBtn").hide();

            //hide delete button
            $(this).closest("tr").find(".deleteBtn").hide();

            //show save button
            $(this).closest("tr").find(".saveBtn").show();

            //show cancel button
            $(this).closest("tr").find(".cancelBtn").show();

        });

        $('.saveBtn').on('click', function () {
            $('#studetData').css('opacity', '.5');
            var trObj = $(this).closest("tr");
            var ID = $(this).closest("tr").attr('id');
            var inputData = $(this).closest("tr").find(".editInput").serialize();

            $.ajax({
                type: 'POST',
                url: "<?= route_to('normal.table.action') ?>",
                dataType: "json",
                data: 'action=edit&id=' + ID + '&' + inputData,
                beforeSend: function () {
                    $('.validation').text('');
                },
                success: function (response) {
                    $('.ci-csrf-token').val(response.newToken);
                    $('.ci-csrf').val(response.newToken);

                    if (!$.isEmptyObject(response.errors)) {
                        $.each(response.errors, function (prefix, value) {
                            trObj.find("span." + prefix + '_error').text(value);
                        });
                    }

                    if (response.status == true) {

                        trObj.find(".editSpan.name").text(response.data.name);
                        trObj.find(".editSpan.subject").text(response.data.subject);
                        trObj.find(".editSpan.marks").text(response.data.marks);

                        trObj.find(".editInput.name").val(response.data.name);
                        trObj.find(".editInput.subject").val(response.data.subject);
                        trObj.find(".editInput.marks").val(response.data.marks);

                        trObj.find(".editInput").hide();
                        trObj.find(".editSpan").show();
                        trObj.find(".saveBtn").hide();
                        trObj.find(".cancelBtn").hide();
                        trObj.find(".editBtn").show();
                        trObj.find(".deleteBtn").show();

                        toastr.success(response.message);
                    } else {

                    }
                    $('#studetData').css('opacity', '');
                }
            });
        });

        $('.cancelBtn').on('click', function () {
            //hide & show buttons
            $(this).closest("tr").find(".saveBtn").hide();
            $(this).closest("tr").find(".cancelBtn").hide();
            $(this).closest("tr").find(".confirmBtn").hide();
            $(this).closest("tr").find(".editBtn").show();
            $(this).closest("tr").find(".deleteBtn").show();

            //hide input and show values
            $(this).closest("tr").find(".editInput").hide();
            $(this).closest("tr").find(".editSpan").show();
        });

        $('.deleteBtn').on('click', function () {
            //hide edit & delete button
            $(this).closest("tr").find(".editBtn").hide();
            $(this).closest("tr").find(".deleteBtn").hide();

            //show confirm & cancel button
            $(this).closest("tr").find(".confirmBtn").show();
            $(this).closest("tr").find(".cancelBtn").show();
        });

        $('.confirmBtn').on('click', function () {
            $('#studetData').css('opacity', '.5');

            var trObj = $(this).closest("tr");
            var ID = $(this).closest("tr").attr('id');
            $.ajax({
                type: 'POST',
                url: '<?= route_to('normal.table.action') ?>',
                dataType: "json",
                data: 'action=delete&id=' + ID + '&' + trObj.find(".ci-csrf-token").attr('name') + '=' + trObj.find(".ci-csrf-token").val(),
                success: function (response) {
                    $('.ci-csrf-token').val(response.newToken);
                    $('.ci-csrf').val(response.newToken);
                    if (response.status == true) {
                        trObj.remove();
                        toastr.success(response.message);
                    } else {
                        trObj.find(".confirmBtn").hide();
                        trObj.find(".cancelBtn").hide();
                        trObj.find(".editBtn").show();
                        trObj.find(".deleteBtn").show();
                        toastr.error(response.message);
                    }
                    $('#studetData').css('opacity', '');
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
                            $(form).find('#' + prefix).addClass('is-invalid');
                            $(form).find('.' + prefix + '_error').text(value);
                        });
                    }

                    if (response.status == true) {
                        toastr.success(response.message);
                        location.reload();
                    }
                }
            });

        });
    });
</script>
<?php $this->endSection() ?>