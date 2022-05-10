<?= $this->extend('layouts/index') ?>
<?= $this->section('content') ?>
<div class="card card-primary card-outline card-outline-tabs">
  <div class="card-header p-0 border-bottom-0">
    <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
      <li class="nav-item text-dark">
        <a class="nav-link active text-dark" id="tab-baru" data-toggle="pill" href="#baru" role="tab" aria-controls="aktif" aria-selected="true"><i class="fas fa-paste mr-1 text-info"></i> Data Tarif</a>
      </li>
    </ul>
  </div>
  <div class="card-body">
    <div class="tab-content" id="custom-tabs-four-tabContent">
        <!-- add Menu -->
        <div class="text-right" style="margin-bottom: 9px; margin-right: 0px;">
          <button class="btn btn-info add" id="add" ><i class="fas fa-plus mr-1"></i> Add Data Tarif</button>
          <!-- <a href="" class="btn btn-info btn-sm edit" data-toggle="modal"  id="edit" data-id="12"><i class="fas fa-edit mr-1"></i></a> -->
        </div>
        <!-- tab Barang baru -->
      <div class="tab-pane fade show active" id="baru" role="tabpanel" aria-labelledby="tab-baru">
        <table id="tarif" class="table table-bordered table-hover table-striped w-100">
          <thead class="align-middle text-center">
            <tr>
              <th>No</th>
              <th>Lokasi</th>
              <th>App</th>
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
  <!-- modal EDIT -->
  <div class="modal fade modaledit" id="modalEdit" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Trif</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= base_url('Transaksi/updatezona') ?>" id="formElem">
        <div class="modal-body">
          <div class="form-group">
            <input type="hidden" class="form-control" id="idlokasi" placeholder="Rp. 100000" aria-label="Batas Bawah" aria-describedby="addon-wrapping">
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <label class="input-group-text" for="inputGroupSelect03">Provinsi</label>
            </div>
              <select class="custom-select" id="inputGroupSelect01" name="Provinsi">
                <option id="code">--- Pilih Lokasi ---</option>
                <?php foreach($lokasi['code'] as $key => $value): ?>
                <option value="<?= $value['kd_lokasi']?>"><?= $value['lokasi']?></option>
                <?php endforeach; ?>
              </select>
          </div>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <label class="input-group-text" for="inputGroupSelect01">App Name</label>
            </div>
              <select class="custom-select" id="inputGroupSelect03" name="Provinsi">
                <option id="code_app">--- Pilih App ---</option>
                <?php foreach($lokasi['app'] as $key => $value): ?>
                <option value="<?= $value->id?>"><?= $value->app_name?></option>
                <?php endforeach; ?>
              </select>
          </div>
          <div class="input-group mb-3" >
            <span class="input-group-text" id="addon-wrapping">Batas Bawah</span>
            <input type="number" class="form-control" id="bawah" placeholder="Rp. 100000" aria-label="Batas Bawah" aria-describedby="addon-wrapping" >
          </div>
          <div class="input-group mb-3">
            <span class="input-group-text" id="addon-wrapping">Batas Atas</span>
            <input type="number" id="atas" class="form-control" placeholder="Rp. 100000" aria-label="Batas Atas" aria-describedby="addon-wrapping" >
          </div>
          <div class="input-group mb-3">
            <span class="input-group-text" id="addon-wrapping">Fee Bawah</span>
            <input type="number" class="form-control" id="feeb" placeholder="Rp. 100000" aria-label="fee Bawah" aria-describedby="addon-wrapping" >
          </div>
          <div class="input-group mb-3">
            <span class="input-group-text" id="addon-wrapping">Fee Atas</span>
            <input type="number" class="form-control" id="feea" placeholder="Rp. 100000" aria-label="Fee Atas" aria-describedby="addon-wrapping" >
          </div>
          <div class="input-group mb-3">
            <span class="input-group-text" id="addon-wrapping">Jarak</span>
            <input type="number" class="form-control" id="jarak" placeholder="100 Km" aria-label="Jarak" aria-describedby="addon-wrapping" >
          </div>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <label class="input-group-text" for="inputGroupSelect01">Kendaraan</label>
            </div>
              <select class="custom-select" id="inputGroupSelect02" name="kendaraan">
                <option id="kendaraan">--- Pilih Kendaraan ---</option>
                <option value="1">Motor</option>
                <option value="2">Mobil Kecil 2 - 4 penumpang</option>
                <option value="3">Mobil Besar 4 - 6 penumpang</option>
              </select>
          </div>
          <div class="input-group">
            <span class="input-group-text">Deskripsi</span>
            <textarea class="form-control" id="deskripsi" aria-label="With textarea"></textarea>
          </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary"><i class="fab fa-telegram-plane mr-2"></i>Update</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- end modal -->
<!-- modal insert -->
<div class="modal fade modalAdd" id="modalAdd" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Data Tarif</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= base_url('Transaksi/addzona') ?>" id="formElem">
        <div class="modal-body">
          <div class="form-group">
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <label class="input-group-text" for="inputGroupSelect03">Provinsi</label>
            </div>
              <select class="custom-select" id="insert01" name="Provinsi">
                <option>--- Pilih Lokasi ---</option>
                <?php foreach($lokasi['code'] as $key => $value): ?>
                <option value="<?= $value['kd_lokasi']?>"><?= $value['lokasi']?></option>
                <?php endforeach; ?>
              </select>
          </div>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <label class="input-group-text" for="inputGroupSelect01">App Name</label>
            </div>
              <select class="custom-select" id="insert02" name="Provinsi">
                <option>--- Pilih App ---</option>
                <?php foreach($lokasi['app'] as $key => $value): ?>
                <option value="<?= $value->id?>"><?= $value->app_name?></option>
                <?php endforeach; ?>
              </select>
          </div>
          <div class="input-group mb-3">
            <span class="input-group-text" id="addon-wrapping">Batas Bawah</span>
            <input type="number" class="form-control" id="btsb" placeholder="Rp. 100000" aria-label="Batas Bawah" aria-describedby="addon-wrapping">
          </div>
          <div class="input-group mb-3">
            <span class="input-group-text" id="addon-wrapping">Batas Atas</span>
            <input type="number" id="btsa" class="form-control" placeholder="Rp. 100000" aria-label="Batas Atas" aria-describedby="addon-wrapping" >
          </div>
          <div class="input-group mb-3">
            <span class="input-group-text" id="addon-wrapping">Fee Bawah</span>
            <input type="number" class="form-control" id="feemb" placeholder="Rp. 100000" aria-label="fee Bawah" aria-describedby="addon-wrapping" >
          </div>
          <div class="input-group mb-3">
            <span class="input-group-text" id="addon-wrapping">Fee Atas</span>
            <input type="number" class="form-control" id="feema" placeholder="Rp. 100000" aria-label="Fee Atas" aria-describedby="addon-wrapping" >
          </div>
          <div class="input-group mb-3">
            <span class="input-group-text" id="addon-wrapping">Jarak</span>
            <input type="number" class="form-control" id="space" placeholder="100 Km" aria-label="Jarak" aria-describedby="addon-wrapping" >
          </div>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <label class="input-group-text" for="inputGroupSelect01">Kendaraan</label>
            </div>
              <select class="custom-select" id="insert03" name="kendaraan">
                <option>--- Pilih Kendaraan ---</option>
                <option value="1">Motor</option>
                <option value="2">Mobil Kecil 2 - 4 penumpang</option>
                <option value="3">Mobil Besar 4 - 6 penumpang</option>
              </select>
          </div>
          <div class="input-group">
            <span class="input-group-text">Deskripsi</span>
            <textarea class="form-control" id="description" aria-label="With textarea"></textarea>
          </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary addlist"><i class="fab fa-telegram-plane mr-2"></i>Update</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- end modal -->
</div>
<script>
  $('#tarif').on('click','.edit',function(){
      // var href = $("button", this).attr('data-id');
        $.ajax({
          url: '<?= base_url() ?>/transaksi/show',
          type: 'POST',
          data : {id:$(this).attr('data-id')}, 
          dataType: 'json',
          success: function(data){
            $('#idlokasi').val(data[0].id);
            $('#code').val(data[0].zona_id);
            $('#code_app').val(data[0].app_id);
            $('#bawah').val(data[0].batas_bawah);
            $('#atas').val(data[0].batas_atas);
            $('#feeb').val(data[0].fee_minim_bawah);
            $('#feea').val(data[0].fee_minim_atas);
            $('#jarak').val(data[0].jarak_pertama);
            $('#kendaraan').val(data[0].jenis_kendaraan_id);
            $('#deskripsi').val(data[0].deskripsi);
              $("#modalEdit").modal('show');
                    console.log(data[0].zona_id)
            }
        })
  });
    $('form').on('submit', function(e) {
      e.preventDefault();
      const formData =  new FormData();
      var id = document.getElementById("idlokasi").value;;
      var provinsi = document.getElementById("inputGroupSelect01").value;
      var bawah = document.getElementById("bawah").value;
      var atas = document.getElementById("atas").value;
      var feeb = document.getElementById("feeb").value;
      var feea = document.getElementById("feea").value;
      var jarak = document.getElementById("jarak").value;
      var kendaraan = document.getElementById("inputGroupSelect02").value;
      var app = document.getElementById("inputGroupSelect03").value;
      var deskripsi = document.getElementById("deskripsi").value;
      formData.append('id', id);
      formData.append('zona', provinsi);
      formData.append('bawah', bawah);
      formData.append('atas', atas);
      formData.append('feeb', feeb);
      formData.append('feea', feea);
      formData.append('jarak', jarak);
      formData.append('kendaraan', kendaraan);
      formData.append('app', app);
      formData.append('deskripsi', deskripsi)

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
        "url": `<?= base_url() ?>/Transaksi/tarif`,
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
<script>
  $('.add').on('click', () => {
      $('#modalAdd').modal('show');
    })
    $('.addlist').on('click', function(e) {
      e.preventDefault();
      const formData =  new FormData();
      var lokasi = document.getElementById("insert01").value;
      var btsbawah = document.getElementById("btsb").value;
      var btsatas = document.getElementById("btsa").value;
      var feemb = document.getElementById("feemb").value;
      var feema = document.getElementById("feema").value;
      var space = document.getElementById("space").value;
      var drive = document.getElementById("insert03").value;
      var appl = document.getElementById("insert02").value;
      var description = document.getElementById("description").value;
      formData.append('zona', lokasi);
      formData.append('bawah', btsbawah);
      formData.append('atas', btsatas);
      formData.append('feeb', feemb);
      formData.append('feea', feema);
      formData.append('jarak', space);
      formData.append('kendaraan', drive);
      formData.append('app', appl);
      formData.append('deskripsi', description);
      $.ajax({
        url: '<?= base_url() ?>/Transaksi/addzona',
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
<?= $this->endSection() ?>