<?php

namespace Modules\PkgJustificatif\App\Models;

use Illuminate\Database\Eloquent\Model;

use Modules\PkgApprenant\App\Models\Apprenant;

class Justificatif extends Model
{
    protected $fillable = [
        'titre',
        'dateDepot',
        'dateDebut',
        'dateFin',
        'fichier',
        'description',
        'apprenant_id',
        'raison_id',
        'statut'
    ];

    public function apprenant()
    {
        return $this->belongsTo(Apprenant::class);
    }

    /**
     * Relation avec le modèle Raison
     */
    public function raison()
    {
        return $this->belongsTo(Raison::class);
    }
}
