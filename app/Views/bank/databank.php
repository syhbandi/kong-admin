<?= $this->extend('layouts/index') ?>
<?= $this->section('content') ?>
<div class="card card-primary card-outline card-outline-tabs">
  <div class="card-header p-0 border-bottom-0">
    <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
      <li class="nav-item text-dark">
        <a class="nav-link active text-dark" id="tab-baru" data-toggle="pill" href="#baru" role="tab" aria-controls="aktif" aria-selected="true"><i class="fas fa-paste mr-1 text-info"></i> Data Bank</a>
      </li>
    </ul>
  </div>
  <div class="card-body">
    <div class="tab-content" id="custom-tabs-four-tabContent">
        <!-- add Menu -->
        <div class="text-right" style="margin-bottom: 9px; margin-right: 0px;">
          <button class="btn btn-info add" id="add" ><i class="fas fa-plus mr-1"></i> Add Bank</button>
          <!-- <a href="" class="btn btn-info btn-sm edit" data-toggle="modal"  id="edit" data-id="12"><i class="fas fa-edit mr-1"></i></a> -->
        </div>
        <!-- tab Barang baru -->
      <div class="tab-pane fade show active" id="baru" role="tabpanel" aria-labelledby="tab-baru">
        <table id="bank" class="table table-bordered table-hover table-striped w-100">
          <thead class="align-middle text-center">
            <tr>
              <th>No</th>
              <th>Code Bank</th>
              <th>Nama Bank</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
  <!-- /.card -->
  <!-- modal insert -->
<div class="modal fade modalAdd" id="modalAddb" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Data Bank</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="formElem">
        <div class="modal-body">
          <div class="form-group">
          <div class="input-group mb-3">
            <span class="input-group-text" id="addon-wrapping">Code Bank</span>
            <input type="number" class="form-control" id="cdbank" placeholder="Code Bank" aria-label="Code Bank" aria-describedby="addon-wrapping">
          </div>
          <div class="input-group mb-3">
            <span class="input-group-text" id="addon-wrapping">Bank</span>
            <input type="text" id="nmbank" class="form-control" placeholder="Nama Bank" aria-label="Nama Bank" aria-describedby="addon-wrapping" >
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
    <!-- modal EDIT -->
<div class="modal fade modaledit" id="modalEdit" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Bank</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= base_url('BankController/editbank') ?>" id="formElem">
        <div class="modal-body">
          <div class="form-group">
            <input type="hidden" id="kd">
          <div class="input-group mb-3" >
            <span class="input-group-text" id="addon-wrapping">Code Bank</span>
            <input type="number" class="form-control" id="codebank" placeholder="Code Bank" aria-label="Batas Bawah" aria-describedby="addon-wrapping" >
          </div>
          <div class="input-group mb-3">
            <span class="input-group-text" id="addon-wrapping">Nama Bank</span>
            <input type="text" id="namabank" class="form-control" placeholder="Nama Bank" aria-label="Batas Atas" aria-describedby="addon-wrapping" >
          </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary"><i class="fab fa-telegram-plane mr-2"></i>Update</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- end modal -->
 
</div>
<script>
  $(function() {
    $('#bank').DataTable({
      "processing": true,
      "serverSide": true,
      "responsive": true,
      "order": [],
      "ajax": {
        "url": `<?= base_url() ?>/BankController/getbank`,
        "type": "POST",
        'data': {}
      },
      "columnDefs": [
        {
          "targets": [0, 1, 2, 3],
          "className": "text-center",
        },
        {
          "targets": [3],
          "className": "text-body-right"
        }
      ],
    });
  });
// edit function
  $('#bank').on('click','.edit',function(){
      // var href = $("button", this).attr('data-id');
        $.ajax({
          url: '<?= base_url() ?>/BankController/getbaykd',
          type: 'POST',
          data : {kd_bank:$(this).attr('data-bank')}, 
          dataType: 'json',
          success: function(data){
            $("#kd").val(data[0].kd_bank)
            $('#codebank').val(data[0].kd_bank);
            $('#namabank').val(data[0].nama_bank);
              $("#modalEdit").modal('show');
            }
        })
  });
    $('form').on('submit', function(e) {
      e.preventDefault();
      const formData =  new FormData();
      var codebank = document.getElementById("kd").value;
      var code = document.getElementById("codebank").value;
      var bank = document.getElementById("namabank").value;
      formData.append('kd', codebank);
      formData.append('code', code);
      formData.append('bank', bank);
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
<script>
  $('.add').on('click', () => {
      $('#modalAddb').modal('show');
    })
    $('.addlist').on('click', function(e) {
      e.preventDefault();
      const formData =  new FormData();
      var code = document.getElementById("cdbank").value;
      var bank = document.getElementById("nmbank").value;
      formData.append('code', code);
      formData.append('nama_bank', bank);
      $.ajax({
        url: '<?= base_url() ?>/BankController/insertb',
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