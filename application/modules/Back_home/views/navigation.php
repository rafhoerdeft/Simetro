<!-- ============================================================== -->
<!-- Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->
<aside class="left-sidebar">
  <!-- Sidebar scroll-->
  <div class="scroll-sidebar">
    <!-- User profile -->
    <div class="user-profile">
      <?php
      $username = $this->session->userdata('username');
      $namaUser = $this->session->userdata('nama_user');
      $first = substr($namaUser, 0, 1);
      $label = strtoupper($first);
      ?>
      <!-- User profile image -->
      <div class="profile-img"> <img src="<?= base_url() ?>assets/assets/images/icon-profil/<?= $label ?>.jpg" alt="user" />
        <!-- this is blinking heartbit-->
        <!-- <div class="notify setpos"> <span class="heartbit"></span> <span class="point"></span> </div> -->
      </div>
      <!-- User profile text-->
      <div class="profile-text">
        <h5><?= ucfirst($namaUser) ?></h5>
        <a href="#" class="dropdown-toggle u-dropdown" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"><i class="fa fa-spin fa-gear"></i></a>
        <!-- <a href="app-email.html" class="" data-toggle="tooltip" title="Email"><i class="mdi mdi-gmail"></i></a> -->
        <a href="<?= base_url() ?>Auth/logout" class="" data-toggle="tooltip" title="Logout"><i class="mdi mdi-power"></i></a>
        <div class="dropdown-menu animated flipInY">
          <!-- text-->
          <a href="<?= base_url() ?>User/profil" class="dropdown-item"><i class="ti-user"></i> Profil</a>
          <!-- text-->
          <a href="<?= base_url() ?>User/akunLogin" class="dropdown-item"><i class="ti-lock"></i> Akun Login</a>
          <!-- text-->
          <!-- <a href="#" class="dropdown-item"><i class="ti-email"></i> Inbox</a> -->
          <!-- text-->
          <!-- <div class="dropdown-divider"></div> -->
          <!-- text-->
          <!-- <a href="#" class="dropdown-item"><i class="ti-settings"></i> Account Setting</a> -->
          <!-- text-->
          <!-- <div class="dropdown-divider"></div> -->
          <!-- text-->
          <!-- <a href="<? //= base_url() 
                        ?>Auth/logout" class="dropdown-item"><i class="fa fa-power-off"></i> Logout</a> -->
          <!-- text-->
        </div>
      </div>
    </div>
    <!-- End User profile text-->
    <!-- Sidebar navigation-->
    <nav class="sidebar-nav">
      <ul id="sidebarnav">
        <li class="nav-devider"></li>
        <li class="nav-small-cap">MENU</li>
        <li class="<?= ($menu == 'carousel' ? 'active' : '') ?>">
          <a class="waves-effect <?= ($menu == 'carousel' ? 'active' : '') ?>" href="<?= base_url() ?>Back_home/" aria-expanded="false">
            <i class="mdi mdi-account-card-details"></i>
            <span class="hide-menu">Carousel</span>
          </a>
        </li>
        <li class="<?= ($menu == 'profile' ? 'active' : '') ?>">
          <a class="waves-effect <?= ($menu == 'profile' ? 'active' : '') ?>" href="<?= base_url() ?>Back_home/profile" aria-expanded="false">
            <i class="mdi mdi-face-profile"></i>
            <span class="hide-menu">Profile</span>
          </a>
        </li>
        <li class="<?= ($menu == 'berita' ? 'active' : '') ?>">
          <a class="waves-effect <?= ($menu == 'berita' ? 'active' : '') ?>" href="<?= base_url() ?>Back_home/berita" aria-expanded="false">
            <i class="mdi mdi-newspaper"></i>
            <span class="hide-menu">Berita</span>
          </a>
        </li>
        <li class="<?= ($menu == 'pengumuman' ? 'active' : '') ?>">
          <a class="waves-effect <?= ($menu == 'pengumuman' ? 'active' : '') ?>" href="<?= base_url() ?>Back_home/pengumuman" aria-expanded="false">
            <i class="fa fa-bullhorn"></i>
            <span class="hide-menu">Pengumuman</span>
          </a>
        </li>
        <li class="<?= ($menu == 'maklumat' ? 'active' : '') ?>">
          <a class="waves-effect <?= ($menu == 'maklumat' ? 'active' : '') ?>" href="<?= base_url() ?>Back_home/maklumat" aria-expanded="false">
            <i class="mdi mdi-clipboard-text"></i>
            <span class="hide-menu">Maklumat</span>
          </a>
        </li>

      </ul>
    </nav>
    <!-- End Sidebar navigation -->
  </div>
  <!-- End Sidebar scroll-->
</aside>
<!-- ============================================================== -->
<!-- End Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->