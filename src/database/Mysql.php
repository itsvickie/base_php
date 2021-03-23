<?php

namespace Base_php\Database;

class Mysql
{
    function __destruct()
    {
        $this->disconnect();
    }

    public function connect()
    {
        return mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
    }

    private function disconnect()
    {
        mysqli_close($this->connect());
    }
}