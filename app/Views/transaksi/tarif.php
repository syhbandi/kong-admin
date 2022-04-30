<?= $this->extend('layouts/index') ?>
<?= $this->section('content') ?>
<div class="card card-primary card-outline card-outline-tabs">
  <div class="card-header p-0 border-bottom-0">
    <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
      <li class="nav-item text-dark">
        <a class="nav-link active text-dark" id="tab-baru" data-toggle="pill" href="#baru" role="tab" aria-controls="aktif" aria-selected="true"><i class="fas fa-paste mr-1 text-info"></i> Data Tarif</a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-dark" id="tab-verif" data-toggle="pill" href="#verif" role="tab" aria-controls="aktif" aria-selected="false"><i class="fas fa-plus mr-1 text-success"></i> Add Tarif</a>
      </li>
    </ul>
  </div>
  <div class="card-body">
    <div class="tab-content" id="custom-tabs-four-tabContent">
        <!-- add Menu -->
        <div class="tab-pane fade show active" id="baru" role="tabpanel" aria-labelledby="tab-baru">
            
        </div>
        <!-- tab Barang baru -->
      <div class="tab-pane fade show active" id="baru" role="tabpanel" aria-labelledby="tab-baru">
        <table id="tarif" class="table table-bordered table-hover table-striped w-100">
          <thead class="align-middle text-center">
            <tr>
              <th>No</th>
              <th>Lokasi</th>
              <th>Batas Bawah</th>
              <th>Batas Atas</th>
              <th>fee minim bawah</th>
              <th>fee minim atas</th>
              <th>Jarak Pertama</th>
              <th>Deskripsi</th>
              <th>Kendaraan</th>
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
    $('#tarif').DataTable({
      "processing": true,
      "serverSide": true,
      "responsive": true,
      "order": [],
      "ajax": {
        "url": `<?= base_url() ?>/TransaksiController/tarif`,
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