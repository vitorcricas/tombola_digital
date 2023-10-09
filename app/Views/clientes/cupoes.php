<?= $this->extend('templates/default_layout') ?>
<?= $this->section('content') ?>

<?= $this->include('templates/sidebar') ?>

<style>
    #report-error>p {
        color: white;
    }

    #report-success>p {
        color: white;
    }
</style>


<div class="container">

    <div style='height:20px;'></div>
    <div role="alert" class="alert alert-info alert-dismissible">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"> </button>
        <strong><i class="fa fa-info-circle"></i> Avisos!</strong><br> As senhas registadas na plataforma não podem ser colocadas na tômbola física.<br>Apesar do registo ser digital as senhas em papel deverão ser guardadas até ao sorteio.
    </div>

    <div style="padding: 10px">
        <?php echo $output; ?>
    </div>
</div>


<?= $this->endSection() ?>


<?= $this->section('extra_scripts') ?>

<script>
    $(document).ready(function() { //          

        $("input[name='id_voucher']").focus();
        $("#form-button-save").hide();

        $('#crudForm').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) {
                e.preventDefault();
                return false;
            }
        });

    });
</script>

<?= $this->endSection() ?>