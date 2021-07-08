
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
                    <div class="profile-img"> <img src="<?= base_url() ?>assets/assets/images/icon-profil/<?=$label?>.jpg" alt="user" />
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
                            <a href="<?= base_url() ?>Petugas/profil" class="dropdown-item"><i class="ti-user"></i> Profil</a>
                            <!-- text-->
                            <a href="<?= base_url() ?>Petugas/akunLogin" class="dropdown-item"><i class="ti-lock"></i> Akun Login</a>
                            <!-- text-->
                            <!-- <a href="#" class="dropdown-item"><i class="ti-email"></i> Inbox</a> -->
                            <!-- text-->
                            <!-- <div class="dropdown-divider"></div> -->
                            <!-- text-->
                            <!-- <a href="#" class="dropdown-item"><i class="ti-settings"></i> Account Setting</a> -->
                            <!-- text-->
                            <!-- <div class="dropdown-divider"></div> -->
                            <!-- text-->
                            <!-- <a href="<?//= base_url() ?>Auth/logout" class="dropdown-item"><i class="fa fa-power-off"></i> Logout</a> -->
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
                        <li class="<?= ($menu == 'dashboard'?'active':'') ?>"> 
                            <a class="waves-effect <?= ($menu == 'dashboard'?'active':'') ?>" href="<?= base_url() ?>Admin" aria-expanded="false">
                                <i class="mdi mdi-gauge"></i>
                                <span class="hide-menu">Dashboard</span>
                            </a>
                        </li>
                        <li class="<?= ($menu == 'laporan'?'active':'') ?>"> 
                            <a class="waves-effect <?= ($menu == 'laporan'?'active':'') ?>" href="<?= base_url() ?>Petugas/laporan" aria-expanded="false">
                                <i class="mdi mdi-file-document"></i>
                                <span class="hide-menu">Laporan</span>
                            </a>
                        </li>
                        <!-- <li class="<?//= ($menu == 'tera'?'active':'') ?>"> 
                            <a class="waves-effect <?//= ($menu == 'tera'?'active':'') ?>" href="<?//= base_url() ?>Petugas/dataTera" aria-expanded="false">
                                <i class="mdi mdi-scale-balance"></i>
                                <span class="hide-menu">Tera UTTP</span>
                            </a>
                        </li> -->
                        <li> 
                            <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                                <i class="mdi mdi-scale-balance"></i>
                                <span class="hide-menu">Tera UTTP 
                                    <!-- <span class="label label-rouded label-themecolor pull-right">4</span> -->
                                </span>
                            </a>
                            <ul aria-expanded="false" class="collapse">
                                <li>
                                    <a class="<?= ($menu == 'tera_baru'?'active':'') ?>" href="<?= base_url() ?>Petugas/pendaftaranTera">
                                        Tera Baru
                                    </a>
                                </li>
                                <li>
                                    <a class="<?= ($menu == 'tera'?'active':'') ?>" href="<?= base_url() ?>Petugas/dataTera">
                                        Data Tera 
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="<?= ($menu == 'pengajuan_tera'?'active':'') ?>"> 
                            <a class="waves-effect <?= ($menu == 'pengajuan_tera'?'active':'') ?>" href="<?= base_url() ?>Petugas/pengajuanMasuk" aria-expanded="false">
                                <i class="mdi mdi-login"></i>
                                <span class="hide-menu">Pengajuan Masuk</span>
                            </a>
                        </li>
                        <li class="<?= ($menu == 'hasil_uji'?'active':'') ?>"> 
                            <a class="waves-effect <?= ($menu == 'hasil_uji'?'active':'') ?>" href="<?= base_url() ?>Petugas/hasilPengujian" aria-expanded="false">
                                <i class="mdi mdi-file-multiple"></i>
                                <span class="hide-menu">Hasil Pengujian</span>
                            </a>
                        </li>
                        <!-- <li class="<?//= ($menu == 'kategori_alat'?'active':'') ?>"> 
                            <a class="waves-effect <?//= ($menu == 'kategori_alat'?'active':'') ?>" href="<?//= base_url() ?>Petugas/kategoriAlat" aria-expanded="false">
                                <i class="mdi mdi-scale"></i>
                                <span class="hide-menu">Kategori Alat</span>
                            </a>
                        </li>
                        <li class="<?//= ($menu == 'jenis_alat'?'active':'') ?>"> 
                            <a class="waves-effect <?//= ($menu == 'jenis_alat'?'active':'') ?>" href="<?//= base_url() ?>Petugas/jenisAlat" aria-expanded="false">
                                <i class="mdi mdi-scale-bathroom"></i>
                                <span class="hide-menu">Jenis Alat</span>
                            </a>
                        </li>
                        <li class="<?//= ($menu == 'tarif'?'active':'') ?>"> 
                            <a class="waves-effect <?//= ($menu == 'tarif'?'active':'') ?>" href="<?//= base_url() ?>Petugas/dataTarif" aria-expanded="false">
                                <i class="mdi"><b>Rp</b></i>
                                <span class="hide-menu">Tarif Retribusi</span>
                            </a>
                        </li>
                        <li class="<?//= ($menu == 'kelompok_tarif'?'active':'') ?>"> 
                            <a class="waves-effect <?//= ($menu == 'kelompok_tarif'?'active':'') ?>" href="<?//= base_url() ?>Petugas/kelompokTarif" aria-expanded="false">
                                <i class="fa fa-money"></i>
                                <span class="hide-menu">Kelompok Tarif</span>
                            </a>
                        </li>
                        <li class="<?//= ($menu == 'usaha'?'active':'') ?>"> 
                            <a class="waves-effect <?//= ($menu == 'usaha'?'active':'') ?>" href="<?//= base_url() ?>Petugas/jenisUsaha" aria-expanded="false">
                                <i class="mdi mdi-briefcase-check"></i>
                                <span class="hide-menu">Jenis Usaha</span>
                            </a>
                        </li>
                        <li class="<?//= ($menu == 'pasar'?'active':'') ?>"> 
                            <a class="waves-effect <?//= ($menu == 'pasar'?'active':'') ?>" href="<?//= base_url() ?>Petugas/dataPasar" aria-expanded="false">
                                <i class="mdi mdi-hospital-building"></i>
                                <span class="hide-menu">Data Pasar</span>
                            </a>
                        </li>
                        <li class="<?//= ($menu == 'kelompok_pasar'?'active':'') ?>"> 
                            <a class="waves-effect <?//= ($menu == 'kelompok_pasar'?'active':'') ?>" href="<?//= base_url() ?>Petugas/kelompokPasar" aria-expanded="false">
                                <i class="mdi mdi-shopping"></i>
                                <span class="hide-menu">Kelompok Pasar</span>
                            </a>
                        </li> -->
                        <!-- <li class="<?//= ($menu == 'user'?'active':'') ?>"> 
                            <a class="waves-effect <?//= ($menu == 'user'?'active':'') ?>" href="<?//= base_url() ?>Petugas/dataUser" aria-expanded="false">
                                <i class="mdi mdi-account-box"></i>
                                <span class="hide-menu">Data User</span>
                            </a>
                        </li>
                        <li class="<?//= ($menu == 'petugas'?'active':'') ?>"> 
                            <a class="waves-effect <?//= ($menu == 'petugas'?'active':'') ?>" href="<?//= base_url() ?>Petugas/dataPetugas" aria-expanded="false">
                                <i class="mdi mdi-account-card-details"></i>
                                <span class="hide-menu">Data Petugas</span>
                            </a>
                        </li> -->

                        <li> 
                            <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                                <i class="mdi mdi-database"></i>
                                <span class="hide-menu">Master Data 
                                    <!-- <span class="label label-rouded label-themecolor pull-right">4</span> -->
                                </span>
                            </a>
                            <ul aria-expanded="false" class="collapse">
                                <li>
                                    <a class="<?= ($menu == 'user'?'active':'') ?>" href="<?= base_url() ?>Petugas/dataUser">
                                        <!-- <i class="mdi mdi-account-box"></i> --> Data Pemilik Usaha 
                                    </a>
                                </li>
                                <li>
                                    <a class="<?= ($menu == 'petugas'?'active':'') ?>" href="<?= base_url() ?>Petugas/dataPetugas">
                                        <!-- <i class="mdi mdi-account-card-details"></i> --> Data Petugas
                                    </a>
                                </li>
                                <li>
                                    <a class="<?= ($menu == 'kategori_alat'?'active':'') ?>" href="<?= base_url() ?>Petugas/kategoriAlat">
                                        <!-- <i class="mdi mdi-scale"></i> --> Kategori Alat
                                    </a>
                                </li>
                                <li>
                                    <a class="<?= ($menu == 'jenis_alat'?'active':'') ?>" href="<?= base_url() ?>Petugas/jenisAlat">
                                        <!-- <i class="mdi mdi-scale-bathroom"></i> --> Jenis Alat
                                    </a>
                                </li>
                                <li>
                                    <a class="<?= ($menu == 'tarif'?'active':'') ?>" href="<?= base_url() ?>Petugas/dataTarif">
                                        <!-- <i class="mdi"><b>Rp</b></i> --> Tarif Retribusi
                                    </a>
                                </li>
                                <li>
                                    <a class="<?= ($menu == 'kelompok_tarif'?'active':'') ?>" href="<?= base_url() ?>Petugas/kelompokTarif">
                                        <!-- <i class="fa fa-money"></i> --> Kelompok Tarif
                                    </a>
                                </li>
                                <li>
                                    <a class="<?= ($menu == 'usaha'?'active':'') ?>" href="<?= base_url() ?>Petugas/jenisUsaha">
                                        <!-- <i class="mdi mdi-briefcase-check"></i> --> Jenis Usaha
                                    </a>
                                </li>
                                <li>
                                    <a class="<?= ($menu == 'pasar'?'active':'') ?>" href="<?= base_url() ?>Petugas/dataPasar">
                                        <!-- <i class="mdi mdi-hospital-building"></i> --> Data Pasar
                                    </a>
                                </li>
                                <li>
                                    <a class="<?= ($menu == 'kelompok_pasar'?'active':'') ?>" href="<?= base_url() ?>Petugas/kelompokPasar">
                                        <!-- <i class="mdi mdi-shopping"></i> --> Kelompok Pasar
                                    </a>
                                </li>
                            </ul>
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