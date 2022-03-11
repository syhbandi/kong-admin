<?= $this->extend('layouts/index'); ?>
<?= $this->section('content') ?>
<div class="card card-outline card-outline-tab">
  <div class="card-header border-bottom-0 p-0">
    <ul class="nav nav-tabs" role="tablist">
      <li class="nav-items ">
        <a class="nav-link text-dark active" id="belum-verifikasi" data-toggle="pill" href="#belum-verifikasi-content" role="tab" aria-controls="belum-verifikasi-content" aria-selected="true"><i class="fas fa-check-circle text-info mr-1"></i> Belum Verifikasi</a>
      </li>
      <li class="nav-items ">
        <a class="nav-link text-dark" id="riwayat" data-toggle="pill" href="#riwayat-content" role="tab" aria-controls="riwayat-content" aria-selected="false"><i class="fas fa-history mr-1 text-purple"></i> Riwayat</a>
      </li>
    </ul>
  </div>

  <div class="card-body">
    <div class="tab-content">
      <div class="tab-pane fade show active" id="belum-verifikasi-content" role="tabpanel" aria-labelledby="belum-verifikasi">
        <table id="topUp" class="table table-bordered table-hover table-striped w-100">
          <thead class="align-middle text-center">
            <tr>
              <th>No</th>
              <th>Nama</th>
              <th>No. Rekening</th>
              <th>Nominal</th>
              <th>Bank</th>
              <th>Tanggal</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>

      <div class="tab-pane fade" id="riwayat-content" role="tabpanel" aria-labelledby="riwayat">
        <table id="riwayat-top-up" class="table table-bordered table-hover table-striped w-100">
          <thead class="align-middle text-center">
            <tr>
              <th>No</th>
              <th>Nama</th>
              <th>No. Rekening</th>
              <th>Nominal</th>
              <th>Bank</th>
              <th>Tanggal</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<script>
  $(function() {
    $('#topUp').DataTable({
      "processing": true,
      "serverSide": true,
      "responsive": true,
      "order": [],
      "ajax": {
        "url": `<?= base_url() ?>/rider/getTopUp/2/0`,
        "type": "POST",
        'data': {}
      },
      "columnDefs": [{
          "targets": [0, 2, 4, 5, 6, 7],
          "className": "text-center",
        },
        {
          targets: [3],
          className: 'text-body-right'
        }
      ],
    });
    $('#riwayat-top-up').DataTable({
      "processing": true,
      "serverSide": true,
      "responsive": true,
      "order": [],
      "ajax": {
        "url": `<?= base_url() ?>/rider/getTopUp/2`,
        "type": "POST",
        'data': {}
      },
      "columnDefs": [{
          "targets": [0, 2, 4, 5, 6, 7],
          "className": "text-center",
        },
        {
          targets: [3],
          className: 'text-body-right'
        }
      ],
    });
  })
</script>
<?= $this->EndSection() ?>