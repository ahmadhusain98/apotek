<form method="post" id="formPengelola">
  <div class="h4 mb-3 text-gray-800">Pengguna / pengelola
    <div class="btn-group float-right" role="group" aria-label="Basic example">
      <button type="button" class="btn btn-dark btn-sm" disabled>Video Tutorial <i class="fa fa-arrow-alt-circle-right"></i></button>
      <button type="button" class="btn btn-info btn-sm" title="Tutorial Tambah" onclick="tutor(1)"><i class="fa fa-plus"></i></button>
      <button type="button" class="btn btn-info btn-sm" title="Tutorial Ubah" onclick="tutor(2)"><i class="fa fa-repeat"></i></button>
      <button type="button" class="btn btn-info btn-sm" title="Tutorial Hapus" onclick="tutor(3)"><i class="fa fa-ban"></i></button>
    </div>
  </div>

  <div class=" card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">List data pengelola
        <button type="button" class="btn btn-sm float-right" style="background-color: transparent; border: 0px;" title="Informasi" onclick="forInfo()"><i class="fa fa-2x fa-info-circle text-info"></i></button>
        <?php if ($role_aksi->tambah > 0) : ?>
          <button class="btn btn-primary btn-sm float-right" type="button" onclick="add_pengelola()"><i class="fa fa-plus"></i> Tambah List</button>
        <?php endif; ?>
      </h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="tablePengelola" width="100%" cellspacing="0">
          <thead>
            <tr class="bg-primary text-white">
              <th width="5%">No</th>
              <th>Username</th>
              <th>Nama</th>
              <th>Nomor HP</th>
              <th>Status Aktif</th>
              <th>Role</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="modal fade" id="m_pengelola" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <input type="text" title="Nama" class="form-control" id="nama" name="nama" placeholder="Nama..." onkeyup="ubah_nama(this.value, 'nama')">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <input type="text" title="Username" class="form-control" id="username" name="username" placeholder="Username..." onkeyup="delspace_nocaps(this.value, 'username')" onchange="cekUsername(this.value)">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <input type="password" title="Sandi" class="form-control" id="password" name="password" placeholder="Sandi...">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <input type="number" title="Nomor Hp" class="form-control" id="nohp" name="nohp" placeholder="Nomor Hp..." onkeyup="maxhp(this.value)">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <input type="email" title="Email" class="form-control" id="email" name="email" placeholder="Email...">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <input type="text" title="Tempat Lahir" class="form-control" id="tempat_lahir" name="tempat_lahir" placeholder="Tempat Lahir...">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <input type="date" title="Tanggal Lahir" class="form-control" id="tgl_lahir" name="tgl_lahir" placeholder="Tanggal Lahir..." value="<?= date('Y-m-d') ?>" max="<?= date('Y-m-d') ?>">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <select name="gender" id="gender" class="form-control select2_all" data-placeholder="-- Pilih Gender --">
                  <option value="">-- Pilih Gender --</option>
                  <option value="P">Pria</option>
                  <option value="W">Wanita</option>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <select name="kode_role" id="kode_role" class="form-control select2_all" data-placeholder="-- Pilih Role --">
                  <option value="">-- Pilih Role --</option>
                  <?php foreach ($m_role as $mr) : ?>
                    <option value="<?= $mr->kode ?>"><?= $mr->keterangan ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <textarea name="alamat" title="Alamat" id="alamat" class="form-control" placeholder="Alamat..."></textarea>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Tutup</button>
          <input type="hidden" name="prosesx" id="prosesx" value="1">
          <button type="button" class="btn btn-primary btn-sm" onclick="proses()" id="btnShow">Proses</button>
          <button class="btn btn-primary btn-sm" type="button" disabled id="btnHide">
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            Mohon ditunggu...
          </button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="m_tutorial" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-body">
          <div id="body_tutor"></div>
        </div>
      </div>
    </div>
  </div>

  <div class="position-fixed bottom-0 right-0 p-3" style="z-index: 5; right: 0; bottom: 0; height: 200px;">
    <div id="liveToast" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000">
      <div class="toast-header">
        <strong class="mr-auto text-primary">Informasi</strong>
        <small class="text-danger">Akun dengan status <i><b>online</b></i></small>
      </div>
      <div class="toast-body">
        Tidak dapat diubah, maupun dihapus!
      </div>
    </div>
  </div>
</form>

<!-- Global -->
<script>
  const form = $('#formPengelola');
  const btnShow = $('#btnShow');
  const btnHide = $('#btnHide');

  $('.select2_all').select2({
    dropdownParent: $('#m_pengelola'),
    width: '100%',
    heigh: 'auto',
  })

  var table = $('#tablePengelola');

  var nama = $('#nama');
  var username = $('#username');
  var password = $('#password');
  var nohp = $('#nohp');
  var email = $('#email');
  var gender = $('#gender');
  var tempat_lahir = $('#tempat_lahir');
  var tgl_lahir = $('#tgl_lahir');
  var kode_role = $('#kode_role');
  var alamat = $('#alamat');
  var prosesx = $('#prosesx');

  $(document).ready(function() {
    btnHide.hide()
  });
</script>

<!-- another function -->
<script>
  function cekUsername(param) {
    btnShow.hide();
    btnHide.show();
    $('#m_pengelola').modal('hide');

    if (param == '' || param == null) {} else {
      $.ajax({
        url: siteUrl + 'Auth/cekUsername/' + param,
        type: 'POST',
        dataType: 'JSON',
        success: function(result) {
          if (result == '' || result == null) {
            btnShow.show();
            btnHide.hide();

            Swal.fire({
              title: '404',
              text: 'Tidak ada respons dari sistem',
              icon: 'error'
            }).then((value) => {
              $('#m_pengelola').modal('show');
              $('.modal-title').text('Form Tambah User Pengelola');
            });
            return;
          } else {
            if (result.response == 1) {
              btnShow.show();
              btnHide.hide();
              username.val('');
              Swal.fire({
                title: 'Username',
                text: 'Sudah digunakan',
                icon: 'warning'
              }).then((value) => {
                $('#m_pengelola').modal('show');
                $('.modal-title').text('Form Tambah User Pengelola');
              });
              return;
            }
          }
        },
        error: function(result) {
          btnShow.show();
          btnHide.hide();
          Swal.fire({
            title: '501',
            text: 'Error Sistem',
            icon: 'error'
          })
          return;
        }
      })
    }
  }

  function updated(param) {
    prosesx.val(2)
    $.ajax({
      url: siteUrl + 'Users/get_data_user/' + param,
      type: 'POST',
      dataType: 'JSON',
      success: function(result) {
        if (result == '' || result == null) {
          btnShow.show();
          btnHide.hide();

          Swal.fire({
            title: '404',
            text: 'Tidak ada respons dari sistem',
            icon: 'error'
          })
          return;
        } else {
          if (result.response == 0) {
            Swal.fire({
              title: 'Akun ' + param,
              text: 'Tidak ditemukan!',
              icon: 'error'
            });
            return;
          } else {
            btnShow.show();
            btnHide.hide();
            $(".modal-title").text("Form Ubah User Pengelola");
            $('#m_pengelola').modal('show');

            nama.val(result.nama);
            username.val(result.username);
            username.attr('readonly', true);
            password.val(result.sandi_ori);
            nohp.val(result.nohp);
            email.val(result.email);
            tempat_lahir.val(result.tempat_lahir);
            tgl_lahir.val(result.tgl_lahir);
            gender.val(result.gender).change();
            kode_role.val(result.kode_role).change();
            alamat.val(result.alamat);
          }
        }
      },
      error: function(result) {
        btnShow.show();
        btnHide.hide();

        Swal.fire({
          title: '501',
          text: 'Error Sistem',
          icon: 'error'
        });
        return;
      }
    });
  }

  function tutor(param) {
    $('#m_tutorial').modal('show');
    var body = $('#body_tutor');
    body.empty();
    if (param == 1) {
      body.append(`<div class="embed-responsive embed-responsive-16by9">
        <iframe class="embed-responsive-item" src="` + siteUrl + `/assets/tutorial/pengelola/insert.mp4" allowfullscreen></iframe>
      </div>`);
    } else if (param == 2) {
      body.append(`<div class="embed-responsive embed-responsive-16by9">
        <iframe class="embed-responsive-item" src="` + siteUrl + `/assets/tutorial/pengelola/update.mp4" allowfullscreen></iframe>
      </div>`);
    } else {
      body.append(`<div class="embed-responsive embed-responsive-16by9">
        <iframe class="embed-responsive-item" src="` + siteUrl + `/assets/tutorial/pengelola/delete.mp4" allowfullscreen></iframe>
      </div>`);
    }
  }

  function forInfo() {
    $('#liveToast').toast('show')
  }

  function maxhp(param) {
    if (param.length >= 15) {
      btnShow.show();
      btnHide.hide();
      nohp.val(param.substring(0, 15));

      Swal.fire({
        title: 'Nomor Hp',
        text: 'Maksimal 15 digit!',
        icon: 'error'
      }).then((value) => {
        $('#m_pengelola').modal('show');
      });
      return;
    }
  }
</script>

<!-- proses proses add, update, and delete -->
<script>
  function add_pengelola() {
    btnShow.show();
    btnHide.hide();

    $('#m_pengelola').modal('show');
    $('.modal-title').text('Form Tambah User Pengelola');
  }

  function proses() {
    btnShow.hide();
    btnHide.show();

    var proses_ = prosesx.val();
    $('#m_pengelola').modal('hide');

    if (nama.val() == '' || nama.val() == null) {
      Swal.fire({
        title: 'Nama',
        text: 'Tidak boleh kosong',
        icon: 'error'
      }).then((value) => {
        $('#m_pengelola').modal('show');
      });
      return;
    }

    if (username.val() == '' || username.val() == null) {
      Swal.fire({
        title: 'Username',
        text: 'Tidak boleh kosong',
        icon: 'error'
      }).then((value) => {
        $('#m_pengelola').modal('show');
      });
      return;
    }

    if (proses_ == 1) {
      if (password.val() == '' || password.val() == null) {
        Swal.fire({
          title: 'Sandi',
          text: 'Tidak boleh kosong',
          icon: 'error'
        });
        return;
      }
    }

    if (nohp.val() == '' || nohp.val() == null) {
      Swal.fire({
        title: 'Nomor Hp',
        text: 'Tidak boleh kosong',
        icon: 'error'
      }).then((value) => {
        $('#m_pengelola').modal('show');
      });
      return;
    }

    if (email.val() == '' || email.val() == null) {
      Swal.fire({
        title: 'Email',
        text: 'Tidak boleh kosong',
        icon: 'error'
      }).then((value) => {
        $('#m_pengelola').modal('show');
      });
      return;
    }

    if (tempat_lahir.val() == '' || tempat_lahir.val() == null) {
      Swal.fire({
        title: 'Tempat Lahir',
        text: 'Tidak boleh kosong',
        icon: 'error'
      }).then((value) => {
        $('#m_pengelola').modal('show');
      });
      return;
    }

    if (tgl_lahir.val() == '' || tgl_lahir.val() == null) {
      Swal.fire({
        title: 'Tanggal Lahir',
        text: 'Tidak boleh kosong',
        icon: 'error'
      }).then((value) => {
        $('#m_pengelola').modal('show');
      });
      return;
    }

    if (alamat.val() == '' || alamat.val() == null) {
      Swal.fire({
        title: 'Alamat',
        text: 'Tidak boleh kosong',
        icon: 'error'
      }).then((value) => {
        $('#m_pengelola').modal('show');
      });
      return;
    }

    if (proses_ == 1) {
      var pesan_success = 'ditambahkan, silahkan aktivasi terlebih dahulu!';
      var pesan_error = 'ditambahkan, silahkan coba lagi!';
    } else {
      var pesan_success = 'diperbaharui!';
      var pesan_error = 'diperbaharui, silahkan coba lagi!';
    }

    $.ajax({
      url: siteUrl + 'Users/add_pengelola_proses/' + proses_,
      type: 'POST',
      data: form.serialize(),
      dataType: 'JSON',
      success: function(result) {
        if (result == '' || result == null) {
          btnShow.show();
          btnHide.hide();

          Swal.fire({
            title: '404',
            text: 'Tidak ada respons dari sistem',
            icon: 'error'
          }).then((value) => {
            $('#m_pengelola').modal('show');
          });
          return;
        } else {
          if (result.response == 1) {
            btnShow.show();
            btnHide.hide();

            Swal.fire({
              title: 'Akun ' + username.val(),
              text: 'Berhasil ' + pesan_success,
              icon: 'success'
            }).then((result) => {
              location.href = siteUrl + 'Users/pengelola';
            });
          } else {
            btnShow.show();
            btnHide.hide();

            Swal.fire({
              title: 'Akun ' + username.val(),
              text: 'Gagak ' + pesan_error,
              icon: 'warning'
            }).then((value) => {
              $('#m_pengelola').modal('show');
            });
          }
        }
      },
      error: function(result) {
        btnShow.show();
        btnHide.hide();

        Swal.fire({
          title: '501',
          text: 'Error Sistem',
          icon: 'error'
        })
        return;
      }
    });
  }

  function deleted(username) {
    Swal.fire({
      title: "Anda yakin?",
      text: "Data yang dihapus tidak bisa di kembalikan!",
      icon: "question",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Ya, hapus!",
      cancelButtonText: "Tidak"
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: siteUrl + 'Users/deleted_pengelola_proses/' + username,
          type: 'POST',
          dataType: 'JSON',
          success: function(result) {
            if (result == '' || result == null) {
              Swal.fire({
                title: '404',
                text: 'Tidak ada respons dari sistem',
                icon: 'error'
              })
              return;
            } else {
              if (result.response == 1) {
                Swal.fire({
                  title: 'Akun ' + username,
                  text: 'Berhasil dihapus!',
                  icon: 'success'
                }).then((result) => {
                  location.href = siteUrl + 'Users/pengelola';
                });
              } else {
                Swal.fire({
                  title: 'Akun ' + username.val(),
                  text: 'Gagal dihapus!',
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