<form method="post" id="formUnit">
    <div class="h4 mb-3 text-gray-800">Barang
        <div class="btn-group float-right" role="group" aria-label="Basic example">
            <button type="button" class="btn btn-dark btn-sm" disabled>Video Tutorial <i class="fa fa-arrow-alt-circle-right"></i></button>
            <button type="button" class="btn btn-info btn-sm" title="Tutorial Tambah" onclick="tutor(1)"><i class="fa fa-plus"></i></button>
            <button type="button" class="btn btn-info btn-sm" title="Tutorial Ubah" onclick="tutor(2)"><i class="fa fa-repeat"></i></button>
            <button type="button" class="btn btn-info btn-sm" title="Tutorial Hapus" onclick="tutor(3)"><i class="fa fa-ban"></i></button>
        </div>
    </div>

    <div class=" card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">List data barang
                <button type="button" class="btn btn-sm float-right" style="background-color: transparent; border: 0px;" title="Informasi" onclick="forInfo()"><i class="fa fa-2x fa-info-circle text-info"></i></button>
                <?php if ($role_aksi->tambah > 0) : ?>
                    <a class="btn btn-primary btn-sm float-right" type="button" href="<?= site_url() ?>Umum/proses_barang"><i class="fa fa-plus"></i> Tambah List</a>
                <?php endif; ?>
            </h6>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-4">
                            <select name="kode_unit" id="kode_unit" class="form-control select2_all" data-placeholder="Pilih Unit..." onchange="filter()">
                                <option value="">Pilih Unit...</option>
                                <?php foreach ($m_unit as $unit) : ?>
                                    <option value="<?= $unit->kode_unit ?>"><?= $unit->nama_unit ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <select name="kategori" id="kategori" class="form-control select2_all" data-placeholder="Pilih Kategori..." onchange="filter()">
                                <option value="">Pilih Kategori...</option>
                                <?php foreach ($m_kategori as $kategori) : ?>
                                    <option value="<?= $kategori->kode ?>"><?= $kategori->nama ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <select name="satuan" id="satuan" class="form-control select2_all" data-placeholder="Pilih Satuan..." onchange="filter()">
                                <option value="">Pilih Satuan...</option>
                                <?php foreach ($m_satuan as $satuan) : ?>
                                    <option value="<?= $satuan->kode ?>"><?= $satuan->nama ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="tableUnit" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th rowspan="2" width="5%">No</th>
                                    <th rowspan="2">Unit</th>
                                    <th rowspan="2">Kode</th>
                                    <th rowspan="2">Nama</th>
                                    <th rowspan="2">Kategori</th>
                                    <th rowspan="2">Satuan</th>
                                    <th colspan="4" class="text-center">Harga</th>
                                    <th rowspan="2">Deskripsi</th>
                                    <th rowspan="2">Aksi</th>
                                </tr>
                                <tr>
                                    <th>Beli</th>
                                    <th>Beli + PPN</th>
                                    <th>NET</th>
                                    <th>Jual</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    var table = $('#tableUnit');

    function filter() {
        var fil1 = $('#kode_unit').val();
        var fil2 = $('#kategori').val();
        var fil3 = $('#satuan').val();
        table.DataTable().ajax.url("<?= site_url() . $list_ajax ?>" + fil1).load();
    }

    function deleted(kodex) {
        Swal.fire({
            title: "Anda yakin, barang akan di hapus di semua unit?",
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
                    url: siteUrl + 'Umum/deleted_barang/' + kodex,
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
                                    title: 'Barang',
                                    text: 'Berhasil dihapus!',
                                    icon: 'success'
                                }).then((result) => {
                                    location.href = siteUrl + 'Umum/barang';
                                });
                            } else {
                                Swal.fire({
                                    title: 'Barang',
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