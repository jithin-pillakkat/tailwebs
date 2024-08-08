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
<style>
    .form-control:focus {
        border-color: black;
        outline: 0;
        box-shadow: none;
    }

    .form-select:focus {
        border-color: black;
        outline: 0;
        box-shadow: none;
    }
</style>

<body>

    <nav class="navbar bg-body-tertiary sticky-top">
        <div class="container">
            <a class="navbar-brand text-danger fw-bold">Tailwebs</a>
            <div class="d-flex">
                <a class="btn btn-sm btn-outline-dark me-2 <?= '/' . uri_string() == route_to('normal.table') ? 'active' : '' ?>"
                    href="<?= route_to('normal.table') ?>">Normal Table</a>
                <a class="btn btn-sm btn-outline-dark me-2 <?= '/' . uri_string() == route_to('student.index') ? 'active' : '' ?>"
                    href="<?= route_to('student.index') ?>">Data Table</a>
                <button class="btn btn-sm btn-outline-dark" type="button" id="logout">Logout</button>
            </div>
        </div>
    </nav>

    <div class="container">

        <?php $this->renderSection('content') ?>

    </div>




    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
        integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <?php $this->renderSection('scripts') ?>

    <script>
        $('#logout').on('click', function (e) {
            e.preventDefault();

            Swal.fire({
                title: "Are you sure?",
                text: "Do you want to logout!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "<?= route_to('logout') ?>";
                }
            });
        })
    </script>

</body>

</html>