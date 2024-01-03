<form class="user">
  <!-- Outer Row -->
  <div class="row justify-content-center">

    <div class="col-xl-4 col-lg-12 col-md-9">

      <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
          <!-- Nested Row within Card Body -->
          <div class="row">
            <div class="col-md-12">
              <div class="p-4">
                <div class="text-center">
                  <h1 class="h4 text-gray-900 mb-4"><?= $judul; ?></h1>
                </div>
                <hr>
                <div class="form-group">
                  <input type="text" class="form-control" id="username" name="username" placeholder="Username...">
                </div>
                <div class="form-group">
                  <input type="password" class="form-control" id="password" name="password" placeholder="Sandi...">
                </div>
                <div class="form-group">
                  <select name="cabang" id="cabang" class="form-control" data-placeholder="-- Cabang --">
                    <option value="">-- Cabang --</option>
                  </select>
                </div>
                <button type="button" class="btn btn-primary btn-block">
                  Masuk
                </button>
                <hr>
                <div class="text-center">
                  <a class="small" href="<?= site_url() ?>Auth/regist">Belum Punya Akun!</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>

  </div>
</form>

<script>
</script>