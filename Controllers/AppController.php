<?php
class AppController extends Controller
{     
    public $bdd;

    function __construct() {
        $this->bdd = new AppModel();
        
    }

    function rules() {
        $data = $this->bdd->getRulesApp();
        $this->render(
            array(
                'rules' => $data[0]['rules']
            )
        );
    }

    function cagnotte() {
        $data = $this->bdd->getRulesApp();
        $this->render(
            array(
                'cagnotte' => $data[0]['cagnotte']
            )
        );
    }

    function classement() {
        $data = $this->bdd->getClassementApp();
        $this->render(
            array(
                'classement' => $data
            )
        );
    }
}
