<div id="topbar" class="dark topbar-colored topbar-fullwidth">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <ul class="top-menu">
                    <?php if ($ionAuth->inGroup("clientes")) { ?>
                        <li <?php if ($submenu == 0) { ?>class="current" <?php } ?>><a href="<?php echo base_url("dashboard"); ?>">Início</a></li>
                        <?php if ($hasQuiz) { ?>
                            <li <?php if ($submenu == 1) { ?>class="current" <?php } ?>><a href="<?php echo base_url("clientes/cupoes/"); ?>">Senhas</a></li>
                            <li <?php if ($submenu == 4) { ?>class="current" <?php } ?>><a href="<?php echo base_url("clientes/sorteios/"); ?>">Sorteios</a></li>
                        <?php }
                    } else if ($ionAuth->inGroup("comerciantes") || $ionAuth->isAdmin()) { ?>
                        <li <?php if ($submenu == 0) { ?>class="current" <?php } ?>><a href="<?php echo base_url("dashboardC"); ?>">Início</a></li>
                        <li <?php if ($submenu == 5) { ?>class="current" <?php } ?>><a href="<?php echo base_url("comerciantes/vouchers/"); ?>">Gestão de Senhas</a></li>

                        <li <?php if ($submenu == 1) { ?>class="current" <?php } ?>><a href="<?php echo base_url("comerciantes/cupoes/"); ?>">Registos</a></li>
                        <li <?php if ($submenu == 2) { ?>class="current" <?php } ?>><a href="<?php echo base_url("comerciantes/listagem/"); ?>">Comerciantes</a></li>
                        <li <?php if ($submenu == 3) { ?>class="current" <?php } ?>><a href="<?php echo base_url("comerciantes/pedidosAdesao/"); ?>">Pedidos de Adesão</a></li>
                        <li <?php if ($submenu == 6) { ?>class="current" <?php } ?>><a href="<?php echo base_url("comerciantes/quizzes/"); ?>">Quizzes</a></li>
                        <li <?php if ($submenu == 7) { ?>class="current" <?php } ?>><a href="<?php echo base_url("admin/stats/"); ?>">Estatísticas</a></li>
                        <li <?php if ($submenu == 8) { ?>class="current" <?php } ?>><a href="<?php echo base_url("admin/draw/"); ?>">Sorteio</a></li>

                    <?php } ?>

                </ul>
            </div>
            <div class="col-md-6 d-none d-sm-block">
                <ul class="top-menu " style="float:right">
                    <!--<li class="social-facebook"><a href="#"><i class="fab fa-facebook-f"></i></a></li>-->
                    <li><a href="<?php echo base_url("auth/edit_user/" . $user->id); ?>">Dados Pessoais</a></li>
                    <li><a href="<?php echo base_url("auth/logout"); ?>">Logout</a></li>

                </ul>
            </div>
        </div>
    </div>
</div>