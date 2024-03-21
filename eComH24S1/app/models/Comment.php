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

    // Add a comment to a publication
    // Inside Comment model (Comment.php)
    public function addComment()
    {
        $SQL = 'INSERT INTO publication_comment (profile_id, publication_id, comment_text, timestamp) 
            VALUES (:profile_id, :publication_id, :comment_text, :timestamp)';
        $STMT = self::$_conn->prepare($SQL);
        $STMT->execute([
            'profile_id' => $this->profile_id,
            'publication_id' => $this->publication_id,
            'comment_text' => $this->comment_text,
            'timestamp' => $this->timestamp,
        ]);
    }


    // Get comments by publication ID
    public function getCommentsByPublicationId($id)
    {
        $SQL = 'SELECT * FROM publication_comment WHERE publication_id = :id ORDER BY timestamp DESC';
        $STMT = self::$_conn->prepare($SQL);
        $STMT->execute(['id' => $id]);
        return $STMT->fetchAll(PDO::FETCH_OBJ);
    }


    // Edit a comment
    public static function editComment($publication_comment_id, $new_comment_text)
    {
        $SQL = 'UPDATE publication_comment SET comment_text = :comment_text WHERE publication_comment_id = :publication_comment_id';
        $STMT = self::$_conn->prepare($SQL);
        $STMT->execute([
            'publication_comment_id' => $publication_comment_id,
            'comment_text' => $new_comment_text
        ]);
    }

    // Delete a comment
    public static function deleteComment($publication_comment_id)
    {
        $SQL = 'DELETE FROM publication_comment WHERE publication_comment_id = :publication_comment_id';
        $STMT = self::$_conn->prepare($SQL);
        $STMT->execute(['publication_comment_id' => $publication_comment_id]);
    }

    // Get a comment by its ID
    public static function getCommentById($publication_comment_id)
    {
        $SQL = 'SELECT * FROM publication_comment WHERE publication_comment_id = :publication_comment_id';
        $STMT = self::$_conn->prepare($SQL);
        $STMT->execute(['publication_comment_id' => $publication_comment_id]);
        return $STMT->fetch(PDO::FETCH_OBJ);
    }

}

?>