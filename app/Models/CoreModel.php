<?php

namespace App\Models;


abstract class CoreModel
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var int
     */
    protected int $status;

    /**
     * @var string
     */
    protected $created_at;
    /**
     * @var string
     */
    protected $updated_at;


    /**
     * Get the value of id
     *
     * @return  int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get the value of created_at
     *
     * @return  string
     */
    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    /**
     * Get the value of updated_at
     *
     * @return  string
     */
    public function getUpdatedAt(): string
    {
        return $this->updated_at;
    }

    /**
     * Get the value of status
     *
     * @return  int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @param  int  $status
     *
     * @return  self
     */
    public function setStatus(int $status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Le but de cette méthode : mettre à jour la bdd
     * @return bool Retourne true si la sauvegarde a réussi et false sinon
     */
    public function save()
    {
        // si l'entité existe déjà en BDD, on la met à jour 
        if ($this->getId() > 0) {
            // donc on fait un update
            return $this->update();
        } else {
            //  si l'entité n'existe pas encore en BDD, on la crée
            return $this->insert();
        }
    }

    // oblige les enfants à avoir ces méthodes
    abstract static public function find($id);
    abstract static public function findAll();
    abstract public function insert();
    abstract public function update();
    abstract public function delete();
}
