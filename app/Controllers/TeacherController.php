<?php

namespace App\Controllers;

use App\Models\Teacher;
use App\Models\CoreModel;

class TeacherController extends CoreController
{
    /**
     * Méthode gérant la page affichant la liste des profs
     *
     * @return void
     */
    public function list()
    {
        $teachersList = Teacher::findAll();

        // Affichage du template et informations pour le viewdata
        $this->show('teacher/list', [
            'teachers_list' => $teachersList
        ]);
    }

    /**
     * Méthode gérant la page contenant le formulaire d'ajout d'un prof
     *
     * @return void
     */
    public function add()
    {
        $this->show('teacher/add');
    }


    /**
     * Méthode gérant la page recevant les données du formulaire d'ajout d'un prof
     * @return void
     */
    public function create()
    {
        // récupérer les données du formulaire
        $firstname = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_SPECIAL_CHARS);
        $lastname = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_SPECIAL_CHARS);
        $job = filter_input(INPUT_POST, 'job');
        $status = filter_input(INPUT_POST, 'status', FILTER_VALIDATE_INT);

        // Gestion des erreurs
        $errorsList = [];

        if ($lastname === '') {
            // Ajout du message d'erreur dans le tableau des erreurs
            $errorsList[] = 'Le nom doit être renseigné';
        }
        if ($firstname === '') {
            $errorsList[] = 'Le prénom doit être renseigné';
        }
        if ($job === '') {
            $errorsList[] = 'Le job doit être renseigné';
        }
        if ($status === '') {
            $errorsList[] = 'Le statut doit être renseigné';
        }

        //ajout en DB
        $teacherToInsert = new Teacher();
        $teacherToInsert->setFirstname($firstname);
        $teacherToInsert->setLastname($lastname);
        $teacherToInsert->setJob($job);
        $teacherToInsert->setStatus($status);
        dump($teacherToInsert);

        if (!empty($errorsList)) {
            // Si il y a des erreurs
            // dump($errorsList);
            $this->show('teacher/add', [
                'errors_list' => $errorsList,
                'teacher' => $teacherToInsert
            ]);
        } else {
            // Si les données sont "viables" alors on sauvegarde dans la DB
            if ($teacherToInsert->save()) {
                // rediriger sur la page "liste"
                $this->redirect('teacher-list');
            } else {
                echo 'Le professeur n\'a pas pu être rajouté suite à une erreur';
            }
        }
    }

    /**
     * Méthode gérant la page affichant le formulaire d'édition d'un professeur
     *
     * @return void
     */
    public function update($teacherId)
    {

        $teacher = Teacher::find($teacherId);
        // dump($teacher);

        $this->show('teacher/edit', [
            'teacher' => $teacher
        ]);
    }

    /**
     * Méthode gérant la page traitant les informations envoyées par le formulaire d'édition d'un professeur
     *
     * @return void
     */
    public function updatePost($teacherId)
    {
        // Récupération des informations du formulaire
        $firstname = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_SPECIAL_CHARS);
        $lastname = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_SPECIAL_CHARS);
        $job = filter_input(INPUT_POST, 'job');
        $status = filter_input(INPUT_POST, 'status', FILTER_VALIDATE_INT);

        // Pour mettre à jour le professeur :
        // on récupère l'objet professeur à modifier
        $teacherToUpdate = Teacher::find($teacherId);

        // modifier les propriétés de l'objet professeur
        $teacherToUpdate->setFirstname($firstname);
        $teacherToUpdate->setLastname($lastname);
        $teacherToUpdate->setJob($job);
        $teacherToUpdate->setStatus($status);

        if ($teacherToUpdate->save()) {
            // Si la mise à jour en BDD a fonctionné, alors on redirige vers la liste des professeurs
            $this->redirect('teacher-list');
        } else {
            // Afficher un message d'erreur à l'utilisateur
            exit("Echec lors de la mise à jour du professeur, veuillez contacter l'administrateur du site");
        }
    }

    public function delete($id)
    {
        $teacherToDelete = Teacher::find($id);
        
        if ($teacherToDelete->delete()) {
            // Si la suppression en BDD a fonctionné, alors on redirige vers la liste des professeurs
            $this->redirect('teacher-list');
        } else {
            // Afficher un message d'erreur à l'utilisateur
            exit("Echec lors de la suppression du professeur, veuillez contacter l'administrateur du site");
        }
    }
}
