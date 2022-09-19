<?= $this->extend('layouts/index') ?>
<?= $this->section('content') ?>
<div class="card card-primary card-outline card-outline-tabs">
  <div class="card-header p-0 border-bottom-0">
    <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
      <li class="nav-item text-dark">
        <a class="nav-link active text-dark" id="tab-baru" data-toggle="pill" href="#baru" role="tab" aria-controls="baru" aria-selected="true"><i class="fas fa-plus-circle mr-1 text-info"></i> Data Atribut</a>
      </li>
      <!-- <li class="nav-item">
        <a class="nav-link text-dark" id="tab-aktif" data-toggle="pill" href="#aktif" role="tab" aria-controls="aktif" aria-selected="false"><i class="fas fa-power-off mr-1 text-success"></i> Aktif</a>
      </li> -->
      <!-- <li class="nav-item">
        <a class="nav-link text-dark" id="tab-vdata" data-toggle="pill" href="#vdata" role="tab" aria-controls="vdata" aria-selected="false"><i class="fas fa-power-off mr-1 text-warning"></i> Verivikasi Data</a>
      </li> -->
      <!-- <li class="nav-item">
        <a class="nav-link text-dark" id="tab-vpembayaran" data-toggle="pill" href="#vpembayaran" role="tab" aria-controls="vpembayaran" aria-selected="false"><i class="fas fa-money-bill mr-1 text-success"></i> Verivikasi Pembayaran</a>
      </li> -->
      <!-- <li class="nav-item">
        <a class="nav-link text-dark" id="tab-vatribut" data-toggle="pill" href="#vatribut" role="tab" aria-controls="vatribut" aria-selected="false"><i class="fas fa-power-off mr-1 text-info"></i> Verivikasi Atribut</a>
      </li> -->
      <!-- <li class="nav-item">
        <a class="nav-link text-dark" id="tab-banned" data-toggle="pill" href="#banned" role="tab" aria-controls="banned" aria-selected="false"><i class="fas fa-ban mr-1 text-danger"></i> Banned</a>
      </li> -->
    </ul>
  </div>
  <div class="card-body">
    <div class="tab-content" id="custom-tabs-four-tabContent">
      <!-- tab rider baru -->
      <div class="tab-pane fade show active" id="baru" role="tabpanel" aria-labelledby="tab-baru">
        <table id="attrBaru" class="table table-bordered table-hover table-striped w-100">
          <thead class="align-middle text-center">
            <tr>
              <th>No</th>
              <th>Nama Paket</th>
              <th>Keterangan</th>
              <th>Harga Jual</th>
              <th>Action</th>
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
   <!-- modal EDIT -->
   <div class="modal fade modaledit" id="modalEdit" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Atribut</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= base_url('AtributController/editattr') ?>" id="formElem">
        <div class="modal-body">
          <div class="form-group">
            <input type="hidden" id="kd">
          <div class="input-group mb-3" >
            <span class="input-group-text" id="addon-wrapping">Nama</span>
            <input type="text" class="form-control" id="nama" placeholder="Nama Atribut" aria-label="Batas Bawah" aria-describedby="addon-wrapping" readonly>
          </div>
          <div class="input-group mb-3" >
            <span class="input-group-text" id="addon-wrapping">Keterangan</span>
            <input type="text" class="form-control" id="keterangan" placeholder="Code Bank" aria-label="Batas Bawah" aria-describedby="addon-wrapping" readonly>
          </div>
          <div class="input-group mb-3">
            <span class="input-group-text" id="addon-wrapping">Harga Atribut</span>
            <input type="text" id="harga_attr" class="form-control" placeholder="Nama Bank" aria-label="Batas Atas" aria-describedby="addon-wrapping" >
          </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary"><i class="fab fa-telegram-plane mr-2"></i>Update</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- end modal -->

<script>
  $(function() {
    $('#attrBaru').DataTable({
      "processing": true,
      "serverSide": true,
      "responsive": true,
      "order": [],
      "ajax": {
        "url": `<?= base_url() ?>/AtributController/getattr`,
        "type": "POST",
        'data': {}
      },
      "columnDefs": [
        {
          "targets": [0, 1, 2, 3, 4],
          "className": "text-center",
        },
        {
          "targets": [3],
          "className": "text-body-right"
        }
      ],
    });
// edit function
$('#attrBaru').on('click','.edit',function(){
      // var href = $("button", this).attr('data-id');
        $.ajax({
          url: '<?= base_url() ?>/AtributController/getbaykd',
          type: 'POST',
          data : {driver_attr_id:$(this).attr('data-attr')}, 
          dataType: 'json',
          success: function(data){
            $("#kd").val(data[0].driver_attr_id);
            $('#nama').val(data[0].nama);
            $('#keterangan').val(data[0].keterangan);
            $('#harga_attr').val(data[0].harga_jual);
            $("#modalEdit").modal('show');
            }
        })
  });
  $('form').on('submit', function(e) {
      e.preventDefault();
      const formData =  new FormData();
      var kd_attr = document.getElementById("kd").value;
      var harga = document.getElementById("harga_attr").value;
      formData.append('driver_attr_id', kd_attr);
      formData.append('harga_jual', harga);
      $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        data: formData,
        dataType: 'json',
        contentType: false,
        processData: false,
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
    });
    // $('#rider-aktif').DataTable({
    //   processing: true,
    //   serverSide: true,
    //   responsive: true,
    //   order: [],
    //   "ajax": {
    //     "url": `<?= base_url() ?>/rider/getRider/aktif`,
    //     "type": "POST",
    //     'data': {}
    //   },
    //   "columnDefs": [{
    //       "targets": [0, 1, 4, 5, 7, 8],
    //       "className": "text-center",
    //     },
    //     {
    //       "targets": [6],
    //       "className": "text-body-right"
    //     }
    //   ],
    // });
    // $('#riderNonaktif').DataTable({
    //   processing: true,
    //   serverSide: true,
    //   responsive: true,
    //   order: [],
    //   "ajax": {
    //     "url": `<?= base_url() ?>/rider/getRider/nonaktif`,
    //     "type": "POST",
    //     'data': {}
    //   },
    //   "columnDefs": [{
    //       "targets": [0, 1, 4, 5, 7, 8],
    //       "className": "text-center",
    //     },
    //     {
    //       "targets": [6],
    //       "className": "text-body-right"
    //     }
    //   ],
    // });
    // $('#riderBanned').DataTable({
    //   processing: true,
    //   serverSide: true,
    //   responsive: true,
    //   order: [],
    //   "ajax": {
    //     "url": `<?= base_url() ?>/rider/getRider/banned`,
    //     "type": "POST",
    //     'data': {}
    //   },
    //   "columnDefs": [{
    //       "targets": [0, 1, 4, 5, 7, 8],
    //       "className": "text-center",
    //     },
    //     {
    //       "targets": [6],
    //       "className": "text-body-right"
    //     }
    //   ],
    // });



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