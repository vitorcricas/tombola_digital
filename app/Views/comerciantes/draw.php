<?= $this->extend('templates/default_layout') ?>
<?= $this->section('content') ?>

<link href="<?php echo base_url("css/draw.css"); ?>" rel="stylesheet">

<style>
    .card-body {
        min-height: 205px;
    }
</style>

<?= $this->include('templates/sidebar') ?>

<?php
$premiosAtribuir = explode(",", $premios);
$draw = count($premiosAtribuir) - count($premiosAtribuidos);

if ($draw == 0)
    $draw_text = "Já foram sorteados todos os prémios";
else
    $draw_text = "Sorteio do " . $draw . "º Prémio » " . $premiosAtribuir[$draw - 1] . "€";
?>


<div class="container-fluid" style="overflow:auto">
    <div style='height:20px;'></div>
    <div style="padding: 10px">
        <?php if ($draw !== 0) { ?>

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mx-auto h-100 d-flex flex-column justify-content-center align-items-center">
                <div id="raffle-draw" class="w-100">
                    <input type="hidden" id="rdraw" value="<?= $draw ?>">
                    <input type="hidden" id="draw_text" value="<?= $draw_text ?>">
                    <input type="hidden" id="draw_value" value="<?= $premiosAtribuir[$draw - 1] ?>">
                    <h3 class="mb-5 text-center"><b><?= $draw_text ?></b></h3>
                    <hr>
                    <div id="ticket-list" class="d-flex overflow-hidden">
                        <?php
                        $highlight = false;
                        foreach ($cupoes as $cupao) :
                        ?>
                            <div class="col-2 ticket-item <?= (!$highlight) ? 'highlight-item' : '' ?>" data-id="<?= $cupao['id_voucher'] ?>" data-client="<?= $cupao['cliente'] ?>">
                                <div class="card rounded-0 mx-2">
                                    <div class="card-body">
                                        <div class="container-fluid item-details">
                                            <h4 class="text-muted text-center item-code"><?= $cupao['codigo'] ?></h4>
                                            <h4 class="text-center item-name"><?= $cupao['nome'] ?></h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php $highlight = true; ?>
                        <?php endforeach; ?>
                    </div>
                    <hr>

                    <div class="text-center mt-4">
                        <h4>Cupões a concurso = <b><?= count($cupoes) ?></b> | Sorteados <?=count($premiosAtribuidos)?> de <?=count($premiosAtribuir)?> prémios</h4>
                    </div>

                    <div class="text-center mt-4">
                        <button class="btn btn-lg btn-primary rounded-pill col-lg-3 col-md-4 col-sm-6 col-xs-10" type="button" id="draw">Sortear</button>
                    </div>
                    <div class="text-center">
                        <a class="btn btn-default" href="<?php echo base_url("admin/premiados"); ?>"><i class="fas fa-trophy"></i> Premiados</a>
                    </div>
                </div>
            </div>

            <div class="modal fade rounded-0" id="winnerModal" data-bs-backdrop="static">
                <div class="modal-dialog  modal-lg modal-dialog-centered modal-dialog-scrollable rounded-0">
                    <div class="modal-content rounded-0">

                        <div class="modal-body rounded-0">
                            <div class="container-fluid h-50">
                                <div id="win_template" class="position-relative">
                                    <img src="<?php echo base_url("images/draw_winner.jpg"); ?>" alt="" class="img-fluid">
                                    <div id="winner_greet">
                                        <h3 id="winner_prize" class="text-center"><b></b></h3>
                                        <h1 id="winner_client" class="text-center"><b></b></h1>
                                    </div>
                                    <div id="winner_name">                                        
                                        <h3 id="winner_code" class="text-center"><b></b></h3>
                                        <h3 id="winner_merchant" class="text-center"><b></b></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center my-2">
                                <button type="button" class="btn btm-sm rounded-pill btn-light border" data-bs-dismiss="modal">Sortear próximo</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <?php } else { ?>
            <h3 class="text-center"><b><?= $draw_text ?></b></h3>
            <div class="text-center">
                <a class="btn btn-default" href="<?php echo base_url("admin/premiados"); ?>"><i class="fas fa-trophy"></i> Premiados</a>
            </div>

        <?php } ?>
    </div>
</div>


<?= $this->endSection() ?>

<?= $this->section('extra_scripts') ?>

<script type="text/javascript">
    var rdraw, ticket_id;
    $(document).ready(function() {

        const draw = async () => {
            var totalTickets = $('.ticket-item').length
            var pick = Math.floor(Math.random() * (totalTickets) + 1);


            for (var $i = 1; $i <= pick; $i++) {
                var _i = $i > totalTickets ? $i - totalTickets : $i;
                await new Promise(resolve => {
                    setTimeout(() => {
                        var _scroll = $(`.ticket-item:nth-child(${_i})`)[0].offsetLeft
                        $('#ticket-list')[0].scrollLeft = _scroll - 350
                        $('.highlight-item').removeClass('highlight-item')
                        $(`.ticket-item:nth-child(${_i})`).addClass('highlight-item')
                        resolve()
                    }, 0)
                })

                if ($i == pick) {
                    setTimeout(() => {
                        var item = $(`.ticket-item.highlight-item`)
                        ticket_id = item.attr('data-id');
                        ticket_client = item.attr('data-client');

                        var win_modal = $('#winnerModal');
                        rdraw = $('#rdraw').val();
                        var draw_text = $('#draw_text').val();
                        draw_value = $('#draw_value').val();

                        win_modal.find('#winner_merchant').html("<b>Comerciante</b>: " + item.find('.item-name').text())
                        win_modal.find('#winner_code').html("<b>Senha nº</b>: " + item.find('.item-code').text())
                        win_modal.find('#winner_prize').text(draw_text)
                        win_modal.find('#winner_client').text(ticket_client);

                        win_modal.modal('show');

                        jQuery.ajax({
                            type: "POST",
                            url: "<?php echo base_url("admin/saveWinner"); ?>",
                            data: {
                                id_sorteio: <?= $id_sorteio ?>,
                                id_voucher: ticket_id,
                                valor: draw_value
                            },
                            success: function(data) {}
                        });

                    }, 500)
                }
            }
        }

        $('#draw').click(function() {
            $("#draw").attr('disabled', 'disabled');
            $("#draw").text("A sortear...")


            draw();
        })

        $('#winnerModal').on('hide.bs.modal', function(e) {
            location.reload();

        })

    });
</script>
<?= $this->endSection() ?>