<?php
namespace app\models;

use PDO;

class Profile extends \app\core\Model {
    public $profile_id; // Primary Key
    public $user_id;
    public $first_name;
    public $middle_name;
    public $last_name;

    // CRUD operations

    // Create a new profile
    public function insert() {
        $SQL = 'INSERT INTO profile(user_id, first_name, middle_name, last_name) VALUE (:user_id, :first_name, :middle_name, :last_name)';
        $STMT = self::$_conn->prepare($SQL);
        $STMT->execute([
            'user_id' => $this->user_id,
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'last_name' => $this->last_name
        ]);
    }

    // Retrieve profile information for a specific user
    public function getForUser($user_id) {
        $SQL = 'SELECT * FROM profile WHERE user_id = :user_id';
        $STMT = self::$_conn->prepare($SQL);
        $STMT->execute([
            'user_id' => $user_id
        ]);
        $STMT->setFetchMode(PDO::FETCH_CLASS, 'app\models\Profile');
        return $STMT->fetch();
    }

    // Retrieve all profiles
    public function getAll() {
        $SQL = 'SELECT * FROM profile';
        $STMT = self::$_conn->prepare($SQL);
        $STMT->execute();
        $STMT->setFetchMode(PDO::FETCH_CLASS, 'app\models\Profile');
        return $STMT->fetchAll();
    }

    // Search for profiles by name
    public function getByName($name) {
        $SQL = 'SELECT * FROM profile WHERE CONCAT(first_name, \' \', middle_name, \' \', last_name) = :name';
        $STMT = self::$_conn->prepare($SQL);
        $STMT->execute([
            'name' => $name
        ]);
        $STMT->setFetchMode(PDO::FETCH_CLASS, 'app\models\Profile');
        return $STMT->fetchAll();
    }

    // Update profile information
    // Note: Cannot change the user_id, as it's a business logic choice implemented in the model
    public function update() {
        $SQL = 'UPDATE profile SET first_name=:first_name, middle_name=:middle_name, last_name=:last_name WHERE profile_id = :profile_id';
        $STMT = self::$_conn->prepare($SQL);
        $STMT->execute([
            'profile_id' => $this->profile_id,
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'last_name' => $this->last_name
        ]);
    }

    // Delete a profile
    public function delete() {
        $SQL = 'DELETE FROM profile WHERE profile_id = :profile_id';
        $STMT = self::$_conn->prepare($SQL);
        $STMT->execute([
            'profile_id' => $this->profile_id
        ]);
    }
}
?>
