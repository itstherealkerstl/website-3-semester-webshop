<?php require_once __DIR__.'/header.php'?>
<div class="container">
    <h1 id="mainueber"> Willkommen im Shop. </h1>
</div>
<section class="container" id="products">

    <?php
    if ($esgibtBenachrichtigungen): ?>
        <div class="alert alert-success" role="alert">
            <?php
            foreach ($benachrichtigungen as $message): ?>
                <p><?= $message ?></p>
            <?php
            endforeach ?>
        </div>
    <?php
    endif; ?>
    
    <div class="row">



        <?php foreach($produkte as $pd):?>
            <div class="col-4">
                <?php include 'produktseite.php' ?>
            </div>
        <?php endforeach;?>


    </div>
</section>
<?php require_once __DIR__.'/footer.php'?>
