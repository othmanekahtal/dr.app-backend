<?php
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

class Api extends Controller
{
    public $db;

    /**
     * @var mixed
     */

    public function __construct()
    {
        $this->db = $this->model('api_services');
    }


    public function record($params)
    {
        if (isset($params)) {
            $idUser = $params[0];
            $id = $params[1];
            if (!$id and !$idUser) {
                die(json_encode(['error' => true, 'message' => 'not params']));
            }
            if ($this->gettoken()) {
                try {
                    $this->verification($this->gettoken());
                    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                        if ($this->db->has_user_record($idUser, $id)) {
                            $record = $this->db->Read_Record($id);
                            die(json_encode(['error' => false, 'record' => $record[0]]));
                        } else {
                            die(json_encode(['error' => true, 'message' => 'not data']));
                        }
                    }
                } catch (\Throwable $th) {
                    die(json_encode(['error' => true, 'message' => "you are not authorized" . $th]));
                }

            } else {
                die(json_encode(['error' => true, 'message' => "you need authorization"]));
            }
        } else {
            die(json_encode(['error' => true, 'message' => "you are not send require params"]));
        }
    }

    public function records($id_user)
    {
        if (isset($id_user)) {
            $idUser = $id_user[0];

            if (!$idUser) {
                die(json_encode(['error' => true, 'message' => 'not params']));
            }

            if ($this->gettoken()) {
                try {
                    $this->verification($this->gettoken());
                    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                        $records = $this->db->all_user_record($idUser);
                        die(json_encode(['error' => false, 'records' => $records]));
                    }
                } catch (\Throwable $th) {
                    die(json_encode(['error' => true, 'message' => "you are not authorized" . $th]));
                }

            } else {
                die(json_encode(['error' => true, 'message' => "you need authorization"]));
            }
        } else
            die(json_encode(['error' => true, 'message' => "you are not send require params"]));
    }

    public function status($params)
    {
        if (isset($params)) {
            $idUser = $params[0];
            $id = $params[1];
            if (!$id and !$idUser) {
                die(json_encode(['error' => true, 'message' => 'not params']));
            }
            if ($this->gettoken()) {
                try {
                    $this->verification($this->gettoken());
                    if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
                        if ($this->db->has_user_record($idUser, $id)) {
                            if ($this->db->change_status_record($id)) {
                                die(json_encode(['error' => false, 'message' => 'success']));
                            } else {
                                die(json_encode(['error' => true, 'message' => 'can\'t delete record']));
                            }
                        } else {
                            die(json_encode(['error' => true, 'message' => 'not data']));
                        }
                    }
                } catch (\Throwable $th) {
                    die(json_encode(['error' => true, 'message' => "you are not authorized" . $th]));
                }

            } else {
                die(json_encode(['error' => true, 'message' => "you need authorization"]));
            }
        } else {
            die(json_encode(['error' => true, 'message' => "you are not send require params"]));
        }
    }

    public function update()
    {
        if ($this->gettoken()) {
            try {
                $this->verification($this->gettoken());
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    if (isset($_POST['id']) && isset($_POST['user_id']) && isset($_POST['date']) && isset
                        ($_POST['time'])) {
                        $id = $_POST['id'];
                        $time = $_POST['time'];
                        $date = $_POST['date'];
                        $user_id = $_POST['user_id'];
                        if ($this->db->has_user_record($user_id, $id)) {
                            if ($this->db->update($user_id, $time, $date, $id)) {
                                die(json_encode(['error' => false, 'message' => 'successfully']));
                            } else {
                                die(json_encode(['error' => true, 'message' => 'failed']));
                            }
                        } else {
                            die(json_encode(['error' => true, 'message' => 'not data']));
                        }
                    } else {
                        die(json_encode(['error' => true, 'message' => 'require data not catch it']));
                    }

                }
            } catch (\Throwable $th) {
                die(json_encode(['error' => true, 'message' => "you are not authorized" . $th]));
            }
        }
    }

    public function add()
    {
        if ($this->gettoken()) {
            try {
                $this->verification($this->gettoken());
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    if (isset($_POST['user_id']) && isset($_POST['date']) && isset
                        ($_POST['time'])) {
                        $time = $_POST['time'];
                        $date = $_POST['date'];
                        $user_id = $_POST['user_id'];
                        if ($this->db->add($user_id, $time, $date)) {
                            die(json_encode(['error' => false, 'message' => 'successfully']));
                        } else {
                            die(json_encode(['error' => true, 'message' => 'failed']));
                        }
                    } else {
                        die(json_encode(['error' => true, 'message' => 'require data not catch it']));
                    }

                }
            } catch (\Throwable $th) {
                die(json_encode(['error' => true, 'message' => "you are not authorized" . $th]));
            }
        }
    }

    public function available()
    {
        if ($this->gettoken()) {
            try {
                $this->verification($this->gettoken());
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $date = $_POST['date'];
                    die(json_encode(['error' => false, 'not' => $this->db->available($date)]));
                }
            } catch (\Throwable $th) {
                die(json_encode(['error' => true, 'message' => "you are not authorized" . $th]));
            }
        } else {
            die(json_encode(['error' => true, 'message' => "you need authorization"]));
        }

    }
}