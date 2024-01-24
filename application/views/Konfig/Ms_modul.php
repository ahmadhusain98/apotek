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
    <div id="contentForm"></div>
    <div class="row" id="forTab1">
      <div class="col-sm-12">
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
                    <button type="button" class="btn btn-info btn-sm mb-1" data-bs-toggle="tooltip" title="Ubah Data<?= $nama; ?>"><i class="fa-solid fa-repeat"></i></button>
                    <button type="button" class="btn btn-danger btn-sm mb-1" data-bs-toggle="tooltip" title="Hapus Data<?= $nama; ?>"><i class="fa fa-ban"></i></button>
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

<script>
  var textTab = $('#textTab');

  const btnTab1 = $('#btnTab1');
  const btnTab2 = $('#btnTab2');
  const btnTab3 = $('#btnTab3');
  const forTab1 = $('#forTab1');
  const forTab2 = $('#forTab2');
  const forTab3 = $('#forTab3');

  const contentForm = $("#contentForm")
  var parameteForm = $("#parameteForm")

  $(document).ready(function() {
    tab(1);
  });

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
</script>

<!-- datatable -->
<script>
  var tableModul = $('#tableModul').DataTable({
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

  var tableMenu = $('#tableMenu').DataTable({
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

  var tableSubMenu = $('#tableSubMenu').DataTable({
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