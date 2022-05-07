<?= $this->extend('layouts/index') ?>
<?= $this->section('content') ?>
<div class="card card-primary card-outline card-outline-tabs">
  <div class="card-header p-0 border-bottom-0">
    <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
      <li class="nav-item text-dark">
        <a class="nav-link active text-dark" id="tab-baru" data-toggle="pill" href="#baru" role="tab" aria-controls="aktif" aria-selected="true"><i class="fas fa-paste mr-1 text-info"></i> Data Tarif</a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-dark" id="tab-verif" data-toggle="pill" href="#verif" role="tab" aria-controls="aktif" aria-selected="false"><i class="fas fa-plus mr-1 text-success"></i> Add Tarif</a>
      </li>
    </ul>
  </div>
  <div class="card-body">
    <div class="tab-content" id="custom-tabs-four-tabContent">
        <!-- add Menu -->
        <div class="tab-pane fade show active" id="baru" role="tabpanel" aria-labelledby="tab-baru">
        <!-- <button type="button" class="btn btn-info edit" id="edit"></button> -->
        </div>
        <!-- tab Barang baru -->
      <div class="tab-pane fade show active" id="baru" role="tabpanel" aria-labelledby="tab-baru">
        <table id="tarif" class="table table-bordered table-hover table-striped w-100">
          <thead class="align-middle text-center">
            <tr>
              <th>No</th>
              <th>Lokasi</th>
              <th>Batas Bawah</th>
              <th>Batas Atas</th>
              <th>fee minim bawah</th>
              <th>fee minim atas</th>
              <th>Jarak Pertama</th>
              <th>Deskripsi</th>
              <th>Kendaraan</th>
              <th>Detail</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
  <!-- /.card -->
  <!-- modal -->
  <div class="modal fade modaledit" id="modalEdit" tabindex="-1" aria-hidden="true">
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
            <div class="input-group-prepend">
              <label class="input-group-text" for="inputGroupSelect01">Provinsi</label>
            </div>
              <select class="custom-select" id="inputGroupSelect01" name="Provinsi">
                <option>--- Pilih ---</option>
                <?php foreach($tarif['code'] as $key => $value): ?>
                <option value="<?= $value->kd_lokasi?>"><?= $value->lokasi1?></option>
                <?php endforeach; ?>
              </select>
          </div>
          <div class="input-group mb-3">
            <span class="input-group-text" id="addon-wrapping">Batas Bawah</span>
            <input type="number" class="form-control" id="bawah" placeholder="Rp. 100000" aria-label="Batas Bawah" aria-describedby="addon-wrapping" value="<?= $tarif['bawah']?>">
          </div>
          <div class="input-group mb-3">
            <span class="input-group-text" id="addon-wrapping">Batas Atas</span>
            <input type="number" id="atas" class="form-control" placeholder="Rp. 100000" aria-label="Batas Atas" aria-describedby="addon-wrapping" value="<?= $tarif['atas']?>">
          </div>
          <div class="input-group mb-3">
            <span class="input-group-text" id="addon-wrapping">Fee Bawah</span>
            <input type="number" class="form-control" id="Feeb" placeholder="Rp. 100000" aria-label="fee Bawah" aria-describedby="addon-wrapping" value="<?= $tarif['fee bawah']?>">
          </div>
          <div class="input-group mb-3">
            <span class="input-group-text" id="addon-wrapping">Fee Atas</span>
            <input type="number" class="form-control" id="feea" placeholder="Rp. 100000" aria-label="Fee Atas" aria-describedby="addon-wrapping" value="<?= $tarif['fee atas']?>">
          </div>
          <div class="input-group mb-3">
            <span class="input-group-text" id="addon-wrapping">Jarak</span>
            <input type="number" class="form-control" id="jarak" placeholder="100 Km" aria-label="Jarak" aria-describedby="addon-wrapping"  value="<?= $tarif['jarak']?>">
          </div>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <label class="input-group-text" for="inputGroupSelect01">Kendaraan</label>
            </div>
              <select class="custom-select" id="inputGroupSelect01" name="kendaraan">
                <option><?= $tarif['nama']?></option>
                <option value="1">Motor</option>
                <option value="2">Mobil Kecil 2 - 4 penumpang</option>
                <option value="3">Mobil Besar 4 - 6 penumpang</option>
              </select>
          </div>
          <div class="input-group">
            <span class="input-group-text">Deskripsi</span>
            <textarea class="form-control" id="deskripsi" aria-label="With textarea"><?= $tarif['deskripsi']?></textarea>
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
<!-- end modal -->
</div>
<script>
   $('#edit').on('click', () => {
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
      formData.append('kd_user', '');
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
  $(function() {
    $('#tarif').DataTable({
      "processing": true,
      "serverSide": true,
      "responsive": true,
      "order": [],
      "ajax": {
        "url": `<?= base_url() ?>/TransaksiController/tarif`,
        "type": "POST",
        'data': {}
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
<?= $this->endSection() ?>