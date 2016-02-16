<div>
    <div class="row" id="title">
        <div class="col-md-12">
            <h4 style="text-align:center">Ajout d'un nouveau Quizz !</h4>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-3" style="text-align:center">
            <p style="font-size: 40px;">1</p>
            <p>Création du Quizz</p>
        </div>
        <div class="col-md-3" style="text-align:center;color:#d4d4d4">            
            <p style="font-size: 40px;">2</p>
            <p>Ajout des questions</p>
        </div>
        <div class="col-md-3"></div>
    </div>
    <hr>
    
    <div class="col-md-12">
        
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="quizz-name">Nom du quizz</label>
                        <input type="text" class="form-control" id="quizz-name" name="quizz-name" placeholder="Nom" required autocomplete="off" value="<?php echo ((isset($_POST['quizz-name']))? $_POST['quizz-name']: '');?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="nbQuestions">Nombre de questions total</label>
                        <input type="number" class="form-control" min="1" max="30" value="<?php echo ((isset($_POST['quizz-nbQuestions']))? $_POST['quizz-nbQuestions']: '10');?>" name="quizz-nbQuestions" id="nbQuestions" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="nbQuestionsDisplayed">Nombre de questions à afficher</label>
                        <input type="number" class="form-control" min="1" max="10" value="<?php echo ((isset($_POST['quizz-nbQuestionsDisplayed']))? $_POST['quizz-nbQuestionsDisplayed']: '');?>" name="quizz-nbQuestionsDisplayed" id="nbQuestionsDisplayed" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="quizz-lot">Lot à gagner</label>
                        <textarea id="quizz-lot" name="quizz-lot" placeholder="Lot..." class="form-control" rows="3" required></textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="quizz-description">Description (optional)</label>
                        <textarea id="quizz-description" name="quizz-description" placeholder="Description..." class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="quizz-start-datetime">Date de début</label>
                        <div class="input-append date">
                            <input size="16" type="text" value="<?php echo ((isset($_POST['quizz-start-datetime']))? $_POST['quizz-start-datetime']: '');?>" name="quizz-start-datetime" id="quizz-start-datetime" readonly class="form-control form_datetime" placeholder="Cliquer pour ouvrir le calendrier..." required>
                            <span class="add-on"><i class="icon-th"></i></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="quizz-end-datetime">Date de fin</label>
                        <div class="input-append date">
                            <input size="16" type="text" value="<?php echo ((isset($_POST['quizz-end-datetime']))? $_POST['quizz-end-datetime']: '');?>" name="quizz-end-datetime" id="quizz-end-datetime" readonly class="form-control form_datetime" placeholder="Cliquer pour ouvrir le calendrier..." required>
                            <span class="add-on"><i class="icon-th"></i></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="image">Image</label>
                        <input type="file" class="form-control" name="quizz-image" id="image" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <br>
                    <button type="submit" name="submit" class="btn btn-success" style="width:100%">
                        <i class="fa fa-arrow-circle-right" style="font-size:30px"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    $(document).ready(function(){
        //configurations générales des 2 datetimepicker
        $(".form_datetime").datetimepicker({
            format: "dd/mm/yyyy hh:ii",
            autoclose: true,
            todayBtn: true,
            weekStart: 1,
            startDate: new Date(),
            todayHighlight: false,
            minuteStep: 5
        });
        //configuration du 1er datetimepicker
        $('#quizz-start-datetime').datetimepicker().on('changeDate', function(ev){
            $('#quizz-end-datetime').datetimepicker('setStartDate', ev.date);
        });
        //configuration du 2ème datetimepicker
        $('#quizz-end-datetime').datetimepicker().on('changeDate', function(ev){

        });

        //quand on remplie un champ
        $('#quizz-name, #quizz-start-datetime, #quizz-end-datetime').change(function(){
            $(this).css('border', '1px solid #CCC');
        });

        $('#nbQuestions').change(function(){
            $('#nbQuestionsDisplayed').attr('max', $('#nbQuestions').val());
        });

        //vérification JS du formulaire
        $('form').submit(function(){
            //check si le nom du quizz n'est pas vide
            if($('#quizz-name').val().trim() == ''){
                $('#quizz-name').css('border', '1px solid #F00');
                $('#quizz-name').attr('placeholder', 'Veuillez saisir un nom');
                return false;
            };
            //check is la date du début n'est pas vide
            if($('#quizz-start-datetime').val().trim() == ''){
                $('#quizz-start-datetime').css('border', '1px solid #F00');
                $('#quizz-start-datetime').attr('placeholder', 'Veuillez saisir une date de debut');
                return false;
            }
            //check is la date de fin n'est pas vide
            if($('#quizz-end-datetime').val().trim() == ''){
                $('#quizz-end-datetime').css('border', '1px solid #F00');
                $('#quizz-end-datetime').attr('placeholder', 'Veuillez saisir une date de fin');
                return false;
            }

            return true;
        });
    });
</script>