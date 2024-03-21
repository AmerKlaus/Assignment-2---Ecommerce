<?php
namespace app\controllers;

// Applying the Login condition to the whole class
#[\app\filters\Login]
class Profile extends \app\core\Controller
{

	#[\app\filters\HasProfile]
	public function index()
	{
		// Retrieve profile information for the logged-in user
		$profileModel = new \app\models\Profile();
		$profile = $profileModel->getForUser($_SESSION['user_id']);

		// Retrieve publications associated with the user's profile ID
		$publicationModel = new \app\models\Publications();
		$publications = $publicationModel->getPublicationsByProfileId($profile->profile_id);

		// Pass profile and publications data to the view
		$this->view('Profile/index', ['profile' => $profile, 'publications' => $publications]);
	}

	public function create()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {//data is submitted through method POST
			// Make a new profile object
			$profile = new \app\models\Profile();
			// Populate it
			$profile->user_id = $_SESSION['user_id'];
			$profile->first_name = $_POST['first_name'];
			$profile->middle_name = $_POST['middle_name'];
			$profile->last_name = $_POST['last_name'];
			// Insert it
			$profile->insert();
			// Redirect
			header('location:/Profile/index');
		} else {
			$this->view('Profile/create');
		}
	}

	public function modify()
	{
		$profile = new \app\models\Profile();
		$profile = $profile->getForUser($_SESSION['user_id']);

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {//data is submitted through method POST
			// Make a new profile object
			// Populate it
			$profile->first_name = $_POST['first_name'];
			$profile->middle_name = $_POST['middle_name'];
			$profile->last_name = $_POST['last_name'];
			// Update it
			$profile->update();
			// Redirect
			header('location:/Profile/index');
		} else {
			$this->view('Profile/modify', $profile);
		}
	}

	public function delete()
	{
		// Present the user with a form to confirm the deletion that is requested and delete if the form is submitted
/*		// Make sure that the user is logged in
		if(!isset($_SESSION['user_id'])){
			header('location:/User/login');
			return;
		}
*/
		$profile = new \app\models\Profile();
		$profile = $profile->getForUser($_SESSION['user_id']);

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$profile->delete();
			header('location:/Profile/index');
		} else {
			$this->view('Profile/delete', $profile);
		}
	}
}
