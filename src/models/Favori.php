<?php

namespace cocktails\models;

use \Illuminate\Database\Eloquent\Model;

//Classe Favori qui est un modèle Eloquent
class Favori extends Model {

  //Table lié
  protected $table='Favori';
  //Clé primaire de la table
  protected $primaryKey='idFavori';
  //Colonne created_at et updated_at désactivées
  public $timestamps=false;

}
