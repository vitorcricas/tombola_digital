<?= $this->extend('templates/default_layout') ?>


<?= $this->section('content') ?>

<style>
    .required:after {
        content: " *";
        color: red;
    }

</style>

<div class="modal fade" id="rgpdModal" tabindex="-1" role="modal" aria-labelledby="modal-label-3" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 id="modal-label-3" class="modal-title">Tratamento e Proteção de Dados</h4>
                <button aria-hidden="true" data-bs-dismiss="modal" class="btn-close" type="button">×</button>
            </div>
            <div class="modal-body">
                <div class="row mb20">
                    <div class="col-md-12">
                        <h3>Informações Adicionais</h3>
                        <p>O tratamento dos dados recolhidos neste formulário por parte do Município da Mealhada respeitará a legislação em vigor em matéria de proteção de dados pessoais e será realizado com base nas seguintes condições:</p>
                        <p><b>- Responsável pelo tratamento - </b>Município de Mealhada;</p>
                        <p style="text-align: justify;"><b>- Finalidade do tratamento - </b> Os dados recolhidos destinam-se exclusivamente à realização do sorteio da Tômbola de Natal e ao tratamento de dados estatísticos</p>
                        <p style="text-align: justify;"><b>- Destinatário(s) dos dados - </b>Município da Mealhada</p>
                        <p style="text-align: justify;"><b>- Conservação dos dados pessoais - </b>12 meses</p>
                        <p>Para mais informações sobre a Política de Privacidade do Município consulte o nosso site em <a href="http://www.cm-mealhada.pt/menu/561/politica-de-privacidade" trarget="_blank">www.cm-mealhada.pt</a> ou envie um e-mail para <a href="mailto:dpo@cm-mealhada.pt">dpo@cm-mealhada.pt</a></p>
                        <h3>Proteção de Dados</h3>
                        <p>Os dados pessoais recolhidos no formulário para apresentação deste pedido são exclusivamente necessários para realização do sorteio de natal pelo Município. Em conformidade com o Regulamento Geral de Proteção de Dados (RGPD), encontra-se prevista, na seção acima (“Informações Adicionais”), informação sobre o tratamento dos dados pessoais disponibilizados, a realizar pelo Município.</p>
                        <p>Ao requerente (titular dos dados pessoais) é garantido o direito de acesso, de retificação, de apagamento, de portabilidade, de ser informado em caso de violação da segurança dos dados e de limitação e oposição ao tratamento dos dados pessoais recolhidos. O requerente (titular dos dados pessoais) tem ainda direito a apresentar reclamação à autoridade de controlo nacional (Comissão Nacional de Proteção de Dados).</p>
                        <p>Para mais informações sobre as Políticas de Privacidade do Município, consulte o nosso site em <a href="https://www.cm-mealhada.pt" target="_blank">www.cm-mealhada.pt</a> ou envie um e-mail para <a href="mailto:dpo@cm-mealhada.pt">dpo@cm-mealhada.pt</a>.</p>

                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button data-bs-dismiss="modal" class="btn btn-b" type="button">Fechar</button>
            </div>
        </div>
    </div>
</div>

<section class="pt-15 pb-15" data-bg-image="<?php echo base_url("images/pages/login.jpg"); ?>">
    <div class="bg-overlay"></div>

    <div class="container">
        <div class="row">

            <div class="col-md-12 col-lg-10 col-xl-8 mx-auto">
                <?php if ($message != "") { ?>
                    <div id="infoMessage"><?php echo $message; ?></div>
                <?php } ?>

                <div class="card">
                    <div class="card-header py-5 px-sm-5">
                        <h2><?php echo lang('Auth.register_user_heading'); ?></h2>
                        <h3><?php echo lang('Auth.register_user_subheading'); ?></h3>
                    </div>

                    <?php
                    $attributes = ['role' => 'form'];
                    echo form_open(uri_string(), $attributes);
                    $labelAttributesR = ['class' => 'col-sm-3 col-form-label no-padding-right required'];
                    $labelAttributes = ['class' => 'col-sm-3 col-form-label no-padding-right']; ?>

                    <div class="card-body py-5 px-sm-5">

                        <div class="row mb-3">
                            <?php echo form_label(lang('Auth.create_user_fname_label'), 'first_name', $labelAttributesR); ?>
                            <div class="col-sm-9">
                                <?php echo form_input($first_name); ?>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <?php echo form_label(lang('Auth.create_user_email_label'), 'email', $labelAttributesR); ?>

                            <div class="col-sm-9">
                                <?php echo form_input($email); ?>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <?php echo form_label(lang('Auth.create_user_phone_label'), 'telefone', $labelAttributes); ?>

                            <div class="col-sm-9">
                                <?php echo form_input($telefone); ?>
                            </div>
                        </div>


                        <div class="row mb-3">
                            <?php echo form_label(lang('Auth.create_user_password_label'), 'password', $labelAttributesR); ?>

                            <div class="col-sm-9">
                                <?php echo form_input($password); ?>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <?php echo form_label(lang('Auth.create_user_password_confirm_label'), 'password_confirm', $labelAttributesR); ?>

                            <div class="col-sm-9">
                                <?php echo form_input($password_confirm); ?>
                            </div>
                        </div>

                        <div class="row mb-3">

                            <div class="checkbox pull-left col-sm-offset-1">
                                <label><input type="checkbox" name="rgpd" id="rgpd" required> Tomei conhecimento e aceito as <a href="#" data-bs-target="#rgpdModal" data-bs-toggle="modal">condições do tratamento e proteção de dados</a></label>
                            </div>
                            <div class="checkbox pull-left col-sm-offset-1">
                                <label><input type="checkbox" required> Autorizo o tratamento dos dados recolhidos para efeitos de tratamento estatístico e análise de hábitos de consumo.</a></label>
                            </div>                            
                        </div>


                        <div class="clearfix form-actions">
                            <div class="offset-md-3 col-md-6">
                                <?php echo form_button(array('name' => 'submit', 'type' => 'submit', 'class' => 'btn-reveal btn-reveal-left mt-4 btn btn-primary btn-block btn-primary', 'content' => '<i class="fa fa-arrow-right"></i>&nbsp;' . lang('Auth.create_user_submit_btn'))); ?>

                            </div>




                        </div>

                    </div>

                    <?php echo form_close(); ?>


                </div>
            </div>


        </div>

    </div>
    </div>
    </div>







</section>

<?= $this->endSection() ?>


<?= $this->section('extra_scripts') ?>
<?= $this->endSection() ?>