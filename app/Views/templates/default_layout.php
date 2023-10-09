<!DOCTYPE html>
<html lang="pt">

<head>
<meta name="title" content="Tômbola de Natal para dinamização do comércio local - Mealhada/ACIBA" />
    <meta name="copyright" content="CM Mealhada / ACIBA" />
    <meta name="robots" content="INDEX, FOLLOW" />
    <meta name="revisit-After" content="1 day" />
    <meta name="rating" content="General" />
    <meta name="owner" content="CM Mealhada / ACIBA" />
    <meta name="robots" content="index,follow" />
    <meta name="revisit-after" content="15 days" />
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">
    <meta name="format-detection" content="telephone=no">

    <meta property="og:title" content="Tômbola de Natal para dinamização do comércio local - Mealhada/ACIBA">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Tômbola de Natal para dinamização do comércio local - Mealhada/ACIBA">
    <meta property="og:locale" content="pt_PT" />
    <meta property="og:url" content="https://tombola.cm-mealhada.pt/">
    <meta property="og:image" content="https://tombola.cm-mealhada.pt/favicon.ico">
    <meta property="og:description" content="Tômbola de Natal para dinamização do comércio local - Mealhada/ACIBA">

    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta http-equiv="pragma" content="no-cache" />
    <meta http-equiv="cache-control" content="no-cache,no-store,must-revalidate" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta charset="UTF-8">
    <meta http-equiv="Content-Language" content="PT" />

    <link rel="shortcut icon" href="https://tombola.cm-mealhada.pt/favicon.ico" type="image/x-icon" />
    <link rel="icon" href="https//tombola.cm-mealhada.pt/favicon.ico" type="image/x-icon" />
    <link rel="alternate" hreflang="pt" href="https://tombola.cm-mealhada.pt/" />
    <link rel=”canonical” href=”https://tombola.cm-mealhada.pt/” />

    <?php
    if (isset($css_files)) :
        foreach ($css_files as $file) : ?>
            <link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
    <?php endforeach;
    endif; ?>

    <link href="<?php echo base_url("css/plugins.css"); ?>" rel="stylesheet">
    <link href="<?php echo base_url("css/style.css"); ?>" rel="stylesheet">
    <link href="<?php echo base_url("plugins/fontawesome/css/fontawesome.min.css"); ?>" rel="stylesheet">

</head>


<body>

    <div class="body-inner">

        <header id="header" data-transparent="false" class="dark submenu-light">
            <div class="header-inner">
                <div class="container">
                    <div id="logo">
                        <a href="<?php echo base_url("/"); ?>">
                            <img class="logo-default" src="<?php echo base_url("images/logo.png"); ?>">
                            <img class="logo-dark" src="<?php echo base_url("images/logo-dark.png"); ?>">
                        </a>
                    </div>

                    <div id="mainMenu-trigger"> <a class="lines-button x"><span class="lines"></span></a> </div>
                    <div id="mainMenu" class="menu-rounded">
                        <div class="container">
                            <nav>
                                <ul>
                                    <li <?php if ($menu == 1) echo "class='current'"; ?>><a href="<?php echo base_url("/"); ?>">Início</a></li>
                                    <li <?php if ($menu == 2) echo "class='current'"; ?>><a href="<?php echo base_url("/clientes"); ?>">Clientes</a></li>
                                    <li <?php if ($menu == 3) echo "class='current'"; ?>><a href="<?php echo base_url("/comerciantes"); ?>">Comerciantes</a></li>
                                    <!--<li <?php if ($menu == 4) echo "class='current'"; ?>><a href="<?php echo base_url("/sorteios"); ?>">Sorteios</a></li>-->
                                    <li <?php if ($menu == 5) echo "class='current'"; ?>><a href="<?php echo base_url("/regulamento"); ?>">Regulamento</a></li>
                                    <li <?php if ($menu == 9) echo "class='current'"; ?>><a href="<?php echo base_url("/sorteio"); ?>">Sorteio</a></li>
                                    <li <?php if ($menu == 8) echo "class='current'"; ?>><a href="<?php echo base_url("/montras"); ?>">Concurso Montras</a></li>

                                    <!--<li <?php if ($menu == 6) echo "class='current'"; ?>><a href="<?php echo base_url("/faq"); ?>">FAQ</a></li>-->
                                    <li <?php if ($menu == 7) echo "class='current'"; ?>><a href="<?php echo base_url("/contato"); ?>">Contato</a></li>

                                </ul>

                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <?= $this->renderSection('content') ?>


        <footer id="footer">
            <div class="footer-content">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 text-center">
                            <img src="<?php echo base_url("images/logo.png"); ?>">
                            <img src="<?php echo base_url("images/cmm_horizontal.png"); ?>">
                        </div>
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="widget">
                                        <div class="widget-title">TÔMBOLA</div>
                                        <ul class="list">
                                            <li><a href="<?php echo base_url("/clientes"); ?>">Login</a></li>
                                            <li><a href="<?php echo base_url("/comerciantes"); ?>">Comerciantes</a></li>
                                            <!--<li><a href="<?php echo base_url("/sorteios"); ?>">Sorteios</a></li>-->
                                            <li><a href="<?php echo base_url("/regulamento"); ?>">Regulamento</a></li>
                                            <li><a href="<?php echo base_url("/montras"); ?>">Concurso de Montras</a></li>

                                            <!--<li><a href="<?php echo base_url("/faq"); ?>">FAQ</a></li>-->
                                            <li><a href="<?php echo base_url("/contato"); ?>">Contato</a></li>

                                        </ul>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="widget">
                                        <div class="widget-title">MEALHADA</div>
                                        <ul class="list">
                                            <li><span class='icons_web icon-angle-right'></span><a title='' href='https://www.cm-mealhada.pt/menu/351/contactos_uteis'>Contactos úteis</a></li>
                                            <li><span class='icons_web icon-angle-right'></span><a title='' href='https://www.cm-mealhada.pt/menu/553/mealhada'>Mealhada</a></li>
                                            <li><span class='icons_web icon-angle-right'></span><a title='' href='https://www.cm-mealhada.pt/menu/334/onde_comer'>Onde Comer</a></li>
                                            <li><span class='icons_web icon-angle-right'></span><a title='' href='https://www.cm-mealhada.pt/menu/333/onde_ficar'>Onde Ficar</a></li>
                                            <li><span class='icons_web icon-angle-right'></span><a title='' href='https://www.cm-mealhada.pt/menu/332/o_que_visitar'>O que Visitar</a></li>
                                            <li><span class='icons_web icon-angle-right'></span><a title='' href='https://www.cm-mealhada.pt/menu/336/mata_nacional_do_bussaco'>Mata Nacional do Bussaco</a></li>
                                            <li><span class='icons_web icon-angle-right'></span><a title='' href='https://www.cm-mealhada.pt/menu/345/termas_de_luso'>Termas de Luso</a></li>
                                        </ul>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="call-to-action p-t-20 p-b-20  mb-0 call-to-action-dark">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <img class="img-fluid rounded" src="<?php echo base_url("images/sponsors.jpg"); ?>">
                        </div>
                    </div>
                </div>
            </div>

            <div class="copyright-content">
                <div class="container">
                    <div class="row">
                        <div class="copyright-text text-left col-md-9">© 2023 Município da Mealhada - Todos os direitos reservados.<a href="//www.cm-mealhada.pt" target="_blank" rel="noopener"> CMM</a> </div>
                        <div class="mb-4 social-icons social-icons-large social-icons-border social-icons-rounded social-icons-colored-hover col-md-3">
                            <ul>
                                <li class="social-tombola"><a href="https://www.aciba.pt/" target="_blank"><i class="fas fa-link"></i></a></li>
                                <li class="social-facebook"><a href="https://pt-pt.facebook.com/acibaoficial/" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                                <li class="social-tombola"><a href="mailto:geral@aciba.pt" target="_blank"> <i class="fas fa-envelope"></i></a></li>
                                <li class="social-tombola"><a href="tel:231201606" target="_blank"> <i class="fas fa-phone"></i></a></li>

                                <!--li class="social-twitter"><a href="#"><i class="fab fa-twitter"></i></a></li>
                            <li class="social-instagram"><a href="#"><i class="fab fa-instagram"></i></a></li>
                            <li class="social-youtube"><a href="#"><i class="fab fa-youtube"></i></a></li>-->
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </footer>
        <!-- end: Footer -->

    </div>
    <!-- end: Body Inner -->
    <!-- Scroll top -->
    <a id="scrollTop"><i class="icon-chevron-up"></i><i class="icon-chevron-up"></i></a>
    <!--Plugins-->
    <?php if (!isset($js_files)) { ?>
        <script src="<?php echo base_url("js/jquery.js"); ?>"></script>
        <script src="<?php echo base_url("js/bootstrap5.min.js"); ?>"></script>

        <?php } else {
        foreach ($js_files as $file) : ?>
            <script src="<?php echo $file; ?>"></script>
    <?php endforeach;
    } ?>

    <script src="<?php echo base_url("js/plugins.js"); ?>"></script>
    <!--Template functions-->
    <script src="<?php echo base_url("js/functions.js"); ?>"></script>

    <?= $this->renderSection('extra_scripts') ?>

    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
        var Tawk_API = Tawk_API || {},
            Tawk_LoadStart = new Date();
        (function() {
            var s1 = document.createElement("script"),
                s0 = document.getElementsByTagName("script")[0];
            s1.async = true;
            s1.src = 'https://embed.tawk.to/63999b0db0d6371309d45ba5/1gk80bbmp';
            s1.charset = 'UTF-8';
            s1.setAttribute('crossorigin', '*');
            s0.parentNode.insertBefore(s1, s0);
        })();
    </script>
    <!--End of Tawk.to Script-->

</body>

</html>