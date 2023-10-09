<?= $this->extend('templates/default_layout') ?>
<?= $this->section('content') ?>

<?= $this->include('templates/sidebar') ?>


<div class="container">
    <div style='height:20px;'></div>
    <div style="padding: 10px">

    <a class="btn btn-default" href="<?php echo base_url("auth/backoffice/"); ?>">Utilizadores</a>
    <a class="btn btn-default" href="<?php echo base_url("admin/settings/"); ?>">Definições</a>

    <a class="btn btn-default"  href="<?php echo base_url("admin/logs/"); ?>">Logs</a>

    </div>
</div>


<?= $this->endSection() ?>