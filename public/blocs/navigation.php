<?php

$action = str_replace(dirname($_SERVER['PHP_SELF']).'/', '', $_SERVER['PHP_SELF']); 
?>

<header>
		<nav  class="container">
      <div class="row">
        <div class="col-sm-2">
          <a href="/"><img src="img/logo.png" /></a>
        </div>
        <div class="col-sm-6">
          <form method="post" class="bar_search">
            <div class="form-group row">
              <div class="col-sm-11">
                <input type="text" class="form-control-plaintext" placeholder="Recherche..." name="search">
              </div>
              <div class="col-sm-1">
                <button class="btn btn-outline-warning btn-sm" type="submit" value=""><i class="fa fa-search"></i></button>
              </div>
            </div>
          </form>
        </div>
        <div class="col-sm-4">
          <ul>
            <!-- <li><button type="button"  data-toggle="modal" data-target="#insription">Inscription</button></li>
            <li> | </li>
            <li><button type="button"  data-toggle="modal" data-target="#connexion">Connexion</button></li>
            <li><a href="#"><img src="img/user.png" alt="" /></a></li> -->
            <li><a href="#">Véhicule</a></li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Profil <i class="fa fa-user" aria-hidden="true"></i></a>
              <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="#">Profil</a>
                <a class="dropdown-item" href="#">Commandes</a>
                <div class="dropdown-divider"></div>
                <button type="button" class="btn btn-danger">Déconnexion</button>
              </div>
            </li>
          </ul>         
        </div>
      </div>
		</nav>
	</header>