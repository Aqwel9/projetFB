var base_url = '';
var questionsIdUnCompleted = new Array();
var isAnswerSet = false;
$(document).ready(function(){
    $(".nav li a")
        .filter(function () {
            var val = false;
            var actual = location.href;
            actual = actual.split("/");
            catName = actual[3].split("?");
            if (location.href == this.href || this.href == window.location.protocol + '//' + actual[2] + '/' + catName[0]) {
                val = true;
            }
            return val;
        })
        .parents()
        .addClass("active");  
    
    $(".highlight tr").on("mouseover", function () {
        if ($(this).attr("name") != "no-hover") {
            $(this).css("opacity", 0.5);

        }
    }).on("mouseout", function () {

        $(this).css("opacity", 1);
    });
});



function setBaseUrl(url){
    base_url = url;   
}

function htmlEntities(str) {
    return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
}

function printMessage(message, level){
    $('header').after('<div class="alert alert-'+level+' alert-dismissible fade in" style="display:none" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>'+htmlEntities(message)+'</div>');

    $('.alert').show('fast');
}

function updateQuestion(idQuestion, idPropositions, question){
    NProgress.start();
    $.ajax({
        url: base_url+'ajax/updateQuestion',
        method: 'POST',
        data: { idQuestion: idQuestion, idPropositions: idPropositions },
        dataType: 'JSON'
    }).done(function(data, textStatus, jqXHR){
        $('p#question_'+question).html(htmlEntities($("div[data-id-question='"+question+"'] input[data-id-question]").val()));
    }).fail(function(jqXHR, textStatus, errorThrown){
        console.error("{"+jqXHR.responseText+"}");
        console.error(textStatus);
        console.error(errorThrown);
    }).always(function(){
        NProgress.done();
    });
}

function launchQuizz(quizz){
    for(question in quizz.questions){
        questionsIdUnCompleted.push(parseInt(question));
    }
    setQuestion(quizz);
}

function setQuestion(quizz){
    //choix de la question
    //traitement anti doublon pour le choix de la question
    var randomIdQuestion = questionsIdUnCompleted[getRandomArbitrary(0, questionsIdUnCompleted.length)];
    var index = questionsIdUnCompleted.indexOf(randomIdQuestion);
    if(index > -1){
        questionsIdUnCompleted.splice(index, 1);
    }
    //initialisation du countdown
    var countdown = $("#countdown").countdown360({
        radius: 60,
        seconds: 5,
        label: false,
        fontColor: '#FFFFFF',
        autostart: false,
        onComplete: function(){
            setAnswer(quizz, null, $('[data-id-quizz]').attr('data-id-quizz'), $('[data-id-question]').attr('data-id-question'), null, null);
        }
    });
    //insertion des données
    $("#quizz").fadeOut('slow', function(){
        $('#question').attr('data-id-question', randomIdQuestion).text(quizz.questions[randomIdQuestion].question);
        $('#number-question-status').text((quizz.questions_nb_total - questionsIdUnCompleted.length) +"/"+quizz.questions_nb_displayed);
        //choix des réponses
        //traitement anti doublon pour le choix de la réponse
        var reponsesIdStillUnDisplayed = new Array();
        for(proposition in quizz.questions[randomIdQuestion].propositions){
            reponsesIdStillUnDisplayed.push(parseInt(proposition));
        }
        $('button[data-nb]').each(function(i, e){
            $(this).text("");
            $(this).unbind("click");
            $(this).removeClass('btn-success').addClass('btn-default');
            $(this).removeClass('btn-danger').addClass('btn-default');
        });

        $('button[data-nb]').each(function(i, e){
            if($(this).text() == ""){
                var randomValue = getRandomArbitrary(0, reponsesIdStillUnDisplayed.length);
                $(this).attr('data-id-proposition', reponsesIdStillUnDisplayed[randomValue]);
                $(this).text(quizz.questions[randomIdQuestion].propositions[reponsesIdStillUnDisplayed[randomValue]].proposition);
                var index = reponsesIdStillUnDisplayed.indexOf(reponsesIdStillUnDisplayed[randomValue]);
                if(index > -1){
                    reponsesIdStillUnDisplayed.splice(index, 1);
                }
                $(this).prop("disabled", false);
                $(this).click(function(){
                    setAnswer(quizz, countdown, $('[data-id-quizz]').attr('data-id-quizz'), $('[data-id-question]').attr('data-id-question'), $(this).attr('data-id-proposition'), $(this));
                });
            }
        });

        $("#quizz").fadeIn('slow');
        countdown.start();
    });
}

function setAnswer(quizz, countdown, idQuizz, idQuestion, idProposition, button){
    var time = 10000;
    isAnswerSet = false;
    
    if(countdown != null){
        countdown.stop();
        time = countdown.getElapsedTimeMs();
    }

    var idFb = $('[data-id-fb]').attr('data-id-fb');

    if(button != null){
        if(quizz.questions[idQuestion].propositions[idProposition].is_correct == 1){
            button.removeClass('btn-default').addClass('btn-success');
        }else{
            button.removeClass('btn-default').addClass('btn-danger');
            $('button[data-nb]').each(function(i, e){
                if(quizz.questions[idQuestion].propositions[$(this).attr('data-id-proposition')].is_correct == 1){
                    $(this).removeClass('btn-default').addClass('btn-success');
                }
            });
        }
        nextQuestion(quizz);
    }else{
        $('button[data-nb]').each(function(i, e){
            if(quizz.questions[idQuestion].propositions[$(this).attr('data-id-proposition')].is_correct == 1){
                $(this).removeClass('btn-default').addClass('btn-success');
            }
        });
        nextQuestion(quizz);
    }

    $.ajax({
        url: base_url+'ajax/insertAnswer',
        method: 'POST',
        data: { idQuizz: idQuizz, idQuestion: idQuestion, idProposition: idProposition, idFb: idFb, time: time },
        dataType: 'JSON'
    }).done(function(data, textStatus, jqXHR){
        isAnswerSet = true;
        if(!data['success']){
            printMessage("Une erreur est survenu lors de l'enregistrement de votre réponse", "danger");
            console.error(data['message']);
        }
    }).fail(function(jqXHR, textStatus, errorThrown){
        console.error(jqXHR);
    });
}

function nextQuestion(quizz){
    $('button[data-nb]').each(function(i, e){
        $(this).prop("disabled", true);
        $(this).unbind("unclick");
    });
    if((quizz.questions_nb_total - quizz.questions_nb_displayed) != questionsIdUnCompleted.length){
        setTimeout(function(){
            setQuestion(quizz)
        }, 2000);
    }else endOfQuizz(quizz);
}

function endOfQuizz(quizz){
    NProgress.start();
    if(isAnswerSet == true){
        window.onbeforeunload = null;
        console.info('Fin du quizz');
        var idQuizz = $('[data-id-quizz]').attr('data-id-quizz');
        var idFb = $('[data-id-fb]').attr('data-id-fb');
        var quizzName = 

        // Modification de la page
        $('#quizz').empty();

        // On récupère le score
        $.ajax({
            url: base_url+'ajax/getPlayerScore',
            method: 'POST',
            data: { idQuizz: idQuizz, idFb: idFb },
            dataType: 'JSON'
        }).done(function(data, textStatus, jqXHR){
            $("#quizz").html('<h3 style="text-align:center">Félicitations, vous avez obtenu un score de <b>'+data.message+'</b> !</h3><br><p style="text-align:center">N\'hésitez pas à partager votre score avec vos amis en cliquant sur le bouton ci-dessous : </p><br><button class="fb-share-button-style" onclick="shareFacebook();"><h2><i class="fa fa-facebook-official"></i> Partager !</h2></button>');
            NProgress.done();
        }).fail(function(jqXHR, textStatus, errorThrown){
            console.error(jqXHR);
            NProgress.done();
        });
    }else{
        setTimeout(function(){
            endOfQuizz();
        }, 100);   
    }
}

function getRandomArbitrary(min, max) {
    return Math.floor(Math.random() * (max - min)) + min;
}

function shareFacebook(){
    FB.ui({
      method: 'share',
      href: base_url,
    }, function(response){
        location.reload();
    });
}