<?= $this->extend('templates/default_layout') ?>
<?= $this->section('content') ?>

<?= $this->include('templates/sidebar') ?>


<div class="container">

    <div style='height:20px;'></div>
    <a class="btn btn-default" href="<?php echo base_url('admin');?>">Voltar</a>

    <div style="padding: 10px">
        <?php echo $output; ?>
    </div>
</div>



<?= $this->endSection() ?>