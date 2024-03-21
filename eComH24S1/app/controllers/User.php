<?php
namespace app\controllers;

class User extends \app\core\Controller
{

	// Method to handle user login
	function login()
	{
		// Show the login form and log the user in
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			// Log the user in... if the password is correct
			// Get the user from the database
			$username = $_POST['username'];
			$user = new \app\models\User();
			$user = $user->get($username);
			// Check the password against the hash
			$password = $_POST['password'];
			if ($user && $user->active && password_verify($password, $user->password_hash)) {
				// Remember that this is the user logging in...
				$_SESSION['user_id'] = $user->user_id;

				header('location:/User/securePlace');
			} else {
				header('location:/User/login');
			}
		} else {
			$this->view('User/login');
		}
	}

	// Method to handle user logout
	function logout()
	{
		// Destroy the session and redirect to the login page
		session_destroy();
		header('location:/User/login');
	}

	// Method to access a secure location (requires login)
	function securePlace()
	{
		if (!isset($_SESSION['user_id'])) {
			header('location:/User/login');
			return;
		}
		echo 'You are safe. You are in a secure location.';
	}

	// Method to handle user registration
	function register()
	{
		// Display the registration form and process the registration
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			// Create a new User object
			$user = new \app\models\User();
			// Populate the User object
			$user->username = $_POST['username'];
			$user->password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
			// Insert the user into the database
			$user->insert();
			// Redirect to the login page
			header('location:/User/login');
		} else {
			$this->view('User/registration');
		}
	}

	// Method to update user record
	function update()
	{
		if (!isset($_SESSION['user_id'])) {
			header('location:/User/login');
			return;
		}

		$user = new \app\models\User();
		$user = $user->getById($_SESSION['user_id']);

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			// Process the update
			$user->username = $_POST['username'];
			// Change the password only if one is sent
			$password = $_POST['password'];
			if (!empty($password)) {
				$user->password_hash = password_hash($password, PASSWORD_DEFAULT);
			}
			$user->update();
			header('location:/User/update');
		} else {
			$this->view('User/update', $user);
		}
	}

	// Method to delete user account
	function delete()
	{
		if (!isset($_SESSION['user_id'])) {
			header('location:/User/login');
			return;
		}

		$user = new \app\models\User();
		$user = $user->getById($_SESSION['user_id']);
		$user->delete();
		header('location:/User/logout');
	}

}