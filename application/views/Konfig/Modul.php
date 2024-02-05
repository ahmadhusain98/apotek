<div class="h4 mb-3 text-gray-800">Ubah Posisi Modul</div>

<form method="post" id="formModul">
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">List data Modul</h6>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-md-5 col-12">
          <div class="row">
            <div class="col-md-12">
              <div class="h5">Dari Modul</div>
            </div>
          </div>
          <div class="table-responsive">
            <table class="table table-bordered" id="tableModulDari" width="100%" cellspacing="0">
              <thead>
                <tr class="bg-primary text-white">
                  <th width="5%">No</th>
                  <th>Modul</th>
                  <th width="5%">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php $no = 1;
                foreach ($list as $m) : ?>
                  <tr>
                    <td><?= $no; ?></td>
                    <td><?= $m->nama; ?></td>
                    <td>
                      <button type="button" class="btn btn-sm btn-primary" id="btnDari<?= $m->id; ?>" onclick="dari('<?= $m->id; ?>', '<?= $m->nama ?>')">Pilih</button>
                    </td>
                  </tr>
                <?php $no++;
                endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
        <div class="col-md-5 col-12">
          <div class="row">
            <div class="col-md-12">
              <div class="h5">Ke Modul</div>
            </div>
          </div>
          <div class="table-responsive">
            <table class="table table-bordered" id="tableModulKe" width="100%" cellspacing="0">
              <thead>
                <tr class="bg-primary text-white">
                  <th width="5%">No</th>
                  <th>Modul</th>
                  <th width="5%">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php $no = 1;
                foreach ($list as $m) : ?>
                  <tr>
                    <td><?= $no; ?></td>
                    <td><?= $m->nama; ?></td>
                    <td>
                      <button type="button" class="btn btn-sm btn-primary" id="btnKe<?= $m->id; ?>" onclick="ke('<?= $m->id; ?>', '<?= $m->nama ?>')">Pilih</button>
                    </td>
                  </tr>
                <?php $no++;
                endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
        <div class="col-md-2 col-12">
          <div class="form-group">
            <div class="row">
              <div class="col">
                <label class="control-label">Dari Modul</label>
              </div>
            </div>
            <div class="row">
              <div class="col">
                <input type="hidden" name="idDari" id="idDari">
                <input type="text" name="namaDari" id="namaDari" class="form-control">
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col">
                <label class="control-label">Ke Modul</label>
              </div>
            </div>
            <div class="row">
              <div class="col">
                <input type="hidden" name="idKe" id="idKe">
                <input type="text" name="namaKe" id="namaKe" class="form-control">
              </div>
            </div>
            <hr>
            <button type="button" class="btn btn-sm btn-success btn-block" id="btnShow" onclick="proses()">Proses</button>
            <button class="btn btn-success btn-sm btn-block" type="button" disabled id="btnHide">
              <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
              Prosesing...
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>

<script>
  var table1 = $('#table');
  var table = $('#table');

  var btnShow = $('#btnShow');
  var btnHide = $('#btnHide');

  const form = $('#formModul');

  $(document).ready(function() {
    btnHide.hide()
  });

  function dari(id, nama) {
    $('#idDari').val(id);

    if (nama == '') {
      nama = 'Beranda';
    } else {
      nama = nama;
    }
    $('#namaDari').val(nama);
  }

  function ke(id, nama) {
    $('#idKe').val(id);

    if (nama == '') {
      nama = 'Beranda';
    } else {
      nama = nama;
    }
    $('#namaKe').val(nama);
  }

  function proses() {
    var idDari = $('#idDari').val();
    var idKe = $('#idKe').val();

    if (idDari == '' || idDari == null) {
      btnHide.hide();
      btnShow.show();

      Swal.fire({
        title: 'Dari Modul',
        text: 'Tidak boleh kosong',
        icon: 'error'
      });
      return;
    }

    if (idKe == '' || idKe == null) {
      btnHide.hide();
      btnShow.show();

      Swal.fire({
        title: 'Ke Modul',
        text: 'Tidak boleh kosong',
        icon: 'error'
      });
      return;
    }

    if (idDari == idKe) {
      btnHide.hide();
      btnShow.show();

      $('#idDari').val('');
      $('#namaDari').val('');
      $('#idKe').val('');
      $('#namaKe').val('');

      Swal.fire({
        title: 'Modul',
        text: 'Tidak boleh sama',
        icon: 'error'
      });
      return;
    }

    Swal.fire({
      title: "Yakin Ubah Posisi Modul?",
      text: "Posisi modul akan berubah!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Ya, ubah!"
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: siteUrl + 'C_modul/change/',
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
            } else {
              if (result.response == 1) {
                btnHide.hide();
                btnShow.show();

                Swal.fire({
                  title: 'Modul',
                  text: 'Berhasil diubah!',
                  icon: 'success'
                }).then((result) => {
                  location.href = siteUrl + 'C_modul';
                });

              } else {
                btnHide.hide();
                btnShow.show();

                Swal.fire({
                  title: 'Modul',
                  text: 'Gagal diubah, coba lagi!',
                  icon: 'error'
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