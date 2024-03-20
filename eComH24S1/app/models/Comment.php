<?php

namespace app\models;

use PDO;

class Comment extends \app\core\Model
{
    public $comment_id;
    public $profile_id;
    public $publication_id;
    public $comment_text;
    public $timestamp;

    // Add a comment to a publication
   // Inside Comment model (Comment.php)
public function addComment($profile_id, $publication_id, $comment_text)
{
    $SQL = 'INSERT INTO publication_comment (profile_id, publication_id, comment_text, timestamp) 
            VALUES (:profile_id, :publication_id, :comment_text, :timestamp)';
    $STMT = self::$_conn->prepare($SQL);
    $STMT->execute([
        'profile_id' => $profile_id,
        'publication_id' => $publication_id,
        'comment_text' => $comment_text,
        'timestamp' => date('Y-m-d H:i:s')
    ]);
}


    // Get comments by publication ID
    public function getCommentsByPublicationId($publication_id)
    {
        $SQL = 'SELECT * FROM publication_comment WHERE publication_id = :publication_id ORDER BY timestamp DESC';
        $STMT = self::$_conn->prepare($SQL);
        $STMT->execute(['publication_id' => $publication_id]);
        return $STMT->fetchAll(PDO::FETCH_OBJ);
    }
    

    // Edit a comment
    public function editComment($comment_id, $new_comment_text)
    {
        $SQL = 'UPDATE publication_comment SET comment_text = :comment_text WHERE comment_id = :comment_id';
        $STMT = self::$_conn->prepare($SQL);
        $STMT->execute([
            'comment_id' => $comment_id,
            'comment_text' => $new_comment_text
        ]);
    }

    // Delete a comment
    public function deleteComment($comment_id)
    {
        $SQL = 'DELETE FROM publication_comment WHERE comment_id = :comment_id';
        $STMT = self::$_conn->prepare($SQL);
        $STMT->execute(['comment_id' => $comment_id]);
    }
}

?>
