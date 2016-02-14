<h2 style="text-align:center">Liste des Quizzs</h2><br>
<hr>

<div class="col-md-12">

    <?php if(count($quizz) > 0){?>
    <div class="table-responsive">
        <table class="table table-bordered nowrap table-valign table-condensed table-striped highlight" width="100%">
            <thead>
                <tr class="text-uppercase odd gradeX" name="no-hover">
                    <th>Etat</th>
                    <th>Identifiant</th>
                    <th>Nom</th>
                    <th>Description</th>
                    <th>Lot à gagner</th>
                    <th>Date de début</th>
                    <th>Date de fin</th>
                    <th>Nombre de questions affichées</th>
                    <th>Nombre de questions totales</th>
                    <th>Editer</th>
                </tr>
            </thead>
            <tbody>
                <?php
        foreach($quizz as $q){
            echo '
                <tr '.((!$q['enabled'])? 'class=warning' : '' ).'>
                    <td>'.(($q['enabled'])? 'Activé' : 'Désactivé' ).'</td>
                    <td>'.htmlentities($q['id']).'</td>
                    <td>'.htmlentities(substr($q['name'], 0, 100)).'</td>
                    <td>'.htmlentities(substr($q['description'], 0, 100)).'</td>
                    <td>'.htmlentities(substr($q['lot'], 0, 100)).'</td>
                    <td>'.htmlentities(substr($q['date_start'], 0, 100)).'</td>
                    <td>'.htmlentities(substr($q['date_end'], 0, 100)).'</td>
                    <td>'.htmlentities(substr($q['questions_nb_displayed'], 0, 100)).'</td>
                    <td>'.htmlentities(substr($q['questions_nb_total'], 0, 100)).'</td>
                    <td><a href="'.BASE_URL.'admin/editQuizz/'.$q['id'].'"><i class="fa fa-pencil-square-o"></i></a></td>
                </tr>
           ';
        }
                ?>
            </tbody>
        </table>
    </div>
    <?php }else{?>
    <h3 style="text-align:center">Aucun quizz trouvé ! Créer un nouveau <a href="<?php echo BASE_URL;?>admin/addQuizz">ici</a></h3>
    <?php }?>
    
</div>

<style>
    tr * {
        text-align:center;
    }
</style>


<script>
    $(function(){
        $(".table").DataTable();
    });
</script>