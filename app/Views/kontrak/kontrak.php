<?= $this->extend('layouts/index') ?>
<?= $this->section('content') ?>
<div class="card card-primary card-outline card-outline-tabs">
  <div class="card-header p-0 border-bottom-0">
    <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
      <li class="nav-item text-dark">
        <a class="nav-link active text-dark" id="tab-baru" data-toggle="pill" href="#baru" role="tab" aria-controls="aktif" aria-selected="true"><i class="fas fa-power-off mr-1 text-success"></i> Sudah Validais </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-dark" id="tab-verif" data-toggle="pill" href="#verif" role="tab" aria-controls="aktif" aria-selected="false"><i class="fas fa-power-off mr-1 text-danger"></i> Non Validasi </a>
      </li>
    </ul>
  </div>
  <div class="card-body">
    <div class="tab-content" id="custom-tabs-four-tabContent">
      <!-- tab Barang baru -->
      <div class="tab-pane fade show active" id="baru" role="tabpanel" aria-labelledby="tab-baru">
        <table id="barangBaru" class="table table-bordered table-hover table-striped w-100">
          <thead class="align-middle text-center">
            <tr>
              <th>No</th>
              <th>Kode Barang</th>
              <th>Nama Barang</th>
              <th>Kategori</th>
              <th>Merk</th>
              <th>Nama Toko</th>
              <th>Date Add</th>
              <th>Date Modif</th>
              <th>Detail</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
      <!-- tab Barang aktif -->
      <div class="tab-pane fade" id="aktif" role="tabpanel" aria-labelledby="tab-aktif">
        <table id="barangaktif" class="table table-bordered table-hover table-striped w-100">
          <thead class="align-middle text-center">
          <tr>
              <th>No</th>
              <th>Kode Barang</th>
              <th>Nama Barang</th>
              <th>Kategori</th>
              <th>Merk</th>
              <th>Nama Toko</th>
              <th>Date Add</th>
              <th>Date Modif</th>
              <th>Detail</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
      <!-- tab Barang Belum Verivikasi -->
      <div class="tab-pane fade" id="verif" role="tabpanel" aria-labelledby="tab-verif">
        <table id="barang-verif" class="table table-bordered table-hover table-striped w-100">
          <thead class="align-middle text-center">
          <tr>
              <th>No</th>
              <th>Kode Barang</th>
              <th>Nama Barang</th>
              <th>Kategori</th>
              <th>Merk</th>
              <th>Nama Toko</th>
              <th>Date Add</th>
              <th>Date Modif</th>
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
  // $(function() {
  //   $('#barangBaru').DataTable({
  //     "processing": true,
  //     "serverSide": true,
  //     "responsive": true,
  //     "order": [],
  //     "ajax": {
  //       "url": `<?= base_url() ?>/pos/getBarang/nonaktif`,
  //       "type": "POST",
  //       'data': {}
  //     },
  //     "columnDefs": [{
  //         "targets": [0, 1, 4, 5, 7, 8],
  //         "className": "text-center",
  //       },
  //       {
  //         "targets": [6],
  //         "className": "text-body-right"
  //       }
  //     ],
  //   });

  //   $('#barang-verif').DataTable({
  //     processing: true,
  //     serverSide: true,
  //     responsive: true,
  //     order: [],
  //     "ajax": {
  //       "url": `<?= base_url() ?>/pos/getBarang/nonverification`,
  //       "type": "POST",
  //       'data': {}
  //     },
  //     "columnDefs": [{
  //         "targets": [0, 1, 4, 5, 7, 8],
  //         "className": "text-center",
  //       },
  //       {
  //         "targets": [6],
  //         "className": "text-body-right"
  //       }
  //     ],
  //   });

  //   $('#barangaktif').DataTable({
  //     processing: true,
  //     serverSide: true,
  //     responsive: true,
  //     order: [],
  //     "ajax": {
  //       "url": `<?= base_url() ?>/pos/getBarang/aktif`,
  //       "type": "POST",
  //       'data': {}
  //     },
  //     "columnDefs": [{
  //         "targets": [0, 1, 4, 5, 7, 8],
  //         "className": "text-center",
  //       },
  //       {
  //         "targets": [6],
  //         "className": "text-body-right"
  //       }
  //     ],
  //   });
  // });
</script>
<?= $this->endSection() ?>