<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '<?php echo APP_ID; ?>',
      xfbml      : true,
      version    : '<?php echo GRAPH_VERSION; ?>'
    });
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/fr_FR/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
</script>
  
<div class="col-md-8 col-md-offset-2" style="background:rgba(248, 248, 248, 0.37); border-radius:5px; border:solid 1px #eee;">
    <section id="quizz" data-id-quizz="<?php echo $this->registry->router->args[0];?>">
        <div data-id-fb="<?php echo $idFb;?>" style="display:none"></div>
        <div class="row" style="margin-bottom:30px;">
            <div class="col-md-12">
                <div id="number-question-status" style="float:right"></div>
                <div class="col-md-3">
                    <div><div id="countdown" style="text-align:center"></div></div>
                </div>
                <div class="col-md-9">
                    <div id="question" class="col-md-12" data-id-question=""></div>
                </div>
            </div>
        </div>
        <div id="row">
            <div class="text-center col-lg-6">
                <div class="classWithPad">
                    <button data-nb="1" data-state="false" type="button" class="btn btn-default reponse btn-lg" data-id-proposition=""></button>
                </div>
            </div>
            <div class="text-center col-lg-6">
                <div class="classWithPad">
                    <button data-nb="2" data-state="false" type="button"class="btn btn-default reponse btn-lg" data-id-proposition=""></button>
                </div>
            </div>
                
            <div class="text-center col-lg-6">
                <div class="classWithPad">
                    <button data-nb="3" data-state="false" type="button" class="btn btn-default reponse btn-lg" data-id-proposition=""></button>
                </div>
            </div>
            <div class="text-center col-lg-6">
                <div class="classWithPad">        
                    <button data-nb="4" data-state="false" type="button"class="btn btn-default reponse btn-lg" data-id-proposition=""></button>
                </div>
            </div>

        </div>
    </section>
</div>

<style>
    /* temporaire avant qu'Axel fasse les modif*/
    section#quizz{
        padding: 10px;
        display: none;
    }
    div#question{
        font-weight: bold;
    }
    div#number-question-status{
        margin-bottom:30px;
        font-weight: bold;
    }
    ol#reponses li.reponse button{
        width:100%;
    }  
    button.reponse { 
        width:100%;
    }
    
    button.cancel { 
        padding-left:5px;
        padding-right:5px;
    }
    
    button.confirm { 
        padding-left:5px;
        padding-right:5px;
    }
    
    .sweet-alert { 
        padding-top:0;
        margin-top:0px !important;
        top:10% !important;
        overflow-y:scroll
    }
</style>
<script>
    $(document).ready(function(){
        //Si le quizz n'a jamais été fait
        var quizz = undefined;
        var welcome_message = "<p>Répondez correctement aux <b><?php echo htmlentities($quizz['questions_nb_displayed']);?></b> questions en un minimum de temps pour tenter de remporter <br><b>\"<?php echo htmlentities($quizz['lot']);?>\"</b> !</p><p>Bonne chance, et que le meilleur gagne !</p>";
        var availability = "<div class='col-md-12'></div> <div class='col-md-5'><b><?php echo DateTime::createFromFormat('Y-m-d H:i:s', $quizz['date_start'])->format('d/m/Y H:i:s');?></b></div><div class='col-md-2'><i class='fa fa-calendar'></i></div><div class='col-md-5'><b><?php echo DateTime::createFromFormat('Y-m-d H:i:s', $quizz['date_end'])->format('d/m/Y H:i:s');?></b></div>";
        swal({
            title: "",
            text: "<div class='col-md-12'><b><?php echo htmlentities($quizz['name']);?></b><hr><div class='row' style='font-style:italic;font-size:14px'>"+availability+"</div><hr><?php echo htmlentities($quizz['description']);?><br><p>"+welcome_message+"</p><br><p></p></div>",
            showCancelButton: true,
            confirmButtonText: "Charger le quizz",
            cancelButtonText: "Retour",
            closeOnConfirm: false,
            closeOnCancel: false,
            allowEscapeKey: false,
            html: true,
            showLoaderOnConfirm: true
        }, function(isConfirm){
            if(isConfirm){
                //lancer le quizz
                $.ajax({
                    url: base_url+'ajax/getQuizzById',
                    method: 'POST',
                    data: { id: '<?php echo $this->registry->router->args[0];?>' },
                    dataType: 'JSON'
                }).done(function(data, textStatus, jqXHR){
                    swal({
                        title: "Quizz chargé !",
                        text: "Le quizz a été correctement chargé. Cliquer sur \"Commencer\" pour démarrer le quizz et lancer le compte à rebours",
                        type: "success",
                        confirmButtonText: "Commencer",
                        allowEscapeKey: false,
                        closeOnConfirm: true
                    },function(){
                        window.onbeforeunload = function(){ return "Attention, si vous quittez la partie, vous confirmez déclarer forfait et obtiendrez 0 pour ce quizz."};
                        launchQuizz(data.quizz);
                    });
                }).fail(function(jqXHR, textStatus, errorThrown){
                    console.error("{"+jqXHR.responseText+"}");
                    console.error(textStatus);
                    console.error(errorThrown);
                });

            }else{
                //redirection vers la page d'accueil
                NProgress.start();
                document.location.href = base_url;
            }
        });
    });
</script>
