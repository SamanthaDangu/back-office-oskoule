<?php

// autoload.php permet de charger les packages installées avec composer
require_once '../vendor/autoload.php';

// Activation du mécanisme des sessions
session_start();

/* ------------
--- ROUTAGE ---
-------------*/

//Instanciation class Altorouter pour créer nos routes
$router = new AltoRouter();

$_SERVER['BASE_URI'] = '/';

// Déclarations des routes
$router->map(
    'GET',
    '/',
    [
        'method' => 'home',
        'controller' => '\App\Controllers\MainController' // On indique le FQCN de la classe
    ],
    'main-home'
);

// Route pour la page liste de professeurs
$router->map(
    'GET',
    '/teacher/list',
    [
        'method' => 'list',
        'controller' => '\App\Controllers\TeacherController'
    ],
    'teacher-list'
);

// Route pour la page ajouter un professeur
$router->map(
    'GET',
    '/teacher/add',
    [
        'method' => 'add',
        'controller' => '\App\Controllers\TeacherController'
    ],
    'teacher-add'
);

// Route pour la page post ajouter un professeur
$router->map(
    'POST',
    '/teacher/add',
    [
        'method' => 'create',
        'controller' => '\App\Controllers\TeacherController'
    ],
    'teacher-create'
);

// Route pour la page permettant d'afficher le formulaire d'édition d'un professeur
$router->map(
    'GET',
    '/teacher/update/[i:id]',
    [
        'method' => 'update',
        'controller' => '\App\Controllers\TeacherController'
    ],
    'teacher-update'
);

// Route pour la page permettant de traiter les informations envoyées par le formulaire d'édition d'un professeur
$router->map(
    'POST',
    '/teacher/update/[i:id]',
    [
        'method' => 'updatePost',
        'controller' => '\App\Controllers\TeacherController'
    ],
    'teacher-update-post'
);

// Route pour la page permettant de supprimer un professeur
$router->map(
    'GET',
    '/teacher/delete/[i:id]',
    [
        'method' => 'delete',
        'controller' => '\App\Controllers\TeacherController'
    ],
    'teacher-delete'
);


// Route pour la page liste de élèves
$router->map(
    'GET',
    '/student/list',
    [
        'method' => 'list',
        'controller' => '\App\Controllers\StudentController'
    ],
    'student-list'
);

// Route pour la page ajouter un élève
$router->map(
    'GET',
    '/student/add',
    [
        'method' => 'add',
        'controller' => '\App\Controllers\StudentController'
    ],
    'student-add'
);

// Route pour la page post ajouter un élève
$router->map(
    'POST',
    '/student/add',
    [
        'method' => 'create',
        'controller' => '\App\Controllers\StudentController'
    ],
    'student-create'
);

// Route pour la page permettant d'afficher le formulaire d'édition d'un élève
$router->map(
    'GET',
    '/student/update/[i:id]',
    [
        'method' => 'update',
        'controller' => '\App\Controllers\StudentController'
    ],
    'student-update'
);

// Route pour la page permettant de traiter les informations envoyées par le formulaire d'édition d'un élève
$router->map(
    'POST',
    '/student/update/[i:id]',
    [
        'method' => 'updatePost',
        'controller' => '\App\Controllers\StudentController'
    ],
    'student-update-post'
);

// Route pour la page permettant de supprimer un élève
$router->map(
    'GET',
    '/student/delete/[i:id]',
    [
        'method' => 'delete',
        'controller' => '\App\Controllers\StudentController'
    ],
    'student-delete'
);

// Route pour la page liste des utilisateurs
$router->map(
    'GET',
    '/user/list',
    [
        'method' => 'list',
        'controller' => '\App\Controllers\UserController'
    ],
    'user-list'
);

// Route pour la page se connecter
$router->map(
    'GET',
    '/user/login',
    [
        'method' => 'login',
        'controller' => '\App\Controllers\UserController'
    ],
    'user-login'
);

// Route pour la page POST se connecter
$router->map(
    'POST',
    '/user/login',
    [
        'method' => 'loginPost',
        'controller' => '\App\Controllers\UserController'
    ],
    'user-loginPost'
);

// Route pour la page permettant de déconnecter du site
$router->map(
    'GET',
    '/user/logout',
    [
        'method' => 'logout',
        'controller' => '\App\Controllers\UserController'
    ],
    'user-logout'
);

// Route pour la page affichant le formulaire d'ajout d'un utilisateur
$router->map(
    'GET',
    '/user/add',
    [
        'method' => 'add',
        'controller' => '\App\Controllers\UserController'
    ],
    'user-add'
);

// Route pour la page recevant et traitant les données envoyées par le formulaire d'ajout d'un utilisateur
$router->map(
    'POST',
    '/user/add',
    [
        'method' => 'create',
        'controller' => '\App\Controllers\UserController'
    ],
    'user-create'
);

// Route pour la page permettant d'afficher le formulaire d'édition d'un utilisateur
$router->map(
    'GET',
    '/user/update/[i:id]',
    [
        'method' => 'update',
        'controller' => '\App\Controllers\UserController'
    ],
    'user-update'
);

// Route pour la page permettant de traiter les informations envoyées par le formulaire d'édition d'un utilisateur
$router->map(
    'POST',
    '/user/update/[i:id]',
    [
        'method' => 'updatePost',
        'controller' => '\App\Controllers\UserController'
    ],
    'user-update-post'
);

// Route pour la page permettant de supprimer un utilisateur
$router->map(
    'GET',
    '/user/delete/[i:id]',
    [
        'method' => 'delete',
        'controller' => '\App\Controllers\UserController'
    ],
    'user-delete'
);

/* -------------
--- DISPATCH ---
--------------*/

// On demande à AltoRouter de trouver une route qui correspond à l'URL courante
$match = $router->match();

// Si la route existe ça fait le dispatch tout seul sinon page 404
$dispatcher = new Dispatcher($match, '\App\Controllers\ErrorController::err404');

if ($match !== false) { // $match n'est pas faux alors on récupère l'argument name
    $dispatcher->setControllersArguments($match['name']);
}

// Le dispatch va exécuter la méthode du controller
$dispatcher->dispatch();
