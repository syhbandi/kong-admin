<?= $this->extend('layouts/index') ?>
<?= $this->section('content') ?>
<div class="card card-primary card-outline card-outline-tabs">
  <div class="card-header p-0 border-bottom-0">
    <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
      <li class="nav-item text-dark">
        <a class="nav-link active text-dark" id="tab-baru" data-toggle="pill" href="#baru" role="tab" aria-controls="aktif" aria-selected="true"><i class="fas fa-power-off mr-1 text-danger"></i> Nonaktif</a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-dark" id="tab-verif" data-toggle="pill" href="#verif" role="tab" aria-controls="aktif" aria-selected="false"><i class="fas fa-power-off mr-1 text-warning"></i> Aktif (Non Display)</a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-dark" id="tab-aktif" data-toggle="pill" href="#aktif" role="tab" aria-controls="aktif" aria-selected="false"><i class="fas fa-power-off mr-1 text-success"></i> Aktif (Display)</a>
      </li>
    </ul>
  </div>
  <button class="btn btn-primary verifikasi" id="verif"><i class="fas fa-check-circle mr-1"></i> Verifikasi</button>
  <div class="card-body">
    <div class="tab-content" id="custom-tabs-four-tabContent">
      <!-- tab Barang baru -->
      <div class="tab-pane fade show active" id="baru" role="tabpanel" aria-labelledby="tab-baru">
        <table id="barangBaru" class="table table-bordered table-hover table-striped w-100">
          <thead class="align-middle text-center">
            <tr>
              <th></th>
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
  $(function() {
    $('#barangBaru').DataTable({
      "processing": true,
      "serverSide": true,
      "responsive": true,
      "order": [],
      "ajax": {
        "url": `<?= base_url() ?>/pos/getjmlbrng/nonaktif/`+`<?= $company_id ?>`,
        "type": "POST",
        'data': {
        }
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

    $('#barang-verif').DataTable({
      processing: true,
      serverSide: true,
      responsive: true,
      order: [],
      "ajax": {
        "url": `<?= base_url() ?>/pos/getjmlbrng/nonverification/`+`<?= $company_id ?>`,
        "type": "POST",
        'data': {

        }
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

    $('#barangaktif').DataTable({
      processing: true,
      serverSide: true,
      responsive: true,
      order: [],
      "ajax": {
        "url": `<?= base_url() ?>/pos/getjmlbrng/aktif/`+`<?= $company_id ?>`,
        "type": "POST",
        'data': {
        }
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
<script>
$("document").ready(function(){
  var files = new Array();
$('#verif').click(function(){

    //xzyId is table id.
    $('#barangBaru tbody tr  input:checkbox').each(function() {
      if ($(this).is(':checked')) {
      files.push(this.value);
      }
    });
    console.log(files);
      Swal.fire({
        title: 'Aktif(Display) Barang?',
        text: "Pastikan sudah mengecek Barang",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Verifikasi',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: '<?= base_url('pos/verivikasiBarang') ?>',
            type: 'POST',
            data: {
              status: 'aktif',
              kd_barang: files,
              id : `<?= $company_id ?>`,
            },
            dataType: 'json',
            // contentType: false,
            // processData: false,
            success: function(res) {
              if (res.success) {
                location.href = res.redirect
              } else {
                Swal.fire({
                  title: 'Oops..',
                  text: res.msg,
                  icon: 'error',
                })
              }
            },
            error: function(e) {
              console.log(e.response)
            }
          })
        }
      })

    
 });
})

</script>
<?= $this->endSection() ?>