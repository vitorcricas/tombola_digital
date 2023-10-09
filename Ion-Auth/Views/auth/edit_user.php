<?= $this->extend('templates/default_layout') ?>
<?= $this->section('content') ?>

<?= $this->include('templates/sidebar') ?>


<style>
    .required:after {
        content: " *";
        color: red;
    }
</style>

<section class="pt-15 pb-15" data-bg-image="<?php echo base_url("images/pages/login.jpg"); ?>">
    <div class="bg-overlay"></div>

    <div class="container">
        <div class="row">


            <div class="col-md-12 col-lg-10 col-xl-8 mx-auto">
                <?php if ($message != "") { ?>
                    <div id="infoMessage" class="alert alert-danger"><?php echo $message; ?></div>
                <?php } ?>
                <div class="card">
                    <div class="card-header py-5 px-sm-5">
                        <h3><?php echo lang('Auth.edit_user_heading'); ?></h3>
                        <p><?php echo lang('Auth.edit_user_subheading'); ?></p>

                    </div>


                    <span class="clearfix"></span>

                    <?php
                    $attributes = ['role' => 'form'];
                    echo form_open(uri_string(), $attributes);
                    $labelAttributesR = ['class' => 'col-sm-3 col-form-label no-padding-right required'];
                    $labelAttributes = ['class' => 'col-sm-3 col-form-label no-padding-right']; ?>

                    <div class="card-body py-5 px-sm-5">

                        <div class="row mb-3">

                            <?php echo form_label(lang('Auth.edit_user_fname_label'), 'first_name', $labelAttributesR); ?>

                            <div class="col-sm-9">
                                <?php echo form_input($first_name); ?>
                            </div>
                            <?php echo form_label(lang('Auth.edit_user_email_label'), 'email', $labelAttributesR); ?>

                            <div class="col-sm-9">
                                <?php echo form_input($email); ?>
                            </div>
                            <?php echo form_label(lang('Auth.edit_user_phone_label'), 'telefone', $labelAttributes); ?>

                            <div class="col-sm-9">
                                <?php echo form_input($telefone); ?>
                            </div>

                            <h4>Password</h4>


                            <?php echo form_label(lang('Auth.edit_user_password_label'), 'password', $labelAttributes); ?>

                            <div class="col-md-9">
                                <?php echo form_input($password); ?>
                            </div>

                            <?php echo form_label(lang('Auth.edit_user_password_confirm_label'), 'password_confirm', $labelAttributes); ?>

                            <div class="col-md-9">
                                <?php echo form_input($password_confirm); ?>
                            </div>

                            <?php if ($ionAuth->isAdmin()) : ?>

                                <h3><?php echo lang('Auth.edit_user_groups_heading'); ?></h3>
                                <?php foreach ($groups as $group) : ?>
                                    <label class="checkbox">
                                        <?php
                                        $gID = $group['id'];
                                        $checked = null;
                                        $item = null;
                                        foreach ($currentGroups as $grp) {
                                            if ($gID == $grp->id) {
                                                $checked = ' checked="checked"';
                                                break;
                                            }
                                        }
                                        ?>
                                        <input type="checkbox" name="groups[]" value="<?php echo $group['id']; ?>" <?php echo $checked; ?>>
                                        <?php echo htmlspecialchars($group['name'], ENT_QUOTES, 'UTF-8'); ?>
                                    </label>
                                <?php endforeach ?>

                            <?php endif ?>

                            <?php echo form_hidden('id', $user->id); ?>


                            <div class="clearfix form-actions">
                                <div class="col-md-offset-3 col-md-9">
                                    <?php echo form_button(array('name' => 'submit', 'type' => 'submit', 'class' => 'btn btn-info', 'content' => '<i class="ace-icon fa fa-check bigger-110"></i>' . lang('Auth.edit_user_submit_btn'))); ?>
                                    <button class="btn btn-danger" onClick="return redirect('<?php echo base_url('/dashboard'); ?>');">'<i class="ace-icon fa fa-undo bigger-110"></i>Cancelar</button>

                                </div>


                                <?php echo form_close(); ?>

                                <script>
                                    function redirect(url) {
                                        window.location.href = url;
                                        return false;
                                    }
                                </script>

                            </div>

                        </div>


                    </div>

                </div>
            </div>
        </div>
    </div>
    </div>
</section>




<?= $this->endSection() ?>