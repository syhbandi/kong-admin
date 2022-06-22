<?= $this->extend('layouts/index'); ?>
<?= $this->section('content') ?>
<div class="card card-outline-tab">
  <div class="card-header border-bottom-0 p-0">
    <ul class="nav nav-tabs" role="tablist">
      <li class="nav-items">
        <a href="#belum-verifikasi-content" class="nav-link text-dark active" id="belum-verifikasi" data-toggle="pill" role="tab" aria-controls="belum-verifikasi-content" aria-selected="true"><i class="fas fa-check-circle text-info mr-1"></i> Belum Verifikasi</a>
      </li>
      <li class="nav-items">
        <a href="#riwayat-content" class="nav-link text-dark" id="riwayat" data-toggle="pill" role="tab" aria-controls="riwayat-content" aria-selected="false"><i class="fas fa-history mr-1 text-purple"></i> Riwayat</a>
      </li>
    </ul>
  </div>
  <div class="card-body">
    <div class="tab-content">
      <div class="tab-pane fade show active" id="belum-verifikasi-content" role="tabpanel" aria-labelledby="belum-verifikasi">
      <form class="pb-3" id="search">
        <fieldset>
          <div class="row">
            <div class="col-3">
              <div class="input-group date" id="datepicker">
                <input type="date" class="form-control" id="date" value="<?= date("Y-m-d")?>"/>
                <span class="input-group-append">
                  <span class="input-group-text bg-light d-block">
                    <i class="fa fa-calendar"></i>
                  </span>
              </div>
            </div>
            <div class="col-sm-1 text-center">
              <!-- <button id="btnSearch" class="btn btn-primary btn-md center-block" >Submit</button> -->
              <button type="submit" id="btnsearch" class="btn btn-primary btn-md center-block">Search</button>
            </div>
        </fieldset>
      </form>
        <table id="table-belum-verifikasi" class="table table-bordered table-hover table-striped w-100">
          <thead class="align-middle text-center">
            <tr>
              <th>No</th>
              <th>Company Id</th>
              <th>Jenis Transaksi</th>
              <th>Nama Usaha</th>
              <th>Jumlah Pencairan</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
      <div class="tab-pane fade" id="riwayat-content" role="tabpanel" aria-labelledby="riwayat">
        <table id="table-riwayat" class="table table-bordered table-hover table-striped w-100">
          <thead class="align-middle text-center">
            <tr>
              <th>No</th>
              <th>Company Id</th>
              <th>Jenis Transaksi</th>
              <th>Nama Usaha</th>
              <th>Jumlah Pencairan</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>


<script>
  function pernarikan(param_akhir){
    $('#table-belum-verifikasi').DataTable({
      "processing": true,
      "serverSide": true,
      "responsive": true,
      "bDestroy": true,
      "order": [],
      "ajax": {
        "url": `<?= base_url() ?>/pos/getPencairan/unverif`,
        "type": "POST",
        'data': {
          jenis: "unverif",
          status : 0,
          akhir: param_akhir,
        }
      },
      "columnDefs": [{
          "targets": [0, 1, 2, 3, 4, 5, 6],
          "className": "text-center",
        },
        {
          targets: [3, 4],
          className: 'text-body-right'
        }
      ],
    });
  }
  $(function() {
    pernarikan(`<?= date('Y-m-d')?>`)
    $('#table-riwayat').DataTable({
      "processing": true,
      "serverSide": true,
      "responsive": true,
      "order": [],
      "ajax": {
        "url": `<?= base_url() ?>/pos/getPencairan/1`,
        "type": "POST",
        'data': {
          jenis: "verif",
          status : 1,
          akhir:`<?= date('Y-m-d')?>`
        }
      },
      "columnDefs": [{
          "targets": [0, 1, 2, 3, 4, 5, 6],
          "className": "text-center",
        },
        {
          targets: [3, 4],
          className: 'text-body-right'
        }
      ],
    });
  })
</script>
<script>
  $(function(){
    $('#search').submit(function(e){
      e.preventDefault()
      pernarikan($("#date").val())
    })
  });
</script>
<?= $this->EndSection() ?>