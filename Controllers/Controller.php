<?php
// DefaultController.php

class Controller {

    public function methodNotFound() {
        $this->render(["error" => "Méthode non trouvée."]);
    }

    public function controllerNotFound() {
        $this->render(["error" => "Contrôleur non trouvé."]);
    }

    public function render($data) {
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function vue($vue, $data = array()) {
        require_once '/Views/' . $vue .'.php';
    }

    public function getRequestPost() {
        // Récupère les données JSON envoyées dans la requête POST
        $json_data = file_get_contents('php://input');
        $data = json_decode($json_data, true);
        
        // Récupération des paramètres de l'URL
        $controllerName = isset($_GET['controller']) ? ucfirst($_GET['controller']) . 'Controller' : 'Controller';
        $methodName = isset($_GET['method']) ? $_GET['method'] : 'controllerNotFound';
        $params = !empty($data) ? $data : null; // Initialisation des paramètres
        
        return array(
            'controller' => $controllerName,
            'method' => $methodName,
            'params' => $params
        );
    }

    public function getRequestGet() {
        // Récupération des paramètres de l'URL
        $controllerName = isset($_GET['controller']) ? ucfirst($_GET['controller']) . 'Controller' : 'Controller';
        $methodName = isset($_GET['method']) ? $_GET['method'] : 'controllerNotFound';

        return array(
            'controller' => $controllerName,
            'method' => $methodName
        );
    }

    public function routeRequest() {
        // Récupération du type de requête HTTP
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        // Sécurisation des données de la requête
        switch ($requestMethod) {
            case 'GET':
                $requestData = $this->getRequestGet();
                break;
            case 'POST':
                $requestData = $this->getRequestPost();
                break;
            default:
                $requestData = [];
        }

        // Retourne un tableau contenant le nom du contrôleur, le nom de la méthode et les paramètres
        return $requestData;
    }
}
