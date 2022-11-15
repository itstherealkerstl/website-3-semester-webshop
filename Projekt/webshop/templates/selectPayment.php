<?php require_once __DIR__.'/header.php'?>

    <section class="container" id="selectPaymentMethod">

        <?php if($gibtesFehlermeldungen):?>
            <div class="alert alert-danger" role="alert">
                <?php foreach ($fehlermeldungen as $errorMessage):?>
                    <p><?=$errorMessage?></p>
                <?php endforeach;?>

            </div>
        <?php endif;?>

        <form method="POST" action="index.php/selectPayment">
            <?php
            foreach ($avaliablePaymentMethods as $value => $text): ?>
                <div class="form-check">
                    <input type="radio" class="form-check-input" name="paymentMethod" id="payment<?= $text ?>" value="<?= $value ?>">
                    <label class="form-check-label" for="payment<?= $text ?>">
                        <?= $text ?>
                    </label>
                </div>
            <?php
            endforeach ?>


            <button type="submit" class="btn btn-primary">Weiter zur Bezahlung</button>
        </form>
    </section>

<?php require_once __DIR__.'/footer.php'?>