<form method="post" id="formProfil">
    <div class="h4 mb-3 text-gray-800">Akun / profil</div>

    <input type="hidden" name="cek_foto" id="cek_foto" value="<?= $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row()->foto; ?>">

    <div class="row">
        <div class="col-sm-3 my-auto">
            <div class="row">
                <div class="col-sm-12">
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <div class="card shadow" style="width: auto;">
                                <img id="preview_img" src="<?= base_url() ?>../assets/img/user/<?= $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row()->foto; ?>" class="card-img-top p-3" width="150vh" style="border-radius: 25px;">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item text-center text-primary" style="font-size: 14px; font-weight: bold;">
                                        <?= $this->M_central->getDataRow('m_role', ['kode' => $userdata->kode_role])->keterangan ?>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="input-group shadow">
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
        <div class="col-sm-9">
            <div class="card shadow">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="row">
                                    <label class="control-label col-sm-3">Nama</label>
                                    <div class="col-sm-9">
                                        <input type="text" title="Nama" class="form-control" id="nama" name="nama" placeholder="Nama..." value="<?= $userdata->nama; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="row">
                                    <label class="control-label col-sm-3">Email</label>
                                    <div class="col-sm-9">
                                        <input type="email" title="Email" class="form-control" id="email" name="email" placeholder="Email..." value="<?= $userdata->email; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="row">
                                    <label class="control-label col-sm-3">Tempat Lahir</label>
                                    <div class="col-sm-9">
                                        <input type="text" title="Tempat Lahir" class="form-control" id="tempat_lahir" name="tempat_lahir" placeholder="Tempat lahir..." value="<?= $userdata->tempat_lahir; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="row">
                                    <label class="control-label col-sm-3">Tanggal Lahir</label>
                                    <div class="col-sm-9">
                                        <input type="date" title="Tanggal Lahir" class="form-control" id="tgl_lahir" name="tgl_lahir" placeholder="Tanggal lahir..." value="<?= date('Y-m-d', strtotime($userdata->tgl_lahir)); ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="row">
                                    <label class="control-label col-sm-3">No Hp</label>
                                    <div class="col-sm-9">
                                        <input type="text" title="No Hp" class="form-control" id="nohp" name="nohp" placeholder="No Hp..." value="<?= $userdata->nohp; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="row">
                                    <label class="control-label col-sm-3">Gender</label>
                                    <div class="col-sm-9">
                                        <select name="gender" id="gender" class="form-control select2_all" data-placeholder="-- Pilih Gender --">
                                            <option value="">-- Pilih Gender --</option>
                                            <option value="P" <?= (($userdata->gender == 'P') ? 'selected' : '') ?>>Pria</option>
                                            <option value="W" <?= (($userdata->gender == 'W') ? 'selected' : '') ?>>Wanita</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="row">
                                    <label class="control-label col-sm-3">Sandi</label>
                                    <div class="col-sm-9">
                                        <div class="input-group mb-3" onclick="showpass()">
                                            <input type="password" title="Sandi" class="form-control" id="password" name="password" placeholder="Sandi..." value="<?= $userdata->sandi_ori; ?>">
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="basic-addon2"><i class="fa fa-eye"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="row">
                                    <label class="control-label col-sm-3">Alamat</label>
                                    <div class="col-sm-9">
                                        <textarea name="alamat" id="alamat" class="form-control"><?= $userdata->alamat ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-12 text-center">
                            <button class="btn btn-primary btn-sm" type="button" id="btnShow" onclick="update_akun()">Perbaharui</button>
                            <button class="btn btn-primary btn-sm" type="button" disabled id="btnHide">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                Mohon ditunggu...
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    $('.select2_all').select2({
        width: '100%',
        heigh: 'auto',
    })

    // variable
    var btnShow = $('#btnShow');
    var btnHide = $('#btnHide');

    var nama = $('#nama');
    var email = $('#email');
    var tempat_lahir = $('#tempat_lahir');
    var tgl_lahir = $('#tgl_lahir');
    var nohp = $('#nohp');
    var gender = $('#gender');
    var alamat = $('#alamat');

    $(document).ready(function() {
        btnHide.hide();
    });
</script>

<!-- another function -->
<script>
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
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            $('#div_preview_foto').css("display", "none");
            $('#preview_img').attr('src', '');
        }
    }

    function showpass() {
        if ($('#password').attr("type") == "password") {
            $('#password').attr("type", "text");
        } else {
            $('#password').attr("type", "password");
        }
    }
</script>

<!-- Update function -->
<script>
    function update_akun() {
        btnShow.hide();
        btnHide.show();

        if (nama.val() == '') {
            btnHide.hide();
            btnShow.show();

            Swal.fire({
                title: 'Nama',
                text: 'Tidak boleh kosong',
                icon: 'error'
            });
            return;
        }

        if (email.val() == '') {
            btnHide.hide();
            btnShow.show();

            Swal.fire({
                title: 'Email',
                text: 'Tidak boleh kosong',
                icon: 'error'
            });
            return;
        }

        if (tempat_lahir.val() == '') {
            btnHide.hide();
            btnShow.show();

            Swal.fire({
                title: 'Tempat Lahir',
                text: 'Tidak boleh kosong',
                icon: 'error'
            });
            return;
        }

        if (tgl_lahir.val() == '') {
            btnHide.hide();
            btnShow.show();

            Swal.fire({
                title: 'Tanggal Lahir',
                text: 'Tidak boleh kosong',
                icon: 'error'
            });
            return;
        }

        if (nohp.val() == '') {
            btnHide.hide();
            btnShow.show();

            Swal.fire({
                title: 'No Hp',
                text: 'Tidak boleh kosong',
                icon: 'error'
            });
            return;
        }

        if (gender.val() == '') {
            btnHide.hide();
            btnShow.show();

            Swal.fire({
                title: 'Gender',
                text: 'Tidak boleh kosong',
                icon: 'error'
            });
            return;
        }

        if (alamat.val() == '') {
            btnHide.hide();
            btnShow.show();

            Swal.fire({
                title: 'Alamat',
                text: 'Tidak boleh kosong',
                icon: 'error'
            });
            return;
        }

        var form = $('#formProfil')[0];
        var data = new FormData(form);

        $.ajax({
            url: siteUrl + 'Akun/update_proses/',
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
                    btnHide.hide();
                    btnShow.show();

                    Swal.fire({
                        title: '404',
                        text: 'Tidak ada respons dari sistem',
                        icon: 'error'
                    });
                    return;
                } else {
                    if (result.response == 1) {
                        btnHide.hide();
                        btnShow.show();

                        Swal.fire({
                            title: 'Akun ' + result.username,
                            text: 'Berhasil diperbaharui!',
                            icon: 'success'
                        }).then((result) => {
                            location.href = siteUrl + 'Akun';
                        });
                    } else {
                        btnHide.hide();
                        btnShow.show();

                        Swal.fire({
                            title: 'Akun ' + result.username,
                            text: 'Gagak diperbaharui, silahkan coba lagi!',
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
</script>