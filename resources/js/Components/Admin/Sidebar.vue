<script setup>
import { ref, computed } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';

const props = defineProps({
    isOpen: {
        type: Boolean,
        default: true
    }
});

defineEmits(['toggle-sidebar']);

const page = usePage();
const currentUrl = computed(() => page.url);

const getRoute = (path) => {
    if (path === '#') return '#';
    const baseUrl = page.props.asset_url.replace(/\/$/, '');
    return baseUrl + path;
};

const openMenus = ref([]);
const pinnedMenus = ref([]);

const togglePin = (label, event) => {
    event.preventDefault();
    event.stopPropagation();
    const index = pinnedMenus.value.indexOf(label);
    if (index > -1) {
        pinnedMenus.value.splice(index, 1);
    } else {
        pinnedMenus.value.push(label);
    }
};

const isPinned = (label) => pinnedMenus.value.includes(label);

const menuItems = [
    { type: 'category', label: 'GÉNÉRAL' },
    {
        label: 'Dashboard',
        icon: 'bi bi-grid-fill',
        route: '/admin/dashboard',
    },
    {
        label: 'Statistiques',
        icon: 'bi bi-bar-chart-fill',
        route: '/admin/statistiques',
    },
    { type: 'category', label: 'OPÉRATIONS' },
    {
        label: 'Transitaires',
        icon: 'bi bi-people-fill',
        route: '/admin/transitaires',
    },
    {
        label: 'Stockage',
        icon: 'bi bi-box-seam',
        route: '/admin/stockage',
    },
    {
        label: 'Traffic',
        icon: 'bi bi-truck',
        route: '#',
        children: [
            { label: 'Liste des trafics', route: '/admin/trafic' },
            { label: 'Nouveau trafic', route: '/admin/trafic/create' },
        ]
    },
    {
        label: 'Bon',
        icon: 'bi bi-file-text',
        route: '/admin/bons',
    },
    { type: 'category', label: 'FINANCES & DOCS' },
    {
        label: 'Documents',
        icon: 'bi bi-file-earmark',
        route: '/admin/documents',
    },
    {
        label: 'Comptabilité',
        icon: 'bi bi-wallet2',
        route: '#',
        children: [
            { label: 'Facturation', route: '/admin/comptabilite/facturation' },
            { label: 'Caisse', route: '/admin/comptabilite/caisse' },
            { label: 'État de caisse', route: '/admin/comptabilite/etat-caisse' },
        ]
    },
    { type: 'category', label: 'ADMINISTRATION' },
    {
        label: 'Paramètres',
        icon: 'bi bi-gear-fill',
        route: '/admin/parametres',
    },
    {
        label: 'Utilisateurs',
        icon: 'bi bi-person-fill',
        route: '/admin/utilisateurs',
    },
    {
        label: 'Régularisation',
        icon: 'bi bi-shield-check',
        route: '/admin/regularisation',
    },
];

const isActive = (item) => {
    if (item.route && item.route !== '#') {
        return currentUrl.value.startsWith(item.route);
    }
    if (item.children) {
        return item.children.some(child => currentUrl.value.startsWith(child.route));
    }
    return false;
};

const isMenuOpen = (label) => {
    return openMenus.value.includes(label);
};

const toggleMenu = (label) => {
    const index = openMenus.value.indexOf(label);
    if (index > -1) {
        openMenus.value.splice(index, 1);
    } else {
        openMenus.value.push(label);
    }
};

const reinitRiho = () => {
    // Reinitialize feather icons if needed
    if (typeof feather !== 'undefined') {
        feather.replace();
    }
    // Initialize simplebar manually
    if (typeof SimpleBar !== 'undefined') {
        const simpleBarEl = document.getElementById('simple-bar');
        if (simpleBarEl && !simpleBarEl.classList.contains('simplebar-initialized')) {
            new SimpleBar(simpleBarEl);
            simpleBarEl.classList.add('simplebar-initialized');
        }
    }
};

import { onMounted } from 'vue';
onMounted(() => {
    reinitRiho();
});

// Auto-open parent menu if a child is active
menuItems.forEach(item => {
    if (item.children && item.children.some(child => currentUrl.value?.startsWith(child.route))) {
        openMenus.value.push(item.label);
    }
});
</script>

<template>
    <div class="sidebar-wrapper" data-layout="stroke-svg">
        <div>
            <div class="logo-wrapper">
                <Link :href="getRoute('/admin/dashboard')">
                    <div class="d-flex align-items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                            <polyline points="9 22 9 12 15 12 15 22"/>
                        </svg>
                        <span class="text-white" style="font-size: 20px; font-weight: 700; letter-spacing: 1px;">Mangasa</span>
                    </div>
                </Link>
                <div class="back-btn"><i class="fa fa-angle-left"></i></div>
                <div class="toggle-sidebar" @click="$emit('toggle-sidebar')">
                    <i class="status_toggle middle sidebar-toggle" data-feather="grid"></i>
                </div>
            </div>
            <!-- Removed logo-icon-wrapper to prevent extra spacing -->
            <nav class="sidebar-main">
                <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
                <div id="sidebar-menu">
                    <div class="simplebar-wrapper">
                        <div class="simplebar-mask">
                            <div class="simplebar-content-wrapper">
                                <div class="simplebar-content">
                                    <ul class="sidebar-links" id="simple-bar">
                        <li class="back-btn">
                            <div class="mobile-back text-end">
                                <span>Back</span>
                                <i class="fa fa-angle-right ps-2" aria-hidden="true"></i>
                            </div>
                        </li>
                        <li class="pin-title sidebar-main-title" :style="pinnedMenus.length > 0 ? 'display: block !important; padding-top: 10px !important; margin-top: 0 !important; order: -2 !important;' : 'display: none !important;'">
                            <div><h6 style="color: #94a3b8 !important; font-weight: 600 !important; font-size: 13px !important; text-transform: uppercase !important;">PINNED</h6></div>
                        </li>

                        <template v-for="(item, index) in menuItems" :key="item.label">
                            <li v-if="item.type === 'category'" class="sidebar-main-title" :style="(index === 0 && pinnedMenus.length === 0) ? 'margin-top: 0 !important; padding-top: 10px !important; order: 0;' : 'order: 0;'">
                                <div><h6 style="color: #94a3b8 !important; font-weight: 600 !important; font-size: 13px !important; text-transform: uppercase !important;">{{ item.label }}</h6></div>
                            </li>
                            <li v-else class="sidebar-list"
                                :class="{ active: isActive(item), 'pined': isPinned(item.label) }"
                                :style="isPinned(item.label) ? 'order: -1 !important;' : 'order: 0;'">
                                <i class="fa fa-thumb-tack" @click="togglePin(item.label, $event)"></i>

                                <!-- Simple link (no children) -->
                                <Link v-if="!item.children"
                                      class="sidebar-link sidebar-title"
                                      :class="{ active: isActive(item) }"
                                      :href="getRoute(item.route)">
                                    <i :class="item.icon" class="fs-5 me-2" style="width: 24px;"></i>
                                    <span>{{ item.label }}</span>
                                </Link>

                                <!-- Parent with children -->
                                <a v-else
                                   class="sidebar-link sidebar-title"
                                   :class="{ active: isActive(item) }"
                                   href="javascript:void(0)"
                                   @click="toggleMenu(item.label)">
                                    <i :class="item.icon" class="fs-5 me-2" style="width: 24px;"></i>
                                    <span>{{ item.label }}</span>
                                    <div class="according-menu">
                                        <i class="fa" :class="isMenuOpen(item.label) || isActive(item) ? 'fa-angle-down' : 'fa-angle-right'"></i>
                                    </div>
                                </a>
                                <ul v-if="item.children"
                                    class="sidebar-submenu"
                                    :style="{ display: (isMenuOpen(item.label) || isActive(item)) ? 'block' : 'none' }">
                                    <li v-for="child in item.children" :key="child.label">
                                        <Link :href="getRoute(child.route)"
                                              :class="{ active: currentUrl?.startsWith(child.route) }">
                                            {{ child.label }}
                                        </Link>
                                    </li>
                                </ul>
                            </li>
                        </template>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
            </nav>

            <!-- Removed overlapping user profile -->
        </div>
    </div>
</template>

<style>
.sidebar-wrapper {
    width: 250px !important;
    border-radius: 0 !important;
}
.sidebar-links {
    margin-top: 0 !important;
    padding-top: 0 !important;
    display: flex;
    flex-direction: column;
}
.sidebar-main {
    margin-top: 0 !important;
}
.logo-wrapper {
    margin-bottom: 0 !important;
    padding-bottom: 10px !important;
}
.simplebar-content {
    padding-top: 0 !important;
}
.sidebar-main-title {
    margin-bottom: 0 !important;
}
.sidebar-main-title div h6 {
    opacity: 1 !important;
    visibility: visible !important;
    display: block !important;
}
/* Ensure the text is properly aligned with new icons */
.sidebar-link span {
    margin-left: 8px;
}
/* Ensure the pin icon works and cursor is pointer */
.fa-thumb-tack {
    cursor: pointer;
}
</style>
