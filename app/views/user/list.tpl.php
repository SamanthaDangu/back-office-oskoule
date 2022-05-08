<div class="container my-4"> <a href="<?= $router->generate('user-add') ?>" class="btn btn-success float-right">Ajouter</a>

    <h2>Liste des Utilisateurs</h2>
    <table class="table table-hover mt-4">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Email</th>
                <th scope="col">Nom</th>
                <th scope="col">Role</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users_list as $userObject) : ?>
                <tr>
                    <th scope="row"><?= $userObject->getId() ?></th>
                    <td><?= $userObject->getEmail() ?></td>
                    <td><?= $userObject->getName() ?></td>
                    <td><?= $userObject->getRole() ?></td>
                    <td class="text-right">
                        <a href="<?= $router->generate('user-update', ['id' => $userObject->getId()]) ?>" class="btn btn-sm btn-warning">
                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                        </a>
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="<?= $router->generate('user-delete', ['id' => $userObject->getId()]) ?>">Oui, je veux supprimer</a>
                                <a class="dropdown-item" href="#" data-toggle="dropdown">Oups !</a>
                            </div>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>