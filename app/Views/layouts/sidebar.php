<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="index3.html" class="brand-link">
    <img src="<?= base_url() ?>/assets/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: 0.8" />
    <span class="brand-text font-weight-light">KONG Admin</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="<?= base_url() ?>/assets/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image" />
      </div>
      <div class="info">
        <a href="#" class="d-block"><?= session()->get('nama') ?? 'Anonymous' ?></a>
      </div>
    </div>

    <!-- SidebarSearch Form -->
    <div class="form-inline">
      <div class="input-group" data-widget="sidebar-search">
        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search" />
        <div class="input-group-append">
          <button class="btn btn-sidebar">
            <i class="fas fa-search fa-fw"></i>
          </button>
        </div>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
          <a href="<?= base_url() ?>" class="nav-link <?= service('uri')->getPath() == '/' ? 'active' : '' ?>">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Beranda
            </p>
          </a>
        </li>
        <li class="nav-item <?= service('uri')->getSegment(1) == 'market' ? 'menu-open' : '' ?>">
          <a href="#" class="nav-link <?= service('uri')->getSegment(1) == 'market' ? 'active' : '' ?>">
            <i class="nav-icon fas fa-user"></i>
            <p>
              Mister Kong User
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?= base_url('market') ?>" class="nav-link <?= service('uri')->getPath() == 'market' ? 'active' : '' ?>">
                <i class="nav-icon fas fa-user-check"></i>
                <p>Data User</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item <?= service('uri')->getSegment(1) == 'rider' ? 'menu-open' : '' ?>">
          <a href="#" class="nav-link <?= service('uri')->getSegment(1) == 'rider' ? 'active' : '' ?>">
            <i class="nav-icon fas fa-biking"></i>
            <p>
              Rider
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?= base_url('rider') ?>" class="nav-link <?= service('uri')->getPath() == 'rider' ? 'active' : '' ?>">
                <i class="nav-icon fas fa-user-check"></i>
                <p>Data Rider</p>
              </a>
            </li>
            <li class="nav-item ">
              <a href="<?= base_url('rider/top-up') ?>" class="nav-link <?= service('uri')->getPath() == 'rider/top-up' ? 'active' : '' ?>">
                <i class="nav-icon fas fa-money-check"></i>
                <p>Top Up Saldo</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= base_url('rider/pencairan') ?>" class="nav-link <?= service('uri')->getPath() == 'rider/pencairan' ? 'active' : '' ?>">
                <i class="nav-icon fas fa-hand-holding-usd"></i>
                <p>Pencairan Saldo</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= base_url('rider/pengajuan-kendaraan') ?>" class="nav-link <?= service('uri')->getPath() == 'rider/pengajuan-kendaraan' ? 'active' : '' ?>">
                <i class="nav-icon fas fa-motorcycle"></i>
                <p>Pengajuan Kendaraan</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item <?= service('uri')->getSegment(1) == 'pos' ? 'menu-open' : '' ?>">
          <a href="#" class="nav-link <?= service('uri')->getSegment(1) == 'pos' ? 'active' : '' ?>">
            <i class="nav-icon fas fa-store-alt"></i>
            <p>
              POS
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?= base_url('pos') ?>" class="nav-link <?= service('uri')->getPath() == 'pos' ? 'active' : '' ?>">
                <i class="nav-icon fas fa-user-check"></i>
                <p>Data Toko</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= base_url('pos/pencairan') ?>" class="nav-link <?= service('uri')->getPath() == 'pos/pencairan' ? 'active' : '' ?>">
                <i class="nav-icon fas fa-hand-holding-usd"></i>
                <p>Pencairan Toko</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= base_url('pos/barang') ?>" class="nav-link <?= service('uri')->getPath() == 'pos/barang' ? 'active' : '' ?>">
                <i class="nav-icon fas fa-box"></i>
                <p>Data Barang</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item <?= service('uri')->getSegment(1) == 'market' ? 'menu-open' : '' ?>">
          <a href="#" class="nav-link <?= service('uri')->getSegment(1) == 'market' ? 'active' : '' ?>">
            <i class="nav-icon fas fa-shopping-cart"></i>
            <p>
              Transaksi
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?= base_url('market') ?>" class="nav-link <?= service('uri')->getPath() == 'market' ? 'active' : '' ?>">
                <i class="nav-icon fas fa-handshake"></i>
                <p>Data Transaksi</p>
              </a>
            </li>
          </ul>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>