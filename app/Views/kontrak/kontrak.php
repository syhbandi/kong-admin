<?= $this->extend('layouts/index') ?>
<?= $this->section('content') ?>
<div class="card card-primary card-outline card-outline-tabs">
  <div class="card-header p-0 border-bottom-0">
    <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
      <li class="nav-item text-dark">
        <a class="nav-link active text-dark" id="tab-baru" data-toggle="pill" href="#aktif" role="tab" aria-controls="aktif" aria-selected="true"><i class="fas fa-power-off mr-1 text-success"></i> Sudah Validais </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-dark" id="tab-nonaktif" data-toggle="pill" href="#nonaktif" role="tab" aria-controls="aktif" aria-selected="false"><i class="fas fa-power-off mr-1 text-danger"></i> Non Validasi </a>
      </li>
    </ul>
  </div>
  <div class="card-body">
    <div class="tab-content" id="custom-tabs-four-tabContent">
      <!-- tab Barang baru -->
      <div class="tab-pane fade show active" id="aktif" role="tabpanel" aria-labelledby="tab-baru">
        <table id="verif" class="table table-bordered table-hover table-striped w-100">
          <thead class="align-middle text-center">
            <tr>
              <th>No</th>
              <th>Nama Usaha Sumber</th>
              <th>Nama Usaha Tujuan</th>
              <th>Tgl Request</th>
              <th>Tgl Response</th>
              <th>Tgl Kontrak</th>
              <th>Priode Kontrak</th>
              <th>Status</th>
              <th>Detail</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
      <!-- tab Barang Belum Verivikasi -->
      <div class="tab-pane fade" id="nonaktif" role="tabpanel" aria-labelledby="tab-nonaktif">
        <table id="nonverif" class="table table-bordered table-hover table-striped w-100">
          <thead class="align-middle text-center">
            <tr>
              <th>No</th>
              <th>Nama Usaha Sumber</th>
              <th>Nama Usaha Tujuan</th>
              <th>Tgl Request</th>
              <th>Tgl Response</th>
              <th>Tgl Kontrak</th>
              <th>Priode Kontrak</th>
              <th>Status</th>
              <th>Detail</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
  <!-- /.card -->
</div>

<script>
  $(function() {
    $('#verif').DataTable({
      "processing": true,
      "serverSide": true,
      "responsive": true,
      "order": [],
      "ajax": {
        "url": `<?= base_url() ?>getkontrak/aktif`,
        "type": "POST",
        'data': {}
      },
      "columnDefs": [{
          "targets": [0, 1, 4, 5, 7, 8],
          "className": "text-center",
        },
        {
          "targets": [6],
          "className": "text-body-right"
        }
      ],
    });

    $('#nonverif').DataTable({
      processing: true,
      serverSide: true,
      responsive: true,
      order: [],
      "ajax": {
        "url": `<?= base_url() ?>getkontrak/nonaktif`,
        "type": "POST",
        'data': {}
      },
      "columnDefs": [{
          "targets": [0, 1, 4, 5, 7, 8],
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
<!-- <script>
  $(function() {
    $('#verif').DataTable({
      "processing": true,
      "serverSide": true,
      "responsive": true,
      "order": [],
      "ajax": {
        "url": `<?= base_url() ?>getkontrak/aktif`,
        "type": "POST",
        'data': {}
      },
      "columnDefs": [{
          "targets": [0, 1, 2, 3, 4, 5, 6, 7, 8],
          "className": "text-center",
        },
        {
          "targets": [6],
          "className": "text-body-right"
        }
      ],
    });

    $('#nonverif').DataTable({
      processing: true,
      serverSide: true,
      responsive: true,
      order: [],
      "ajax": {
        "url": `<?= base_url() ?>getkontrak/nonktif`,
        "type": "POST",
        'data': {}
      },
      "columnDefs": [{
          "targets": [0, 1, 2, 3, 4, 5, 6, 7, 8],
          "className": "text-center",
        },
        {
          "targets": [6],
          "className": "text-body-right"
        }
      ],
    });
  });
</script> -->
<?= $this->endSection() ?>