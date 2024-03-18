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
       $data =[
            'profile_id' => $this->profile_id,
            'publication_title' => $this->publication_title,
            'publication_text' => $this->publication_text,
            'timestamp' => date('Y-m-d H:i:s'), 
            'publication_status' => 'public'];

        $STMT->execute($data);
    }

   public function getAllPublications()
{
    $SQL = 'SELECT * FROM publication';
    $STMT = self::$_conn->prepare($SQL);
    $STMT->execute();
    $STMT->setFetchMode(PDO::FETCH_CLASS, 'app\\models\\Publications'); 
    return $STMT->fetchAll();
}

    
}
