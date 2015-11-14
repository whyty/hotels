<?php

class AdminController extends VanillaController {
	
	function beforeAction () {
		session_start();
		$this->_user = new User();
	}

	function index($id = null) {
		$this->isLoggedIn();
		$this->_user->where(array('password' => $_SESSION['loggedIn']['success']));
		$response = $this->_user->search();
		$this->set('username', $response[0]['User']['name']);

	}
	
	function login(){
		$error = isset($_SESSION['loggedIn']['error']) ? $_SESSION['loggedIn']['error'] : '' ;
		$this->set('error', $error);
	}
	
	function signin(){
		$_SESSION['loggedIn'] = array();
		$this->_user->where(array("username" => $_POST['username'],"password" => md5($_POST['password'])));
		if ($this->_user->search()){
			$data = $this->_user->search();
			$_SESSION['loggedIn']['success'] = $data[0]['User']['password'];
			redirect("/admin");
		 }else{
			$_SESSION['loggedIn']['error'] = 'Username / password wrong';
			redirect("/admin/login");
		 }
	}

	function isLoggedIn(){
		if(isset($_SESSION['loggedIn']['success'])){
			$this->_user->where(array('password' => $_SESSION['loggedIn']['success']));
			$data = $this->_user->search();
			if($data){
				return true;
			}else{
				redirect("/admin/login");
			}
		}else{
			redirect("/admin/login");
		}
	}
	
	function logout() {
		unset($_SESSION['loggedIn']);
		redirect("/admin/login");
	}
	
	function afterAction() {

	}

}