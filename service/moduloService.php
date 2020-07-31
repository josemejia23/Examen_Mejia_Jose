<?php

include 'mainService.php';

class ModuloService extends MainService

{
    private $entityName = "SEG_MODULO";
    function insert($codModulo,$nombre, $estado)
    {

        $stmt = $this->conex->prepare("INSERT INTO SEG_MODULO (COD_MODULO, NOMBRE, ESTADO) VALUES (?,?, ?)");
        $stmt->bind_param('sss', $codModulo,$nombre, $estado);
        $stmt->execute();
        $stmt->close();
    }

    function findAll()
    {
        return $this->findAll1($this->entityName);
    }

    function findByPK($codModulo)
    {
        $result = $this->conex->query("SELECT * FROM SEG_MODULO WHERE COD_MODULO=" . $codModulo);
        if ($result->num_rows > 0) {
            return  $result->fetch_assoc();
        } else {
            return NULL;
        }
    }

    function update( $nombre, $estado, $codModulo)
    {
        $stmt = $this->conex->prepare("UPDATE SEG_MODULO SET NOMBRE=?, ESTADO=? WHERE COD_MODULO=?");
        $stmt->bind_param('sss', $nombre, $estado,$codModulo);
        $stmt->execute();
        $stmt->close();
    }

    function delete($codModulo)
    {

        $stmt = $this->conex->prepare("DELETE FROM SEG_MODULO WHERE COD_MODULO=?");
        $stmt->bind_param('s', $codModulo);
        $stmt->execute();
        $stmt->close();
    }
}