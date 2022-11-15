
<form method="POST" action="index.php/lieferadresse/add">
    <div class=""card>
        <div class="card-header" id="logindesign">
            Neue Adresse eingeben:
        </div>
        <div class="card-body">
            <?php if($gibtesFehlermeldungen):?>
                <div class="alert alert-danger" role="alert">
                    <?php foreach ($fehlermeldungen as $errorMessage):?>
                        <p><?=$errorMessage?></p>
                    <?php endforeach;?>

                </div>
            <?php endif;?>

            <div class="form-group">
                <label for="empfaenger"> Empfänger </label>
                <input name="empfaenger" value="<?= $empfaenger?>" class="form-control" id="empfaenger">
            </div>

            <div class="form-group">
                <label for="stadt"> Stadt </label>
                <input name="stadt" value="<?=$stadt?>" class="form-control" id="stadt">
            </div>


            <div class="form-group">
                <label for="plz"> PLZ </label>
                <input name="plz" value="<?= $plz?>" class="form-control" id="plz">
            </div>

            <div class="form-group">
                <label for="strasse"> Straße </label>
                <input name="strasse" value="<?= $strasse?>" class="form-control" id="strasse">
            </div>

            <div class="form-group">
                <label for="hausnummer"> Hausnummer </label>
                <input name="hausnummer" value="<?= $hausnummer?>" class="form-control" id="hausnummer">
            </div>
        </div>

        <div class="card-footer">
            <button class="btn btn-success" id="logindesignok">SPEICHERN</button>
        </div>
    </div>
</form>