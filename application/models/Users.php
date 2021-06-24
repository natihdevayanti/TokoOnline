<?php
class Users extends CI_Model {

    public function __construct(){
        $this->load->database();
    }

    public function register($name, $password, $confirmationPassword){
        if(strlen($password) < 8){
            return array('status'=>'ERROR', 'message'=>'password less than 8 characters');
        }
        if($password != $confirmationPassword){
            return array('status'=>'ERROR', 'message'=>'your password confirmation is not the same as password');
        }

        $data = array(
            'username' => $this->input->post('name'),
            'password' => hash('sha256', $password, false)
        );

        $response = $this->db->insert('users', $data);

        return array('status'=>'OK', 'message'=>'Registration Successful');
    }
    
    public function login($name, $password){
        $data = $this->db->get_where('users', array('username' => $name))->result();

        if(count($data) <= 0){
            return array('status'=>'ERROR', 'message'=>'User not found');
        }

        if($data[0]->password === hash('sha256', $password, false)){
            return array('status'=>'OK', 'message'=>'Login Successful');
        }

        return array('status'=>'ERROR', 'message'=>'Password is not correct');
    }
}