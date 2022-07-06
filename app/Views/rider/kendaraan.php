<?= $this->extend('layouts/index') ?>
<?= $this->section('content') ?>
<div class="card card-primary card-outline card-outline-tabs">
  <div class="card-header p-0 border-bottom-0">
    <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
      <li class="nav-item text-dark">
        <a class="nav-link active text-dark" id="tab-baru" data-toggle="pill" href="#baru" role="tab" aria-controls="baru" aria-selected="true"><i class="fas fa-plus-circle mr-1 text-info"></i> Baru</a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-dark" id="tab-aktif" data-toggle="pill" href="#aktif" role="tab" aria-controls="aktif" aria-selected="false"><i class="fas fa-power-off mr-1 text-success"></i> Aktif</a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-dark" id="tab-nonaktif" data-toggle="pill" href="#nonaktif" role="tab" aria-controls="nonaktif" aria-selected="false"><i class="fas fa-power-off mr-1 text-danger"></i> Nonaktif</a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-dark" id="tab-banned" data-toggle="pill" href="#banned" role="tab" aria-controls="banned" aria-selected="false"><i class="fas fa-ban mr-1 text-danger"></i> Banned</a>
      </li>
    </ul>
  </div>
  <div class="card-body">
    <div class="tab-content" id="custom-tabs-four-tabContent">
      <!-- tab rider baru -->
      <div class="tab-pane fade show active" id="baru" role="tabpanel" aria-labelledby="tab-baru">
        <table id="riderBaru" class="table table-bordered table-hover table-striped w-100">
          <thead class="align-middle text-center">
            <tr>
            <th>No</th>
              <th>No.Plat</th>
              <th>Merk</th>
              <th>Model Kendaraan</th>
              <th>Nama Driver</th>
              <th>Tahun Pembuatan</th>
              <th>Status</th>
              <th>Detail</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
      <!-- tab rider aktif -->
      <div class="tab-pane fade" id="aktif" role="tabpanel" aria-labelledby="tab-aktif">
        <table id="rider-aktif" class="table table-bordered table-hover table-striped w-100">
          <thead class="align-middle text-center">
            <tr>
            <th>No</th>
              <th>No.Plat</th>
              <th>Merk</th>
              <th>Model Kendaraan</th>
              <th>Nama Driver</th>
              <th>Tahun Pembuatan</th>
              <th>Status</th>
              <th>Detail</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
      <!-- tab rider nonaktif -->
      <div class="tab-pane fade" id="nonaktif" role="tabpanel" aria-labelledby="tab-nonaktif">
        <table id="riderNonaktif" class="table table-bordered table-hover table-striped w-100">
          <thead class="align-middle text-center">
            <tr>
            <th>No</th>
              <th>No.Plat</th>
              <th>Merk</th>
              <th>Model Kendaraan</th>
              <th>Nama Driver</th>
              <th>Tahun Pembuatan</th>
              <th>Status</th>
              <th>Detail</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
      <!-- tab rider banned -->
      <div class="tab-pane fade" id="banned" role="tabpanel" aria-labelledby="tab-banned">
        <table id="riderBanned" class="table table-bordered table-hover table-striped w-100">
          <thead class="align-middle text-center">
            <tr>
            <th>No</th>
              <th>No.Plat</th>
              <th>Merk</th>
              <th>Model Kendaraan</th>
              <th>Nama Driver</th>
              <th>Tahun Pembuatan</th>
              <th>Status</th>
              <th>Detail</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <!-- /.card -->
</div>

<script>
  $(function() {
    $('#riderBaru').DataTable({
      "processing": true,
      "serverSide": true,
      "responsive": true,
      "order": [],
      "ajax": {
        "url": `<?= base_url() ?>/rider/getKendaraan/baru`,
        "type": "POST",
        'data': {}
      },
      "columnDefs": [{
          "targets": [0, 1, 4, 5, 7],
          "className": "text-center",
        },
        {
          "targets": [6],
          "className": "text-body-right"
        }
      ],
    });

    $('#rider-aktif').DataTable({
      processing: true,
      serverSide: true,
      responsive: true,
      order: [],
      "ajax": {
        "url": `<?= base_url() ?>/rider/getKendaraan/aktif`,
        "type": "POST",
        'data': {}
      },
      "columnDefs": [{
          "targets": [0, 1, 4, 5, 7],
          "className": "text-center",
        },
        {
          "targets": [6],
          "className": "text-body-right"
        }
      ],
    });
    $('#riderNonaktif').DataTable({
      processing: true,
      serverSide: true,
      responsive: true,
      order: [],
      "ajax": {
        "url": `<?= base_url() ?>/rider/getKendaraan/nonaktif`,
        "type": "POST",
        'data': {}
      },
      "columnDefs": [{
          "targets": [0, 1, 4, 5, 7],
          "className": "text-center",
        },
        {
          "targets": [6],
          "className": "text-body-right"
        }
      ],
    });
    $('#riderBanned').DataTable({
      processing: true,
      serverSide: true,
      responsive: true,
      order: [],
      "ajax": {
        "url": `<?= base_url() ?>/rider/getKendaraan/banned`,
        "type": "POST",
        'data': {}
      },
      "columnDefs": [{
          "targets": [0, 1, 4, 5, 7],
          "className": "text-center",
        },
        {
          "targets": [6],
          "className": "text-body-right"
        }
      ],
    });



    // $('table').on('click', '.verifikasi', function(e) {
    //   const kd_driver = $(this).data('driver')
    //   console.log(kd_driver)
    //   Swal.fire({
    //     title: 'Verifikasi Rider?',
    //     text: "Pastikan sudah cek kelengkapan Rider",
    //     icon: 'warning',
    //     showCancelButton: true,
    //     confirmButtonColor: '#3085d6',
    //     cancelButtonColor: '#d33',
    //     confirmButtonText: 'Verifikasi',
    //     cancelButtonText: 'Batal'
    //   }).then((result) => {
    //     if (result.isConfirmed) {
    //       $.ajax({
    //         url: '<?= base_url('rider/verifikasi') ?>',
    //         type: 'POST',
    //         data: {
    //           kd_driver
    //         },
    //         dataType: 'json',
    //         // contentType: false,
    //         // processData: false,
    //         success: function(res) {
    //           if (res.success) {
    //             location.href = res.redirect
    //           } else {
    //             Swal.fire({
    //               title: 'Oops..',
    //               text: res.msg,
    //               icon: 'error',
    //             })
    //           }
    //         },
    //         error: function(e) {
    //           console.log(e.response)
    //         }
    //       })
    //     }
    //   })
    // })

  });
</script>
<?= $this->endSection() ?>