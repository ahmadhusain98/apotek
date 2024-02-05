<form method="post" id="formAksesModul">
    <div class="h4 mb-3 text-gray-800">Keamanan / aktifasi akun</div>

    <div class=" card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">List data aktifasi akun
                <button type="button" class="btn btn-sm float-right" style="background-color: transparent; border: 0px;" title="Informasi" onclick="forInfo()"><i class="fa fa-2x fa-info-circle text-info"></i></button>
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="tableAksesModul" width="100%" cellspacing="0">
                    <thead>
                        <tr class="bg-primary text-white">
                            <th rowspan="2" width="5%">No</th>
                            <th rowspan="2">Tingkatan</th>
                            <th class="text-center" colspan="<?= count($modul) ?>">Modul</th>
                        </tr>
                        <tr class="bg-primary text-white">
                            <?php foreach ($modul as $m) : ?>
                                <th><?= $m->nama ?></th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($m_role as $r) :
                        ?>
                            <tr>
                                <td><?= $no ?></td>
                                <td><?= $r->keterangan ?></td>
                                <?php
                                $nom = 1;
                                foreach ($modul as $m) :
                                    if ($this->db->query("SELECT * FROM akses_modul WHERE kode_role IN (SELECT kode FROM m_role WHERE kode = '$r->kode') AND id_modul = '$m->id'")->num_rows() > 0) {
                                        $cek = "checked";
                                    } else {
                                        $cek = "";
                                    }
                                ?>
                                    <td class="text-center">
                                        <input type="hidden" id="ph<?= $nom; ?>">
                                        <input type="checkbox" <?= $cek; ?> class="form-control" id="pilih<?= $nom . '_' . $no; ?>" name="pilih[]" onclick="getAksesModul('<?= $m->id; ?>', '<?= $m->nama; ?>', '<?= $nom; ?>', '<?= $r->kode; ?>', '<?= $no; ?>')">
                                    </td>
                                <?php
                                    $nom++;
                                endforeach;
                                ?>
                            </tr>
                        <?php
                            $no++;
                        endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</form>

<script>
    var tableAksesModul = $('#tableAksesModul').DataTable({
        destroy: true,
        processing: true,
        responsive: true,
        serverSide: false,
        order: [],
        scrollCollapse: false,
        paging: true,
        oLanguage: {
            sEmptyTable: "<div class='text-center'>Data Kosong</div>",
            sInfoEmpty: "",
            sInfoFiltered: " - Dipilih dari _TOTAL_ data",
            sSearch: "Cari : ",
            sInfo: " Jumlah _TOTAL_ Data (_START_ - _END_)",
            sLengthMenu: "_MENU_ Baris",
            sZeroRecords: "<div class='text-center'>Data Kosong</div>",
            oPaginate: {
                sPrevious: "Sebelumnya",
                sNext: "Berikutnya"
            }
        },
        aLengthMenu: [
            [5, 15, 20, -1],
            [5, 15, 20, "Semua"]
        ],
        columnDefs: [{
            targets: [-1],
            orderable: false,
        }, ],
    });

    function getAksesModul(id_modul, nama_modul, nomor, kode_role, no) {
        if (document.getElementById("pilih" + nomor + "_" + no).checked == true) {
            var cekph = 1;
        } else {
            var cekph = 0;
        }
        if (cekph < 1) {
            Swal.fire({
                title: "Anda yakin?",
                text: "Hapus akses pada role ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Hapus Akses',
                cancelButtonText: 'Tutup',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?= site_url('Akses_modul/del_akses/'); ?>" + id_modul + '/' + kode_role,
                        type: "POST",
                        dataType: "JSON",
                        success: function(result) {
                            if (result == '' || result == null) {
                                Swal.fire({
                                    title: '404',
                                    text: 'Tidak ada respons dari sistem',
                                    icon: 'error'
                                });
                                return;
                            } else {
                                if (result.response == 1) {
                                    Swal.fire({
                                        title: 'Modul ' + nama_modul,
                                        text: 'Berhasil menghapus akses!',
                                        icon: 'success'
                                    });
                                } else {
                                    Swal.fire({
                                        title: 'Modul ' + nama_modul,
                                        text: 'Gagal menghapus akses!',
                                        icon: 'error'
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
                } else {
                    document.getElementById("pilih" + nomor + "_" + no).checked = true;
                }
            })
        } else {
            Swal.fire({
                title: "Anda yakin?",
                text: "Beri akses pada role ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Beri Akses',
                cancelButtonText: 'Tutup',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?= site_url('Akses_modul/add_akses/'); ?>" + id_modul + '/' + kode_role,
                        type: "POST",
                        dataType: "JSON",
                        success: function(result) {
                            if (result == '' || result == null) {
                                Swal.fire({
                                    title: '404',
                                    text: 'Tidak ada respons dari sistem',
                                    icon: 'error'
                                });
                                return;
                            } else {
                                if (result.response == 1) {
                                    Swal.fire({
                                        title: 'Modul ' + nama_modul,
                                        text: 'Berhasil memberikan akses!',
                                        icon: 'success'
                                    });
                                } else {
                                    Swal.fire({
                                        title: 'Modul ' + nama_modul,
                                        text: 'Gagal memberikan akses!',
                                        icon: 'error'
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
                } else {
                    document.getElementById("pilih" + nomor + "_" + no).checked = false;
                }
            })
        }
    }
</script>