<?php

// todo:in archive account we need to check token!!!

header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');


//header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

class User extends Controller
{
    private mixed $db;

    public function __construct()
    {
        $this->db = $this->model('user_model');
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['email'])) {
                $email = $_POST['email'];
            } else {
                die(json_encode(['error' => 'email is empty']));
            }
            if (isset($_POST['password'])) {
                $password = $_POST['password'];
            } else {
                die(json_encode(['error' => true, 'message' => 'password is empty']));
            }
            if (strlen($email) > 255 or strlen($email) < 10) {
                die(json_encode(['error' => true, 'message' => 'Your Email should be between 10 and 255']));
            }
            if (strlen($password) > 26 or strlen($password) < 10) {
                die(json_encode(['error' => true, 'message' => 'Your password, should at least must be 10 character']));
            }
            try {
                $user = $this->db->findUser($email, $password);
            } catch (PDOException $e) {
                die(['error' => true, 'message' => 'No user under this information']);
            }
            if ($user) {
                $user = (object)[
                    'id' => $user->id,
                    'username' => $user->username,
                    'email' => $user->email
                ];
                print_r(json_encode(['error' => false, 'message' => 'welcome back dear', 'token' => $this->generateToken()
                    , 'userInfo' => $user]));
            } else {
                print_r(json_encode('false'));
            }
        }
    }


    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password']) &&
                $_POST['repeat_password']) {
                $username = $_POST['username'];
                $email = $_POST['email'];
                $password = $_POST['password'];
                $password_repeat = $_POST['repeat_password'];
                if (strlen($username) > 55 or strlen($username) < 6) {
                    die(json_encode(['error' => true, 'message' => 'Your Name should between 6 and 55 character']));
                }
                if ($this->db->Is_new_Email($email)) {
                    die(json_encode(['error' => true, 'message' => 'Your Email already taken']));
                }
                if (strlen($email) > 255 or strlen($email) < 10) {
                    die(json_encode(['error' => true, 'message' => 'Your Email should between 10 and 255']));
                }
                if (strlen($password) > 26 or strlen($password) < 10) {
                    die(json_encode(['error' => true, 'message' => 'your password is invalid']));
                }
                if ($password_repeat != $password) {
                    die(json_encode(['error' => true, 'message' => 'please confirm password ,passwords do not match']));
                }
                $password = password_hash($password, PASSWORD_DEFAULT);
                try {
                    if ($this->db->insertUser($username, $email, $password)) {
                        die(json_encode(['error' => false, 'message' => 'Your account saved successfully!']));
                    };
                } catch (PDOException $e) {
                    die(json_encode(['error' => true, 'message' => 'System crashed!']));
                }
            }

        }
    }

    public function archived_account($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
            if ($this->db->archieve_account($id)) {
                die(json_encode(['error' => false, 'message' => 'Your account deleted successfully !']));
            } else {
                die(json_encode(['error' => true, 'message' => 'Some problem happens']));
            }
        }
    }

}

