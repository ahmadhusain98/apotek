<form method="post" id="formUnit">
    <div class="h4 mb-3 text-gray-800">Cabang / pengelola unit
        <div class="btn-group float-right" role="group" aria-label="Basic example">
            <button type="button" class="btn btn-dark btn-sm" disabled>Video Tutorial <i class="fa fa-arrow-alt-circle-right"></i></button>
            <button type="button" class="btn btn-info btn-sm" title="Tutorial Beri Akses" onclick="tutor(1)"><i class="fa-solid fa-toggle-on"></i></button>
            <button type="button" class="btn btn-info btn-sm" title="Tutorial Matikan Akses" onclick="tutor(2)"><i class="fa-solid fa-toggle-off"></i></button>
        </div>
    </div>

    <div class=" card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">List data pengelola unit
                <button type="button" class="btn btn-sm float-right" style="background-color: transparent; border: 0px;" title="Informasi" onclick="forInfo()"><i class="fa fa-2x fa-info-circle text-info"></i></button>
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="tablePengelolaUnit" width="100%" cellspacing="0">
                    <thead>
                        <tr class="bg-primary text-white">
                            <th rowspan="2" width="5%">No</th>
                            <th rowspan="2">Username</th>
                            <th class="text-center" colspan="<?= count($cabang) ?>">Cabang</th>
                        </tr>
                        <tr class="bg-primary text-white">
                            <?php foreach ($cabang as $c) : ?>
                                <th><?= $c->nama_unit ?></th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($table as $t) :
                        ?>
                            <tr>
                                <td><?= $no ?></td>
                                <td>
                                    <?= $t->username ?>
                                </td>
                                <?php
                                $nocab = 1;
                                foreach ($cabang as $c) {
                                    if ($this->db->query("SELECT * FROM akses_unit WHERE kode_unit IN (SELECT kode_unit FROM m_unit WHERE kode_unit = '$c->kode_unit') AND username = '$t->username'")->num_rows() > 0) {
                                        $cek = "checked";
                                    } else {
                                        $cek = "";
                                    } ?>
                                    <td class="text-center">
                                        <input type="hidden" id="ph<?= $nocab; ?>">
                                        <input type="checkbox" <?= $cek; ?> class="form-control" id="pilih<?= $nocab . '_' . $no; ?>" name="pilih[]" onclick="getAksesCab('<?= $c->kode_unit; ?>', '<?= $c->nama_unit; ?>', '<?= $nocab; ?>', '<?= $t->username; ?>', '<?= $no; ?>')">
                                    </td>
                                <?php $nocab++;
                                }
                                ?>
                            </tr>
                        <?php
                            $no++;
                        endforeach;
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</form>

<script>
    var tablePengelolaUnit = $('#tablePengelolaUnit').DataTable({
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

    function getAksesCab(kode_unit, nama_unit, nomor, username, no) {
        if (document.getElementById("pilih" + nomor + "_" + no).checked == true) {
            var cekph = 1;
        } else {
            var cekph = 0;
        }
        if (cekph < 1) {
            Swal.fire({
                title: "Anda yakin?",
                text: "Hapus akses pada username ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Hapus Akses',
                cancelButtonText: 'Tutup',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?= site_url('Cabang/del_cabang/'); ?>" + kode_unit + '/' + username,
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
                                        title: 'Username ' + username,
                                        text: 'Berhasil menghapus akses!',
                                        icon: 'success'
                                    });
                                } else {
                                    Swal.fire({
                                        title: 'Username ' + username,
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
                text: "Beri akses pada username ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Beri Akses',
                cancelButtonText: 'Tutup',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?= site_url('Cabang/add_cabang/'); ?>" + kode_unit + '/' + username,
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
                                        title: 'Username ' + username,
                                        text: 'Berhasil memberikan akses!',
                                        icon: 'success'
                                    });
                                } else {
                                    Swal.fire({
                                        title: 'Username ' + username,
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