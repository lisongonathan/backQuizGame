<?php
require_once __DIR__ . '/../Core/Connexion.php';

class Model extends Connexion
{
    private $sql;
    private $params;

    public function __construct() {
        parent::__construct();
    }

    public function setParams(array $params) : void {
        $this->params = $params;
    }

    public function setRequest(string $sql) : void {
        $this->sql = $sql;
    }

    public function setItem() : bool {
        $stmt = $this->conn->prepare($this->sql);

        return $stmt->execute($this->params);
    }

    public function getFind() : array {
        $stmt = $this->conn->query($this->sql);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getFindByParams() : array {
        $stmt = $this->conn->prepare($this->sql);
        $stmt->execute($this->params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getFindBySearch(string $keyword) : array {
        $stmt = $this->conn->prepare($this->sql);
        $stmt->execute(['%' . $keyword . '%']);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
