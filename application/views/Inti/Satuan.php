<form method="post" id="formSatuan">
    <div class="h4 mb-3 text-gray-800">Umum / satuan barang</div>

    <div class=" card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">List data satuan barang
                <?php if ($role_aksi->tambah > 0) : ?>
                    <button class="btn btn-primary btn-sm float-right" type="button" onclick="add_satuan()"><i class="fa fa-plus"></i> Tambah List</button>
                <?php endif; ?>
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="tableSatuan" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="mod_satuan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="forProses" id="forProses" value="1">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <div class="row">
                                    <label class="control-label col-sm-3">Kode</label>
                                    <div class="col-sm-9">
                                        <input type="hidden" name="id" id="id">
                                        <input type="text" name="kode" id="kode" class="form-control" readonly placeholder="Otomatis">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="control-label col-sm-3">Nama</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="nama" id="nama" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Tutup</button>
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

<script>
    // variable
    var table = $('#tableSatuan');
    const btnShow = $('#btnShow');
    const btnHide = $('#btnHide');
    const form = $('#formSatuan');

    var forProses = $('#forProses');
    var id = $('#id');
    var kode = $('#kode');
    var nama = $('#nama');

    $(document).ready(function() {
        btnHide.hide()
    });

    // another function
    function add_satuan() {
        forProses.val(1);
        $('.modal-title').text('Tambah Satuan');
        id.val('');
        kode.val('');
        nama.val('');
        $('#mod_satuan').modal('show');
    }

    function updated(idx) {
        $.ajax({
            url: siteUrl + 'Umum/show_data_satuan/' + idx,
            type: "POST",
            dataType: "JSON",
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
                        $('#mod_satuan').modal('show');
                        forProses.val(2);

                        id.val(idx);
                        kode.val(result.kode);
                        nama.val(result.nama);
                    } else {
                        btnShow.show();
                        btnHide.hide();

                        Swal.fire({
                            title: 'Data Satuan',
                            text: 'Tidak ada!',
                            icon: 'error'
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

    // function proses, update, and delete
    function proses() {
        btnShow.hide();
        btnHide.show();
        $('#mod_satuan').modal('hide');

        var cekProses = forProses.val();

        if (nama.val() == '') {
            btnShow.show();
            btnHide.hide();
            $('#mod_satuan').modal('show');

            Swal.fire({
                title: 'Nama',
                text: 'Tidak boleh kosong!',
                icon: 'error'
            });
            return;
        }

        $.ajax({
            url: siteUrl + 'Umum/proses_satuan/' + cekProses,
            type: "POST",
            data: form.serialize(),
            dataType: "JSON",
            success: function(result) {
                if (result == '' || result == null) {
                    btnShow.show();
                    btnHide.hide();
                    $('#mod_satuan').modal('hide');

                    Swal.fire({
                        title: '404',
                        text: 'Tidak ada respons dari sistem',
                        icon: 'error'
                    }).then((result) => {
                        $('#mod_satuan').modal('show');
                    });
                } else {
                    if (result.response == 1) {
                        btnShow.show();
                        btnHide.hide();
                        $('#mod_satuan').modal('hide');

                        Swal.fire({
                            title: 'Proses',
                            text: 'Berhasil dilakukan!',
                            icon: 'success'
                        }).then((result) => {
                            location.href = siteUrl + 'Umum/satuan';
                        });
                    } else {
                        btnShow.show();
                        btnHide.hide();
                        $('#mod_satuan').modal('hide');

                        Swal.fire({
                            title: 'Proses',
                            text: 'Gagak dilakukan!',
                            icon: 'warning'
                        }).then((result) => {
                            $('#mod_satuan').modal('show');
                        });
                    }
                }
            },
            error: function(result) {
                btnShow.show();
                btnHide.hide();
                $('#mod_satuan').modal('hide');

                Swal.fire({
                    title: '501',
                    text: 'Error Sistem',
                    icon: 'error'
                }).then((result) => {
                    $('#mod_satuan').modal('show');
                })
                return;
            }
        });
    }

    function deleted(idx) {
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
                    url: siteUrl + 'Umum/del_satuan/' + idx,
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
                                    location.href = siteUrl + 'Umum/satuan';
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