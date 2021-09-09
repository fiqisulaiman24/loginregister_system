<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Join extends CI_Controller {

	public function index()
	{
		$this->form_validation->set_rules('email', 'email', 'trim|required|valid_email|is_unique[user.email]', array('is_unique' => 'Email %s ini sudah digunakan'));

		$this->form_validation->set_rules('password', 'password', 'trim|required|min_length[6]');

		$this->form_validation->set_rules('password_confirm', 'confirm password', 'trim|required|matches[password]');

		if ($this->form_validation->run() == TRUE)
		{
			$nama 		= $this->input->post('nama');
			$email 		= $this->input->post('email');
			$password 	= $this->input->post('password');
			$foto_profil = $_FILES['foto_profil']['name'];

			$this->load->model('model_join');
			$this->load->helper('string');

			$kode_aktifasi = random_string('alnum', 50);

			if ($this->model_join->join($nama, $email, $password, $foto_profil, $kode_aktifasi))
			{
				$config['upload_path'] = 'assets/upload';
				$config['allowed_types'] = 'jpg|png';
				$config['max_size']  = '3000';
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				if ( ! $this->upload->do_upload('foto_profil')){
					$error = array('error' => $this->upload->display_errors());
				}else{
					$data = array('upload_data' => $this->upload->data());
					$this->_email($email, $kode_aktifasi);

					$this->session->set_flashdata('info', '<script>swal({title: "Info", text: "Periksa email anda untuk mengaktifkan akun", timer: 3000, icon: "info", button: false});</script>');
					redirect(base_url(), 'refresh');
				}
			} else {
				$this->session->set_flashdata('info', '<script>swal({title: "Error", text: "Oops... Ada yang salah pada pembuatan akun anda", timer: 3000, icon: "error", button: false});</script>');
				redirect(base_url('join'), 'refresh');
			}
		} else {
			$data = array('title' => 'Daftar Akun');

			$this->load->view('template/header', $data, FALSE);
			$this->load->view('join');
			$this->load->view('template/footer');
		}
	}

	function _email($email, $kode_aktifasi)
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
		$this->email->subject('[Konfirmasi Email]');

        $html = '
			<div style="margin-bottom: 20px; font-weight: bold;">Halo ,'.$email.'</div>

			<div>Terima kasih sudah bergabung.</div>
			<div style="margin-bottom: 10px;">Untuk mengaktifkan akun anda, silahkan klik pada link ini dan anda akan di arahkan pada halaman login : <a href="'.base_url('activate?code='.$kode_aktifasi.'&email='.$email).'">Konfirmasi alamat email</a>.
			</div>

			<div>Jika link tersebut tidak berhasil, anda bisa mengakses nya dengan alamat URL ini pada browser anda</div>

			<div><a href="'.base_url('activate?code='.$kode_aktifasi.'&email='.$email).'">'.base_url('activate?code='.$kode_aktifasi.'&email='.$email).'</a></div>

			<div style="margin-bottom: 20px; margin-top: 10px;">Jika anda mempunyai pertanyaan, silahkan balas email ini dan nanti akan kami hubungi sebisa mungkin, terima kasih !</div>
		';

		$this->email->message($html);
		return $this->email->send();
	}
}

/* End of file join.php */
/* Location: ./application/controllers/join.php */