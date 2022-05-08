<?php

namespace App\Controllers;

abstract class CoreController
{
    public function __construct($routeId = '')
    {
        // On définit la liste des permissions pour les routes
        // nécessitant une connexion utilisateur
        $accessControlList = [
            'teacher-list' => ['admin', 'user'],
            'teacher-add' => ['admin'],
            'teacher-create' => ['admin'],
            'student-list' => ['admin', 'user'],
            'student-add' => ['admin', 'user'],
            'student-create' => ['admin', 'user'],
            'user-list' => ['admin'],
        ];

        // Si la route est dans le tableau
        if (array_key_exists($routeId, $accessControlList)) {
            // Alors on récupère le tableau des roles autorisés
            $authorizedRoles = $accessControlList[$routeId];
            // Puis, on vérifie les autorisations
            $this->checkAuthorization($authorizedRoles);
        }
    }

    /**
     * Méthode permettant de faire une redirection grâce à l'id de route
     *
     * @param string $routeId
     * @return void
     */
    protected function redirect($routeId)
    {
        global $router;
        header('Location: ' . $router->generate($routeId));
        exit();
    }

    /**
     * Méthode ayant qui vérifie les autorisations
     * 
     * @param array $role La liste des roles qui sont autorisés
     *
     * @return bool
     */
    protected function checkAuthorization($authorizedRoles)
    {
        // Si l'utilisateur est connecté
        if (isset($_SESSION['userId'])) {

            // Alors on récupère son role
            $role = $_SESSION['userObject']->getRole();

            // Si le role a les autorisations
            if (in_array($role, $authorizedRoles)) {
                // Alors on retourne vrai
                return true;
            } else {
                // Si le role a pas les autorisations 
                $errorController = new ErrorController();
                $errorController->err403();
            }
        } else {
            // Sinon on redirige vers la page de connexion
            $this->redirect('user-login');
        }
    }

    /**
     * Méthode permettant d'afficher les views et utiliser les datas
     * @return void
     */
    protected function show(string $viewName, $viewData = [])
    {
        global $router;

        $viewData['currentPage'] = $viewName;

        // définir l'url absolue pour la racine du site
        // /!\ != racine projet, ici on parle du répertoire public/
        $viewData['baseUri'] = $_SERVER['BASE_URI'];

        // On ajoute l'information pour savoir si l'utisateur courant est connecté
        $viewData['isUserLoggedIn'] = isset($_SESSION['userId']);

        // Si on trouve les informations sur l'utilisateur connecté
        if (isset($_SESSION['userObject'])) {
            // on les rajoute dans $viewData
            $viewData['loggedInUser'] = $_SESSION['userObject'];
        }

        extract($viewData);

        // $viewData est disponible dans chaque fichier de vue
        require_once __DIR__ . '/../views/layout/header.tpl.php';
        require_once __DIR__ . '/../views/' . $viewName . '.tpl.php';
        require_once __DIR__ . '/../views/layout/footer.tpl.php';
    }
}
