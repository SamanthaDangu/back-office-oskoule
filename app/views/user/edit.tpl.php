<div class="container my-4"> <a href="<?= $router->generate('user-list') ?>" class="btn btn-success float-right">Retour</a>
        <h2>Ajouter un utilisateur</h2>

        <form action="" method="POST" class="mt-5">
            <div class="form-group">
                <label for="email">Adresse email</label>
                <input type="email" class="form-control" name="email" id="email" placeholder="" value="<?php if (isset($user)) { echo $user->getEmail(); }?>" >
            </div>
            <div class="form-group">
                <label for="name">Nom</label>
                <input type="text" class="form-control" name="name" id="name" placeholder="" value="<?php if (isset($user)) { echo $user->getName(); }?>">
            </div>
            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="" value="">
            </div>
            <div class="form-group">
            <label for="role">Role</label>
            <select name="role" id="role" class="form-control">
                <option value="user" <?php if (isset($user) && $user->getRole() == 1) {
                    echo ' selected';
                } ?>>Utilisateur</option>
                <option value="admin" <?php if (isset($user) && $user->getRole() == 2) {
                    echo ' selected';
                } ?>>Administrateur</option>
            </select>
        </div>
        <div class="form-group">
            <label for="status">Statut</label>
            <select name="status" id="status" class="form-control">
                <option value="0">-</option>
                <option value="1" <?php if (isset($user) && $user->getStatus() == 1) {
                    echo ' selected';
                } ?>>Actif</option>
                <option value="2" <?php if (isset($user) && $user->getStatus() == 2) {
                    echo ' selected';
                } ?>>Désactivé</option>
            </select>
        </div>
            <button type="submit" class="btn btn-primary btn-block mt-5">Valider</button>
        </form>
    </div>