<div>
    <div class="row" id="title">
        <div class="col-md-12">
            <h4 style="text-align:center">Ajout d'un nouveau Quizz !</h4>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-3" style="text-align:center;color:#d4d4d4">
            <p style="font-size: 40px;">1</p>
            <p>Création du Quizz</p>
        </div>
        <div class="col-md-3" style="text-align:center">            
            <p style="font-size: 40px;">2</p>
            <p>Ajout des questions</p>
        </div>
        <div class="col-md-3"></div>
    </div>
    <hr>

    <div class="col-md-12">
        <form action="" method="POST">
            <input type="hidden" name="idQuizz" value="<?php echo ((isset($idQuizz))? $idQuizz : null);?>">
            <input type="hidden" name="nbQuestions" value="<?php echo ((isset($nbQuestions))? $nbQuestions : null);?>">
            <p style="text-align:right">        
                <button type="submit" class="btn btn-link">Terminer <i class="fa fa-arrow-right"></i></button>            
            </p>        
            <div id="questions">
                <div class="">
                    <div class="row">
                        <?php for($i=1; $i<=$nbQuestions; $i++){?>
                        <div class="col-md-4 question">
                            <div class="row">
                                <div class="col-md-12">
                                    <p style="text-align:center">Question n°<?php echo $i;?></p>
                                </div>
                                <div class="col-md-12 form-group">
                                    <textarea class="form-control" name="<?php echo $i;?>__question" placeholder="Saisir la question" required></textarea>
                                </div>
                                <div class="col-md-12 form-group has-success has-feedback">
                                    <input type="text" style="background: #99e599" class="form-control" name="<?php echo $i;?>__right-answer" placeholder="Réponse correct" required autocomplete="off">
                                </div>
                                <div class="col-md-12 form-group has-warning">
                                    <input type="text" style="background:#e59999" class="form-control" name="<?php echo $i;?>__wrong-answer[]" placeholder="Une mauvaise proposition" required autocomplete="off">
                                </div>
                                <div class="col-md-12 form-group has-warning">
                                    <input type="text" style="background:#e59999" class="form-control" name="<?php echo $i;?>__wrong-answer[]" placeholder="Une mauvaise proposition" required autocomplete="off">
                                </div>
                                <div class="col-md-12 form-group has-warning">
                                    <input type="text" style="background:#e59999" class="form-control" name="<?php echo $i;?>__wrong-answer[]" placeholder="Une mauvaise proposition" required autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <?php }?>
                    </div>
                </div>
            </div>
            <p style="text-align:right">        
                <button type="submit" class="btn btn-link">Terminer <i class="fa fa-arrow-right"></i></button>
            </p>
        </form>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('button#addQuestion').click(function(){
            //            $('div#questions').append('');

            $('div.question').slideDown('fast');

            $('button#removeQuestion').click(function(){
                $(this).parents('div.question').slideUp('fast', function(){
                    $(this).remove();
                });
            });

            $('html, body').animate( { scrollTop: $('footer').offset().top }, 150 ); // Go
        });

        $('button#removeQuestion').click(function(){
            $(this).parents('div.question').slideUp('fast',function(){
                $(this).remove();
            });

        });

        $('form').submit(function(){
            if($('div.question').length == 0){
                printMessage('Ajouter au moins une question wesh..', 'danger');
                return false;
            }

            $('div#questions div.question').each(function(index, e){
                console.log(index, e);


            });

            return true;
        });
    });
</script>
<style>
    #questions{

    }

    .question{
        border: 1px solid #a2a2a2; 
        padding: 10px;
        /*        margin: 10px;*/
        border-radius: 5px;
        box-shadow: 0px 0px 1px #000;
    }

</style>