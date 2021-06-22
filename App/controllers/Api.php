<?php


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
                        if ($records) {
                            die(json_encode(['error' => false, 'record' => $records[0]]));
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
        } else
            die(json_encode(['error' => true, 'message' => "you are not send require params"]));
    }


    public function changeStatus($params)
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
                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                        if ($this->db->has_user_record($idUser, $id)) {
                            die(json_encode(['error' => false, 'message' => 'success']));
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

    public function updateRecord($params)
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

    public function addRecord($params)
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

}