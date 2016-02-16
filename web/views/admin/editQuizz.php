<div>
    <div class="row">
        <div class="col-md-2">
            <a href="<?php echo BASE_URL;?>admin/listQuizz"><i class="fa fa-arrow-left"></i> Revenir à la liste des quizz</a>
        </div>
    </div>
    <hr>
    <h1 style="text-align:center">Mode édition</h1>
    <hr>
    
    <div class="col-md-12">
        <h3 style="text-align:center">Informations générales</h3>
        <form method="post" action="">
            <div class="row">
                <div class="col-md-2">
                    <p>EN LIGNE</p>
                </div>
                <div class="col-md-10">
                    <input type="checkbox" <?php echo (($quizz['enabled'])? 'checked':'');?> name="enabled" value="1">
                </div>
            </div>
            <input type="hidden" value="<?php echo $quizz['id_quizz'];?>" name="idquizz" hidden>
            <div class="row">
                <div class="col-md-2">
                    <p>INTITULÉ DU QUIZZ</p>
                </div>
                <div class="col-md-10">
                    <input type="text" class="form-control" value="<?php echo $quizz['quizz_name'];?>" name="name" required>
                    <input type="hidden" value="<?php echo $quizz['quizz_name'];?>" name="original-name" hidden>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <p>DESCRIPTION</p>
                </div>
                <div class="col-md-10">
                    <textarea class="form-control" name="description"><?php echo $quizz['description'];?></textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <p>LOT</p>
                </div>
                <div class="col-md-10">
                    <textarea class="form-control" name="lot" required><?php echo $quizz['lot'];?></textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <p>DATE DE DÉBUT</p>
                </div>
                <div class="col-md-10">
                    <input type="text" class="form-control form-datetime" value="<?php echo $quizz['date_start'];?>" disabled>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <p>DATE DE FIN</p>
                </div>
                <div class="col-md-10">
                    <input type="text" class="form-control form-datetime" value="<?php echo $quizz['date_end'];?>" disabled>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <p>QUESTIONS AFFICHÉES</p>
                </div>
                <div class="col-md-10">
                    <input type="number" min="1" max="<?php echo $quizz['questions_nb_total'];?>" class="form-control" value="<?php echo $quizz['questions_nb_displayed'];?>" name="questions_nb_displayed" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <p>TOTAL DE QUESTIONS</p>
                </div>
                <div class="col-md-10">
                    <input type="number" value="<?php echo $quizz['questions_nb_total'];?>" class="form-control" disabled>
                    <input type="hidden" name="questions_nb_total" value="<?php echo $quizz['questions_nb_total'];?>" hidden>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-10">
                    <button type="submit" class="btn btn-success" name="submit" value="update" style="float:right">METTRE A JOUR</button>
                </div>
            </div>
        </form>
    </div>
    <div  class="col-md-12">
        <h3 style="text-align:center">Questions / Réponses</h3>

        <?php if(isset($quizz['questions'])){?>
        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
            <?php foreach($quizz['questions'] as $id_question => $question){?>
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="heading_<?php echo $id_question;?>">
                    <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse_<?php echo $id_question;?>" aria-expanded="true" aria-controls="collapse_<?php echo $id_question;?>">
                            <p id="question_<?php echo $id_question;?>"><?php echo htmlentities($question['question']);?></p>                            
                        </a>
                    </h4>
                </div>
                <div id="collapse_<?php echo $id_question;?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading_<?php echo $id_question;?>">
                    <div class="panel-body row" data-id-question="<?php echo $id_question;?>">
                        <div class="col-md-12">
                            <input data-id-question="<?php echo $id_question;?>" class="form-control" value="<?php echo htmlentities($question['question']);?>" placeholder="Question...">
                        </div>
                        <br><br>
                        <?php foreach($question['propositions'] as $id_proposition => $proposition){?>
                        <div class="col-md-3">
                            <input data-id-proposition="<?php echo $id_proposition;?>" class="form-control" style="border:solid 1px<?php echo (($proposition['is_correct'])? '#33d31e' : '#d3331e');?>" value="<?php echo htmlentities($proposition['proposition']);?>">
                        </div>
                        <?php }?>
                        <br><br>
                        <div class="col-md-3">
                            <button type="button" class="btn btn-default btn-update" data-id-question="<?php echo $id_question;?>">MODIFIER</button>
                        </div>
                    </div>
                </div>
            </div>
            <?php }?>
            <?php }else{?>
            <p style="text-align:center">Il n'y a aucune question à ce quizz.</p>
            <?php }?>
        </div>
    </div>

</div>

<script>
    $(document).ready(function(){
        $("button.btn-update").click(function(){
            var idQuestion = new Object();
            var idPropositions = new Object();

            $("div[data-id-question='"+$(this).attr("data-id-question")+"'] input[data-id-proposition]").each(function(){
                idPropositions[ $(this).attr('data-id-proposition') ] = $(this).val();
            });

            idQuestion[$(this).attr("data-id-question")] = $("div[data-id-question='"+$(this).attr("data-id-question")+"'] input[data-id-question]").val();
            updateQuestion(idQuestion, idPropositions, $(this).attr("data-id-question"));

            return false;
        });
    });
</script>
<style>
    .row{
        margin-bottom: 10px
    }
</style>