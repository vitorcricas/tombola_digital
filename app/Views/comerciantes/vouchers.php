<?= $this->extend('templates/default_layout') ?>
<?= $this->section('content') ?>

<?= $this->include('templates/sidebar') ?>




<div class="container">

    <div class="p-t-20">
        <?php echo $output; ?>
    </div>
</div>


<?= $this->endSection() ?>

<?= $this->section('extra_scripts') ?>

<script>
    $(document).ready(function() { // 

        var nSenhasMaco = <?= intval($nSenhasMaco) ?>;
        var final = $("#field-n_macos").val() * <?= intval($nSenhasMaco) ?> - 1;

        //código final igual ao inicial
        if ($("#field-codigo").val() != "")
            $("#field-codigo_f").val(parseInt($("#field-codigo").val()) + parseInt(final));

        $(".header-tools>.floatL .btn-default").addClass("btn-success");

        $("#form-button-save").hide();

        $("#field-codigo").on("keyup", function() {
            if ($("#field-codigo").val() != "") {
                final = $("#field-n_macos").val() * <?= intval($nSenhasMaco) ?> - 1;
                $("#field-codigo_f").val(parseInt($("#field-codigo").val()) + parseInt(final));
            } else
                $("#field-codigo_f").val("");
        });


    });
</script>

<?= $this->endSection() ?>