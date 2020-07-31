<?php
include 'mainService.php';
class LoginService extends MainService
{
    function login($username, $password)
    {
        $result = $this->conex->query("SELECT * FROM USUARIO WHERE USERNAME='$username'");
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if ($row['PASSWORD'] == $password) {
                return $row;
            }
        } else {
            return NULL;
        }
    }
}