<?php
    define("ROOT_CONFIG", __DIR__ . "/config/config.ini");
    define("ROOT_CLASS", "vendor/");

    include(ROOT_CLASS . "config.php");
    include(ROOT_CLASS . "dataBase.php");
    include(ROOT_CLASS . "invite.php");

    $config = new Config();
    $bdd = new DataBase($config);
    $invite = new Invite($bdd->getBdd());

    if (isset($_POST['name']))
    {
        if (isset($_POST['valider']))
            $invite->setName($_POST['name']);

        if (isset($_POST['present']))
            $invite->setPresent($_POST['present']);

        if (isset($_POST['boisson']))
            $invite->setBoisson($_POST['boisson']);

        $invite->addInvite();
    }

    //include("dataBase/invite.php");
?>

<!DOCTYPE HTML>
<html lang="fr">
    <head>
        <!-- CSS -->
		<link href="assets/css/bootstrap.min.css" rel="stylesheet">
		<link href="assets/css/index.css" rel="stylesheet">
		<link href="assets/css/fontawesome.css" rel="stylesheet">

        <title>Michael + Nataly | <?php echo $config->getDate(); ?></title>

        <link rel="icon" type="image/svg" href="assets/img/<?php echo $config->getLogo(); ?>" />
        
    </head>

    <body onresize="jumbotronHeightAdapt()">
        <!-- Premier Jumbotron - prend tout l'écran -->
        <div class="jumbotron firstJumbo">
            <div class="mainBlock">
                <h1 class="mainTitre">
                    <span>P</span>
                    <img src="assets/img/tower.png" class="imageTower" alt="A">
                    <span class="risMainTitre">RIS</span>
                </h1>
                <span class="sousTitre">Michael et Natalia</span>
            </div>
        </div>

        <!-- 3 carrés images -->
        <div class="container blockImage">
            <div class="row">
                <div class="col-4 firstImage" id="googlemap">
                    <iframe id="googleMap"
                        title="Adresse"
                        width="100%"
                        height="100%"
                        src="https://www.openstreetmap.org/export/embed.html?bbox=61.33200%2C55.19600%2C61.33800%2C55.18953">
                    </iframe> 
                    <div class="numero1">
                        1
                    </div>
                </div>
                <div class="col-4 secondImage">
                    <img src="assets/img/fourchette.png" width="100%" height="100%">
                    <div class="numero2">
                        2
                    </div>
                </div>
                <div class="col-4 thirdImage">
                    <img src="assets/img/resto.png" width="100%" height="100%">
                    <div class="numero3">
                        3
                    </div>
                </div>
            </div>
        </div>

        <!-- Explication de chaque carré -->
        <div class="container blockDescription">
            <div class="row">
                <div class="col-4 firstHour">
                    <h2>14:30 - 15:00</h2>
                    <div class="borderHour"></div>
                    <div class="textHour">
                        Ресторан “Ланжерон
                        ул. Молодогвардейцев, 27 Б
                        Сбор гостей :)
                    </div>
                </div>
                <div class="col-4 secondHour">
                    <h2>15:00 - 16:30</h2>
                    <div class="borderHour"></div>
                    <div class="textHour">
                        Символическая церемония с фуршетом
                        На французском фуршет называется “Apéritif” - это целая традиция для всех французов. Время закусок, легких алкогольных напитков и, главное, разговоров!
                    </div>
                </div>
                <div class="col-4 thirdHour">
                    <h2>16:30 - 00:00</h2>
                    <div class="borderHour"></div>
                    <div class="textHour">
                        Развлекательная программа, танцы, банкет, все в лучших русских традициях
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid fondRose">
            <div class="row">
                <div class="offset-1 col-8">
                    <h2>Нам нужно знать!</h2>
                </div>
            </div>
        </div>

        <div class="container containerForm">
            <div class="row">
                <div class="col-6 backgroundForm">
                    <form class="formText" method="post" action="#">
                        Я <input type="text" name="name" placeholder="Имя и фамилия" class="textName"> <br>
                        Буду 24 августа  с Вами! <br>
                        <p class="answerPlz">
                            Обязательно <input type="radio" name="present" value="oui"> - Я не смогу :( <input type="radio" name="present" value="non">
                        </p>
                        А на фуршете я хочу пить <br>
                        <p class="answerPlz">
                            Коктейли <input type="radio" name="boisson" value="cocktail"> - Шампанское <input type="radio" name="boisson" value="champagne">
                        </p>
                        <input type="submit" name="valider" value="Отправить">
                    </form>
                </div>
                <div class="offset-1 col-5">
                    <img src="assets/img/us.jpg" class="usStyle">
                </div>
            </div>
        </div>

        <footer class="backgroundFooter">
            <div class="container">
                <div class="row">
                    <div class="col-12 centerFooter">
                        01.09.2018  France - Russie 24.08.2019
                    </div>
                </div>
            </div>
        </footer>
        <!--
        <div class="jumbotron secondJumbo">
            <div class="container">
                <div class="row">
                    <div class="col-6">
                        <h1 class="heureApero">
                            15:30 - 16:00
                        </h1>
                        <p class="textSecondJumbo">
                            Ресторан “Ланжерон<br>
                            ул. Молодогвардейцев, 27 Б<br>      

                            Сбор гостей :)
                        </p>
                    </div>
                    <div class="col-6">
                        et là
                    </div>
                </div>
            </div>
        </div>

        <div class="jumbotron choiceJumbo">
            Prénom : <input type="text" name="prenom">
            Nom : <input type="text" name="nom">
            <br>
            Choix de la boisson : <input type="radio" name="boisson" value="cocktail"> Cocktail <input type="radio" name="boisson" value="champagne"> Champagne
        </div>
        -->
        <!-- Jquery -->
        <script src="assets/js/jquery-3.3.1.min.js"></script>
        <!-- JS -->
        <script src="assets/js/index.js"></script>
		<!-- FontAwesome -->
        <!--<script src="https://kit.fontawesome.com/40e817b9a2.js"></script>-->
        
        <script>
           /* var invocation = new XMLHttpRequest();
var url = 'http://www.google.com/maps/place/Langeron+Chelyabinsk/@55.192851,61.3310614,17z/data=!3m1!4b1!4m5!3m4!1s0x43c59339620e199d:0x36947e8733616172!8m2!3d55.192851!4d61.3332501';
var googleMap = document.getElementById("googlemap");

function callOtherDomain() {
  if(invocation) {    
    invocation.open('GET', url, true);
    //invocation.onreadystatechange = handler;
    invocation.send(googleMap);
    console.log(invocation);
  }
}

setTimeout(callOtherDomain(), 200); */

        </script>
    </body>
</html>