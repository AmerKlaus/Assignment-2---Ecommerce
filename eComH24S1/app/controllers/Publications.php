<?php
namespace app\controllers;

use app\core\Controller;

class Publications extends Controller {

    public function index() {
       
      $publicationModel = new \app\models\Publications();
        
           $publications = $publicationModel->getAllPublications();

        // Load the view with publications data
        $this->view('Publications/publications', ['publications' => $publications]);
    }

    public function create() {
        // Load the view for creating a new publication
        $this->view('Publications/create');
    }

   public function store() {

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        

      
        $publication = new \app\models\Publications(); 

        // Set the values from the form
        $publication->profile_id = $_SESSION['profile_id']; 
        $publication->publication_title = $_POST['title'];
        $publication->publication_text = $_POST['content'];
        $publication->timestamp = date('Y-m-d H:i:s');
        $publication->publication_status = 'public'; 

       
        $publication->insert(); 

        
        header('Location: /Publications/index'); 
        exit();
    }
}

}
?>
