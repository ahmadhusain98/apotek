<?= $kode ?>
<form method="post" id="formUnit">
    <div class="h4 mb-3 text-gray-800">Tambah Barang</div>

    <div class=" card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form barang
                <button type="button" class="btn btn-sm float-right btn-danger" title="Kembali" onclick="get_menu('<?= $menu ?>')"><i class="fa-solid fa-circle-arrow-left"></i> Kembali</button>
                <button type="button" class="btn btn-sm float-right btn-info mr-1" title="Kembali" onclick="infoHarga()"><i class="fa-solid fa-circle-question"></i> Harga di unit lain</button>
            </h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="h6"># DATA MASTER</div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <input type="text" name="kode" id="kode" class="form-control" placeholder="Kode Barang Otomatis" readonly>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <input type="text" name="nama" id="nama" class="form-control" placeholder="Nama Barang...">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <select name="kategori" id="kategori" class="form-control select2_all" data-placeholder="Pilih Kategori...">
                            <option value="">Pilih Kategori...</option>
                            <?php foreach ($kategori as $k) : ?>
                                <option value="<?= $k->kode ?>"><?= $k->nama ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <select name="satuan" id="satuan" class="form-control select2_all" data-placeholder="Pilih Satuan...">
                            <option value="">Pilih Satuan...</option>
                            <?php foreach ($satuan as $s) : ?>
                                <option value="<?= $s->kode ?>"><?= $s->nama ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <textarea name="deskripsi" id="deskripsi" class="form-control" placeholder="Deskripsi Obat..."></textarea>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-12">
                    <div class="h6"># DATA HARGA</div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <input type="text" name="harga_beli" id="harga_beli" class="form-control" placeholder="Rp. Harga Beli...">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <select name="kena_pajak" id="kena_pajak" class="form-control select2_all" data-placeholder="Kena Pajak?">
                            <option value="">Kena Pajak?</option>
                            <option value="1">Ya</option>
                            <option value="2">Tidak</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <input type="text" name="harga_net" id="harga_net" class="form-control" placeholder="Rp. Harga NET...">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <input type="text" name="harga_jual" id="harga_jual" class="form-control" placeholder="Rp. Harga Jual...">
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="button" class="btn btn-sm btn-primary"><i class="fa-solid fa-server"></i> Proses</button>
        </div>
    </div>
</form>

<script>
    $('.select2_all').select2({
        width: '100%',
        heigh: 'auto',
    })
</script>