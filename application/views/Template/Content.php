<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title><?= $judul; ?></title>

  <!-- Custom fonts for this template-->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="<?= base_url() ?>../assets/css/sb-admin-2.min.css" rel="stylesheet">

  <!-- selectpicekr -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">

  <!-- jquery -->
  <!-- <script src="<?= base_url() ?>../assets/vendor/jquery/jquery.min.js"></script> -->

  <!-- sweet alert -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- jquery -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

  <!-- Custom styles for this page -->
  <link href="<?= base_url() ?>../assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

  <!-- Page level plugins -->
  <script src="<?= base_url() ?>../assets/vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="<?= base_url() ?>../assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="<?= base_url() ?>../assets/js/demo/datatables-demo.js"></script>

  <!-- Select2 -->
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

  <!-- animate -->
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

</head>

<style>
  .select2-selection__rendered {
    line-height: 31px !important;
  }

  .select2-container .select2-selection--single {
    height: 37px !important;
  }

  .select2-selection__arrow {
    height: 37px !important;
  }
</style>

<body id="page-top">

  <?php
  $sess = $this->session->userdata('username');
  $sess1 = $this->session->userdata('kode_unit');
  if ($sess1 != '') {
    $cek_unit = $this->db->get_where('akses_unit', ['username' => $sess, 'kode_unit' => $sess1])->num_rows();
    if ($cek_unit < 1) {
      redirect('Auth/logout_action/1');
    }
  }
  ?>

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" type="button" onclick="get_menu('Dashboard')">
        <div class="sidebar-brand-icon rotate-n-15">
          <i class="fa-solid fa-prescription-bottle-medical"></i>
        </div>
        <?php
        $cabang = $this->session->userdata('kode_unit');
        ?>
        <div class="sidebar-brand-text mx-3">Apotek <sup class="badge badge-light"><?= $cabang ?></sup></div>
      </a>

      <?php
      $sess_role = $this->session->userdata('kode_role');
      $modul = $this->db->query("SELECT * FROM m_modul WHERE id IN (SELECT id_modul FROM akses_modul WHERE kode_role = '$sess_role')")->result();
      foreach ($modul as $mo) :
        if ($mo->nama == '') {
          $devider = "my-0";
        } else {
          $devider = "";
        }
        echo '<hr class="sidebar-divider ' . $devider . '">';
        echo '<div class="sidebar-heading">
          ' . $mo->nama . '
        </div>';
        $menu = $this->db->get_where("menu", ["id_modul" => $mo->id])->result();
        foreach ($menu as $me) :
          $param_menu1 = $this->uri->segment(1);
          $param_menu2 = $this->uri->segment(2);
          $cek_menu = $this->db->query('SELECT * FROM menu WHERE url = "' . $param_menu1 . '/' . $param_menu2 . '"')->row();
          if (empty($cek_menu)) {
            if ($param_menu1 == $me->url) {
              $active_menu = "active";
            } else {
              $active_menu = "";
            }
          } else {
            if (($param_menu1 . '/' . $param_menu2) == $me->url) {
              $active_menu = "active";
            } else {
              $active_menu = "";
            }
          }
          echo '<li class="nav-item ' . $active_menu . '">';
          $cek_sub_menu = $this->db->query("SELECT * FROM sub_menu WHERE url LIKE '%$me->url%'")->num_rows();
          if ($cek_sub_menu > 0) {
            $no = 1;
            $cek_sm = $this->db->query("SELECT * FROM menu WHERE id_modul = '$mo->id' AND id IN (SELECT id_menu FROM sub_menu)")->num_rows();
            if ($cek_sm > 1) {
              $first_sm = $this->db->query("SELECT * FROM menu WHERE id_modul = '$mo->id' ORDER BY id ASC LIMIT 1")->row();
              if ($me->id == $first_sm->id) {
                $stylePad = '';
              } else {
                $stylePad = 'style="margin-top: -15px"';
              }
            } else {
              $stylePad = '';
            }
            echo '<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse' . $me->nama . '" aria-expanded="true" aria-controls="collapsePages" ' . $stylePad . '>
                ' . $me->ikon . ' <span>' . $me->nama . '</span>
              </a>';
            echo '<div id="collapse' . $me->nama . '" class="collapse" aria-labelledby="heading' . $me->nama . '" data-parent="#accordionSidebar">
              <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">' . $me->nama . ':</h6>';
            $sub_menu = $this->db->get_where("sub_menu", ["id_menu" => $me->id])->result();
            foreach ($sub_menu as $sm) {
              echo '<a class="collapse-item" type="button" onclick="get_menu(' . "'" . $sm->url . "'" . ')">' . $sm->nama . '</a>';
              $no++;
            }
            echo '</div>
            </div>';
          } else {
            $cek_urut_modul = $this->db->query('SELECT * FROM menu WHERE id_modul = "' . $mo->id . '" ORDER BY id ASC LIMIT 1')->row();
            if ($me->id == $cek_urut_modul->id) {
              $stylePad = '';
            } else {
              $stylePad = 'style="margin-top: -15px"';
            }
            echo '<a class="nav-link" type="button" onclick="get_menu(' . "'" . $me->url . "'" . ')" ' . $stylePad . '>
              ' . $me->ikon . ' <span>' . $me->nama . '</span>
            </a>';
          }
          echo '</li>';
      ?>
        <?php endforeach; ?>
      <?php endforeach; ?>

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            <!-- Nav Item - Search Dropdown (Visible Only XS) -->
            <li class="nav-item dropdown no-arrow d-sm-none">
              <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
              </a>
              <!-- Dropdown - Messages -->
              <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search">
                  <div class="input-group">
                    <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                      <button class="btn btn-primary" type="button">
                        <i class="fas fa-search fa-sm"></i>
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </li>

            <!-- Nav Item - Alerts -->
            <li class="nav-item dropdown no-arrow mx-1">
              <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                <!-- Counter - Alerts -->
                <span class="badge badge-danger badge-counter">3+</span>
              </a>
              <!-- Dropdown - Alerts -->
              <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header">
                  Alerts Center
                </h6>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="mr-3">
                    <div class="icon-circle bg-primary">
                      <i class="fas fa-file-alt text-white"></i>
                    </div>
                  </div>
                  <div>
                    <div class="small text-gray-500">December 12, 2019</div>
                    <span class="font-weight-bold">A new monthly report is ready to download!</span>
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="mr-3">
                    <div class="icon-circle bg-success">
                      <i class="fas fa-donate text-white"></i>
                    </div>
                  </div>
                  <div>
                    <div class="small text-gray-500">December 7, 2019</div>
                    $290.29 has been deposited into your account!
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="mr-3">
                    <div class="icon-circle bg-warning">
                      <i class="fas fa-exclamation-triangle text-white"></i>
                    </div>
                  </div>
                  <div>
                    <div class="small text-gray-500">December 2, 2019</div>
                    Spending Alert: We've noticed unusually high spending for your account.
                  </div>
                </a>
                <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
              </div>
            </li>

            <!-- Nav Item - Messages -->
            <li class="nav-item dropdown no-arrow mx-1">
              <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-envelope fa-fw"></i>
                <!-- Counter - Messages -->
                <span class="badge badge-danger badge-counter">7</span>
              </a>
              <!-- Dropdown - Messages -->
              <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="messagesDropdown">
                <h6 class="dropdown-header">
                  Message Center
                </h6>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="dropdown-list-image mr-3">
                    <img class="rounded-circle" src="img/undraw_profile_1.svg" alt="...">
                    <div class="status-indicator bg-success"></div>
                  </div>
                  <div class="font-weight-bold">
                    <div class="text-truncate">Hi there! I am wondering if you can help me with a
                      problem I've been having.</div>
                    <div class="small text-gray-500">Emily Fowler · 58m</div>
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="dropdown-list-image mr-3">
                    <img class="rounded-circle" src="img/undraw_profile_2.svg" alt="...">
                    <div class="status-indicator"></div>
                  </div>
                  <div>
                    <div class="text-truncate">I have the photos that you ordered last month, how
                      would you like them sent to you?</div>
                    <div class="small text-gray-500">Jae Chun · 1d</div>
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="dropdown-list-image mr-3">
                    <img class="rounded-circle" src="img/undraw_profile_3.svg" alt="...">
                    <div class="status-indicator bg-warning"></div>
                  </div>
                  <div>
                    <div class="text-truncate">Last month's report looks great, I am very happy with
                      the progress so far, keep up the good work!</div>
                    <div class="small text-gray-500">Morgan Alvarez · 2d</div>
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="dropdown-list-image mr-3">
                    <img class="rounded-circle" src="https://source.unsplash.com/Mv9hjnEUHR4/60x60" alt="...">
                    <div class="status-indicator bg-success"></div>
                  </div>
                  <div>
                    <div class="text-truncate">Am I a good boy? The reason I ask is because someone
                      told me that people say this to all dogs, even if they aren't good...</div>
                    <div class="small text-gray-500">Chicken the Dog · 2w</div>
                  </div>
                </a>
                <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>
              </div>
            </li>

            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?= (($this->session->userdata('shift') != '') ? 'Shift Kerja: ' . $this->session->userdata('shift') . '<div class="topbar-divider d-none d-sm-block"></div>' : '') ?>
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row()->nama; ?></span>
                <img class="img-profile rounded-circle" src="<?= base_url() ?>../assets/img/user/<?= $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row()->foto; ?>">
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" type="button" onclick="get_menu('Akun')">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Profil
                </a>
                <a class="dropdown-item" type="button" onclick="get_menu('')">
                  <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                  Pengaturan
                </a>
                <a class="dropdown-item" type="button" onclick="get_menu('')">
                  <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                  Aktivitas Log
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" type="button" onclick="logout()">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Keluar
                </a>
              </div>
            </li>

          </ul>

        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <?= $content; ?>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; Your Website 2020</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <script>
    const siteUrl = '<?= site_url() ?>';

    function get_menu(menu) {
      location.href = siteUrl + menu;
    }

    $('.select2_all').select2({
      width: '100%',
      heigh: 'auto',
    })

    function formatRupiah(valx, idForm) {

      if (valx == '') {
        var val = 0;
      } else {
        var val = parseInt(valx.replace(/(,|[^\d.-]+)+/g, ''));
      }

      var sign = 1;

      if (val < 0) {
        sign = -1;
        val = -val;
      }

      let num = val.toString().includes('.') ? val.toString().split('.')[0] : val.toString();
      let len = num.toString().length;
      let result = '';
      let count = 1;
      for (let i = len - 1; i >= 0; i--) {
        result = num.toString()[i] + result;
        if (count % 3 === 0 && count !== 0 && i !== 0) {
          result = ',' + result;
        }
        count++;
      }
      if (val.toString().includes('.')) {
        result = result + '.' + val.toString().split('.')[1];
      }
      $('#' + idForm).val(sign < 0 ? '-' + result : result);
    }

    function ubah_nama(val, idForm) {
      str = val.toLowerCase().replace(/\b[a-z]/g, function(letter) {
        return letter.toUpperCase();
      });
      $('#' + idForm).val(str);
    }

    function delspace(param, idForm) {
      var kodex = param.trim();
      $('#' + idForm).val(kodex.toUpperCase());
    }

    function delspace_nocaps(param, idForm) {
      var kodex = param.trim();
      $('#' + idForm).val(kodex);
    }

    function cekKode(param, idForm, urlForm, modal) {
      $.ajax({
        url: siteUrl + urlForm + param,
        type: 'POST',
        dataType: 'JSON',
        success: function(result) {
          if (result == '' || result == null) {
            $('#' + modal).modal('hide');
            btnShow.show();
            btnHide.hide();

            Swal.fire({
              title: '404',
              text: 'Tidak ada respons dari sistem',
              icon: 'error'
            }).then((value) => {
              $('#' + modal).modal('show');
            });
            return;
          } else {
            if (result.response == 1) {
              $('#' + modal).modal('hide');
              $('#' + idForm).val('');
              btnShow.show();
              btnHide.hide();

              Swal.fire({
                title: 'Kode',
                text: 'Sudah digunakan, silahkan gunakan kode lain!',
                icon: 'error'
              }).then((value) => {
                $('#' + modal).modal('show');
              });
              return;
            }
          }
        },
        error: function(result) {
          $('#' + modal).modal('hide');
          Swal.fire({
            title: '501',
            text: 'Error Sistem',
            icon: 'error'
          })
          return;
        }
      });
    }

    function logout() {
      Swal.fire({
        title: "Keluar?",
        text: "Anda akan meninggalkan sistem!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya, Keluar!"
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: siteUrl + 'Auth/logout_action',
            type: 'POST',
            dataType: 'JSON',
            success: function(result) {
              if (result == '' || result == null) {
                Swal.fire({
                  title: '404',
                  text: 'Tidak ada respons dari sistem',
                  icon: 'error'
                });
                return;
              } else {
                if (result.response == 1) {
                  Swal.fire({
                    title: 'Keluar',
                    text: 'Berhasil dilakukan!',
                    icon: 'success'
                  }).then((result) => {
                    location.href = siteUrl + 'Auth';
                  });
                } else {
                  Swal.fire({
                    title: 'Keluar',
                    text: 'Gagak dilakukan, silahkan coba lagi!',
                    icon: 'warning'
                  });
                }
              }
            },
            error: function(result) {
              Swal.fire({
                title: '501',
                text: 'Error Sistem',
                icon: 'error'
              })
              return;
            }
          });
        }
      });
    }
  </script>

  <!-- Bootstrap core JavaScript-->
  <script src="<?= base_url() ?>../assets/vendor/jquery/jquery.min.js"></script>
  <script src="<?= base_url() ?>../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="<?= base_url() ?>../assets/vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="<?= base_url() ?>../assets/js/sb-admin-2.min.js"></script>

  <?php if ($this->uri->segment(1) == 'C_modul') : ?>
  <?php else : ?>

    <?php $this->load->view('datatable'); ?>

  <?php endif; ?>

  <script>

  </script>
</body>

</html>