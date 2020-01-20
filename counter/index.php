<?php
ignore_user_abort(true);
?>

<!DOCTYPE HTML>
<html lang="fr">
<head>

    <title>Counter</title>

</head>

<body>

    <span id="point">
        10
    </span>/
    <span id="maxPoint">
        10
    </span>

    <div id="counter">
        600
    </div>

    <div>
        <button id="btnMoins">-1 Point</button>
    </div>

    <script type="text/javascript">
        var showPoint       = document.getElementById("point");
        var showPointMax    = document.getElementById("maxPoint");
        var pointMax        = showPointMax.innerText;
        var showCounter     = document.getElementById("counter");
        var counter         = showCounter.innerText;
        var btnMoins        = document.getElementById("btnMoins");
        var intervalOn      = false;

        showCounter.style.display = "none";

        function count()
        {
            intervalOn = true;
            if (showCounter.style.display == "none")
            {
                var minute = Math.floor(counter/60);
                var second = counter%60;
                showCounter.innerText = minute + ":" + second;
                showCounter.style.display = "block";
            }

            var interval = window.setInterval(function()
            {
                var point       = showPoint.innerText;
                var pointMax    = showPointMax.innerText;

                console.log(point + " : " + pointMax);

                counter--;
                var minute = Math.floor(counter/60);
                var second = counter%60;

                if (second < 10)
                    second = "0" + second;

                console.log(minute + ":" + second);
                showCounter.innerText = minute + ":" + second;

                if (counter <= 0)
                {
                    counter = 600;
                    point++;
                    showPoint.innerText = point;

                    if (point == pointMax)
                        intervalOn = false;
                }

                if (parseInt(point) >= parseInt(pointMax))
                {
                    clearInterval(interval);
                    showCounter.style.display = "none";
                }
            }, 1);
        }
        
        if (point < pointMax)
        {
            count();
        }

        btnMoins.onclick = function()
        {
            var point = showPoint.innerText;
            point--;
            showPoint.innerText = point;

            if ((point < pointMax) && (intervalOn == false))
            {
                count();
            }
        }

    </script>

</body>
</html>