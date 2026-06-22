<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { ref, onMounted } from 'vue';

defineOptions({ layout: AdminLayout });

const stockages = ref([
    { date: '08/05/2026', numero: '2026/11/234', client: 'SIFA SARL', categorie: 'Véhicules', nature: 'Voiture', poids: '2,340', reliquat: '(Suivi)', destination: 'Mali', stockage: 'Normal' },
    { date: '08/05/2026', numero: '2026/11/235', client: 'DOGEYAM TRANSP', categorie: 'Divers', nature: 'JOUET ET APPAREIL', poids: '110.00', reliquat: '(Suivi)', destination: 'Mali', stockage: 'Normal' },
    { date: '08/05/2026', numero: '2026/11/236', client: 'TRAHS RELAS TRANS', categorie: 'Divers', nature: 'MOTOR', poids: '52,781', reliquat: '(Suivi)', destination: 'Mali', stockage: 'Normal' },
    { date: '08/05/2026', numero: '2026/11/237', client: 'CARAMA INTERNATIONAL', categorie: 'Véhicules', nature: 'Voiture', poids: '1,200', reliquat: '(Suivi)', destination: 'Mali', stockage: 'Normal' },
]);

const activities = ref([
    { icon: 'bi-box-seam', color: '#4CAF50', bg: '#e8f5e9', title: 'Nouveau stockage ajouté', desc: 'STK-20240516-027 par Nouvelle Import', time: 'Il y a 2 minutes' },
    { icon: 'bi-truck', color: '#2196F3', bg: '#e3f2fd', title: 'Enlèvement planifié', desc: 'ENL-20240516-015 pour United Foods', time: 'Il y a 15 minutes' },
    { icon: 'bi-activity', color: '#FF9800', bg: '#fff3e0', title: 'Nouveau traffic créé', desc: 'Traffic #TRF-045263 vers le Mali', time: 'Il y a 1 heure' },
    { icon: 'bi-currency-dollar', color: '#4CAF50', bg: '#e8f5e9', title: 'Nouvelle facture générée', desc: 'Facture F-23-00362-00881 pour 870.00 CFA', time: 'Il y a 2 heures' },
    { icon: 'bi-box-seam', color: '#9C27B0', bg: '#f3e5f5', title: 'Stockage terminé', desc: 'STK-20240509-012 marchandise enlevée', time: 'Il y a 4 heures' },
]);

const chartData = ref({
    labels: ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'],
    entrees: [78, 65, 92, 85, 98, 72, 60],
    entreposes: [60, 55, 75, 70, 82, 65, 55],
    traites: [45, 40, 58, 52, 63, 48, 42],
});

onMounted(() => {
    // Draw the chart on canvas
    const canvas = document.getElementById('warehouseChart');
    if (canvas) {
        const ctx = canvas.getContext('2d');
        drawChart(ctx);
    }
});

function drawChart(ctx) {
    const data = chartData.value;
    const canvas = ctx.canvas;
    const w = canvas.width;
    const h = canvas.height;
    const padding = { top: 20, right: 20, bottom: 40, left: 40 };
    const chartW = w - padding.left - padding.right;
    const chartH = h - padding.top - padding.bottom;
    const maxVal = 100;
    const barGroupWidth = chartW / data.labels.length;
    const barWidth = barGroupWidth * 0.22;
    const gap = 4;

    ctx.clearRect(0, 0, w, h);

    // Grid lines
    ctx.strokeStyle = '#f0f0f0';
    ctx.lineWidth = 1;
    for (let i = 0; i <= 4; i++) {
        const y = padding.top + (chartH / 4) * i;
        ctx.beginPath();
        ctx.moveTo(padding.left, y);
        ctx.lineTo(w - padding.right, y);
        ctx.stroke();
        ctx.fillStyle = '#999';
        ctx.font = '11px Montserrat';
        ctx.textAlign = 'right';
        ctx.fillText(maxVal - (maxVal / 4) * i, padding.left - 8, y + 4);
    }

    const colors = ['#1a8a7d', '#4ecdc4', '#a8e6cf'];

    data.labels.forEach((label, i) => {
        const groupX = padding.left + barGroupWidth * i;
        const val = data.traites[i]; // Just draw one bar like in the mockup
        
        const barH = (val / maxVal) * chartH;
        const x = groupX + (barGroupWidth - barWidth) / 2; // centered
        const y = padding.top + chartH - barH;

        ctx.fillStyle = '#cbf3e9'; // Light cyan matching the mockup
        ctx.beginPath();
        const radius = 4;
        ctx.moveTo(x + radius, y);
        ctx.lineTo(x + barWidth - radius, y);
        ctx.quadraticCurveTo(x + barWidth, y, x + barWidth, y + radius);
        ctx.lineTo(x + barWidth, y + barH);
        ctx.lineTo(x, y + barH);
        ctx.lineTo(x, y + radius);
        ctx.quadraticCurveTo(x, y, x + radius, y);
        ctx.fill();

        ctx.fillStyle = '#666';
        ctx.font = '12px Montserrat';
        ctx.textAlign = 'center';
        ctx.fillText(label, groupX + (barWidth * 3 + gap * 2) / 2, h - padding.bottom + 20);
    });
}
</script>

<template>
    <div class="container-fluid">
        <!-- Welcome Section -->
        <div class="page-title">
            <div class="row">
                <div class="col-12">
                    <h1 class="f-w-700 mb-1" style="font-size: 24px; color: #111827;">Welcome Alex 👋</h1>
                    <p class="mb-0" style="font-size: 13px; color: #6b7280;">Voici un aperçu de vos activités récentes</p>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="container-fluid">
            <div class="row">
                <!-- Total Stockages -->
                <div class="col-xl-3 col-sm-6 mb-4">
                    <div class="card o-hidden h-100" style="border: 1px solid #eaecf0; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: #fff3e0;">
                                    <i class="bi bi-box" style="font-size: 20px; color: #e65100;"></i>
                                </div>
                                <span style="font-size: 12px; color: #9ca3af;">+10.5% dernier semaine</span>
                            </div>
                            <h2 class="f-w-700 mb-1" style="font-size: 20px; color: #212529;">1,523</h2>
                            <span style="font-size: 13px; color: #6b7280;">Total Stockages</span>
                        </div>
                    </div>
                </div>

                <!-- Enlèvements en attente -->
                <div class="col-xl-3 col-sm-6 mb-4">
                    <div class="card o-hidden h-100" style="border: 1px solid #eaecf0; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: #fff9c4;">
                                    <i class="bi bi-activity" style="font-size: 20px; color: #fbc02d;"></i>
                                </div>
                                <span style="font-size: 12px; color: #9ca3af;">+7.2% dernier semaine</span>
                            </div>
                            <h2 class="f-w-700 mb-1" style="font-size: 20px; color: #212529;">128</h2>
                            <span style="font-size: 13px; color: #6b7280;">Enlèvements en attente</span>
                        </div>
                    </div>
                </div>

                <!-- Redevances dues -->
                <div class="col-xl-3 col-sm-6 mb-4">
                    <div class="card o-hidden h-100" style="border: 1px solid #eaecf0; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: #ffebee;">
                                    <i class="bi bi-currency-dollar" style="font-size: 20px; color: #d32f2f;"></i>
                                </div>
                                <span style="font-size: 12px; color: #9ca3af;">+12.8% dernier semaine</span>
                            </div>
                            <h2 class="f-w-700 mb-1" style="font-size: 20px; color: #212529;">45,780 <small style="font-size: 13px; color: #6b7280;">CFA</small></h2>
                            <span style="font-size: 13px; color: #6b7280;">Redevances dues</span>
                        </div>
                    </div>
                </div>

                <!-- Trafics actifs -->
                <div class="col-xl-3 col-sm-6 mb-4">
                    <div class="card o-hidden h-100" style="border: 1px solid #eaecf0; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: #e0f2f1;">
                                    <i class="bi bi-truck" style="font-size: 20px; color: #00897b;"></i>
                                </div>
                                <span style="font-size: 12px; color: #9ca3af;">+3.2% dernier semaine</span>
                            </div>
                            <h2 class="f-w-700 mb-1" style="font-size: 20px; color: #212529;">36</h2>
                            <span style="font-size: 13px; color: #6b7280;">Trafics actifs</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stockages récents + Journal d'activités -->
            <div class="row">
                <!-- Stockages récents -->
                <div class="col-xl-8 col-md-12 mb-4">
                    <div class="card h-100" style="border: 1px solid #eaecf0; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
                        <div class="card-header bg-white pb-0 d-block w-100" style="border-bottom: none; border-top-left-radius: 12px; border-top-right-radius: 12px; padding-top: 20px;">
                            <h5 class="f-w-600 mb-0 d-inline-block" style="font-size: 15px; color: #4b5563;">Stockages Récents</h5>
                            <a href="#" class="float-end" style="font-size: 12px; color: #1a8a7d; line-height: 24px;">Voir tout →</a>
                        </div>
                        <div class="card-body pt-3">
                            <div class="table-responsive">
                                <table class="table align-middle mb-0" style="border-spacing: 0;">
                                    <thead style="background: #f9fafb;">
                                        <tr>
                                            <th class="text-uppercase f-w-600 border-bottom-0 py-3 px-3" style="font-size: 11px; color: #6b7280; letter-spacing: 0.5px;">Date<br>enregistrement</th>
                                            <th class="text-uppercase f-w-600 border-bottom-0 py-3 px-3" style="font-size: 11px; color: #6b7280; letter-spacing: 0.5px;">Numéro<br>dossier</th>
                                            <th class="text-uppercase f-w-600 border-bottom-0 py-3 px-3" style="font-size: 11px; color: #6b7280; letter-spacing: 0.5px;">Nom client</th>
                                            <th class="text-uppercase f-w-600 border-bottom-0 py-3 px-3" style="font-size: 11px; color: #6b7280; letter-spacing: 0.5px;">Catégorie</th>
                                            <th class="text-uppercase f-w-600 border-bottom-0 py-3 px-3" style="font-size: 11px; color: #6b7280; letter-spacing: 0.5px;">Nature</th>
                                            <th class="text-uppercase f-w-600 border-bottom-0 py-3 px-3" style="font-size: 11px; color: #6b7280; letter-spacing: 0.5px;">Poids<br>brut (Kg)</th>
                                            <th class="text-uppercase f-w-600 border-bottom-0 py-3 px-3" style="font-size: 11px; color: #6b7280; letter-spacing: 0.5px;">Reliquat<br>poids (T)</th>
                                            <th class="text-uppercase f-w-600 border-bottom-0 py-3 px-3" style="font-size: 11px; color: #6b7280; letter-spacing: 0.5px;">Destination</th>
                                            <th class="text-uppercase f-w-600 border-bottom-0 py-3 px-3" style="font-size: 11px; color: #6b7280; letter-spacing: 0.5px;">Stockage</th>
                                            <th class="text-uppercase f-w-600 border-bottom-0 py-3 px-3" style="font-size: 11px; color: #6b7280; letter-spacing: 0.5px;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white">
                                        <tr v-for="(stock, idx) in stockages" :key="idx" style="border-bottom: 1px solid #f3f4f6;">
                                            <td class="py-3 px-3" style="font-size: 12px; color: #9ca3af;">{{ stock.date }}</td>
                                            <td class="py-3 px-3">
                                                <span class="font-monospace f-w-500" style="color: #0d9488; font-size: 13px;">{{ stock.numero }}</span>
                                            </td>
                                            <td class="f-w-500 py-3 px-3" style="font-size: 13px; color: #111827;">{{ stock.client }}</td>
                                            <td class="py-3 px-3" style="font-size: 13px; color: #6b7280;">{{ stock.categorie }}</td>
                                            <td class="py-3 px-3" style="font-size: 13px; color: #6b7280;">{{ stock.nature }}</td>
                                            <td class="f-w-600 py-3 px-3" style="font-size: 13px; color: #111827;">{{ stock.poids }}</td>
                                            <td class="f-style-italic py-3 px-3" style="font-size: 13px; color: #6b7280;">{{ stock.reliquat }}</td>
                                            <td class="py-3 px-3">
                                                <span class="badge" style="background: #dcfce7; color: #166534; font-size: 11px; padding: 4px 8px; border-radius: 4px; font-weight: 500;">
                                                    {{ stock.destination }}
                                                </span>
                                            </td>
                                            <td class="py-3 px-3" style="font-size: 13px; color: #6b7280;">{{ stock.stockage }}</td>
                                            <td class="py-3 px-3 text-center">
                                                <a href="#" style="color: #6b7280; font-size: 16px;"><i class="bi bi-eye"></i></a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Journal d'activités -->
                <div class="col-xl-4 col-md-12 mb-4">
                    <div class="card h-100 d-flex flex-column" style="border: 1px solid #eaecf0; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
                        <div class="card-header bg-white pb-0 d-block w-100" style="border-bottom: none; border-top-left-radius: 12px; border-top-right-radius: 12px; padding-top: 20px;">
                            <h5 class="f-w-600 mb-0 d-inline-block" style="font-size: 15px; color: #4b5563;">Journal d'activités</h5>
                            <a href="#" class="float-end" style="font-size: 12px; color: #0d9488; line-height: 24px;">Voir tout →</a>
                        </div>
                        <div class="card-body pt-4 flex-grow-1 d-flex flex-column justify-content-between">
                            <div v-for="(activity, idx) in activities" :key="idx" class="d-flex align-items-start gap-3">
                                <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" :style="{ width: '40px', height: '40px', background: activity.bg, borderRadius: '10px !important' }">
                                    <i :class="'bi ' + activity.icon" :style="{ color: activity.color, fontSize: '18px' }"></i>
                                </div>
                                <div>
                                    <h6 class="f-w-500 mb-1" style="font-size: 13px; color: #111827;">{{ activity.title }}</h6>
                                    <p class="mb-1" style="font-size: 13px; color: #6b7280;">{{ activity.desc }}</p>
                                    <span style="font-size: 12px; color: #9ca3af;">{{ activity.time }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Activité des entrepôts (Chart) -->
            <div class="row">
                <div class="col-12 mb-4">
                    <div class="card h-100" style="border: 1px solid #eaecf0; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
                        <div class="card-header bg-white pb-0" style="border-bottom: none; border-top-left-radius: 12px; border-top-right-radius: 12px; padding-top: 20px;">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h5 class="f-w-600 mb-1" style="font-size: 15px; color: #4b5563;">Activité des entrepôts</h5>
                                    <p class="mb-0" style="font-size: 12px; color: #9ca3af;">Suivre l'activité par Moles (7 derniers jours)</p>
                                </div>
                                <div class="d-flex gap-3">
                                    <span class="d-flex align-items-center gap-1" style="font-size: 12px; color: #9ca3af;">
                                        <span class="rounded-circle d-inline-block" style="width: 10px; height: 10px; background: #1a8a7d;"></span> Entrées
                                    </span>
                                    <span class="d-flex align-items-center gap-1" style="font-size: 12px; color: #9ca3af;">
                                        <span class="rounded-circle d-inline-block" style="width: 10px; height: 10px; background: #4ecdc4;"></span> Entreposés
                                    </span>
                                    <span class="d-flex align-items-center gap-1" style="font-size: 12px; color: #9ca3af;">
                                        <span class="rounded-circle d-inline-block" style="width: 10px; height: 10px; background: #a8e6cf;"></span> Traités
                                    </span>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-3">
                                    <p class="mb-1" style="font-size: 12px; color: #9ca3af;">Stockages cette semaine</p>
                                    <h4 class="f-w-700" style="font-size: 20px; color: #212529;">162 <small class="ms-2" style="font-size: 12px; color: #2e7d32 !important;"><i class="bi bi-arrow-up-right"></i> +5.2%</small></h4>
                                </div>
                                <div class="col-md-3">
                                    <p class="mb-1" style="font-size: 12px; color: #9ca3af;">Enlèvements cette semaine</p>
                                    <h4 class="f-w-700" style="font-size: 20px; color: #212529;">98 <small class="ms-2" style="font-size: 12px; color: #c62828 !important;"><i class="bi bi-arrow-down-right"></i> -2.1%</small></h4>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <canvas id="warehouseChart" width="900" height="300" style="width: 100%; max-height: 300px;"></canvas>
                            <div class="row mt-3 pt-3" style="border-top: 1px solid #f0f0f0;">
                                <div class="col-md-3">
                                    <p class="mb-1" style="font-size: 12px; color: #9ca3af;">Taux de rotation</p>
                                    <h4 class="f-w-700" style="font-size: 20px;">56</h4>
                                </div>
                                <div class="col-md-3">
                                    <p class="mb-1" style="font-size: 12px; color: #9ca3af;">Capacité totale</p>
                                    <h4 class="f-w-700" style="font-size: 20px;">162,340 <small style="font-size: 12px; color: #9ca3af;">m³</small></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
