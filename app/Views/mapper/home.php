<?php
// echo "<pre>";
// print_r($belum_bayar);
// echo "</pre>";


?>


<?= $this->extend('layouts/index') ?>
<?= $this->section('content') ?>
<div class="card card-primary card-outline card-outline-tabs">
  <div class="card-header p-0 border-bottom-0">
    <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
      <li class="nav-item text-dark">
        <a class="nav-link active text-dark" id="tab-belum_verif" data-toggle="pill" href="#belum-verif" role="tab" aria-controls="aktif" aria-selected="true"><i class="fas fa-power-off mr-1 text-success"></i> Belum Verifikasi </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-dark" id="tab-belum_bayar" data-toggle="pill" href="#belum-bayar" role="tab" aria-controls="aktif" aria-selected="false"><i class="fas fa-power-off mr-1 text-danger"></i> Belum Bayar </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-dark" id="tab-sudah_verif" data-toggle="pill" href="#sudah-verif" role="tab" aria-controls="aktif" aria-selected="false"><i class="fas fa-power-off mr-1 text-danger"></i> Sudah Verifikasi </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-dark" id="tab-expired" data-toggle="pill" href="#expired" role="tab" aria-controls="aktif" aria-selected="false"><i class="fas fa-power-off mr-1 text-danger"></i> Expired</a>
      </li>
    </ul>
  </div>
  <div class="card-body">
    <div class="tab-content" id="custom-tabs-four-tabContent">
      <!-- tab Belum Verifikasi -->
      <div class="tab-pane fade show active" id="belum-verif" role="tabpanel" aria-labelledby="tab-belum_verif">
        <table id="dtbl-belum-verif" class="table table-bordered table-hover table-striped w-100 table-verifikasi">
        <thead class="align-middle text-center">
            <tr>
              <th>No</th>
              <th>NAMA USAHA</th>
              <th>PERIODE (Bulan)</th>
              <th>NOMINAL</th>
              <th>KETERANGAN</th>
              <th>BUKTI BAYAR</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php
                foreach ($belum_verif as $key_bb => $value_bb) {
                    ?>
                    <tr>
                        <td><?=$key_bb+1?></td>
                        <td id="bv-nama-usaha_<?=$key_bb?>"><?=$value_bb->nama_usaha?></td>
                        <td id="bv-awal_<?=$key_bb?>" style="text-align:center"><?=$value_bb->periode." <br>(".$value_bb->awal." s/d ".$value_bb->akhir," )"?></td>
                        <td id="bv-nominal_<?=$key_bb?>"><?=$value_bb->nominal?></td>
                        <td>Pembayaran dilakukan pada tanggal <?=$value_bb->tanggal_bayar?></td>
                        <td><?=$value_bb->bukti_bayar?></td>
                        <td><button class="btn btn-sm btn-primary btn-verifikasi" data-kode="bv" data-nomor="<?=$key_bb?>" data-awal="<?=$value_bb->awal?>" data-periode="<?=$value_bb->periode?>" data-jenis="<?=$value_bb->tarif_mapper_id?>" data-othercid="<?=$value_bb->id?>">Verifikasi</button></td>
                    </tr>
                    <?php
                }
            ?>
            
          </tbody>
        </table>
      </div>
      <!-- tab Belum bayar -->
      <div class="tab-pane fade show" id="belum-bayar" role="tabpanel" aria-labelledby="tab-belum_bayar">
        <table id="dtbl-belum-bayar" class="table table-bordered table-hover table-striped w-100 table-verifikasi">
          <thead class="align-middle text-center">
            <tr>
              <th>No</th>
              <th>NAMA USAHA</th>
              <th>PERIODE (Bulan)</th>
              <th>NOMINAL</th>
              <th>KETERANGAN</th>
              <th>BUKTI BAYAR</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php
                foreach ($belum_bayar as $key_bb => $value_bb) {
                    ?>
                    <tr>
                        <td><?=$key_bb+1?></td>
                        <td id="bb-nama-usaha_<?=$key_bb?>"><?=$value_bb->nama_usaha?></td>
                        <td id="bb-awal_<?=$key_bb?>" style="text-align:center"><?=$value_bb->periode." <br>(".$value_bb->awal." s/d ".$value_bb->akhir," )"?></td>
                        <td id="bb-nominal_<?=$key_bb?>"><?=$value_bb->nominal?></td>
                        <td>Pembayaran dilakukan pada tanggal <?=$value_bb->tanggal_bayar?></td>
                        <td><?=$value_bb->bukti_bayar?></td>
                        <td><button class="btn btn-sm btn-primary btn-verifikasi" data-kode="bb" data-nomor="<?=$key_bb?>" data-awal="<?=$value_bb->awal?>" data-periode="<?=$value_bb->periode?>" data-jenis="<?=$value_bb->tarif_mapper_id?>" data-othercid="<?=$value_bb->id?>">Verifikasi</button></td>
                    </tr>
                    <?php
                }
            ?>
            
          </tbody>
        </table>
      </div>
       <!-- tab sudah verifikasi -->
       <div class="tab-pane fade show" id="sudah-verif" role="tabpanel" aria-labelledby="tab-sudah_verif">
        <table id="dtbl-sudah-verif" class="table table-bordered table-hover table-striped w-100 table-verifikasi">
        <thead class="align-middle text-center">
            <tr>
              <th>No</th>
              <th>NAMA USAHA</th>
              <th>PERIODE (Bulan)</th>
              <th>NOMINAL</th>
              <th>KETERANGAN</th>
              <th>BUKTI BAYAR</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php
                foreach ($sudah_verif as $key_bb => $value_bb) {
                    ?>
                    <tr>
                        <td><?=$key_bb+1?></td>
                        <td id="sv-nama-usaha_<?=$key_bb?>"><?=$value_bb->nama_usaha?></td>
                        <td id="sv-awal_<?=$key_bb?>" style="text-align:center"><?=$value_bb->periode." <br>(".$value_bb->awal." s/d ".$value_bb->akhir," )"?></td>
                        <td id="sv-nominal_<?=$key_bb?>"><?=$value_bb->nominal?></td>
                        <td>Pembayaran dilakukan pada tanggal <?=$value_bb->tanggal_bayar?></td>
                        <td><?=$value_bb->bukti_bayar?></td>
                        <td><button class="btn btn-sm btn-primary btn-verifikasi" data-kode="sv" data-nomor="<?=$key_bb?>" data-awal="<?=$value_bb->awal?>" data-periode="<?=$value_bb->periode?>" data-jenis="<?=$value_bb->tarif_mapper_id?>" data-othercid="<?=$value_bb->id?>">Renew</button></td>
                    </tr>
                    <?php
                }
            ?>
            
          </tbody>
        </table>
      </div>
       <!-- tab expired -->
       <div class="tab-pane fade show" id="expired" role="tabpanel" aria-labelledby="tab-expired">
        <table id="dtbl-expired" class="table table-bordered table-hover table-striped w-100 table-verifikasi">
        <thead class="align-middle text-center">
            <tr>
              <th>No</th>
              <th>NAMA USAHA</th>
              <th>PERIODE (Bulan)</th>
              <th>NOMINAL</th>
              <th>KETERANGAN</th>
              <th>BUKTI BAYAR</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php
                foreach ($expired as $key_bb => $value_bb) {
                    ?>
                    <tr>
                        <td><?=$key_bb+1?></td>
                        <td id="ex-nama-usaha_<?=$key_bb?>"><?=$value_bb->nama_usaha?></td>
                        <td id="ex-awal_<?=$key_bb?>" style="text-align:center"><?=$value_bb->periode." <br>(".$value_bb->awal." s/d ".$value_bb->akhir," )"?></td>
                        <td id="ex-nominal_<?=$key_bb?>"><?=$value_bb->nominal?></td>
                        <td>Pembayaran dilakukan pada tanggal <?=$value_bb->tanggal_bayar?></td>
                        <td><?=$value_bb->bukti_bayar?></td>
                        <td><button class="btn btn-sm btn-primary btn-verifikasi" data-kode="ex" data-nomor="<?=$key_bb?>" data-awal="<?=$value_bb->awal?>" data-periode="<?=$value_bb->periode?>" data-jenis="<?=$value_bb->tarif_mapper_id?>" data-othercid="<?=$value_bb->id?>">Renew</button></td>
                    </tr>
                    <?php
                }
            ?>
            
          </tbody>
        </table>
      </div>
  <!-- /.card -->
</div>



<div class="modal fade" id="verifikasiModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Verifikasi</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="frm-verifikasi">
            <input type="hidden" id="other-cid" name="other_cid">
            <div class="form-group">
                <label for="nama_usaha" class="col-form-label">Recipient:</label>
                <input type="text" class="form-control" id="nama-usaha" name="nama_usaha">
            </div>
            <div class="form-group">
                <label for="awal" class="col-form-label">Awal:</label>
                <input type="date" class="form-control" id="awal" name="awal">
            </div>
            <div class="form-row">
                <div class="form-group col-4">
                <label for="periode" class="col-form-label">Periode:</label>
                <input type="number" class="form-control" id="periode" name="periode">
            </div>
            <div class="form-group col-4">
                    <select name="jenis-periode" id="jenis" class="form-control" style="margin-top:39px">
                        <option value="1__12">Tahun</option>
                        <option value="2__1">Bulan</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="nominal" class="col-form-label">Nominal:</label>
                <input type="text" class="form-control" id="nominal" name="nominal" readonly>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            <input type="submit" class="btn btn-primary" value="Simpan">
        </div>
    </form>
    </div>
  </div>
</div>

<script>

    $('#frm-verifikasi').submit(function(e){
        e.preventDefault();
        $.ajax({
            type:"POST",
            url:`<?=base_url()?>verifikasi`,
            data:$(this).serialize(),
            dataType:"json",
            success:function(r){
              if (r.status==1) {
                // console.log(r) 
                location.reload()
              }
            }
        })
    })

  $('.table-verifikasi').on('click','.btn-verifikasi',function(){
    let kode=$(this).data('kode');
    let nomor=$(this).data('nomor');
    let nama_usaha=$('#'+kode+"-nama-usaha_"+nomor).text();
    let awal=$(this).data('awal');
    let periode=$(this).data('periode');
    let nominal=$('#'+kode+"-nominal_"+nomor).text();
    let jenis=$(this).data('jenis');
    let other_cid=$(this).data('othercid');
    

    $('#nama-usaha').val(nama_usaha);
    $('#awal').val(awal);
    $('#periode').val(periode);
    $('#nominal').val(nominal);
    $('#other-cid').val(other_cid);
    if(jenis==1){
        $('#jenis option[value=1__12]').attr('selected','selected');
    }else{
        $('#jenis option[value=2__1]').attr('selected','selected');
    }
    // alert('#'+kode+"_nama-usaha_"+nomor);
    $('#verifikasiModal').modal('show');
  })
  $(function() {
    $('#dtbl-belum-verif').DataTable({
    //   "processing": true,
    //   "serverSide": true,
    //   "responsive": true,
    //   "order": [],
    //   "ajax": {
    //     "url": `<?= base_url() ?>getkontrak/aktif`,
    //     "type": "POST",
    //     'data': {}
    //   },
    //   "columnDefs": [{
    //       "targets": [0, 1, 4, 5, 7, 8],
    //       "className": "text-center",
    //     },
    //     {
    //       "targets": [6],
    //       "className": "text-body-right"
    //     }
    //   ],
    });

    $('#dtbl-belum-bayar').DataTable({});
    $('#dtbl-sudah-verif').DataTable({});
    $('#dtbl-expired').DataTable({});
  });
</script>

<?= $this->endSection() ?>