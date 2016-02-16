<?php
class fb {
    private static $instance = null;
    private $registry;
    private $fb;


    public static function getInstance($arg) {
        if (!self::$instance instanceof self) {
            self::$instance = new self($arg);
        }
        return self::$instance;
    }

    public function __clone() {
        trigger_error('Clone is not allowed.', E_USER_ERROR);
    }

    public function __wakeup() {
        trigger_error('Deserializing is not allowed.', E_USER_ERROR);
    }

    private function __construct($registry){
        $permissions = ['user_birthday', 'user_games_activity', 'user_likes', 'user_location', 'email'];
        require_once __SITE_PATH.'/includes/facebook-php-sdk-v4-5.0.0/src/Facebook/autoload.php';
        $fb = new Facebook\Facebook([
            'app_id' => APP_ID,
            'app_secret' => APP_SECRET,
            'default_graph_version' => GRAPH_VERSION
        ]);
        $helper = $fb->getRedirectLoginHelper();
        if(empty($_SESSION['facebook_access_token'])){
            $loginUrl = $helper->getLoginUrl(BASE_URL.'scripts/login.php', $permissions);
            header('Location: '.$loginUrl);
            die();
        }else{
            if($this->tokenIsValid()){
                $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
            }else{
                $loginUrl = $helper->getLoginUrl(BASE_URL.'scripts/login.php', $permissions);
                header('Location: '.$loginUrl);
                die();
            }
        }

        $this->fb = $fb;
        $this->registry = $registry;
        $registry->is_admin = $this->is_admin($this->getCurrentUserId());
        $registry->db->insertUserInfo($this->collectUserInfo($this->getCurrentUserId()));
    }

    private function tokenIsValid(){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'https://graph.facebook.com/me?access_token='.$_SESSION['facebook_access_token']);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $return = curl_exec($curl);
        $return = json_decode($return, true);
        curl_close($curl);
        return !isset($return['error']);
    }

    public function get_roles(){
        try{
            $response = $this->fb->get('/'.APP_ID.'/roles', APP_ACCESS_TOKEN);
        }catch(Facebook\Exceptions\FacebookResponseException $e){
            echo $e->getMessage();
            exit;
        }
        return $response->getGraphEdge()->asArray();
    }

    public function getCurrentUserId(){
        try{
            $response = $this->fb->get('/me')->getGraphUser()->AsArray();
        }catch(Facebook\Exceptions\FacebookResponseException $e){
            echo $e->getMessage();
            exit;
        }
        return $response['id'];
    }

    public function is_admin($id_user){
        $admins = $this->get_roles();
        foreach($admins as $admin){
            if($admin['role'] == 'administrators'){
                if($admin['user'] == $id_user){
                    return true;
                }
            }
        }
        return false;
    }

    private function collectUserInfo($id_user){
        $return = [];
        $user = [];
        
        $perm = ['first_name','last_name','birthday','gender','location','devices','email','books','music','favorite_athletes','application'];
        $perm = array_fill_keys($perm,'');

        if($this->registry->is_admin)
            $return['is_admin'] = 1;
        else
            $return['is_admin'] = 0;

        try{
            $user_data = $this->fb->get('/'.$id_user.'?fields=first_name,last_name,birthday,gender,location,devices,email')->getGraphUser()->AsArray();
        }catch(Facebook\Exceptions\FacebookResponseException $e){
            echo $e->getMessage();
            exit;
        }

        try{
            $user_likes = $this->fb->get('/'.$id_user.'?fields=books{name},music{name},favorite_athletes,scores{application{name}}')->getGraphUser()->AsArray();
        }catch(Facebook\Exceptions\FacebookResponseException $e){
            echo $e->getMessage();
            exit;
        }

        foreach($user_data as $key => $data){
            if($data instanceof DateTime)
            {
                $return[$key] = $data->format('Y-m-d');
            }
            elseif(is_array($data))
            {
                foreach($data as $k => $v)
                {
                    if(is_array($v))
                    {
                        foreach($v as $cle => $val)
                        {
                            if(isset($return[$cle]))
                                $return[$key] .= '|'.$val; 
                            else
                                $return[$key] = $val;
                        }
                    }
                    elseif($k != 'id')
                        $return[$key] = $v;
                }
            }
            elseif($key != 'id')
                $return[$key] = $data;
        }
        // M'en veux pas Younes je sais que c'est moche <3
        foreach($user_likes as $k => $v)
        {
            if(is_array($v))
            {
                foreach($v as $kk => $vv)
                {
                    foreach($vv as $kkk => $vvv)
                    {
                        if(is_array($vvv))
                        {
                            foreach($vvv as $kkkk => $vvvv)
                            {
                                if($kkk != 'user' && $kkkk != 'id')
                                {
                                    if(isset($return[$kkk]))
                                        $return[$kkk] .= '|'.$vvvv; 
                                    else
                                        $return[$kkk] = $vvvv;
                                }
                            }
                        }
                        else
                        {
                            if($kkk != 'id')
                            {
                                if(isset($return[$k]))
                                    $return[$k] .= '|'.$vvv; 
                                else
                                    $return[$k] = $vvv;
                            }
                        }
                    }
                }
            }
        }

        $return['last_update'] = date('Y-m-d H:i:s');
        $return['id_fb'] = $id_user;
        
        $diff = array_diff_key($perm,$return)
        
        $user['is_admin'] = $return['is_admin'];
        foreach($perm as $k => $v)
        {
            if(array_key_exists($k,$return)){
                $user[$k] = $return[$k];
            }else $user[$k] = '';
        }
        $user['last_update'] = $return['last_update']
        $user['id_fb'] = $return['id_fb']

        /*var_dump($return);
        echo "<br><hr><br>";
        var_dump($user_data);*/

        return $user;
    }

    public function addPermission($new_perm){
        $permissions = $this->fb->get('/me/permissions')->getGraphEdge()->asArray();
        $helper = $this->fb->getRedirectLoginHelper();
        $$new_perm = false;
        foreach($permissions as $permission){
            if($permission['permission'] == $new_perm && $permission['status'] != 'granted'){
                header("Location: ".$helper->getLoginUrl(BASE_URL.'scripts/login.php', ['scope' => $new_perm]));
            }
            if($permission['permission'] == $new_perm){
                $$new_perm = true;
            }
        }
        if(!$$new_perm){
            header("Location: ".$helper->getLoginUrl(BASE_URL.'scripts/login.php', ['scope' => $new_perm]));
        }
    }

    public function uploadImageQuizz($file, $comment){
        $data = [
            'message' => $comment,
            'source' => $this->fb->fileToUpload($file['tmp_name'])
        ];

        try{
            $response = $this->fb->get('/'.FAN_PAGE_ID.'?fields=access_token')->getGraphUser()->AsArray();
        }catch(Facebook\Exceptions\FacebookResponseException $e){
            return false;
            //            return $e->getMessage();
            exit;
        }
        $fan_access_token = $response['access_token'];

        try{
            $response = $this->fb->post('/'.FAN_ALBUM_QUIZZ_ID.'/photos', $data, $fan_access_token);
            $graphNode = $response->getGraphNode();
            return $graphNode['id'];
        }catch(FacebookSDKException $e){
            return false;
            //            return $e->getMessage();
        }
    }

    public function getLinkPhoto($idPhoto){
        try{
            $response = $this->fb->get('/'.$idPhoto.'?fields=images')->getGraphUser()->AsArray();
            return $response['images'][0]['source'];
        }catch(Facebook\Exceptions\FacebookResponseException $e){
            //            return false;
            return $e->getMessage();
            exit;
        }
    }
    
    public function sendNotification($idQuizz){
        /*$quizz = $this->registry->db->getInfoQuizz($idQuizz);
        $quizzName = $quizz[$idQuizz]['name'];
        $listUser = $this->registry->db->getResultsByIdQuizz($idQuizz);
        foreach($listUser as $id => $val)
        {
            $this->fb->post('/'.$id.'/notifications?access_token='.APP_ACCESS_TOKEN.'&amp;template=Les résultats du quizz '.$quizzName.' sont arrivés !&amp;href='.BASE_URL.'results/'.$idQuizz);
        }*/
        
        $this->fb->post('/me/notifications', ['access_token' => $_SESSION['facebook_access_token']], ['template' => 'Les résultats du quizz sont arrivés !'], ['href' => BASE_URL.'results/'.$idQuizz]);
    }

    public function getProfilePicture($idPlayer){
        
        $idFb = $this->registry->db->getIdFbByUserId($idPlayer);
        
        try{
            $response = $this->fb->get('/'.$idFb.'?fields=picture')->getGraphUser()->AsArray();
            return $response['picture']['url'];
        }catch(Facebook\Exceptions\FacebookResponseException $e){
            //            return false;
            return $e->getMessage();
            exit;
        }
    }
    
}