<div class="container my-4"> <a href="<?= $router->generate('student-list') ?>" class="btn btn-success float-right">Retour</a>
    <h2>Ajouter un étudiant</h2>

    <form action="" method="POST" class="mt-5">
        <div class="form-group">
            <label for="firstname">Prénom</label>
            <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Prénom de l'élève" value="<?php if (isset($student)) {
                echo $student->getFirstname(); 
            } ?>" >        </div>
        <div class="form-group">
            <label for="lastname">Nom</label>
            <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Nom de l'élève" value="<?php if (isset($student)) {
                echo $student->getLastname(); 
            } ?>" >        </div>
        <div class="form-group">
            <label for="student">Prof</label>
            <select name="teacher_id" id="teacher_id" class="form-control">
                <option value="0">-</option>
                <option value="1"<?php if (isset($student) && $student->getTeacher_id() == 1) {
                    echo ' selected';
                }?>>Baptiste Delphin</option>
                <option value="2"<?php if (isset($student) && $student->getTeacher_id() == 2) {
                    echo ' selected';
                }?>>Stéphane Pellier</option>
            </select>
        </div>
        <div class="form-group">
            <label for="status">Statut</label>
            <select name="status" id="status" class="form-control">
                <option value="0">-</option>
                <option value="1"<?php if (isset($student) && $student->getStatus() == 1) {
                    echo ' selected';
                }?>>Actif</option>
                <option value="2"<?php if (isset($student) && $student->getStatus() == 2) {
                    echo ' selected';
                }?>>Désactivé</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary btn-block mt-5">Valider</button>
    </form>
</div>
