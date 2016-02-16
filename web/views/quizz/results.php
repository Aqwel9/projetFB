<div id="fb-root"></div>
<script>
    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/fr_FR/sdk.js#xfbml=1&version=<?php echo GRAPH_VERSION;?>&appId=<?php echo APP_ID;?>";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>

<?php
if(strtotime($quizz['date_end']) < time()){ ?>
<h2 style="text-align:center">Résultats du quizz <?php echo $quizz['name'];?></h2><br>
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Rang</th>
                <th>Nom</th>
                <th>Score</th>
            </tr>
        </thead>
        <tbody>
            <?php
                                           if(count($results)>0){
                                               $i = 1;
                                               $topten = $results;
                                               if(count($topten)>10){
                                                   $topten = array_slice($topten,0,10);
                                               }
                                               foreach($topten as $p){
                                                   echo '
                                                    <tr'.(($p['id_player'] == $idPlayer)? ' class="you"' : '' ).'>
                                                        <td'.(($i == 1)? ' id="first"' : '' ).'>'.$i.' '.(($i == 1)? '<i class="fa fa-trophy"></i> ': '').'</td>
                                                        <td><img src="'.$this->registry->fb->getProfilePicture($p['id_player']).'" alt="" class="img-circle"> '.$p['first_name'].' '.$p['last_name'].'</td>
                                                        <td>'.$p['total'].'</td>
                                                    </tr>
                                               ';
                                                   $i++;
                                               }
                                               if(!array_key_exists($idPlayer,$topten) && !empty($myresults)){
                                                   $results = array_values($results);
                                                   $player = array_search($idPlayer,$results);
                                                   echo '
                                                <tr><td colspan="3">...</td></tr>
                                                <tr class="you">
                                                    <td>'.($player++).'</td>
                                                    <td><img src="'.$this->registry->fb->getProfilePicture($p['id_player']).'" alt="" class="img-circle"> '.$results[$player]['first_name'].' '.$results[$player]['last_name'].'</td>
                                                    <td>'.$results[$player]['total'].'</td>
                                                </tr>
                                            ';
                                               }
                                           }else{
                                               echo '<tr><td colspan="3" style="text-align:center;font-style:italic">Aucun participant</td></tr>';   
                                           }
            ?>
        </tbody>
    </table>
</div>
<style>
    @keyframes blink { 
        50% {
            color: #b757ff;
        }
    }
    .you{
        animation: blink .5s step-end infinite alternate;
        -webkit-animation: blink .5s step-end infinite alternate;
    }
    #first, #first + td, #first +td + td{
        color: #FFD700;
    }
</style>
<?php }else{ ?>
<div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-6"  style="text-align:center">
        <p><?php echo $quizz['name'];?></p>
        <img style="display:block; margin-left:auto; margin-right:auto;width:80%" src="<?php echo $this->registry->fb->getLinkPhoto($quizz['img']);?>" class="img-responsive" alt="<?php echo $quizz['name'];?>">
        <a href="http://www.facebook.com/share.php?u=<?php echo BASE_URL;?>&title=J'ai eu <?php echo $myresults[$idPlayer]['total'].' point'.(($myresults[$idPlayer]['total'] > 1) ? 's' : '');?> au quizz: <?php echo $quizz['name'];?>. Et toi?" class="btn btn-block btn-social btn-facebook" style="display:block; margin-left:auto; margin-right:auto;width:80%" target="_blank">
            <span class="fa fa-facebook"></span> Partager mon score !
        </a>
        <h3 style="font-weight:bold"><?php echo $myresults[$idPlayer]['total'].' point'.(($myresults[$idPlayer]['total'] > 1) ? 's' : '');?></h3>
        <p> Les résultats seront disponibles dès la fin du quizz, le <b><?php echo date('d/m/Y à H:i', strtotime($quizz['date_end']));?></b> </p>
        <p>Vous recevrez une notification pour vous prévenir de la publication des résultats et savoir si vous avez gagné <b><?php echo $quizz['lot']; ?></b>... </p>
        <p>Restez branchés !</p>
        <!-- <div class="fb-share-button" data-href="<?php echo BASE_URL;?>" data-layout="button"></div>-->
    </div>
    <div class="col-md-3"></div>
</div>

<?php } ?>