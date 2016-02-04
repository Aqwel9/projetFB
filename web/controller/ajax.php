<?php
class ajaxController extends baseController {

    public function index() {        
        $this->registry->template->show('not_found');
    }

    public function updateQuestion(){
        if(isset($_POST['idQuestion']) && isset($_POST['idPropositions'])){
            $json_data = [
                'idQuestion' => [],
                'idPropositions' => []
            ];

            foreach($_POST['idQuestion'] as $id => $label){
                $json_data['idQuestion'][] = $this->registry->db->updateLabel($id, $label, 'question');
            }

            foreach($_POST['idPropositions'] as $id => $label){
                $json_data['idPropositions'][] = $this->registry->db->updateLabel($id, $label, 'proposition');
            }

            echo json_encode($json_data);
        }
    }

    public function getQuizzById(){
        if(isset($_POST['id']) && filter_var($_POST['id'], FILTER_VALIDATE_INT)){
            $idQuizz = $_POST['id'];
            $json_data['quizz'] = $this->registry->db->getQuestionsByIdQuizz($_POST['id']);
        }else $json_data['error'] = "Erreur d'id";   

        echo json_encode($json_data);
    }

    public function insertAnswer(){
        if(isset($_POST['idQuizz']) && isset($_POST['idQuestion']) && isset($_POST['idProposition']) && isset($_POST['idFb']) && isset($_POST['time'])){
            $idFb = $_POST['idFb'];
            $idQuestion = $_POST['idQuestion'];
            $idProposition = $_POST['idProposition'];
            $time = $_POST['time'];
            $idQuizz = $_POST['idQuizz'];
            $json_data = [$idFb, $idQuestion, $idProposition, $time, $idQuizz];

            //vérification à faire
            if(($res = $this->registry->db->insertAnswer($idFb, $idQuestion, $idProposition, $time, $idQuizz)) === true){
                $json_data['message'] = '';
                $json_data['success'] = true;
            }else{
                $json_data['message'] = $res;
                $json_data['success'] = false;
            }

            echo json_encode($json_data);
        }
    }
}
?>