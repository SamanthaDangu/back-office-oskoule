<?php

namespace App\Models;

use App\Utils\Database;
use PDO;

class Student extends CoreModel
{
    private $firstname;
    private $lastname;
    private $teacher_id;
    private $teacherFirstname;

    /**
     *  Méthode permettant de récupérer un enregistrement de la table student en fonction d'un id donné
     *
     * @param int $id L'id de l'utilisateur recherché
     * 
     * @return student
     */
    static public function find($id)
    {
        $pdo = Database::getPDO();
        $sql = '
            SELECT *
            FROM student
            WHERE id = :id
        ';
        $pdoStatement = $pdo->prepare($sql);
        $pdoStatement->bindValue(':id', $id, PDO::PARAM_INT);
        $pdoStatement->execute();
        $student = $pdoStatement->fetchObject(self::class);

        return $student;
    }

    /**
     * Méthode permettant de récupérer tous les enregistrements de la table student
     * 
     * @return student[]
     */
    static public function findAll()
    {
        $pdo = Database::getPDO();
        $sql = '
        SELECT s.*, t.firstname AS teacherFirstname
        FROM student s
        JOIN teacher t
        ON s.teacher_id = t.id
        ';
        $pdoStatement = $pdo->query($sql);
        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, self::class);
        return $results;
    }


    /**
     * Méthode permettant d'ajouter un enregistrement dans la table student
     * L'objet courant doit contenir toutes les données à ajouter : 1 propriété => 1 colonne dans la table
     * 
     * @return bool
     */
    public function insert()
    {
        $pdo = Database::getPDO();
        $sql = '
            INSERT INTO student (firstname, lastname, status, teacher_id)
            VALUES (:firstname, :lastname, :status, :teacher_id)
        ';
        $pdoStatement = $pdo->prepare($sql);
        $pdoStatement->bindValue(':firstname', $this->firstname, PDO::PARAM_STR);
        $pdoStatement->bindValue(':lastname', $this->lastname, PDO::PARAM_STR);
        $pdoStatement->bindValue(':status', $this->status, PDO::PARAM_INT);
        $pdoStatement->bindValue(':teacher_id', $this->teacher_id, PDO::PARAM_INT);
        $pdoStatement->execute();

        $insertedRows = $pdoStatement->rowCount();

        if ($insertedRows > 0) {
            $this->id = $pdo->lastInsertId();
            return true;
        } else {
            return false;
        }
    }

    /**
     * Méthode permettant de mettre à jour un enregistrement dans la table student
     * L'objet courant doit contenir l'id, et toutes les données à ajouter : 1 propriété => 1 colonne dans la table
     * 
     * @return bool
     */
    public function update()
    {
        $pdo = Database::getPDO();
        $sql = '
            UPDATE student
            SET 
                firstname = :firstname,
                lastname = :lastname,
                status = :status,
                teacher_id = :teacher_id;
                updated_at = NOW()
            WHERE id = :id
        ';
        $pdoStatement = $pdo->prepare($sql);
        $pdoStatement->bindValue(':id', $this->id, PDO::PARAM_INT);
        $pdoStatement->bindValue(':firstname', $this->firstname, PDO::PARAM_STR);
        $pdoStatement->bindValue(':lastname', $this->lastname, PDO::PARAM_STR);
        $pdoStatement->bindValue(':status', $this->status, PDO::PARAM_INT);
        $pdoStatement->bindValue(':teacher_id', $this->teacher_id, PDO::PARAM_INT);
        $pdoStatement->execute();

        $updatedRows = $pdoStatement->rowCount();

        return ($updatedRows > 0);
    }

    /**
     * Méthode permettant de supprimer un enregistrement dans la table student
     * L'objet courant doit contenir l'id
     * 
     * @return bool
     */
    public function delete()
    {
        $pdo = Database::getPDO();
        $sql = '
            DELETE FROM student
            WHERE id = :id
        ';
        $pdoStatement = $pdo->prepare($sql);
        $pdoStatement->bindValue(':id', $this->id, PDO::PARAM_INT);
        $pdoStatement->execute();

        $deletedRows = $pdoStatement->rowCount();

        return ($deletedRows > 0);
    }

    /**
     * Get the value of firstname
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set the value of firstname
     *
     * @return  self
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get the value of lastname
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set the value of lastname
     *
     * @return  self
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }



    /**
     * Get the value of teacher_id
     */
    public function getTeacher_id()
    {
        return $this->teacher_id;
    }

    /**
     * Set the value of teacher_id
     *
     * @return  self
     */
    public function setTeacher_id($teacher_id)
    {
        $this->teacher_id = $teacher_id;

        return $this;
    }

    /**
     * Get the value of teacherFirstname
     */
    public function getTeacherFirstname()
    {
        return $this->teacherFirstname;
    }

    /**
     * Set the value of teacherFirstname
     *
     * @return  self
     */
    public function setTeacherFirstname($teacherFirstname)
    {
        $this->teacherFirstname = $teacherFirstname;

        return $this;
    }
}
