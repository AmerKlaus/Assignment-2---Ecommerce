<?php
namespace app\controllers;

use app\core\Controller;

class Publications extends Controller
{

    // Inside Publications controller (Publications.php)
    public function index()
    {
        $publicationModel = new \app\models\Publications();

        // Check if a search query is submitted
        if (isset ($_GET['q']) && !empty ($_GET['q'])) {
            // Retrieve publications based on search query
            $publicationsData = $publicationModel->searchPublications($_GET['q']);
        } else {
            // Retrieve all publications
            $publicationsData = $publicationModel->getAllPublicationTitles();
        }

        // Convert object to array
        $publications = [];
        foreach ($publicationsData as $publication) {
            $publications[] = [
                "publication_id" => $publication['publication_id'],
                'publication_title' => $publication['publication_title'],
                // Add other fields as needed
            ];
        }

        // Pass the publications data to the view
        $this->view('Publications/publications', ['publications' => $publications]);
    }


    #[\app\filters\HasProfile]
    public function create()
    {
        // Load the view for creating a new publication
        $this->view('Publications/create');
    }

    #[\app\filters\HasProfile]
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

    // Inside your Publications controller (Publications.php)
    public function content($id)
    {
        $publicationModel = new \app\models\Publications();
        $publication = $publicationModel->getPublicationById($id);

        if (!$publication) {
            // Handle case when publication is not found
            // Example: header('Location: /Error');
            exit ("Publication not found.");
        }

        $commentModel = new \app\models\Comment();
        $comments = $commentModel->getCommentsByPublicationId($id);

        if (!$comments) {
            echo "no comments found.";
        }

        // Convert object to array
        $publicationArray[] = [
            'publication_id' => $publication['publication_id'],
            'publication_title' => $publication['publication_title'],
            'publication_text' => $publication['publication_text'],
            'timestamp' => $publication['timestamp'],
            // Add other fields as needed
        ];

        $commentsArray = [];
        foreach ($comments as $comment) {
            $commentsArray[] = [
                'publication_comment_id' => $comment->publication_comment_id,
                'profile_id' => $comment->profile_id,
                'publication_id' => $comment->publication_id,
                'timestamp' => $comment->timestamp,
                'comment_text' => $comment->comment_text,
                // Add other fields as needed
            ];
        }

        // Load the view with publication data
        $this->view('Publications/view', ['publications' => $publicationArray, 'comments' => $commentsArray]);
    }

    #[\app\filters\HasProfile]
    public function edit($id)
    {
        // Get the publication from the database based on $publication_id
        $user_id = $_SESSION['user_id'];

        // Get the profile ID for the current user using the user ID
        $profileModel = new \app\models\Profile();
        $profile = $profileModel->getForUser($user_id);

        if ($profile) {
            $profile_id = $profile->profile_id;

            // Get the publication from the database based on $id and $profile_id
            $publicationModel = new \app\models\Publications();
            $publication = $publicationModel->getPublicationByIdAndProfile($id, $profile_id);

            // Check if the publication exists and belongs to the current user
            if (!$publication) {
                // Redirect to an error page or display an error message
                // Example: header('Location: /Error');
                exit ("Publication not found or you don't have permission to edit it.");
            }

            // Pass the publication data to the view for editing
            $this->view('Publications/edit', ['publication_id' => $id, 'publication' => $publication]);
        } else {
            // Handle the case when the profile is not found
            // Example: header('Location: /Error'); exit();
            exit ("Profile not found for the logged-in user.");
        }
    }

    #[\app\filters\HasProfile]
    public function update($id)
    {
        // Get the updated data from the form
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = isset ($_POST['title']) ? $_POST['title'] : null;
            $content = isset ($_POST['content']) ? $_POST['content'] : null;
            $status = isset ($_POST['status']) ? $_POST['status'] : null;

            // Call the updatePublication method with the retrieved values
            $publicationModel = new \app\models\Publications();
            $publicationModel->updatePublication($id, $title, $content, $status);
            header('Location: /Publications/index');
            exit();
        } else {
            // Handle the case when the form is not submitted
            // For example, redirect to an error page or display a message
            exit ("Form not submitted.");
        }
    }

    // Inside your Publications controller (Publications.php)
    #[\app\filters\HasProfile]
    public function delete($id)
    {
        // Check if the publication exists and belongs to the current user
        $user_id = $_SESSION['user_id'];

        // Get the profile ID for the current user using the user ID
        $profileModel = new \app\models\Profile();
        $profile = $profileModel->getForUser($user_id);

        if ($profile) {
            $profile_id = $profile->profile_id;

            // Get the publication from the database based on $id and $profile_id
            $publicationModel = new \app\models\Publications();
            $publication = $publicationModel->getPublicationByIdAndProfile($id, $profile_id);

            if ($publication) {
                // Delete the publication
                $publicationModel->deletePublication($id);

                // Redirect back to Publications/index after deletion
                header('Location: /Publications/index');
                exit();
            } else {
                // Handle the case when the publication is not found or doesn't belong to the user
                exit ("Publication not found or you don't have permission to delete it.");
            }
        } else {
            // Handle the case when the profile is not found
            exit ("Profile not found for the logged-in user.");
        }
    }

    // Inside Publications controller (Publications.php)public function view($id)

    #[\app\filters\HasProfile]
    // Method to handle adding a comment to a publication
public function addComment($id)
{
    // Check if the request method is POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // Instantiate a new Comment model
        $comment = new \app\models\Comment();

        // Get the profile associated with the current user
        $profile = new \app\models\Profile();
        $profile = $profile->getForUser($_SESSION['user_id']);

        // Set the values for the comment
        $comment->profile_id = $profile->profile_id;
        $comment->publication_id = $id;
        $comment->timestamp = date('Y-m-d H:i:s');
        $comment->comment_text = $_POST['comment_text'];

        // Add the comment to the database
        $comment->addComment();

        // Redirect to the publication content page
        header("Location: /Publications/content/$id");
        exit();
    }
}

    #[\app\filters\HasProfile]
   // Method to handle editing a comment
public function editComment($id)
{
    // Check if the request method is POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get the new comment text from the form
        $new_comment_text = isset ($_POST['new_comment_text']) ? $_POST['new_comment_text'] : null;

        // Check if the new comment text is not empty
        if ($new_comment_text) {
            // Instantiate a new Comment model
            $commentModel = new \app\models\Comment();
            $comment = $commentModel->getCommentById($id);

            // Get the profile associated with the current user
            $user_id = $_SESSION['user_id'];
            $profileModel = new \app\models\Profile();
            $profile = $profileModel->getForUser($user_id);

            // Check if the comment exists and if the user has permission to edit it
            if (!$comment || $comment->profile_id != $profile->profile_id) {
                exit ("Comment not found or you don't have permission to edit it.");
            }

            // Update the comment with the new text
            $commentModel->editComment($id, $new_comment_text);

            // Redirect to the publication content page
            header("Location: /Publications/content/{$comment->publication_id}");
            exit();
        } else {
            exit ("Comment text cannot be empty.");
        }
    }
}

    #[\app\filters\HasProfile]
    // Method to handle deleting a comment
public function deleteComment($id)
{
    // Instantiate a new Comment model
    $commentModel = new \app\models\Comment();
    $comment = $commentModel->getCommentById($id);

    // Get the profile associated with the current user
    $user_id = $_SESSION['user_id'];
    $profileModel = new \app\models\Profile();
    $profile = $profileModel->getForUser($user_id);

    // Check if the comment exists and if the user has permission to delete it
    if (!$comment || $comment->profile_id != $profile->profile_id) {
        exit ("Comment not found or you don't have permission to delete it.");
    }

    // Delete the comment from the database
    $commentModel->deleteComment($id);

    // Redirect to the publication content page
    header("Location: /Publications/content/{$comment->publication_id}");
}

?>