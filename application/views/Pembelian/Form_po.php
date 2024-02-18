<form method="post" id="formBarang">
    <div class="h4 mb-3 text-gray-800"><?= $judul_form ?></div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form <i>pre order</i>
                <button type="button" class="btn btn-sm float-right btn-danger" title="Kembali" onclick="get_menu('<?= $menu ?>')"><i class="fa-solid fa-circle-arrow-left"></i> Kembali</button>
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
                        <div class="row">
                            <label for="" class="control-label col-md-3">Invoice <sup class="text-danger">*</sup></label>
                            <div class="col-md-9">
                                <input type="text" name="invoice" id="invoice" class="form-control" placeholder="Otomatis" readonly value="<?= (!empty($header) ? $header->invoice : '') ?>">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="row">
                            <label for="" class="control-label col-md-3">Dikirim <i>by</i><sup class="text-danger">*</sup></label>
                            <div class="col-md-9">
                                <select name="kirimby" id="kirimby" class="form-control select2_all" data-placeholder="Pilih...">
                                    <option value="">Pilih...</option>
                                    <option value="WA">WA</option>
                                    <option value="SMS">SMS</option>
                                    <option value="EMAIL">EMAIL</option>
                                    <option value="TELP">TELP</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="row">
                            <label for="" class="control-label col-md-3">Tgl <i>Pre Order</i></label>
                            <div class="col-md-9">
                                <input type="date" name="tglpo" id="tglpo" class="form-control" value="<?= (!empty($header) ? date('Y-m-d', strtotime($header->tglpo)) : date('Y-m-d')) ?>">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="row">
                            <label for="" class="control-label col-md-3">Tgl Kirim</label>
                            <div class="col-md-9">
                                <input type="date" name="tglkirim" id="tglkirim" class="form-control" value="<?= (!empty($header) ? date('Y-m-d', strtotime($header->tglkirim)) : date('Y-m-d')) ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="row">
                            <label for="" class="control-label col-md-3"><i>Supplier</i> <sup class="text-danger">*</sup></label>
                            <div class="col-md-9">
                                <select name="kode_vendor" id="kode_vendor" class="form-control select2_all" data-placeholder="Pilih...">
                                    <option value="">Pilih</option>
                                    <?php foreach ($vendor as $v) : ?>
                                        <option value="<?= $v->kode ?>"><?= $v->nama ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="row">
                            <label for="" class="control-label col-md-3">Gudang <sup class="text-danger">*</sup></label>
                            <div class="col-md-9">
                                <select name="kode_gudang" id="kode_gudang" class="form-control select2_all" data-placeholder="Pilih...">
                                    <option value="">Pilih</option>
                                    <?php foreach ($gudang as $g) : ?>
                                        <option value="<?= $g->kode ?>"><?= $g->nama ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="row">
                            <label for="" class="control-label col-md-3">No. <i>References</i></label>
                            <div class="col-md-9">
                                <input type="text" name="noref" id="noref" class="form-control" placeholder="Nomor References">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="row">
                            <label for="" class="control-label col-md-3">PO <i>Internal</i></label>
                            <div class="col-md-9">
                                <select name="interpo" id="interpo" class="form-control select2_all" data-placeholder="Pilih...">
                                    <option value="0">Tidak</option>
                                    <option value="1">Ya</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-12">
                    <div class="h6"># DATA DETAIL</div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="tableHarga" width="100%">
                            <thead>
                                <tr class="bg-primary text-white">
                                    <th rowspan="2" style="width: 5%">Hapus</th>
                                    <th rowspan="2" style="width: 30%">Barang</th>
                                    <th rowspan="2" style="width: 10%">Satuan</th>
                                    <th rowspan="2" style="width: 10%">Harga</th>
                                    <th rowspan="2" style="width: 10%">Qty</th>
                                    <th colspan="2" class="text-center" style="width: 20%">Diskon</th>
                                    <th rowspan="2" style="width: 5%">PPN</th>
                                    <th rowspan="2" style="width: 10%">Total</th>
                                </tr>
                                <tr class="bg-primary text-white">
                                    <th style="width: 10%">(%)</th>
                                    <th style="width: 10%">(Rp)</th>
                                </tr>
                            </thead>
                            <tbody id="table_body">
                                <tr id="row_po1">
                                    <td class="text-center">
                                        <button type="button" class="btn btn-danger btn-sm" onclick="hapus_col('1')"><i class="fa fa-times-circle"></i></button>
                                    </td>
                                    <td style="width: 30%">
                                        <select name="kode_barang[]" id="kode_barang1" class="form-control select2_barang input-group-lg" data-placeholder="Pilih Barang..."></select>
                                    </td>
                                    <td>
                                        <input type="text" name="satuan[]" id="satuan1" class="form-control" readonly>
                                    </td>
                                    <td>
                                        <input type="text" name="harga[]" id="harga1" class="form-control text-right" readonly value="0">
                                    </td>
                                    <td>
                                        <input type="text" name="qty[]" id="qty1" class="form-control text-right" value="1">
                                    </td>
                                    <td>
                                        <input type="text" name="discpr[]" id="discpr1" class="form-control text-right" readonly value="0">
                                    </td>
                                    <td>
                                        <input type="text" name="discrp[]" id="discrp1" class="form-control text-right" readonly value="0">
                                    </td>
                                    <td>
                                        <input type="checkbox" name="ppn[]" id="ppn1" class="form-control">
                                        <input type="hidden" name="ppnrp[]" id="ppnrp1" value="0">
                                    </td>
                                    <td>
                                        <input type="text" name="jumlah[]" id="jumlah1" class="form-control text-right" readonly value="0">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <button class="btn btn-primary" type="button" style="width: 100%;" onclick="tambah_row()"><i class="fa fa-plus-circle"></i> Tambah Barang</button>
                </div>
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="row">
                                            <label for="" class="control-label col-md-3">Subtotal</label>
                                            <div class="col-md-9">
                                                <input type="text" name="subtotal" id="subtotal" class="form-control text-right" value="0" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="row">
                                            <label for="" class="control-label col-md-3">Diskon</label>
                                            <div class="col-md-9">
                                                <input type="text" name="subdiskon" id="subdiskon" class="form-control text-right" value="0" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="row">
                                            <label for="" class="control-label col-md-3">PPN</label>
                                            <div class="col-md-9">
                                                <input type="text" name="subppn" id="subppn" class="form-control text-right" value="0" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="row">
                                            <label for="" class="control-label col-md-3">DPP</label>
                                            <div class="col-md-9">
                                                <input type="text" name="subdpp" id="subdpp" class="form-control text-right" value="0" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <button type="button" class="btn btn-danger" style="width: 100%;" onclick="reset_detail()"><i class="fa fa-refresh"></i> <i>Reset Data Detail</i></button>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="row">
                                            <label for="" class="control-label col-md-3">Total</label>
                                            <div class="col-md-9">
                                                <input type="text" name="totalsemua" id="totalsemua" class="form-control text-right" value="0" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    $(document).ready(function() {
        var cabang = '<?= $cabang; ?>';
        initailizeSelect2_barang(cabang);
    });

    var row = 2;

    function tambah_row() {
        var body = $('#table_body');
        body.append(`<tr id="row_po${row}">
            <td class="text-center">
                <button type="button" class="btn btn-danger btn-sm" onclick="hapus_col('${row}')"><i class="fa fa-times-circle"></i></button>
            </td>
            <td style="width: 30%">
                <select name="kode_barang[]" id="kode_barang${row}" class="form-control select2_barang" data-placeholder="Pilih Barang..."></select>
            </td>
            <td>
                <input type="text" name="satuan[]" id="satuan${row}" class="form-control" readonly>
            </td>
            <td>
                <input type="text" name="harga[]" id="harga${row}" class="form-control text-right" readonly value="0">
            </td>
            <td>
                <input type="text" name="qty[]" id="qty${row}" class="form-control text-right" value="1">
            </td>
            <td>
                <input type="text" name="discpr[]" id="discpr${row}" class="form-control text-right" readonly value="0">
            </td>
            <td>
                <input type="text" name="discrp[]" id="discrp${row}" class="form-control text-right" readonly value="0">
            </td>
            <td>
                <input type="checkbox" name="ppn[]" id="ppn${row}" class="form-control">
                <input type="hidden" name="ppnrp[]" id="ppnrp${row}" value="0">
            </td>
            <td>
                <input type="text" name="jumlah[]" id="jumlah${row}" class="form-control text-right" readonly value="0">
            </td>
        </tr>`);
        var cabang = '<?= $cabang ?>';
        initailizeSelect2_barang(cabang);
        row++;
    }

    function hapus_col(col) {
        $('#row_po' + col).remove();
    }

    function reset_detail() {
        $('#table_body').empty();
        tambah_row();
    }
</script>