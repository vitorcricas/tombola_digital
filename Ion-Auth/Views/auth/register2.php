


        <div class="container">

            <h1><?php echo lang('Auth.register_user_heading');?></h1>
            <p><?php echo lang('Auth.register_user_subheading');?></p>

            <div id="infoMessage"><?php echo $message;?></div>

            <?php echo form_open('registar');?>

            <p>
                <?php echo form_label(lang('Auth.create_user_fname_label')."<span class='required'></span>", 'first_name');?> <br />
                <?php echo form_input($first_name);?>
            </p>

          
            <p>

                <?php echo form_label(lang('Auth.create_user_identity_label')."<span class='required'></span>", 'username');?> <br />
                <?php echo form_input($username);?>
            </p>


            <p>
                <?php echo form_label(lang('Auth.create_user_email_label')."<span class='required'></span>", 'email');?> <br />
                <?php echo form_input($email);?>
            </p>

            <p>
                <?php echo form_label(lang('Auth.create_user_phone_label'), 'telefone');?> <br />
                <?php echo form_input($telefone);?>
            </p>

              <p>
                <?php echo form_label(lang('Auth.create_user_nif_label')."<span class='required'></span>", 'nif');?> <br />
                <?php echo form_input($nif);?>
            </p>

            
            <p>
                <?php echo form_label(lang('Auth.create_user_password_label')."<span class='required'></span>", 'password');?> <br />
                <?php echo form_input($password);?>
            </p>

            <p>
                <?php echo form_label(lang('Auth.create_user_password_confirm_label')."<span class='required'></span>", 'password_confirm');?> <br />
                <?php echo form_input($password_confirm);?>
            </p>


            <p><?php echo form_submit('submit', lang('Auth.create_user_submit_btn') ,"class='btn btn-danger'");?></p>

            <?php echo form_close();?>

        </div>
