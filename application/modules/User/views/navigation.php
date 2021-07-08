

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

                            <a class="waves-effect <?= ($menu == 'dashboard'?'active':'') ?>" href="<?= base_url() ?>User" aria-expanded="false">

                                <i class="mdi mdi-gauge"></i>

                                <span class="hide-menu">Dashboard</span>

                            </a>

                        </li>

                        <li> 

                            <a class="has-arrow waves-effect" href="#" aria-expanded="false">

                                <i class="mdi mdi-scale-balance"></i>

                                <span class="hide-menu">Register Tera

                                    <!-- <span class="label label-rouded label-themecolor pull-right">4</span> -->

                                </span>

                            </a>

                            <ul aria-expanded="false" class="collapse">

                                <li>

                                    <a class="<?= ($menu == 'tera_baru'?'active':'') ?>" href="<?= base_url() ?>User/teraBaru">

                                        Pendaftaran Tera 

                                    </a>

                                </li>

                                <li>

                                    <a class="<?= ($menu == 'tera'?'active':'') ?>" href="<?= base_url() ?>User/dataTera">

                                        Daftar Pengajuan

                                    </a>

                                </li>

                            </ul>

                        </li>

                        <!-- <li class="<?//= ($menu == 'tera'?'active':'') ?>"> 

                            <a class="waves-effect <?//= ($menu == 'tera'?'active':'') ?>" href="<?//= base_url() ?>User/dataTera" aria-expanded="false">

                                <i class="mdi mdi-scale-balance"></i>

                                <span class="hide-menu">Pengajuan Tera</span>

                            </a>

                        </li> -->

                        <li class="<?= ($menu == 'usaha'?'active':'') ?>"> 

                            <a class="waves-effect <?= ($menu == 'usaha'?'active':'') ?>" href="<?= base_url() ?>User/dataUsaha" aria-expanded="false">

                                <i class="mdi mdi-briefcase-check"></i>

                                <span class="hide-menu">Data Usaha</span>

                            </a>

                        </li>

                        <li class="<?= ($menu == 'uttp'?'active':'') ?>"> 

                            <a class="waves-effect <?= ($menu == 'uttp'?'active':'') ?>" href="<?= base_url() ?>User/dataUttp" aria-expanded="false">

                                <i class="mdi mdi-scale"></i>

                                <span class="hide-menu">Data UTTP</span>

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