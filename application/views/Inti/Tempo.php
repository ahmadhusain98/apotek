<form method="post" id="formTempo">
    <div class="h4 mb-3 text-gray-800">Inti / jatuh tempo
        <div class="btn-group float-right" role="group" aria-label="Basic example">
            <button type="button" class="btn btn-dark btn-sm" disabled>Video Tutorial <i class="fa fa-arrow-alt-circle-right"></i></button>
            <button type="button" class="btn btn-info btn-sm" title="Tutorial Tambah" onclick="tutor(1)"><i class="fa fa-plus"></i></button>
            <button type="button" class="btn btn-info btn-sm" title="Tutorial Ubah" onclick="tutor(2)"><i class="fa fa-repeat"></i></button>
            <button type="button" class="btn btn-info btn-sm" title="Tutorial Hapus" onclick="tutor(3)"><i class="fa fa-ban"></i></button>
        </div>
    </div>

    <div class=" card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">List data jatuh tempo
                <button type="button" class="btn btn-sm float-right" style="background-color: transparent; border: 0px;" title="Informasi" onclick="forInfo()"><i class="fa fa-2x fa-info-circle text-info"></i></button>
                <?php if ($role_aksi->tambah > 0) : ?>
                    <button class="btn btn-primary btn-sm float-right" type="button" onclick="add_tempo()"><i class="fa fa-plus"></i> Tambah List</button>
                <?php endif; ?>
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="tableTempo" width="100%" cellspacing="0">
                    <thead>
                        <tr class="bg-primary text-white">
                            <th width="5%">No</th>
                            <th>Keterangan</th>
                            <th>Jatuh Tempo</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="mod_tempo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                <input type="text" title="Keterangan" class="form-control" id="keterangan" name="keterangan" placeholder="Keterangan...">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <input type="number" class="form-control" id="hitung" name="hitung" placeholder="Tempo Dalam Hari..." value="1" min="1" onchange="cekHitung(this.value)">
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="basic-addon2">Hari</span>
                                    </div>
                                </div>
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
    var table = $('#tableTempo');
    var btnShow = $('#btnShow');
    var btnHide = $('#btnHide');
    var id = $('#id');
    var keterangan = $('#keterangan');
    var hitung = $('#hitung');
    var prosesx = $('#prosesx');

    const form = $('#formTempo');

    $(document).ready(function() {
        btnHide.hide()
    });

    // another function
    function cekHitung(hari) {
        $('#mod_tempo').modal('hide');
        if (hari < 1) {
            Swal.fire({
                title: 'Jatuh Tempo',
                text: 'Minimal 1 Hari',
                icon: 'error'
            }).then((value) => {
                $('#hitung').val(1);
                $('#mod_tempo').modal('show');
            });
            return;
        }
    }

    function add_tempo() {
        $('.modal-title').text('Tambah Jatuh Tempo');
        $('#mod_tempo').modal('show');
        id.val('');
        keterangan.val('');
        hitung.val(1);
    }

    function updated(idx) {
        $.ajax({
            url: siteUrl + 'Inti/getTempo/' + idx,
            type: 'POST',
            data: form.serialize(),
            dataType: 'JSON',
            success: function(result) {
                $('.modal-title').text('Update Jatuh Tempo');
                $('#mod_tempo').modal('show');
                id.val(idx);
                keterangan.val(result.keterangan);
                hitung.val(result.hitung);
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

    // function proses entri, update, and deleted
    function proses() {
        btnShow.hide();
        btnHide.show();
        $('#mod_tempo').modal('hide');

        var proses_ = prosesx.val();

        if (keterangan.val() == '') {
            btnShow.show();
            btnHide.hide();

            Swal.fire({
                title: 'Keterangan',
                text: 'Tidak boleh kosong',
                icon: 'error'
            }).then((value) => {
                $('#mod_tempo').modal('show');
            });
            return;
        }

        if (hitung.val() < 1) {
            btnShow.show();
            btnHide.hide();

            Swal.fire({
                title: 'Jatuh Tempo',
                text: 'Minimal 1 hari',
                icon: 'error'
            }).then((value) => {
                $('#mod_tempo').modal('show');
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
            url: siteUrl + 'Inti/proses_tempo/' + proses_,
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
                        $('#mod_tempo').modal('show');
                    });
                    return;
                } else {
                    if (result.response == 1) {
                        btnShow.show();
                        btnHide.hide();

                        Swal.fire({
                            title: keterangan.val(),
                            text: 'Berhasil ' + pesan_success,
                            icon: 'success'
                        }).then((result) => {
                            location.href = siteUrl + 'Inti/tempo';
                        });
                    } else {
                        btnShow.show();
                        btnHide.hide();

                        Swal.fire({
                            title: keterangan.val(),
                            text: 'Gagal ' + pesan_error,
                            icon: 'warning'
                        }).then((value) => {
                            $('#mod_tempo').modal('show');
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
                    url: siteUrl + 'Inti/deleted_tempo_proses/' + idx,
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
                                    title: 'Tempo',
                                    text: 'Berhasil dihapus!',
                                    icon: 'success'
                                }).then((result) => {
                                    location.href = siteUrl + 'Inti/tempo';
                                });
                            } else {
                                Swal.fire({
                                    title: 'Tempo',
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