<?php

namespace App\Controllers;

use App\Models\Student;
use App\Models\CoreModel;

class StudentController extends CoreController
{
    /**
     * Méthode gérant la page affichant la liste des élèves
     * @return void
     */
    public function list()
    {
        $studentsList = Student::findAll();

        // Affichage du template et informations pour le viewdata
        $this->show('student/list', [
            'students_list' => $studentsList
        ]);
    }

    /**
     * Méthode gérant la page contenant le formulaire d'ajout d'un élève
     *
     * @return void
     */
    public function add()
    {
        $this->show('student/add');
    }


    /**
     * Méthode gérant la page recevant les données du formulaire d'ajout d'un élève
     * @return void
     */
    public function create()
    {
        // récupérer les données du formulaire
        $firstname = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_SPECIAL_CHARS);
        $lastname = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_SPECIAL_CHARS);
        $teacher_id = filter_input(INPUT_POST, 'teacher_id');
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
        if ($teacher_id === '') {
            $errorsList[] = 'Le élève doit être renseigné';
        }
        if ($status === '') {
            $errorsList[] = 'Le statut doit être renseigné';
        }

        //ajout en DB
        $studentToInsert = new Student();
        $studentToInsert->setFirstname($firstname);
        $studentToInsert->setLastname($lastname);
        $studentToInsert->setTeacher_id($teacher_id);
        $studentToInsert->setStatus($status);

        if (!empty($errorsList)) {
            // Si il y a des erreurs
            dump($errorsList);
            $this->show('student/add', [
                'errors_list' => $errorsList,
                'student' => $studentToInsert
            ]);
        } else {
            // Si les données sont "viables" alors on sauvegarde dans la DB
            if ($studentToInsert->save()) {
                // rediriger sur la page "liste"
                $this->redirect('student-list');
            } else {
                echo 'L\'élève n\'a pas pu être rajouté suite à une erreur';
            }
        }
    }

    /**
     * Méthode gérant la page affichant le formulaire d'édition d'un élève
     *
     * @return void
     */
    public function update($studentId)
    {

        $student = Student::find($studentId);
        // dump($student);

        $this->show('student/edit', [
            'student' => $student
        ]);
    }

    /**
     * Méthode gérant la page traitant les informations envoyées par le formulaire d'édition d'un élève
     *
     * @return void
     */
    public function updatePost($studentId)
    {
        // Récupération des informations du formulaire
        $firstname = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_SPECIAL_CHARS);
        $lastname = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_SPECIAL_CHARS);
        $teacher_id = filter_input(INPUT_POST, 'teacher_id');
        $status = filter_input(INPUT_POST, 'status', FILTER_VALIDATE_INT);

        // Pour mettre à jour le élève :
        // on récupère l'objet élève à modifier
        $studentToUpdate = Student::find($studentId);

        // modifier les propriétés de l'objet élève
        $studentToUpdate->setFirstname($firstname);
        $studentToUpdate->setLastname($lastname);
        $studentToUpdate->setTeacher_id($teacher_id);
        $studentToUpdate->setStatus($status);

        if ($studentToUpdate->save()) {
            // Si la mise à jour en BDD a fonctionné, alors on redirige vers la liste des élèves
            $this->redirect('student-list');
        } else {
            // Afficher un message d'erreur à l'utilisateur
            exit("Echec lors de la mise à jour du élève, veuillez contacter l'administrateur du site");
        }
    }

    public function delete($id)
    {
        $studentToDelete = Student::find($id);
        
        if ($studentToDelete->delete()) {
            // Si la suppression en BDD a fonctionné, alors on redirige vers la liste des élèves
            $this->redirect('student-list');
        } else {
            // Afficher un message d'erreur à l'utilisateur
            exit("Echec lors de la suppression de l'élève, veuillez contacter l'administrateur du site");
        }
    }
}
