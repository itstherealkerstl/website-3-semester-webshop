<div class="col-3">
<img class="productPicture" src="index.php/product/image/<?= $warenkorbProdukt['slug']?>/1.jpg" width="100%"></div>
<div class="col-7">
    <div id="titeldesign"><?= $warenkorbProdukt['titel']?></div>
    <div id="descrdesignware"><?= $warenkorbProdukt['description']?></div>
</div>
<div id="rechts" class="col-2 text-right">
    <span class="price">
    <?= number_format($warenkorbProdukt['price']/100,2,","," ") ?> €

</div>