<?php
require_once 'header.php';
?>

<div class="activityTitle">
    <h1>TEMPO</h1>
</div>
<div class="content">
    <div class="atividade">
        <div class="clockCircle">
            <label id="minutes">00</label>:<label id="seconds">00</label>
        </div>
        <div class="stop">
            <button id="stopButton">Parar</button>
        </div>
    </div>
</div>
<div class="nav-bar">
    <a href="mainPage.php"><img src="/PAP/app/img/house.png"></a>
    <a href="startActivity.php"><img src="/PAP/app/img/plus.png"></a>
    <a href="profile.php"><img src="/PAP/app/img/profile.png" style="margin-right: 10px;"></a>
</div>
</div>
</body>

</html>
<script>
    var minutesLabel = document.getElementById("minutes");
    var secondsLabel = document.getElementById("seconds");
    var totalSeconds = 0;
    setInterval(setTime, 1000);

    function setTime() {
        ++totalSeconds;
        secondsLabel.innerHTML = pad(totalSeconds % 60);
        minutesLabel.innerHTML = pad(parseInt(totalSeconds / 60));
    }

    function pad(val) {
        var valString = val + "";
        if (valString.length < 2) {
            return "0" + valString;
        } else {
            return valString;
        }
    }
    
    document.getElementById("stopButton").addEventListener("click", function() {
        // Criando um cookie com o valor do tempo total em segundos
        var timeNow = pad(parseInt(totalSeconds / 60)) + ":" + pad(totalSeconds % 60);
        document.cookie = "ctempo=" + timeNow + "; path=/";
        document.cookie = "ctempoCalc=" + totalSeconds + "; path=/";
        window.location.href = "mainPage.php";
    });
</script>