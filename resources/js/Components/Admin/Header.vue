<script setup>
import { Link } from '@inertiajs/vue3';

defineEmits(['toggle-sidebar']);
</script>

<template>
    <div class="page-header" style="background-color: #ffffff !important; border-bottom: 1px solid #eaecf0;">
        <div class="header-wrapper row m-0" style="background-color: #ffffff !important;">
            <form class="form-inline search-full col" action="#" method="get">
                <div class="form-group w-100">
                    <div class="Typeahead Typeahead--twitterUsers">
                        <div class="u-posRelative">
                            <input class="demo-input Typeahead-input form-control-plaintext w-100"
                                   type="text"
                                   placeholder="Rechercher..."
                                   name="q"
                                   title=""
                                   autofocus="autofocus"/>
                            <i class="close-search" data-feather="x"></i>
                        </div>
                    </div>
                </div>
            </form>

            <div class="header-logo-wrapper col-auto p-0">
                <div class="logo-wrapper">
                    <Link :href="`${$page.props.asset_url.replace(/\/$/, '')}/admin/dashboard`">
                        <div class="d-flex align-items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                                <polyline points="9 22 9 12 15 12 15 22"/>
                            </svg>
                            <span style="font-weight: 700; font-size: 18px;">Mangasa</span>
                        </div>
                    </Link>
                </div>
                <div class="toggle-sidebar" @click="$emit('toggle-sidebar')">
                    <i class="status_toggle middle sidebar-toggle" data-feather="align-center"></i>
                </div>
            </div>

            <div class="left-header col-xxl-5 col-xl-6 col-lg-5 col-md-4 col-sm-3 p-0">
                <div class="d-flex align-items-center w-100 ps-3">
                    <div class="d-flex align-items-center" style="border: 1px solid #eaecf0; border-radius: 8px; padding: 6px 14px; background: #fff; width: 300px;">
                        <i class="bi bi-search" style="color: #9ca3af; font-size: 14px; margin-right: 8px; flex-shrink: 0;"></i>
                        <input class="border-0 shadow-none bg-transparent p-0 f-13 flex-grow-1" type="search" placeholder="Rechercher..." style="outline: none; width: 100%; min-width: 0;"/>
                    </div>
                </div>
            </div>

            <div class="nav-right col-xxl-7 col-xl-6 col-md-7 col-8 pull-right right-header p-0 ms-auto">
                <ul class="nav-menus">



                    <!-- Notifications -->
                    <li class="onhover-dropdown notification-down p-0 me-3">
                        <div class="notification-box position-relative d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; cursor: pointer;">
                            <i class="bi bi-bell-fill" style="font-size: 18px; color: #6b7280;"></i>
                            <span class="position-absolute translate-middle badge rounded-circle" style="top: 8px; right: 0px; background: #ef4444; width: 16px; height: 16px; padding: 0; display: flex; align-items: center; justify-content: center; font-size: 10px; border: 2px solid #fff; color: white;">3</span>
                        </div>
                        <div class="onhover-show-div notification-dropdown">
                            <div class="card mb-0">
                                <div class="card-header">
                                    <div class="common-space">
                                        <h4 class="text-start f-w-600">Notifications</h4>
                                        <div><span>3 Nouvelles</span></div>
                                    </div>
                                </div>
                                <div class="card-body p-3">
                                    <ul class="list-unstyled">
                                        <li class="d-flex align-items-center gap-2 mb-3">
                                            <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 36px; height: 36px; background: #e8f5e9;">
                                                <i class="fa fa-cube" style="color: #2e7d32;"></i>
                                            </div>
                                            <div>
                                                <span class="f-w-500 f-13 d-block">Nouveau stockage ajouté</span>
                                                <span class="f-light f-12">Il y a 2 minutes</span>
                                            </div>
                                        </li>
                                        <li class="d-flex align-items-center gap-2 mb-3">
                                            <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 36px; height: 36px; background: #fff3e0;">
                                                <i class="fa fa-truck" style="color: #e65100;"></i>
                                            </div>
                                            <div>
                                                <span class="f-w-500 f-13 d-block">Enlèvement planifié</span>
                                                <span class="f-light f-12">Il y a 15 minutes</span>
                                            </div>
                                        </li>
                                        <li class="d-flex align-items-center gap-2">
                                            <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 36px; height: 36px; background: #e3f2fd;">
                                                <i class="fa fa-file-text" style="color: #1565c0;"></i>
                                            </div>
                                            <div>
                                                <span class="f-w-500 f-13 d-block">Nouvelle facture générée</span>
                                                <span class="f-light f-12">Il y a 1 heure</span>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </li>

                    <!-- User profile -->
                    <li class="profile-nav onhover-dropdown p-0">
                        <div class="media profile-media align-items-center">
                            <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 38px; height: 38px; background: #1a8a7d; color: white; font-size: 14px; font-weight: 600;">
                                AM
                            </div>
                            <div class="media-body d-xxl-block d-none box-col-none ms-2 text-start">
                                <div class="d-flex align-items-center gap-1">
                                    <span class="f-w-500" style="color: #111827; font-size: 13px;">Alex Mora</span>
                                    <i class="fa fa-angle-down" style="font-size: 11px; color: #6b7280; margin-top: 2px;"></i>
                                </div>
                                <p class="mb-0" style="font-size: 11px; color: #9ca3af; line-height: 1;">Administrateur</p>
                            </div>
                        </div>
                        <ul class="profile-dropdown onhover-show-div">
                            <li>
                                <a href="#">
                                    <i data-feather="user"></i>
                                    <span>Mon Profil</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i data-feather="settings"></i>
                                    <span>Paramètres</span>
                                </a>
                            </li>
                            <li>
                                <Link href="/logout" method="post" as="button" class="btn btn-pill btn-outline-primary btn-sm w-100">
                                    Déconnexion
                                </Link>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>
