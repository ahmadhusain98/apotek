<form method="post" id="formBarang">
    <div class="h4 mb-3 text-gray-800"><?= $judul_form ?></div>

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
                    <div class="h6"># DATA DESKRIPSI</div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <input type="text" name="kode" id="kode" class="form-control" placeholder="Kode Barang Otomatis" readonly value="<?= (!empty($barang) ? $barang->kode : '') ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <input type="text" name="nama" id="nama" class="form-control" placeholder="Nama Barang..." value="<?= (!empty($barang) ? $barang->nama : '') ?>">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <select name="kategori" id="kategori" class="form-control select2_all" data-placeholder="Pilih Kategori...">
                            <option value="">Pilih Kategori...</option>
                            <?php foreach ($kategori as $k) : ?>
                                <option value="<?= $k->kode ?>" <?= (!empty($barang) ? (($barang->kategori == $k->kode) ? 'selected' : '') : '') ?>><?= $k->nama ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <select name="satuan" id="satuan" class="form-control select2_all" data-placeholder="Pilih Satuan...">
                            <option value="">Pilih Satuan...</option>
                            <?php foreach ($satuan as $s) : ?>
                                <option value="<?= $s->kode ?>" <?= (!empty($barang) ? (($barang->satuan == $s->kode) ? 'selected' : '') : '') ?>><?= $s->nama ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <textarea name="deskripsi" id="deskripsi" class="form-control" placeholder="Deskripsi Obat..."><?= (!empty($barang) ? $barang->deskripsi : '') ?></textarea>
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
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Beli</span>
                            </div>
                            <input type="text" name="harga_beli" id="harga_beli" class="form-control text-right" placeholder="Rp. Harga Beli..." value="<?= (!empty($harga) ? number_format($harga->harga_beli) : '0') ?>" onkeyup="formatRupiah(this.value, 'harga_beli')">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-5">
                                <select name="kena_pajak" id="kena_pajak" class="form-control select2_all" data-placeholder="Kena Pajak?" onchange="cek_pajak(this.value)">
                                    <option value="">Kena Pajak?</option>
                                    <option value="1" <?= (!empty($harga) ? (($harga->kena_pajak == 1) ? 'selected' : '') : '') ?>>Ya</option>
                                    <option value="2" <?= (!empty($harga) ? (($harga->kena_pajak == 2) ? 'selected' : '') : '') ?>>Tidak</option>
                                </select>
                            </div>
                            <div class="col-md-7">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">Beli PPN</span>
                                    </div>
                                    <input type="text" name="harga_beli_ppn" id="harga_beli_ppn" class="form-control text-right" placeholder="Rp. Harga Beli PPN..." value="<?= (!empty($harga) ? number_format($harga->harga_beli_ppn) : '0') ?>" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Net</span>
                            </div>
                            <input type="text" name="harga_net" id="harga_net" class="form-control text-right" placeholder="Rp. Harga NET..." value="<?= (!empty($harga) ? number_format($harga->harga_net) : '0') ?>" onkeyup="formatRupiah(this.value, 'harga_net')" onchange="cek_beli(this.value)">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Jual</span>
                            </div>
                            <input type="text" name="harga_jual" id="harga_jual" class="form-control text-right" placeholder="Rp. Harga Jual..." value="<?= (!empty($harga) ? number_format($harga->harga_jual) : '0') ?>" onkeyup="formatRupiah(this.value, 'harga_jual')" onchange="cek_net(this.value)">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <input type="hidden" name="prosesx" id="prosesx" value="<?= $prosesx ?>">
            <button type="button" class="btn btn-sm btn-primary" id="btnShow" onclick="proses()"><i class="fa-solid fa-server"></i> Proses</button>
            <button class="btn btn-primary btn-sm" type="button" disabled id="btnHide">
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                Mohon ditunggu...
            </button>
        </div>
    </div>
</form>

<script>
    $('.select2_all').select2({
        width: '100%',
        heigh: 'auto',
    })

    // variable
    var kode = $('#kode');
    var nama = $('#nama');
    var kategori = $('#kategori');
    var satuan = $('#satuan');
    var deskripsi = $('#deskripsi');
    var harga_beli = $('#harga_beli');
    var kena_pajak = $('#kena_pajak');
    var harga_beli_ppn = $('#harga_beli_ppn');
    var harga_net = $('#harga_net');
    var harga_jual = $('#harga_jual');
    var prosesx = $('#prosesx');

    const form = $('#formBarang');
    const btnShow = $('#btnShow');
    const btnHide = $('#btnHide');

    $(document).ready(function() {
        btnHide.hide();
        harga_net.attr('readonly', true);
    });

    function cek_pajak(pajak) {
        if (pajak == '') {
            harga_net.attr('readonly', true);
        } else {
            harga_net.attr('readonly', false);
        }

        var harga_belix = Number(parseInt((harga_beli.val()).replaceAll(',', '')));

        if (pajak < 2) {
            var hitung_pajak = harga_belix + (harga_belix * (11 / 100));
        } else {
            var hitung_pajak = harga_belix;
        }

        formatRupiah(hitung_pajak.toString(), 'harga_beli_ppn');
    }

    function cek_beli(net) {
        var hargan = Number(parseInt(net.replaceAll(',', '')));
        var hargabp = Number(parseInt((harga_beli_ppn.val()).replaceAll(',', '')));

        if (hargan < hargabp) {
            formatRupiah(harga_beli_ppn.val(), 'harga_net');
            Swal.fire({
                title: 'Harga net',
                text: 'Tidak boleh lebih dari harga beli ppn',
                icon: 'error'
            });
            return;
        }
    }

    function cek_net(jual) {
        var hargaj = Number(parseInt(jual.replaceAll(',', '')));
        var hargan = Number(parseInt((harga_net.val()).replaceAll(',', '')));

        if (hargaj > hargan) {
            formatRupiah(harga_net.val(), 'harga_jual');
            Swal.fire({
                title: 'Harga jual',
                text: 'Tidak boleh lebih dari harga net',
                icon: 'error'
            });
            return;
        }
    }

    function proses() {
        btnShow.hide();
        btnHide.show();

        if (prosesx.val() > 1) {
            if (kode.val() == '' || kode.val() == null) {
                btnShow.show();
                btnHide.hide();

                Swal.fire({
                    title: 'Kode barang',
                    text: 'Tidak boleh kosong',
                    icon: 'error'
                });
                return;
            }
        }

        if (nama.val() == '' || nama.val() == null) {
            btnShow.show();
            btnHide.hide();

            Swal.fire({
                title: 'Nama barang',
                text: 'Tidak boleh kosong',
                icon: 'error'
            });
            return;
        }

        if (kategori.val() == '' || kategori.val() == null) {
            btnShow.show();
            btnHide.hide();

            Swal.fire({
                title: 'Kategori barang',
                text: 'Tidak boleh kosong',
                icon: 'error'
            });
            return;
        }

        if (satuan.val() == '' || satuan.val() == null) {
            btnShow.show();
            btnHide.hide();

            Swal.fire({
                title: 'Satuan barang',
                text: 'Tidak boleh kosong',
                icon: 'error'
            });
            return;
        }

        if (Number(parseInt((harga_beli.val()).replaceAll(',', ''))) < 1) {
            btnShow.show();
            btnHide.hide();

            harga_beli.val(0)
            Swal.fire({
                title: 'Harga beli',
                text: 'Tidak boleh kurang dari 1 Rupiah',
                icon: 'error'
            });
            return;
        }

        if (kena_pajak.val() == '' || kena_pajak.val() == null) {
            btnShow.show();
            btnHide.hide();

            Swal.fire({
                title: 'Kena pajak',
                text: 'Tidak boleh kosong',
                icon: 'error'
            });
            return;
        }

        if (Number(parseInt((harga_net.val()).replaceAll(',', ''))) < 1) {
            btnShow.show();
            btnHide.hide();

            harga_net.val(0)
            Swal.fire({
                title: 'Harga net',
                text: 'Tidak boleh kurang dari 1 Rupiah',
                icon: 'error'
            });
            return;
        }

        if (Number(parseInt((harga_jual.val()).replaceAll(',', ''))) < 1) {
            btnShow.show();
            btnHide.hide();

            harga_jual.val(0)
            Swal.fire({
                title: 'Harga jual',
                text: 'Tidak boleh kurang dari 1 Rupiah',
                icon: 'error'
            });
            return;
        }

        if (prosesx.val() == 1) {
            var pesan_success = 'ditambahkan!';
            var pesan_error = 'ditambahkan, silahkan coba lagi!';
        } else {
            var pesan_success = 'diperbaharui!';
            var pesan_error = 'diperbaharui, silahkan coba lagi!';
        }

        $.ajax({
            url: siteUrl + 'Umum/proses_barang_aksi/' + prosesx.val(),
            type: 'POST',
            data: form.serialize(),
            dataType: 'JSON',
            success: function(result) {
                if (result == '' || result == null) {
                    btnShow.show();
                    btnHide.hide();

                    Swal.fire({
                        title: '404',
                        text: 'Tidak ada respons dari sistem',
                        icon: 'error'
                    });
                    return;
                } else {
                    if (result.response == 1) {
                        btnShow.show();
                        btnHide.hide();

                        Swal.fire({
                            title: 'Barang ' + nama.val(),
                            text: 'Berhasil ' + pesan_success,
                            icon: 'success'
                        }).then((result) => {
                            location.href = siteUrl + 'Umum/barang';
                        });
                    } else {
                        btnShow.show();
                        btnHide.hide();

                        Swal.fire({
                            title: 'Barang ' + nama.val(),
                            text: 'Gagak ' + pesan_error,
                            icon: 'warning'
                        });
                        return;
                    }
                }
            },
            error: function(result) {
                btnShow.show();
                btnHide.hide();

                Swal.fire({
                    title: '501',
                    text: 'Error Sistem',
                    icon: 'error'
                })
                return;
            }
        });
    }
</script>