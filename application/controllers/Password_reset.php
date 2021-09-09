<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Password_reset extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('model_password');
		$this->load->helper('string');
	}

	public function index()
	{
		$this->form_validation->set_rules('email', 'email', 'trim|required|valid_email');

		if ($this->form_validation->run() == TRUE)
		{
			$email 			= $this->input->post('email');
			$kode_aktifasi 	= random_string('alnum', 50);

			if ($this->model_password->cek($email, $kode_aktifasi))
			{
				$this->_email_reset($email, $kode_aktifasi);

				$this->session->set_flashdata('info', '<script>swal({title: "Success", text: "Link untuk reset password anda sudah dikirim", timer: 3000, icon: "success", button: false});</script>');
				redirect(base_url('login'),'refresh');
			} else {
				$this->session->set_flashdata('info', '<script>swal({title: "Error", text: "Tidak ada akun dengan email yang anda masukan", timer: 3000, icon: "error", button: false});</script>');
				redirect(base_url('password_reset'),'refresh');
			}
		} else {
			$data = array('title' => 'Reset Password');

			$this->load->view('template/header', $data, FALSE);
			$this->load->view('password_reset');
			$this->load->view('template/footer');
		}
	}

	public function reset()
	{
		$code 	= $this->input->get('code');
		$email 	= $this->input->get('email');

		$this->form_validation->set_rules('password', 'password', 'trim|required|min_length[6]');
		$this->form_validation->set_rules('password_confirm', 'confirm password', 'trim|required|matches[password]');

		if ($this->form_validation->run() == TRUE)
		{
			$password = $this->input->post('password');

			$this->model_password->renew($email, $password);
			$this->_email_sukses($email);

			$this->session->set_flashdata('info', '<script>swal({title: "Success", text: "Password anda berhasil direset", timer: 3000, icon: "success", button: false});</script>');
			redirect(base_url(), 'refresh');
		}else {
			if (strlen($code)==50 && !empty($email))
			{
				if ($this->model_password->reset($code, $email))
				{
					$data = array('title' => 'Password Renew');

					$this->load->view('template/header', $data, FALSE);
					$this->load->view('password_renew');
					$this->load->view('template/footer');
				} else show_404();
			} else if(empty($code) && empty($email)) {
				show_404();
			} else {
				$this->session->set_flashdata('info', '<script>swal({title: "Success", text: "Link untuk reset password anda tidak benar", timer: 3000, icon: "success", button: false});</script>');
				redirect(base_url('password_reset'), 'refresh');
			}
		}
	}

	function _email_reset($email, $kode_aktifasi)
	{
		$config = [
			'mailtype'  	=> 'html',
			'charset'   	=> 'utf-8',
			'protocol'  	=> 'smtp',
			'smtp_host' 	=> 'smtp.gmail.com',
			'smtp_user' 	=> 'rechtweezjr@gmail.com', // second email of fiqi sulaiman
			'smtp_pass'   	=> 'Loverozarado', // my second email password :(
			'smtp_crypto' 	=> 'ssl',
			'smtp_port'   	=> 465,
			'crlf'    		=> "\r\n",
			'newline' 		=> "\r\n"
		];

		$this->load->library('email', $config);
		$this->email->initialize($config);
		$this->email->from('rechtweezjr@gmail.com', 'Rechtweez');
		$this->email->to($email);
		$this->email->subject('[Reset Password]');

		$html = '
		<div style="margin-bottom: 20px; font-weight: bold;">Halo, '.$email.'</div>

		<div>Seperti nya anda meminta untuk mereset password pada akun anda.</div>

		<div style="margin-bottom: 10px;">Untuk mereset password pada akun anda, silahkan klik link berikut ini dan kami akan mengarahkan anda ke halaman reset password : <a href="'.base_url('password_reset/reset?code='.$kode_aktifasi.'&email='.$email).'">Reset password saya</a>.
		</div>

		<div>Jika link tersebut tidak berhasil, anda bisa mengakses nya dengan alamat URL ini pada browser anda</div>

		<div><a href="'.base_url('password_reset/reset?code='.$kode_aktifasi.'&email='.$email).'">'.base_url('password_reset/reset?code='.$kode_aktifasi.'&email='.$email).'</a></div>

		<div style="margin-bottom: 20px; margin-top: 10px;">Jika anda mempunyai pertanyaan, silahkan balas email ini dan nanti akan kami hubungi sebisa mungkin, terima kasih !</div>
		';

		$this->email->message($html);
		return $this->email->send();
	}

	function _email_sukses($email)
	{
		$config = [
			'mailtype'  	=> 'html',
			'charset'   	=> 'utf-8',
			'protocol'  	=> 'smtp',
			'smtp_host' 	=> 'smtp.gmail.com',
			'smtp_user' 	=> 'rechtweezjr@gmail.com', // second email of fiqi sulaiman
			'smtp_pass'   	=> 'Loverozarado', // my second email password :(
			'smtp_crypto' 	=> 'ssl',
			'smtp_port'   	=> 465,
			'crlf'    		=> "\r\n",
			'newline' 		=> "\r\n"
		];

		$this->load->library('email', $config);
		$this->email->initialize($config);
		$this->email->from('rechtweezjr@gmail.com', 'Rechtweez');
		$this->email->to($email);
		$this->email->subject('[Reset Password Berhasil]');

		$html = '
		<div style="margin-bottom: 20px; font-weight: bold;">Halo, '.$email.'</div>
		<div>Password anda sudah direset pada waktu'.date('Y/m/d h:i:s a').', Tolong tetap jaga keamanan akun anda :)</div>

		<div style="margin-bottom: 20px; margin-top: 10px;">Jika anda mempunyai pertanyaan, silahkan balas email ini dan nanti akan kami hubungi sebisa mungkin, terima kasih !</div>
		';

		$this->email->message($html);
		return $this->email->send();
	}
}

/* End of file password_reset.php */
/* Location: ./application/controllers/password_reset.php */