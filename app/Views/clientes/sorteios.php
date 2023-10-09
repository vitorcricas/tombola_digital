<?= $this->extend('templates/default_layout') ?>
<?= $this->section('content') ?>

<?= $this->include('templates/sidebar') ?>

<div class="container">
    <div style='height:20px;'></div>
    <div style="padding: 10px">
        <?php echo $output; ?>
    </div>
</div>


<?= $this->endSection() ?>

<?= $this->section('extra_scripts') ?>

<div class="modal fade" id="modal-drawInfo" tabindex="-1" role="dialog" aria-labelledby="modal-label-drawInfo" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 id="modal-label-drawInfo" class="modal-title"></h4>
                <button aria-hidden="true" data-dismiss="modal" class="btn-close" type="button">×</button>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-b" type="button">Fechar</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $(".filter-row ").hide();
        $(".footer-tools ").hide();

        $("#drawInfo").on("click", function() {

            //modal title
            //modal body
            $.ajax({
                type: "POST",
                url: "<?php echo base_url("clientes/drawInfo"); ?>",
                data: {
                    "id_sorteio": $(this).data("id")
                },
                success: function(data) {
                    dados = JSON.parse(data);

                    $("#modal-label-drawInfo").html(dados["descricao"]);

                    html = ' <div class="row mb20">';
                    html+='<div class="col-md-6"><h4>Período de Adesão</h4></div><div class="col-md-6"><h5>'+dados["adesao_dataI"]+' a '+dados["adesao_dataF"]+'</h5></div>';
                    html+='<div class="col-md-6"><h4>Período para Registo de Senhas</h4></div><div class="col-md-6"><h5>'+dados["registo_dataI"]+' a '+dados["registo_dataF"]+'</h5></div>';
                    html+='<div class="col-md-6"><h4>Data do Sorteio</h4></div><div class="col-md-6"><h5>'+dados["data_sorteio"]+'</h5></div>';

                    html+='</div></div>';

                    $("#modal-drawInfo .modal-body").html(html)


                }
            });


        });
    })
</script>
<?= $this->endSection() ?>