<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>KONG Admin | Login</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= base_url() ?>/assets/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?= base_url() ?>/assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url() ?>/assets/dist/css/adminlte.min.css">

  <link rel="stylesheet" href="<?= base_url() ?>/assets/plugins/sweetalert2/sweetalert2.min.css">
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="alert alert-danger d-none align-items-center">
      <div id="icon" class="mr-3">
        <i class="fas fa-exclamation-circle"></i>
      </div>
      <div id="msg" class="flex-grow-1">
        <h5>Login gagal!</h5>
        <span class="msg"></span>
      </div>

    </div>
    <!-- /.login-logo -->
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <a href="<?= base_url() ?>" class="h1">KONG Admin</a>
      </div>
      <div class="card-body">
        <p class="login-box-msg">Masuk untuk menggunakan aplikasi</p>

        <form action="<?= base_url('auth/login') ?>" method="post">
          <div class="input-group mb-3">
            <input type="email" class="form-control" placeholder="Email" name="email">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" placeholder="Password" name="password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="d-flex flex-column">
            <button type="submit" class="btn btn-primary btn-block">Masuk</button>
            <a href="#" class="text-danger mx-auto mt-3">Lupa password?</a>
            <!-- <div class="icheck-primary text-center">
              <input type="checkbox" id="remember">
              <label for="remember">
                Ingat saya
              </label>
            </div> -->
            <!-- /.col -->
            <!-- /.col -->
          </div>
        </form>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.login-box -->

  <!-- jQuery -->
  <script src="<?= base_url() ?>/assets/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="<?= base_url() ?>/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="<?= base_url() ?>/assets/dist/js/adminlte.min.js"></script>

  <script src="<?= base_url() ?>/assets/plugins/sweetalert2/sweetalert2.min.js"></script>

  <script>
    $(function() {
      $('form').on('submit', function(e) {
        e.preventDefault()
        $('button[type=submit]').html(`<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span> sedang proses`).prop('disabled', true);
        const formData = new FormData($(this)[0])


        $.ajax({
          url: $(this).attr('action'),
          type: 'POST',
          data: formData,
          dataType: 'JSON',
          contentType: false,
          processData: false,
          success: function(res) {
            if (res.success) {
              location.href = res.redirect
            } else {
              $('.alert').removeClass('d-none').addClass('d-flex').find('.msg').html(res.msg)
              $('button[type=submit]').html(`Masuk`).prop('disabled', false);
              $('form').find('input').val('')
            }




          },
          error: function(res) {
            console.log(res.response)
          }
        })
      })
    })
  </script>
</body>

</html>