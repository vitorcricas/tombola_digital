<?= $this->extend('templates/default_layout') ?>

<?= $this->section('content') ?>
<?php
$premiosAtribuir = explode(",", $premios);
?>

<div class="body-inner">

    <section id="page-title" data-bg-parallax="images/parallax/montras.jpg">
        <div class="container">
            <div class="page-title">
                <div class="heading-text heading-line text-center mt-5">
                    <h4><span class="badge bg-success"><?= $totalCupoes ?> senhas a sorteio!</span></h4>

                </div>
                <?php if (count($premiosAtribuir) == count($premiados)) : ?>
                    <h4 class="text-light">O sorteio decorreu no dia 3 de fevereiro pelas 19h no edifício dos Paços do Concelho da Mealhada</h4>
                <?php else : ?>
                    <h4 class="text-light">O sorteio irá decorrer no dia 3 de fevereiro pelas 19h no edifício dos Paços do Concelho da Mealhada</h4>
                <?php endif; ?>

            </div>

        </div>
    </section>


    <section class="background-dark">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-4">
                    <div class="heading-text">
                        <?php if (count($premiosAtribuir) == count($premiados)) : ?>
                            <h2 class="text-light fw-800"><span>Parabéns a todos!</span></h2>
                        <?php endif; ?>
                        <img alt="" src="<?php echo base_url("images/prize-icon.png") ?>">
                    </div>
                </div>

                <div class="col-lg-8">
                    <?php if (count($premiosAtribuir) == count($premiados)) : ?>
                        <div class="heading-text heading-section text-light">
                            <h2>Lista de Premiados</h2>
                            <div class="row text-light">
                                <div class="table-responsive">
                                    <table class="table table-hover text-light">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Comerciante</th>
                                                <th scope="col">Cupão</th>
                                                <th scope="col">Prémio</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $npremio = 1;
                                            foreach ($premiados as $premiado) :
                                            ?>
                                                <tr>
                                                    <th scope="row"><?= $npremio ?>º</th>
                                                    <td><?= $premiado["nome"] ?> (<?= $premiado["freguesia"] ?>)</td>
                                                    <td><?= $premiado["codigo"] ?></td>
                                                    <td><?= $premiado["valor"] ?>€</td>
                                                </tr>
                                            <?php $npremio++;
                                            endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    <?php else : ?>
                        <div class="heading-text heading-section text-light">
                            <h2>Ainda não foram sortados prémios</h2>
                        </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </section>

</div>



<?= $this->endSection() ?>