<div class="row">
    <?php
    foreach ($lieferadressen as $deliveryAddress): ?>
        <div class="col-3" >
            <div class="card-header" id="logindesign">
                Gespeicherte Adressen:
            </div>

            <div class="card" id="adressendesign">
                <div class="card-body">
                    <strong class="empfaenger"><?= $deliveryAddress['adresse'] ?></strong>
                    <p class="strasse2">
                        <?= $deliveryAddress['strasse'] ?> <?= $deliveryAddress['nummer'] ?>
                    </p>
                    <p class="stadt2">
                        <?= $deliveryAddress['plz'] ?> <?= $deliveryAddress['stadt'] ?>
                    </p>
                    <a class="card-link" id="adressenwaehlendesign" href="index.php/completeOrder<?= $deliveryAddress['id'] ?>">ADRESSE WÄHLEN</a>
                </div>
            </div>
        </div>
    <?php
    endforeach; ?>
</div>