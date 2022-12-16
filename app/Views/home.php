<?= $this->extend('layouts/index') ?>
<?= $this->section('content') ?>
<div class="row">
  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-warning">
      <div class="inner">
        <h3><?= $user['user mp'] ?> User</h3>

        <p>User MisterKong</p>
      </div>
      <div class="icon">
        <i class="ion ion-person-add"></i>
      </div>
      <a href="<?= base_url('market') ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-success">
      <div class="inner">
        <h3><?= $user['user pos'] ?> User</h3>

        <p>User KongPos</p>
      </div>
      <div class="icon">
        <i class="ion ion-bag"></i>
      </div>
      <a href="<?= base_url('pos') ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-info">
      <div class="inner">
        <h3><?= $user['user rider'] ?> User</h3>

        <p>User KongRider</p>
      </div>
      <div class="icon">
        <i class="ion ion-speedometer"></i>
      </div>
      <a href="<?= base_url('rider') ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-danger">
      <div class="inner">
        <h3><?= $user['barang'] ?></h3>

        <p>Jumlah Produk</p>
      </div>
      <div class="icon">
        <i class="ion ion-pie-graph"></i>
      </div>
      <a href="<?= base_url('pos/barang') ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
</div>

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-body">
        <div class="mb-3">
          <div class="form-group">
            <label for="cari-lokasi" class="control-label">Cari Lokasi</label>
            <input type="text" id="cari-lokasi" class="form-control" placeholder="misal: Mataram Mall" onclick="this.select()">
          </div>
        </div>
        <div id="map" class="border-2" style="width: 100%; height: 500px;"></div>
        <textarea id="lokasi" class="form-control mt-3" readonly></textarea>
        <input id="distance" class="form-control mt-3" readonly>
      </div>
    </div>
  </div>
</div>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDEdu-jKgoBzPlCtin84i5W8fUb7dHE0Xs&callback=initMap&libraries=places&v=weekly" async></script>
<script>
  const position = {
    lat: -8.5970823,
    lng: 116.1004891
  }

  const mapIconR = "<?= base_url() ?>/assets/delivery.png"
  const mapIconD = "<?= base_url() ?>/assets/car.png"
  const mapIconDB = "<?= base_url() ?>/assets/taxi.png"

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
    setInterval(function() {
      const coords = [
      <?php foreach ($posisi as $key => $value) : ?>[<?= $value->loc_lat ?? -8.5970823 ?>, <?= $value->loc_lng ?? 116.1004891 ?>, <?= $value->kd_jenis_kendaraan ?>],
      <?php endforeach; ?>
    ]
    coords.forEach((el) => {
      const posisi = {
        lat: el[0],
        lng: el[1]
      }
      const picon = el[2];
      if (picon == 1) {
        icon = mapIconR
      } else {
        if (picon == 2) {
          icon = mapIconD
        } else {
          icon = mapIconDB
        }

      }
      console.log(posisi)
      const marker = new google.maps.Marker({
        position: posisi,
        map,
        icon: icon,
      })
    });
  }, 15000);
    console.log(coords)

  }

  function currentPosition(location) {
    const geocoder = new google.maps.Geocoder();
    geocoder
      .geocode({
        location
      })
      .then((response) => {
        if (response.results[0]) {
          document.querySelector('#lokasi').value = response.results[0].formatted_address
          document.querySelector('#cari-lokasi').value = response.results[0].formatted_address
          getDistance(location)
        } else {
          window.alert("No results found");
        }
      })
      .catch((e) => window.alert("Geocoder failed due to: " + e));
  }

  function initAutocomplete(map, marker) {

    const input = document.querySelector("#cari-lokasi");
    const searchBox = new google.maps.places.SearchBox(input);

    map.addListener("bounds_changed", () => {
      searchBox.setBounds(map.getBounds());
    });

    searchBox.addListener("places_changed", () => {
      const places = searchBox.getPlaces();


      if (places.length == 0) {
        return;
      }

      // marker.setMap(null)

      const bounds = new google.maps.LatLngBounds();

      places.forEach(place => {
        if (!place.geometry || !place.geometry.location) {
          console.log("Returned place contains no geometry");
          return;
        }

        marker.setPosition(place.geometry.location)

        if (place.geometry.viewport) {
          // Only geocodes have viewport.
          bounds.union(place.geometry.viewport);
        } else {
          bounds.extend(place.geometry.location);
        }


        currentPosition(place.geometry.location)

      });

      map.fitBounds(bounds);
    })
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

<?= $this->endSection() ?>