<?php

namespace Modules\PkgAbsence\Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Absence;
use Modules\PkgApprenant\App\Models\Apprenant;
use App\Models\Seance;
class AbsencesSeeder extends Seeder
{
    public function run()
    {
        $apprenants = Apprenant::all();
        $seances = Seance::all();

        foreach (range(1, 20) as $i) {
            Absence::create([
                'apprenant_id' => $apprenants->random()->id,
                'seance_id' => $seances->random()->id,
                'date_absence' => now()->subDays(rand(0, 30))->toDateString(),
            ]);
        }
    }
}
