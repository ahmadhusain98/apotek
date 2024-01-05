<div class="h4 mb-3 text-gray-800">Pengguna / pengelola</div>

<div class=" card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">List data pengelola
      <button class="btn btn-primary btn-sm float-right" type="button"><i class="fa fa-plus"></i> Tambah List</button>
    </h6>
  </div>
  <div class="card-body">
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
          <?php if (empty($list)) : ?>
            <tr>
              <td colspan="6">
                <div class="alert alert-danger text-center" role="alert">Data Kosong</div>
              </td>
            </tr>
          <?php else : ?>
            <?php $no = 1;
            foreach ($list as $l) : ?>
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

<script>
  var table = $('#tableModul');
</script>