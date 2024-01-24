<div class="h4 mb-3 text-gray-800">
  <?= $judul; ?>
</div>

<div class=" card shadow mb-4">
  <div class="card-header py-3">
    <nav class="nav nav-pills flex-column flex-sm-row">
      <a class="flex-sm-fill text-sm-center nav-link active" id="btnTab1" type="button" onclick="tab(1)">Modul</a>
      <a class="flex-sm-fill text-sm-center nav-link" id="btnTab2" type="button" onclick="tab(2)">Menu</a>
      <a class="flex-sm-fill text-sm-center nav-link" id="btnTab3" type="button" onclick="tab(3)">Sub Menu</a>
      <input type="hidden" id="parameteForm" class="form-control" value="1">
    </nav>
  </div>
  <div class="card-body">
    <div class="row" id="forTab1">
      <div class="col-sm-12">
        <div class="row mb-3">
          <div class="col-sm-12">
            <button type="button" class="btn btn-sm btn-primary float-right" onclick="tambah(1)"><i class="fa fa-plus"></i> Tambah Modul</button>
          </div>
        </div>
        <div class="table-responsive">
          <table class="table table-bordered" id="tableModul" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th width="5%">No</th>
                <th>Nama Modul</th>
                <th width="10%">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php $no = 1;
              foreach ($modul as $mo) : ?>
                <?php if ($mo->nama == '') {
                  $nama = 'Beranda';
                } else {
                  $nama = $mo->nama;
                } ?>
                <tr>
                  <td><?= $no ?></td>
                  <td><?= $nama ?></td>
                  <td class="text-center">
                    <button type="button" class="btn btn-info btn-sm mb-1" data-bs-toggle="tooltip" title="Ubah Data<?= $nama; ?>" onclick="show_data('<?= $mo->id; ?>')"><i class="fa-solid fa-repeat"></i></button>
                    <button type="button" class="btn btn-danger btn-sm mb-1" data-bs-toggle="tooltip" title="Hapus Data<?= $nama; ?>" onclick="del_data(1, '<?= $mo->id; ?>')"><i class="fa fa-ban"></i></button>
                  </td>
                </tr>
              <?php $no++;
              endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="row" id="forTab2">
      <div class="col-sm-12">
        <div class="table-responsive">
          <table class="table table-bordered" id="tableMenu" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th width="5%">No</th>
                <th>Nama Menu</th>
                <th>Bagian Modul</th>
                <th width="10%">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php $nom = 1;
              foreach ($menu as $me) : ?>
                <?php
                if ($this->M_central->getDataRow('m_modul', ['id' => $me->id_modul])->nama == '') {
                  $nama_modul = 'Beranda';
                } else {
                  $nama_modul = $this->M_central->getDataRow('m_modul', ['id' => $me->id_modul])->nama;
                }
                ?>
                <tr>
                  <td><?= $nom ?></td>
                  <td><?= $me->nama ?></td>
                  <td><?= $nama_modul ?></td>
                  <td class="text-center">
                    <button type="button" class="btn btn-info btn-sm mb-1" data-bs-toggle="tooltip" title="Ubah Data <?= $me->nama ?>"><i class="fa-solid fa-repeat"></i></button>
                    <button type="button" class="btn btn-danger btn-sm mb-1" data-bs-toggle="tooltip" title="Hapus Data <?= $me->nama ?>"><i class="fa fa-ban"></i></button>
                  </td>
                </tr>
              <?php $nom++;
              endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="row" id="forTab3">
      <div class="col-sm-12">
        <div class="table-responsive">
          <table class="table table-bordered" id="tableSubMenu" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th width="5%">No</th>
                <th>Nama Sub Menu</th>
                <th>Bagian Menu</th>
                <th width="10%">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php $nos = 1;
              foreach ($submenu as $sm) : ?>
                <tr>
                  <td><?= $nos ?></td>
                  <td><?= $sm->nama ?></td>
                  <td><?= $this->M_central->getDataRow('menu', ['id' => $sm->id_menu])->nama; ?></td>
                  <td class="text-center">
                    <button type="button" class="btn btn-info btn-sm mb-1" data-bs-toggle="tooltip" title="Ubah Data <?= $sm->nama ?>"><i class="fa-solid fa-repeat"></i></button>
                    <button type="button" class="btn btn-danger btn-sm mb-1" data-bs-toggle="tooltip" title="Hapus Data <?= $sm->nama ?>"><i class="fa fa-ban"></i></button>
                  </td>
                </tr>
              <?php $nos++;
              endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<form methid="post" id="formMaster">
  <div class="modal fade" id="m_master" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="forParam" id="forParam" value="0">
          <div id="bodyModal"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
          <button type="button" class="btn btn-sm btn-primary" onclick="proses()" id="btnShow">Proses</button>
          <button class="btn btn-primary btn-sm" type="button" disabled id="btnHide">
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            Mohon ditunggu...
          </button>
        </div>
      </div>
    </div>
  </div>
</form>

<!-- variable -->
<script>
  var textTab = $('#textTab');
  var forParam = $('#forParam');
  var btnShow = $('#btnShow');
  var btnHide = $('#btnHide');
  const form = $('#formMaster');

  const btnTab1 = $('#btnTab1');
  const btnTab2 = $('#btnTab2');
  const btnTab3 = $('#btnTab3');
  const forTab1 = $('#forTab1');
  const forTab2 = $('#forTab2');
  const forTab3 = $('#forTab3');
  var parameteForm = $("#parameteForm");

  $(document).ready(function() {
    btnHide.hide()
    tab(<?= $tabFor ?>);
  });
</script>

<!-- datatable -->
<script>
  $('#tableModul').DataTable({
    destroy: true,
    processing: true,
    responsive: true,
    serverSide: false,
    order: [],
    scrollCollapse: false,
    paging: true,
    oLanguage: {
      sEmptyTable: "<div class='text-center'>Data Kosong</div>",
      sInfoEmpty: "",
      sInfoFiltered: " - Dipilih dari _TOTAL_ data",
      sSearch: "Cari : ",
      sInfo: " Jumlah _TOTAL_ Data (_START_ - _END_)",
      sLengthMenu: "_MENU_ Baris",
      sZeroRecords: "<div class='text-center'>Data Kosong</div>",
      oPaginate: {
        sPrevious: "Sebelumnya",
        sNext: "Berikutnya"
      }
    },
    aLengthMenu: [
      [5, 15, 20, -1],
      [5, 15, 20, "Semua"]
    ],
    columnDefs: [{
      targets: [-1],
      orderable: false,
    }, ],
  })

  $('#tableMenu').DataTable({
    destroy: true,
    processing: true,
    responsive: true,
    serverSide: false,
    order: [],
    scrollCollapse: false,
    paging: true,
    oLanguage: {
      sEmptyTable: "<div class='text-center'>Data Kosong</div>",
      sInfoEmpty: "",
      sInfoFiltered: " - Dipilih dari _TOTAL_ data",
      sSearch: "Cari : ",
      sInfo: " Jumlah _TOTAL_ Data (_START_ - _END_)",
      sLengthMenu: "_MENU_ Baris",
      sZeroRecords: "<div class='text-center'>Data Kosong</div>",
      oPaginate: {
        sPrevious: "Sebelumnya",
        sNext: "Berikutnya"
      }
    },
    aLengthMenu: [
      [5, 15, 20, -1],
      [5, 15, 20, "Semua"]
    ],
    columnDefs: [{
      targets: [-1],
      orderable: false,
    }, ],
  })

  $('#tableSubMenu').DataTable({
    destroy: true,
    processing: true,
    responsive: true,
    serverSide: false,
    order: [],
    scrollCollapse: false,
    paging: true,
    oLanguage: {
      sEmptyTable: "<div class='text-center'>Data Kosong</div>",
      sInfoEmpty: "",
      sInfoFiltered: " - Dipilih dari _TOTAL_ data",
      sSearch: "Cari : ",
      sInfo: " Jumlah _TOTAL_ Data (_START_ - _END_)",
      sLengthMenu: "_MENU_ Baris",
      sZeroRecords: "<div class='text-center'>Data Kosong</div>",
      oPaginate: {
        sPrevious: "Sebelumnya",
        sNext: "Berikutnya"
      }
    },
    aLengthMenu: [
      [5, 15, 20, -1],
      [5, 15, 20, "Semua"]
    ],
    columnDefs: [{
      targets: [-1],
      orderable: false,
    }, ],
  })
</script>

<!-- another function -->
<script>
  function tab(par) {
    parameteForm.val(par)
    if (par == 1) {
      textTab.text('Modul');
      btnTab1.addClass('active');
      btnTab2.removeClass('active');
      btnTab3.removeClass('active');

      forTab1.show();
      forTab2.hide();
      forTab3.hide();
    } else if (par == 2) {
      textTab.text('Menu');
      btnTab2.addClass('active');
      btnTab1.removeClass('active');
      btnTab3.removeClass('active');

      forTab2.show();
      forTab1.hide();
      forTab3.hide();
    } else {
      textTab.text('Sub Menu');
      btnTab3.addClass('active');
      btnTab1.removeClass('active');
      btnTab2.removeClass('active');

      forTab3.show();
      forTab1.hide();
      forTab2.hide();
    }
  }

  function change_name(name) {
    var besar = name.charAt(0).toUpperCase();
    var kecil = name.slice(1);

    $('#nama_modul').val(besar + kecil);
  }

  function tambah(param) {
    $('#m_master').modal('show');
    var body = $('#bodyModal');
    body.empty('')
    forParam.val(param)
    if (param == 1) {
      $('.modal-title').text('Tambah Modul');
      body.append(`<div class="row">
        <div class="col-sm-12">
          <div class="form-group">
            <div class="row">
              <label class="control-label col-sm-3">Nama Modul</label>
              <div class="col-sm-9">
                <input type="text" name="nama_modul" id="nama_modul" class="form-control" onkeyup="change_name(this.value)">
              </div>
            </div>
          </div>
        </div>
      </div>`);
    }
  }
</script>

<!-- function proses, update, and del -->
<script>
  function proses() {
    var param = forParam.val();
    btnShow.hide();
    btnHide.show();

    if (param == 1) {
      var nama_modul = $('#nama_modul').val();
      if (nama_modul == '') {
        btnShow.show();
        btnHide.hide();

        Swal.fire({
          title: 'Nama Modul',
          text: 'Tidak boleh kosong',
          icon: 'error'
        });
        return;
      }

      $.ajax({
        url: siteUrl + 'C_modul/proses/' + param,
        type: 'POST',
        data: form.serialize(),
        dataType: 'JSON',
        success: function(result) {
          if (result == '' || result == null) {
            btnShow.show();
            btnHide.hide();
            $('#m_master').modal('hide');

            Swal.fire({
              title: '404',
              text: 'Tidak ada respons dari sistem',
              icon: 'error'
            }).then((result) => {
              $('#m_master').modal('show');
            });
          } else {
            if (result.response == 1) {
              btnShow.show();
              btnHide.hide();
              $('#m_master').modal('hide');

              Swal.fire({
                title: 'Proses',
                text: 'Berhasil dilakukan!',
                icon: 'success'
              }).then((result) => {
                if (param == 1) {
                  location.href = siteUrl + 'C_modul/l_modul/' + param;
                }
                tab(param);
              });
            } else {
              btnShow.show();
              btnHide.hide();
              $('#m_master').modal('hide');

              Swal.fire({
                title: 'Proses',
                text: 'Gagak dilakukan!',
                icon: 'warning'
              }).then((result) => {
                $('#m_master').modal('show');
              });
            }
          }
        },
        error: function(result) {
          btnShow.show();
          btnHide.hide();
          $('#m_master').modal('hide');

          Swal.fire({
            title: '501',
            text: 'Error Sistem',
            icon: 'error'
          }).then((result) => {
            $('#m_master').modal('show');
          })
          return;
        }
      })
    }
  }

  function del_data(param, id) {
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
          url: siteUrl + 'C_modul/deleted_proses/' + param + '/' + id,
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
                  title: 'Data',
                  text: 'Berhasil dihapus!',
                  icon: 'success'
                }).then((result) => {
                  if (param == 1) {
                    location.href = siteUrl + 'C_modul/l_modul/' + param;
                  }
                });
              } else {
                Swal.fire({
                  title: 'Data',
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