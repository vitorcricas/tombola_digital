<?= $this->extend('templates/default_layout') ?>
<?= $this->section('content') ?>

<style>
    .modal-dialog {
        overflow-y: initial !important;
        max-width: 700px;
    }

    .modal-body {
        max-height: 70vh;
        overflow-y: auto;
    }
</style>

<div class="modalClientVouchers modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<?= $this->include('templates/sidebar') ?>


<div class="container-fluid">
    <div style='height:20px;'></div>


    <div style="padding: 10px">
        <?php echo $output; ?>
    </div>

    <a class="btn btn-info" href="<?php echo base_url("comerciantes/exportMerchants"); ?>">Exportar fichas ativas</a>

</div>


<?= $this->endSection() ?>


<?= $this->section('extra_scripts') ?>

<script>
    $(document).ready(function() { //          


        $("input[name='vouchers']").hide();

        $(document).on("click", ".usedVouchers", function() {
            var nome = $(this).data("nome");

            $.ajax({
                type: "POST",
                url: "<?php echo base_url("comerciantes/getUsedMerchantVouchersClients"); ?>",
                data: {
                    id: $(this).data("id")
                },
                success: function(data) {
                    $(".modalClientVouchers .modal-title").html("Lista de vouchers registados " + nome);

                    $(".modalClientVouchers .modal-body").html(data);
                    $(".modalClientVouchers").gc_modal();
                }
            });

        });

        $(document).on("click", '.image-lightbox', function() {
            $.magnificPopup.open({
                items: {
                    src: $(this).data("src"), // can be a HTML string, jQuery object, or CSS selector
                    type: 'image'
                }
            });
        });


        $(document).on("click", '.gmap-lightbox', function() {
            $.magnificPopup.open({
                items: {
                    src: $(this).data("src"), // can be a HTML string, jQuery object, or CSS selector
                    type: 'iframe'
                }
            });
        });

        //$('.gmap-lightbox').magnificPopup({type:'iframe'});

        $("#form-button-save").hide();

        $(document).on("click", ".confirm_merchant", function() {

            $.ajax({
                type: "POST",
                url: "<?php echo base_url("comerciantes/confirmMerchant"); ?>",
                data: {
                    id: $(this).data("id")
                },
                dataType: 'json',
                success: function(data) {
                    if (data.success == true) {

                        INSPIRO.elements.notification("Sucesso", "O comerciante foi colocado na lista", "success");
                        setTimeout(function() {
                            location.reload(); //ja preencheu quiz
                        }, 2000);


                    } else {
                        INSPIRO.elements.notification("Erro", "Erro a confirmar pedido de adesão!", "danger");
                    }


                }
            });

        });

        $(document).on("click", ".toggle_merchant", function() {

            tipo = "ativado";
            if ($(this).data("val") == 0)
                tipo = "desativado";



            $.ajax({
                type: "POST",
                url: "<?php echo base_url("comerciantes/toggleMerchant"); ?>",
                data: {
                    id: $(this).data("id"),
                    val: $(this).data("val"),
                },
                dataType: 'json',
                success: function(data) {
                    if (data.success == true) {

                        INSPIRO.elements.notification("Sucesso", "O comerciante foi " + tipo, "success");
                        setTimeout(function() {
                            location.reload(); //ja preencheu quiz
                        }, 2000);


                    } else {
                        INSPIRO.elements.notification("Erro", "Erro ao " + tipo + " comerciante", "danger");
                    }


                }
            });

        });


    });
</script>


<?= $this->endSection() ?>