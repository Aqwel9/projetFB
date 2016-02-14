<h2 style="text-align:center">Liste des utilisateurs</h2><br>
<hr>

<div class="col-md-12">
    
    <?php if(count($players) > 0){?>
    <div class="table-responsive" style="overflow-x:initial">
        <table class="table table-bordered table-valign table-condensed table-striped highlight" id="listUser">
            <thead>
                <tr class="text-uppercase odd gradeX" name="no-hover">
                    <th>Type</th>
                    <th>ID</th>
                        <th style="display:none">Profil Facebook</th>
                    <th>Nom</th>
                    <th>Age</th>
                    <th>Genre</th>
                    <th>Lieu</th>
                    <th>Email</th>
                        <th style="display:none">Appareils</th>
                        <th style="display:none">Applications</th>
                        <th style="display:none">Livres favoris</th>
                        <th style="display:none">Artistes favoris</th>
                        <th style="display:none">Athlètes favoris</th>
                    <th>Appareils</th>
                    <th>Applications</th>
                    <th>Livres favoris</th>
                    <th>Artistes favoris</th>
                    <th>Athlètes favoris</th>
                    <th>Dernière connexion</th>
                </tr>
            </thead>
            <tbody>
                <?php
        foreach($players as $p){
            echo '
                <tr>
                    <td>'.(($p['is_admin'])? 'Admin' : 'User' ).'</td>
                    <td>'.$p['id'].'</td>
                        <td style="display:none">http://www.facebook.com/'.$p['id_fb'].'</td>
                    <td><a href="http://www.facebook.com/'.$p['id_fb'].'" target="_blank">'.$p['first_name'].' '.$p['last_name'].'</a></td>
                    <td>'.$p['birthday'].'</td>
                    <td>'.$p['gender'].'</td>
                    <td>'.$p['location'].'</td>
                    <td>'.$p['email'].'</td>
                        <td style="display:none">'.str_replace('|','&#13;',$p['devices']).'</td>
                        <td style="display:none">'.str_replace('|','&#13;',$p['application']).'</td>
                        <td style="display:none">'.str_replace('|','&#13;',$p['books']).'</td>
                        <td style="display:none">'.str_replace('|','&#13;',$p['music']).'</td>
                        <td style="display:none">'.str_replace('|','&#13;',$p['favorite_athletes']).'</td>
                    <td data-header="Appareils" data-sweet="'.$p['devices'].'"><a href="#">Afficher</a></td>
                    <td data-header="Applications" data-sweet="'.$p['application'].'"><a href="#">Afficher</a></td>
                    <td data-header="Livres" data-sweet="'.$p['books'].'"><a href="#">Afficher</a></td>
                    <td data-header="Artistes favoris" data-sweet="'.$p['music'].'"><a href="#">Afficher</a></td>
                    <td data-header="Athlètes favoris" data-sweet="'.$p['favorite_athletes'].'"><a href="#">Afficher</a></td>
                    <td>'.date('d/m/Y',strtotime($p['last_update'])).'</td>
                </tr>
           ';
        }
                ?>
            </tbody>
        </table>
    </div>
    <?php }else{?>
    <h3 style="text-align:center">Aucun joueur trouvé !</h3>
    <?php }?>
    
</div>

<style>
    tr * {
        text-align:center;
    }
</style>


<script>
    $(function(){
        $(".tablesorter").tablesorter({
            sortList: [[0,0]] 
        });
        
        $("#listUser").DataTable({
            dom: "Bfrtip",
            buttons: [
           {
                extend: 'csvHtml5',
                fieldSeparator: ';',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 18 ]
                }
            }
        ]
        });
        
        $('td[data-sweet]').click(function(){
            var data = $(this).attr("data-sweet");
            var html = "<ul style='text-align:left'>";
            data = data.split('|');
            for(var i=0;i<data.length;i++)
            {
                html += "<li>"+data[i]+"</li>";
            }
            html += "</ul>";
            swal({
                title: $(this).attr("data-header"),
                text: html,
                html: true,
                allowOutsideClick: true
            });
        });
    });
</script>