<form method="post" id="formGudang">
    <div class="h4 mb-3 text-gray-800">Umum / gudang
        <div class="btn-group float-right" role="group" aria-label="Basic example">
            <button type="button" class="btn btn-dark btn-sm" disabled>Video Tutorial <i class="fa fa-arrow-alt-circle-right"></i></button>
            <button type="button" class="btn btn-info btn-sm" title="Tutorial Tambah" onclick="tutor(1)"><i class="fa fa-plus"></i></button>
            <button type="button" class="btn btn-info btn-sm" title="Tutorial Ubah" onclick="tutor(2)"><i class="fa fa-repeat"></i></button>
            <button type="button" class="btn btn-info btn-sm" title="Tutorial Hapus" onclick="tutor(3)"><i class="fa fa-ban"></i></button>
        </div>
    </div>

    <div class=" card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">List data gudang
                <button type="button" class="btn btn-sm float-right" style="background-color: transparent; border: 0px;" title="Informasi" onclick="forInfo()"><i class="fa fa-2x fa-info-circle text-info"></i></button>
                <?php if ($role_aksi->tambah > 0) : ?>
                    <button class="btn btn-primary btn-sm float-right" type="button" onclick="add_gudang()"><i class="fa fa-plus"></i> Tambah List</button>
                <?php endif; ?>
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="tableGudang" width="100%" cellspacing="0">
                    <thead>
                        <tr class="bg-primary text-white">
                            <th width="5%">No</th>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>No Hp</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="mod_gudang" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                <input type="text" title="Kode Gudang" class="form-control" id="kode" name="kode" placeholder="Kode Gudang..." onkeyup="delspace(this.value, 'kode')" onchange="cekKode(this.value, 'kode', 'Umum/cek_gudang/', 'mod_gudang')">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" title="Nama Gudang" class="form-control" id="nama" name="nama" placeholder="Nama Gudang..." onkeyup="ubah_nama(this.value, 'nama')">
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
                                <select name="status_aktif" id="status_aktif" class="form-control select2_all" data-placeholder="Pilih Status...">
                                    <option value="">Pilih Status...</option>
                                    <option value="1">Aktif</option>
                                    <option value="0">Non-aktif</option>
                                </select>
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
    var table = $('#tableGudang');

    var id = $('#id');
    var kode = $('#kode');
    var nama = $('#nama');
    var nohp = $('#nohp');
    var status_aktif = $('#status_aktif');
    var alamat = $('#alamat');
    var prosesx = $('#prosesx');

    const form = $('#formGudang');
    const btnShow = $('#btnShow');
    const btnHide = $('#btnHide');

    $(document).ready(function() {
        btnHide.hide()
    });

    // another function

    function add_gudang() {
        $('#mod_gudang').modal('show');
        $('.modal-title').text('Tambah Gudang');
        id.val('');
        kode.val('');
        kode.attr('readonly', false);
        nama.val('');
        nohp.val('');
        status_aktif.val('').change();
        alamat.val('');
        prosesx.val(1);
    }

    function updated(idx) {
        $.ajax({
            url: siteUrl + 'Umum/getGudang/' + idx,
            type: 'POST',
            data: form.serialize(),
            dataType: 'JSON',
            success: function(result) {
                $('#mod_gudang').modal('show');
                $('.modal-title').text('Update Gudang');
                id.val(idx);
                kode.val(result.kode);
                kode.attr('readonly', true);
                nama.val(result.nama);
                nohp.val(result.nohp);
                status_aktif.val(result.status).change();
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

    // function proses entri, update and delete
    function proses() {
        btnShow.hide();
        btnHide.show();
        $('#mod_gudang').modal('hide');

        var proses_ = prosesx.val();

        if (kode.val() == '') {
            btnShow.show();
            btnHide.hide();

            Swal.fire({
                title: 'Kode Gudang',
                text: 'Tidak boleh kosong',
                icon: 'error'
            }).then((value) => {
                $('#mod_gudang').modal('show');
            });
            return;
        }

        if (nama.val() == '') {
            btnShow.show();
            btnHide.hide();

            Swal.fire({
                title: 'Nama Gudang',
                text: 'Tidak boleh kosong',
                icon: 'error'
            }).then((value) => {
                $('#mod_gudang').modal('show');
            });
            return;
        }

        if (nohp.val() == '') {
            btnShow.show();
            btnHide.hide();

            Swal.fire({
                title: 'No Hp Gudang',
                text: 'Tidak boleh kosong',
                icon: 'error'
            }).then((value) => {
                $('#mod_gudang').modal('show');
            });
            return;
        }

        if (status_aktif.val() == '') {
            btnShow.show();
            btnHide.hide();

            Swal.fire({
                title: 'Status Gudang',
                text: 'Tidak boleh kosong',
                icon: 'error'
            }).then((value) => {
                $('#mod_gudang').modal('show');
            });
            return;
        }

        if (alamat.val() == '') {
            btnShow.show();
            btnHide.hide();

            Swal.fire({
                title: 'Alamat Gudang',
                text: 'Tidak boleh kosong',
                icon: 'error'
            }).then((value) => {
                $('#mod_gudang').modal('show');
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
            url: siteUrl + 'Umum/proses_gudang/' + proses_,
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
                        $('#mod_gudang').modal('show');
                    });
                    return;
                } else {
                    if (result.response == 1) {
                        btnShow.show();
                        btnHide.hide();

                        Swal.fire({
                            title: 'Gudang ' + nama.val(),
                            text: 'Berhasil ' + pesan_success,
                            icon: 'success'
                        }).then((result) => {
                            location.href = siteUrl + 'Umum/gudang';
                        });
                    } else {
                        btnShow.show();
                        btnHide.hide();

                        Swal.fire({
                            title: 'Gudang ' + nama.val(),
                            text: 'Gagal ' + pesan_error,
                            icon: 'warning'
                        }).then((value) => {
                            $('#mod_gudang').modal('show');
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
                    url: siteUrl + 'Umum/deleted_gudang_proses/' + idx,
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
                                    title: 'Gudang ' + namax,
                                    text: 'Berhasil dihapus!',
                                    icon: 'success'
                                }).then((result) => {
                                    location.href = siteUrl + 'Umum/gudang';
                                });
                            } else {
                                Swal.fire({
                                    title: 'Gudang ' + namax,
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