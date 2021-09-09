<?php
if ($this->session->flashdata('info')) echo $this->session->flashdata('info');
?>
<div class="my-5">
	<div class="container">
		<div class="d-flex justify-content-center form-row">
			<div class="col-lg-8 post-outer">
				<div class="mb-4 text-left h4">
					Login
				</div>
				<div class="card brad-20">
					<div class="card-body brad-20 shadow">
						<div class="my-3">
							<?= form_open(''); ?>
								<?php echo validation_errors('<script>swal({title: "Warning", text: "', '", timer: 10000, icon: "warning", button: false});</script>'); ?>
								<input type="text" name="email" value="<?= set_value('email'); ?>" placeholder="Email" class="form-control mb-4">

								<input type="password" name="password" value="<?= set_value('password'); ?>" placeholder="Password" class="form-control mb-4">

								<button type="submit" name="submit" class="btn btn-primary btn-block mb-4">Login</button>
							<?= form_close(); ?>
							<div class="float-left">
								<a href="<?= base_url('password_reset'); ?>" title="Forgot password?" class="card-link link">
									Lupa password?
								</a>
							</div>
							<div class="float-right">
								<a href="<?= base_url('join'); ?>" title="Join Us" class="card-link link">
									Daftar
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
