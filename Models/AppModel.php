<?php
class AppModel extends Model
{
    //Create

    //Read
    /* RULES */
    function getRulesApp(){
        //Verifier le matricule et le mot de passe de l'agent
        $sql = "SELECT *
            FROM app
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

    /* CLASSEMENT */
    function getClassementApp(){
        //Verifier le matricule et le mot de passe de l'agent
        $sql = "SELECT users.photo, users.pseudo, users.solde, levels.designation, COUNT(historiques.id) AS qstns
            FROM users
            INNER JOIN levels ON levels.id = users.id_level
            INNER JOIN games ON games.id_user = users.id
            INNER JOIN historiques ON historiques.id_game = games.id
            GROUP BY users.id
            ORDER BY qstns DESC
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

    //Update

    //Delete
    
}
