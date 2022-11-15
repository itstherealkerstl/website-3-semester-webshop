
<div class="card" id="boxdesign">


    <?php if ($isAdmin):?>
        <a href="index.php/product/edit/<?= $pd['slug']?>" class="btn btn-primary btn-sm" id="bearbeitendesign">BEARBEITEN</a>
    <?php endif;?>

    <img src="index.php/product/image/<?= $pd['slug']?>/1.jpg" class="card-img-top" alt="picture">
    <div class="card-title" id="titeldesign">
        <?= $pd['titel']?></div>
    <div class="card-body" id="descrdesign">

        <?= $pd['description']?>
        <a href="index.php/product/<?= $pd['slug']?>" class="btn btn-primary btn-sm" id="detaildesign">>> DETAILS <<</a>

        <hr>
        <?= $pd['price']?> €
        <a href="index.php/cart/add/<?= $pd['id']?>" class="btn btn-success btn-sm" id="kaufendesign">KAUFEN</a>

    </div>

    <div class="card-footer" id="borderfooter">


    </div>
</div>