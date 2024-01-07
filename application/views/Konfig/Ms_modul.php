<div class="h4 mb-3 text-gray-800"><?= $judul; ?></div>

<div class=" card shadow mb-4">
  <div class="card-header py-3">
    <nav class="nav nav-pills flex-column flex-sm-row">
      <a class="flex-sm-fill text-sm-center nav-link active" id="btnTab1" type="button" onclick="tab(1)">Modul</a>
      <a class="flex-sm-fill text-sm-center nav-link" id="btnTab2" type="button" onclick="tab(2)">Menu</a>
      <a class="flex-sm-fill text-sm-center nav-link" id="btnTab3" type="button" onclick="tab(3)">Sub Menu</a>
      <input type="hidden" id="parameteForm" class="form-control" value="1">
    </nav>
  </div>
  <div class="card-body">
    <div id="contentForm"></div>
  </div>
</div>

<script>
  var table = $('#tableModul');
  var table1 = $('#tableMenu');
  var table2 = $('#tableSubMenu');

  const btnTab1 = $('#btnTab1');
  const btnTab2 = $('#btnTab2');
  const btnTab3 = $('#btnTab3');
  const forTab1 = $('#forTab1');
  const forTab2 = $('#forTab2');
  const forTab3 = $('#forTab3');

  const contentForm = $("#contentForm")
  var parameteForm = $("#parameteForm")

  $(document).ready(function() {
    tab(1);
  });

  function tab(par) {
    parameteForm.val(par)
    if (par == 1) {
      btnTab1.addClass('active');
      btnTab2.removeClass('active');
      btnTab3.removeClass('active');

      forTab1.show();
      forTab2.hide();
      forTab3.hide();
    } else if (par == 2) {
      btnTab2.addClass('active');
      btnTab1.removeClass('active');
      btnTab3.removeClass('active');

      forTab2.show();
      forTab1.hide();
      forTab3.hide();
    } else {
      btnTab3.addClass('active');
      btnTab1.removeClass('active');
      btnTab2.removeClass('active');

      forTab3.show();
      forTab1.hide();
      forTab2.hide();
    }
    $.get(siteUrl + "C_modul/Tab/" + par, function(data) {
      contentForm.html(data)
    })
  }
</script>