<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function index()
	{
		if ($this->session->has_userdata('user_id'))
		{
			redirect(base_url('home'), 'refresh');
		}

		$this->form_validation->set_rules('email', 'email', 'trim|required|valid_email');

		$this->form_validation->set_rules('password', 'password', 'trim|required');

		if ($this->form_validation->run() == TRUE)
		{
			$email 		= $this->input->post('email');
			$password 	= $this->input->post('password');

			$this->load->model('model_login');

			if ($this->model_login->login($email, $password))
			{
				if ($this->model_login->active($email) != 0)
				{
					$session = array(
						'user_id' 	=> $this->model_login->user_id($email),
						'nama'		=> $this->model_login->nama($email),
						'foto_profil' => $this->model_login->foto_profil($email),
						'email'		=> $email,
					);

					$this->session->set_userdata($session);
					$this->session->set_flashdata('info', '<script>swal({title: "Success", text: "Anda berhasil login", timer: 3000, icon: "success", button: false});</script>');
					redirect(base_url('home'), 'refresh');
				} else {
					$this->session->set_flashdata('info', '<script>swal({title: "Info", text: "Konfirmasi terlebih dahulu melalui email anda", timer: 3000, icon: "info", button: false});</script>');
					redirect(base_url(), 'refresh');
				}
			} else {
				$this->session->set_flashdata('info', '<script>swal({title: "Error", text: "Email atau password anda salah", timer: 3000, icon: "error", button: false});</script>');
				redirect(base_url(), 'refresh');
			}
		} else {
			$data = array('title' => 'Login');

			$this->load->view('template/header', $data, FALSE);
			$this->load->view('login');
			$this->load->view('template/footer');
		}
	}

	public function logout()
	{
		if ($this->session->has_userdata('user_id'))
		{
			$this->session->unset_userdata('user_id');
			$this->session->unset_userdata('nama');
			$this->session->unset_userdata('email');
			$this->session->unset_userdata('foto_profil');
			$this->session->set_flashdata('info', '<script>swal({title: "Success", text: "Anda berhasil logout", timer: 10000, icon: "success", button: false});</script>');
			redirect(base_url(), 'refresh');
		} else echo show_404();
	}
}

/* End of file Home.php */
/* Location: ./application/controllers/Home.php */