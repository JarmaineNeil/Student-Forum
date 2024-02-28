<?php
session_start();
ini_set('display_errors', 1);
Class Action {
	private $db;

	public function __construct() {
		ob_start();
   	include 'db_connect.php';
    
    $this->db = $conn;
	}
	
	// function login
	function login(){
		
			extract($_POST);		
			$stmt = $this->db->prepare("SELECT * FROM users WHERE username = :username AND password = :password");
			$stmt->bindParam(':username', $username, PDO::PARAM_STR);
			$stmt->bindParam(':password', md5($password), PDO::PARAM_STR);
			$stmt->execute();

			if($stmt->rowCount() > 0) {
				$result = $stmt->fetch(PDO::FETCH_ASSOC);

				foreach ($result as $key => $value) {
					if($key != 'password' && !is_numeric($key)) {
						$_SESSION['login_'.$key] = $value;
					}
				}

				return 1;
			} else {
				return 3;
			}

	}

	// function logout
	function logout(){
		session_destroy();

		foreach ($_SESSION as $key => $value) {
			unset($_SESSION[$key]);
		}

		header("location: login.php");
		exit;
	
	}
	function logout2(){
		session_destroy();
		foreach ($_SESSION as $key => $value) {
			unset($_SESSION[$key]);
		}
		header("location:../index.php");
	}

	// save user function
	function save_user(){
		extract($_POST);
		$data = "name = :name, username = :username, type = :type";
		$parameters = [
			':name' => $name,
			':username' => $username,
			':type' => $type,
		];

		if (!empty($password)) {
			$data .= ", password = :password";
			$parameters[':password'] = md5($password);
		}

		$chkStmt = $this->db->prepare("SELECT * FROM users WHERE username = :check_username AND id != :id");
		$chkStmt->bindParam(':check_username', $username, PDO::PARAM_STR);
		$chkStmt->bindParam(':id', $id, PDO::PARAM_INT);
		$chkStmt->execute();

		if ($chkStmt->rowCount() > 0) {
			return 2;
		}

		if (empty($id)) {
			$saveStmt = $this->db->prepare("INSERT INTO users SET " . $data);
		} else {
			$saveStmt = $this->db->prepare("UPDATE users SET " . $data . " WHERE id = :id");
			$saveStmt->bindParam(':id', $id, PDO::PARAM_INT);
		}

		$saveResult = $saveStmt->execute($parameters);

		if ($saveResult) {
			return 1;
		}

	}

	//delete user
	function delete_user(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM users where id = ".$id);
		if($delete)
			return 1;
	}


	//signup function
	function signup()
	{
		extract($_POST);

		$data = " name = :fullname ";
		$data .= ", username = :email ";
		$data .= ", password = :password ";

		$stmtCheckUsername = $this->db->prepare("SELECT * FROM users WHERE username = :email");
		$stmtCheckUsername->bindParam(':email', $email, PDO::PARAM_STR);
		$stmtCheckUsername->execute();
		$chk = $stmtCheckUsername->rowCount();

		if ($chk > 0) {
			return 2;
		}

		$stmtSaveUser = $this->db->prepare("INSERT INTO users SET $data");
		$stmtSaveUser->bindParam(':fullname', $firstname . ' ' . $lastname, PDO::PARAM_STR);
		$stmtSaveUser->bindParam(':email', $email, PDO::PARAM_STR);
		$stmtSaveUser->bindParam(':password', md5($password), PDO::PARAM_STR);
		$save = $stmtSaveUser->execute();

		if ($save) {
			$uid = $this->db->lastInsertId();
			$data = '';

			foreach ($_POST as $k => $v) {
				if ($k == 'password') {
					continue;
				}

				if (empty($data) && !is_numeric($k)) {
					$data = " $k = :$k ";
				} else {
					$data .= ", $k = :$k ";
				}
			}

			if (!empty($_FILES['img']['tmp_name'])) {
				$fname = strtotime(date('y-m-d H:i')) . '_' . $_FILES['img']['name'];
				$move = move_uploaded_file($_FILES['img']['tmp_name'], 'assets/uploads/' . $fname);
				$data .= ", avatar = :avatar ";
			}

			$stmtSaveAlumni = $this->db->prepare("INSERT INTO alumnus_bio SET $data");
			$stmtSaveAlumni->bindParam(':avatar', $fname, PDO::PARAM_STR);
			
			foreach ($_POST as $k => $v) {
				if ($k != 'password') {
					$stmtSaveAlumni->bindParam(":$k", $v, PDO::PARAM_STR);
				}
			}

			$save_alumni = $stmtSaveAlumni->execute();

			if ($save_alumni) {
				$aid = $this->db->lastInsertId();
				$stmtUpdateUser = $this->db->prepare("UPDATE users SET alumnus_id = :aid WHERE id = :uid");
				$stmtUpdateUser->bindParam(':aid', $aid, PDO::PARAM_INT);
				$stmtUpdateUser->bindParam(':uid', $uid, PDO::PARAM_INT);
				$stmtUpdateUser->execute();

				$login = $this->login();

				if ($login) {
					return 1;
				}
			}
		}
	}

	// edit account
	function update_account()
	{
		extract($_POST);
	
		$data = " name = :fullname ";
		$data .= ", username = :email ";
	
		if (!empty($password)) {
			$data .= ", password = :password ";
		}
	
		$stmtCheckUsername = $this->db->prepare("SELECT * FROM users WHERE username = :email AND id != :login_id");
		$stmtCheckUsername->bindParam(':email', $email, PDO::PARAM_STR);
		$stmtCheckUsername->bindParam(':login_id', $_SESSION['login_id'], PDO::PARAM_INT);
		$stmtCheckUsername->execute();
	
		$chk = $stmtCheckUsername->rowCount();
	
		if ($chk > 0) {
			return 2;
		}
	
		$stmtUpdateUser = $this->db->prepare("UPDATE users SET $data WHERE id = :login_id");
		$stmtUpdateUser->bindParam(':fullname', $firstname . ' ' . $lastname, PDO::PARAM_STR);
		$stmtUpdateUser->bindParam(':email', $email, PDO::PARAM_STR);
		$stmtUpdateUser->bindParam(':password', md5($password), PDO::PARAM_STR);
	
		$stmtUpdateUser->bindParam(':login_id', $_SESSION['login_id'], PDO::PARAM_INT);
		$save = $stmtUpdateUser->execute();
	
		if ($save) {
			$data = '';
	
			foreach ($_POST as $k => $v) {
				if ($k == 'password') {
					continue;
				}
	
				if (empty($data) && !is_numeric($k)) {
					$data = " $k = :$k ";
				} else {
					$data .= ", $k = :$k ";
				}
			}
	
			if (!empty($_FILES['img']['tmp_name'])) {
				$fname = strtotime(date('y-m-d H:i')) . '_' . $_FILES['img']['name'];
				$move = move_uploaded_file($_FILES['img']['tmp_name'], 'assets/uploads/' . $fname);
				$data .= ", avatar = :avatar ";
			}
	
			$stmtUpdateAlumni = $this->db->prepare("UPDATE alumnus_bio SET $data WHERE id = :bio_id");
			$stmtUpdateAlumni->bindParam(':avatar', $fname, PDO::PARAM_STR);
	
			foreach ($_POST as $k => $v) {
				if ($k != 'password') {
					$stmtUpdateAlumni->bindParam(":$k", $v, PDO::PARAM_STR);
				}
			}
	
			$stmtUpdateAlumni->bindParam(':bio_id', $_SESSION['bio']['id'], PDO::PARAM_INT);
			$save_alumni = $stmtUpdateAlumni->execute();
	
			if ($save_alumni) {
				foreach ($_SESSION as $key => $value) {
					unset($_SESSION[$key]);
				}
				$login = $this->login();
				if ($login) {
					return 1;
				}
			}
		}
	}
	
	//save function
	function save_category()
	{
		extract($_POST);

		$data = " name = :name ";
		$data .= ", description = :description ";

		if (empty($id)) {
			$stmtSave = $this->db->prepare("INSERT INTO categories SET $data");
		} else {
			$stmtSave = $this->db->prepare("UPDATE categories SET $data WHERE id = :id");
			$stmtSave->bindParam(':id', $id, PDO::PARAM_INT);
		}

		$stmtSave->bindParam(':name', $name, PDO::PARAM_STR);
		$stmtSave->bindParam(':description', $description, PDO::PARAM_STR);

		$save = $stmtSave->execute();

		if ($save) {
			return 1;
		}
	}

	// delete
	function delete_category(){
		extract($_POST);

		$stmtDelete = $this->db->prepare("DELETE FROM categories WHERE id = :id");
		$stmtDelete->bindParam(':id', $id, PDO::PARAM_INT);

		$delete = $stmtDelete->execute();

		if ($delete) {
			return 1;
		}

	}

	//create
	function save_topic()
	{
		extract($_POST);
	
		$data = " title = :title ";
		$data .= ", category_ids = :category_ids ";
		$data .= ", content = :content ";
	
		if (empty($id)) {
			$data .= ", user_id = :login_id ";
			$stmtSave = $this->db->prepare("INSERT INTO topics SET $data");
		} else {
			$stmtSave = $this->db->prepare("UPDATE topics SET $data WHERE id = :id");
			$stmtSave->bindParam(':id', $id, PDO::PARAM_INT);
		}
	
		$stmtSave->bindParam(':title', $title, PDO::PARAM_STR);
		$stmtSave->bindParam(':category_ids', implode(",", $category_ids), PDO::PARAM_STR);
		$stmtSave->bindParam(':content', htmlentities(str_replace("'", "&#x2019;", $content)), PDO::PARAM_STR);
	
		if (empty($id)) {
			$stmtSave->bindParam(':login_id', $_SESSION['login_id'], PDO::PARAM_INT);
		}
	
		$save = $stmtSave->execute();
	
		if ($save) {
			return 1;
		}
	}
	
	//delete
	function delete_topic()
	{
		extract($_POST);
	
		$stmtDelete = $this->db->prepare("DELETE FROM topics WHERE id = :id");
		$stmtDelete->bindParam(':id', $id, PDO::PARAM_INT);
	
		$delete = $stmtDelete->execute();
	
		if ($delete) {
			return 1;
		}
	}
	
	//create
	function save_comment()
	{
		extract($_POST);
	
		$data = " comment = :comment ";
	
		if (empty($id)) {
			$data .= ", topic_id = :topic_id ";
			$data .= ", user_id = :login_id ";
			$stmtSave = $this->db->prepare("INSERT INTO comments SET $data");
		} else {
			$stmtSave = $this->db->prepare("UPDATE comments SET $data WHERE id = :id");
			$stmtSave->bindParam(':id', $id, PDO::PARAM_INT);
		}
	
		$stmtSave->bindParam(':comment', htmlentities(str_replace("'", "&#x2019;", $comment)), PDO::PARAM_STR);
	
		if (empty($id)) {
			$stmtSave->bindParam(':topic_id', $topic_id, PDO::PARAM_INT);
			$stmtSave->bindParam(':login_id', $_SESSION['login_id'], PDO::PARAM_INT);
		}
	
		$save = $stmtSave->execute();
	
		if ($save) {
			return 1;
		}
	}
	
	//delete
	function delete_comment()
	{
		extract($_POST);
	
		$stmtDelete = $this->db->prepare("DELETE FROM comments WHERE id = :id");
		$stmtDelete->bindParam(':id', $id, PDO::PARAM_INT);
	
		$delete = $stmtDelete->execute();
	
		if ($delete) {
			return 1;
		}
	}
	
	//add
	function save_reply()
	{
		extract($_POST);
	
		$data = " reply = :reply ";
	
		if (empty($id)) {
			$data .= ", comment_id = :comment_id ";
			$data .= ", user_id = :login_id ";
			$stmtSave = $this->db->prepare("INSERT INTO replies SET $data");
		} else {
			$stmtSave = $this->db->prepare("UPDATE replies SET $data WHERE id = :id");
			$stmtSave->bindParam(':id', $id, PDO::PARAM_INT);
		}
	
		$stmtSave->bindParam(':reply', htmlentities(str_replace("'", "&#x2019;", $reply)), PDO::PARAM_STR);
	
		if (empty($id)) {
			$stmtSave->bindParam(':comment_id', $comment_id, PDO::PARAM_INT);
			$stmtSave->bindParam(':login_id', $_SESSION['login_id'], PDO::PARAM_INT);
		}
	
		$save = $stmtSave->execute();
	
		if ($save) {
			return 1;
		}
	}
	
	//delete
	function delete_reply()
	{
		extract($_POST);
	
		$stmtDelete = $this->db->prepare("DELETE FROM replies WHERE id = :id");
		$stmtDelete->bindParam(':id', $id, PDO::PARAM_INT);
	
		$delete = $stmtDelete->execute();
	
		if ($delete) {
			return 1;
		}
	}

}