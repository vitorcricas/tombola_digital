<?= $this->extend('templates/default_layout') ?>

<?= $this->section('content') ?>

<div class="body-inner">

    <section id="page-title" data-bg-parallax="images/parallax/tombola_wide.jpg">
        <div class="container">
            <div class="page-title">
                <h1>Contate-nos</h1>
                <span>Tire as suas dúvidas</span>
            </div>

        </div>
    </section>
    <!-- end: Page title -->
    <!-- CONTENT -->
    <section>
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <h3 class="text-uppercase">Formulário de Contacto</h3>
                    <div class="m-t-30">
                        <form class="form-horizontal" id="form" method="post" action="#" data-toggle="validator" role="form">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="nome">Nome</label>
                                    <input type="text" aria-required="true" name="nome" required class="form-control required name" placeholder="">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="email">Email</label>
                                    <input type="email" aria-required="true" name="email" required class="form-control required email" placeholder="">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="assunto">Assunto</label>
                                    <input type="text" name="assunto" required class="form-control required" placeholder="Assunto...">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="mensagem">Mensagem</label>
                                <textarea type="text" name="mensagem" required rows="5" class="form-control required" placeholder="Insira a sua mensagem"></textarea>
                            </div>
                            <div class="form-group">
                                <script src="https://www.google.com/recaptcha/api.js" async defer></script>
                                <div class="g-recaptcha" data-sitekey="6Ld_mfMiAAAAACeah80AJU0Yb-wemfnR3HvBwzCO"></div>
                            </div>
                            <button class="btn btn-primary" type="submit" id="form-submit"><i class="fa fa-paper-plane"></i>&nbsp;Enviar mensagem</button>

                            <div class="form-group text-center">
                                    <div id="sending1" style="display:none">
                                        <img src="<?php echo base_url("images/loader.gif"); ?>">
                                        A enviar...
                                    </div>
                                </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-6">
                    <h3 class="text-uppercase">Onde estamos</h3>
                    <div class="row">
                        <div class="col-lg-5">
                            <address>
                                <strong>Município da Mealhada</strong><br>
                                Largo do Município<br>
                                3054-001 Mealhada<br>
                                <abbr title="Telefone">T:</h4> 231 200 980<br>
                                    <abbr title="Fax">F:</h4> 231 203 618
                            </address>
                        </div>
                        <div class="col-lg-7">
                            <address>
                                <strong>ACIBA</strong><br>
                                Espaço Inovação Mealhada<br>
                                Av. Cidade de Coimbra, nº 51 – Sala 1<br>
                                3050-374 Mealhada<br>
                                <abbr title="Telefone">T:</h4> 231 201 606<br>
                                    <abbr title="Fax">F:</h4> 927 975 540
                            </address>
                        </div>
                    </div>
                    <!-- Google Map -->
                    <div class="map"></div>
                    <!-- end: Google Map -->
                </div>
            </div>
        </div>
    </section>
    <!-- end: Content -->

    <?= $this->endSection() ?>

    <?= $this->section('extra_scripts') ?>

    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url("js/validator.min.js"); ?>"></script>

    <script type="text/javascript" src="plugins/gmap3/gmap3.min.js"></script>
    <script type="text/javascript" src="plugins/gmap3/map-styles.js"></script>

    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBabg8CTeyIlzoVFvSwsu8U6gNg2WgVq1U&region=PT"></script>

    <script>
        var infowindow = new google.maps.InfoWindow({
            //content: contentString,
            ariaLabel: "Uluru",
        });


        map = $('.map')
            .gmap3({
                center: [40.377928, -8.453142],
                zoom: 14
            }).marker([{
                    position: [40.377928, -8.453142],
                    content: "Município da Mealhada"
                },
                {
                    position: [40.3663463, -8.453742],
                    content: "Associação Comercial e Industrial da Bairrada e Aguieira"
                },
                {
                    address: "86000 Poitiers, France"
                },
                {
                    address: "66000 Perpignan, France",
                    icon: "https://maps.google.com/mapfiles/marker_grey.png"
                }
            ]).on('click', function(marker) {
                marker.setIcon('https://maps.google.com/mapfiles/marker_green.png');


                console.info(marker);
                infowindow.setContent(marker.content);
                infowindow.open({
                    anchor: marker,
                    map,
                });

            });


        $('#form').validator().on('submit', function(e) {
            if (e.isDefaultPrevented()) {
                INSPIRO.elements.notification("Erro", "Preencha todos os campos obrigatórios", "danger");
            } else {
                e.preventDefault();
                $('button[type=submit]').hide();
                var form = $('#form')[0];
                var formData = new FormData(form);
                $('#sending1').show();


                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url("sendContactForm"); ?>",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        $('button[type=submit]').show();
                        $('#sending1').hide();

                        if (data.response == true) {
                            form.reset();
                            INSPIRO.elements.notification("Sucesso", "Obrigado pelo contacto", "success");

                            $([document.documentElement, document.body]).animate({
                                scrollTop: $("#form").offset().top
                            }, 1000);
                        } else {
                            INSPIRO.elements.notification("Erro", data.message, "danger");
                        }


                    }
                });

            }
        });
    </script>

    <?= $this->endSection() ?>