<?php
$code 	= $this->input->get('code');
$email 	= $this->input->get('email');

if ($this->session->flashdata('info')) echo $this->session->flashdata('info');
?>

<div class="my-5">
	<div class="container">
		<div class="d-flex justify-content-center form-row">
			<div class="col-lg-4 post-outer">
				<div class="mb-4 text-left h4">
					Password Baru
				</div>
				<div class="card brad-20">
					<div class="card-body brad-20 shadow">
						<div class="my-3">
							<?php echo validation_errors('<script>swal({title: "Warning", text: "', '", timer: 10000, icon: "warning", button: false});</script>'); ?>
							<?= form_open('password_reset/reset?code='.$code.'&email='.$email.''); ?>
								<input type="password" name="password" value="<?= set_value('password'); ?>" placeholder="Password" class="form-control mb-4">

								<input type="password" name="password_confirm" value="<?= set_value('password_confirm'); ?>" placeholder="Confirm Password" class="form-control mb-4">

								<button type="submit" name="submit" class="btn btn-primary btn-block">Ubah Password</button>
							<?= form_close(); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

