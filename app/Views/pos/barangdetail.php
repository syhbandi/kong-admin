<?= $this->extend('layouts/index'); ?>
<?= $this->section('content'); ?>
<div class="card">
  <div class="card-header d-flex align-items-center">
    <h3 class="card-title">Data Lengkap Toko (<?= $barang['Nama Toko'] ?>)</h3>
    <div class="ml-auto ">
    <button class="btn btn-default" onclick="window.history.back()"><i class="fas fa-arrow-left mr-1"></i>Batal</button>
      <!-- <button class="btn btn-warning perbaikan"><i class="fas fa-reply-all mr-1"></i> Ajukan Perbaikan</button> -->
      <button class="btn btn-primary aktif <?= $status_barang == -1 ? 'd-none' : '' ?>"><i class="fas fa-check-circle mr-1"></i> Aktif(Non Display)</button>
      <button class="btn btn-success verifikasi <?= $status_barang == 1 ? 'd-none' : '' ?>"><i class="fas fa-check-circle mr-1"></i> Aktif(Display)</button>
      <button class="btn btn-danger nonaktif <?= $status_barang == 0 ? 'd-none' : '' ?>"><i class="fas fa-times-circle mr-1"></i> Non Aktif</button>

    </div>
  </div>
  <div class="card-body">
    <table class="table table-bordered">
      <?php foreach ($barang as $key => $value) : ?>
        <tr>
          <th><?= $key ?></th>
          <td><?= $value ?></td>
        </tr>
      <?php endforeach ?>
    </table>
  </div>
</div>

<div class="modal fade" id="modalImage" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalImageLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <img src="" alt="" id="data-image" width="100%">
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalPerbaikan" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Ajukan Perbaikan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= base_url('rider/perbaikan') ?>">
        <div class="modal-body">
          <div class="form-group">
            <label for="">Keterangan Perbaikan</label>
            <textarea name="pesan" id="pesan" cols="30" rows="4" placeholder="Sertakan keterangan perbaikan" class="form-control"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary"><i class="fab fa-telegram-plane mr-2"></i>Ajukan</button>
        </div>
      </form>
    </div>
  </div>
</div>


<script>
  $('.verifikasi').on('click', () => {
      console.log('<?= $code ?>')
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
              kd_barang: '<?= $code ?>'
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
    })

    $('.aktif').on('click', () => {
      console.log('<?= $code ?>')
      Swal.fire({
        title: 'aktif(Non Display) Barang?',
        text: "Pastikan sudah mengecek Barang",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'aktif',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: '<?= base_url('pos/verivikasiBarang') ?>',
            type: 'POST',
            data: {
              status: 'nondisplay',
              kd_barang: '<?= $code ?>'
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
    })

    $('.nonaktif').on('click', () => {
      console.log('<?= $code ?>')
      Swal.fire({
        title: 'nonaktif Barang?',
        text: "Pastikan sudah mengecek Barang",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'nonaktif',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: '<?= base_url('pos/verivikasiBarang') ?>',
            type: 'POST',
            data: {
              status: 'nonaktif',
              kd_barang: '<?= $code ?>'
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
    })

  $('.perbaikan').on('click', () => {
      $('#modalPerbaikan').modal('show');
    })

    $('form').on('submit', function(e) {
      e.preventDefault();
      const formData = new FormData($(this)[0]);
      formData.append('kd_barang', '<?= $code ?>');

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
</script>
<?= $this->endSection(); ?>