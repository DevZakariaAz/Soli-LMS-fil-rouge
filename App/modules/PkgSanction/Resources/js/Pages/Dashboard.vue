<template>
    <AuthenticatedLayout>
        <div class="min-h-screen bg-gray-50 p-4 md:p-6">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6">Tableau de bord</h1>

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <SummaryCard title="Sanctions actives"
                    :value="recentSanctionsCount ? `${activeSanctionCount}/${sanctionsAbsenceCount}` : '0/0'"
                    trend="voir les détails" color="blue" icon="Gavel" />
                <SummaryCard title="Sanctions  semaine" :value="recentSanctionsCount ?? 0"
                    trend="Baisse de 5% cette semaine" color="orange" icon="Calendar" />
                <SummaryCard title="Sanctions non résolues" :value="sanctionsAbsencePrevisionnelleCount ?? 0"
                    trend="voir les détails" color="red" icon="AlertTriangle" />
                <SummaryCard title="Taux de récurrence" value="15%" trend="Baisse de 2% ce trimestre"
                    color="green" icon="Percent" />
            </div>

            <!-- Charts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <div class="bg-white rounded-lg shadow p-4">
                    <h2 class="text-lg font-semibold text-gray-700 mb-4">Évolution mensuelle des sanctions</h2>
                    <div class="h-64">
                        <LineChart :chartData="monthlySanctionsChartData" />
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-4">
                    <h2 class="text-lg font-semibold text-gray-700 mb-4">Répartition par type de sanction</h2>
                    <div class="h-64">
                        <PieChart :chartData="sanctionsByTypesChartData" />
                    </div>
                </div>
            </div>

            <!-- <div class="bg-white rounded-lg shadow p-4 mb-6">
                <h2 class="text-lg font-semibold text-gray-700 mb-4">Top 5 des formateurs ayant le plus d'apprenants
                    sanctionnés</h2>
                <div class="h-64">
                    <BarChart :chartData="trainersChartData" />
                </div>
            </div> -->

            <!-- Recent Sanctions Table -->
            <SanctionsTable :sanctions="recentSanctions" class="mb-6" />

            <!-- Analytics Box -->
            <!-- <AnalyticsBox :analytics="analyticsData" /> -->
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref, computed } from 'vue';
import AuthenticatedLayout from '@core/Layouts/AuthenticatedLayout.vue';

import SummaryCard from '../Components/Dashboard/SummaryCard.vue';
import SanctionsTable from '../Components/Dashboard/SanctionsTable.vue';
import AnalyticsBox from '../Components/Dashboard/AnalyticsBox.vue';
import LineChart from '../Components/Dashboard/LineChart.vue';
import PieChart from '../Components/Dashboard/PieChart.vue';
import BarChart from '../Components/Dashboard/BarChart.vue';

const props = defineProps({
    sanctionsAbsenceCount: Number,
    sanctionsAbsencePrevisionnelleCount: Number,
    recentSanctions: Array,
    recentSanctionsCount: Number,
    activeSanctionCount: Number,
    monthlySanctions: Array,
    sanctionsByTypes: Array,
});

console.log(props.sanctionsByTypes);

const monthlySanctionsChartData = computed(() => {
    if (!props.monthlySanctions || !props.monthlySanctions.length) {
        return {
            labels: [],
            datasets: []
        };
    }

    return {
        labels: props.monthlySanctions.map(item => item.month),
        datasets: [
            {
                label: 'Sanctions',
                data: props.monthlySanctions.map(item => item.count),
                borderColor: '#3b82f6',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                borderWidth: 2,
                tension: 0.3,
                fill: true,
            }
        ],
    };
});

const sanctionsByTypesChartData = computed(() => {
    return {
        labels: props.sanctionsByTypes.map(item => item.penalite),
        datasets: [
            {
                data: props.sanctionsByTypes.map(item => item.value),
                backgroundColor: [
                    'rgba(59, 130, 246, 0.8)',
                    'rgba(245, 158, 11, 0.8)',
                    'rgba(239, 68, 68, 0.8)',
                    'rgba(16, 185, 129, 0.8)',
                ],
                borderWidth: 1,
            }
        ]
    };
});

// Analytics data
const analyticsData = ref({
    tendance: {
        value: 'En hausse',
        icon: 'TrendingUp',
        color: 'red'
    },
    apprenants: {
        value: '12',
        icon: 'Users',
        color: 'orange'
    },
    duree: {
        value: '5 jours',
        icon: 'Clock',
        color: 'blue'
    },
    attente: {
        value: '7',
        icon: 'AlertCircle',
        color: 'red'
    }
});
</script>