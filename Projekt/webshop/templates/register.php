<?php require_once __DIR__.'/header.php'?>

</section>
<section id="register" class="container">
    <form action="index.php/account/register" method="POST">
        <div class="card col-7">
            <div class="card-header" id="logindesign">

                REGISTRIERUNG:

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
                    <label for="username">Username</label>
                    <input type="text" value="<?= $username ?>" name="username" id="username" class="form-control">
                </div>
                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="email" value="<?= $email ?>" name="email" id="email" class="form-control">
                </div>
                <div class="form-group">
                    <label for="emailRepeat">E-mail wiederholen</label>
                    <input type="email" value="<?= $emailwiederholung ?>" name="emailRepeat" id="emailRepeat" class="form-control">
                </div>
                <div class="form-group">
                    <label for="password">Passwort</label>
                    <input type="password" value="<?= $passwort ?>" name="password" id="password" class="form-control">
                </div>
                <div class="form-group">
                    <label for="passwordRepeat">Passwort wiederholen</label>
                    <input type="password" value="<?= $passwortwiederholung ?>" name="passwordRepeat" id="passwordRepeat" class="form-control">
                </div>

            </div>
            <div class="card-footer">
                <button class="btn btn-success" type="submit" id="logindesignok">REGISTRIEREN</button>
            </div>
        </div>
    </form>

</section>

<?php require_once __DIR__.'/footer.php'?>
