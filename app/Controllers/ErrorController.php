<?php

namespace App\Controllers;

class ErrorController extends CoreController
{
    /**
     * Méthode gérant l'affichage de la page 403 si l'utilisateur n'a pas les droits
     *
     * @return void
     */
    public function err403()
    {
        // On envoie le header 403
        header('HTTP/1.1 403 Forbidden');
        // Puis on affiche la page d'erreur 403
        $this->show('error/err403');
        // arrêt du script
        exit();
    }

    /**
     * Méthode gérant l'affichage de la page 404
     *
     * @return void
     */
    public function err404()
    {
        // Affichage du template
        $this->show('error/err404');

        //arrêt du script
        exit();
    }
}
