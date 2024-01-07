<script>
    table.DataTable({
        destroy: true,
        processing: true,
        responsive: true,
        serverSide: true,
        order: [],
        ajax: {
            url: "<?= site_url() . $list_ajax ?>",
            type: "POST"
        },
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
</script>