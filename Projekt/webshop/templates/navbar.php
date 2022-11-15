<nav class="navbar navbar-expand-lg navbar-light bg-light" id="designnavoben">
    <div class="container">
    <a class="navbar-brand" href="#" id="homedesign">HOME</a>


    <ul class="navbar-nav">
        <li class="nav-item" id="homedesign">
            <?php if($userclass->isLogin()):?>
                <a class="nav-link"href="index.php/logout">LOGOUT</a>
            <?php endif;?>

            <?php if(!$userclass->isLogin()):?>
                <a class="nav-link" href="index.php/login">LOGIN</a>
            <?php endif;?>

        </li>

        <li class="nav-item">

            <a class="nav-link" href="index.php/register">REGISTRIEREN</a>
        </li>
    </ul>
        <ul class="navbar-nav ml-auto">


        <li class="nav-item">
           <a href="index.php/cart" id="warenkorbdesign"> WARENKORB <?=$countcartItems?></a>
        </li>
    </ul>




</div>
</nav>
<header class="jumbotron">




</header>

    <div class="container">
<?php if($isAdmin):?>
    <div class="col">
        <div class="card" id="newProduct">
            <div class="card-body" >

                <a href="index.php/product/new" id="designneu">+ NEUES PRODUKT ANLEGEN</a>
            </div>
        </div>

    </div>

<?php endif?>

    </div>
