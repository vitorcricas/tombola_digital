<?= $this->extend('templates/default_layout') ?>
<?= $this->section('content') ?>

<?= $this->include('templates/sidebar') ?>

<div class="container">
    <div class="row m-t-40 m-b-40">
        <h3>Bem-vindo <?php echo $user->first_name; ?>,</h3>
        <p>Já foram registadas <a href="<?php echo base_url('comerciantes/cupoes');?>"><?php echo $totalCupoes; ?> senhas</a></p>
        <?php if ( $ionAuth->isAdmin()):?>
        <p><a class="btn btn-default" href="<?php echo base_url('admin');?>"><i class="fa fa-plus"></i> &nbsp; Administração</a>
        <?php endif; ?>

        <p>Seleccione uma das opções no menu</p>
    </div>
</div>

<?= $this->endSection() ?>