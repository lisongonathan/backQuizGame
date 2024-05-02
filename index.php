<?php
// Inclut l'autoloader
require_once './Core/autoload.php';
require_once './Controllers/Controller.php';

// Création d'une instance de DefaultController
$defaultController = new Controller();

// Récupère les données de la requête POST
$data = $defaultController->routeRequest();

// Vérifie si le contrôleur et la méthode existent
if (file_exists('./Controllers/' . $data['controller'] . '.php')) {

    // Crée une instance du contrôleur
    $controller = new $data['controller']();
    $method = $data['method'];
    
    if (method_exists($controller, $data['method'])) {
    
        if (count($data) > 2) {
            $params = $data['params']; 

            // Appelle la méthode spécifiée avec les paramètres
            $controller->$method($params);

        } else {
    
            // Appelle la méthode spécifiée sans les paramètres
            $controller->$method();
        }
    } else {
        // Contrôleur ou méthode non trouvés
        $defaultController->methodNotFound();
    }

    
} else {
    // Contrôleur ou méthode non trouvés
    $defaultController->render(["error" => "Contrôleur ". $data['controller'] ." non trouvé."]);
}