<template>
  <AuthenticatedLayout>
    <div class="p-6">
      <!-- En-tête avec bouton d'exportation -->
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">Tableau de Bord des Absences</h1>
        <ExportButton :data="exportData" />
      </div>

      <!-- Cartes de résumé -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
        <SummaryCard
          title="Total des absences aujourd'hui"
          :value="totalAbsencesToday"
          trend="Aujourd'hui"
          color="blue"
          icon="Database"
        />
        <SummaryCard
          title="Apprenants absents aujourd'hui"
          :value="apprenantsAbsentsToday"
          trend="Aujourd'hui"
          color="red"
          icon="Users"
        />
        <SummaryCard
          title="Taux d'absence global"
          :value="tauxAbsenceGlobal + '%'"
          trend="Aujourd'hui"
          color="green"
          icon="Percent"
        />
      </div>

      <!-- Groupes avec le plus d'absents -->
      <div class="bg-white rounded-lg shadow p-4 mb-6">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">Groupes avec le plus d'absents</h2>
        <ul>
          <li v-for="groupe in groupesAvecPlusAbsents" :key="groupe.id" class="mb-2">
            {{ groupe.nom }} — {{ groupe.absents_count }} absents
          </li>
        </ul>
      </div>

      <!-- Séances avec le plus d'absents -->
      <div class="bg-white rounded-lg shadow p-4 mb-6">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">Séances avec le plus d'absents</h2>
        <ul>
          <li v-for="seance in seancesAvecPlusAbsents" :key="seance.id" class="mb-2">
            Séance #{{ seance.id }} — {{ seance.absences_count }} absents
          </li>
        </ul>
      </div>

      <!-- Apprenants avec plus de 3 absences non justifiées -->
      <div class="bg-white rounded-lg shadow p-4">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">Apprenants avec plus de 3 absences non justifiées</h2>
        <ul>
          <li v-for="apprenant in apprenantsPlus3AbsencesNonJustifiees" :key="apprenant.id" class="mb-2">
            {{ apprenant.nom }} {{ apprenant.prenom }} — {{ apprenant.unjustified_count }} absences non justifiées
          </li>
        </ul>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@core/Layouts/AuthenticatedLayout.vue';
import SummaryCard from './Components/SummaryCard.vue';
import ExportButton from './Components/ExportButton.vue';

const props = defineProps({
  totalAbsencesToday: Number,
  apprenantsAbsentsToday: Number,
  tauxAbsenceGlobal: Number,
  groupesAvecPlusAbsents: Array,
  seancesAvecPlusAbsents: Array,
  apprenantsPlus3AbsencesNonJustifiees: Array,
  exportData: Array
});
</script>

<style scoped>
.chart-container {
  position: relative;
  height: 100%;
}
</style>
