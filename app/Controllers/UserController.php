<?php

namespace App\Controllers;

use App\Models\AppUser;

class UserController extends CoreController
{
    /**
     * Méthode gérant la page affichant la liste des utilisateurs
     *
     * @return void
     */
    public function list()
    {
        // Récupération des données
        $usersList = AppUser::findAll();

        // Affichage du template et informations pour le viewdata
        $this->show('user/list', [
            'users_list' => $usersList
        ]);
    }

    /**
     * Méthode s'occupant d'afficher le formulaire de connexion
     *
     * @return void
     */
    public function login()
    {
        $this->show('user/login');
    }

    /**
     * Méthode s'occupant de traiter les informations envoyées par le formulaire de connexion
     * @return void
     */
    public function loginPost()
    {
        // récupérer les données du formulaire
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST, 'password');

        // Instanciation AppUser + récupération de la méthode besoin
        $user = AppUser::findByEmail($email);

        // Si l'adresse mail n'est pas fausse
        if ($user !== false) {
            // si le mdp n'est pas faux
            if (password_verify($password, $user->getPassword())) {

                // On récupère l'id et l'objet de l'user
                $_SESSION['userId'] = $user->getId();
                $_SESSION['userObject'] = $user;

                // rediriger sur la page d'acceuil
                $this->redirect('main-home');
            } else {
                // Si le mdp est faux
                exit('Courriel ou mot de passe incorrect');
            }
        } else {
            // si l'email est  faux
            exit('Courriel ou mot de passe incorrect');
        }
    }

    /** 
     * Méthode permettant de se déconnecter du site
     * 
     * @return void
     */
    public function logout()
    {
        // unset() supprime certaines informations de la session
        unset($_SESSION['userId']);
        unset($_SESSION['userObject']);

        // rediriger sur la page d'acceuil
        $this->redirect('main-home');
    }

    
    /**
     * Méthode gérant la page contenant le formulaire d'ajout d'un utilisateur
     *
     * @return void
     */
    public function add()
    {
        $this->show('user/add');
    }

    /**
     * Méthode traitant l'envoi du formulaire d'ajout d'un utilisateur
     * 
     * @return @void
     */
    public function create()
    {
        $email = filter_input(INPUT_POST, 'email');
        $name = filter_input(INPUT_POST, 'name');
        $password = filter_input(INPUT_POST, 'password');
        $role = filter_input(INPUT_POST, 'role');
        $status = filter_input(INPUT_POST, 'status', FILTER_VALIDATE_INT);

        // Gestion des erreurs
        $errorsList = [];

        if ($email === false) {
            $errorsList[] = 'L\'email n\'a pas un format valide';
        }
        if ($name === '') {
            $errorsList[] = 'Le nom et prénom doit être renseigné';
        }
        if (strlen($password) < 8) {
            $errorsList[] = 'Le mot de passe doit comporter au moins 8 caractères';
        }
        if ($role === '') {
            $errorsList[] = 'Le role doit être renseigné';
        }
        if ($status === '') {
            $errorsList[] = 'Le statut doit être renseigné';
        }

        $user = new AppUser();
        $user->setEmail($email);
        $user->setName($name);
        $user->setPassword(password_hash($password, PASSWORD_DEFAULT));
        $user->setRole($role);
        $user->setStatus($status);

        if (!empty($errorsList)) {
            $this->show('user/add', [
                'errors_list' => $errorsList,
                'user' => $user
            ]);
        } else {
            if ($user->save()) {

                $this->redirect('user-list');
            } else {
                echo 'L\'utilisateur n\'a pas pu être rajouté suite à une erreur';
            }

        }
    }

    
    /**
     * Méthode gérant la page affichant le formulaire d'édition d'un utilisateur
     *
     * @return void
     */
    public function update($userId)
    {

        $user = AppUser::find($userId);
        // dump($user);

        $this->show('user/edit', [
            'user' => $user
        ]);
    }

    /**
     * Méthode gérant la page traitant les informations envoyées par le formulaire d'édition d'un utilisateur
     *
     * @return void
     */
    public function updatePost($userId)
    {
        // Récupération des informations du formulaire
        $email = filter_input(INPUT_POST, 'email');
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_STRING);
        $status = filter_input(INPUT_POST, 'status', FILTER_VALIDATE_INT);

        // Pour mettre à jour le utilisateur :
        // on récupère l'objet utilisateur à modifier
        $userToUpdate = AppUser::find($userId);

        // modifier les propriétés de l'objet utilisateur
        $userToUpdate->setEmail($email);
        $userToUpdate->setName($name);
        $userToUpdate->setRole($role);
        $userToUpdate->setStatus($status);

        if ($userToUpdate->save()) {
            // Si la mise à jour en BDD a fonctionné, alors on redirige vers la liste des utilisateurs
            $this->redirect('user-list');
        } else {
            // Afficher un message d'erreur à l'utilisateur
            exit("Echec lors de la mise à jour du utilisateur, veuillez contacter l'administrateur du site");
        }
    }

    public function delete($id)
    {
        $userToDelete = AppUser::find($id);
        
        if ($userToDelete->delete()) {
            // Si la suppression en BDD a fonctionné, alors on redirige vers la liste des utilisateurs
            $this->redirect('user-list');
        } else {
            // Afficher un message d'erreur à l'utilisateur
            exit("Echec lors de la suppression de l'utilisateur, veuillez contacter l'administrateur du site");
        }
    }
}
