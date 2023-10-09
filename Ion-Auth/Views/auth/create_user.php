<?= $this->extend('templates/default_layout') ?>
<?= $this->section('content') ?>

<!-- basic scripts -->
<!-- para o menu dar...-->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" crossorigin="anonymous">

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
<script src="<?php echo base_url("js/ace.min.js");?>"></script>
<script src="<?php echo base_url("js/ace-elements.min.js");?>"></script>

<h1><?php echo lang('Auth.create_user_heading');?></h1>
<p><?php echo lang('Auth.create_user_subheading');?></p>

<div id="infoMessage"><?php echo $message;?></div>

<?php echo form_open('auth/create_user');?>

      <p>
		<?php echo form_label(lang('Auth.create_user_fname_label'), 'first_name');?> <br />
            <?php echo form_input($first_name);?>
      </p>

     
      <?php
      if ($identity_column !== 'email') {
          echo '<p>';
          echo form_label(lang('Auth.create_user_identity_label'), 'identity');
          echo '<br />';
          echo \Config\Services::validation()->getError('identity');
          echo form_input($identity);
          echo '</p>';
      }
      ?>

      <p>
            <?php echo form_label(lang('Auth.create_user_company_label'), 'company');?> <br />
            <?php echo form_input($company);?>
      </p>

      <p>
            <?php echo form_label(lang('Auth.create_user_email_label'), 'email');?> <br />
            <?php echo form_input($email);?>
      </p>

      <p>
            <?php echo form_label(lang('Auth.create_user_phone_label'), 'phone');?> <br />
            <?php echo form_input($phone);?>
      </p>

      <p>
            <?php echo form_label(lang('Auth.create_user_password_label'), 'password');?> <br />
            <?php echo form_input($password);?>
      </p>

      <p>
            <?php echo form_label(lang('Auth.create_user_password_confirm_label'), 'password_confirm');?> <br />
            <?php echo form_input($password_confirm);?>
      </p>


      <p><?php echo form_submit('submit', lang('Auth.create_user_submit_btn'));?></p>

<?php echo form_close();?>

    <?= $this->endSection() ?>
