<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { ref, computed } from 'vue';

defineOptions({ layout: AdminLayout });

const showCreateModal = ref(false);
const showEditModal = ref(false);
const showAccessModal = ref(false);
const selectedUser = ref(null);
const editingUser = ref(null);
const showDropdown = ref(null);
const searchQuery = ref('');
const filterStatut = ref('Tous');
const filterFonction = ref('Toutes');
const currentPage = ref(1);
const perPage = 8;

const modulesList = ref([
    { id: 1, nom: 'Dashboard & Statistiques' },
    { id: 2, nom: 'Transitaires' },
    { id: 3, nom: 'Stockage' },
    { id: 4, nom: 'Trafic' },
    { id: 5, nom: 'Bons' },
    { id: 6, nom: 'Documents' },
    { id: 7, nom: 'Comptabilité & Facturation' },
    { id: 8, nom: 'Paramètres Généraux' },
    { id: 9, nom: 'Gestion des Utilisateurs' },
]);

const newUser = ref({ nom: '', prenom: '', login: '', fonction: '', password: '' });

const colors = ['#e91e63', '#ff9800', '#4caf50', '#2196f3', '#9c27b0', '#00bcd4', '#795548', '#f44336', '#009688'];

const users = ref([
    { id: 106, nom: 'TRAORE',       prenom: 'Cheick',          login: 'ctraore',    fonction: 'Stockage - Traffic',    statut: 'Actif',    derniereConnexion: "Aujourd'hui",    color: '#e91e63' },
    { id: 105, nom: 'DEMBELE',      prenom: 'Drissa',          login: 'ddembele',   fonction: 'Caisse - Facturation',  statut: 'Actif',    derniereConnexion: 'Il y a 54 jours',  color: '#ff9800' },
    { id: 104, nom: 'BA',           prenom: 'Berthe Kadidja',  login: 'bba',        fonction: 'Gérant',                statut: 'Actif',    derniereConnexion: 'Il y a 17 jours',  color: '#4caf50' },
    { id: 103, nom: 'KONE',         prenom: 'Souleymane',      login: 'skone-ca',   fonction: 'Contrôle de sécurité',  statut: 'Actif',    derniereConnexion: 'Il y a 800 jours', color: '#2196f3' },
    { id: 102, nom: 'DOLO',         prenom: 'Mohamed',         login: 'mdolo',      fonction: 'Facturation',           statut: 'Actif',    derniereConnexion: "Aujourd'hui",    color: '#9c27b0' },
    { id: 101, nom: 'KONE',         prenom: 'Seif',            login: 'skone',      fonction: 'Gérant',                statut: 'Actif',    derniereConnexion: 'Il y a 16 jours',  color: '#00bcd4' },
    { id: 100, nom: 'NGATE',        prenom: 'Tarit',           login: 'tndiaye',    fonction: 'CRIC',                  statut: 'Inactif',  derniereConnexion: 'Il y a 1163 jours',color: '#009688' },
    { id: 99,  nom: 'DIABATE',      prenom: 'Djadiemy',        login: 'ddatabate',  fonction: 'Agent de Transit',      statut: 'Inactif',  derniereConnexion: 'Il y a 1179 jours',color: '#ff9800' },
    { id: 98,  nom: 'COULIBALY',    prenom: 'Aminata',         login: 'acoulibaly', fonction: 'Direction',             statut: 'Actif',    derniereConnexion: 'Il y a 3 jours',   color: '#e91e63' },
]);

const fonctions = ['Toutes', 'Stockage - Traffic', 'Caisse - Facturation', 'Gérant', 'Contrôle de sécurité', 'Facturation', 'CRIC', 'Agent de Transit', 'Direction'];

const filteredUsers = computed(() => {
    return users.value.filter(user => {
        const q = searchQuery.value.toLowerCase();
        const matchSearch = q === '' || user.nom.toLowerCase().includes(q) || user.prenom.toLowerCase().includes(q) || user.login.toLowerCase().includes(q);
        const matchStatut = filterStatut.value === 'Tous' || user.statut === filterStatut.value;
        const matchFonction = filterFonction.value === 'Toutes' || user.fonction === filterFonction.value;
        return matchSearch && matchStatut && matchFonction;
    });
});

const totalPages = computed(() => Math.ceil(filteredUsers.value.length / perPage));
const pagedUsers = computed(() => filteredUsers.value.slice((currentPage.value - 1) * perPage, currentPage.value * perPage));

const totalUsers    = computed(() => users.value.length);
const activeUsers   = computed(() => users.value.filter(u => u.statut === 'Actif').length);
const inactiveUsers = computed(() => users.value.filter(u => u.statut === 'Inactif').length);

const getInitials = (user) => (user.prenom[0] + user.nom[0]).toUpperCase();

const toggleDropdown = (id) => {
    showDropdown.value = showDropdown.value === id ? null : id;
};

/* ---- CREATE ---- */
const openCreateModal = () => {
    newUser.value = { nom: '', prenom: '', login: '', fonction: '', password: '' };
    showCreateModal.value = true;
};
const closeCreateModal = () => { showCreateModal.value = false; };
const addUser = () => {
    if (newUser.value.nom && newUser.value.prenom && newUser.value.login) {
        users.value.unshift({
            id: Math.max(...users.value.map(u => u.id)) + 1,
            nom: newUser.value.nom.toUpperCase(),
            prenom: newUser.value.prenom,
            login: newUser.value.login,
            fonction: newUser.value.fonction || 'Non définie',
            statut: 'Actif',
            derniereConnexion: "Aujourd'hui",
            color: colors[Math.floor(Math.random() * colors.length)],
        });
        closeCreateModal();
    }
};

/* ---- EDIT ---- */
const openEditModal = (user) => {
    editingUser.value = { ...user };
    showDropdown.value = null;
    showEditModal.value = true;
};
const closeEditModal = () => { showEditModal.value = false; editingUser.value = null; };
const saveEdit = () => {
    if (editingUser.value) {
        const idx = users.value.findIndex(u => u.id === editingUser.value.id);
        if (idx !== -1) users.value[idx] = { ...editingUser.value };
    }
    closeEditModal();
};

const openAccessModal = (user) => {
    selectedUser.value = { ...user };
    showAccessModal.value = true;
};

const closeAccessModal = () => {
    showAccessModal.value = false;
    selectedUser.value = null;
};
</script>

<template>
    <div class="container-fluid">

        <!-- Page Header -->
        <div class="page-title">
            <div class="row align-items-center">
                <div class="col-6">
                    <div class="d-flex align-items-center gap-3">
                        <div class="d-flex align-items-center justify-content-center rounded-2" style="width:48px;height:48px;background:#e6f4f2;">
                            <i class="bi bi-people-fill" style="font-size:22px;color:#1a8a7d;"></i>
                        </div>
                        <div>
                            <h4 class="mb-0 f-w-700" style="color:#111827;">Utilisateurs</h4>
                            <p class="mb-0 f-13" style="color:#6b7280;">Gestion des comptes et permissions</p>
                        </div>
                    </div>
                </div>
                <div class="col-6 text-end">
                    <button class="btn btn-sm px-4 py-2 f-w-600" style="background:#1a8a7d;color:#fff;border:none;border-radius:8px;font-size:14px;" @click="openCreateModal">
                        <i class="bi bi-plus me-1"></i> Nouvel Utilisateur
                    </button>
                </div>
            </div>
        </div>

        <div class="container-fluid">

            <!-- Stats Cards -->
            <div class="row mb-3">
                <!-- Total -->
                <div class="col-xl-4 col-sm-6 mb-3">
                    <div class="card border-0 shadow-sm" style="border-radius:12px;">
                        <div class="card-body py-3 px-4">
                            <div class="d-flex align-items-center gap-3">
                                <div class="d-flex align-items-center justify-content-center rounded-circle" style="width:42px;height:42px;background:#e6f4f2;flex-shrink:0;">
                                    <i class="bi bi-people" style="font-size:18px;color:#1a8a7d;"></i>
                                </div>
                                <div>
                                    <h3 class="mb-0 f-w-700" style="color:#111827;font-size:22px;">{{ totalUsers }}</h3>
                                    <span class="f-13" style="color:#6b7280;">Total</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Actifs -->
                <div class="col-xl-4 col-sm-6 mb-3">
                    <div class="card border-0 shadow-sm" style="border-radius:12px;">
                        <div class="card-body py-3 px-4">
                            <div class="d-flex align-items-center gap-3">
                                <div class="d-flex align-items-center justify-content-center rounded-circle" style="width:42px;height:42px;background:#e8f5e9;flex-shrink:0;">
                                    <i class="bi bi-check-circle" style="font-size:18px;color:#22c55e;"></i>
                                </div>
                                <div>
                                    <h3 class="mb-0 f-w-700" style="color:#111827;font-size:22px;">{{ activeUsers }}</h3>
                                    <span class="f-13" style="color:#6b7280;">Actifs</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Inactifs -->
                <div class="col-xl-4 col-sm-6 mb-3">
                    <div class="card border-0 shadow-sm" style="border-radius:12px;">
                        <div class="card-body py-3 px-4">
                            <div class="d-flex align-items-center gap-3">
                                <div class="d-flex align-items-center justify-content-center rounded-circle" style="width:42px;height:42px;background:#fff3e0;flex-shrink:0;">
                                    <i class="bi bi-clock-history" style="font-size:18px;color:#f59e0b;"></i>
                                </div>
                                <div>
                                    <h3 class="mb-0 f-w-700" style="color:#111827;font-size:22px;">{{ inactiveUsers }}</h3>
                                    <span class="f-13" style="color:#6b7280;">Inactifs</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Users Table Card -->
            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-sm" style="border-radius:12px;">
                        <div class="card-body p-0">

                            <!-- Search & Filters -->
                            <div class="d-flex justify-content-between align-items-center px-4 pt-4 pb-3" style="border-bottom:1px solid #f3f4f6; gap: 16px;">
                                <div class="d-flex align-items-center gap-2 flex-grow-1" style="border:1px solid #e5e7eb;border-radius:8px;padding:6px 14px;background:#fff;">
                                    <i class="bi bi-search" style="color:#9ca3af;font-size:13px;flex-shrink:0;"></i>
                                    <input type="text" class="border-0 p-0 f-13 bg-transparent w-100" placeholder="Rechercher nom, prénom, login..." v-model="searchQuery" style="outline:none;" />
                                </div>
                                <div class="d-flex align-items-center gap-2 flex-shrink-0">
                                    <select class="form-select form-select-sm" style="border:1px solid #e5e7eb;border-radius:8px;font-size:13px;color:#374151;min-width:90px;" v-model="filterStatut">
                                        <option value="Tous">Tous</option>
                                        <option value="Actif">Actif</option>
                                        <option value="Inactif">Inactif</option>
                                    </select>
                                    <select class="form-select form-select-sm" style="border:1px solid #e5e7eb;border-radius:8px;font-size:13px;color:#374151;min-width:100px;" v-model="filterFonction">
                                        <option v-for="f in fonctions" :key="f" :value="f">{{ f }}</option>
                                    </select>
                                    <span class="f-12" style="color:#9ca3af;white-space:nowrap;">{{ filteredUsers.length }} résultats</span>
                                </div>
                            </div>

                            <!-- Table -->
                            <div class="table-responsive">
                                <table class="table mb-0" style="border-collapse:separate;">
                                    <thead>
                                        <tr style="background:#fafafa;">
                                            <th class="text-uppercase f-w-600 py-3 px-4" style="color:#9ca3af;font-size:11px;letter-spacing:0.5px;border-bottom:1px solid #f3f4f6;white-space:nowrap;">Utilisateur</th>
                                            <th class="text-uppercase f-w-600 py-3 px-3" style="color:#9ca3af;font-size:11px;letter-spacing:0.5px;border-bottom:1px solid #f3f4f6;">Login</th>
                                            <th class="text-uppercase f-w-600 py-3 px-3" style="color:#9ca3af;font-size:11px;letter-spacing:0.5px;border-bottom:1px solid #f3f4f6;">Fonction</th>
                                            <th class="text-uppercase f-w-600 py-3 px-3" style="color:#9ca3af;font-size:11px;letter-spacing:0.5px;border-bottom:1px solid #f3f4f6;">Statut</th>
                                            <th class="text-uppercase f-w-600 py-3 px-3" style="color:#9ca3af;font-size:11px;letter-spacing:0.5px;border-bottom:1px solid #f3f4f6;white-space:nowrap;">Dernière connexion</th>
                                            <th class="text-uppercase f-w-600 py-3 px-3" style="color:#9ca3af;font-size:11px;letter-spacing:0.5px;border-bottom:1px solid #f3f4f6;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="user in pagedUsers" :key="user.id" class="align-middle" style="border-bottom:1px solid #f9fafb;" @click="showDropdown = null">
                                            <!-- User -->
                                            <td class="py-3 px-4">
                                                <div class="d-flex align-items-center gap-3">
                                                    <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 text-white f-w-600" :style="{ width:'38px', height:'38px', background: user.color, fontSize:'13px' }">
                                                        {{ getInitials(user) }}
                                                    </div>
                                                    <div>
                                                        <div class="f-w-600 f-14" style="color:#111827;">{{ user.prenom }} {{ user.nom }}</div>
                                                        <div class="f-12" style="color:#9ca3af;">ID #{{ user.id }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <!-- Login -->
                                            <td class="py-3 px-3 f-13" style="color:#4b5563;">{{ user.login }}</td>
                                            <!-- Fonction -->
                                            <td class="py-3 px-3">
                                                <span class="f-13 f-w-500" style="color:#1a8a7d;">{{ user.fonction }}</span>
                                            </td>
                                            <!-- Statut -->
                                            <td class="py-3 px-3">
                                                <span v-if="user.statut === 'Actif'"
                                                      class="d-inline-flex align-items-center gap-1 px-2 py-1 f-12 f-w-500"
                                                      style="background:#dcfce7;color:#166534;border-radius:999px;">
                                                    <span class="rounded-circle" style="width:6px;height:6px;background:#22c55e;display:inline-block;"></span>
                                                    Actif
                                                </span>
                                                <span v-else
                                                      class="d-inline-flex align-items-center gap-1 px-2 py-1 f-12 f-w-500"
                                                      style="background:#f3f4f6;color:#6b7280;border-radius:999px;">
                                                    <span class="rounded-circle" style="width:6px;height:6px;background:#9ca3af;display:inline-block;"></span>
                                                    Inactif
                                                </span>
                                            </td>
                                            <!-- Dernière connexion -->
                                            <td class="py-3 px-3 f-13" style="color:#6b7280;">{{ user.derniereConnexion }}</td>
                                            <!-- Actions -->
                                            <td class="py-3 px-3">
                                                <div class="position-relative">
                                                    <button class="btn p-1 border-0 bg-transparent" @click.stop="toggleDropdown(user.id)" style="color:#9ca3af;font-size:18px;line-height:1;">
                                                        <i class="bi bi-three-dots-vertical"></i>
                                                    </button>
                                                    <div v-if="showDropdown === user.id"
                                                         class="position-absolute bg-white shadow-sm rounded-2 py-1"
                                                         style="right:0;top:calc(100% + 4px);z-index:100;min-width:200px;border:1px solid #f3f4f6;">
                                                        <a href="#" class="d-flex align-items-center gap-2 px-3 py-2 text-decoration-none f-13" style="color:#374151;" @click.prevent="openEditModal(user)">
                                                            <i class="bi bi-pencil-square" style="color:#1a8a7d;"></i> Modifier
                                                        </a>
                                                        <a href="#" class="d-flex align-items-center gap-2 px-3 py-2 text-decoration-none f-13" style="color:#374151;" @click.prevent="openAccessModal(user)">
                                                            <i class="bi bi-shield-lock" style="color:#1a8a7d;"></i> Gérer les accès
                                                        </a>
                                                        <a href="#" class="d-flex align-items-center gap-2 px-3 py-2 text-decoration-none f-13" style="color:#374151;" @click.prevent="showDropdown=null">
                                                            <i class="bi bi-key" style="color:#f59e0b;"></i> Réinitialiser mot de passe
                                                        </a>
                                                        <a href="#" class="d-flex align-items-center gap-2 px-3 py-2 text-decoration-none f-13" style="color:#ef4444;" @click.prevent="showDropdown=null">
                                                            <i class="bi bi-power"></i> Désactiver
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div class="d-flex justify-content-between align-items-center px-4 py-3" style="border-top:1px solid #f3f4f6;">
                                <span class="f-12" style="color:#9ca3af;">
                                    {{ (currentPage - 1) * perPage + 1 }}-{{ Math.min(currentPage * perPage, filteredUsers.length) }} sur {{ filteredUsers.length }}
                                </span>
                                <div class="d-flex gap-1">
                                    <button v-for="p in totalPages" :key="p"
                                            class="btn btn-sm d-flex align-items-center justify-content-center f-13 f-w-600"
                                            :style="p === currentPage
                                                ? 'background:#1a8a7d;color:#fff;border:none;width:30px;height:30px;border-radius:6px;'
                                                : 'background:transparent;color:#6b7280;border:1px solid #e5e7eb;width:30px;height:30px;border-radius:6px;'"
                                            @click="currentPage = p">
                                        {{ p }}
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== MODAL : NOUVEL UTILISATEUR ===== -->
    <div v-if="showCreateModal" class="modal-overlay d-flex align-items-center justify-content-center" @click.self="closeCreateModal">
        <div class="modal-box">
            <div class="d-flex justify-content-between align-items-start mb-4">
                <div>
                    <h5 class="f-w-700 mb-1" style="color:#111827;font-size:18px;">Nouvel utilisateur</h5>
                    <p class="mb-0 f-13" style="color:#6b7280;">Créer un nouveau compte utilisateur</p>
                </div>
                <button class="btn p-0 border-0 bg-transparent" @click="closeCreateModal" style="color:#9ca3af;font-size:18px;">
                    <i class="bi bi-x-circle"></i>
                </button>
            </div>
            <div class="row mb-3">
                <div class="col-6">
                    <label class="modal-label">NOM <span style="color:#ef4444;">*</span></label>
                    <input type="text" class="modal-input" placeholder="TRAORE" v-model="newUser.nom" />
                </div>
                <div class="col-6">
                    <label class="modal-label">PRÉNOM <span style="color:#ef4444;">*</span></label>
                    <input type="text" class="modal-input" placeholder="Cheick" v-model="newUser.prenom" />
                </div>
            </div>
            <div class="mb-3">
                <label class="modal-label">LOGIN <span style="color:#ef4444;">*</span></label>
                <input type="text" class="modal-input" placeholder="ctraore" v-model="newUser.login" />
            </div>
            <div class="mb-4">
                <label class="modal-label">FONCTION <span style="color:#ef4444;">*</span></label>
                <select class="modal-input" v-model="newUser.fonction">
                    <option value="" disabled>Sélectionner une fonction</option>
                    <option v-for="f in fonctions.filter(f => f !== 'Toutes')" :key="f" :value="f">{{ f }}</option>
                </select>
            </div>
            <div class="d-flex justify-content-end gap-3">
                <button class="btn-modal-cancel" @click="closeCreateModal">Effacer</button>
                <button class="btn-modal-save" @click="addUser">Enregistrer</button>
            </div>
        </div>
    </div>

    <!-- ===== MODAL : MODIFIER UTILISATEUR ===== -->
    <div v-if="showEditModal && editingUser" class="modal-overlay d-flex align-items-center justify-content-center" @click.self="closeEditModal">
        <div class="modal-box">
            <div class="d-flex justify-content-between align-items-start mb-4">
                <div>
                    <h5 class="f-w-700 mb-1" style="color:#111827;font-size:18px;">Modifier l'utilisateur</h5>
                    <p class="mb-0 f-13" style="color:#6b7280;">Modifier les informations de {{ editingUser.prenom }} {{ editingUser.nom }}</p>
                </div>
                <button class="btn p-0 border-0 bg-transparent" @click="closeEditModal" style="color:#9ca3af;font-size:18px;">
                    <i class="bi bi-x-circle"></i>
                </button>
            </div>
            <div class="row mb-3">
                <div class="col-6">
                    <label class="modal-label">NOM <span style="color:#ef4444;">*</span></label>
                    <input type="text" class="modal-input" v-model="editingUser.nom" />
                </div>
                <div class="col-6">
                    <label class="modal-label">PRÉNOM <span style="color:#ef4444;">*</span></label>
                    <input type="text" class="modal-input" v-model="editingUser.prenom" />
                </div>
            </div>
            <div class="mb-3">
                <label class="modal-label">LOGIN <span style="color:#ef4444;">*</span></label>
                <input type="text" class="modal-input" v-model="editingUser.login" />
            </div>
            <div class="mb-4">
                <label class="modal-label">FONCTION <span style="color:#ef4444;">*</span></label>
                <select class="modal-input" v-model="editingUser.fonction">
                    <option v-for="f in fonctions.filter(f => f !== 'Toutes')" :key="f" :value="f">{{ f }}</option>
                </select>
            </div>
            <div class="d-flex justify-content-end gap-3">
                <button class="btn-modal-cancel" @click="closeEditModal">Effacer</button>
                <button class="btn-modal-save" @click="saveEdit">Enregistrer</button>
            </div>
        </div>
    </div>

    <!-- Modale Gérer les Accès -->
    <div class="modal-overlay" v-if="showAccessModal">
        <div class="modal-box" style="padding: 0; background: transparent; box-shadow: none;">
            <div class="modal-content" style="max-width: 750px; border-radius: 12px; padding: 24px;">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h5 class="f-w-700 mb-1" style="color:#111827;font-size:18px;">Gestion des accès</h5>
                        <p class="mb-0 f-13" style="color:#6b7280;">Définir les permissions pour <strong>{{ selectedUser?.prenom }} {{ selectedUser?.nom }}</strong></p>
                    </div>
                    <button class="btn p-0 border-0 bg-transparent" @click="closeAccessModal" style="color:#9ca3af;font-size:18px;">
                        <i class="bi bi-x-circle"></i>
                    </button>
                </div>

                <div class="row">
                    <!-- Cloner depuis un autre utilisateur -->
                    <div class="col-md-12 mb-4">
                        <div class="p-3" style="background: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 8px;">
                            <label class="modal-label mb-2 d-block" style="color: #475569; font-weight: 600;"><i class="bi bi-copy me-2"></i>Copier les accès d'un utilisateur existant</label>
                            <div class="d-flex gap-2">
                                <select class="modal-input flex-grow-1" style="background: white;">
                                    <option value="">-- Sélectionner un utilisateur --</option>
                                    <option v-for="u in users.filter(u => u.id !== selectedUser?.id)" :key="u.id" :value="u.id">
                                        {{ u.prenom }} {{ u.nom }} ({{ u.fonction }})
                                    </option>
                                </select>
                                <button class="btn" style="background: #1a8a7d; color: white; padding: 8px 16px;">Appliquer</button>
                            </div>
                        </div>
                    </div>

                    <!-- Permissions Spécifiques -->
                    <div class="col-md-12">
                        <h6 class="mb-3 f-w-600" style="color: #334155;">Accès spécifiques par module</h6>
                        <div class="table-responsive" style="border: 1px solid #eaecf0; border-radius: 8px;">
                            <table class="table mb-0 table-hover">
                                <thead style="background: #f9fafb; border-bottom: 1px solid #eaecf0;">
                                    <tr>
                                        <th style="font-size: 12px; color: #6b7280; font-weight: 600; padding: 12px 16px;">MODULE</th>
                                        <th class="text-center" style="font-size: 12px; color: #6b7280; font-weight: 600; padding: 12px;">LECTURE</th>
                                        <th class="text-center" style="font-size: 12px; color: #6b7280; font-weight: 600; padding: 12px;">ÉCRITURE</th>
                                        <th class="text-center" style="font-size: 12px; color: #6b7280; font-weight: 600; padding: 12px;">SUPPRESSION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="module in modulesList" :key="module.id">
                                        <td class="f-w-500" style="color: #111827; padding: 12px 16px;">{{ module.nom }}</td>
                                        <td class="text-center" style="padding: 12px;">
                                            <input class="form-check-input" type="checkbox" checked style="cursor: pointer; width: 18px; height: 18px;">
                                        </td>
                                        <td class="text-center" style="padding: 12px;">
                                            <input class="form-check-input" type="checkbox" style="cursor: pointer; width: 18px; height: 18px;">
                                        </td>
                                        <td class="text-center" style="padding: 12px;">
                                            <input class="form-check-input" type="checkbox" style="cursor: pointer; width: 18px; height: 18px;">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4 pt-3" style="border-top:1px solid #eaecf0;">
                    <button class="btn" style="background:#f3f4f6;color:#4b5563;font-weight:500;padding: 8px 16px;" @click="closeAccessModal">Annuler</button>
                    <button class="btn" style="background:#1a8a7d;color:white;font-weight:500;padding: 8px 16px;">Enregistrer les accès</button>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
/* ---- Overlay & Modal ---- */
.modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.35);
    z-index: 1050;
    backdrop-filter: blur(2px);
    display: flex;
    align-items: center;
    justify-content: center;
}
.modal-box {
    background: #fff;
    border-radius: 16px;
    padding: 32px;
    width: 100%;
    max-width: 520px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.15);
}

.modal-content {
    background: #ffffff;
    border-radius: 12px;
    padding: 24px;
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    width: 100%;
    margin: 0 16px;
    max-height: 90vh;
    overflow-y: auto;
}

/* ---- Form elements inside modal ---- */
.modal-label {
    display: block;
    font-size: 11px;
    font-weight: 600;
    letter-spacing: 0.5px;
    color: #374151;
    margin-bottom: 6px;
}
.modal-input {
    display: block;
    width: 100%;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    padding: 10px 14px;
    font-size: 14px;
    color: #111827;
    background: #fff;
    outline: none;
    transition: border-color 0.15s;
    appearance: auto;
}
.modal-input:focus {
    border-color: #1a8a7d;
    box-shadow: 0 0 0 3px rgba(26,138,125,0.1);
}

/* ---- Modal Buttons ---- */
.btn-modal-cancel {
    background: transparent;
    border: none;
    font-size: 14px;
    font-weight: 500;
    color: #6b7280;
    padding: 10px 20px;
    border-radius: 8px;
    cursor: pointer;
    transition: background 0.15s;
}
.btn-modal-cancel:hover { background: #f3f4f6; }

.btn-modal-save {
    background: #1a8a7d;
    border: none;
    font-size: 14px;
    font-weight: 600;
    color: #fff;
    padding: 10px 24px;
    border-radius: 8px;
    cursor: pointer;
    transition: background 0.15s;
}
.btn-modal-save:hover { background: #147a6d; }

/* ---- Table hover ---- */
tbody tr:hover { background: #fafafa; }
</style>
