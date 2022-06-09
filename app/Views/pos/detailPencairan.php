<?= $this->extend('layouts/index'); ?>
<?= $this->section('content'); ?>
<div class="card">
  <div class="card-header d-flex align-items-center">
    <h3 class="card-title">Pengajuan Pencairan</h3>
    <div class="ml-auto ">
      <button class="btn btn-default" onclick="window.history.back()"><i class="fas fa-arrow-left mr-1"></i>Batal</button>
      <button class="btn btn-warning perbaikan"><i class="fas fa-reply-all mr-1"></i> Ajukan Perbaikan</button>
      <button class="btn btn-primary verifikasi"><i class="fas fa-check-circle mr-1"></i> Verifikasi</button>
    </div>
    
  </div>
  <div class="card-body">
    <div class="tab-content">
      <div class="tab-pane fade show active" id="belum-verifikasi-content" role="tabpanel" aria-labelledby="belum-verifikasi">
        <table id="table-belum-verifikasi" class="table table-bordered table-hover table-striped w-100">
          <thead class="align-middle text-center">
            <tr>
              <th>No</th>
              <th>Nomor Transaksi</th>
              <th>Jenis Transaksi</th>
              <th>Jumlah Item</th>
              <th>Jumlah Pencairan</th>
            </tr>
          </thead>
          <tbody>
          <?php foreach ($data as $key => $value) : ?>
            <tr>
              <td><?= $key+1 ?></td>
              <td><?= $value->no_transaksi ?></td>
              <td><?= $value->jenis_transaksi ?></td>
              <td><?= $value->jumlah_item ?></td>
              <td><?= $value->total_transfer ?></td>
            </tr>
            <?php endforeach ?>
          </tbody>
        </table>
      </div>
</div>
<div class="modal fade" id="modalImage" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabel"></h5>
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
        <h5 class="modal-title">Tolak pengajuan penarikan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= base_url('pos/verifikasiPencairan') ?>">
        <div class="modal-body">
          <div class="form-group">
            <label for="">Keterangan Penolakan</label>
            <textarea name="pesan" id="pesan" cols="30" rows="4" placeholder="Sertakan keterangan Penolakan" class="form-control"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary"><i class="fab fa-telegram-plane mr-2"></i>Kirim</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  $(function() {
    $('.btn-dok').on('click', function() {
      const source = $(this).data('source');
      $('#data-image').attr('src', source)
      $('#modalImage').modal('show');
    })

    $('.verifikasi').on('click', () => {
      Swal.fire({
        title: 'Verifikasi Top Up?',
        text: "Pastikan sudah cek",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Verifikasi',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: '<?= base_url('pos/verifikasiPencairan') ?>',
            type: 'POST',
            data: {
             
            },
            dataType: 'json',
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



  })
</script>
<?= $this->endSection(); ?>