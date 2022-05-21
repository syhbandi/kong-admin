<?= $this->extend('layouts/index'); ?>
<?= $this->section('content'); ?>
<div class="card">
  <div class="card-header d-flex align-items-center">
    <h3 class="card-title">Data Lengkap Kontrak</h3>
    <div class="ml-auto <?= $status == 3 ? 'd-none' : '' ?>">
      <button class="btn btn-default" onclick="window.history.back()"><i class="fas fa-arrow-left mr-1"></i>Batal</button>
      <!-- <button class="btn btn-warning perbaikan"><i class="fas fa-reply-all mr-1"></i> Ajukan Perbaikan</button> -->
      <button class="btn btn-primary verifikasi"><i class="fas fa-check-circle mr-1"></i> Verifikasi</button>
    </div>
  </div>
  <div class="card-body">
    <table class="table table-bordered">
      <?php foreach ($kontrak as $key => $value) : ?>
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

    $('.verifikasi').on('click', () => {
      Swal.fire({
        title: 'Verifikasi Kontrak?',
        text: "Pastikan sudah cek Bukti Pembayaran Kontrak",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Verifikasi',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          console.log('<?= $comp_customer ?>');
          console.log('<?= $code_customer ?>');
          $.ajax({
            url: '<?= base_url() ?>/KontrakController/updatekontrak',
            type: 'POST',
            data: {
              id: '<?= $id_kontrak ?>',
              code_customer : '<?= $code_customer ?>',  
              comp_customer : '<?= $comp_customer ?>',
              code_supplier : '<?= $code_supplier ?>', 
              comp_supplier : '<?= $comp_supplier ?>',
              tujuan : '<?= $tujuan ?>',
              sumber : '<?= $sumber ?>',
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
  })
</script>
<?= $this->endSection(); ?>