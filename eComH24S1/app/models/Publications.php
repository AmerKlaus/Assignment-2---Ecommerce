<?php

namespace app\models;

use PDO;

class Publications extends \app\core\Model
{
    public $publication_id;
    public $profile_id;
    public $publication_title;
    public $publication_text;
    public $timestamp;
    public $publication_status;

    // Create
    public function insert()
    {
        $SQL = 'INSERT INTO publication (profile_id, publication_title, publication_text, timestamp, publication_status) 
                VALUES (:profile_id, :publication_title, :publication_text, :timestamp, :publication_status)';

        $STMT = self::$_conn->prepare($SQL);
        $data = [
            'profile_id' => $this->profile_id,
            'publication_title' => $this->publication_title,
            'publication_text' => $this->publication_text,
            'timestamp' => date('Y-m-d H:i:s'),
            'publication_status' => $this->publication_status,
        ];

        $STMT->execute($data);
    }

    public function getAllPublications()
    {
        $SQL = 'SELECT * FROM publication WHERE publication_status = :publication_status';
        $STMT = self::$_conn->prepare($SQL);
        $STMT->execute(['publication_status' => 'public']); // Corrected parameter value
        $STMT->setFetchMode(PDO::FETCH_CLASS, 'app\\models\\Publications');
        return $STMT->fetchAll();
    }

    // Publications.php model

    // Inside your Publications model (Publications.php)
    public function updatePublication($id, $title, $content, $status)
    {
        // Check if title and content are not null before executing the query
        if ($title !== null && $content !== null && $status !== null) {
            $SQL = 'UPDATE publication SET publication_title = :title, publication_text = :content, publication_status = :status WHERE publication_id = :id';
            $STMT = self::$_conn->prepare($SQL);
            $STMT->execute(['id' => $id, 'title' => $title, 'content' => $content, 'status' => $status]);
        } else {
            // Handle the case when title or content is null
            // For example, redirect to an error page or display a message
            exit ("Title or content cannot be null.");
        }
    }

    // Inside your Publications model (Publications.php)
    public function getPublicationById($id)
    {
        $SQL = 'SELECT * FROM publication WHERE publication_id = :id';
        $STMT = self::$_conn->prepare($SQL);
        $STMT->execute(['id' => $id]);
        return $STMT->fetch(PDO::FETCH_ASSOC);
    }


    // Inside your Publications model (Publications.php)
    public function getPublicationByIdAndProfile($id, $profile_id)
    {
        $SQL = 'SELECT * FROM publication WHERE publication_id = :id AND profile_id = :profile_id';
        $STMT = self::$_conn->prepare($SQL);
        $STMT->execute(['id' => $id, 'profile_id' => $profile_id]);
        $STMT->setFetchMode(PDO::FETCH_CLASS, 'app\\models\\Publications');
        return $STMT->fetch(); // Assuming you expect only one publication
    }

    // Inside your Publications model (Publications.php)
    public function deletePublication($id)
    {
        $SQL = 'DELETE FROM publication WHERE publication_id = :id';
        $STMT = self::$_conn->prepare($SQL);
        $STMT->execute(['id' => $id]);
    }

    public function getAllPublicationTitles()
    {
        $SQL = 'SELECT publication_id, publication_title FROM publication ORDER BY timestamp DESC';
        $STMT = self::$_conn->prepare($SQL);
        $STMT->execute();
        return $STMT->fetchAll(PDO::FETCH_ASSOC);
    }
    // Inside your Publications model (Publications.php)
public function getPublicationsByProfileId($profileId)
{
    $SQL = 'SELECT * FROM publication WHERE profile_id = :profile_id';
    $STMT = self::$_conn->prepare($SQL);
    $STMT->execute(['profile_id' => $profileId]);
    return $STMT->fetchAll(PDO::FETCH_CLASS, 'app\\models\\Publications');
}

public function addComment($publicationId)
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get the current user's profile ID
        $profileModel = new \app\models\Profile();
        $profile = $profileModel->getForUser($_SESSION['user_id']);
        $profileId = $profile->profile_id;

        // Insert the comment into the database
        $commentModel = new \app\models\CommentModel();
        $commentModel->addComment($profileId, $publicationId, $_POST['comment_text']);

        // Redirect back to the publication view page
        header('Location: /Publications/index/' . $publicationId);
        exit();
    }
}


}
