<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title><?= $judul; ?></title>

  <!-- Custom fonts for this template-->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="<?= base_url() ?>../assets/css/sb-admin-2.min.css" rel="stylesheet">

  <!-- selectpicekr -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">

  <!-- jquery -->
  <!-- <script src="<?= base_url() ?>../assets/vendor/jquery/jquery.min.js"></script> -->

  <!-- sweet alert -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- jquery -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

  <!-- Custom styles for this page -->
  <link href="<?= base_url() ?>../assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

  <!-- Page level plugins -->
  <script src="<?= base_url() ?>../assets/vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="<?= base_url() ?>../assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="<?= base_url() ?>../assets/js/demo/datatables-demo.js"></script>

  <!-- Select2 -->
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

  <!-- animate -->
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

  <link rel="shortcut icon" href="<?= base_url() ?>../assets/img/favicon.png">
</head>

<style>
  .select2-selection__rendered {
    line-height: 31px !important;
  }

  .select2-container .select2-selection--single {
    height: 37px !important;
  }

  .select2-selection__arrow {
    height: 37px !important;
  }
</style>

<body class="bg-gradient-primary">

  <div class="container">

    <?= $content; ?>

  </div>

  <script>
    $(".select2_all").select2({
      placeholder: $(this).data('placeholder'),
    });
  </script>

  <script>
    function ubah_nama(val, idForm) {
      str = val.toLowerCase().replace(/\b[a-z]/g, function(letter) {
        return letter.toUpperCase();
      });
      $('#' + idForm).val(str);
    }

    function delspace(param, idForm) {
      var kodex = param.trim();
      $('#' + idForm).val(kodex.toUpperCase());
    }

    function delspace_nocaps(param, idForm) {
      var kodex = param.trim();
      $('#' + idForm).val(kodex);
    }
  </script>

  <!-- Bootstrap core JavaScript-->
  <script src="<?= base_url() ?>../assets/vendor/jquery/jquery.min.js"></script>
  <script src="<?= base_url() ?>../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="<?= base_url() ?>../assets/vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="<?= base_url() ?>../assets/js/sb-admin-2.min.js"></script>

</body>

</html>