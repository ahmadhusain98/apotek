<form class="user" method="post" id="formRegist">
  <!-- Outer Row -->
  <div class="row justify-content-center">

    <div class="col-xl-6 col-lg-12 col-md-9">

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
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <input type="text" title="Nama" class="form-control" id="nama" name="nama" placeholder="Nama...">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <input type="text" title="Username" class="form-control" id="username" name="username" placeholder="Username..." onchange="cekUsername(this.value)">
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
                      <input type="text" title="Nomor Hp" class="form-control" id="nohp" name="nohp" placeholder="Nomor Hp...">
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
                  <div class="col-md-12">
                    <div class="form-group">
                      <textarea name="alamat" title="Alamat" id="alamat" class="form-control" placeholder="Alamat..."></textarea>
                    </div>
                  </div>
                </div>
                <button type="button" class="btn btn-primary btn-block btn-sm" onclick="daftarkan()">
                  Daftar
                </button>
                <hr>
                <div class="text-center">
                  <a class="small" href="<?= site_url() ?>Auth">Sudah Punya Akun!</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>

  </div>
</form>

<script>
  var nama = $('#nama');
  var username = $('#username');
  var password = $('#password');
  var nohp = $('#nohp');
  var email = $('#email');
  var tempat_lahir = $('#tempat_lahir');
  var tgl_lahir = $('#tgl_lahir');
  var alamat = $('#alamat');

  const siteUrl = '<?= site_url() ?>';
  const form = $('#formRegist');

  function cekUsername(param) {
    if (param == '' || param == null) {} else {
      $.ajax({
        url: siteUrl + 'Auth/cekUsername/' + param,
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
                title: 'Username',
                text: 'Sudah digunakan',
                icon: 'warning'
              });
              return;
            }
          }
        }
      })
    }
  }

  function daftarkan() {
    if (nama.val() == '' || nama.val() == null) {
      Swal.fire({
        title: 'Nama',
        text: 'Tidak boleh kosong',
        icon: 'error'
      });
      return;
    }

    if (username.val() == '' || username.val() == null) {
      Swal.fire({
        title: 'Username',
        text: 'Tidak boleh kosong',
        icon: 'error'
      });
      return;
    }

    if (password.val() == '' || password.val() == null) {
      Swal.fire({
        title: 'Sandi',
        text: 'Tidak boleh kosong',
        icon: 'error'
      });
      return;
    }

    if (nohp.val() == '' || nohp.val() == null) {
      Swal.fire({
        title: 'Nomor Hp',
        text: 'Tidak boleh kosong',
        icon: 'error'
      });
      return;
    }

    if (email.val() == '' || email.val() == null) {
      Swal.fire({
        title: 'Email',
        text: 'Tidak boleh kosong',
        icon: 'error'
      });
      return;
    }

    if (tempat_lahir.val() == '' || tempat_lahir.val() == null) {
      Swal.fire({
        title: 'Tempat Lahir',
        text: 'Tidak boleh kosong',
        icon: 'error'
      });
      return;
    }

    if (tgl_lahir.val() == '' || tgl_lahir.val() == null) {
      Swal.fire({
        title: 'Tanggal Lahir',
        text: 'Tidak boleh kosong',
        icon: 'error'
      });
      return;
    }

    if (alamat.val() == '' || alamat.val() == null) {
      Swal.fire({
        title: 'Alamat',
        text: 'Tidak boleh kosong',
        icon: 'error'
      });
      return;
    }

    $.ajax({
      url: siteUrl + 'Auth/regist_action/',
      type: 'POST',
      data: form.serialize(),
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
              title: 'Akun ' + username.val(),
              text: 'Berhasil didaftarkan, silahkan ajukan aktivasi!',
              icon: 'success'
            }).then((result) => {
              location.href = siteUrl + 'Auth';
            });
          } else {
            Swal.fire({
              title: 'Akun ' + username.val(),
              text: 'Gagak didaftarkan, silahkan coba lagi!',
              icon: 'warning'
            });
          }
        }
      }
    });
  }
</script>