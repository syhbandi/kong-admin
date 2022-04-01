<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>KONG Admin | <?= $title ?? 'Dashboard' ?></title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback" />
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= base_url() ?>/assets/plugins/fontawesome-free/css/all.min.css" />
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" />
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="<?= base_url() ?>/assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css" />
  <!-- iCheck -->
  <link rel="stylesheet" href="<?= base_url() ?>/assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css" />
  <!-- JQVMap -->
  <link rel="stylesheet" href="<?= base_url() ?>/assets/plugins/jqvmap/jqvmap.min.css" />
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url() ?>/assets/dist/css/adminlte.min.css" />
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="<?= base_url() ?>/assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css" />
  <!-- Daterange picker -->
  <!-- <link rel="stylesheet" href="<?= base_url() ?>/assets/plugins/daterangepicker/daterangepicker.css" /> -->
  <!-- summernote -->
  <!-- <link rel="stylesheet" href="<?= base_url() ?>/assets/plugins/summernote/summernote-bs4.min.css" /> -->

  <link rel="stylesheet" href="<?= base_url() ?>/assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>/assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

  <link rel="stylesheet" href="<?= base_url() ?>/assets/plugins/sweetalert2/sweetalert2.min.css">
  <!-- <link rel="stylesheet" href="<?= base_url() ?>/assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css"> -->


  <!-- jQuery -->
  <script src="<?= base_url() ?>/assets/plugins/jquery/jquery.min.js"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="<?= base_url() ?>/assets/plugins/jquery-ui/jquery-ui.min.js"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge("uibutton", $.ui.button);
  </script>
  <!-- Bootstrap 4 -->
  <script src="<?= base_url() ?>/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?= base_url() ?>/assets/dist/js/adminlte.js"></script>

  <script src="<?= base_url() ?>/assets/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="<?= base_url() ?>/assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="<?= base_url() ?>/assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="<?= base_url() ?>/assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

  <script src="<?= base_url() ?>/assets/plugins/sweetalert2/sweetalert2.min.js"></script>

  <style>
    th.text-body-right {
      text-align: inherit;
    }

    td.text-body-right {
      text-align: right;
    }

    .img-thumbnail {
      max-width: 200px;
      height: auto;
      cursor: pointer;
      margin: 5px;
    }
  </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
      <img class="animation__shake" src="<?= base_url() ?>/assets/dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60" />
    </div>

    <!-- Navbar -->
    <?= $this->include('layouts/navbar') ?>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <?= $this->include('layouts/sidebar'); ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Dashboard</h1>
              <ol class="breadcrumb float-sm-left">
                <li class="breadcrumb-item active"><?= (!empty($pos['version app'])) ? "App Version (". $pos['version app'] . ")": " " ?></li>
                <?= (!empty($pos['version app'])) ? "<li class='breadcrumb-item active'><a href='".$pos['id version']."' data-toggle='modal' data-target='#exampleModal".$pos['id version']."'>Edit</a> </li>": " " ?>
              </ol>
              <!-- <button class="btn btn-sm btn-warning" id="tesToast">Toast</button> -->
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Dashboard v1</li>
              </ol>
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->
      <!-- Modal -->
<?= (!empty($pos['version app'])) ? "
<form class='form-control-sm' action='".base_url('pos/updatever')."' method='POST'>
<div class='modal fade' id='exampleModal".$pos['id version']."' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
  <div class='modal-dialog' role='document'>
    <div class='modal-content'>
      <div class='modal-header'>
        <h5 class='modal-title' id='exampleModalLabel'>Edit Version</h5>
        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
          <span aria-hidden='true'>&times;</span>
        </button>
      </div>
      <div class='modal-body'>
        <input class='form-control form-control-sm' type='text' name='version' value='".$pos['version app']."' >
      </div>
      <div class='modal-footer'>
        <input type='hidden' name='id' value='".$pos['id version']."'>
        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
        <button type='submit' class='btn btn-primary' >Update</button>
      </div>
    </div>
  </div>
</div>
</form>": " " ?>
      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <?= $this->renderSection('content') ?>
        </div>
        <!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- footer -->
    <?= $this->include('layouts/footer') ?>
    <!-- /.footer -->
  </div>
  <!-- ./wrapper -->

  <?php if (service('uri')->getPath() == '/') : ?>
    <!-- ChartJS -->
    <!-- <script src="<?= base_url() ?>/assets/plugins/chart.js/Chart.min.js"></script> -->
    <!-- Sparkline -->
    <!-- <script src="<?= base_url() ?>/assets/plugins/sparklines/sparkline.js"></script> -->
    <!-- JQVMap -->
    <!-- <script src="<?= base_url() ?>/assets/plugins/jqvmap/jquery.vmap.min.js"></script> -->
    <!-- <script src="<?= base_url() ?>/assets/plugins/jqvmap/maps/jquery.vmap.usa.js"></script> -->
    <!-- jQuery Knob Chart -->
    <!-- <script src="<?= base_url() ?>/assets/plugins/jquery-knob/jquery.knob.min.js"></script> -->
    <!-- daterangepicker -->
    <!-- <script src="<?= base_url() ?>/assets/plugins/moment/moment.min.js"></script> -->
    <!-- <script src="<?= base_url() ?>/assets/plugins/daterangepicker/daterangepicker.js"></script> -->
    <!-- Tempusdominus Bootstrap 4 -->
    <!-- <script src="<?= base_url() ?>/assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script> -->
    <!-- Summernote -->
    <!-- <script src="<?= base_url() ?>/assets/plugins/summernote/summernote-bs4.min.js"></script> -->
    <!-- overlayScrollbars -->
    <!-- <script src="<?= base_url() ?>/assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script> -->
    <!-- AdminLTE App -->
    <!-- AdminLTE for demo purposes -->
    <!-- <script src="<?= base_url() ?>/assets/dist/js/demo.js"></script> -->
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <!-- <script src="<?= base_url() ?>/assets/dist/js/pages/dashboard.js"></script> -->
  <?php endif ?>
    
  <script>
    $(function() {
      const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 5000,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer)
          toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
      })

      <?php if (session()->getFlashdata('sukses') != '') : ?>
        Toast.fire({
          icon: 'success',
          title: '<?= session()->getFlashdata('sukses') ?>'
        })
      <?php endif ?>

      <?php if (session()->getFlashdata('error') != '') : ?>
        Toast.fire({
          icon: 'error',
          title: '<?= session()->getFlashdata('error') ?>'
        })
      <?php endif ?>

      // $('#tesToast').on('click', function(e) {
      //   Toast.fire({
      //     icon: 'success',
      //     title: 'tes teks panjang di toasts dan lebih panjang lagi sampai ke langit'
      //   })
      // })
    })
  </script>
</body>

</html>