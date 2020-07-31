<?php

include 'mainService.php';

class clienteService extends MainService

{
    private $entityName = "CLIENTE";
    function insert($cedula, $nombre, $fechaNacimiento)
    {

        $stmt = $this->conex->prepare("INSERT INTO cliente (cedula, nombre, fecha_nacimiento) VALUES (?, ?, ?)");
        $stmt->bind_param('sss', $cedula, $nombre, $fechaNacimiento);
        $stmt->execute();
        $stmt->close();
    }

    function findAll()
    {
        return $this->findAll1($this->entityName);
    }

    function findByPK($codCliente)
    {
        $result = $this->conex->query("SELECT * FROM cliente WHERE cod_cliente=" . $codCliente);
        if ($result->num_rows > 0) {
            return  $result->fetch_assoc();
        } else {
            return NULL;
        }
    }

    function update($cedula, $nombre, $fechaNacimiento, $codCliente)
    {
        $stmt = $this->conex->prepare("UPDATE cliente SET cedula=?, nombre=?, fecha_nacimiento=? WHERE cod_cliente=?");
        $stmt->bind_param('sssi', $cedula, $nombre, $fechaNacimiento, $codCliente);
        $stmt->execute();
        $stmt->close();
    }

    function delete($codCliente)
    {

        $stmt = $this->conex->prepare("DELETE FROM cliente WHERE cod_cliente=?");
        $stmt->bind_param('i', $codCliente);
        $stmt->execute();
        $stmt->close();
    }
}