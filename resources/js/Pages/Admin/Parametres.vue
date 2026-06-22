<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { ref, computed } from 'vue';

defineOptions({ layout: AdminLayout });

const tables = ref([
    { id: 'categorie', label: 'Catégories', icon: 'bi-layers', data: ['Engrais', 'Céréales', 'Farines', 'Véhicules', 'Divers'] },
    { id: 'famillearticle', label: 'Famille Article', icon: 'bi-tag', data: ['(Voir base de données ~3851 lignes)'] },
    { id: 'famille_hydrocarbure', label: 'Famille Hydrocarbure', icon: 'bi-droplet', data: ['Gasoil', 'Super', 'Jet A1', 'FO 180', 'FO 380', 'Gaz', 'Bitume', 'Huile lubrifiante', 'Graisse', 'Petrole', 'Autre'] },
    { id: 'nature_import', label: "Nature Import", icon: 'bi-box-arrow-in-down', data: ['Maïs', 'Riz', 'Blé (arachide)', 'Farine et pâtes alimentaires', 'Sucre', 'Lait (Ardo)', 'Huile Mayonnaise + moutarde (Margarine)', 'Sel', 'Thé', 'Boisson', 'Jus de fruit + bonbon', 'Chocolat + biscuit', 'Poissons et résidus de poisson', 'Concentré de tomate', 'Bouillon (Aromes)', 'Oignons + pomme de terre ails (Haricots)', 'Aliment volaille', 'Tabac et cigarettes', 'Textiles et bonneterie', 'Véhicules', 'Véhicules et pieces détachées', 'Matériels et équipements', 'Ciment', 'Ciment blanc céramique', 'Fil machine', 'Bois et meubles en bois', 'Autres matériaux (bitume)', 'Librairie papeterie', 'Produits pharmaceutiques', 'Produits chimiques et cosmétiques produits de beauté', 'Poudre de calcaire', 'Phosphate', 'Préforme', 'Emballage+Plastique', 'Détergent', 'Polypropylène tuyaux', 'Savon', 'Hydrocarbure Gaz Oïl', 'Gaz', 'Super et/ou Jet', 'Fuel', 'Lubrifiant', 'Matériels agricoles', 'Tracteur (machine grue)', 'Autres engins lourds', 'Divers', 'Minerais'] },
    { id: 'nature_export', label: "Nature Export", icon: 'bi-box-arrow-up', data: ['Bovin', 'Ovins - Caprins', 'Peaux et cuirs (viande)', 'Coton', 'Coton et Dérivés', 'Coton fibre (déchet)', 'Graines de coton', 'Tourteaux', 'Fil à tisser (Bois scie)', 'Denrées alimentaires', 'Fruits secs et jus de mangue', 'Son de blé', 'Céréales', 'Riz (semasse de riz)', 'Mil / Maïs', 'Arachide', 'Haricot / Patate', 'Aliment de bétail', 'Produits de ceuillette (gomme arabique)', 'Amande de karité, huile de palme, Zaban', 'Amande d\'acajou (sésames)', 'Comme arabique (Tamarin, Patate)', 'Fer à béton', 'Ferrailles', 'Divers', 'Minerais'] },
    { id: 'lieu_stockage', label: 'Lieu de stockage', icon: 'bi-building', data: ['Mole 1', 'Mole 2', 'Mole 3', 'Mole 4', 'Mole 5', 'Mole 6', 'Mole 7', 'Mole 8', 'Mole 9', 'Mole 10', 'KAOLACK', 'Autre'] },
    { id: 'depot_hydrocarbure', label: 'Dépôt Hydrocarbure', icon: 'bi-fuel-pump', data: ['Sen Stock (produits blancs)', 'Sen Stock (produits noirs)', 'Sen Stock (Mbao)', 'Vivo Getee Nord', 'DOT', 'Oryx', 'Shell', 'ERES', 'JETEE NORD', 'CSL', 'TOUBA GAZ', 'PUMA ENERGY', 'GAMPETROLEUM', 'ATLAS ENERGIE GAMBIA', 'TOUBA OIL', 'GENERAL PETROLEUM SERVICES'] },
    { id: 'pays_destinataire', label: 'Pays Destinataire', icon: 'bi-globe', data: ['Mali', 'Burkina Faso', 'Niger', 'Ghana', "Côte d'Ivoire", 'Guinée Conakry', 'Togo', 'Bénin', 'Mauritanie', 'Autre'] },
    { id: 'mode_transport', label: 'Mode Transport', icon: 'bi-truck', data: ['Route', 'Fer'] },
    { id: 'modepaiement', label: 'Mode Paiement', icon: 'bi-credit-card', data: ['Chéque', 'Virement', 'Espèce'] },
    { id: 'condtions', label: 'Conditions', icon: 'bi-calendar3', data: ['15 jours', '30 jours', '45 jours', '60 jours', '90 jours', '120 jours', '180 jours', 'Fin mois'] },
    { id: 'regime', label: 'Régime', icon: 'bi-shield-check', data: ['E100', 'E930', 'E950', 'R100', 'R110', 'R120', 'R300', 'R320', 'R400', 'R404', 'R420', 'R520', 'R530', 'R531', 'R600', 'R951', 'R953', 'S110', 'S111', 'S120', 'S210', 'LTA', 'TIF', 'E840', 'R510'] },
    { id: 'fonction_utilisateur', label: 'Fonction Utilisateur', icon: 'bi-person-badge', data: ['Gérant', 'Contrôle de sécurité', 'Statistique', 'Facturation', 'Caisse', 'Comptabilité', 'Statistique-Hydro', 'Statistique-Divers', 'Agent de Transit', 'Stockage-Trafic', 'Caisse-Facturation', 'Transitaire', 'CMC', 'Pont-Bascule'] },
    { id: 'statut_utilisateur', label: 'Statut Utilisateur', icon: 'bi-person-check', data: ['Simple', 'Validateur', 'Superviseur', 'Administrateur', 'Vérificateur'] },
    { id: 'taux_tva', label: 'Taux TVA', icon: 'bi-percent', data: ['18', '0'] },
    { id: 'taxe_cmc', label: 'Taxe CMC', icon: 'bi-cash-coin', data: ['Engin', 'Conteneur (20p)', 'Conteneur (40p)', 'Conventionnel'] }
]);

const activeTableId = ref('categorie');
const activeTable = computed(() => tables.value.find(t => t.id === activeTableId.value));

const newItem = ref('');
const currentPage = ref(1);
const perPage = 10;

const pagedData = computed(() => {
    if(!activeTable.value) return [];
    return activeTable.value.data.slice((currentPage.value - 1) * perPage, currentPage.value * perPage);
});

const totalPages = computed(() => {
    if(!activeTable.value) return 1;
    return Math.ceil(activeTable.value.data.length / perPage) || 1;
});

const selectTab = (id) => {
    activeTableId.value = id;
    currentPage.value = 1;
    newItem.value = '';
};

const addItem = () => {
    if (newItem.value.trim() && activeTable.value) {
        activeTable.value.data.push(newItem.value.trim());
        newItem.value = '';
    }
};

const removeItem = (index) => {
    if (activeTable.value) {
        const realIndex = (currentPage.value - 1) * perPage + index;
        activeTable.value.data.splice(realIndex, 1);
        if (pagedData.value.length === 0 && currentPage.value > 1) {
            currentPage.value--;
        }
    }
};
</script>

<template>
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="page-title mb-4">
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="d-flex align-items-center gap-3">
                        <div class="d-flex align-items-center justify-content-center rounded-2" style="width:48px;height:48px;background:#e6f4f2;">
                            <i class="bi bi-gear" style="font-size:22px;color:#1a8a7d;"></i>
                        </div>
                        <div>
                            <h4 class="mb-0 f-w-700" style="color:#111827;">Paramètres Généraux</h4>
                            <p class="mb-0 f-13" style="color:#6b7280;">Gérer les référentiels et listes de valeurs</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Horizontal Tabs -->
        <div class="d-flex gap-2 overflow-auto mb-4 hide-scrollbar" style="white-space: nowrap; padding-bottom: 5px;">
            <button v-for="tab in tables" :key="tab.id"
                    @click="selectTab(tab.id)"
                    class="btn d-inline-flex align-items-center gap-2 rounded-pill f-13 f-w-600 transition-all"
                    :style="activeTableId === tab.id
                        ? 'background:#1a8a7d; color:#fff; border: 1px solid #1a8a7d; padding: 8px 18px;'
                        : 'background:#fff; color:#6b7280; border: 1px solid #eaecf0; padding: 8px 18px;'">
                <i :class="tab.icon" :style="activeTableId === tab.id ? 'color:#fff;' : 'color:#9ca3af;'"></i>
                {{ tab.label }}
            </button>
        </div>

        <!-- Main Card -->
        <div class="card border-0 shadow-sm" style="border-radius:12px;">
            <div class="card-header bg-white border-bottom p-4" style="border-top-left-radius: 12px; border-top-right-radius: 12px;">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background: #e6f4f2;">
                        <i :class="activeTable.icon" style="color: #1a8a7d; font-size: 16px;"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 f-w-600" style="color: #111827; font-size: 16px;">{{ activeTable.label }}</h5>
                        <p class="mb-0 f-12" style="color: #6b7280;">Gérer les valeurs de la liste "{{ activeTable.label }}"</p>
                    </div>
                </div>
            </div>
            
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr style="background:#fafafa;">
                                <th class="text-uppercase f-w-600 py-3 px-4" style="color:#9ca3af;font-size:11px;letter-spacing:0.5px;border-bottom:1px solid #f3f4f6;">{{ activeTable.label }}</th>
                                <th class="text-uppercase f-w-600 py-3 px-4 text-end" style="color:#9ca3af;font-size:11px;letter-spacing:0.5px;border-bottom:1px solid #f3f4f6;">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, idx) in pagedData" :key="idx" style="border-bottom:1px solid #f9fafb;">
                                <td class="py-3 px-4 f-w-500 f-14" style="color:#111827;">{{ item }}</td>
                                <td class="py-3 px-4 text-end">
                                    <button class="btn p-0 border-0 bg-transparent" @click="removeItem(idx)">
                                        <i class="bi bi-trash" style="font-size:15px; color: #ef4444;"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr v-if="pagedData.length === 0">
                                <td colspan="2" class="text-center py-4 text-muted f-13">Aucune donnée disponible.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Footer: Pagination & Add Form -->
            <div class="card-footer bg-white border-top d-flex justify-content-between align-items-center p-4" style="border-bottom-left-radius: 12px; border-bottom-right-radius: 12px;">
                <!-- Pagination -->
                <div class="d-flex gap-1">
                    <button v-for="p in totalPages" :key="p"
                            class="btn btn-sm d-flex align-items-center justify-content-center f-13 f-w-600"
                            :style="p === currentPage
                                ? 'background:#1a8a7d;color:#fff;border:none;width:30px;height:30px;border-radius:6px;'
                                : 'background:#f9fafb;color:#6b7280;border:1px solid #e5e7eb;width:30px;height:30px;border-radius:6px;'"
                            @click="currentPage = p">
                        {{ p }}
                    </button>
                </div>
                
                <!-- Add New -->
                <div class="d-flex gap-2">
                    <input type="text" class="form-control f-13 shadow-none" 
                           :placeholder="'Nouveau ' + activeTable.label.toLowerCase() + '...'" 
                           v-model="newItem"
                           @keyup.enter="addItem"
                           style="border:1px solid #e5e7eb; border-radius:20px; padding: 6px 16px; min-width:250px;">
                    <button class="btn f-w-600 text-white d-flex align-items-center gap-1 shadow-none" 
                            style="background:#1a8a7d; border-radius:20px; font-size:13px; padding: 8px 18px;"
                            @click="addItem">
                        <i class="bi bi-plus" style="font-size:18px;"></i> Ajouter
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.hide-scrollbar::-webkit-scrollbar {
    display: none;
}
.hide-scrollbar {
    -ms-overflow-style: none;
    scrollbar-width: none;
}
.transition-all {
    transition: all 0.2s ease-in-out;
}
tbody tr:hover { background: #fafafa; }
</style>
