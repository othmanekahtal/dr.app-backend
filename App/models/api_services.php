<?php

class api_services
{
    public $database;

    /**
     * api_services constructor.
     */
    public function __construct()
    {
        $this->database = new Database();
    }

    public function has_user_record($id_user, $id_record)
    {
        if ($this->verify_user($id_user)) {
            $sql = /** @lang text */
                'select * from appointment where appointment.user = :id_user and appointment.id = :id_record';
            $this->database->query($sql);
            $this->database->bind(':id_user', $id_user, PDO::PARAM_INT);
            $this->database->bind(':id_record', $id_record, PDO::PARAM_INT);
            $this->database->execute();
            if ($this->database->rowCount()) {
                return true;
            } else {
                return false;
            }
        } else {
            die(json_encode(['error' => true, 'message' => 'Your account is archived']));
        }
    }

    public function verify_user($id): int
    {
        $sql = /** @lang sql */
            'select * from users where id=:user and access = 1';
        $this->database->query($sql);
        $this->database->bind(':user', $id);
        return count($this->database->fetch_all_as_arr());
    }

    public function all_user_record($idUser)
    {
        $sql = /** @lang text */
            'select * from appointment where appointment.user = :id_user';
        $this->database->query($sql);
        $this->database->bind(':id_user', $idUser, PDO::PARAM_INT);
        return $this->database->fetch_all_as_obj();
    }

    public function Read_Record($id)
    {
        $sql = /** @lang text */
            'select * from appointment where id=:id';
        $this->database->query($sql);
        $this->database->bind(':id', (int)$id, PDO::PARAM_INT);
        return $this->database->fetch_all_as_obj();
    }

    public function change_status_record($id)
    {
        $sql = /** @lang text */
            'update appointment set status = \'cancelled\' where id=:id';
        $this->database->query($sql);
        $this->database->bind(':id', $id, PDO::PARAM_INT);
        return $this->database->execute();
    }

    public function add($user, $time, $date)
    {
        $sql = /** @lang text */
            'insert into appointment (date,user,time) values (:date,:user,:time)';
        $this->database->query($sql);
        $this->database->bind(':date', $date, PDO::PARAM_STR);
        $this->database->bind(':user', $user, PDO::PARAM_INT);
        $this->database->bind(':time', $time, PDO::PARAM_STR);
        return $this->database->execute();
    }

    public function update($user, $time, $date, $id)
    {
        $sql = /** @lang text */
            'update appointment set date=:date,user=:user,time=:time where id = :id';
        $this->database->query($sql);
        $this->database->bind(':date', $date, PDO::PARAM_STR);
        $this->database->bind(':user', $user, PDO::PARAM_INT);
        $this->database->bind(':id', $id, PDO::PARAM_INT);
        $this->database->bind(':time', $time, PDO::PARAM_STR);
        return $this->database->execute();
    }

    public function available($date)
    {
        $sql = /** @lang text */
            'select time from appointment where date = :date and status = \'pending\'';
        $this->database->query($sql);
        $this->database->bind(':date', $date);
        return $this->database->fetch_all_as_obj();
    }
}