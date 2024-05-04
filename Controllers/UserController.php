<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../Core/API/PHPMailer-master/src/Exception.php';
require __DIR__ . '/../Core/API/PHPMailer-master/src/PHPMailer.php';
require __DIR__ . '/../Core/API/PHPMailer-master/src/SMTP.php';

class UserController extends AppController
{ 
    public $bdd;
    function __construct() {
        parent::__construct();

        $this->bdd = new UserModel();
        
    }

    function login($data = array('mdp'=> NULL, 'e_mail' => NULL)) {
        $reqData = array(
            'mdp' => sha1(htmlspecialchars($data['mdp'])),
            'e_mail' => htmlspecialchars($data['e_mail']),                
        );
        
        $result = $this->bdd->getPlayerByAuth($reqData);

        if ($result) {
            $this->render(
                array(
                    'status' => TRUE,
                    'reponse' => $result                
                )
            );
        } else {
            $this->render(
                array(
                    'status' => FALSE,
                    'reponse' => 'E-mail ou Mot de passe incorrecte '               
                )
            );
        }
        
    }

    function signup($data = array('phone'=> NULL, 'mdp'=> NULL, 'e_mail' => NULL)) {
        $reqData = array(
            'mdp' => sha1(htmlspecialchars($data['mdp'])),
            'e_mail' => htmlspecialchars($data['e_mail']),   
            'phone' => htmlspecialchars($data['phone']),                
        );
        $isUser = $this->bdd->checkMailPlayer($reqData['e_mail']) ? TRUE : FALSE;

        if ($isUser) {
            $this->render(
                array(
                    'reponse' => 'Opps! Votre compte n\'a pas été créé, car cette adresse e-mail est déjà utilisée par un autre joueur.'                
                )
            );
        } else {
            $data = $this->bdd->createPlayer($reqData);

            if ($data) {
                $this->render(
                    array(
                    'reponse' => $data                
                    )
                );
            } else {
                $this->render(
                    array(
                        'reponse' => 'Opps! Votre compte n\'a pas été créé.'                
                    )
                );
            }
        }
        
        
    }

    function generateRandomPassword($length = 12) {
        // Génération du mot de passe aléatoire
        $chars = 'abcdefghijklmnopqrstuvwxyz';
        $password = '';
        for ($i = 0; $i < $length; $i++) {
            $password .= $chars[rand(0, strlen($chars) - 1)];
        }
        return $password;
    }

    function sendNewPassword($email) {
        $mail = new PHPMailer(true);
        $mdp = $this->generateRandomPassword(6);
        try {
            // Paramètres SMTP de Hostinger
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'lisongobaita@gmail.com'; // Votre adresse e-mail Hostinger
            $mail->Password = 'obfthbjhhqoznfdk'; // Votre mot de passe Hostinger
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;
        
            // Expéditeur et destinataire
            $mail->setFrom('no-reply@elmes-service.site', 'QuizzApp');
            $mail->addAddress($email);
        
            // Contenu de l'e-mail
            $mail->isHTML(true);
            $mail->Subject = 'Nouveau mot de passe';
            $mail->Body = 'Votre nouveau mot de passe est : ' . $mdp;
        
            // Envoyer l'e-mail
            $mail->send();

            return $mdp;
        } catch (Exception $e) {
            return FALSE;
        }

    }

    function recovery($data = array('e_mail' => NULL)) {
        $reqData = array(
            'e_mail' => htmlspecialchars($data['e_mail']),                  
        );

        $isUser = $this->bdd->checkMailPlayer($reqData['e_mail']) ? TRUE : FALSE;

        if (!$isUser) {
            $this->render(
                array(
                    'status' => FALSE,
                    'reponse' => "Opps! Votre adresse e-mail n'est pas enregistrer dans le système !!!"                
                )
            );
        } else {
            $reqData['mdp'] = $this->sendNewPassword($reqData['e_mail']);

            if ($this->bdd->changePasswordPlayer($reqData)) {
                $this->render(
                    array(
                        'status' => TRUE,
                        'reponse' => 'Votre compte a été reinitialisé. Allez dans votre boite e-mail pour récuperer le nouveau mot de passe.'                
                    )
                );
            } else {
                $this->render(
                    array(
                        'status' => FALSE,
                        'reponse' => 'Opps! Un problème est survenu pendant le traitement de la requête.'                
                    )
                );
            }
            
        }
        
        
    }

    function passwd($data = array('id' => NULL, 'current' => NULL, 'new' => NULL)) {
        $reqData = array(
            'id' => (int) $data['id'], 
            'current' => sha1(htmlspecialchars($data['current'])),
            'mdp' => sha1(htmlspecialchars($data['new']))       
        );

        $isUser = $this->bdd->checkPasswdPlayer($reqData) ? $this->bdd->checkPasswdPlayer($reqData) : FALSE;

        if (is_array($isUser)) {
            $reqData['e_mail'] = $isUser['e_mail'];

            if ($this->bdd->changePasswordPlayer($reqData)) {
                $this->render(
                    array(
                        'status' => TRUE,
                        'reponse' => $reqData['mdp']             
                    )
                );
            } else {
                $this->render(
                    array(
                        'status' => FALSE,
                        'reponse' => 'Opps! Un problème est survenu pendant le traitement de la requête.'                
                    )
                );
            }
        } else {
            $this->render(
                array(
                    'status' => FALSE,
                    'reponse' => "Opps! Veuillez renseigner le bon mot de passe !!!"                
                )
            );
            
        }
        
        
    }

    function pieces() {
        $data = $this->bdd->getAllPieces() ? $this->bdd->getAllPieces() : FALSE;

        if (!$data) {

            $this->render(
                array(
                    'status' => FALSE,
                    'reponse' => "Opps! Aucune piece n'a été trouvé dans le système !!!"                
                )
            );
        } else {
            $pieces = array();

            foreach ($data as $piece) {
                $pieces[] = array(
                    'id'=>$piece['id'],
                    'nom'=> ucfirst($piece['designation']),
                    'image'=>$piece['image'],
                    'color'=>$piece['color'],
                    'parties'=>$piece['parties'],
                    'bonus'=>$piece['bonus'],
                    'montant'=>$piece['montant'],
                    'icone'=>$piece['icone'],
                    'description'=>$piece['description'],
                );
            }

            $this->render(
                array(
                    'status' => TRUE,
                    'reponse' => $pieces      
                )
            );
            
        }
        
        
    }
}
