<?php require_once __DIR__.'/header.php'?>

<section id="newProduct" class="container">
    <form action="index.php/product/new/<?=$slug?>" method="POST">


        <div class="card">
            <div class="card-header">
                Neues Produkt erstellen
            </div>
            <div class="card-body">

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


                <?php if($gibtesFehlermeldungen):?>
                    <div class="alert alert-danger" role="alert">
                        <?php foreach ($fehlermeldungen as $errorMessage):?>
                            <p><?=$errorMessage?></p>
                        <?php endforeach;?>

                    </div>
                <?php endif;?>


                <div class="form-group">
                    <label for="name">Produkt Name</label>
                    <input type="text" value="<?= $produktName ?>" name="name" id="name" class="form-control">
                </div>
                <div class="form-group">
                    <label for="slug">Slug</label>
                    <input type="text" value="<?= $slug ?>" name="slug" id="slug" class="form-control">
                </div>
                <div class="form-group">
                    <label for="description">Produkt Beschreibung</label>
                    <textarea class="form-control" id="description" name="description" rows="3"><?=$description ?></textarea>
                </div>
                <div class="form-group">
                    <label for="price">Preis</label>
                    <input type="text" value="<?= $price ?>" name="price" id="price" class="form-control">
                </div>
            </div>
            <div class="card-footer">
                <a href="index.php" class="btn btn-danger">Abbrechen</a>
                <button class="btn btn-success">Speichern</button>
            </div>
        </div>
    </form>
</section>

<?php require_once __DIR__.'/footer.php'?>