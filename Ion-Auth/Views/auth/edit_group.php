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

<h1><?php echo lang('Auth.edit_group_heading');?></h1>
<p><?php echo lang('Auth.edit_group_subheading');?></p>

<div id="infoMessage"><?php echo $message;?></div>

<?php echo form_open(current_url());?>

      <p>
            <?php echo form_label(lang('Auth.edit_group_name_label'), 'group_name');?> <br />
            <?php echo form_input($group_name);?>
      </p>

      <p>
            <?php echo form_label(lang('Auth.edit_group_desc_label'), 'description');?> <br />
            <?php echo form_input($group_description);?>
      </p>

      <p><?php echo form_submit('submit', lang('Auth.edit_group_submit_btn'));?></p>

<?php echo form_close();?>

    <?= $this->endSection() ?>
