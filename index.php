<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dofus Fight</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Roboto&display=swap" rel="stylesheet">
</head>
<body>
    <?php
        session_start();
        unset($_SESSION["fight"]);

        $jsonClasses = file_get_contents('characters.json');
        $classes = json_decode($jsonClasses,true);
        $jsonCartes = file_get_contents('maps.json');
        $cartes = json_decode($jsonCartes,true);
    ?>

    <div class="container">
        <div class="title">
            <!-- <h1>Dofus Fighter</h1> -->
        </div>
        <h2>choisissez une classe</h2>
        <div class="select">
            <ul class="ange">
                <?php foreach($classes as $classe){ ?>
                    
                        <?php if($classe["type"] == "ange") { ?>
                            <li>
                                <a href="combat.php?me=<?= $classe["id"] - 1?>">
                                    <img src="img/classes/<?= $classe["picture"] ?>.jpeg" alt="">
                                    <div class="infos">
                                        <div class="card-header">
                                            <img src="img/<?= $classe["type"] ?>.png" alt="">
                                            <h3><?= $classe["name"] ?></h3>
                                            <span><?= $classe["puissance"] ?></span>
                                        </div>
                                        <ul class="sorts">
                                            <?php foreach($classe["attacks"] as $sort) { ?>
                                                <li>
                                                    <img src="img/sorts/<?= $sort["id"] ?>.png" alt="">
                                                    <div class="sort-details">
                                                        <p class="sort-nom"><?= $sort["name"]?></p>
                                                        <span class="sort-nom"><?= $sort["type"]?></span>
                                                    </div>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                </a>
                            </li>

                        <?php } ?>
                    <?php } ?>
                </ul>

                <ul class="demon">
                    <?php foreach($classes as $classe){ ?>
                        <?php if($classe["type"] == "demon") { ?>
                            <li>
                                <a href="combat.php?me=<?= $classe["id"] - 1?>">
                                    <img src="img/classes/<?= $classe["picture"] ?>.jpeg" alt="">
                                    <div class="infos">
                                        <div class="card-header">
                                            <img src="img/<?= $classe["type"] ?>.png" alt="">
                                            <h3><?= $classe["name"] ?></h3>
                                            <span><?= $classe["puissance"] ?></span>
                                        </div>
                                        <ul class="sorts">
                                            <?php foreach($classe["attacks"] as $sort) { ?>
                                                <li>
                                                    <img src="img/sorts/<?= $sort["id"] ?>.png" alt="">
                                                    <div class="sort-details">
                                                        <p class="sort-nom"><?= $sort["name"]?></p>
                                                        <span class="sort-nom"><?= $sort["type"]?></span>
                                                    </div>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                </a>
                            </li>
                            

                        <?php } ?>
                    <?php } ?>
                </ul>
            
        </div>
        <h2>choisissez une carte</h2>
        <ul class="cartes">
            <?php foreach($cartes as $carte) { ?>
                <li>
                    <div class="carte-box">
                        <img src="img/cartes/<?= $carte["picture"] ?>.png" alt="">
                        <div class="infos">
                            <p><?= $carte["description"] ?></p>
                        </div>
                    </div>
                    <h4><?= $carte["name"] ?></h4>
                </li>
            <?php }?>
        </ul>
        <script>
        let classeSelect;
        let carteSelect = 2;
    </script>
        <div class="cta">
            <a href={`combat.php?name=${2}`}=>Combattre !</a>
        </div>
    </div>

   

    <?php
        function php_func(){
            echo "Stay Safe";
        }
    ?>
    
</body>
</html>