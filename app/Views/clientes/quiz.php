<?= $this->extend('templates/default_layout') ?>
<?= $this->section('content') ?>

<link href="<?php echo base_url("plugins/jquery-steps/jquery.steps.css"); ?>" rel="stylesheet">
<link href="<?php echo base_url("plugins/bootstrap-switch/bootstrap-switch.css"); ?>" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.css" rel="stylesheet">


<?= $this->include('templates/sidebar') ?>

<div class="container">

    <div class="row m-t-40 m-b-40">

        <h4>Temos um pequeno questionário para si. O seu preenchimento é <mark>facultativo</mark> e as respostas não serão associadas ao seu utilizador</h4>
        <h5>O tratamento desta informação serve exclusivamente para a análise de hábitos de consumo.</h5>
        <h5><input type="checkbox" id="noQuizck"> Não quero preencher o questionário e quero apenas registar senhas<button id="noQuiz" class="btn-sm btn btn-default">&nbsp;OK</button></h5>

        <div class="card">
            <div class="card-body">

                <form id="quiz" class="wizard needs-validation" data-style="1" novalidate>
                    <h3>Q1</h3>
                    <div class="wizard-content">
                        <div class="row">
                            <div class="form-check mb-1 mt-5">
                                <div class="form-group col-md-6">
                                    <h5>Costuma fazer compras no concelho da Mealhada?</h5>
                                    <label class="p-switch switch-color-success">
                                        <input type="checkbox" name="q1" id="q1"><span class="p-switch-style" required></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="q2">
                                    <h5>Quanto costuma gastar em compras de natal?</h5>
                                </label>
                                <select class="form-select " name="q2" required>
                                    <option value="">-</option>
                                    <option value="<50">Menos de 50€</option>
                                    <option value="<100">50 a 100€</option>
                                    <option value="<250">100€ a 250€</option>
                                    <option value=">250">Mais de 250€</option>

                                </select>
                            </div>

                        </div>

                    </div>

                    <h3>Q2</h3>
                    <div class="wizard-content">
                        <div class="row">

                            <div class="form-group col-md-6">
                                <h5>Já visitou o Município da Mealhada?</h5>
                                <label class="p-switch switch-color-success">
                                    <input type="checkbox" name="q3" id="q3"><span class="p-switch-style" required></span>
                                </label>
                            </div>
                        </div>
                        <div class="row">

                            <div class="form-group col-md-6">
                                <label for="q4">
                                    <h5>O que identifica melhor o município da Mealhada?</h5>
                                </label>
                                <select class="form-select" name="q4" id="q4" required>
                                    <option value="">-</option>
                                    <option value="Luso">Água de Luso</option>
                                    <option value="Carnaval">Carnaval</option>
                                    <option value="Leitão">Leitão</option>
                                    <option value="Bussaco">Mata do Bussaco</option>
                                    <option value="Todos">Todos os anteriores</option>
                                    <option value="Outros">Outros</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">

                            <div class="form-group col-md-6">
                                <textarea id="outros" name="outros" style="display:none" class="form-control" placeholder="Descreva o que identifica melhor no Município"></textarea>
                            </div>
                        </div>

                    </div>

                    <h3>Concelho</h3>
                    <div class="wizard-content">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="q5">
                                    <h5>Concelho de Residência<h5>
                                </label>
                                <select class="q5" name="q5" required>
                                    <option value="">-</option>
                                    <?php foreach ($concelhos as $concelho) { ?>
                                        <option value="<?= $concelho["designacao"] ?>"><?= $concelho["designacao"] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>//

<?= $this->section('extra_scripts') ?>

<script src="<?php echo base_url("plugins/validate/validate.min.js"); ?>"></script>
<script src="<?php echo base_url("plugins/jquery-steps/jquery.steps.min.js"); ?>"></script>
<script src="<?php echo base_url("plugins/bootstrap-switch/bootstrap-switch.min.js"); ?>"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {

        $("#q4").on("change", function() {
            if ($(this).val() == "Outros") {
                $("#outros").show();
                $("#outros").prop('required', true);

            } else {
                $("#outros").hide();
                $("#outros").prop('required', false);

            }
        });

        $("#noQuiz").on("click", function() {
            if ($("#noQuizck").prop("checked") == false)
                INSPIRO.elements.notification("Erro", "Assinale a caixa de verificação", "danger");
            else {
                var form = $('#quiz')[0];
                var formData = new FormData(form);
                formData.append("outros", $("#outros").val());


                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url("clientes/doneQuiz"); ?>",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        INSPIRO.elements.notification("Registado", "Pode começar a registar as suas senhas", "success");

                        setTimeout(function() {
                            location.reload(); //ja preencheu quiz
                        }, 2000);
                    },

                });

            }

        });


    });

    jQuery.extend(jQuery.validator.messages, {
        required: "Campo obrigatório"
    });

    var quizwizard = $('#quiz');

    quizwizard.steps({
        labels: {
            current: "current step:", //
            finish: "Fim",
            next: "Próximo",
            previous: "Anterior",
            loading: "A Carregar ..."
        },

        headerTag: "h3",
        bodyTag: '.wizard-content',
        autoFocus: true,
        enableAllSteps: true,
        titleTemplate: '<span class="number">#index#</span><span class="title">#title#</span>',
        onStepChanging: function(event, currentIndex, newIndex) {
            if (currentIndex > newIndex) {
                return true;
            }
            return quizwizard.valid();
        },
        onStepChanged: function(event, currentIndex, priorIndex) {
            if (currentIndex == 2) {
                $(".q5").addClass("chosen-select");
                $(".chosen-select").chosen();
            } else {
                $(".q5").removeClass("chosen-select");
                // $(".chosen-select").chosen();
            }

        },
        onFinishing: function(event, currentIndex) {
            return quizwizard.valid();
        },
        onFinished: function(event, currentIndex) {

            var form = $('#quiz')[0];
            var formData = new FormData(form);

            formData.set("q1", $("#q1").prop("checked") ? "Sim" : "Não");
            formData.set("q3", $("#q3").prop("checked") ? "Sim" : "Não");


            $.ajax({
                type: "POST",
                url: "<?php echo base_url("clientes/saveQuiz"); ?>",
                data: formData,
                contentType: false,
                processData: false,
                success: function(data) {
                    INSPIRO.elements.notification("Enviado", "Obrigado pelo seu contributo. Pode começar a registar as suas senhas", "success");

                    setTimeout(function() {
                        location.reload(); //ja preencheu quiz
                    }, 2000);

                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    INSPIRO.elements.notification("Erro", "Erro a submeter respostas. Tente novamente", "danger");

                }
            });

        }
    });

    $.validator.setDefaults({
        ignore: ":hidden:not(select.chosen-select)"
    }) //for all select

    //Validation
    quizwizard.validate({
        errorClass: 'is-invalid',
        validClass: 'is-valid',
        errorElement: "div",
        errorPlacement: function(error, element) {
            $(element).parents(".form-group").append(error);
        }
    });



    $('.wizard').find(".actions ul > li > a").addClass("btn");
</script>


<?= $this->endSection() ?>