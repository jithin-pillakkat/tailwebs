<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Jithin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css"
        integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center align-items-center vh-100">
            <div class="col-md-5">
                <div class="card px-3 shadow">
                    <div class="card-body">
                        <form action="<?= route_to('login.handler') ?>" method="POST" id="login_form"
                            autocomplete="off">
                            <input type="hidden" name="<?= csrf_token()?>" value="<?= csrf_hash()?>" class="ci-csrf">
                            <div class="text-center mb-5 mt-2">
                                <h2>Login</h2>
                            </div>
                            <?php if(session()->has('error')): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?= session()->get('error') ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                            <?php endif ?>
                            <div class="mb-4">
                                <label for="username" class="form-label">Username</label>
                                <div class="input-group has-validation">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <input type="text" class="form-control" name="username" id="username">
                                    <div class="invalid-feedback username_error"></div>
                                </div>

                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group has-validation">
                                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                    <input type="password" class="form-control" name="password" id="password">
                                    <div class="invalid-feedback password_error"></div>
                                </div>
                            </div>

                            <div class="text-center mt-5">
                                <button type="submit" class="btn btn-dark" id="login">Login</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
        integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $('#login_form').on('submit', function (e) {
            e.preventDefault();
            let form = this;
            let csrfName = $('.ci-csrf').attr('name');
            let csrfToken = $('.ci-csrf').val();
            let formData = new FormData(form);
                formData.append(csrfName, csrfToken);

            $.ajax({
                url: $('#login_form').attr('action'),
                method: $('#login_form').attr('method'),
                data: formData,
                dataType: 'json',
                processData: false,
                contentType: false,
                beforeSend: function () {
                    $(form).find('input.form-control').removeClass('is-invalid');
                    $(form).find('div.invalid-feedback').text(' ');

                    $('#login').html(`<span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
                                        <span role="status">Loading...</span>`).attr('disabled', true);
                },
                success: function (response) {
                    $('#login').text('Login').attr('disabled', false);
                    $('.ci-csrf').val(response.token);
                    if (response.status == true) {
                        window.location.href = "<?= route_to('student.index') ?>";
                    }

                    if (!$.isEmptyObject(response.errors)) {

                        $.each(response.errors, function (prefix, value) {
                            $('#' + prefix).addClass('is-invalid');
                            $('.' + prefix + '_error').text(value);
                        });
                    }

                    if (response.status == false) {
                        toastr.error(response.message);
                    }
                }
            })

        })
    </script>

</body>

</html>