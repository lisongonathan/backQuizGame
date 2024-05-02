<?php
spl_autoload_register(function ($className){
    $modelPath = __DIR__ . '/../Models/' . $className . '.php';
    $controllerPath = __DIR__ . '/../Controllers/' . $className . '.php';

    //Verification de l'existence du fichier
    if (file_exists($modelPath)) {
        # Inclusion de la classe Model
        require_once $modelPath;
    
    } elseif (file_exists($controllerPath)) {
        # Inclusion de la classe Controller
        require_once $controllerPath;

    } else {
        # Aucun fichier de classe n'a été trouver
        throw new Exception("La class $className est introuvable");
        
    }
    
});