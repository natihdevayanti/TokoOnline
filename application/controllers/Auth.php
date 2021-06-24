<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	function __construct() {
		parent::__construct();
		$this->load->model('users');
		$this->load->helper('url');
		$this->load->helper('form');
		parse_str($_SERVER['QUERY_STRING'], $_GET); 
	}

	public function index() {
        redirect('/login', true);
	}

    public function register(){
		if ($this->input->server('REQUEST_METHOD') === 'GET') {
			$this->load->view('register');
		 } else if ($this->input->server('REQUEST_METHOD') === 'POST') {
			if($this->input->post('name') && $this->input->post('password') && $this->input->post('confirmation_password')){
				$name = $this->input->post('name');
				$password = $this->input->post('password');
				$confirmationPassword = $this->input->post('confirmation_password');
				$response = $this->users->register($name, $password, $confirmationPassword);
				echo $response['message'];
			}
		 }
    }

    public function login(){
		if ($this->input->server('REQUEST_METHOD') === 'GET') {
			$this->load->view('login');
		 } else if ($this->input->server('REQUEST_METHOD') === 'POST') {
			if($this->input->post('name') && $this->input->post('password')){
				$name = $this->input->post('name');
				$password = $this->input->post('password');
				$response = $this->users->login($name, $password);
				echo $response['message'];
			}
		 }
    }
}
