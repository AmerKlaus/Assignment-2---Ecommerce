<?php
namespace app\models;

use PDO;

class User extends \app\core\Model {
    public $user_id;
    public $username;
    public $password_hash;

    // CRUD operations

    // Create a new user
    public function insert() {
        $SQL = 'INSERT INTO user (username, password_hash) VALUES (:username, :password_hash)';
        $STMT = self::$_conn->prepare($SQL);
        $data = [
            'username' => $this->username,
            'password_hash' => $this->password_hash
        ];
        $STMT->execute($data);
    }

    // Retrieve a user by username
    public function get($username) {
        $SQL = 'SELECT * FROM user WHERE username = :username';
        $STMT = self::$_conn->prepare($SQL);
        $STMT->execute(['username' => $username]);
        $STMT->setFetchMode(PDO::FETCH_CLASS, 'app\models\User');
        return $STMT->fetch();
    }

    // Retrieve a user by user_id
    public function getById($user_id) {
        $SQL = 'SELECT * FROM user WHERE user_id = :user_id';
        $STMT = self::$_conn->prepare($SQL);
        $STMT->execute(['user_id' => $user_id]);
        $STMT->setFetchMode(PDO::FETCH_CLASS, 'app\models\User');
        return $STMT->fetch();
    }

    // Update user information
    public function update() {
        $SQL = 'UPDATE user SET username = :username, password_hash = :password_hash WHERE user_id = :user_id';
        $STMT = self::$_conn->prepare($SQL);
        $STMT->execute((array)$this);
    }

    // Delete a user (deactivate account)
    public function delete() {
        $SQL = 'UPDATE user SET active = :active WHERE user_id = :user_id';
        $STMT = self::$_conn->prepare($SQL);
        $data = ['user_id' => $this->user_id, 'active' => 0];
        $STMT->execute($data);
    }
}
?>
