<!DOCTYPE html>
<html>
    <head>
        <title><?php echo APP_TITLE;?> - Test</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="<?php echo BASE_URL;?>img/favicon.ico">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">        

        <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>

        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js' ></script>

       <!-- Documentation: http://www.malot.fr/bootstrap-datetimepicker/index.php-->
        <link href="<?php echo BASE_URL;?>css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css">
        <script src="<?php echo BASE_URL;?>js/bootstrap-datetimepicker.min.js"></script>

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
        
        <script src="<?php echo BASE_URL;?>js/jquery.tablesorter.min.js"></script>

        <link href="<?php echo BASE_URL;?>css/mystyle.css" rel="stylesheet" type="text/css">
        <script src="<?php echo BASE_URL;?>js/functions.js"></script>
        <script>
            setBaseUrl('<?php echo BASE_URL;?>');
        </script>
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
                            <li class="active"><a href="#"><i class="fa fa-gamepad fa-2x"></i></a></li>
                            <li><a href="#"><i class="fa fa-trophy fa-2x"></i></a></li>
                            <li><a href="<?php echo BASE_URL;?>admin"><i class="fa fa-cog fa-2x"></i></a></li>
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