<?php
class UserModel extends Model
{
    /* CREATE */
    function createPlayer($data) {
        //Verifier le matricule et le mot de passe de l'agent
        $sql = "INSERT INTO users(e_mail, mdp, phone) VALUES (?, ?, ?)";
    
        //Data utilisateur
        $this -> setParams(array($data['e_mail'], sha1($data['mdp']), $data['phone']));
        $this -> setRequest($sql);
    
        //Data BD
        $result = $this -> setItem();

        if ($result) {            
            return TRUE;

        } else {             
            return FALSE;
        }
        
    }

    function createSouscription($data) {
        //Verifier le matricule et le mot de passe de l'agent
        $sql = "INSERT INTO souscription(nom, e_mail, contenu, id_produit) VALUES (?, ?, ?, ?)";
    
        //Data utilisateur
        $this -> setParams(array($data['nom'], $data['email'], $data['message'], $data['produit']));
        $this -> setRequest($sql);
    
        //Data BD
        $result = $this -> setItem();

        if ($result) {            
            return TRUE;

        } else {             
            return FALSE;
        }
        
    }

    function createMessage($data) {
        //Verifier le matricule et le mot de passe de l'agent
        $sql = "INSERT INTO message(nom, email, sujet, contenu) VALUES (?, ?, ?, ?)";
    
        //Data utilisateur
        $this -> setParams(array($data['nom'], $data['email'], $data['sujet'], $data['message']));
        $this -> setRequest($sql);
    
        //Data BD
        $result = $this -> setItem();

        if ($result) {            
            return TRUE;

        } else {             
            return FALSE;
        }
        
    }

    function createCmdBasique($data) {
        //Verifier le matricule et le mot de passe de l'agent
        $sql = "INSERT INTO commande(id_syllabus, id_lecteur, commande, statut) VALUES (?, ?, ?, '1')";
    
        //Data utilisateur
        $this -> setParams(array($data['id'], $_SESSION['user']['id'], 'BASIQUE'));
        $this -> setRequest($sql);
    
        //Data BD
        $result = $this -> setItem();

        if ($result) {            
            return TRUE;

        } else {             
            return FALSE;
        }
        
    }

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
    function getAdminByAuth($data){
        //Verifier le matricule et le mot de passe de l'agent
        $sql = "SELECT *
            FROM auteur
            INNER JOIN admin ON admin.id_auteur = auteur.id
            WHERE pseudo = ? AND mdp = ?
        ";
    
        //Data utilisateur
        $this -> setParams(array($data['pseudo'], sha1($data['mdp'])));
        $this -> setRequest($sql);
    
        //Data BD
        $result = $this -> getFindByParams();

        if (count($result)) {
            foreach ($result as $key => $value) {
                $resultat = $value;
            }
            
            return $resultat;

        } else {             
            return FALSE;
        }
        
    }

    function getAuteurByAuth($data){
        //Verifier le matricule et le mot de passe de l'agent
        $sql = "SELECT *
            FROM auteur
            WHERE pseudo = ? AND mdp = ?
        ";
    
        //Data utilisateur
        $this -> setParams(array($data['pseudo'], sha1($data['mdp'])));
        $this -> setRequest($sql);
    
        //Data BD
        $result = $this -> getFindByParams();

        if (count($result)) {
            foreach ($result as $key => $value) {
                $resultat = $value;
            }
            
            return $resultat;

        } else {             
            return FALSE;
        }
        
    }

    function getPlayerByAuth($data){
        //Verifier le matricule et le mot de passe de l'agent
        $sql = "SELECT users.*, levels.designation AS level, levels.image AS levelCol
            FROM users            
            INNER JOIN levels ON levels.id = users.id_level
            WHERE e_mail = ? AND mdp = ?
        ";
    
        //Data utilisateur
        $this -> setParams(array($data['e_mail'], $data['mdp']));
        $this -> setRequest($sql);
        
        //Data BD
        $result = $this -> getFindByParams();

        if (count($result)) {
            foreach ($result as $key => $value) {
                $resultat = $value;
            }
            
            return $resultat;

        } else {             
            return FALSE;
        }
        
    }

    function getAllPieces(){
        //Verifier le matricule et le mot de passe de l'agent
        $sql = "SELECT *
            FROM pieces
            ORDER BY pieces.parties
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

    function getServiceById($id){
        //Requette
        $sql = "SELECT *
                FROM service
                WHERE service.id = ?
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

    function checkPasswdPlayer($data){
        //Requette
        $sql = "SELECT *
                FROM users
                WHERE users.mdp = ? AND users.id = ?
        ";

        //Traitement Requette
        $this -> setRequest($sql);
        $this -> setParams(array($data['current'], $data['id']));
        
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

    function checkMailPlayer($mail){
        //Requette
        $sql = "SELECT *
                FROM users
                WHERE users.e_mail = ?
        ";

        //Traitement Requette
        $this -> setRequest($sql);
        $this -> setParams(array($mail));
        
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

    function checkPseudoPlayer($pseudo){
        //Requette
        $sql = "SELECT *
                FROM users
                WHERE users.pseudo = ?
        ";

        //Traitement Requette
        $this -> setRequest($sql);
        $this -> setParams(array($pseudo));
        
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

    function checkSoldeProspect($id){
        //Requette
        $sql = "SELECT *
                FROM prospect
                WHERE prospect.id = ?
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

    function checkSoldeAuteur($id){
        //Requette
        $sql = "SELECT *
                FROM auteur
                WHERE auteur.id = ?
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

    function getAllArticles(){
        //Verifier le matricule et le mot de passe de l'agent
        $sql = "SELECT article.id, article.id_chapitre, article.couverture, article.sous_titre, CONCAT(auteur.pseudo) AS 'auteur', article.titre, article.date_post, article.description, syllabus.id_categorie
                FROM article
                INNER JOIN chapitre ON chapitre.id = article.id_chapitre
                INNER JOIN syllabus ON syllabus.id = chapitre.id_syllabus
                INNER JOIN auteur ON auteur.id = syllabus.id_auteur
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

    function getArticleById($id){
        //Requette
        $sql = "SELECT article.*, auteur.nom, auteur.post_nom, auteur.prenom, auteur.sexe, auteur.e_mail, auteur.profile, auteur.description AS 'bio', auteur.id AS 'auteur', syllabus.id As 'syllabus'
                FROM article
                INNER JOIN chapitre ON chapitre.id = article.id_chapitre
                INNER JOIN syllabus ON syllabus.id = chapitre.id_syllabus
                INNER JOIN auteur ON auteur.id = syllabus.id_auteur
                WHERE article.id=?
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

    function getAllThemes(){
        //Verifier le matricule et le mot de passe de l'agent
        $sql = "SELECT theme.id, theme.titre
                FROM theme
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

    function getAllCategories(){
        //Verifier le matricule et le mot de passe de l'agent
        $sql = "SELECT categorie.id, categorie.titre, categorie.id_theme AS 'theme'
                FROM categorie
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

    function getSyllabusById($id){
        //Requette
        $sql = "SELECT syllabus.*, categorie.titre AS 'categorie', theme.titre AS 'theme', auteur.nom, auteur.post_nom, auteur.prenom, auteur.telephone, auteur.solde, auteur.id AS 'auteur_id'
                FROM syllabus 
                INNER JOIN categorie ON categorie.id = syllabus.id_categorie
                INNER JOIN theme ON theme.id = categorie.id_theme
                INNER JOIN auteur ON auteur.id = syllabus.id_auteur
                WHERE syllabus.id=?
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

    function getChapitresBySyllabus($id){
        //Requette
        $sql = "SELECT chapitre.*
                FROM chapitre 
                WHERE chapitre.id_syllabus=?
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

    function getArticlesByChapitre($id){
        //Requette
        $sql = "SELECT article.*
                FROM article 
                WHERE article.id_chapitre=?
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

    function getAllSyllabus(){
        //Verifier le matricule et le mot de passe de l'agent
        $sql = "SELECT syllabus.id, syllabus.titre, syllabus.sous_titre, syllabus.description, syllabus.couverture, syllabus.prix, CONCAT(auteur.pseudo) AS 'auteur', categorie.titre AS 'categorie', syllabus.id_categorie
                FROM syllabus
                INNER JOIN auteur ON auteur.id = syllabus.id_auteur
                INNER JOIN categorie ON categorie.id = syllabus.id_categorie
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

    function getCaissierByAuth($data){
        //Verifier le matricule et le mot de passe de l'agent
        $sql = "SELECT auteur.*, caissier.id as 'caissier_id', caissier.code AS 'caissier_code', caissier.statut
            FROM auteur
            INNER JOIN caissier ON caissier.id_auteur = auteur.id
            WHERE pseudo = ? AND mdp = ?
        ";
    
        //Data utilisateur
        $this -> setParams(array($data['pseudo'], sha1($data['mdp'])));
        $this -> setRequest($sql);
    
        //Data BD
        $result = $this -> getFindByParams();

        if (count($result)) {
            foreach ($result as $key => $value) {
                $resultat = $value;
            }
            
            return $resultat;

        } else {             
            return FALSE;
        }
        
    }

    /* UPDATE */
    function changePasswordPlayer($data) {
        //Verifier le matricule et le mot de passe de l'agent
        $sql = "UPDATE users 
            SET users.mdp=? 
            WHERE users.e_mail=?
        ";
    
        //Data utilisateur
        $this -> setParams(array($data['mdp'], $data['e_mail']));
        $this -> setRequest($sql);
    
        //Data BD
        $result = $this -> setItem();

        if ($result) {            
            return TRUE;

        } else {             
            return FALSE;
        }
        
    }

    function changePasswordAuteur($data) {
        //Verifier le matricule et le mot de passe de l'agent
        $sql = "UPDATE auteur 
            SET auteur.mdp=? 
            WHERE auteur.e_mail=?
        ";
    
        //Data utilisateur
        $this -> setParams(array(sha1($data['mdp']), $data['email']));
        $this -> setRequest($sql);
    
        //Data BD
        $result = $this -> setItem();

        if ($result) {            
            return TRUE;

        } else {             
            return FALSE;
        }
        
    }

    function changeSoldeProspect($solde) {
        //Verifier le matricule et le mot de passe de l'agent
        $sql = "UPDATE prospect 
            SET prospect.solde=? 
            WHERE prospect.id=?
        ";
    
        //Data utilisateur
        $this -> setParams(array($solde, $_SESSION['user']['id']));
        $this -> setRequest($sql);
    
        //Data BD
        $result = $this -> setItem();

        if ($result) {            
            return TRUE;

        } else {             
            return FALSE;
        }
        
    }

    function setCreditAuteur($data) {
        //Verifier le matricule et le mot de passe de l'agent
        $sql = "UPDATE auteur 
            SET auteur.solde=?
            WHERE auteur.id=?
        ";
    
        //Data utilisateur
        $this -> setParams(array($data['montant'], $data['id']));
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
