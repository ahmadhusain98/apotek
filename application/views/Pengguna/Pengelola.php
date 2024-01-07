<form method="post" id="formPengelola">
  <div class="h4 mb-3 text-gray-800">Pengguna / pengelola</div>

  <div class=" card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">List data pengelola
        <button class="btn btn-primary btn-sm float-right" type="button" onclick="add_pengelola()"><i class="fa fa-plus"></i> Tambah List</button>
      </h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="tablePengelola" width="100%" cellspacing="0">
          <thead>
            <tr>
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
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Tutup</button>
          <button type="button" class="btn btn-primary btn-sm" onclick="proses()">Proses</button>
        </div>
      </div>
    </div>
  </div>
</form>

<!-- Global -->
<script>
  const form = $('#formPengelola');

  var table = $('#tablePengelola');

  var nama = $('#nama');
  var username = $('#username');
  var password = $('#password');
  var nohp = $('#nohp');
  var email = $('#email');
  var tempat_lahir = $('#tempat_lahir');
  var tgl_lahir = $('#tgl_lahir');
  var alamat = $('#alamat');
</script>

<!-- another function -->
<script>
  function cekUsername(param) {
    $('#m_pengelola').modal('hide');
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
            }).then((value) => {
              $('#m_pengelola').modal('show');
              $('.modal-title').text('Form Tambah User Pengelola');
            });
            return;
          } else {
            if (result.response == 1) {
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
        }
      })
    }
  }
</script>

<!-- proses add/update -->
<script>
  function add_pengelola() {
    $('#m_pengelola').modal('show');
    $('.modal-title').text('Form Tambah User Pengelola');
  }

  function proses() {
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

    let timerInterval;
    Swal.fire({
      title: "Mohon Tunggu!",
      html: "Sedang melakukan proses",
      timer: 1000,
      timerProgressBar: true,
      didOpen: () => {
        Swal.showLoading();
        const timer = Swal.getPopup().querySelector("b");
        timerInterval = setInterval(() => {
          timer.textContent = `${Swal.getTimerLeft()}`;
        }, 100);
      },
      willClose: () => {
        clearInterval(timerInterval);
      }
    }).then((result) => {
      if (result.dismiss === Swal.DismissReason.timer) {
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
              }).then((value) => {
                $('#m_pengelola').modal('show');
              });
              return;
            } else {
              if (result.response == 1) {
                Swal.fire({
                  title: 'Akun ' + username.val(),
                  text: 'Berhasil ditambahkan, silahkan ajukan aktivasi!',
                  icon: 'success'
                }).then((result) => {
                  location.href = siteUrl + 'Users/pengelola';
                });
              } else {
                Swal.fire({
                  title: 'Akun ' + username.val(),
                  text: 'Gagak ditambahkan, silahkan coba lagi!',
                  icon: 'warning'
                }).then((value) => {
                  $('#m_pengelola').modal('show');
                });
              }
            }
          }
        });
      }
    });
  }
</script>