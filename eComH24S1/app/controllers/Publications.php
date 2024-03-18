<?php
namespace app\controllers;

use app\core\Controller;

class Publications extends Controller
{

    public function index()
    {
        $publicationModel = new \app\models\Publications();
        $publicationsData = $publicationModel->getAllPublications();

        // Convert object to array
        $publications = [];
        foreach ($publicationsData as $publication) {
            $publications[] = [
                'publication_title' => $publication->publication_title,
                'publication_text' => $publication->publication_text,
                'timestamp' => $publication->timestamp,
                // Add other fields as needed
            ];
        }

        // Load the view with publications data
        $this->view('Publications/publications', ['publications' => $publications]);
    }

    #[\app\filters\HasProfile]
    public function create()
    {
        // Load the view for creating a new publication
        $this->view('Publications/create');
    }

    public function store()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {



            $publication = new \app\models\Publications();

            // Set the values from the form
            $profile = new \app\models\Profile();
            $profile = $profile->getForUser($_SESSION['user_id']);

            $publication->profile_id = $profile->profile_id;
            $publication->publication_title = $_POST['title'];
            $publication->publication_text = $_POST['content'];
            $publication->timestamp = date('Y-m-d H:i:s');
            $publication->publication_status = $_POST['status'];


            $publication->insert();


            header('Location: /Publications/index');
            exit();
        }
    }

}
?>