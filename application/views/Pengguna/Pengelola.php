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
        <button type="button" class="btn btn-primary btn-sm">Proses</button>
      </div>
    </div>
  </div>
</div>

<!-- Global -->
<script>
  var table = $('#tablePengelola');
</script>

<!-- proses add/update -->
<script>
  function add_pengelola() {
    $('#m_pengelola').modal('show');
    $('.modal-title').text('Form Tambah User Pengelola');
  }
</script>