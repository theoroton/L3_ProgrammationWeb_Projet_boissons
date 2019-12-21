<?php

namespace cocktails\models;

use \Illuminate\Database\Eloquent\Model;

//Classe Utilisateur qui est un modèle Eloquent
class Utilisateur extends Model {

  //Table lié
  protected $table='Utilisateur';
  //Clé primaire de la table
  protected $primaryKey='idUtilisateur';
  //Colonne created_at et updated_at désactivées
  public $timestamps=false;

}
