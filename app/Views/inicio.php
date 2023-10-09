<?= $this->extend('templates/default_layout') ?>
<?= $this->section('content') ?>


<!-- Body Inner -->
<div class="body-inner">

    <div id="cookieNotify" class="modal-strip cookie-notify background-aciba" data-delay="3000" data-expire="1" data-cookie-name="cookiebar2021_1" data-cookie-enabled="true">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 text-sm-center sm-center sm-m-b-10 m-t-5">Este portal utiliza cookies para melhorar a experiência de utilização. </div>
                <div class="col-lg-4 text-end sm-text-center sm-center">
                    <button type="button" class="btn btn-roundeded btn-light btn-outline btn-sm m-r-10 modal-close">Recusar</button>
                    <button type="button" class="btn btn-roundeded btn-light btn-sm modal-confirm">Ok</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Inspiro Slider -->
    <div id="slider" class="inspiro-slider slider-fullscreen dots-creative" data-height-xs="360">
        <!-- Slide 1 -->
        <div class="slide kenburns" data-bg-parallax="images/slider/tombnatal1.jpg">
            <div class="bg-overlay"></div>
            <div class="container">
                <div class="slide-captions text-light">
                    <!-- Captions -->
                    <div class="row m-t-100">

                        <div class="col-md-7 col-xs-12">
                            <h2 data-animate="fadeInUp" data-animate-delay="300" class="text-left"><span class="business">TÔMBOLA DE NATAL</h2>
                            <h4 data-animate="fadeInUp" data-animate-delay="600" class="text-left">Apoiar o comércio local</h4>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-8">
                            <h4 class="mt-5">O sorteio já decorreu</h4>

                            <!--<div class="countdown rectangle medium " data-animate="fadeInLeft" data-animate-delay="800" data-countdown="2023/02/03 19:00:00">

                                <div class="countdown-container">
                                     <div class="countdown-box ">
<div class="number">53</div><span>Dias</span>
</div>
<div class="countdown-box">
<div class="number">18</div><span>Horas</span>
</div>
<div class="countdown-box">
<div class="number">14</div><span>Minutos</span>
</div>
<div class="countdown-box">
<div class="number">33</div><span>Segundos</span>
</div>
                                    -
                                </div>
                            </div>-->
                            <h4 class="mt-3"><button type="button" class="btn btn-lg btn-roundeded btn-reveal btn-reveal-left "><a href="<?php echo base_url("sorteio"); ?>">premiados</a></button></h4>
                            <?php if ($openR == 1) { ?>

                                <!--     <p class="mt-5">Ainda tem...</p>

                                <div class="countdown rectangle medium " data-animate="fadeInLeft" data-animate-delay="800" data-countdown="2023/01/16 00:00:01">

                                    <div class="countdown-container">
                                        <!-- <div class="countdown-box ">
                                <div class="number">53</div><span>Dias</span>
                            </div>
                            <div class="countdown-box">
                                <div class="number">18</div><span>Horas</span>
                            </div>
                            <div class="countdown-box">
                                <div class="number">14</div><span>Minutos</span>
                            </div>
                            <div class="countdown-box">
                                <div class="number">33</div><span>Segundos</span>
                            </div>-->
                                <!--       </div>
                                </div>
                                <p class="mt-3">...para registar as suas senhas!</p>-->
                            <?php } ?>
                        </div>
                        <div class="col-md-4 mt-5" data-animate="fadeInRight" data-animate-delay="1600">
                            <h4>Por cada 15€ de compras será entregue ao cliente uma senha de participação</h4>

                            <?php if ($openR == 0) { ?>
                                <button type="button" class="btn btn-roundeded btn-reveal btn-reveal-left disabled" title="Registo inícia a 7 de dezembro!">O registo de senhas terminou</button>
                            <?php } else { ?>
                                <button type="button" class="btn btn-lg btn-roundeded btn-reveal btn-reveal-left "><a href="<?php echo base_url("clientes"); ?>">Registar senhas</a><i class="fa fa-arrow-right"></i></button>

                            <?php } ?>

                        </div>
                    </div>

                    <br>

                    <h2 class="text-center p-t-200"><a title="Mais info." href="#mais"><i class="icon-arrow-down"></i></a></h2>


                    <!-- <div class="row" style="padding-top:12%;">
                        <div class="col-lg-3" data-animate="fadeInUp" data-animate-delay="600">
                            <h4>Comerciantes</h4>
                            <p>A iniciativa é extensiva a todos comerciantes do concelho da Mealhada</p>
                            <button type="button" class="btn btn-roundeded btn-reveal btn-reveal-left"><a href="<?php echo base_url("adesao"); ?>">Aderir</a><i class="fa fa-arrow-right"></i></button>

                        </div>
                        <div class="col-lg-3" data-animate="fadeInUp" data-animate-delay="1200">
                            <h4>Iniciativa</h4>
                            <p>Decorre entre 7 de dezembro de 3022 e 15 de janeiro de 2024</p>
                            <button type="button" class="btn btn-roundeded btn-reveal btn-reveal-left"><a href="#mais">Saber mais</a><i class="fa fa-arrow-right"></i></button>

                        </div>
                        <div class="col-lg-3" data-animate="fadeInUp" data-animate-delay="1600">
                            <h4>Participação</h4>
                            <p>Por cada 15€ de compras será entregue ao cliente uma senha de participação</p>
                            <button type="button" class="btn btn-roundeded btn-reveal btn-reveal-left"><a href="<?php echo base_url("clientes"); ?>">Registar senhas</a><i class="fa fa-arrow-right"></i></button>

                        </div>
                        <div class="col-lg-3" data-animate="fadeInUp" data-animate-delay="2000">
                            <h4>Prémios</h4>
                            <p>Os consumidores habilitam-se a nove prémios de 25€ a 250€</p>
                            <button type="button" class="btn btn-roundeded btn-reveal btn-reveal-left"><a href="<?php echo base_url("sorteios"); ?>">Ver Sorteios</a><i class="fa fa-arrow-right"></i></button>

                        </div>
                    </div>
-->
                </div>


            </div>
        </div>
        <!-- end: Slide 1 -->
    </div>
    <!--end: Inspiro Slider -->

    <section class="p-b-40" id="mais">
        <div class="container">
            <div class="row">


                <div class="col-lg-6 ">
                    <img class="img-fluid rounded" src="images/cartaz_2022.jpg">
                </div>
                <div class="col-lg-6" style="text-align: justify">
                    <div class="heading-text heading-section">
                        <h2>Tômbola de Natal procura animar comércio</h2>
                    </div>
                    <span class="lead">Começa dia 7 de dezembro a tradicional Tômbola de Natal, dinamizada pela <a href="https://www.aciba.pt/" target="_blank">ACIBA – Associação Comercial e Industrial da Bairrada e Aguieira</a> com o apoio financeiro da Câmara da Municipal da Mealhada, que procura passar a mensagem aos consumidores de que o comércio local é a melhor opção para as compras de Natal.
                        O apoio financeiro da Câmara da Mealhada para esta iniciativa é de <strong>três mil euros</strong>.
                </div>
            </div>
        </div>
    </section>

    <section class="p-b-40">
        <div class="container">
            <div class="row">

                <div class="col-lg-6" style="text-align: justify">
                    <div class="heading-text heading-section">
                        <h2>Como funciona</h2>
                    </div>
                    <span class="lead">A iniciativa é extensiva a todos comerciantes do concelho da Mealhada que pretendam aderir e não só aos associados da ACIBA. Entre <strong>7 de dezembro e 15 de janeiro de 2023</strong>, por cada <strong>15€</strong> de compras será entregue, pelo estabelecimento comercial aderente, ao cliente, uma senha de participação, que depois de devidamente preenchida, o habilitará ao sorteio, num máximo de seis senhas por compra.

                        Os consumidores habilitam-se a dezoito (18) prémios em valores para compras: o primeiro, <strong>de 250€, o segundo de 175€, o terceiro de 100€, o quarto de 75€, o quinto de 50€ e quatro prémios de 25€</strong>. Serão sorteados 9 prémios no formato tradicional com a novidade de este ano existir uma tômbola digital que também irá atribuir outros 9 prémios.</span>
                </div>
                <div class="col-lg-6 image-middle">
                    <img class="img-fluid rounded" src="images/cupao.jpg">
                </div>
            </div>
        </div>
    </section>

    <?php if ($open) { ?>
        <section class="p-b-40">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 image-middle">
                        <img class="img-fluid rounded" src="images/comercio.jpg">
                    </div>
                    <div class="col-lg-6 " style="text-align: justify">
                        <div class="heading-text heading-section">
                            <h2>Comerciantes</h2>
                        </div>
                        <span class="lead ">Se é comerciante e quer aderir à iniciativa, é simples!<br>
                            Aceda ao <a href="<?php echo base_url("adesao"); ?>">formulário de adesão</a>, leia o <a href="<?php echo base_url("regulamento"); ?>">regulamento</a> e caso reúna as condições necessárias, submeta a sua candidatura.<br>

                            <!--<strong>A adesão de comerciantes decorre de 7 a 18 de novembro.</strong><br>-->
                            <span class="text-light">
                                <br>
                                <button type="button" class="btn btn-roundeded btn-reveal btn-reveal-left"><a href="<?php echo base_url("adesao"); ?>"><span>ADERIR</span></a><i class="fa fa-arrow-right"></i></button>
                            </span>

                        </span>
                    </div>

                </div>
            </div>
        </section>
    <?php } ?>

    <section class="p-b-40">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 ">
                    <img class="img-fluid rounded" src="images/concurso.jpg">
                </div>
                <div class="col-lg-6" style="text-align: justify">
                    <div class="heading-text heading-section">
                        <h2>Concurso de Montras</h2>
                    </div>
                    <span class="lead">O estabelecimento “Art & Style”, em Luso, foi o grande vencedor do “Concurso de Montras de Natal 2023” na Mealhada (ver tabela abaixo), uma iniciativa promovida pela ACIBA – Associação Comercial e Industrial da Bairrada e Aguieira, em parceria com o Município de Mealhada e o jornal online Bairrada Informação, que visou promover a interação entre os comerciantes do concelho de Mealhada, bem como a sua a criatividade, por forma a dinamizar e valorizar o comércio local, tornando-o mais atrativo durante a quadra natalícia.</span>
                    <span class="text-light"><br>
                        <button type="button" class="btn btn-roundeded btn-reveal btn-reveal-left"><a href="https://www.bairradainformacao.pt/2023/01/10/art-style-de-luso-vence-concurso-de-montras-de-natal-2022-da-aciba/?fbclid=IwAR3CXaYhU0DCVNoaPKpP4kH7_uBVkWgW6-_OnI0owPyiTNVtUodg8GWFCcQ" target="_blank"><span>Ver notícia completa</span></a><i class="fa fa-arrow-right"></i></button>
                    </span>
                </div>

            </div>
        </div>
    </section>


    <section class="p-b-40">
        <div class="container">
            <div class="row">


                <div class="col-lg-6" style="text-align: justify">
                    <div class="heading-text heading-section text-right">
                        <h2 class="text-right">Comprar no comércio local</h2>
                    </div>
                    <span class="lead">Para participar na iniciativa, basta efetuar compras num dos
                        <!--<a href="<?php echo base_url("comerciantes"); ?>">-->estabelecimentos aderentes
                        <!--</a>--> para ter direito a uma ou mais senhas. Depois de
                        <!--<a href="<?php echo base_url("clientes"); ?>">-->registar
                        <!--</a>--> as senhas no portal ou inserir na tômbola física, pode habilitar-se aos prémios em compras de 25€ a 250€ para usar num dos estabelecimentos aderentes.<br>
                        Quanto mais compras efetuar, mais senhas receberá e mais hipóteses terá de ganhar!<br>
                        O período de compras inicia a 7 de dezembro de 2023 e decorre até 15 de janeiro de 2024.<br><br>
                    </span>
                    <?php if ($openR) { ?>
                        <span class="text-light">
                            <br>
                            <button type="button" class="btn btn-roundeded btn-reveal btn-reveal-left"><a href="<?php echo base_url("clientes"); ?>"><span>REGISTAR SENHAS</span></a><i class="fa fa-arrow-right"></i></button>
                        </span>
                    <?php } ?>
                </div>
                <div class="col-lg-6 image-middle">
                    <img class="img-fluid rounded" src="images/cliente.jpg">
                </div>

            </div>
        </div>
    </section>

</div>

<?= $this->endSection() ?>