<?php
if(!$this->session->has_userdata('user_id')) redirect(base_url(),'refresh');
if ($this->session->flashdata('info')) echo $this->session->flashdata('info');
?>
<div class="my-3">
	<div class="container">
		<div class="d-flex justify-content-center form-row align-items-center">
			<div class="col-lg-8 post-outer">
				<div class="card brad-20 text-dark mb-3">
					<div class="card-body brad-20 shadow">
						<div class="my-0">
							<p>Selamat datang !</p>
							<div class="float-left">
								<p class="h5 font-weight-bold"><?= $this->session->userdata('nama'); ?></p>
								<p class="h5 font-weight-bold"><?= $this->session->userdata('email'); ?></p>
								<p>ID user : <?= $this->session->userdata('user_id'); ?></p>
								<a href="<?= base_url('login/logout'); ?>" class="text-center text-primary font-weight-bold">
									<i class="fa fa-sign-out-alt text-primary"></i> Logout
								</a>
							</div>
							<div class="float-right">
								<img width="64" style="border-radius: 50em;" src="<?= base_url('assets/upload/'.$this->session->userdata('foto_profil'))?>">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>