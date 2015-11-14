<?php

class AdminController extends VanillaController {
	
	protected $_error;
	protected $_username;
	
	function beforeAction () {
		session_start();
		$this->_user = new User();
	}

	function index($id = null) {
		$this->isLoggedIn();
		$this->set('username', $this->_username);
		$this->set('sectionName', 'Home');

	}
	
	function login(){
		$error = isset($_SESSION['loggedIn']['error']) ? $_SESSION['loggedIn']['error'] : '' ;
		$this->set('error', $error);
	}
	
	
	function settings(){
		$this->isLoggedIn();
		$this->set('username', $this->_username);
		$this->set('sectionName', 'Admin Settings');
	}
	
	
	function updateSettings(){
		$this->_user->where(array('password' => $_SESSION['loggedIn']['success']));
		$user = $this->_user->search();
		$this->_user->id = $user[0]['User']['id'];
		if(isset($_POST['name'])) $this->_user->name = $_POST['name'];
		if(isset($_POST['password']) && !empty($_POST['password'])){
			$this->_user->password = md5($_POST['password']);
			$_SESSION['loggedIn']['success'] = md5($_POST['password']);
		}
		$this->_user->save();
		
		redirect('/admin/settings');
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
				$this->_username = $data[0]['User']['name'];
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