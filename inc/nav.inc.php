<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="<?php echo URL; ?>index.php">Bibliotheque</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="<?php echo URL; ?>index.php">Abonné <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo URL; ?>Formulaire_livre.php">Livre</a>
            </li>
             <li class="nav-item">
                <a class="nav-link" href="<?php echo URL; ?>Formulaire_emprunt.php">Emprunt</a>
            </li>
             
            
            
        </ul>
        <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="search" placeholder="Rechercher" aria-label="Rechercher">
            <button class="btn btn-outline-light my-2 my-sm-0" type="submit">Rechercher</button>
        </form>
    </div>
</nav>