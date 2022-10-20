<?php

class Conexion {

    private string $host = "45.151.120.12";
    private string $user = "u804519145_enviexpress";
    private string $password = "2vW@sQTJi5>C";
    private string $db ="u804519145_enviexpress";
    private PDO $conect;

    public function __construct() {
        $connectionString = "mysql:host=".$this->host.";dbname=".$this->db.";charset=utf8";

        try{
            $this->conect = new PDO ($connectionString, $this->user, $this->password, [
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'",
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                PDO::ATTR_TIMEOUT => 5
            ]);
            // $this->conect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $e){
            // $this->conect ='Error de conexión';
            die($e->getMessage());
        }
    }

    public function ejecutar($sql) {
        $this->conect->exec($sql);
        return $this->conect->lastInsertId();
    }

    public function consultar($sql) {
        $stmt = $this->conect->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function buscar($sql) {
        $stmt = $this->conect->prepare($sql);
        $stmt->execute();
        return $stmt->fetch();
    }

}
?>