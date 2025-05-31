<?php

namespace Modules\PkgAbsence\App\Services;

use Modules\PkgAbsence\App\Models\Absence;
use Modules\PkgApprenant\App\Models\Apprenant;
use Modules\PkgApprenant\App\Models\Groupe;
use App\Models\Seance;

class AbsenceService
{
    public function getDashboardData(): array
    {
        return [
            'totalAbsencesToday'                       => $this->getTotalAbsencesToday(),
            'apprenantsAbsentsToday'                  => $this->getNbApprenantsAbsentsToday(),
            'groupesAvecPlusAbsents'                  => $this->getGroupesWithMostAbsentsToday(),
            'seancesAvecPlusAbsents'                  => $this->getSeancesWithMostAbsentsToday(),
            'tauxAbsenceGlobal'                       => $this->getTauxAbsenceGlobalToday(),
            'apprenantsPlus3AbsencesNonJustifiees'    => $this->getApprenantsWithMoreThan3UnjustifiedAbsences(),
        ];
    }
    // fonction de total absences today 
    public function getTotalAbsencesToday(): int
    {
        return Absence::whereHas('seance', function ($query) {
            $query->whereDate('date_debut', now()->toDateString());
        })->count();
    }
    public function getNbApprenantsAbsentsToday(): int
    {
        return Absence::whereHas('seance', function ($query) {
            $query->whereDate('date_debut', now()->toDateString());
        })->distinct('user_id')->count('user_id');
    }
    public function getGroupesWithMostAbsentsToday()
    {
        return Groupe::withCount(['apprenants as absents_count' => function ($query) {
            $query->whereHas('absences', function ($q) {
                $q->whereHas('seance', function ($sq) {
                    $sq->whereDate('date_debut', now()->toDateString());
                });
            });
        }])->orderByDesc('absents_count')->get();
    }
    public function getSeancesWithMostAbsentsToday()
    {
        return Seance::whereDate('date_debut', now()->toDateString())
            ->withCount('absences')
            ->orderByDesc('absences_count')
            ->get();
    }
    public function getTauxAbsenceGlobalToday(): float
    {
        $totalApprenants = Apprenant::count();
        if ($totalApprenants === 0) return 0;

        $absentsAujourdHui = $this->getNbApprenantsAbsentsToday();

        return round(($absentsAujourdHui / $totalApprenants) * 100, 2);
    }
    public function getApprenantsWithMoreThan3UnjustifiedAbsences()
    {
        return Apprenant::whereHas('absences', function ($query) {
            $query->where('justifie', false);
        })
        ->withCount(['absences as unjustified_count' => function ($q) {
            $q->where('justifie', false);
        }])
        ->having('unjustified_count', '>', 3)
        ->get();
    }

}
