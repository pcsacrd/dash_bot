<?php
require_once 'header.php';

$velocidade = 0;

if (isset($_COOKIE['cdistancia']) && isset($_COOKIE['ctempo'])) {
    $distancia = isset($_COOKIE['cdistancia']) ? floatval($_COOKIE['cdistancia']) : 0;
    $tempo = $_COOKIE['ctempo'];
    $tempoCalc = $_COOKIE['ctempoCalc'];

    if ($tempo != 0) {
        $velocidade = $distancia / $tempoCalc;
        $velocidade = number_format((float)$velocidade, 0, '.', '');
    } else {
        // Tratar o caso em que o tempo é zero para evitar divisão por zero
        $velocidade = 0;
    }

    $refresh = "DELETE FROM atividade";
    $resultRefresh = mysqli_query($conexao, $refresh);

    $query = "INSERT INTO atividade (distancia, tempo, velocidade) VALUES ('$distancia', '$tempoCalc', '$velocidade')";
    $resultQuery = mysqli_query($conexao, $query);
    if ($resultQuery) {
        
    } else {
        echo "Erro ao inserir valor na tabela atividade: " . mysqli_error($conexao);
    }
}
?>

<div class="title">
    <h1>Atividade Recente</h1>
</div>
<div class="content">
    <?php if (isset($distancia) && isset($tempo) && isset($velocidade)) { ?>
    <div class="conteiner">
        <h3>Distancia Percorrida</h3>
        <h2><?php echo $distancia; ?> metros</h2>
    </div>
    <div id="map" class="conteinerMap"></div>
    <div class="conteinerMini">
        <h3>Tempo </h3>
        <h2><?php echo $tempo; ?> min</h2>
    </div>
    <div class="conteinerMini">
        <h3>Velocidade Media</h3>
        <h2><?php echo $velocidade; ?> m/s</h2>
    </div>
    <?php } else { ?>
        <p class='invalidData'>Sem atividade recente</p>
    <?php } ?>
</div>

<div class="nav-bar">
    <a href="mainPage.php"><img src="/PAP/app/img/house.png"></a>
    <a href="startActivity.php"><img src="/PAP/app/img/plus.png"></a>
    <a href="profile.php"><img src="/PAP/app/img/profile.png" style="margin-right: 10px;"></a>
</div>
</div>
</body>

</html>

<script src="https://maps.googleapis.com/maps/api/js?libraries=geometry&key=AIzaSyBq1lhvicIhoCkr2ioEZmsD2zg7tlNtqSI"></script>
<script>
    function initialize() {
        <?php
        $sql = "SELECT * , LAG(estado,1,0) OVER (ORDER BY 'id_gps') AS 'ultimo_estado' FROM gps";
        if ($resultSql = mysqli_query($conexao, $sql)) {
            if (mysqli_num_rows($resultSql) >= 1) {
        ?>
                var mapProp = {
                    zoom: 15,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                };

                var map = new google.maps.Map(document.getElementById('map'), mapProp);

                var lineCoordinates = [];
                var totalDistance = 0;
                var prevPosition = 0;

                <?php

                while ($row = mysqli_fetch_array($resultSql)) { ?>
                    var lat = <?php echo $row['lat']; ?>;
                    var long = <?php echo $row['long']; ?>;
                    var estado = <?php echo $row['estado']; ?>;
                    var ultimo_estado = <?php echo $row['ultimo_estado']; ?>;

                    if ((estado == 0 && ultimo_estado == 0)) {

                    } else if ((estado == 1 && ultimo_estado == 0)) {

                        var position_i = new google.maps.LatLng(lat, long);
                        var marker_i = new google.maps.Marker({
                            animation: google.maps.Animation.BOUNCE,
                            position: position_i,
                            map: map,
                            icon: ('http://maps.google.com/mapfiles/ms/icons/green-dot.png')
                        });

                        marker_i.setMap(map);
                        lineCoordinates.push(position_i);
                        prevPosition = position_i;

                    } else if ((estado == 1 && ultimo_estado == 1)) {

                        var current_position = new google.maps.LatLng(lat, long);
                        var novo_marker = new google.maps.Marker({
                            animation: google.maps.Animation.BOUNCE,
                            position: current_position,
                            map: map,
                            visible: false
                        });

                        novo_marker.setMap(map);
                        lineCoordinates.push(current_position);

                        if (prevPosition) {
                            totalDistance += google.maps.geometry.spherical.computeDistanceBetween(prevPosition, current_position);
                        }
                        prevPosition = current_position;

                    } else if (estado == 0 && ultimo_estado == 1) {

                        var position_f = new google.maps.LatLng(lat, long);
                        var marker_f = new google.maps.Marker({
                            animation: google.maps.Animation.BOUNCE,
                            position: position_f,
                            map: map,
                            icon: ('http://maps.google.com/mapfiles/ms/icons/red-dot.png')
                        });

                        marker_f.setMap(map);
                        lineCoordinates.push(position_f);

                        if (prevPosition) {
                            totalDistance += google.maps.geometry.spherical.computeDistanceBetween(prevPosition, position_f);
                        }
                        prevPosition = position_f;
                    }
                <?php
                }
                ?>

                var latCenter = (position_i.lat() + position_f.lat()) / 2;
                var lngCenter = (position_i.lng() + position_f.lng()) / 2;
                var centerPoint = new google.maps.LatLng(latCenter, lngCenter);
                map.setCenter(centerPoint);

                var line = new google.maps.Polyline({
                    path: lineCoordinates,
                    geodesic: true,
                    strokeColor: '#FF0000',
                    strokeOpacity: 1.0,
                    strokeWeight: 2
                });
                line.setMap(map);

                totalDistance = Math.floor(totalDistance * 100) / 100;
                totalDistance = totalDistance.toFixed(0);
                document.cookie = "cdistancia=" + totalDistance + "; path=/";
        <?php
            }
        }
        ?>
    }
    google.maps.event.addDomListener(window, 'load', initialize);
</script>