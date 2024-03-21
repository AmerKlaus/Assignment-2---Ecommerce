<?php

namespace app\models;

use PDO;

class Comment extends \app\core\Model
{
    public $publication_comment_id;
    public $profile_id;
    public $publication_id;
    public $comment_text;
    public $timestamp;

    // Method to add a comment to a publication
    // Inside Comment model (Comment.php)
    public function addComment()
    {
        // SQL query to insert a new comment
        $SQL = 'INSERT INTO publication_comment (profile_id, publication_id, comment_text, timestamp) 
            VALUES (:profile_id, :publication_id, :comment_text, :timestamp)';
        $STMT = self::$_conn->prepare($SQL);
        // Execute the query with the provided parameters
        $STMT->execute([
            'profile_id' => $this->profile_id,
            'publication_id' => $this->publication_id,
            'comment_text' => $this->comment_text,
            'timestamp' => $this->timestamp,
        ]);
    }


    // Method to get comments by publication ID
    public function getCommentsByPublicationId($id)
    {
        // SQL query to retrieve comments by publication ID
        $SQL = 'SELECT * FROM publication_comment WHERE publication_id = :id ORDER BY timestamp DESC';
        $STMT = self::$_conn->prepare($SQL);
        // Execute the query with the provided parameter
        $STMT->execute(['id' => $id]);
        // Fetch all comments and return them as objects
        return $STMT->fetchAll(PDO::FETCH_OBJ);
    }


    // Method to edit a comment
    public static function editComment($publication_comment_id, $new_comment_text)
    {
        // SQL query to update a comment
        $SQL = 'UPDATE publication_comment SET comment_text = :comment_text WHERE publication_comment_id = :publication_comment_id';
        $STMT = self::$_conn->prepare($SQL);
        // Execute the query with the provided parameters
        $STMT->execute([
            'publication_comment_id' => $publication_comment_id,
            'comment_text' => $new_comment_text
        ]);
    }

    // Method to delete a comment
    public static function deleteComment($publication_comment_id)
    {
        // SQL query to delete a comment
        $SQL = 'DELETE FROM publication_comment WHERE publication_comment_id = :publication_comment_id';
        $STMT = self::$_conn->prepare($SQL);
        // Execute the query with the provided parameter
        $STMT->execute(['publication_comment_id' => $publication_comment_id]);
    }

    // Method to get a comment by its ID
    public static function getCommentById($publication_comment_id)
    {
        // SQL query to retrieve a comment by its ID
        $SQL = 'SELECT * FROM publication_comment WHERE publication_comment_id = :publication_comment_id';
        $STMT = self::$_conn->prepare($SQL);
        // Execute the query with the provided parameter and fetch the result as an object
        $STMT->execute(['publication_comment_id' => $publication_comment_id]);
        return $STMT->fetch(PDO::FETCH_OBJ);
    }

}

?>
