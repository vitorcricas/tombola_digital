<!DOCTYPE html>
<html lang="pt">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta charset="utf-8" />
        <title>Plantas Online / Backoffice - <?php echo $title;?></title>

        <meta name="description" content="overview & stats" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

        <!-- basic scripts -->
        <!-- para o menu dar...-->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" crossorigin="anonymous">
        <link rel="stylesheet" href="<?php echo base_url("css/login2.css");?>" class="theme-stylesheet" id="theme-style" />

        <link rel="stylesheet" href="<?php echo base_url("css/bootstrap.min.css");?>" />

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css?family=Libre+Franklin:400,500,600" rel="stylesheet">

        <style>
            .required:after {
                content:" *";
                color: red;
            }
        </style>

        <script
                src="https://code.jquery.com/jquery-2.2.4.min.js"
                integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
                crossorigin="anonymous"></script>	
        <script src="<?php echo base_url("js/bootstrap.min.js");?>"></script>

    </head>



    <div class="header" id="headerOne" style="height:140px;">
        <a href="http://pol.cm-mealhada.pt/"><img title="Voltar ao portal" style="position:absolute; left:50px;" src="<?php echo base_url("images/logo.png");?>" width="300px" align="middle"></a>
        <span style="position:absolute; right:40px;"><img  src="<?php echo base_url("images/cmm_vertical.png");?>">  </span>
    </div>
    <body>


        <div class="wrapper fadeInDown">
            <div id="formContent">

                <h1><?php echo lang('Auth.reset_password_heading');?></h1>

                <div id="infoMessage"><?php echo $message;?></div>

                <?php echo form_open('auth/reset_password/' . $code);?>

                <div class="row">
                    <div class="form-group">
                        <div class=" col-md-6">

                            <label for="new_password"><?php echo sprintf(lang('Auth.reset_password_new_password_label'), $minPasswordLength);?></label> <br />
                            <?php echo form_input($new_password);?>
                        </div>

                        <div class=" col-md-6">
                            <?php echo form_label(lang('Auth.reset_password_new_password_confirm_label'), 'new_password_confirm');?> <br />
                            <?php echo form_input($new_password_confirm);?>
                        </div>
                    </div>
                </div>

                <?php echo form_input($user_id);?>

                <div class="form-group">
                    <?php echo form_submit('submit', lang('Auth.reset_password_submit_btn'),  'class="btn btn-success"');?>
                </div>

                <?php echo form_close();?>

            </div>

        </div>

    </body>

</html>
