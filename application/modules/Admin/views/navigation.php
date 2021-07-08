

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

                            <a href="<?= base_url() ?>Admin/profil" class="dropdown-item"><i class="ti-user"></i> Profil</a>

                            <!-- text-->

                            <a href="<?= base_url() ?>Admin/akunLogin" class="dropdown-item"><i class="ti-lock"></i> Akun Login</a>

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

                        <!-- <li class="<?= ($menu == 'laporan'?'active':'') ?>"> 

                            <a class="waves-effect <?= ($menu == 'laporan'?'active':'') ?>" href="<?= base_url() ?>Admin/laporan" aria-expanded="false">

                                <i class="mdi mdi-file-document"></i>

                                <span class="hide-menu">Laporan</span>

                            </a>

                        </li> -->

                        <li> 

                            <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">

                                <i class="mdi mdi-file-document"></i>

                                <span class="hide-menu">Laporan 

                                    <!-- <span class="label label-rouded label-themecolor pull-right">4</span> -->

                                </span>

                            </a>

                            <ul aria-expanded="false" class="collapse">

                                <li>
                                    <a class="<?= ($menu == 'laporan'?'active':'') ?>" href="<?= base_url() ?>Admin/lapSetoran">
                                        Setoran
                                    </a>
                                </li>

                                <li>
                                    <a class="<?= ($menu == 'lap_sidang_tera'?'active':'') ?>" href="<?= base_url() ?>Admin/lapSidangTera">
                                        Sidang Tera
                                    </a>
                                </li>

                                <li>
                                    <a class="<?= ($menu == 'tera_ulang_sidang'?'active':'') ?>" href="<?= base_url() ?>Admin/lapTeraUlangSidang">
                                        Tera Ulang Pasar
                                    </a>
                                </li>


                                <li>
                                    <a class="<?= ($menu == 'tera_ulang_kantor'?'active':'') ?>" href="<?= base_url() ?>Admin/lapTeraUlangKantor">
                                        Tera Ulang Kantor
                                    </a>
                                </li>


                                <li>
                                    <a class="<?= ($menu == 'tera_ulang_loco'?'active':'') ?>" href="<?= base_url() ?>Admin/lapTeraUlangLoco">
                                        Tera Ulang Loco
                                    </a>
                                </li>

                               <!--  <li>
                                    <a class="<?= ($menu == 'reg_sidang'?'active':'') ?>" href="<?= base_url() ?>Admin/lapRegisterSidang">
                                        Register Sidang Tera
                                    </a>
                                </li> -->

                                <li>
                                    <a class="<?= ($menu == 'pad'?'active':'') ?>" href="<?= base_url() ?>Admin/lapPad">
                                        PAD Tera
                                    </a>
                                </li>

                                <!-- <li>
                                    <a class="<?= ($menu == 'rincianPad'?'active':'') ?>" href="<?= base_url() ?>Admin/lapRincianPad">
                                        Rincian PAD Tera
                                    </a>
                                </li> -->

                            </ul>

                        </li>

                        <!-- <li class="<?//= ($menu == 'tera'?'active':'') ?>"> 

                            <a class="waves-effect <?//= ($menu == 'tera'?'active':'') ?>" href="<?//= base_url() ?>Admin/dataTera" aria-expanded="false">

                                <i class="mdi mdi-scale-balance"></i>

                                <span class="hide-menu">Tera UTTP</span>

                            </a>

                        </li> -->

                        <li> 

                            <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">

                                <i class="mdi mdi-pencil-box"></i>

                                <span class="hide-menu">Register Tera 

                                    <!-- <span class="label label-rouded label-themecolor pull-right">4</span> -->

                                </span>

                            </a>

                            <ul aria-expanded="false" class="collapse">

                                <li>

                                    <a class="<?= ($menu == 'tera_baru'?'active':'') ?>" href="<?= base_url() ?>Admin/pendaftaranTera">

                                        Pendaftaran Tera

                                    </a>

                                </li>

                                <li>

                                    <a class="<?= ($menu == 'tera'?'active':'') ?>" href="<?= base_url() ?>Admin/dataTera">

                                        Daftar Pengajuan 

                                    </a>

                                </li>

                            </ul>

                        </li>

                        <li> 

                            <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">

                                <i class="mdi mdi-hospital-building"></i>

                                <span class="hide-menu">Sidang Tera 

                                    <!-- <span class="label label-rouded label-themecolor pull-right">4</span> -->

                                </span>

                            </a>

                            <ul aria-expanded="false" class="collapse">

                                <li>

                                    <a class="<?= ($menu == 'sidang_tera'?'active':'') ?>" href="<?= base_url() ?>Admin/tambahListSidang">

                                        Sidang Tera Baru

                                    </a>

                                </li>

                                <li>

                                    <a class="<?= ($menu == 'daftar_sidang'?'active':'') ?>" href="<?= base_url() ?>Admin/dataListSidang">

                                        Daftar Sidang 

                                    </a>

                                </li>

                            </ul>

                        </li>

                        <li class="<?= ($menu == 'pengajuan_tera'?'active':'') ?>"> 

                            <a class="waves-effect <?= ($menu == 'pengajuan_tera'?'active':'') ?>" href="<?= base_url() ?>Admin/pengajuanMasuk" aria-expanded="false">

                                <i class="mdi mdi-login"></i>

                                <span class="hide-menu">

                                    Pengajuan Masuk

                                    <?= ($masuk != 0?'<span class="label label-rouded label-themecolor pull-right" style="min-width: 26px; text-align: center">'.$masuk.'</span>':'') ?>

                                </span>

                            </a>

                        </li>



                        <li> 

                            <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">

                                <i class="mdi mdi-scale-balance"></i>

                                <span class="hide-menu">Pengujian Tera 

                                    <?php $tot_uji=$uji_kantor+$uji_pasar+$uji_pemilik; ?>

                                    <?= ($tot_uji != 0 ?'<span class="label label-rouded label-primary pull-right" style="min-width: 26px; text-align: center">'.$tot_uji.'</span>':'') ?>

                                </span>

                            </a>

                            <ul aria-expanded="false" class="collapse">

                                <li>

                                    <a class="<?= ($menu == 'Kantor_Metrologi'?'active':'') ?>" href="<?= base_url() ?>Admin/pengujianTera/1">

                                        Kantor  

                                        <?= ($uji_kantor != 0 ?'<span class="label label-rouded label-info pull-right" style="min-width: 26px; text-align: center">'.$uji_kantor.'</span>':'') ?>

                                    </a>

                                </li>

                                <!-- <li>

                                    <a class="<?= ($menu == 'Pasar'?'active':'') ?>" href="<?= base_url() ?>Admin/pengujianTera/2">

                                        Pasar

                                        <?= ($uji_pasar != 0?'<span class="label label-rouded label-danger pull-right" style="min-width: 26px; text-align: center">'.$uji_pasar.'</span>':'') ?>

                                    </a>

                                </li> -->

                                <li>

                                    <a class="<?= ($menu == 'Tempat_Pemilik'?'active':'') ?>" href="<?= base_url() ?>Admin/pengujianTera/3">

                                        Loco  

                                        <?= ($uji_pemilik != 0?'<span class="label label-rouded label-inverse pull-right" style="min-width: 26px; text-align: center">'.$uji_pemilik.'</span>':'') ?>

                                    </a>

                                </li>

                                

                            </ul>

                        </li>

                        <li class="<?= ($menu == 'hasil_uji'?'active':'') ?>"> 

                            <a class="waves-effect <?= ($menu == 'hasil_uji'?'active':'') ?>" href="<?= base_url() ?>Admin/hasilPengujian" aria-expanded="false">

                                <i class="mdi mdi-file-multiple"></i>

                                <span class="hide-menu">Hasil Pengujian</span>

                            </a>

                        </li>



                        <li class="<?= ($menu == 'uttp_ulang'?'active':'') ?>"> 

                            <a class="waves-effect <?= ($menu == 'uttp_ulang'?'active':'') ?>" href="<?= base_url() ?>Admin/uttpTeraUlang" aria-expanded="false">

                                <i class="mdi mdi-scale"></i>

                                <span class="hide-menu">UTTP Tera Ulang</span>

                                <?= ($jml_uttp != 0?'<span class="label label-rouded label-success pull-right" style="min-width: 26px; text-align: center">'.$jml_uttp.'</span>':'') ?>

                            </a>

                        </li>



                        <!-- <li class="<?//= ($menu == 'kategori_alat'?'active':'') ?>"> 

                            <a class="waves-effect <?//= ($menu == 'kategori_alat'?'active':'') ?>" href="<?//= base_url() ?>Admin/kategoriAlat" aria-expanded="false">

                                <i class="mdi mdi-scale"></i>

                                <span class="hide-menu">Kategori Alat</span>

                            </a>

                        </li>

                        <li class="<?//= ($menu == 'jenis_alat'?'active':'') ?>"> 

                            <a class="waves-effect <?//= ($menu == 'jenis_alat'?'active':'') ?>" href="<?//= base_url() ?>Admin/jenisAlat" aria-expanded="false">

                                <i class="mdi mdi-scale-bathroom"></i>

                                <span class="hide-menu">Jenis Alat</span>

                            </a>

                        </li>

                        <li class="<?//= ($menu == 'tarif'?'active':'') ?>"> 

                            <a class="waves-effect <?//= ($menu == 'tarif'?'active':'') ?>" href="<?//= base_url() ?>Admin/dataTarif" aria-expanded="false">

                                <i class="mdi"><b>Rp</b></i>

                                <span class="hide-menu">Tarif Retribusi</span>

                            </a>

                        </li>

                        <li class="<?//= ($menu == 'kelompok_tarif'?'active':'') ?>"> 

                            <a class="waves-effect <?//= ($menu == 'kelompok_tarif'?'active':'') ?>" href="<?//= base_url() ?>Admin/kelompokTarif" aria-expanded="false">

                                <i class="fa fa-money"></i>

                                <span class="hide-menu">Kelompok Tarif</span>

                            </a>

                        </li>

                        <li class="<?//= ($menu == 'usaha'?'active':'') ?>"> 

                            <a class="waves-effect <?//= ($menu == 'usaha'?'active':'') ?>" href="<?//= base_url() ?>Admin/jenisUsaha" aria-expanded="false">

                                <i class="mdi mdi-briefcase-check"></i>

                                <span class="hide-menu">Jenis Usaha</span>

                            </a>

                        </li>

                        <li class="<?//= ($menu == 'pasar'?'active':'') ?>"> 

                            <a class="waves-effect <?//= ($menu == 'pasar'?'active':'') ?>" href="<?//= base_url() ?>Admin/dataPasar" aria-expanded="false">

                                <i class="mdi mdi-hospital-building"></i>

                                <span class="hide-menu">Data Pasar</span>

                            </a>

                        </li>

                        <li class="<?//= ($menu == 'kelompok_pasar'?'active':'') ?>"> 

                            <a class="waves-effect <?//= ($menu == 'kelompok_pasar'?'active':'') ?>" href="<?//= base_url() ?>Admin/kelompokPasar" aria-expanded="false">

                                <i class="mdi mdi-shopping"></i>

                                <span class="hide-menu">Kelompok Pasar</span>

                            </a>

                        </li> -->

                        <!-- <li class="<?//= ($menu == 'user'?'active':'') ?>"> 

                            <a class="waves-effect <?//= ($menu == 'user'?'active':'') ?>" href="<?//= base_url() ?>Admin/dataUser" aria-expanded="false">

                                <i class="mdi mdi-account-box"></i>

                                <span class="hide-menu">Data User</span>

                            </a>

                        </li>

                        <li class="<?//= ($menu == 'petugas'?'active':'') ?>"> 

                            <a class="waves-effect <?//= ($menu == 'petugas'?'active':'') ?>" href="<?//= base_url() ?>Admin/dataPetugas" aria-expanded="false">

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

                                    <a class="<?= ($menu == 'target'?'active':'') ?>" href="<?= base_url() ?>Admin/targetPad">

                                        <!-- <i class="mdi mdi-account-box"></i> --> Target PAD

                                    </a>

                                </li>

                                <li>

                                    <a class="<?= ($menu == 'user'?'active':'') ?>" href="<?= base_url() ?>Admin/dataUser">

                                        <!-- <i class="mdi mdi-account-box"></i> --> Data Pemilik Usaha 

                                    </a>

                                </li>

                                <li>

                                    <a class="<?= ($menu == 'petugas'?'active':'') ?>" href="<?= base_url() ?>Admin/dataPetugas">

                                        <!-- <i class="mdi mdi-account-card-details"></i> --> Data Pegawai

                                    </a>

                                </li>

                                <li>

                                    <a class="<?= ($menu == 'jabatan'?'active':'') ?>" href="<?= base_url() ?>Admin/dataJabatan">

                                        Jenis Jabatan 

                                    </a>

                                </li>

                                <li>

                                    <a class="<?= ($menu == 'kategori_alat'?'active':'') ?>" href="<?= base_url() ?>Admin/kategoriAlat">

                                        <!-- <i class="mdi mdi-scale"></i> --> Kategori Alat

                                    </a>

                                </li>

                                <li>

                                    <a class="<?= ($menu == 'jenis_alat'?'active':'') ?>" href="<?= base_url() ?>Admin/jenisAlat">

                                        <!-- <i class="mdi mdi-scale-bathroom"></i> --> Jenis Alat

                                    </a>

                                </li>

                                <li>

                                    <a class="<?= ($menu == 'tarif'?'active':'') ?>" href="<?= base_url() ?>Admin/dataTarif">

                                        <!-- <i class="mdi"><b>Rp</b></i> --> Tarif Retribusi

                                    </a>

                                </li>

                                <li>

                                    <a class="<?= ($menu == 'kelompok_tarif'?'active':'') ?>" href="<?= base_url() ?>Admin/kelompokTarif">

                                        <!-- <i class="fa fa-money"></i> --> Kelompok Tarif

                                    </a>

                                </li>

                                <li>

                                    <a class="<?= ($menu == 'usaha'?'active':'') ?>" href="<?= base_url() ?>Admin/jenisUsaha">

                                        <!-- <i class="mdi mdi-briefcase-check"></i> --> Jenis Usaha

                                    </a>

                                </li>

                                <li>

                                    <a class="<?= ($menu == 'pasar'?'active':'') ?>" href="<?= base_url() ?>Admin/dataPasar">

                                        <!-- <i class="mdi mdi-hospital-building"></i> --> Data Pasar

                                    </a>

                                </li>

                                <!-- <li>

                                    <a class="<?= ($menu == 'kelompok_pasar'?'active':'') ?>" href="<?= base_url() ?>Admin/kelompokPasar">

                                        <i class="mdi mdi-shopping"></i> Kelompok Pasar

                                    </a>

                                </li> -->

                            </ul>

                        </li>



                        <li class="nav-devider"></li>

                        <li class="nav-small-cap">HOME MENU</li>



                        <li class="<?= ($menu == 'carousel' ? 'active' : '') ?>">

                          <a class="waves-effect <?= ($menu == 'carousel' ? 'active' : '') ?>" href="<?= base_url() ?>Admin/carousel" aria-expanded="false">

                            <i class="mdi mdi-account-card-details"></i>

                            <span class="hide-menu">Carousel</span>

                          </a>

                        </li>

                        <li class="<?= ($menu == 'profile' ? 'active' : '') ?>">

                          <a class="waves-effect <?= ($menu == 'profile' ? 'active' : '') ?>" href="<?= base_url() ?>Admin/profile" aria-expanded="false">

                            <i class="mdi mdi-face-profile"></i>

                            <span class="hide-menu">Profile</span>

                          </a>

                        </li>

                        <li class="<?= ($menu == 'berita' ? 'active' : '') ?>">

                          <a class="waves-effect <?= ($menu == 'berita' ? 'active' : '') ?>" href="<?= base_url() ?>Admin/berita" aria-expanded="false">

                            <i class="mdi mdi-newspaper"></i>

                            <span class="hide-menu">Berita</span>

                          </a>

                        </li>

                        <li class="<?= ($menu == 'pengumuman' ? 'active' : '') ?>">

                          <a class="waves-effect <?= ($menu == 'pengumuman' ? 'active' : '') ?>" href="<?= base_url() ?>Admin/pengumuman" aria-expanded="false">

                            <i class="fa fa-bullhorn"></i>

                            <span class="hide-menu">Pengumuman</span>

                          </a>

                        </li>

                        <li class="<?= ($menu == 'maklumat' ? 'active' : '') ?>">

                          <a class="waves-effect <?= ($menu == 'maklumat' ? 'active' : '') ?>" href="<?= base_url() ?>Admin/maklumat" aria-expanded="false">

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