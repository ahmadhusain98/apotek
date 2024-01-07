<!-- jquery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<!-- Custom styles for this page -->
<link href="<?= base_url() ?>assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

<!-- Page level plugins -->
<script src="<?= base_url() ?>assets/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>

<!-- Page level custom scripts -->
<script src="<?= base_url() ?>assets/js/demo/datatables-demo.js"></script>

<div class="table-responsive">
    <table class="table table-bordered" id="tableSubMenu" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th>Nama Sub Menu</th>
                <th>Bagian Menu</th>
                <th width="10%">Aksi</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<script>
    var table = $('#tableSubMenu');
</script>