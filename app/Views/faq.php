<?= $this->extend('templates/default_layout') ?>

<?= $this->section('content') ?>

<div class="body-inner">

<section id="page-title" data-bg-parallax="images/parallax/tombola_wide.jpg">
<div class="container">
    <div class="page-title">
        <h1>FAQs</h1>
        <span>Questões Frequentes</span>
    </div>
   
</div>
</section>
<!-- end: Page title -->
<!-- Section -->
<section>
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h3>Campanha <small>(4)</small></h3>
            <div class="accordion toggle fancy radius clean">
                <div class="ac-item "><!-- ac-active -->
                    <h5 class="ac-title"><i class="fa fa-question-circle"></i>Em que consiste?</h5>
                    <div style="" class="ac-content">....................................................................................................................................</div>
                </div>
                <div class="ac-item">
                    <h5 class="ac-title"><i class="fa fa-question-circle"></i>outro</h5>
                    <div style="" class="ac-content">....................................................................................................................................</div>
                </div>
                <div class="ac-item">
                    <h5 class="ac-title"><i class="fa fa-question-circle"></i>outro</h5>
                    <div style="" class="ac-content">....................................................................................................................................</div>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <h3>Sou comerciante <small>(4)</small></h3>
            <!--<p>Tempora incidunt ut labore et dolore magnam auam quaerat voluptatem. Adipisci velit, sed quia non numquam eius modi.</p>-->
            <div class="accordion toggle fancy radius clean">
            <div class="ac-item "><!-- ac-active -->
                    <h5 class="ac-title"><i class="fa fa-question-circle"></i>Como me posso candidatar?</h5>
                    <div style="" class="ac-content">....................................................................................................................................</div>
                </div>
                <div class="ac-item">
                    <h5 class="ac-title"><i class="fa fa-question-circle"></i>outro</h5>
                    <div style="" class="ac-content">....................................................................................................................................</div>
                </div>
                <div class="ac-item">
                    <h5 class="ac-title"><i class="fa fa-question-circle"></i>outro</h5>
                    <div style="" class="ac-content">....................................................................................................................................</div>
                </div>
            </div>
        </div>
    </div>
    <div class="row m-t-40">
        <div class="col-lg-12">
            <h3>Sou consumidor <small>(5)</small></h3>
            <div class="accordion toggle fancy radius clean">
            <div class="ac-item "><!-- ac-active -->
                    <h5 class="ac-title"><i class="fa fa-question-circle"></i>Como posso participar?</h5>
                    <div style="" class="ac-content">....................................................................................................................................</div>
                </div>
                <div class="ac-item">
                    <h5 class="ac-title"><i class="fa fa-question-circle"></i>outro</h5>
                    <div style="" class="ac-content">....................................................................................................................................</div>
                </div>
                <div class="ac-item">
                    <h5 class="ac-title"><i class="fa fa-question-circle"></i>outro</h5>
                    <div style="" class="ac-content">....................................................................................................................................</div>
                </div>
            </div>
        </div>
        
    </div>
</div>
</section>

<?= $this->endSection() ?>