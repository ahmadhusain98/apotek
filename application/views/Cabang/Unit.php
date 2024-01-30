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
    var kode_unit = $('#kode_unit');
    var nama_unit = $('#nama_unit');
    var penanggungjawab = $('#penanggungjawab');
    var kontak = $('#kontak');
    var tgl_mulai = $('#tgl_mulai');
    var tgl_selesai = $('#tgl_selesai');
    var alamat = $('#alamat');
    var prosesx = $('#prosesx');

    const form = $('#formUnit');

    // onload first
    $(document).ready(function() {
        btnHide.hide()
    });

    // another function
    function add_unit() {
        title.text('Tambah Unit');
        $('#mod_unit').modal('show');
        kode_unit.val('');
        nama_unit.val('');
        penanggungjawab.val('');
        kontak.val('');
        tgl_mulai.val('');
        tgl_selesai.val('');
        alamat.val('');
    }

    // function proses, and delete
    function proses() {
        btnShow.hide();
        btnHide.show();

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
                            text: 'Gagak ' + pesan_error,
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
</script>