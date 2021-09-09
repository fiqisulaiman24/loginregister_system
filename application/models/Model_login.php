<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_login extends CI_Model {

	public function login($email, $password)
	{
		$this->db->select('*');
		$this->db->from('user');
		$this->db->where('email', $email);

		$hash = $this->db->get()->row('password');
		return $this->verify($password, $hash);
	}

	private function verify($password, $hash)
	{
		return password_verify($password, $hash);
	}

	public function active($email)
	{
		$this->db->select('aktif');
		$this->db->from('user');
		$this->db->where('email', $email);

		return $this->db->get()->row('aktif');
	}

	public function user_id($email)
	{
		$this->db->select('user_id');
		$this->db->from('user');
		$this->db->where('email', $email);

		return $this->db->get()->row('user_id');
	}

	public function nama($email)
	{
		$this->db->select('nama');
		$this->db->from('user');
		$this->db->where('email', $email);

		return $this->db->get()->row('nama');
	}

	public function foto_profil($email)
	{
		$this->db->select('foto_profil');
		$this->db->from('user');
		$this->db->where('email', $email);

		return $this->db->get()->row('foto_profil');
	}
}

/* End of file model_login.php */
/* Location: ./application/models/model_login.php */