
<html>
<head>
    <title>Webshop Uebung</title>
    <base href="<?=$baseURL?>">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<?php include __DIR__. '/navbar.php'?>
<header class="jumbotron">

    <div class="container" id="containerwarenkorb">
        <h1 id="warenkorbdesignok">WARENKORB</h1>
    </div>


</header>

<section class="container" id="cartItems">

    <div class="row">

    </div>
    <div class="row cartItemHeader">
    <div id="rechts" class="col-12 text-right">
    <h1 id="preisdesign">PREIS</h1>
        <hr>
    </div>
    </div>

    <?php foreach ($warenkorbProdukte as $warenkorbProdukt):?>
    <div class="row cartItem">
<?php include __DIR__ . '/produkt.php';?>
    </div>

    <?php endforeach;?>
<hr>
    <div class="row">
        <div id="rechts" class="col-12 text-right">
           <h1 id="preisdesign">SUMME </h1> <span class="price"> <?=number_format($warenkorbSumme/100,2,","," ")?> €</span>
        </div>
    </div>
    <div class="row">
        <a class="col-10"></a>
        <a href="index.php/checkout" class="btn btn-primary col-2" id="buttonbestellendesign">
            BESTELLEN
        </a>

    </div>
</section>

<script src="assets/js/bootstrap.bundle.js"></script>
</body>
</html>