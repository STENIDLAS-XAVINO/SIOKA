<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FlashInfos extends Model
{
    protected $fillable = ['contenu', 'date_publication', 'statut', 'categorie'];
}
