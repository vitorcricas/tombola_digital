<?= $this->extend('templates/default_layout') ?>


<?= $this->section('content') ?>

<section class="pt-15 pb-15" data-bg-image="<?php echo base_url("images/pages/login.jpg"); ?>">
    <div class="bg-overlay"></div>

    <div class="container">
        <div class="row">


            <div class="col-md-10 col-lg-8 col-xl-6 mx-auto">
                <?php if ($message != "") { ?>
                    <div id="infoMessage" class="alert alert-danger"><?php echo $message; ?></div>
                <?php } ?>
                <div class="card">
                    <div class="card-header py-5 px-sm-5">
                        <h6 class="h3 mb-1"> <?php echo lang('Auth.forgot_password_heading'); ?></h6>
                        <p class="text-muted mb-0">Insira o email com que registou a sua conta</p>

                    </div>


                    <span class="clearfix"></span>

                    <?php
                    $attributes = ['role' => 'form'];
                    echo form_open('auth/forgot_password', $attributes);

                    $submit = array(
                        'name' => 'submit',
                        'id' => 'submit',
                        'value' => 'true',
                        'type' => 'submit',
                        'class' => 'btn-reveal btn-reveal-left btn btn-primary btn-block btn-primary',
                        'content' => 'Recuperar <i class="fa fa-arrow-right"></i>'
                    );

                    ?>

                    <div class="card-body py-5 px-sm-5">

                        <div class="row mb-3">
                            <label for="identity" class="col-sm-3 col-form-label  no-padding-right required "><?php echo (($type === 'email') ? sprintf(lang('Auth.forgot_password_email_label'), $identity_label) : sprintf(lang('Auth.forgot_password_identity_label'), $identity_label)); ?></label>
                            <div class="col-sm-9"><?php echo form_input($identity); ?></div>
                        </div>

                        <div class="row mb-3">
                            <div class="mt-4 col-md-6"><?php echo form_button($submit); ?></div>
                            <div class="mt-4 col-md-6"> <a href="<?php echo site_url('/clientes'); ?> " class='btn-reveal btn-reveal-left btn btn-primary btn-block btn-danger'><i class="fa fa-arrow-right"></i>Voltar</a></div>

                        </div>

                    </div>
                    <?php echo form_close(); ?>

                </div>
            </div>
        </div>
</section>


<?= $this->endSection() ?>