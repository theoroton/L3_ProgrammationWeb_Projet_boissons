<?php

namespace cocktails\models;

use \Illuminate\Database\Eloquent\Model;

class Utilisateur extends Model {

  protected $table='Utilisateur';
  protected $primaryKey='idUtilisateur';
  public $timestamps=false;

}
