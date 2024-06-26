<?php
class PlayerModel extends UserModel
{
    /* CREATE */
    function createCmdStandard($data) {
        //Verifier le matricule et le mot de passe de l'agent
        $sql = "INSERT INTO commande(id_syllabus, id_lecteur, commande) VALUES (?, ?, ?)";
    
        //Data utilisateur
        $this -> setParams(array($data['id'], $_SESSION['user']['id'], 'STANDARD'));
        $this -> setRequest($sql);
    
        //Data BD
        $result = $this -> setItem();

        if ($result) {            
            return TRUE;

        } else {             
            return FALSE;
        }
        
    }

    function createCmdAvance($data) {
        //Verifier le matricule et le mot de passe de l'agent
        $sql = "INSERT INTO commande(id_syllabus, id_lecteur, commande) VALUES (?, ?, ?)";
    
        //Data utilisateur
        $this -> setParams(array($data['id'], $_SESSION['user']['id'], 'AVANCE'));
        $this -> setRequest($sql);
    
        //Data BD
        $result = $this -> setItem();

        if ($result) {            
            return TRUE;

        } else {             
            return FALSE;
        }
        
    }

    /* READ */
    function getAllTestimonials(){
        //Verifier le matricule et le mot de passe de l'agent
        $sql = "SELECT auteur.profile, CONCAT(auteur.prenom, '-',auteur.nom, ' ', auteur.post_nom) AS client, testimonial.profession, testimonial.contenu
                FROM testimonial
                INNER JOIN auteur ON testimonial.id_auteur = auteur.id
        ";
    
        //Data utilisateur
        $this -> setRequest($sql);
    
        //Data BD
        $result = $this -> getFind();

        if (count($result)) {
            foreach ($result as $key => $value) {
                $resultat[] = $value;
            }
            
            return $resultat;

        } else {             
            return FALSE;
        }
        
    }

    function getPartiesUser($id){
        //Requette
        $sql = "SELECT games.*
            FROM users
            INNER JOIN games ON games.id_user = users.id
            WHERE users.id = ?
        ";

        //Traitement Requette
        $this -> setRequest($sql);
        $this -> setParams(array($id));
        
        //Traiment Resultat
        $data = $this->getFindByParams();

        if (count($data)) {
            foreach ($data as $key => $value) {
                $resultat[] = $value;
            }

            return $resultat;
        } else {            
            return FALSE;
        }

    } 

    function getQuizzesPartie($id){
        //Requette
        $sql = "SELECT historiques.*
            FROM historiques
            WHERE historiques.id_game = 1
        ";

        //Traitement Requette
        $this -> setRequest($sql);
        $this -> setParams(array($id));
        
        //Traiment Resultat
        $data = $this->getFindByParams();

        if (count($data)) {
            foreach ($data as $key => $value) {
                $resultat[] = $value;
            }

            return $resultat;
        } else {            
            return FALSE;
        }

    } 

    function getPlayerById($id){
        //Requette
        $sql = "SELECT users.*
            FROM users
            WHERE users.id = ?
        ";

        //Traitement Requette
        $this -> setRequest($sql);
        $this -> setParams(array($id));
        
        //Traiment Resultat
        $data = $this->getFindByParams();

        if (count($data)) {
            foreach ($data as $key => $value) {
                $resultat = $value;
            }

            return $resultat;
        } else {            
            return FALSE;
        }

    } 

    /* UPDATE */
    function changePhotoPlayer($data) {
        //Verifier le matricule et le mot de passe de l'agent
        $sql = "UPDATE users 
            SET users.photo=? 
            WHERE users.id=?
        ";
    
        //Data utilisateur
        $this -> setParams(array($data['photo'], $data['id']));
        $this -> setRequest($sql);
    
        //Data BD
        $result = $this -> setItem();

        if ($result) {            
            return TRUE;

        } else {             
            return FALSE;
        }
        
    }

    function changeProfilePlayer($champ, $valeur, $id) {
        //Verifier le matricule et le mot de passe de l'agent
        $sql = "UPDATE users 
            SET users.". $champ ."=? 
            WHERE users.id=?
        ";
    
        //Data utilisateur
        $this -> setParams(array($valeur, $id));
        $this -> setRequest($sql);
    
        //Data BD
        $result = $this -> setItem();

        if ($result) {            
            return TRUE;

        } else {             
            return FALSE;
        }
        
    }
}
