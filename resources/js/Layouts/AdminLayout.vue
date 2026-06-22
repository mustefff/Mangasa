<script setup>
import { ref, onMounted, onUnmounted, nextTick } from 'vue';
import Sidebar from '@/Components/Admin/Sidebar.vue';
import Header from '@/Components/Admin/Header.vue';

const sidebarOpen = ref(true);

const toggleSidebar = () => {
    sidebarOpen.value = !sidebarOpen.value;
};

const reinitRiho = () => {
    nextTick(() => {
        if (typeof feather !== 'undefined') {
            feather.replace();
        }
    });
};

onMounted(() => {
    reinitRiho();
});
</script>

<template>
    <div class="page-wrapper compact-wrapper" id="pageWrapper" :class="{ 'close_icon': !sidebarOpen }">
        <!-- Page Header -->
        <Header @toggle-sidebar="toggleSidebar" />

        <!-- Page Body -->
        <div class="page-body-wrapper horizontal-menu">
            <!-- Sidebar -->
            <Sidebar :is-open="sidebarOpen" @toggle-sidebar="toggleSidebar" />

            <!-- Main Content -->
            <div class="page-body">
                <slot />
            </div>

            <!-- Footer -->
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12 footer-copyright text-center">
                            <p class="mb-0">Copyright 2026 © Mangasa - EMASE</p>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
</template>

<style>
/* Remove excess gap between sidebar and main content */
.page-wrapper.compact-wrapper .page-body-wrapper div.sidebar-wrapper {
    width: 250px !important;
}
.page-wrapper.compact-wrapper .page-body-wrapper .page-body {
    margin-left: 250px !important;
}
.page-wrapper.compact-wrapper .page-header {
    margin-left: 250px !important;
    width: calc(100% - 250px) !important;
}
</style>
