<?= $this->extend('templates/default_layout') ?>
<?= $this->section('content') ?>

<?= $this->include('templates/sidebar') ?>

<div class="container">
    <div class="row m-t-40 m-b-40">
        <h3>Bem-vindo <?php echo $user->first_name; ?>,</h3>
        <p>Já inseriu <a href="<?php echo base_url('clientes/cupoes'); ?>"><?php echo $totalCupoes; ?> senhas</a></p>
        <?php if ($registration == 1) { ?>
            <p><a class="btn btn-default" href="<?php echo base_url('clientes/cupoes/add'); ?>"><i class="fa fa-plus"></i> &nbsp; Adicionar Mais Senhas</a>
            <?php } else
            echo '<div role="alert" class="alert alert-danger">'.lang('Errors.cupon_registration_closed').'</div>';
            ?>
            <p>Seleccione uma das opções no menu</p>
    </div>
</div>

<?= $this->endSection() ?>