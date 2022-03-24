<?= $this->extend('layouts/index'); ?>
<?= $this->section('content'); ?>
<div class="card">
  <div class="card-header d-flex align-items-center">
    <h3 class="card-title">Data Lengkap Company (<?= $pos['Nama Usaha'] ?>)</h3>
    <div class="ml-auto <?= $status == 2 ? 'd-none' : '' ?>">
      <button class="btn btn-default" onclick="window.history.back()"><i class="fas fa-arrow-left mr-1"></i>Batal</button>
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
</script>
<?= $this->endSection(); ?>