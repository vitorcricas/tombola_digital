<?= $this->extend('templates/default_layout') ?>
<?= $this->section('content') ?>

<link href="https://cdn.jsdelivr.net/npm/pretty-checkbox@3.0/dist/pretty-checkbox.min.css" rel="stylesheet" type="text/css" />
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">



<style>
    .alert-danger,
    .alert-success {
        color: white;
    }

    .text-right {
        text-align: right !important;
    }

    .form-group.required .control-label:after {
        content: "*";
        color: red;
    }

    .req:after {
        content: "*";
        color: red;
    }

    .control-label-last {
        font-style: italic;
    }

    .control-label-last:before {
        content: "*";
        color: red;
    }
</style>

<div class="body-inner">

    <section id="page-title" data-bg-parallax="<?php echo base_url("images/parallax/tombola.jpg"); ?>">
        <div class="container">
            <div class="page-title">
                <h1>Tômbola de Natal 2023</h1>
                <h3 class="white">Pedido de Adesão de comerciante</h3>
            </div>

        </div>
    </section>

    <section>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!--<h4 class="text-uppercase text-center">Período de adesão » 7 de novembro a 18 de novembro de 2022</h4>-->
                    <?php
                    if (new DateTime() >= new DateTime("2022-11-29 00:01:00") && new DateTime() <= new DateTime("2022-11-29 23:59:00")) { ?>
                        <h3 style="color:red; text-align:center">ÚLTIMO DIA</h3>
                    <?php } ?>


                    <?php
                    if ((new DateTime() > new DateTime("2022-11-30 00:01:00"))) { ?>

                        <br />
                        <div class="text-center">

                            <h2><label class="label label-danger" style="font-size:1em">As inscrições encontram-se encerradas</label></h2>
                            <!--<div class="left-banner-title">Decorrem de 5 de setembro a 1 de outubro de 2022</div>-->
                            <br /><br />
                        </div>
                    <?php } else {
                    ?>

                        <div class="m-t-30">
                            <form class="form-horizontal" id="form" method="post" action="#" data-toggle="validator" role="form">

                                <div class="card">
                                    <div class="card-header">
                                        <span class="h4">Dados do estabelecimento</span>
                                        <p class="text-muted">Preencha os campos em baixo e envie o seu pedido de adesão. Receberá um comprovativo no email<br>
                                            Em alternativa descarregue <a href="<?php echo base_url("assets/uploads/Imp-Tomb-A01.pdf"); ?>" target="_blank">aqui</a> a ficha e envie por <a href="mailto:geral@aciba.pt">email</a> ou entregue em mão na <a href="<?php echo base_url("contato"); ?>">ACIBA</a>.</p>
                                    </div>
                                    <div class="card-body">


                                        <div class="row form-group required">
                                            <label for="nome" class="control-label col-md-3">Designacao Comercial:</label>
                                            <div class="form-group col-md-9 has-feedback">
                                                <input type="text" class="form-control" id="nome" name="nome" data-minlength="4" required data-error="mínimo 4 caracteres">
                                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="row form-group required">
                                            <label for="resp_nome" class="control-label col-md-3">Nome do Responsável:</label>
                                            <div class="form-group col-md-9 has-feedback">
                                                <input type="text" class="form-control" id="resp_nome" name="resp_nome" data-minlength="4" required data-error="mínimo 4 caracteres">
                                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>


                                        <div class="row form-group required">
                                            <label for="morada" class="control-label col-md-3">Morada:</label>
                                            <div class="form-group col-md-9 has-feedback">
                                                <input type="text" class="form-control" id="morada" name="morada" data-minlength="6" required data-error="mínimo 6 caracteres">
                                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>


                                        <div class=" row form-group required ">
                                            <label for="cp1" class="control-label col-md-3">Código Postal:</label>
                                            <div class="form-group col-md-2 has-feedback">
                                                <input type="text" class="form-control cpostal" id="cp1" name="cp1" data-minlength="4" maxlength="4" placeholder="xxxx" required pattern="\d{4}" data-error="4 digitos">
                                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                                <div class="help-block with-errors"></div>

                                            </div>
                                            <div class="form-group col-md-2 has-feedback">
                                                <input type="text" class="form-control cpostal" id="cp2" name="cp2" data-minlength="3" maxlength="3" placeholder="yyy" required pattern="\d{3}" data-error="3 digitos">
                                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                                <div class="help-block with-errors"></div>

                                            </div>
                                            <label for="localidade" class="control-label right col-md-2">Localidade:</label>
                                            <div class="form-group has-feedback col-md-3">
                                                <input type="text" class="form-control" id="localidade" name="localidade" data-minlength="3" required data-error="mínimo 3 caracteres">
                                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                                <div class="help-block with-errors"></div>

                                            </div>

                                        </div>


                                        <div class="row form-group">
                                            <label for="telefone" class="control-label col-md-3">Telemóvel:<span class="required">*</span></label>
                                            <div class="form-group col-md-3 has-feedback">

                                                <input type="text" class="form-control" id="telefone" name="telefone" data-minlength="9" maxlength="9" data-error="Contacto Inválido" required pattern="[0-9]{9}">
                                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                                <div class="help-block with-errors"></div>

                                            </div>
                                            <label for="email" class="control-label right col-md-1">Email:</label>
                                            <div class="form-group col-md-5 has-feedback">
                                                <input type="email" class="form-control" id="email" name="email" data-error="Esse email é inválido">
                                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                                <div class="help-block with-errors"></div>
                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <div class="card">
                                    <div class="card-header">
                                        <span class="h4">Assinale cada uma das opções (obrigatório)</span>
                                    </div>
                                    <div class="card-body">

                                        <div class="row form-group required has-feedback">
                                            <label for="check2_1" class="control-label col-md-10 checking">Tomei conhecimento das <a href="../doc/normas_2022.pdf" target="_blank"> normas</a> de participação na iniciativa Tômbola de Natal.</label>
                                            <div class="col-md-2 ">
                                                <div class="pretty checking p-icon p-smooth">
                                                    <input type="checkbox" name="check3_1" required value="1" />
                                                    <div class="state p-success"><i class="icon fa fa-check"></i><label>Sim</label></div>
                                                </div>
                                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                            </div>

                                        </div>
                                        <div class="row form-group required has-feedback">
                                            <label for="check3_3" class="control-label col-md-10 checking">Declaro que todas as informações prestadas são atuais e corretas.</label>
                                            <div class="col-md-2 ">
                                                <div class="pretty checking p-icon p-smooth">
                                                    <input type="checkbox" name="check3_3" required value="1" />
                                                    <div class="state p-success"><i class="icon fa fa-check"></i><label>Sim</label></div>
                                                </div>
                                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                            </div>
                                        </div>
                                        <div class="row form-group required has-feedback">
                                            <label for="check3_4" class="control-label col-md-10 checking">Autorizo a ACIBA - Associação Comercial e Industrial da Bairrada e Aguieira e a Câmara Municipal de Mealhada a proceder à utilização adequada dos dados facultados na candidatura, no âmbito da divulgação da iniciativa "Tômbola de Natal".</label>
                                            <div class="col-md-2 ">
                                                <div class="pretty checking p-icon p-smooth">
                                                    <input type="checkbox" name="check3_4" required value="1" />
                                                    <div class="state p-success"><i class="icon fa fa-check"></i><label>Sim</label></div>
                                                </div>
                                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                            </div>
                                        </div>

                                    </div>
                                </div>



                                <div><label class="control-label-last"> Campos de preenchimento obrigatório</label></div>
                                <br>

                                <h4><label>O Município de Mealhada cumpre integralmente o Regulamento Geral de Proteção de Dados, no que concerne à recolha e tratamento de dados pessoais.</label></h4>
                                <br>
                                <h4><i class="icon fa fa-user-shield"></i>&nbsp;Consulte a <a href="http://www.cm-mealhada.pt/menu/561/politica-de-privacidade" target="_blank">política de privacidade</a> do Município</h4>
                                <br>


                                <div class="form-group text-center">
                                    <button type="submit" class="btn btn-lg btn-success">Enviar</button>
                                    <div id="sending1" style="display:none">
                                        <img src="<?php echo base_url("images/loader.gif"); ?>">
                                        A enviar...
                                    </div>
                                </div>

                            </form>
                        </div>

                </div>

            </div>

        <?php } ?>

        </div>

    </section>
</div>


<?= $this->endSection() ?>

<?= $this->section('extra_scripts') ?>

<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="<?php echo base_url("js/validator.min.js"); ?>"></script>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>


<script src="<?php echo base_url("js/jquery.mask.min.js"); ?>"></script>

<script>
    $(document).ready(function() {


        $('#cp1').mask('0000');
        $('#cp2').mask('000');

        $('[data-toggle="tooltip"]').tooltip();

        $(".cpostal").on("keyup", function() {
            if ($(this).val().length == $(this).data("minlength")) {

                if ($("#cp1").val().length == 4 && $("#cp2").val().length == 3) {
                    $("#localidade").focus();
                    $("#localidade").val("");
                    $("#localidade").attr("placeholder", "A carregar...");
                } else
                    $("#cp2").focus();
            }

            var cp4 = $("#cp1").val();
            var cp3 = $("#cp2").val();

            if (cp4.length == 4 && cp3.length == 3) {
                $.post('<?php echo base_url("getCP"); ?>', {
                    cp4: $("#cp1").val(),
                    cp3: $("#cp2").val()
                }, function(data) {
                    $('#localidade').effect("highlight", {}, 1000);

                    if (data != "") {
                        $('#localidade').val(data);
                    } else
                        $('#localidade').attr("placeholder", "Nao encontrado. Insira manualmente");


                });

            }

        });

        $('#form').validator().on('submit', function(e) {
            if (e.isDefaultPrevented()) {
                INSPIRO.elements.notification("Erro", "Preencha todos os campos obrigatórios", "danger");

            } else {
                e.preventDefault();
                $("#result1").html("");
                $('button[type=submit]').hide();
                $('#sending1').show();

                var form = $('#form')[0];
                var formData = new FormData(form);

                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url("sendMailAdesao"); ?>",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        $('button[type=submit]').show();
                        $('#sending1').hide();

                        if (data.success == true) {

                            if ($("#email").val() != "")
                                INSPIRO.elements.notification("Sucesso", "Pedido enviado! Irá receber confirmação via email Obrigado", "success");
                            else
                                INSPIRO.elements.notification("Sucesso", "Pedido enviado! Obrigado", "success");
                            form.reset();


                            $([document.documentElement, document.body]).animate({
                                scrollTop: $("#form").offset().top
                            }, 1000);
                        } else {
                            INSPIRO.elements.notification("Erro", "Erro no envio do pedido. O email está correto?", "danger");
                        }


                    }
                });
            }
        });

    });
</script>

<?= $this->endSection() ?>