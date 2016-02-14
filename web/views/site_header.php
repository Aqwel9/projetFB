<!DOCTYPE html>
<html>
    <head>
        <title><?php echo APP_TITLE;?></title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!--        <link rel="icon" href="<?php echo BASE_URL;?>img/favicon.ico">-->
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">        

        <script src="<?php echo BASE_URL;?>js/jquery-2.2.0.min.js"></script>

        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js' ></script>

        <!-- Documentation: http://www.malot.fr/bootstrap-datetimepicker/index.php-->
        <link href="<?php echo BASE_URL;?>css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css">
        <script src="<?php echo BASE_URL;?>js/bootstrap-datetimepicker.min.js"></script>

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

        <script src="<?php echo BASE_URL;?>js/jquery.tablesorter.min.js"></script>

        <script src='<?php echo BASE_URL;?>js/nprogress.js'></script>
        <link rel='stylesheet' href='<?php echo BASE_URL;?>css/nprogress.css'/>

        <script src='<?php echo BASE_URL;?>js/sweetalert.min.js'></script>
        <link rel="stylesheet" type="text/css" href='<?php echo BASE_URL;?>css/sweetalert.css'>


        <script src='<?php echo BASE_URL;?>js/jquery.dataTables.min.js'></script>
        <!--<link rel="stylesheet" type="text/css" href='<?php echo BASE_URL;?>css/jquery.dataTables.min.css'>-->
        <link rel="stylesheet" type="text/css" href='<?php echo BASE_URL;?>css/data-table.css'>

        <script src='<?php echo BASE_URL;?>js/dataTables.buttons.min.js'></script>
        <script src='<?php echo BASE_URL;?>js/buttons.html5.min.js'></script>
        <script src='<?php echo BASE_URL;?>js/buttons.colVis.min.js'></script>
        <link rel="stylesheet" type="text/css" href='<?php echo BASE_URL;?>css/buttons.dataTables.min.css'>

        <script src='<?php echo BASE_URL;?>js/jquery.countdown360.js'></script>


        <link href="<?php echo BASE_URL;?>css/mystyle.css" rel="stylesheet" type="text/css">
        <script src="<?php echo BASE_URL;?>js/functions.js"></script>
        <script>
            setBaseUrl('<?php echo BASE_URL;?>');
        </script>
        <meta property="og:url"           content="<?php echo BASE_URL;?>" />
	    <meta property="og:type"          content="website" />
	    <meta property="og:locale"          content="fr_FR" />
	    
	    <?php if(isset($quizz['name']) && isset($quizz['description']) && isset($quizz['img'])){ ?>
            <meta property="og:title"         content="<?php echo htmlentities($quizz['name']);?>" />
            <meta property="og:description"   content="<?php echo htmlentities($quizz['description']);?>" />
            <meta property="og:image"         content="<?php echo $this->registry->fb->getLinkPhoto(htmlentities($quizz['img'])); ?>" />
	    <?php } ?>
    </head>
    <body>
        <?php if($this->registry->is_admin){?>
        <header>
            <nav class="navbar navbar-default navbar-static-top">
                <div class="container-fluid">
                    <!--BRAND MARK HEADER -->
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="<?php echo BASE_URL;?>">INVESTIGATOR</a>
                    </div>
                    <!-- ########################### -->
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav navbar-right">
                            <li class="divider"></li>
                            <li title="ajout nouveau quizz">
                                <a href="<?php echo BASE_URL;?>admin/addQuizz">
                                    <div style="text-align: center;">
                                        <i class="fa fa-plus-circle fa-2x"></i>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li title="Liste des quizzs">
                                <a href="<?php echo BASE_URL;?>admin/listQuizz">
                                    <div style="text-align: center;">
                                        <i class="fa fa-list fa-2x"></i>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li title="Liste des utilisateurs">
                                <a href="<?php echo BASE_URL;?>admin/listUser">
                                    <div style="text-align: center;">
                                        <i class="fa fa-users fa-2x"></i>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="#">
                                    <div style="text-align: center;">
                                        <i class="fa fa-trophy fa-2x"></i>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li title="Administration">
                                <a href="<?php echo BASE_URL;?>admin">
                                    <div style="text-align: center;">
                                        <i class="fa fa-cog fa-2x"></i>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>
        <?php } ?>
        <div style="margin:5px; padding:5px;">
            <?php if(isset($error)) $this->registry->myFunctions->printMessage($error, 'danger');?>
            <?php if(isset($message)) $this->registry->myFunctions->printMessage($message, 'info');?>
            <?php if(isset($success)) $this->registry->myFunctions->printMessage($success, 'success');?>