<?php require_once __DIR__.'/header.php'?>

<section class="container" id="productDetails">
    <div class="card">
        <div class="card-header" id="headerdesigndetailok">
        <a href="index.php" class="btn btn-primary btn-sm" id="detailzurueckok"><< ZURÜCK</a>
        </div>
        <div class="card-body">
            <div class="row" id="detailrowok">
                <div class="col-4">
                    <img src="index.php/product/image/<?= $produktslug['slug']?>/1.jpg" width="100%">
                </div>
                <div class="col-8">

                        <div id="detaildesignoktitel"><?= $produktslug['titel'] ?></div>

                    <div id="descrdesignwaredetail"><?= $produktslug['description'] ?></div>
                    <div id="pirceid">PREIS <?= $produktslug['price'] ?> €</div>

                    <a href="index.php/cart/add/<?= $produktslug['id'] ?>" class="btn btn-success btn-sm" id="detailkaufenok">KAUFEN</a>
                </div>


            </div>
        </div>

    </div>
</section>
<?php require_once __DIR__.'/footer.php'?>
