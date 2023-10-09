<?= $this->extend('templates/default_layout') ?>
<?= $this->section('content') ?>

<?= $this->include('templates/sidebar') ?>


<div class="container-fluid">
    <div style='height:20px;'></div>
    <div style="padding: 10px">
        <?php echo $output; ?>
    </div>
</div>

