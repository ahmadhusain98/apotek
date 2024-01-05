<div class="h4 mb-3 text-gray-800"><?= $judul; ?></div>

<div class=" card shadow mb-4">
  <div class="card-header py-3">
    <nav class="nav nav-pills flex-column flex-sm-row">
      <a class="flex-sm-fill text-sm-center nav-link active" id="btnTab1" type="button" onclick="tab(1)">Modul</a>
      <a class="flex-sm-fill text-sm-center nav-link" id="btnTab2" type="button" onclick="tab(2)">Menu</a>
      <a class="flex-sm-fill text-sm-center nav-link" id="btnTab3" type="button" onclick="tab(3)">Sub Menu</a>
    </nav>
  </div>
  <div class="card-body">
    <div id="forTab1">
      <div class="row mb-3">
        <div class="col-md-12">
          <h6 class="m-0 font-weight-bold text-primary">List data Modul
            <button class="btn btn-primary btn-sm float-right" type="button"><i class="fa fa-plus"></i> Tambah Modul</button>
          </h6>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="table-responsive">
            <table class="table table-bordered" id="tableModul" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th style="width: 5%;">No</th>
                  <th style="width: 85%;">Modul</th>
                  <th style="width: 10%;">Aksi</th>
                </tr>
              </thead>
              <tbody id="bodyPengelolaId">
                <?php if (empty($modul)) : ?>
                  <tr>
                    <td colspan="6">
                      <div class="alert alert-danger text-center" role="alert">Data Kosong</div>
                    </td>
                  </tr>
                <?php else : ?>
                  <?php $no = 1;
                  foreach ($modul as $l) : ?>
                    <tr>
                      <td class="text-right"><?= $no; ?></td>
                      <td><?= ($l->nama == '') ? 'Beranda' : $l->nama; ?></td>
                      <td class="text-center">
                        <button type="button" class="btn btn-info btn-sm mb-1" data-bs-toggle="tooltip" title="Ubah Data Ke <?= $no ?>"><i class="fa-solid fa-repeat"></i></button>
                        <button type="button" class="btn btn-danger btn-sm mb-1" data-bs-toggle="tooltip" title="Hapus Data Ke <?= $no ?>"><i class="fa fa-ban"></i></button>
                      </td>
                    </tr>
                  <?php $no++;
                  endforeach; ?>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div id="forTab2">
      <div class="row mb-3">
        <div class="col-md-12">
          <h6 class="m-0 font-weight-bold text-primary">List data Menu
            <button class="btn btn-primary btn-sm float-right" type="button"><i class="fa fa-plus"></i> Tambah Menu</button>
          </h6>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="table-responsive">
            <table class="table table-bordered" id="tableMenu" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th style="width: 5%;">No</th>
                  <th>Menu</th>
                  <th>Modul</th>
                  <th style="width: 10%;">Aksi</th>
                </tr>
              </thead>
              <tbody id="bodyPengelolaId">
                <?php if (empty($menu)) : ?>
                  <tr>
                    <td colspan="6">
                      <div class="alert alert-danger text-center" role="alert">Data Kosong</div>
                    </td>
                  </tr>
                <?php else : ?>
                  <?php $nom = 1;
                  foreach ($menu as $m) : ?>
                    <tr>
                      <td class="text-right"><?= $nom; ?></td>
                      <td><?= $m->nama; ?></td>
                      <td><?= ($this->db->get_where('m_modul', ['id' => $m->id_modul])->row()->nama == '') ? 'Beranda' : $this->db->get_where('m_modul', ['id' => $m->id_modul])->row()->nama; ?></td>
                      <td class="text-center">
                        <button type="button" class="btn btn-info btn-sm mb-1" data-bs-toggle="tooltip" title="Ubah Data Ke <?= $nom ?>"><i class="fa-solid fa-repeat"></i></button>
                        <button type="button" class="btn btn-danger btn-sm mb-1" data-bs-toggle="tooltip" title="Hapus Data Ke <?= $nom ?>"><i class="fa fa-ban"></i></button>
                      </td>
                    </tr>
                  <?php $nom++;
                  endforeach; ?>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div id="forTab3">
      <div class="row mb-3">
        <div class="col-md-12">
          <h6 class="m-0 font-weight-bold text-primary">List data Sub Menu
            <button class="btn btn-primary btn-sm float-right" type="button"><i class="fa fa-plus"></i> Tambah Sub Menu</button>
          </h6>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="table-responsive">
            <table class="table table-bordered" id="tableSubMenu" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th style="width: 5%;">No</th>
                  <th>Sub Menu</th>
                  <th>Menu</th>
                  <th style="width: 10%;">Aksi</th>
                </tr>
              </thead>
              <tbody id="bodyPengelolaId">
                <?php if (empty($submenu)) : ?>
                  <tr>
                    <td colspan="6">
                      <div class="alert alert-danger text-center" role="alert">Data Kosong</div>
                    </td>
                  </tr>
                <?php else : ?>
                  <?php $nosm = 1;
                  foreach ($submenu as $sm) : ?>
                    <tr>
                      <td class="text-right"><?= $nosm; ?></td>
                      <td><?= $sm->nama; ?></td>
                      <td><?= ($this->db->get_where('menu', ['id' => $sm->id_menu])->row()->nama == '') ? 'Beranda' : $this->db->get_where('menu', ['id' => $sm->id_menu])->row()->nama; ?></td>
                      <td class="text-center">
                        <button type="button" class="btn btn-info btn-sm mb-1" data-bs-toggle="tooltip" title="Ubah Data Ke <?= $nosm ?>"><i class="fa-solid fa-repeat"></i></button>
                        <button type="button" class="btn btn-danger btn-sm mb-1" data-bs-toggle="tooltip" title="Hapus Data Ke <?= $nosm ?>"><i class="fa fa-ban"></i></button>
                      </td>
                    </tr>
                  <?php $nosm++;
                  endforeach; ?>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  var table = $('#tableModul');
  var table1 = $('#tableMenu');
  var table2 = $('#tableSubMenu');

  const btnTab1 = $('#btnTab1');
  const btnTab2 = $('#btnTab2');
  const btnTab3 = $('#btnTab3');
  const forTab1 = $('#forTab1');
  const forTab2 = $('#forTab2');
  const forTab3 = $('#forTab3');

  $(document).ready(function() {
    tab(1);
  });

  function tab(par) {
    if (par == 1) {
      btnTab1.addClass('active');
      btnTab2.removeClass('active');
      btnTab3.removeClass('active');

      forTab1.show();
      forTab2.hide();
      forTab3.hide();
    } else if (par == 2) {
      btnTab2.addClass('active');
      btnTab1.removeClass('active');
      btnTab3.removeClass('active');

      forTab2.show();
      forTab1.hide();
      forTab3.hide();
    } else {
      btnTab3.addClass('active');
      btnTab1.removeClass('active');
      btnTab2.removeClass('active');

      forTab3.show();
      forTab1.hide();
      forTab2.hide();
    }
  }
</script>