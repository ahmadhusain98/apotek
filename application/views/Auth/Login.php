<form class="user" method="post" id="formLogin">
  <!-- Outer Row -->
  <div class="row justify-content-center">

    <div class="col-xl-4 col-lg-12 col-md-9">

      <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
          <!-- Nested Row within Card Body -->
          <div class="row">
            <div class="col-md-12">
              <div class="p-4">
                <div class="text-center">
                  <h1 class="h4 text-gray-900 mb-4"><?= $judul; ?></h1>
                </div>
                <hr>
                <div class="form-group">
                  <input type="text" class="form-control" id="username" name="username" placeholder="Username...">
                </div>
                <div class="form-group">
                  <input type="password" class="form-control" id="password" name="password" placeholder="Sandi...">
                </div>
                <div class="form-group">
                  <select name="cabang" id="cabang" class="form-control" data-placeholder="-- Cabang --">
                    <option value="">-- Cabang --</option>
                  </select>
                </div>
                <button type="button" class="btn btn-primary btn-block btn-sm" onclick="login_proses()" id="btnShow">
                  Masuk
                </button>
                <button class="btn btn-primary btn-block btn-sm" type="button" disabled id="btnHide">
                  <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                  Mohon ditunggu...
                </button>
                <hr>
                <div class="text-center">
                  <div class="row">
                    <div class="col-md-6">
                      <a class="small" type="button" onclick="ajukan()">Minta Aktivasi!</a>
                    </div>
                    <div class="col-md-6">
                      <a class="small" href="<?= site_url() ?>Auth/regist">Belum Punya Akun!</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>

  </div>
</form>

<div class="modal fade" id="mAktivasi" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog  modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Ajukan Aktivasi Akun</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="text" name="userakifasi" id="userakifasi" class="form-control" placeholder="Username..." title="Username">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Tutup</button>
        <button type="button" class="btn btn-primary btn-sm" onclick="ajukan_proses()">Ajukan</button>
      </div>
    </div>
  </div>
</div>

<script>
  var userakifasi = $('#userakifasi');
  var username = $('#username');
  var password = $('#password');

  const siteUrl = '<?= site_url() ?>';
  const form = $('#formLogin');

  var btnShow = $('#btnShow');
  var btnHide = $('#btnHide');

  $(document).ready(function() {
    btnHide.hide();
  });

  function ajukan() {
    $('#mAktivasi').modal('show');
  }

  function ajukan_proses() {
    $('#mAktivasi').modal('hide');

    if (userakifasi.val() == '' || userakifasi.val() == null) {
      Swal.fire({
        title: 'Username',
        text: 'Tidak boleh kosong',
        icon: 'error'
      });
      return;
    }

    $.ajax({
      url: siteUrl + 'Auth/ajukan_aktivasi/' + userakifasi.val(),
      type: 'POST',
      dataType: 'JSON',
      success: function(result) {
        if (result == '' || result == null) {
          Swal.fire({
            title: '404',
            text: 'Tidak ada respons dari sistem',
            icon: 'error'
          }).then((result) => {
            $('#mAktivasi').modal('show');
          });
        } else {
          if (result.response == 0) {
            Swal.fire({
              title: 'Akun ' + userakifasi.val(),
              text: 'Gagak diajukan aktivasi, username tidak ditemukan!',
              icon: 'error'
            }).then((result) => {
              $('#mAktivasi').modal('show');
            });
          } else if (result.response == 1) {
            Swal.fire({
              title: 'Akun ' + userakifasi.val(),
              text: 'Berhasil diajukan aktivasi, mohon di tunggu untuk proses aktivasi!',
              icon: 'success'
            }).then((result) => {
              location.href = siteUrl + 'Auth';
            });
          } else {
            Swal.fire({
              title: 'Akun ' + userakifasi.val(),
              text: 'Gagak diajukan aktivasi!',
              icon: 'warning'
            }).then((result) => {
              $('#mAktivasi').modal('show');
            });
          }
        }
      }
    })
  }

  function login_proses() {
    btnHide.show();
    btnShow.hide();

    if (username.val() == '' || username.val() == null) {
      btnHide.hide();
      btnShow.show();

      Swal.fire({
        title: 'Username',
        text: 'Tidak boleh kosong',
        icon: 'error'
      });
      return;
    }

    if (password.val() == '' || password.val() == null) {
      btnHide.hide();
      btnShow.show();

      Swal.fire({
        title: 'Password',
        text: 'Tidak boleh kosong',
        icon: 'error'
      });
      return;
    }

    // cek user
    $.ajax({
      url: siteUrl + 'Auth/cek_user/',
      type: 'POST',
      data: form.serialize(),
      dataType: 'JSON',
      success: function(result) {
        if (result == '' || result == null) {
          btnHide.hide();
          btnShow.show();

          Swal.fire({
            title: '404',
            text: 'Tidak ada respons dari sistem',
            icon: 'error'
          });
          return;
        } else if (result.response == 0) {
          btnHide.hide();
          btnShow.show();

          Swal.fire({
            title: 'Akun ' + username.val(),
            text: 'Tidak ditemukan, silahkan mendaftar!',
            icon: 'error'
          }).then((result) => {
            location.href = siteUrl + 'Auth';
          });
        } else if (result.response == 1) {
          btnHide.hide();
          btnShow.show();

          location.href = siteUrl + 'Dashboard';
        } else {
          btnHide.hide();
          btnShow.show();

          Swal.fire({
            title: 'Akun ' + username.val(),
            text: 'Gagal masuk, password berbeda!',
            icon: 'error'
          });
        }
      }
    })
  }
</script>