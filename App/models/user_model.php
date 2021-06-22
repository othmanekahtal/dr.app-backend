<?php

class user_model
{
    public $db;

    /**
     * api_services constructor.
     */
    public function __construct()
    {
        $this->db = new Database();

    }


    public function findUser($email, $password)
    {
        $sql = /** @lang text */
            'SELECT * FROM users where email=:email and access = 1';
        $this->db->query($sql);
        $this->db->bind(":email", $email, PDO::PARAM_STR);
        $row = $this->db->fetch_as_obj();
        if ($row) {
            $hashed_password = $row->password;
            if (password_verify($password, $hashed_password)) {
                return $row;
            } else {
                die(json_encode(['error' => true, 'message' => 'password is wrong']));
            }
        } else {
            if ($this->Is_new_Email($email)) {
                die(json_encode(['error' => true, 'message' => 'your account deleted!']));
            } else {
                die(json_encode(['error' => true, 'message' => 'email is not found']));

            }
        }
    }

    public function insertUser($username, $email, $password)
    {
        $this->db->query(/** @lang text */ 'insert into users (username,email,password) values (:username,:email,:password)');
        // bind placeholders :
        $this->db->bind(":username", $username, PDO::PARAM_STR);
        $this->db->bind(":email", $email, PDO::PARAM_STR);
        $this->db->bind(":password", $password, PDO::PARAM_STR);
        // verify query execution:
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function Is_new_Email($email)
    {

        $this->db->query(/** @lang text */ 'SELECT * FROM users where email=:email');
        $this->db->bind(":email", $email);
        $this->db->execute();
        if ($this->db->rowCount()) {
            return true;
        } else {
            return false;
        }
    }

//    public function GetCol($col, $email)
//    {
//        $this->db->query(/** @lang text */ 'SELECT ' . $col . ' FROM users where email=:col');
//        $this->db->bind(":col", $email);
//        return $this->db->fetch_as_obj();
//    }

    public function archieve_account($id)
    {
        $this->db->query(/** @lang text */ 'update users set access = 0 where id = :id');
        $this->db->bind(":id", $id, PDO::PARAM_INT);
        return $this->db->execute();
    }


}