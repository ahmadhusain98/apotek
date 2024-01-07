<div class="h4 mb-3 text-gray-800">Pengguna / pengelola</div>

<div class=" card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">List data pengelola
      <button class="btn btn-primary btn-sm float-right" type="button"><i class="fa fa-plus"></i> Tambah List</button>
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
        <tbody>
          <?php $no = 1;
          foreach ($list as $l) : ?>
            <tr>
              <td><?= $no; ?></td>
              <td><?= $l->username; ?></td>
              <td><?= $l->nama; ?></td>
              <td><?= $l->nohp; ?></td>
              <td><?= ($l->status_aktif > 0) ? 'Aktif' : 'Non-aktif'; ?></td>
              <td><?= $this->db->get_where('m_role', ['kode' => $l->kode_role])->row()->keterangan; ?></td>
              <td class="text-center">
                <button type="button" class="btn btn-info btn-sm mb-1" data-bs-toggle="tooltip" title="Ubah Data Ke <?= $no ?>"><i class="fa-solid fa-repeat"></i></button>
                <button type="button" class="btn btn-danger btn-sm mb-1" data-bs-toggle="tooltip" title="Hapus Data Ke <?= $no ?>"><i class="fa fa-ban"></i></button>
              </td>
            </tr>
          <?php $no++;
          endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<script>
  var table = $('#tablePengelola');
</script>