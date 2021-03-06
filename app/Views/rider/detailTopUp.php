<?= $this->extend('layouts/index'); ?>
<?= $this->section('content'); ?>
<div class="card">
  <div class="card-header d-flex align-items-center">
    <h3 class="card-title">Data Top Up (<?= $topUp['Nama Rider'] ?>) : <strong><?= $topUp['Nominal Top Up'] ?></strong></h3>
    <div class="ml-auto <?= $dataTopUp->status == '1' ? 'd-none' : '' ?>">
      <button class="btn btn-default" onclick="window.history.back()"><i class="fas fa-arrow-left mr-1"></i>Batal</button>
      <button class="btn btn-danger perbaikan"><i class="fas fa-reply-all mr-1"></i> Reject</button>
      <button class="btn btn-primary verifikasi"><i class="fas fa-check-circle mr-1"></i> Verifikasi</button>
    </div>
  </div>
  <div class="card-body">
    <table class="table table-bordered">
      <?php foreach ($topUp as $key => $value) : ?>
        <tr>
          <th><?= $key ?></th>
          <td class="text-capitalize"><?= $value ?></td>
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
        <h5 class="modal-title">Tolak Top Up</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= base_url('rider/verifikasiTopUp') ?>">
        <div class="modal-body">
          <div class="form-group">
            <label for="">Keterangan Penolakan</label>
            <textarea name="pesan" id="pesan" cols="30" rows="4" placeholder="Sertakan keterangan Penolakan" class="form-control"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary"><i class="fab fa-telegram-plane mr-2"></i>Kirim</button>
          <input type="hidden" name="no_transaksi" value="<?= $dataTopUp->no_transaksi ?>">
          <input type="hidden" name="status" value="-2">
          <input type="hidden" name="id" value="<?= $dataTopUp->id ?>">
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  const data = <?= json_encode($dataTopUp) ?>;
  $(function() {
    $('.btn-dok').on('click', function() {
      // const source = $(this).data('source');
      const source = $(this).attr('src');
      $('#data-image').attr('src', source)
      $('#modalImageLabel').text($(this).data('title'))
      $('#modalImage').modal('show');
    })

    $('.verifikasi').on('click', () => {
      Swal.fire({
        title: 'Verifikasi Top Up?',
        text: "Pastikan sudah cek top up Rider",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Verifikasi',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: '<?= base_url('rider/verifikasiTopUp') ?>',
            type: 'POST',
            data: {
              no_transaksi: '<?= $dataTopUp->no_transaksi ?>',
              id: '<?= $dataTopUp->kd_driver ?>',
              jenis_user: '2',
              nominal: `<?= $dataTopUp->nominal ?>`,
              kd_bank: '<?= $dataTopUp->kd_bank ?>',
              no_rek_pengirim: '<?= $dataTopUp->no_rek_pengirim ?>',
              status: 1
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