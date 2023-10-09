<?= $this->extend('templates/default_layout') ?>
<?= $this->section('content') ?>

<style>
    #map_canvas {
        height: 700px;
    }

    .card-header {
        padding: .75rem .75rem;
    }

    .gm-style-iw-d p {
        line-height: 1em;
    }

    .card-body a {
        color: #333;
        text-decoration: underline;
    }
</style>

<script>
    var atividades = [],
        atividadesDef = [];
    var disponibilidades = ["Disponível", "A esgotar brevemente", "Indisponível"];
    var disponibilidadesDef = ["Disponível", "A esgotar brevemente", "Indisponível"];
    var freguesias = ["Antes", "Barcouço", "Casal Comba", "Luso", "Mealhada", "Pampilhosa", "Vacariça", "Ventosa do Bairro"];
    var freguesiasDef = ["Antes", "Barcouço", "Casal Comba", "Luso", "Mealhada", "Pampilhosa", "Vacariça", "Ventosa do Bairro"];
</script>



<div class="body-inner">

    <section id="page-content">
        <div class="container">
            <div class="row">

                <div class="sidebar sticky-sidebar col-lg-4">
                    <!--widget newsletter-->
                    <div class="row">


                        <div class="col-lg-6 col-xs-12">
                            <button type="button" class="btn-reveal btn-reveal-left btn btn-default btn-small text-light"><i class="fas fa-hand-point-right"></i>&nbsp;<a href="<?php echo base_url('/adesao'); ?>"> Quero aderir</a></button>
                        </div>
                        <div class="col-lg-6 col-xs-12">

                            <button type="button" class="btn btn-block btn-primary btn-roundeded" id="btn_map"><i class="icon-map"></i>&nbsp;Ver mapa</button>
                            <button type="button" style="display:none" class="btn btn-block btn-primary btn-roundeded" id="btn_list"><i class="fa fa-list"></i>&nbsp;Ver lista</button>
                        </div>
                    </div>

                    <div class=" widget-newsletter">
                        <div class="input-group">
                            <input type="text" aria-required="true" name="pesquisar" id="pesquisar" class="form-control widget-search-form" placeholder="Pesquisar...">
                            <button class="btn btn-primary" type="button" id="searchMerchant"><i class="fa fa-search"></i></button>
                        </div>
                    </div>


                    <div class="card  text-left">

                        <h4 class="card-header">Setor de Atividade</h4>
                        <div class="card-body">
                            <div class="col-lg-12">
                                <label class="p-checkbox">
                                    <span>Todos</span>
                                    <input type="checkbox" class="check_atividades" name="check_atividades[]" checked="" value="0">
                                    <span class="p-checkbox-style"></span>
                                </label>
                            </div>
                            <?php foreach ($areas as $atividade) : ?>

                                <script>
                                    atividades.push('<?= $atividade["atividade"] ?>');
                                    atividadesDef.push('<?= $atividade["atividade"] ?>');
                                </script>

                                <div class="col-lg-12">
                                    <label class="p-checkbox">
                                        <span><?= $atividade["atividade"] ?></span>
                                        <input type="checkbox" class="check_atividades" name="check_atividades[]" checked="" value="<?= $atividade["atividade"] ?>">
                                        <span class="p-checkbox-style"></span>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="card  text-left">

                        <h4 class="card-header">Freguesia</h4>
                        <div class="card-body">
                            <div class="col-lg-12">
                                <label class="p-checkbox">
                                    <span>Todas</span>
                                    <input type="checkbox" class="check_freg" name="check_freg[]" checked="" value="0">
                                    <span class="p-checkbox-style"></span>
                                </label>
                            </div>
                            <?php foreach ($freguesias as $freguesia) : ?>

                                <div class="col-lg-12">
                                    <label class="p-checkbox">
                                        <span><?= $freguesia["freguesia"] ?></span>
                                        <input type="checkbox" class="check_freg" name="check_freg[]" checked="" value="<?= $freguesia["freguesia"] ?>">
                                        <span class="p-checkbox-style"></span>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>


                    <!--<div class="card  text-left">

                        <h4 class="card-header">Diponibilidade</h4>
                        <div class="card-body">
                            <div class="col-lg-12">
                                <h5>Todos</h5>
                                <label class="p-switch switch-color-primary">
                                    <input type="checkbox" name="check_disp[]" class="check_disp" checked value="0"><span class="p-switch-style"></span>
                                </label>
                            </div>

                            <div class="col-lg-12">
                                <h5>Disponível</h5>
                                <label class="p-switch switch-color-success">
                                    <input type="checkbox" name="col-lg-3check_disp[]" class="check_disp" value="Disponível" checked><span class="p-switch-style"></span>
                                </label>
                            </div>

                            <div class="col-lg-12">
                                <h5>A esgotar brevemente</h5>
                                <label class="p-switch switch-color-warning">
                                    <input type="checkbox" name="check_disp[]" class="check_disp" value="A esgotar brevemente" checked><span class="p-switch-style"></span>
                                </label>
                            </div>
                            <div class="col-lg-12">
                                <h5>Indisponível</h5>
                                <label class="p-switch switch-color-danger">
                                    <input type="checkbox" name="check_disp[]" class="check_disp" value="Indisponível" checked><span class="p-switch-style"></span>
                                </label>
                            </div>
                        </div>
                    </div>-->
                </div>

                <div class="col-lg-8" id="page_map" style="display:none">
                    <div class="merchant_list mb-4">
                        <h4> <?= count($comerciantes) ?> comerciantes encontrados</h4>
                    </div>
                    <div id="map_canvas"></div>
                </div>

                <div class="col-lg-8" id="page_list">

                    <div class="merchant_list mb-4">
                        <h4> <?= count($comerciantes) ?> comerciantes encontrados</h4>
                    </div>

                    <?php

                    foreach ($comerciantes as $comerciante) : ?>

                        <?php
                        $disponibilidade = "Disponível";

                        if (intval($comerciante["disponivel"]) <= 0)
                            $disponibilidade = "Indisponível";
                        else if (intval($comerciante["disponivel"]) < 10)
                            $disponibilidade = "A esgotar brevemente";
                        ?>

                        <div class="card text-left merchant_info" data-nome="<?= $comerciante["nome"] ?>" data-freg="<?= $comerciante["freguesia"] ?>" data-disp="<?= $disponibilidade ?>" data-setor="<?= $comerciante["setor"] ?>">
                            <div class="card-header">
                                <h3><?= $comerciante["nome"] ?></h3>
                                <?php /*if ($disponibilidade == "Disponível")
                                        echo '<button type="button" class="btn btn-success">
                                        ' . $disponibilidade . ' <span class="badge badge-light">' . $comerciante["disponivel"] . '</span>
                                    </button>';
                                    else if ($disponibilidade == "A esgotar brevemente")
                                        echo '<button type="button" class="btn btn-warning">
                                    ' . $disponibilidade . ' <span class="badge badge-light">' . $comerciante["disponivel"] . '</span>
                                    </button>';
                                    else
                                        echo '<button type="button" class="btn btn-danger">
                                        ' . $disponibilidade . ' <span class="badge badge-light">' . $comerciante["disponivel"] . '</span>
                                        </button>';*/
                                ?>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <?php
                                        if (file_exists(FCPATH . "/images/aderentes/" . $comerciante["id_comerciante"] . ".jpg")) : ?>
                                            <div class="grid-item">
                                                <div class="grid-item-wrap">
                                                    <div class="grid-image"> <img alt="<?= $comerciante["nome"]; ?>" class="img-fluid img-thumbnail" src="<?php echo base_url("images/aderentes/" . $comerciante["id_comerciante"] . ".jpg"); ?>">
                                                    </div>
                                                    <div class="grid-description">
                                                        <a title="<?= $comerciante["nome"]; ?>" data-lightbox="image" href="<?php echo base_url("images/aderentes/" . $comerciante["id_comerciante"] . ".jpg"); ?>" class="btn btn-light btn-roundeded">Zoom</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--<img src="<?php echo base_url("images/aderentes/" . $comerciante["id_comerciante"] . ".jpg"); ?>" class="img-fluid img-thumbnail" alt="">-->
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-lg-8">
                                        <p><i class="fas fa-briefcase" title="setor"></i> <?= $comerciante["setor"] ?></span><br>
                                            <i class="fas fa-map-marker-alt"></i> <a class='gmap-lightbox' href='#' data-src='https://www.google.com/maps/embed/v1/place?key=<?= $apikey ?>&q=<?= $comerciante["gps"] ?>&center=<?= $comerciante["gps"] ?>&zoom=18&maptype=satellite'><?= $comerciante["morada"] ?> <?= $comerciante["freguesia"] ?></span><br></a>

                                            <i class="fa fa-mobile-alt"></i> <a href="tel:<?= $comerciante["contato"] ?>"><?= $comerciante["contato"] ?></a></span><br>
                                            <i class="fa fa-at"></i> <a href="mailto:<?= $comerciante["email"] ?>"><?= $comerciante["email"] ?></a></span>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!--<div class="card-footer text-muted">
                                </div>-->
                        </div>

                    <?php endforeach; ?>

                </div>


            </div>

        </div>
    </section>
</div>

<?= $this->endSection() ?>

<?= $this->section('extra_scripts') ?>

<script src="<?php echo base_url("plugins/bootstrap-switch/bootstrap-switch.min.js"); ?>"></script>
<link href="<?php echo base_url("plugins/bootstrap-switch/bootstrap-switch.css"); ?>" rel="stylesheet">

<script src="https://maps.googleapis.com/maps/api/js?key=<maps-api-key>&callback=initMap&v=weekly" defer></script>
<script src="https://unpkg.com/@googlemaps/markerclusterer/dist/index.min.js"></script>

<script>
    var map;

    $(document).ready(function() { //          


        $(document).on("click", '.gmap-lightbox', function() {
            $.magnificPopup.open({
                items: {
                    src: $(this).data("src"), // can be a HTML string, jQuery object, or CSS selector
                    type: 'iframe'
                }
            });
        });

        $(document).on("click", "#btn_map", function() {
            $("#btn_map").hide();
            $("#btn_list").show();

            $("html, body").animate({
                scrollTop: 0
            }, "fast");

            $("#page_map").fadeIn("slow");
            $("#page_list").fadeOut("quick");

            var latlngbounds = new google.maps.LatLngBounds();
            for (var i = 0; i < markerCluster.markers.length; i++) {

                latlngbounds.extend(new google.maps.LatLng(markerCluster.markers[i].position));
            }
            map.fitBounds(latlngbounds);
        });

        $(document).on("click", "#btn_list", function() {
            $("#btn_map").show();
            $("#btn_list").hide();

            $("#page_list").fadeIn("slow");
            $("#page_map").fadeOut("quick");
        });


        $(document).on("click", "#searchMerchant", function() {
            toggleMerchants();

        });


        $(document).on("change", ".check_atividades", function() {

            var check_atividades = $(this).val();
            var checked = $(this).prop("checked");
            //todo guarda na sessão? senão tem de fazer tudo em jquery inclusive carregar ficha do comerciante!
            //todo show map...

            if (check_atividades == 0) {
                $('.check_atividades').each(function(i, obj) {
                    $(obj).prop('checked', checked);
                });
                if (checked)
                    atividades = atividadesDef;
                else
                    atividades = [];
            } else {
                if (checked) {
                    atividades.push(check_atividades);

                    if (atividades.length == atividadesDef.length)
                        $(".check_atividades[value=0]").prop("checked", true);

                } else {
                    $(".check_atividades[value=0]").prop("checked", false);

                    index = atividades.indexOf(check_atividades);

                    if (index > -1)
                        atividades.splice(index, 1);
                }
            }
            toggleMerchants();


        });

        /*$(document).on("change", ".check_disp", function() {

            var check_disp = $(this).val();
            var checked = $(this).prop("checked");

            if (check_disp == 0) {
                $('.check_disp').each(function(i, obj) {
                    $(obj).p'.rop('checked', checked);
                });
                if (checked)
                    disponibilidades = disponibilidadesDef;
                else
                    disponibilidades = [];

            } else {
                if (checked) {
                    disponibilidades.push(check_disp);

                    if (disponibilidades.length == disponibilidadesDef.length)
                        $(".check_disp[value=0]").prop("checked", true);
                } else {
                    $(".check_disp[value=0]").prop("checked", false);

                    index = disponibilidades.indexOf(check_disp);
                    if (index > -1)
                        disponibilidades.splice(index, 1);
                }
            }

            toggleMerchants();
        });*/

        $(document).on("change", ".check_freg", function() {

            var check_freg = $(this).val();
            var checked = $(this).prop("checked");

            if (check_freg == 0) {
                $('.check_freg').each(function(i, obj) {
                    $(obj).prop('checked', checked);
                });
                if (checked)
                    freguesias = freguesiasDef;
                else
                    freguesias = [];

            } else {
                if (checked) {
                    freguesias.push(check_freg);

                    if (freguesias.length == freguesiasDef.length)
                        $(".check_freg[value=0]").prop("checked", true);
                } else {
                    $(".check_freg[value=0]").prop("checked", false);

                    index = freguesias.indexOf(check_freg);
                    if (index > -1)
                        freguesias.splice(index, 1);
                }
            }

            toggleMerchants();
        });

    });


    function toggleMerchants() {

        $(".merchant_list").fadeOut();

        ncomer = 0;

        $(".merchant_info").each(function(index) {
            if (freguesias.includes($(this).data("freg")) && atividades.includes($(this).data("setor")) && $(this).data("nome").toLowerCase().includes($("#pesquisar").val().toLowerCase())) {
                ncomer++;
                $(this).fadeIn("slow");
            } else
                $(this).fadeOut("slow");

        });

        if (ncomer == 0)
            $(".merchant_list").html("<h4 class='text-center'>Sem resultados</h4>").fadeIn();
        else
            $(".merchant_list").html("<h4>" + ncomer + ' comerciantes encontrados</h4>').fadeIn();;

        markerCluster.clearMarkers();

        for (var i = 0; i < markers.length; i++) {
            if (freguesias.includes(markers[i].freguesia) && atividades.includes(markers[i].atividade) && markers[i].nome.toLowerCase().includes($("#pesquisar").val().toLowerCase()))
                markerCluster.addMarker(markers[i]);
        }

        var latlngbounds = new google.maps.LatLngBounds();
        for (var i = 0; i < markerCluster.markers.length; i++)
            latlngbounds.extend(new google.maps.LatLng(markerCluster.markers[i].position));
        map.fitBounds(latlngbounds);

        $([document.documentElement, document.body]).animate({
            scrollTop: $(".merchant_list").offset().top
        }, 1000);


    }


    function initMap() {

        var pinColor = "FE7569";
        var pinImage = new google.maps.MarkerImage("http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|" + pinColor,
            new google.maps.Size(21, 34),
            new google.maps.Point(0, 0),
            new google.maps.Point(10, 34));
        var pinShadow = new google.maps.MarkerImage("http://chart.apis.google.com/chart?chst=d_map_pin_shadow",
            new google.maps.Size(40, 37),
            new google.maps.Point(0, 0),
            new google.maps.Point(12, 35));

        map = new google.maps.Map(document.getElementById("map_canvas"), {
            zoom: 12,
            center: {
                lat: 40.3605,
                lng: -8.4406
            },
        });
        const infoWindow = new google.maps.InfoWindow({
            content: "",
            disableAutoPan: true,
        });

        markers = pontos.map((ponto, i) => {
            label = ponto.label;
            position = ponto.position;
            atividade = ponto.atividade;
            freguesia = ponto.freguesia;
            nome = ponto.nome;


            const marker = new google.maps.Marker({
                position,
                atividade: atividade,
                freguesia: freguesia,
                nome: nome,
                 icon: '<?php echo base_url('/images/marker.png'); ?>',
                // shadow: pinShadow
                //label: label
            });

            marker.addListener("click", () => {
                infoWindow.setContent(ponto.label);
                infoWindow.open(map, marker);
            });
            return marker;
        });

        markerCluster = new markerClusterer.MarkerClusterer({
            map,
            markers
        });

        map.data.loadGeoJson('<?php echo base_url('/assets/uploads/freguesias.geojson'); ?>');

        map.data.setStyle(function(feature) {
            return {
                fillColor: "grey",
                fillOpacity: 0.2,
                strokeWeight: 1
            };
        });

    }



    pontos = [];

    <?php foreach ($comerciantes as $comerciante) : ?>
        <?php
        $lat = "";
        $lng = "";

        if ($comerciante["gps"] != null) {
            list($lat, $lng) = explode(',', $comerciante["gps"]);
        }

        if ($lat !== "") :

            $label = "<h4>" . $comerciante["nome"] . "</h4>";
            $label .= '<div class="row">' .
                '<div class="col-lg-4">' .
                '<img src="images/aderentes/' . $comerciante["id_comerciante"] . '.jpg" style="width:100%" class="img-thumbnail" alt="">' .
                '</div>' .
                '<div class="col-lg-8" ><span class=""><p><b>Setor:</b> </span><span>' . $comerciante["setor"] . '</span></p>' .
                '<p><span class=""><b>Freguesia:</b> </span><span>' . $comerciante["freguesia"] . '</span></p>' .
                '<p><span class="card-title"><b>Morada:</b> </span><span>' . $comerciante["morada"] . '</span></p>' .
                '<p><span class="card-title"><b>Contacto:</b> </span><span>' . $comerciante["contato"] . '</span></p>' .
                '<p><span class="card-title"><b>Email:</b> </span><span>' . $comerciante["email"] . '</span></p></div></div>';

        ?>
            ponto = {
                atividade: '<?= $comerciante["setor"] ?>',
                freguesia: '<?= $comerciante["freguesia"] ?>',
                nome: '<?= $comerciante["nome"] ?>',
                label: '<?= $label ?>',
                position: {
                    lat: <?= $lat ?>,
                    lng: <?= $lng ?>
                }
            }
            pontos.push(ponto);
        <?php endif; ?>
    <?php endforeach; ?>

    window.initMap = initMap;
</script>


<?= $this->endSection() ?>
