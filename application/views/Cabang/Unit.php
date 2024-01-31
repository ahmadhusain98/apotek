<form method="post" id="formUnit">
    <div class="h4 mb-3 text-gray-800">Cabang / unit
        <div class="btn-group float-right" role="group" aria-label="Basic example">
            <button type="button" class="btn btn-dark btn-sm" disabled>Video Tutorial <i class="fa fa-arrow-alt-circle-right"></i></button>
            <button type="button" class="btn btn-info btn-sm" title="Tutorial Tambah" onclick="tutor(1)"><i class="fa fa-plus"></i></button>
            <button type="button" class="btn btn-info btn-sm" title="Tutorial Ubah" onclick="tutor(2)"><i class="fa fa-repeat"></i></button>
            <button type="button" class="btn btn-info btn-sm" title="Tutorial Hapus" onclick="tutor(3)"><i class="fa fa-ban"></i></button>
        </div>
    </div>

    <div class=" card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">List data unit
                <button type="button" class="btn btn-sm float-right" style="background-color: transparent; border: 0px;" title="Informasi" onclick="forInfo()"><i class="fa fa-2x fa-info-circle text-info"></i></button>
                <?php if ($role_aksi->tambah > 0) : ?>
                    <button class="btn btn-primary btn-sm float-right" type="button" onclick="add_unit()"><i class="fa fa-plus"></i> Tambah List</button>
                <?php endif; ?>
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="tableUnit" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>Penanggungjawab</th>
                            <th>Kontak</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="mod_unit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                <input type="text" title="Kode Unit" class="form-control" id="kode_unit" name="kode_unit" placeholder="Kode Unit..." onkeyup="delspace(this.value)">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" title="Penanggungjawab" class="form-control" id="penanggungjawab" name="penanggungjawab" placeholder="Penanggungjawab...">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" title="Nama Unit" class="form-control" id="nama_unit" name="nama_unit" placeholder="Nama Unit...">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" title="Kontak" class="form-control" id="kontak" name="kontak" placeholder="Kontak...">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="date" title="Tgl Mulai" class="form-control" id="tgl_mulai" name="tgl_mulai" placeholder="Tgl Mulai...">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="date" title="Tgl Selesai" class="form-control" id="tgl_selesai" name="tgl_selesai" placeholder="Tgl Selesai...">
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
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-3">
                                    <input type="hidden" name="name_foto" id="name_foto" value="default.png">
                                    <img id="preview_img" src="<?= base_url() ?>../assets/img/unit/default.png" class="card-img-top p-3" width="50vh" style="border-radius: 25px;">
                                </div>
                                <div class="col-md-9 my-auto">
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="foto_profil" name="foto_profil" aria-describedby="inputGroupFileAddon01">
                                            <label class="custom-file-label" for="inputGroupFile01">Cari Foto</label>
                                        </div>
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
    // variable
    var table = $('#tableUnit');
    var btnShow = $('#btnShow');
    var btnHide = $('#btnHide');
    var title = $('.modal-title');
    var id = $('#id');
    var kode_unit = $('#kode_unit');
    var nama_unit = $('#nama_unit');
    var penanggungjawab = $('#penanggungjawab');
    var kontak = $('#kontak');
    var tgl_mulai = $('#tgl_mulai');
    var tgl_selesai = $('#tgl_selesai');
    var alamat = $('#alamat');
    var name_foto = $('#name_foto');
    var prosesx = $('#prosesx');

    const form = $('#formUnit')[0];

    // onload first
    $(document).ready(function() {
        btnHide.hide()
    });

    // another function
    // when photo has been change
    $("#foto_profil").change(function() {
        readURL(this);
    });

    // preview image
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#div_preview_foto').css("display", "block");
                $('#preview_img').attr('src', e.target.result);
                name_foto.val(input.files[0].name);
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            $('#div_preview_foto').css("display", "none");
            $('#preview_img').attr('src', '');
            name_foto.val('default.png');
        }
    }

    function add_unit() {
        title.text('Tambah Unit');
        $('#mod_unit').modal('show');
        id.val('');
        kode_unit.val('');
        nama_unit.val('');
        penanggungjawab.val('');
        kontak.val('');
        tgl_mulai.val('');
        tgl_selesai.val('');
        alamat.val('');
    }

    function updated(kode_unitx) {
        var data = new FormData(form);

        $.ajax({
            url: siteUrl + 'Cabang/get_unit/' + kode_unitx,
            type: "POST",
            enctype: 'multipart/form-data',
            data: data,
            dataType: "JSON",
            processData: false,
            contentType: false,
            cache: false,
            timeout: 600000,
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
                    btnShow.show();
                    btnHide.hide();

                    $('.modal-title').text('Update Unit');

                    $('#mod_unit').modal('show');
                    id.val(result.id);
                    kode_unit.val(kode_unitx);
                    nama_unit.val(result.nama_unit);
                    penanggungjawab.val(result.penanggungjawab);
                    kontak.val(result.kontak);
                    tgl_mulai.val(result.tgl_mulai);
                    tgl_selesai.val(result.tgl_selesai);
                    alamat.val(result.alamat);
                    name_foto.val(result.foto);
                    document.getElementById('preview_img').src = siteUrl + '../assets/img/unit/' + result.foto;
                    prosesx.val(2);
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

    // function proses, and delete
    function proses() {
        btnShow.hide();
        btnHide.show();

        var data = new FormData(form);

        var proses_ = prosesx.val();
        $('#mod_unit').modal('hide');

        if (kode_unit.val() == '') {
            btnShow.show();
            btnHide.hide();

            Swal.fire({
                title: 'Kode Unit',
                text: 'Tidak boleh kosong',
                icon: 'error'
            }).then((value) => {
                $('#mod_unit').modal('show');
            });
            return;
        }

        if (nama_unit.val() == '') {
            btnShow.show();
            btnHide.hide();

            Swal.fire({
                title: 'Nama Unit',
                text: 'Tidak boleh kosong',
                icon: 'error'
            }).then((value) => {
                $('#mod_unit').modal('show');
            });
            return;
        }

        if (penanggungjawab.val() == '') {
            btnShow.show();
            btnHide.hide();

            Swal.fire({
                title: 'Penanggungjawab',
                text: 'Tidak boleh kosong',
                icon: 'error'
            }).then((value) => {
                $('#mod_unit').modal('show');
            });
            return;
        }

        if (kontak.val() == '') {
            btnShow.show();
            btnHide.hide();

            Swal.fire({
                title: 'Kontak',
                text: 'Tidak boleh kosong',
                icon: 'error'
            }).then((value) => {
                $('#mod_unit').modal('show');
            });
            return;
        }

        if (tgl_mulai.val() == '') {
            btnShow.show();
            btnHide.hide();

            Swal.fire({
                title: 'Tanggal Mulai',
                text: 'Tidak boleh kosong',
                icon: 'error'
            }).then((value) => {
                $('#mod_unit').modal('show');
            });
            return;
        }

        if (tgl_selesai.val() == '') {
            btnShow.show();
            btnHide.hide();

            Swal.fire({
                title: 'Tanggal Selesai',
                text: 'Tidak boleh kosong',
                icon: 'error'
            }).then((value) => {
                $('#mod_unit').modal('show');
            });
            return;
        }

        if (alamat.val() == '') {
            btnShow.show();
            btnHide.hide();

            Swal.fire({
                title: 'Alamat',
                text: 'Tidak boleh kosong',
                icon: 'error'
            }).then((value) => {
                $('#mod_unit').modal('show');
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
            url: siteUrl + 'Cabang/add_unit_proses/' + proses_,
            type: "POST",
            enctype: 'multipart/form-data',
            data: data,
            dataType: "JSON",
            processData: false,
            contentType: false,
            cache: false,
            timeout: 600000,
            success: function(result) {
                if (result == '' || result == null) {
                    btnShow.show();
                    btnHide.hide();

                    Swal.fire({
                        title: '404',
                        text: 'Tidak ada respons dari sistem',
                        icon: 'error'
                    }).then((value) => {
                        $('#mod_unit').modal('show');
                    });
                    return;
                } else {
                    if (result.response == 1) {
                        btnShow.show();
                        btnHide.hide();

                        Swal.fire({
                            title: 'Unit ' + nama_unit.val(),
                            text: 'Berhasil ' + pesan_success,
                            icon: 'success'
                        }).then((result) => {
                            location.href = siteUrl + 'Cabang/unit';
                        });
                    } else {
                        btnShow.show();
                        btnHide.hide();

                        Swal.fire({
                            title: 'Unit ' + nama_unit.val(),
                            text: 'Gagal ' + pesan_error,
                            icon: 'warning'
                        }).then((value) => {
                            $('#mod_unit').modal('show');
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

    function deleted(kode_unitx) {
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
                    url: siteUrl + 'Cabang/deleted_unit_proses/' + kode_unitx,
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
                                    title: 'Unit ' + kode_unitx,
                                    text: 'Berhasil dihapus!',
                                    icon: 'success'
                                }).then((result) => {
                                    location.href = siteUrl + 'Cabang/unit';
                                });
                            } else {
                                Swal.fire({
                                    title: 'Unit ' + kode_unitx,
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