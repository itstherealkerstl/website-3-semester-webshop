
<div class="pdf-container">
<section id="products">
<?php foreach ($order['products'] as $od):?>

<?=$od['title']?>
    <?=$od['quantity']?> Stück
    <?=$od['price']?> €
    <?php endforeach;?>

</section>
</div>