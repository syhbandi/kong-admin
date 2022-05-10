<?= $this->extend('layouts/index') ?>
<?= $this->section('content') ?>
<div class="card card-primary card-outline card-outline-tabs">
  <div class="card-header p-0 border-bottom-0">
    <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
      <li class="nav-item text-dark">
        <a class="nav-link active text-dark" id="tab-baru" data-toggle="pill" href="#baru" role="tab" aria-controls="aktif" aria-selected="true"><i class="fas fa-plus-circle mr-1 text-info"></i> Pengguna Baru</a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-dark" id="tab-aktif" data-toggle="pill" href="#aktif" role="tab" aria-controls="aktif" aria-selected="false"><i class="fas fa-power-off mr-1 text-success"></i> Pengguna Aktif</a>
      </li>
      <li class="nav-item text-dark">
        <a class="nav-link text-dark" id="tab-tab-tutup" data-toggle="pill" href="#tutup" role="tab" aria-controls="aktif" aria-selected="true"><i class="fas fa-ban mr-1 text-warning"></i> Pengguna non Baned</a>
      </li>
      <li class="nav-item text-dark">
        <a class="nav-link text-dark" id="tab-tab-banned" data-toggle="pill" href="#banned" role="tab" aria-controls="aktif" aria-selected="true"><i class="fas fa-ban mr-1 text-danger"></i> Pengguna Banned</a>
      </li>
    </ul>
  </div>
  <div class="card-body">
    <div class="tab-content" id="custom-tabs-four-tabContent">
      <!-- tab Toko baru -->
      <div class="tab-pane fade show active" id="baru" role="tabpanel" aria-labelledby="tab-baru">
        <table id="posBaru" class="table table-bordered table-hover table-striped w-100">
          <thead class="align-middle text-center">
            <tr>
              <th>No</th>
              <th>Nama Usaha</th>
              <th>Kategori Usaha</th>
              <th>No. Hp</th>
              <th>Email</th>
              <th>Nama Pemilik</th>
              <th>Provinsi</th>
              <th>Date Add</th>
              <th>Detail</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
      <!-- tab Toko aktif -->
      <div class="tab-pane fade" id="aktif" role="tabpanel" aria-labelledby="tab-aktif">
        <table id="posaktif" class="table table-bordered table-hover table-striped w-100">
          <thead class="align-middle text-center">
            <tr>
            <th>No</th>
              <th>Nama Usaha</th>
              <th>Kategori Usaha</th>
              <th>No. Hp</th>
              <th>Email</th>
              <th>Nama Pemilik</th>
              <th>Provinsi</th>
              <th>Date Add</th>
              <th>Detail</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
      <!-- tab Toko Tutup -->
      <div class="tab-pane fade" id="tutup" role="tabpanel" aria-labelledby="tab-tutup">
        <table id="postutup" class="table table-bordered table-hover table-striped w-100">
          <thead class="align-middle text-center">
            <tr>
            <th>No</th>
              <th>Nama Usaha</th>
              <th>Kategori Usaha</th>
              <th>No. Hp</th>
              <th>Email</th>
              <th>Nama Pemilik</th>
              <th>Provinsi</th>
              <th>Date Add</th>
              <th>Detail</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
      <!-- tab Toko Banned -->
      <div class="tab-pane fade" id="banned" role="tabpanel" aria-labelledby="tab-banned">
        <table id="posbaned" class="table table-bordered table-hover table-striped w-100">
          <thead class="align-middle text-center">
            <tr>
            <th>No</th>
              <th>Nama Usaha</th>
              <th>Kategori Usaha</th>
              <th>No. Hp</th>
              <th>Email</th>
              <th>Nama Pemilik</th>
              <th>Provinsi</th>
              <th>Date Add</th>
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
    $('#posBaru').DataTable({
      "processing": true,
      "serverSide": true,
      "responsive": true,
      "order": [],
      "ajax": {
        "url": `<?= base_url() ?>/pos/getToko/nonaktif`,
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

    $('#posaktif').DataTable({
      processing: true,
      serverSide: true,
      responsive: true,
      order: [],
      "ajax": {
        "url": `<?= base_url() ?>/pos/getToko/aktif`,
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
    $('#postutup').DataTable({
      processing: true,
      serverSide: true,
      responsive: true,
      order: [],
      "ajax": {
        "url": `<?= base_url() ?>/pos/getToko/tutup`,
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

    $('#posbaned').DataTable({
      "processing": true,
      "serverSide": true,
      "responsive": true,
      "order": [],
      "ajax": {
        "url": `<?= base_url() ?>/pos/getToko/banned`,
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
<?= $this->endSection() ?>