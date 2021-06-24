<?php
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');


class Auth extends Controller
{
    public function verify()
    {
        if ($this->gettoken()) {
            if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                try {
                    $this->verification($this->gettoken());
                } catch
                (\Throwable $th) {
                    die(json_encode(['error' => true]));
                }
                die(json_encode(['error' => false]));
            } else {
                die(json_encode(['error' => true]));
            }
        } else {
            die(json_encode(['error' => true]));
        }
    }
}