<div class="container my-4"> <a href="<?= $router->generate('teacher-list') ?>" class="btn btn-success float-right">Retour</a>
    <h2>Modifier un prof</h2>

    <form action="" method="POST" class="mt-5">
        <div class="form-group">
            <label for="firstname">Prénom</label>
            <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Prénom du professeur" value="<?php if (isset($teacher)) {
                echo $teacher->getFirstname(); 
            } ?>" >
        </div>
        <div class="form-group">
            <label for="lastname">Nom</label>
            <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Nom du professeur" value="<?php if (isset($teacher)) {
                echo $teacher->getLastname(); 
            } ?>" >
        </div>
        <div class="form-group">
            <label for="job">Titre</label>
            <input type="text" class="form-control" id="job" name="job" placeholder="Titre du professeur" value="<?php if (isset($teacher)) {
                echo $teacher->getJob(); 
            } ?>" >
        </div>
        <div class="form-group">
            <label for="status">Statut</label>
            <select name="status" id="status" class="form-control">
                <option value="0">-</option>
                <option value="1"<?php if (isset($teacher) && $teacher->getStatus() == 1) {
                    echo ' selected';
                }?>>Actif</option>
                <option value="2"<?php if (isset($teacher) && $teacher->getStatus() == 2) {
                    echo ' selected';
                }?>>Désactivé</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary btn-block mt-5">Valider</button>
    </form>
</div>
