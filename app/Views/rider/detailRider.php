<?= $this->extend('layouts/index'); ?>
<?= $this->section('content'); ?>
<div class="card">
  <div class="card-header d-flex align-items-center">
    <h3 class="card-title">Data Lengkap Rider (<?= $rider['Nama Rider'] ?>)</h3>
    <div class="ml-auto">
      <button class="btn btn-default" onclick="window.history.back()"><i class="fas fa-arrow-left mr-1"></i>Batal</button>
      <button class="btn btn-danger verifikasi" id="verivikasi" data-status="99"><i class="fas fa-check-circle mr-1"></i> Banned</button>
      <button class="btn btn-warning <?= $status == 3 ? 'd-none' : '' ?> perbaikan"><i class="fas fa-reply-all mr-1"></i> Ajukan Perbaikan</button>
      <button class="btn btn-success chat"><i class="fas fa-arrow-to-top mr-1"></i> Chat User</button>                                                                                                                                                                                                                    
      <button class="btn btn-primary <?= $status == 3 || $status == 0 || $status == 4 || $status == 6 ? 'd-none' : '' ?> verifikasi" id="verivikasi" data-status="0"><i class="fas fa-check-circle mr-1"></i> Verifikasi</button>
      <button class="btn btn-warning <?= $status == 3 || $status == -1 || $status == 4 || $status == 6 ? 'd-none' : '' ?> verifikasi" id="verivikasi" data-status="4"><i class="fas fa-check-circle mr-1"></i> Verifikasi Data</button>
      <button class="btn btn-success <?= $status == 3 || $status == -1 || $status == 0 || $status == 6  ? 'd-none' : '' ?> verifikasi" id="verivikasi" data-status="6"><i class="fas fa-check-circle mr-1"></i> Verifikasi Pembayaran</button>
      <button class="btn btn-dark <?= $status == 3 || $status == -1 || $status == 0 || $status == 4 ? 'd-none' : '' ?> verifikasi" id="verivikasi" data-status="3"><i class="fas fa-check-circle mr-1"></i> Verifikasi Atribut</button>
    </div>
  </div>
  <div class="card-body">
    <table class="table table-bordered">
      <?php foreach ($rider as $key => $value) : ?>
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
  $(function() {
    $('.btn-dok').on('click', function() {
      const source = $(this).attr('src');
      $('#data-image').attr('src', source)
      $('#modalImage').modal('show');
      $('#modalImageLabel').text($(this).data('title'));
    })

  $('.verifikasi').on('click',function(){
    let data_status=$(this).attr('data-status')
    Swal.fire({
        title: 'Verifikasi Rider?',
        text: "Pastikan sudah cek kelengkapan Rider",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Verifikasi',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: '<?= base_url('rider/verifikasi') ?>',
            type: 'POST',
            data: {
              kd_driver: '<?= $kd_driver ?>',
              status : data_status
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
    $('.perbaikan').on('click', () => {
      $('#modalPerbaikan').modal('show');
    })

    $('form').on('submit', function(e) {
      e.preventDefault();
      const formData = new FormData($(this)[0]);
      formData.append('kd_driver', '<?= $kd_driver ?>');

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