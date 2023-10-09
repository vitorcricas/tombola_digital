<?= $this->extend('templates/default_layout') ?>
<?= $this->section('content') ?>

<link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pivottable/2.19.0/pivot.min.css" />

<style>
    body {
        font-family: Verdana;
    }

    .c3-line,
    .c3-focused {
        stroke-width: 3px !important;
    }

    .c3-bar {
        stroke: white !important;
        stroke-width: 1;
    }

    .c3 text {
        font-size: 12px;
        color: grey;
    }

    .tick line {
        stroke: white;
    }

    .c3-axis path {
        stroke: grey;
    }

    .c3-circle {
        opacity: 1 !important;
    }

    .c3-xgrid-focus {
        visibility: hidden !important;
    }

    .node {
        border: solid 1px white;
        font: 10px sans-serif;
        line-height: 12px;
        overflow: hidden;
        position: absolute;
        text-indent: 2px;
    }

    table.pvtTable thead tr th, table.pvtTable tbody tr td  {
        font-size:13px !important;
    } 
</style>

<?= $this->include('templates/sidebar') ?>


<div class="container-fluid" style="overflow:auto">
    <div style='height:20px;'></div>
    <div style="padding: 10px">
    <a class="btn btn-default" href="<?php echo base_url("admin/statsQuiz"); ?>">Quizzes</a>

        <div id="output" style="margin: 30px;"></div>
    </div>
</div>


<?= $this->endSection() ?>

<?= $this->section('extra_scripts') ?>

<script src="https://cdn.plot.ly/plotly-basic-latest.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pivottable/2.23.0/pivot.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pivottable/2.23.0/pivot.pt.min.js"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pivottable/2.23.0/plotly_renderers.min.js"></script>

<script type="text/javascript">
    // This example adds C3 chart renderers.

    $(document).ready(function() {

        $(function() {

            var renderers = $.extend($.pivotUtilities.locales["pt"].renderers, $.pivotUtilities.plotly_renderers);


            var dateFormat = $.pivotUtilities.derivers.dateFormat;
            var sortAs = $.pivotUtilities.sortAs;
            var numberFormat = $.pivotUtilities.numberFormat;
            var tpl = $.pivotUtilities.aggregatorTemplates;

            jQuery.ajax({
                type: "POST",
                url: "<?php echo base_url("admin/getEstatisticas"); ?>",
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                data: [],
                success: function(data) {
                    $("#output").pivotUI(data, {
                        renderers: renderers,
                        rendererName: "Tabela",
                        //hiddenAttributes: ["mês"],
                        /* aggregators: {
                        "Atendimentos": function() { return tpl.uniques(numberFormat)(["atendidos"])}
                    },*/
                        cols: ["dia"],
                        //rows: ["Comerciante"],
                        vals: ["voucher"],
                        aggregatorName: "Contagem de Valores únicos",
                        //aggregatorName: "Contagem",

                        /*derivedAttributes: {
                            "Mês Entrada": dateFormat("mês", "%n", true)
                        },*/
                        sorters: {
                            "mês": sortAs(["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"]),
                        },
                        rowOrder: "key_a_to_z",
                    }, false, "pt");

                  //  $('select').addClass('form-control');
                }
            });

        });
    });
</script>


<?= $this->endSection() ?>