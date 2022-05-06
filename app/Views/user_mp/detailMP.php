<?= $this->extend('layouts/index'); ?>
<?= $this->section('content'); ?>
<div class="card">
  <div class="card-header d-flex align-items-center">
    <h3 class="card-title">Data Lengkap Company (<?= $user['Kode User'] ?> )</h3>
    <div class="ml-auto ">
    <button class="btn btn-default" onclick="window.history.back()"><i class="fas fa-arrow-left mr-1"></i>Batal</button>
      <button class="btn btn-warning perbaikan <?= $status == 1 ? 'd-none' : '' ?>"><i class="fas fa-reply-all mr-1"></i> Ajukan Perbaikan</button>
      <button class="btn btn-primary verifikasi <?= $status == 1 ? 'd-none' : '' ?>"><i class="fas fa-check-circle mr-1"></i> Verifikasi</button>
      <button class="btn btn-danger nonaktif <?= $status == 0 ? 'd-none' : '' ?>"><i class="fas fa-times-circle mr-1"></i> Banned</button>
      <button class="btn btn-info edit <?= $status == 0 ? 'd-none' : '' ?>"><i class="fas fa-edit mr-1"></i> Edit Info User</button>
    </div>
  </div>
  <div class="card-body">
    <table class="table table-bordered">
      <?php foreach ($user as $key => $value) : ?>
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
<div class="modal fade" id="modalEdit" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Katergori Usaha</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= base_url('Marketplace/update') ?>" id="formElem">
        <div class="modal-body">
          <div class="form-group">
          <div class="input-group mb-3">
            <span class="input-group-text" id="addon-wrapping">Nama User</span>
            <input type="text" class="form-control" id="nama" placeholder="Nama User" aria-label="Username" aria-describedby="addon-wrapping" value="<?= $user['Nama']?>">
          </div>
          <div class="input-group mb-3">
            <span class="input-group-text" id="addon-wrapping">No. Hp</span>
            <input type="text" id="no_hp" class="form-control" placeholder="nomer tlpn" aria-label="nomer_hp" aria-describedby="addon-wrapping" value="<?= $user['No. hp'] ?>">
          </div>
          <div class="input-group mb-3">
            <span class="input-group-text" id="addon-wrapping">Email</span>
            <input type="email" class="form-control" id="email" placeholder="Email@mail.com" aria-label="email" aria-describedby="addon-wrapping" value="<?= $user['Email'] ?>">
          </div>
          <div class="input-group mb-3">
            <span class="input-group-text" id="addon-wrapping">Nomer Rekening</span>
            <input type="number" class="form-control" id="no_rek"placeholder="808080" aria-label="norek" aria-describedby="addon-wrapping" value="<?= $user['No rekening'] ?>">
          </div>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <label class="input-group-text" for="inputGroupSelect01">Nama bank</label>
            </div>
              <select class="custom-select" id="inputGroupSelect01" name="kategori">
                <option><?= $user['Rekening']?></option>
                <option value="002">BRI</option>
                <option value="014">BCA</option>
                <option value="009">BNI</option>
                <option value="008">MANDIRI</option>
              </select>
          </div>
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
   $('.edit').on('click', () => {
      $('#modalEdit').modal('show');
    })

    $('form').on('submit', function(e) {
      e.preventDefault();
      var h = document.getElementById("inputGroupSelect01");
      const formData =  new FormData();
      var nama = document.getElementById("nama").value;
      var no_hp = document.getElementById("no_hp").value;
      var email = document.getElementById("email").value;
      var no_rek = document.getElementById("no_rek").value;
      var bank = document.getElementById("inputGroupSelect01").value;
      formData.append('kd_user', '<?= $kd_user ?>');
      formData.append('nama', nama);
      formData.append('no_hp', no_hp);
      formData.append('email', email);
      formData.append('no_rek', no_rek);
      formData.append('kd_bank', bank);


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