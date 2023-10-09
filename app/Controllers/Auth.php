<?php namespace App\Controllers;

//crio a classe só para ter route para / pois se fosse route / para a home depois não conseguia fazer render das views do namespace do ionauth sem ter de copiar as pastas das views para a app
class Auth extends \IonAuth\Controllers\Auth
{
    /**
     * If you want to customize the views,
     *  - copy the ion-auth/Views/auth folder to your Views folder,
     *  - remove comment
     */
    // protected $viewsFolder = 'auth';
    
    
}