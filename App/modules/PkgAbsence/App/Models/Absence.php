<?php

namespace Modules\PkgAbsence\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Seance;
use Modules\PkgApprenant\App\Models\Apprenant;
class Absence extends Model
{
    use HasFactory;

    protected $fillable = [
        'apprenant_id',
        'seance_id',
        'date_absence',
    ];

    public function apprenant()
    {
        return $this->belongsTo(Apprenant::class);
    }
    public function seance()
    {
        return $this->belongsTo(Seance::class);
    }
}
