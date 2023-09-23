<?= $this->extend('layouts/index'); ?>
<?= $this->section('content'); ?>
<div class="card">
  <div class="card-header d-flex align-items-center">
    <h3 class="card-title">Data Lengkap Company (<?= $pos['Nama Usaha'] ?> )</h3>
    <div class="ml-auto ">
    <button class="btn btn-default" onclick="window.history.back()"><i class="fas fa-arrow-left mr-1"></i>Batal</button>
      <!-- <button class="btn btn-warning perbaikan <?= $status == 1 ? 'd-none' : '' ?>"><i class="fas fa-reply-all mr-1"></i> Ajukan Perbaikan</button> -->
      <button class="btn btn-primary verifikasi <?= $status == 1 ? 'd-none' : '' ?>"><i class="fas fa-check-circle mr-1"></i> Verifikasi</button>
      <button class="btn btn-warning tutup <?= $status == 0 ? 'd-none' : '' ?>"><i class="fas fa-eye-slash mr-1"></i> Tutup</button>
      <button class="btn btn-danger nonaktif <?= $status == -2 ? 'd-none' : '' ?>"><i class="fas fa-times-circle mr-1"></i> Banned</button>
      <button class="btn btn-info edit <?= $status == 0 ? 'd-none' : '' ?>"><i class="fas fa-edit mr-1"></i> Edit Toko</button>
      <a href="https://wa.me/62<?= substr($pos['No. Hp'], 1) ?>?text=Hallo%20selamat%20pagi/siang/sore.%20Selamat%Anda%20telah%20lulus%20administrasi%20pendataran%20mitra%20rider%20MisterKong.%20Untuk%20tahap%20selanjutnya%20proses%20interview%20melalui%20video%20call%20WA.%20Kami%20akan%20jadwalkan%20waktu%20interview%20Anda%20dengan%20waktu%20sebagai%20berikut:%20
            Hari/Tanggal:%20<?= date('Y-m-d') ?>%20
            Jam:%20<?= date("h:i:sa") ?>%20
            Jika%20Anda%20tidak%20ada%20waktu%20di%20tanggal%20dan%20jam%20tersebut,%20bisa%20mengajukan%20perubahan.%20Terima%20kasih"><button class="btn btn-success chat"><i class="fas fa-arrow-to-top mr-1"></i> Chat User</button></a>
    </div>
  </div>
  <div class="card-body">
    <table class="table table-bordered">
      <?php foreach ($pos as $key => $value) : ?>
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

<div class="modal fade" id="modalEdit" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Katergori Usaha</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= base_url('pos/editkategori') ?>">
        <div class="modal-body">
          <div class="form-group">
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <label class="input-group-text" for="inputGroupSelect01">Options</label>
            </div>
              <select class="custom-select" id="inputGroupSelect01" name="kategori">
                <option selected>Choose...</option>
                <option value="1">Mini Market / Kelontong / Retail</option>
                <option value="2">Makanan dan Minuman</option>
                <option value="3">Butik / Pakaian / Aksesoris dan Penampilan</option>
                <option value="4">Salon dan Barbershop</option>
                <option value="5">Kesehatan dan Kecantikan</option>
                <option value="6">Olahraga dan Hobi</option>
                <option value="7">Makanan Segar</option>
                <option value="8">Vape Store</option>
                <option value="9">Toko Elektronik, Selular, dan Produk Digital</option>
                <option value="10">Lainnya</option>
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

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDEdu-jKgoBzPlCtin84i5W8fUb7dHE0Xs&callback=initMap&libraries=places&v=weekly" async></script>
<script>
  const position = {
    lat: <?= $pos['Lat'] ?>,
    lng: <?= $pos['Lng'] ?>
  }

  function initMap() {
    currentPosition(position)
    const map = new google.maps.Map(document.querySelector('#map'), {
      zoom: 18,
      center: position,
      disableDefaultUI: true,
      mapTypeControl: false,
      streetViewControl: false,
      zoomControl: false,
      gestureHandling: 'auto',
      mapTypeId: "roadmap",
    })
    const mapIcon = "<?= base_url() ?>/assets/dest-icon.svg"
    const marker = new google.maps.Marker({
      position: position,
      map,
      // draggable: true,
      icon: mapIcon,
      anchorPoint: position,
      // animation: google.maps.Animation.DROP,
    })

    map.addListener('drag', function() {
      marker.setPosition(this.getCenter())
    })

    map.addListener('dragend', function() {
      currentPosition(this.getCenter())
    })

    initAutocomplete(map, marker)

  }

  function currentPosition(location) {
    const geocoder = new google.maps.Geocoder();
    geocoder
      .geocode({
        location
      })
      .catch((e) => window.alert("Geocoder failed due to: " + e));
  }

  function getDistance(destination) {
    const origin = new google.maps.LatLng(-8.596052, 116.1057177)
    let service = new google.maps.DistanceMatrixService();
    service.getDistanceMatrix({
      origins: [origin],
      destinations: [destination],
      travelMode: 'DRIVING',
      // transitOptions: TransitOptions,
      // drivingOptions: DrivingOptions,
      // unitSystem: UnitSystem,
      // avoidHighways: Boolean,
      // avoidTolls: Boolean,
    }, (response, status) => {
      $('#distance').val(response.rows[0].elements[0].distance.value)
    });
  }
  $('.verifikasi').on('click', () => {
      console.log('<?= $company_id ?>')
      Swal.fire({
        title: 'Verifikasi Yoko?',
        text: "Pastikan sudah cek kelengkapan Data Toko",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Verifikasi',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: '<?= base_url('pos/verivikasiToko') ?>',
            type: 'POST',
            data: {
              status: 'aktif',
              company_id: '<?= $company_id ?>'
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

    $('.tutup').on('click', () => {
      console.log('<?= $company_id ?>')
      Swal.fire({
        title: 'Tutup Toko?',
        text: "Pastikan Data toko yang tutup benar",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Tutup',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: '<?= base_url('pos/verivikasiToko') ?>',
            type: 'POST',
            data: {
              status: 'tutup',
              company_id: '<?= $company_id ?>'
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

    $('.nonaktif').on('click', () => {
      console.log('<?= $company_id ?>')
      Swal.fire({
        title: 'Baned Toko?',
        text: "Pastikan Pengguna melakukan kesalahan",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'nonaktif',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: '<?= base_url('pos/verivikasiToko') ?>',
            type: 'POST',
            data: {
              status: 'Banned',
              company_id: '<?= $company_id ?>'
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
      var h = document.getElementById("inputGroupSelect01");
      const formData = new FormData($(document.getElementById("inputGroupSelect01")).value);
      formData.append('company_id', '<?= $company_id ?>');

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
    
    $('.edit').on('click', () => {
      $('#modalEdit').modal('show');
    })

    $('form').on('submit', function(e) {
      e.preventDefault();
      const formData = new FormData($(this)[0]);
      formData.append('company_id', '<?= $company_id ?>');

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