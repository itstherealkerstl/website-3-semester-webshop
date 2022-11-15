<?php require_once __DIR__ . '/header.php'?>

<section id="overview" class="container">
    <div clas="row">
        <h1 id="warenkorbdesignok">BESTELLUNG</h1>
    </div>
<hr>
    <?php foreach ($warenkorbProdukte as $warenkorbProdukt):?>
        <div class="row cartItem">
            <?php include __DIR__ . '/produkt.php';?>
        </div>

    <?php endforeach;?>
    <div class="row">
        <div id="rechts" class="col-12 text-right">
            <h1 id="preisdesign"> SUMME</h1> <span class="price"> <?=number_format($warenkorbSumme/100,2,","," ")?> €</span>
        </div>
    </div>
    <hr>
    <div class="row" id="checkcontainer">
        <a class="btn btn-danger col-5" id="whitespache"></a>
        <a class="btn btn-danger col-3" id="abbrechencheck"href="index.php">ABBRECHEN</a>
        <a class="btn btn-success col-3" id="bestellencheck" href="index.php/CompleteOrder">BESTELLEN</a>
    </div>
</section>
<?php require_once __DIR__.'/footer.php'?>
