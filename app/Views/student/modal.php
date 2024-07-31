<!-- Modal -->
<div class="modal fade" id="studentModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="studentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h1 class="modal-title fs-5" id="studentModalLabel">Add Student</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= route_to('student.save') ?>" method="POST" id="student_add_form" autocomplete="off">
                    <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" class="ci-csrf">
                    <div class="mb-4">
                        <label for="name" class="form-label">Name</label>
                        <div class="input-group has-validation">
                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                            <input type="text" class="form-control" name="name" id="name">
                            <div class="invalid-feedback name_error"></div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="subject" class="form-label">Subject</label>
                        <div class="input-group has-validation">
                            <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                            <input type="text" class="form-control" name="subject" id="subject">
                            <div class="invalid-feedback subject_error"></div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="mark" class="form-label">Mark</label>
                        <div class="input-group has-validation">
                            <span class="input-group-text"><i class="bi bi-bookmark"></i></span>
                            <input type="text" class="form-control" name="mark" id="mark">
                            <div class="invalid-feedback mark_error"></div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-dark" id="add_student">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>