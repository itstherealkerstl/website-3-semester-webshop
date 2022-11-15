<?php require_once __DIR__.'/header.php'?>

<section class="container" id="loginForm">

    <form action="index.php/login" method="POST">

        <div class="card col-7">
            <div class="card-header" id="logindesign">
                HIER EINLOGGEN:
            </div>

            <div class="card-body">

                <?php if($gibtesFehlermeldungen):?>
                    <div class="alert alert-danger" role="alert">
                        <?php foreach ($fehlermeldungen as $errorMessage):?>
                            <p><?=$errorMessage?></p>
                        <?php endforeach;?>

                    </div>
                <?php endif;?>

                <div class="form-group" >
                    <label for="username">Username</label>
                    <input type="text" value="<?=$username?>" name="username" id="username" class="form-control">
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" value="<?=$passwort?>" name="password" id="password" class="form-control">
                </div>

            </div>

            <div class="card-footer" >
                <button class="btn btn-success" type="submit" id="logindesignok">LOGIN</button>
            </div>

            </div>
        </div>
    </form>

    <?php require_once __DIR__.'/footer.php'?>
