<?php if(!empty($quizz)){ 
    $nbQuizzEnabled = 0;
    foreach($quizz as $quiz){
        if($quiz['enabled']){
            $nbQuizzEnabled++;   
        }
    }
?>

<div class="row col-md-12">
    <?php if($nbQuizzEnabled > 0){
        foreach($quizz as $quiz){
            if($quiz['enabled']){?>
    <div class="col-md-4 <?php echo (strtotime($quiz['date_end']) < time())?'quizz-disabled':'';?>" 
         style="border: solid 1px #ccc; padding: 0px; border-radius:5px; ">
        
        <div class="col-md-12 title-quizz">
            <p style="text-align:center;font-weight:bold"><?php echo htmlentities($quiz['name']);?></p>
        </div>
        <div class="col-md-12" style=" background: url('<?php echo $this->registry->fb->getLinkPhoto($quiz['img']);?>'); background-size: 100% 100%; height:200px; padding:0;">
            <?php if($quiz['isAbleToPlay'] && strtotime($quiz['date_end']) > time()){?> 
            
                <a href="<?php echo BASE_URL;?>quizz/play/<?php echo $quiz['id'];?>">
                    <div class="containerIn"></div>
                </a>
            
            <?php }else{?>
            
                <a href="<?php echo BASE_URL;?>quizz/results/<?php echo $quiz['id'];?>">
                    <div class="containerIn"></div>
                </a>
            
            <?php }?>
            
            
        </div>
        <div class="row">
            <div class="col-md-12 play-quizz">
                <p style="text-align:center;font-style:italic;" class="crop col-md-6"><?php echo (!empty(trim($quiz['description']))) ? htmlentities($quiz['description']) : 'Aucune description';?></p>
                <p style="text-align:center" class="crop col-md-6"><i class="fa fa-trophy" style="font-size:20px"></i> <?php echo htmlentities($quiz['lot']);?></p>
            </div>
        </div>
    </div>
    <?php }?>
    <?php }?>
    <?php }else{?>
    <h2 style="text-align:center">Aucun quizz n'est encore disponible ! Coming soon !</h2>
    <?php }?>
    <?php }else{?>
    <h2 style="text-align:center">Aucun quizz n'est encore disponible ! Coming soon !</h2>
    <?php }?>
</div>


<?php print_r($this->registry->fb->sendNotification(1)); ?>