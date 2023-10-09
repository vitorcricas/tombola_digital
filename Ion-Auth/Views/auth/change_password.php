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

<h1><?php echo lang('Auth.change_password_heading');?></h1>

<div id="infoMessage"><?php echo $message;?></div>

<?php echo form_open('auth/change_password');?>

      <p>
            <?php echo form_label(lang('Auth.change_password_old_password_label'), 'old_password');?> <br />
            <?php echo form_input($old_password);?>
      </p>

      <p>
            <label for="new_password"><?php echo sprintf(lang('Auth.change_password_new_password_label'), $minPasswordLength);?></label> <br />
            <?php echo form_input($new_password);?>
      </p>

      <p>
            <?php echo form_label(lang('Auth.change_password_new_password_confirm_label'), 'new_password_confirm');?> <br />
            <?php echo form_input($new_password_confirm);?>
      </p>

      <?php echo form_input($user_id);?>
      <p><?php echo form_submit('submit', lang('Auth.change_password_submit_btn'));?></p>

<?php echo form_close();?>
