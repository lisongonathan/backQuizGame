<?php
class Connexion
{
    private static $instance;
    
    private $host = 'mysql-elmes-quizz.alwaysdata.net';
    private $dbname = 'elmes-quizz_bdd';
    private $user = '355059';
    private $password = 'mot2p@sse';

    protected $conn;

    public function __construct(){
        try {
            // Initialisation de la connexion à la base de données
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->user, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        } catch (PDOException $e) {
            // Gestion des erreurs
            die("Erreur de connexion à la base de données : " . $e->getMessage());
        }
    }

    // Empêche le clonage de l'instance
    public function __clone()
    {
        // Empêche le clonage de l'instance en générant une exception
        throw new Exception("Le clonage de cette instance est interdit.");
    }

    // Empêche la désérialisation de l'instance
    public function __wakeup()
    {
        // Empêche la désérialisation de l'instance en générant une exception
        throw new Exception("La désérialisation de cette instance est interdite.");
    }
}
