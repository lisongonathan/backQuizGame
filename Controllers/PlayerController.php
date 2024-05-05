<?php
require __DIR__ . '/../Core/API/Cinetpay/src/cinetpay.php';
require __DIR__ . '/../Core/API/Cinetpay/commande.php';
class PlayerController extends UserController
{ 
    public $bdd;
    function __construct() {
        parent::__construct();

        $this->bdd = new PlayerModel();
        
    }

    function parties($id = NULL) {
        $data = $this->bdd->getPartiesUser($id);
        $gamesWin = 0;
        $gamesOver = 0;
        $questions = array();

        if ($data) {

            foreach ($data as $parties) {
                if ($parties['score'] != 3 ) {
                    $gamesOver++;
                } else {
                    $gamesWin++;
                }

                $old_games = $this->bdd->getQuizzesPartie($parties['id']);

                if ($old_games) {
                    
                    foreach ($old_games as $quiz) {
                        $questions[] = $quiz;
                    }
                }
                
            }

            $this->render(
                array(
                    'status' => TRUE,
                    'reponse' =>  array(
                        'questions' => $questions,
                        'win' => $gamesWin,
                        'lost' => $gamesOver,
                        'games'=> $data
                    )
                )
            );
        } else {
             $this->render(
                array(
                    'status' => FALSE,
                    'reponse' =>  array(
                        'questions' => $questions,
                        'win' => $gamesWin,
                        'lost' => $gamesOver,
                        'games'=> array()
                    )
                )
            );
        }
        
       
        
    } 
    
    function notifyPaiement() {
        echo "Page de notification";
        print_r($_POST);
        
        // if (isset($_POST['cpm_trans_id'])) {
        
        //     try {
            
        //         require_once __DIR__ . '/../src/cinetpay.php';
        //         require_once __DIR__ . '/../commande.php';
        //         require_once __DIR__ . '/../marchand.php';

        //         //Création d'un fichier log pour s'assurer que les éléments sont bien exécuté
        //         $log  = "User: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
        //         "TransId:".$_POST['cpm_trans_id'].PHP_EOL.
        //         "SiteId: ".$_POST['cpm_site_id'].PHP_EOL.
        //         "-------------------------".PHP_EOL;
        //         //Save string to log, use FILE_APPEND to append.
        //         file_put_contents('./log_'.date("j.n.Y").'.log', $log, FILE_APPEND);

        //         //La classe commande correspond à votre colonne qui gère les transactions dans votre base de données
        //         $commande = new Commande();
        //         // Initialisation de CinetPay et Identification du paiement
        //         $id_transaction = $_POST['cpm_trans_id'];
        //         // apiKey
        //         $apikey = $marchand["apikey"];


        //         // siteId
        //         $site_id = $_POST['cpm_site_id'];


        //         $CinetPay = new CinetPay($site_id, $apikey);
        //         //On recupère le statut de la transaction dans la base de donnée
        //         /* $commande->set_transactionId($id_transaction);
        //             //Il faut s'assurer que la transaction existe dans notre base de donnée
        //         * $commande->getCommandeByTransId();
        //         */

        //         // On verifie que la commande n'a pas encore été traité
        //         $VerifyStatusCmd = "1"; // valeur du statut à recupérer dans votre base de donnée
        //         if ($VerifyStatusCmd == '00') {
        //             // La commande a été déjà traité
        //             // Arret du script
        //             die();
        //         }

        //         // Dans le cas contrait, on verifie l'état de la transaction en cas de tentative de paiement sur CinetPay

        //         $CinetPay->getPayStatus($id_transaction, $site_id);


        //         $amount = $CinetPay->chk_amount;
        //         $currency = $CinetPay->chk_currency;
        //         $message = $CinetPay->chk_message;
        //         $code = $CinetPay->chk_code;
        //         $metadata = $CinetPay->chk_metadata;

        //         //Something to write to txt log
        //         $log  = "User: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
        //             "Code:".$code.PHP_EOL.
        //             "Message: ".$message.PHP_EOL.
        //             "Amount: ".$amount.PHP_EOL.
        //             "currency: ".$currency.PHP_EOL.
        //             "-------------------------".PHP_EOL;
        //         //Save string to log, use FILE_APPEND to append.
        //         file_put_contents('./log_'.date("j.n.Y").'.log', $log, FILE_APPEND);

        //         // On verifie que le montant payé chez CinetPay correspond à notre montant en base de données pour cette transaction
        //         if ($code == '00') {
        //             // correct, on delivre le service
        //             echo 'Felicitation, votre paiement a été effectué avec succès';
        //             die();

        //         } else {
        //             // transaction n'est pas valide
        //             echo 'Echec, votre paiement a échoué pour cause : ' .$message;
        //             die();
        //         }
        //         // mise à jour des transactions dans la base de donnée
        //         /*  $commande->update(); */

        //     } catch (Exception $e) {
        //         echo "Erreur :" . $e->getMessage();
        //     }
        // } else {
        //     // direct acces on IPN
        //     echo "cpm_trans_id non fourni";
        // }
    }
    
    function returnPaiement() {
        echo "Page de retour";
        print_r($_POST);

        if (isset($_POST['transaction_id']) || isset($_POST['token'])) {

            $commande = new Commande();
            $id_transaction = $_POST['transaction_id'];
            
            $marchand = array(
                "apikey" => "188209650365bdb731e0cd44.70688434", // Enrer votre apikey
                "site_id" => "5868051", //Entrer votre site_ID
                "secret_key" => "107118893965bdcb48877944.10066398" //Entrer votre clé secret
            );
        
            try {
                // Verification d'etat de transaction chez CinetPay
                $CinetPay = new CinetPay($marchand["site_id"], $marchand["apikey"]);
        
                $CinetPay->getPayStatus($id_transaction, $marchand["site_id"]);
                $message = $CinetPay->chk_message;
                $code = $CinetPay->chk_code;
        
                //recuperer les info du clients pour personnaliser les reponses.
                /* $commande->getUserByPayment(); */
        
                // redirection vers une page en fonction de l'état de la transaction
                if ($code == '00') {
                    echo 'Felicitation, votre paiement a été effectué avec succès';
                    
                }
                else {
                   // header('Location: '.$commande->getCurrentUrl().'/');
                    echo 'Echec, votre paiement a échoué';
                    
                }
        
            } catch (Exception $e) {
                echo "Erreur :" . $e->getMessage();
            }

            // header('Location:exp://172.20.10.3:8081/quizGame');
            // die();
        } else {
            echo 'transaction_id non transmis';
            die();
        
        }
    }

    function paiement(
        $data = array(
            "amount"=> "1",
            "currency"=> 'USD',
            "customer_surname"=> "Joe",
            "customer_name"=> "Down",
            "description"=> 'Test de paiement'
        )
   ) 
   {
        
        $marchand = array(
            "apikey" => "188209650365bdb731e0cd44.70688434", // Enrer votre apikey
            "site_id" => "5868051", //Entrer votre site_ID
            "secret_key" => "107118893965bdcb48877944.10066398" //Entrer votre clé secret
        );
        
        //Channels
        $data["channels"] ='ALL';

        //Invoice
        $data["invoice_data"] =array(
            "Data 1" => "",
        );
        
        //Retour
        $data["return_url"] ='http://172.20.10.3/elmes_quiz/player/returnPaiement';

        //Notification
        $data["notify_url"] ='http://172.20.10.3/elmes_quiz/player/notifyPaiement';

        //transaction id
        $data["transaction_id"] = time();
    
        //Veuillez entrer votre apiKey
        $apikey = $marchand["apikey"];
        //Veuillez entrer votre siteId
        $site_id = $marchand["site_id"];

        // La class gère la table "Commande"( A titre d'exemple)
        $commande = new Commande();

        $CinetPay = new CinetPay($site_id, $apikey , $VerifySsl=false);//$VerifySsl=true <=> Pour activerr la verification ssl sur curl 
        $result = $CinetPay->generatePaymentLink($data);
    
        if ($result["code"] == '201')
        {
            $url = $result["data"]["payment_url"];
            
            // header('Location:'.$url);
            
            $this->render(
                array(
                    'status' => TRUE,
                    'reponse' =>  $url
                )
            );
    
            // ajouter le token à la transaction enregistré
            /* $commande->update(); */
            //redirection vers l'url de paiement
    
        } else {           

            $this->render(
                array(
                    'status' => TRUE,
                    'reponse' => $result
                )
            );
        }
        
    }    

    function notification($status = 'FELICITATION', $user = array('photo' => 'http://172.20.10.3/backQuizGame/Core/Images/player_6.jpeg', 'nom'  => 'LISONGO BAÏTA, Nathan'), $message="Votre compte a bien été crédité de 10000CDF en date du 05/05/2024. QuizGame vous souhaite bonne chance !!!") {
        $data = array(
            'status'  =>  $status,
            'user'  =>  $user,
            'message'  => $message
        );
        $this->vue('retour', $data);
    }

    function avatar() {
        if ($_FILES) {
            $id = explode('_', $_FILES["photo"]["name"])[1];
            $target_dir = __DIR__ . '/../Core/Images/';
            $file_name = basename($_FILES["photo"]["name"]) . '.' . explode('/', $_FILES["photo"]["type"])[1];
            $target_file = $target_dir . '' . $file_name;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            
            if (in_array($imageFileType, array('jpg', 'jpeg', 'png', 'gin'))) {
                if (!($_FILES["photo"]["size"] > 30000000)) {
                    if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
                        $status = $this->bdd->changePhotoPlayer(array('id' => $id, 'photo' => 'http://172.20.10.3/backQuizGame/Core/Images/' . $file_name));
                        
                        if ($status) {
                            $data = $this->bdd->getPlayerById($id);

                            if ($data) { 
                                $this->render(
                                    array(
                                        'status' => TRUE,
                                        'reponse' => $data
                                    )
                                );
                            } else {
                                $this->render(
                                    array(
                                        'status' => FALSE,
                                        'reponse' => "Tout ne s'est pas bien passé pendant le traitement de la requette"
                                    )
                                );
                            }
                            
                        } else {                            
                            $this->render(
                                array(
                                    'status' => FALSE,
                                    'reponse' => 'Une erreur inattendue est survenu lors de stokage de la photo'
                                )
                            );
                        }
                    } else {
                        $this->render(
                            array(
                                'status' => FALSE,
                                'reponse' => "Erreur lors de l'enregistrement de la photo"
                            )
                        );
                    }
                    
                } else {
                    $this->render(
                        array(
                            'status' => FALSE,
                            'reponse' => 'Le fichier est trop lourd : ' . $_FILES["photo"]["size"] . 'Ko'
                        )
                    );
                }
                
            } else {
                $this->render(
                    array(
                        'status' => FALSE,
                        'reponse' => 'Desole seul les images sont autorisées'
                    )
                );
            }
             
        } else {
            $this->render(
                array(
                    'status' => FALSE,
                    'reponse' => $_FILES
                )
            ); 
        }        
        
    }

    function profile($user = array()) {

        if ($user) {
            $id = $user["id"];

            foreach ($user as $key => $value) {
                $status = $this->bdd->changeProfilePlayer($key, strtolower($value), $id);

                if (!$status) {
                    $this->render(
                        array(
                            'status' => FALSE,
                            'reponse' =>  "Un probleme est survenu lors de l'enregistrement de cette information : " . $value
                        )
                    );

                    break;
                }
                
            }
            
            $data = $this->bdd->getPlayerById($id);

            if ($data) { 
                $this->render(
                    array(
                        'status' => TRUE,
                        'reponse' => $data
                    )
                );
            } else {
                $this->render(
                    array(
                        'status' => FALSE,
                        'reponse' => "Tout ne s'est pas bien passé pendant le traitement de la requette"
                    )
                );
            }

        } else {
            $this->render(
                array(
                    'status' => FALSE,
                    'reponse' =>  "Aucune information n'a été fournie"
                )
            );
        }
        
    }

}
