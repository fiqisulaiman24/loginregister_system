<?php
if ($this->session->flashdata('info')) echo $this->session->flashdata('info');
?>
<div class="my-5">
	<div class="container">
		<div class="d-flex justify-content-center form-row">
			<div class="col-lg-6 post-outer">
				<div class="mb-4 text-left h4">
					Daftar Akun
				</div>
				<div class="card brad-20">
					<div class="card-body brad-20 shadow">
						<div class="my-3">
							<?= form_open_multipart('join'); ?>
								<?php echo validation_errors('<script>swal({title: "Warning", text: "', '", timer: 10000, icon: "warning", button: false});</script>'); ?>
								<input type="text" name="nama" value="<?= set_value('nama'); ?>" placeholder="Nama" class="form-control mb-3">

								<input type="text" name="email" value="<?= set_value('email'); ?>" placeholder="Email" class="form-control mb-3">

								<input type="password" name="password" value="<?= set_value('password'); ?>" placeholder="Password" class="form-control mb-3">

								<input type="password" name="password_confirm" value="<?= set_value('password_confirm'); ?>" placeholder="Konfirmasi Password" class="form-control mb-3">

								<img src="<?= base_url('assets/img/avatar.png')?>" id="foto_profil" class="img-fluid float-left mb-3" alt="foto_profil" width="64">

								<input type="file" name="foto_profil" id="input_foto_profil" class="form-control mb-3" required style="border:0; margin:0; padding:0;">

								<button type="submit" name="submit" class="btn btn-primary btn-block mb-3">Daftar</button>
							<?= form_close(); ?>

							<div class="text-center text-dark">
								Sudah punya akun?
								<a href="<?= base_url(); ?>" title="Login" class="card-link">
									Login
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript" src="<?= base_url('assets/jquery/jquery.min.js')?>"></script>
<script type="text/javascript">
	function readURL_foto_profil(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) {
        $('#foto_profil').attr('src', e.target.result);
      }
      reader.readAsDataURL(input.files[0]); // convert to base64 string
    }
  }

  $("#input_foto_profil").change(function() {
    readURL_foto_profil(this);
  });
</script>