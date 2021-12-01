<?= $this->extend('layouts/index') ?>
<?= $this->section('content') ?>
<div class="card card-primary card-outline card-outline-tabs">
  <div class="card-header p-0 border-bottom-0">
    <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
      <li class="nav-item">
        <a class="nav-link active" id="tab-baru" data-toggle="pill" href="#baru" role="tab" aria-controls="baru" aria-selected="true">Baru</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="tab-aktif" data-toggle="pill" href="#aktif" role="tab" aria-controls="aktif" aria-selected="false">Aktif</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="tab-nonaktif" data-toggle="pill" href="#nonaktif" role="tab" aria-controls="nonaktif" aria-selected="false">Nonaktif</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="tab-banned" data-toggle="pill" href="#banned" role="tab" aria-controls="banned" aria-selected="false">Banned</a>
      </li>
    </ul>
  </div>
  <div class="card-body">
    <div class="tab-content" id="custom-tabs-four-tabContent">
      <!-- tab rider baru -->
      <div class="tab-pane fade show active" id="baru" role="tabpanel" aria-labelledby="tab-baru">
        <table id="riderBaru" class="table table-bordered table-hover" style="width:100%">
          <thead class="align-middle text-center">
            <tr>
              <th>No</th>
              <th>Kode Driver</th>
              <th>Nama</th>
              <th>Alamat</th>
              <th>HP Utama</th>
              <th>HP 2</th>
              <th>Email</th>
              <th>No.Ktp</th>
              <th>Zona</th>
              <th>Merk</th>
              <th>Model</th>
              <th>Plat Nomor</th>
              <th>Tahun</th>
              <th>STNK</th>
              <th>Kendaraan</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
      <!-- tab rider aktif -->
      <div class="tab-pane fade" id="aktif" role="tabpanel" aria-labelledby="tab-aktif">
        Mauris tincidunt mi at erat gravida, eget tristique urna bibendum. Mauris pharetra purus ut ligula tempor, et vulputate metus facilisis. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Maecenas sollicitudin, nisi a luctus interdum, nisl ligula placerat mi, quis posuere purus ligula eu lectus. Donec nunc tellus, elementum sit amet ultricies at, posuere nec nunc. Nunc euismod pellentesque diam.
      </div>
      <!-- tab rider nonaktif -->
      <div class="tab-pane fade" id="nonaktif" role="tabpanel" aria-labelledby="tab-nonaktif">
        Morbi turpis dolor, vulputate vitae felis non, tincidunt congue mauris. Phasellus volutpat augue id mi placerat mollis. Vivamus faucibus eu massa eget condimentum. Fusce nec hendrerit sem, ac tristique nulla. Integer vestibulum orci odio. Cras nec augue ipsum. Suspendisse ut velit condimentum, mattis urna a, malesuada nunc. Curabitur eleifend facilisis velit finibus tristique. Nam vulputate, eros non luctus efficitur, ipsum odio volutpat massa, sit amet sollicitudin est libero sed ipsum. Nulla lacinia, ex vitae gravida fermentum, lectus ipsum gravida arcu, id fermentum metus arcu vel metus. Curabitur eget sem eu risus tincidunt eleifend ac ornare magna.
      </div>
      <!-- tab rider banned -->
      <div class="tab-pane fade" id="banned" role="tabpanel" aria-labelledby="tab-banned">
        Pellentesque vestibulum commodo nibh nec blandit. Maecenas neque magna, iaculis tempus turpis ac, ornare sodales tellus. Mauris eget blandit dolor. Quisque tincidunt venenatis vulputate. Morbi euismod molestie tristique. Vestibulum consectetur dolor a vestibulum pharetra. Donec interdum placerat urna nec pharetra. Etiam eget dapibus orci, eget aliquet urna. Nunc at consequat diam. Nunc et felis ut nisl commodo dignissim. In hac habitasse platea dictumst. Praesent imperdiet accumsan ex sit amet facilisis.
      </div>
    </div>
  </div>
  <!-- /.card -->
</div>

<script>
  $('#riderBaru').DataTable({
    "processing": true,
    "serverSide": true,
    "order": [],
    "ajax": {
      "url": `<?= base_url() ?>/rider/getBaru`,
      "type": "POST",
      'data': {}
    },
    // "columnDefs": [{
    //     "targets": [0, 1, 2, 3, 5, 6],
    //     "className": "text-center",
    //   },
    //   {
    //     targets: [4],
    //     className: "text-body-right"
    //   }
    // ],
  });
</script>
<?= $this->endSection() ?>