<?= $this->extend('templates/default_layout') ?>


<?= $this->section('content') ?>

<style>
    .required:after {
        content: " *";
        color: red;
    }
</style>


<section class="pt-15 pb-15" data-bg-image="<?php echo base_url("images/pages/login.jpg"); ?>">


    <div class="bg-overlay"></div>

    <div class="container-fluid d-flex flex-column">
        <div class="row align-items-center">
            <div class="col-md-6 col-lg-4 col-xl-3 mx-auto">
                <?php if ($message != "") { ?>
                    <div id="infoMessage" class="alert alert-<?= ($messagetype); ?>"><?php echo $message; ?></div>
                <?php } ?>
                <div class="card">

                    <div class="card-header py-5 px-sm-5">
                        <h6 class="h3 mb-1"> <?php echo lang('Auth.login_heading'); ?></h6>
                        <p class="text-muted mb-0"><?php echo lang('Auth.login_subheading'); ?></p>
                    </div>

                    <div class="card-body py-5 px-sm-5">
                        <span class="clearfix"></span>
                        <?php echo form_open('auth/login'); ?>
                        <div class="form-group">
                            <label for="identity">Email</label>
                            <div class="input-group">
                                <?php echo form_input($identity); ?>
                                <span class="input-group-text"><i class="icon-user"></i></span>
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="password">Password</label>
                            <div class="input-group show-hide-password">
                                <?php echo form_input($password); ?>
                                <span class="input-group-text"><i class="icon-eye-off" aria-hidden="true" style="cursor: pointer;"></i></span>
                            </div>
                        </div>
                        <?php
                        $submit = array(
                            'name' => 'submit',
                            'id' => 'submit',
                            'value' => 'true',
                            'type' => 'submit',
                            'class' => 'btn-reveal btn-reveal-left btn btn-primary btn-block btn-primary',
                            'content' => 'Entrar <i class="fa fa-arrow-right"></i>'
                        );
                        ?>

                        <div class="mt-4"><?php echo form_button($submit); ?></div>

                        <div class="row">
                            <div class="col-md-6 mt-4 text-center"><a class="btn btn-outline btn-dark btn-roundeded" href="<?= $google_button; ?>">Login com &nbsp; <img height="24px" src="<?php echo base_url("images/icon-google.png"); ?>"></a></div>
                            <div class="col-md-6 mt-4 text-center"><a class="btn btn-outline btn-dark btn-roundeded" href="<?= $facebook_button; ?>">Login com &nbsp; <img height="24px" src="<?php echo base_url("images/icon-facebook.png"); ?>"></a></div>
                        </div>

                        </form>
                        <?php if ($user_registration) { ?>
                            <div class="mt-4 text-center"><small>Não está registado?</small> <a href="<?php echo site_url('/registar'); ?>" class="small fw-bold"><?php echo lang('Auth.login_not_registed'); ?></a>
                            <?php } ?>
                            </div>

                            <?php echo form_close(); ?>

                    </div>
                    <div id="formFooter" class="mt-4 card-footer text-center">
                        <a class="underlineHover" href="<?php echo site_url('/auth/forgot_password'); ?>"><?php echo lang('Auth.login_forgot_password'); ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>

<?= $this->endSection() ?>
