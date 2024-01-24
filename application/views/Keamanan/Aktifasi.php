<form method="post" id="formAktivasi">
    <div class="h4 mb-3 text-gray-800">Keamanan / aktifasi akun</div>

    <div class=" card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">List data aktifasi akun
                <button type="button" class="btn btn-sm float-right" style="background-color: transparent; border: 0px;" title="Informasi" onclick="forInfo()"><i class="fa fa-2x fa-info-circle text-info"></i></button>
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="tableAktifasi" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Username</th>
                            <th>Nama</th>
                            <th>Status Aktif</th>
                            <th>Status Akun</th>
                            <th>Role</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</form>

<div class="position-fixed bottom-0 right-0 p-3" style="z-index: 5; right: 0; bottom: 0; height: 200px;">
    <div id="liveToast" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000">
        <div class="toast-header">
            <strong class="mr-auto text-primary">Informasi</strong>
            <small class="text-danger">Akun dengan status <i><b>online</b></i></small>
        </div>
        <div class="toast-body">
            Tidak dapat diaktifkan, maupun dinon-aktifkan!
        </div>
    </div>
</div>

<script>
    // variable
    var table = $('#tableAktifasi');

    // another function
    function forInfo() {
        $('#liveToast').toast('show')
    }

    // function proses
    function aktivasi(username) {
        Swal.fire({
            title: "Anda yakin?",
            text: "Data user " + username + " akan diaktifkan!",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, aktifkan!",
            cancelButtonText: "Tidak"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: siteUrl + 'Aktifasi/akif/' + username,
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
                                    text: 'Berhasil diaktifkan!',
                                    icon: 'success'
                                }).then((result) => {
                                    location.href = siteUrl + 'Aktifasi';
                                });
                            } else {
                                Swal.fire({
                                    title: 'Data',
                                    text: 'Gagal diaktifkan!',
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

    function nonaktivasi(username) {
        Swal.fire({
            title: "Anda yakin?",
            text: "Data user " + username + " akan dinon-aktifkan!",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, non-aktifkan!",
            cancelButtonText: "Tidak"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: siteUrl + 'Aktifasi/non_akif/' + username,
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
                                    text: 'Berhasil dinon-aktifkan!',
                                    icon: 'success'
                                }).then((result) => {
                                    location.href = siteUrl + 'Aktifasi';
                                });
                            } else {
                                Swal.fire({
                                    title: 'Data',
                                    text: 'Gagal dinon-aktifkan!',
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