<div class="container my-4"> <a href="<?= $router->generate('student-add') ?>" class="btn btn-success float-right">Ajouter</a>

    <h2>Liste des &Eacute;tudiants</h2>
    <table class="table table-hover mt-4">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Prénom</th>
                <th scope="col">Nom</th>
                <th scope="col">Prof</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($students_list as $studentObject) : ?>
                <tr>
                    <th scope="row"><?= $studentObject->getId() ?></th>
                    <td><?= $studentObject->getFirstname() ?></td>
                    <td><?= $studentObject->getLastname() ?></td>
                    <td><?= $studentObject->getTeacherFirstname() ?></td>
                    <td class="text-right">
                        <a href="<?= $router->generate('student-update', ['id' => $studentObject->getId()]) ?>" class="btn btn-sm btn-warning">
                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                        </a>
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="<?= $router->generate('student-delete', ['id' => $studentObject->getId()]) ?>">Oui, je veux
                                    supprimer</a>
                                <a class="dropdown-item" href="#" data-toggle="dropdown">Oups !</a>
                            </div>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>