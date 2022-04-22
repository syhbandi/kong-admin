<?= $this->extend('layouts/index'); ?>
<?= $this->section('content'); ?>
<div class="card">
  <div class="card-header d-flex align-items-center">
    <h3 class="card-title">Data Lengkap Company (<?= $pos['Nama Usaha'] ?>)</h3>
    <div class="ml-auto ">
    <button class="btn btn-default" onclick="window.history.back()"><i class="fas fa-arrow-left mr-1"></i>Batal</button>
      <button class="btn btn-warning perbaikan <?= $status == 1 ? 'd-none' : '' ?>"><i class="fas fa-reply-all mr-1"></i> Ajukan Perbaikan</button>
      <button class="btn btn-primary verifikasi <?= $status == 1 ? 'd-none' : '' ?>"><i class="fas fa-check-circle mr-1"></i> Verifikasi</button>
      <button class="btn btn-danger nonaktif <?= $status == 0 ? 'd-none' : '' ?>"><i class="fas fa-times-circle mr-1"></i> Banned</button>
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