<form method="post" id="formVendor">
    <div class="h4 mb-3 text-gray-800">Umum / vendor
        <div class="btn-group float-right" role="group" aria-label="Basic example">
            <button type="button" class="btn btn-dark btn-sm" disabled>Video Tutorial <i class="fa fa-arrow-alt-circle-right"></i></button>
            <button type="button" class="btn btn-info btn-sm" title="Tutorial Tambah" onclick="tutor(1)"><i class="fa fa-plus"></i></button>
            <button type="button" class="btn btn-info btn-sm" title="Tutorial Ubah" onclick="tutor(2)"><i class="fa fa-repeat"></i></button>
            <button type="button" class="btn btn-info btn-sm" title="Tutorial Hapus" onclick="tutor(3)"><i class="fa fa-ban"></i></button>
        </div>
    </div>

    <div class=" card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">List data vendor
                <button type="button" class="btn btn-sm float-right" style="background-color: transparent; border: 0px;" title="Informasi" onclick="forInfo()"><i class="fa fa-2x fa-info-circle text-info"></i></button>
                <?php if ($role_aksi->tambah > 0) : ?>
                    <button class="btn btn-primary btn-sm float-right" type="button" onclick="add_vendor()"><i class="fa fa-plus"></i> Tambah List</button>
                <?php endif; ?>
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="tableVendor" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>No Hp</th>
                            <th>Email</th>
                            <th>Transaksi Terakhir</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="mod_vendor" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="hidden" name="id" id="id">
                                <input type="text" title="Kode Vendor" class="form-control" id="kode" name="kode" placeholder="Kode Vendor..." onkeyup="delspace(this.value)">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" title="Nama Vendor" class="form-control" id="nama" name="nama" placeholder="Nama Vendor...">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" title="No Hp" class="form-control" id="nohp" name="nohp" placeholder="No Hp...">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="mail" title="Email" class="form-control" id="email" name="email" placeholder="Email...">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <textarea name="alamat" title="Alamat" id="alamat" class="form-control" placeholder="Alamat..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Tutup</button>
                    <input type="hidden" name="prosesx" id="prosesx" value="1">
                    <button type="button" class="btn btn-primary btn-sm" onclick="proses()" id="btnShow">Proses</button>
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
    var table = $('#tableVendor');

    var id = $('#id');
    var kode = $('#kode');
    var nama = $('#nama');
    var nohp = $('#nohp');
    var email = $('#email');
    var alamat = $('#alamat');
    var prosesx = $('#prosesx');

    const btnShow = $('#btnShow');
    const btnHide = $('#btnHide');
    const form = $('#formVendor');

    $(document).ready(function() {
        btnHide.hide()
    });

    // another function
    function delspace(param) {
        var kodex = param.trim();
        kode.val(kodex);
    }

    function add_vendor() {
        $('#mod_vendor').modal('show');
        $('.modal-title').text('Tambah Vendor');
        id.val('');
        kode.val('');
        kode.attr('disabled', false);
        nama.val('');
        nohp.val('');
        email.val('');
        alamat.val('');
        prosesx.val(1);
    }

    function updated(idx) {
        $.ajax({
            url: siteUrl + 'Umum/getVendor/' + idx,
            type: 'POST',
            data: form.serialize(),
            dataType: 'JSON',
            success: function(result) {
                $('#mod_vendor').modal('show');
                $('.modal-title').text('Update Vendor');
                id.val(idx);
                kode.val(result.kode);
                kode.attr('disabled', true);
                nama.val(result.nama);
                nohp.val(result.nohp);
                email.val(result.email);
                alamat.val(result.alamat);
                prosesx.val(2);
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

    // function proses entri, update, status, and delete
    function updated_status(idx, nama, status) {
        if (status < 1) {
            var titlex = 'Mengaktifkan';
            var text = 'diaktifkan';
            var text2 = 'aktifkan';
        } else {
            var titlex = 'Menonaktifkan';
            var text = 'dinonaktifkan';
            var text2 = 'nonaktifkan';
        }
        Swal.fire({
            title: "Anda yakin?",
            text: titlex + " vendor!",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, " + text2 + "!",
            cancelButtonText: "Tidak"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: siteUrl + 'Umum/status_vendor/' + idx,
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
                                    title: 'Vendor ' + nama,
                                    text: 'Berhasil ' + text + "!",
                                    icon: 'success'
                                }).then((result) => {
                                    location.href = siteUrl + 'Umum/vendor';
                                });
                            } else {
                                Swal.fire({
                                    title: 'Vendor ' + nama,
                                    text: 'Gagal ' + text + "!",
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

    function proses() {
        btnShow.hide();
        btnHide.show();
        $('#mod_vendor').modal('hide');

        var proses_ = prosesx.val();

        if (kode.val() == '') {
            btnShow.show();
            btnHide.hide();

            Swal.fire({
                title: 'Kode Vendor',
                text: 'Tidak boleh kosong',
                icon: 'error'
            }).then((value) => {
                $('#mod_vendor').modal('show');
            });
            return;
        }

        if (nama.val() == '') {
            btnShow.show();
            btnHide.hide();

            Swal.fire({
                title: 'Nama Vendor',
                text: 'Tidak boleh kosong',
                icon: 'error'
            }).then((value) => {
                $('#mod_vendor').modal('show');
            });
            return;
        }

        if (nohp.val() == '') {
            btnShow.show();
            btnHide.hide();

            Swal.fire({
                title: 'No Hp Vendor',
                text: 'Tidak boleh kosong',
                icon: 'error'
            }).then((value) => {
                $('#mod_vendor').modal('show');
            });
            return;
        }

        if (email.val() == '') {
            btnShow.show();
            btnHide.hide();

            Swal.fire({
                title: 'Email Vendor',
                text: 'Tidak boleh kosong',
                icon: 'error'
            }).then((value) => {
                $('#mod_vendor').modal('show');
            });
            return;
        }

        if (alamat.val() == '') {
            btnShow.show();
            btnHide.hide();

            Swal.fire({
                title: 'Alamat Vendor',
                text: 'Tidak boleh kosong',
                icon: 'error'
            }).then((value) => {
                $('#mod_vendor').modal('show');
            });
            return;
        }

        if (proses_ == 1) {
            var pesan_success = 'ditambahkan!';
            var pesan_error = 'ditambahkan, silahkan coba lagi!';
        } else {
            var pesan_success = 'diperbaharui!';
            var pesan_error = 'diperbaharui, silahkan coba lagi!';
        }

        $.ajax({
            url: siteUrl + 'Umum/proses_vendor/' + proses_,
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
                    }).then((value) => {
                        $('#mod_vendor').modal('show');
                    });
                    return;
                } else {
                    if (result.response == 1) {
                        btnShow.show();
                        btnHide.hide();

                        Swal.fire({
                            title: 'Vendor ' + nama.val(),
                            text: 'Berhasil ' + pesan_success,
                            icon: 'success'
                        }).then((result) => {
                            location.href = siteUrl + 'Umum/vendor';
                        });
                    } else {
                        btnShow.show();
                        btnHide.hide();

                        Swal.fire({
                            title: 'Vendor ' + nama.val(),
                            text: 'Gagal ' + pesan_error,
                            icon: 'warning'
                        }).then((value) => {
                            $('#mod_vendor').modal('show');
                        });
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

    function deleted(idx, namax) {
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
                    url: siteUrl + 'Umum/deleted_vendor_proses/' + idx,
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
                                    title: 'Vendor ' + namax,
                                    text: 'Berhasil dihapus!',
                                    icon: 'success'
                                }).then((result) => {
                                    location.href = siteUrl + 'Umum/vendor';
                                });
                            } else {
                                Swal.fire({
                                    title: 'Vendor ' + namax,
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