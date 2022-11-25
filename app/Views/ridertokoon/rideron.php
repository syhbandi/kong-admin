<?= $this->extend('layouts/index') ?>
<?= $this->section('content') ?>

<div class="card card-primary card-outline card-outline-tabs">
  <div class="card-header p-0 border-bottom-0">
    <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
      <li class="nav-item">
        <a class="nav-link text-dark" id="tab-aktif" data-toggle="pill" href="#baru" role="tab" aria-controls="aktif" aria-selected="false"><i class="fas fa-power-off mr-1 text-success"></i> Aktif Berteransaksi</a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-dark" id="tab-vdata" data-toggle="pill" href="#aktif" role="tab" aria-controls="vdata" aria-selected="false"><i class="fas fa-power-off mr-1 text-warning"></i> Tidak Aktif Berteransaksi</a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-dark" id="tab-vatribut" data-toggle="pill" href="#banned" role="tab" aria-controls="vatribut" aria-selected="false"><i class="fas fa-power-off mr-1 text-danger"></i> Offline</a>
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
              <th>Nama</th>
              <th>Alamat</th>
              <th>WhatsApp</th>
              <th>Terakhir Online</th>
              <th>Status</th>
              <th>Jumlah Transaksi</th>
              <th>Chat Rider</th>
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
              <th>Nama</th>
              <th>Alamat</th>
              <th>WhatsApp</th>
              <th>Terakhir Online</th>
              <th>Status</th>
              <th>Jumlah Transaksi</th>
              <th>Chat Rider</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
      <div class="tab-pane fade" id="banned" role="tabpanel" aria-labelledby="tab-banned">
        <table id="riderBanned" class="table table-bordered table-hover table-striped w-100">
          <thead class="align-middle text-center">
            <tr>
              <th>No</th>
              <th>Nama</th>
              <th>Alamat</th>
              <th>WhatsApp</th>
              <th>Terakhir Online</th>
              <th>Status</th>
              <th>Jumlah Transaksi</th>
              <th>Chat Rider</th>
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
        "url": `<?= base_url() ?>/Ridertokoon/getRider/aktif`,
        "type": "POST",
        'data': {}
      },
      "columnDefs": [{
          "targets": [0, 1, 4, 5, 6, 7],
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
        "url": `<?= base_url() ?>/Ridertokoon/getRider/transaksi`,
        "type": "POST",
        'data': {}
      },
      "columnDefs": [{
          "targets": [0, 1, 4, 5, 6, 7],
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
        "url": `<?= base_url() ?>/Ridertokoon/getRider/offline`,
        "type": "POST",
        'data': {}
      },
      "columnDefs": [{
          "targets": [0, 1, 4, 5, 6, 7],
          "className": "text-center",
        },
        {
          "targets": [6],
          "className": "text-body-right"
        }
      ],
    });
  });
</script>
<?= $this->endSection() ?>