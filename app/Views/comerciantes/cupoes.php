<?= $this->extend('templates/default_layout') ?>
<?= $this->section('content') ?>

<?= $this->include('templates/sidebar') ?>


<div class="container">
    <div style='height:20px;'></div>
    <div style="padding: 10px">
        <?php echo $output; ?>
    </div>
</div>


<?= $this->endSection() ?>


<?= $this->section('extra_scripts') ?>

<script>
    $(document).ready(function() { //          

        $("#form-button-save").hide();

    });
</script>

<?= $this->endSection() ?>