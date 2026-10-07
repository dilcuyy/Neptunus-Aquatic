<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title><?= $title ?? 'Neptunus Aquatic' ?> - Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="description" content="Sistem Informasi dan Manajemen Neptunus Aquatic">
    <meta name="msapplication-tap-highlight" content="no">
    <!-- ArchitectUI Main Stylesheet -->
    <link href="<?= base_url('assets/styles/main.css') ?>" rel="stylesheet">
    <!-- Application Modals Stylesheet -->
    <link href="<?= base_url('assets/styles/modals.css') ?>" rel="stylesheet">
    <style>
        /* Fix Bootstrap Modal Stacking Context over ArchitectUI fixed layout */
        .modal-backdrop {
            z-index: 1040;
        }
        .modal {
            z-index: 1050;
        }
        body.modal-open {
            overflow: hidden !important;
        }
        body.modal-open .app-container,
        body.modal-open .app-main,
        body.modal-open .app-main__outer,
        body.modal-open .app-main__inner {
            overflow: hidden !important;
        }

        /* Remove blue focus outlines, glow rings, and border highlights globally */
        *:focus,
        *:focus-visible,
        *:focus-within,
        .form-control:focus,
        .form-select:focus,
        .input-group .form-control:focus,
        .input-group .form-select:focus,
        input:focus,
        select:focus,
        textarea:focus,
        button:focus,
        .btn:focus,
        .btn-check:focus + .btn,
        .form-check-input:focus {
            outline: none !important;
            box-shadow: none !important;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #ced4da !important;
        }

        /* Remove browser native number input spinners (up/down arrows) */
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none !important;
            margin: 0 !important;
        }
        input[type=number] {
            -moz-appearance: textfield !important;
        }

        /* Perfectly center number text inside Qty inputs */
        .input-cart-qty {
            padding-top: 0 !important;
            padding-bottom: 0 !important;
            line-height: 31px !important;
            height: 31px !important;
        }

        /* Native Enterprise Admin - Header Styling */
        .app-header {
            background: #ffffff !important;
            height: 60px !important;
            border-bottom: 1px solid #e2e8f0 !important;
            box-shadow: none !important;
            padding: 0 1.25rem 0 0 !important;
            display: flex;
            align-items: center;
            z-index: 20;
        }
        .app-header .app-header__logo {
            width: 260px;
            height: 60px;
            display: flex;
            align-items: center;
            padding: 0 1.25rem;
            border-right: 1px solid #e2e8f0;
            position: relative;
            flex-shrink: 0;
            box-sizing: border-box;
            transition: width 0.2s ease, min-width 0.2s ease, flex 0.2s ease;
        }
        .header-brand-wrap {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: #0f172a;
            overflow: hidden;
            min-width: 0;
        }
        .header-brand-icon {
            width: 34px;
            height: 34px;
            border-radius: 8px;
            background: #f1f5f9;
            color: #2563eb;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.15rem !important;
            flex-shrink: 0;
        }
        .header-brand-text {
            font-size: 0.975rem !important;
            font-weight: 700 !important;
            letter-spacing: -0.02em;
            color: #0f172a;
            white-space: nowrap;
        }
        /* Sidebar Edge Capsule Toggle Button (Centered on right border) */
        .btn-sidebar-edge-toggle {
            position: absolute;
            top: 50%;
            right: -11px;
            transform: translateY(-50%);
            width: 22px;
            height: 48px;
            border-radius: 9999px;
            background: #ffffff;
            border: 1px solid #cbd5e1;
            color: #64748b;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 2px 6px rgba(15, 23, 42, 0.08);
            padding: 0;
            font-size: 0.65rem;
            transition: all 0.2s ease;
            z-index: 50;
            outline: none;
        }
        .btn-sidebar-edge-toggle:hover {
            background: #f8fafc;
            color: #0284c7;
            border-color: #94a3b8;
            box-shadow: 0 4px 10px rgba(15, 23, 42, 0.12);
        }
        .btn-sidebar-edge-toggle .toggle-icon {
            transition: transform 0.25s ease;
            display: inline-block;
        }
        .closed-sidebar .btn-sidebar-edge-toggle .toggle-icon {
            transform: rotate(180deg);
        }

        /* Header Search Input */
        .header-search-box {
            position: relative;
            width: 280px;
            margin-left: 1.25rem;
        }
        .header-search-box .form-control {
            height: 36px;
            font-size: 0.8125rem;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding-left: 2rem;
            color: #0f172a;
            transition: all 0.15s ease-in-out;
        }
        .header-search-box .form-control:focus {
            background: #ffffff;
            border-color: #cbd5e1 !important;
        }
        .header-search-box .search-prefix-icon {
            position: absolute;
            left: 0.65rem;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 0.875rem !important;
            pointer-events: none;
        }

        /* Header Quick Navigation Links */
        .header-quick-nav {
            display: flex;
            align-items: center;
            gap: 4px;
            margin-left: 1rem;
            list-style: none;
            padding: 0;
            margin-bottom: 0;
        }
        .header-quick-nav .nav-link {
            padding: 0.4rem 0.75rem;
            font-size: 0.8125rem;
            font-weight: 500;
            color: #64748b;
            border-radius: 6px;
            transition: all 0.15s ease-in-out;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .header-quick-nav .nav-link:hover {
            color: #0f172a;
            background: #f1f5f9;
        }

        /* Header Action Buttons & User Profile */
        .header-action-btn {
            width: 36px;
            height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            border: 1px solid #e2e8f0;
            background: #ffffff;
            color: #64748b;
            padding: 0;
            transition: all 0.15s ease;
        }
        .header-action-btn:hover {
            background: #f8fafc;
            color: #0f172a;
            border-color: #cbd5e1;
        }
        .header-user-btn {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 4px 6px;
            border-radius: 6px;
            transition: background 0.15s;
            text-decoration: none;
            color: inherit;
        }
        .header-user-btn:hover {
            background: #f8fafc;
        }
        .header-user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            object-fit: cover;
            border: 1px solid #e2e8f0;
        }
        .header-user-name {
            font-size: 0.8125rem !important;
            font-weight: 600 !important;
            color: #0f172a !important;
            line-height: 1.2;
        }
        .header-user-role {
            font-size: 0.75rem !important;
            font-weight: 400 !important;
            color: #64748b !important;
            line-height: 1.2;
        }

        /* Modern Notification Dropdown */
        .notif-dropdown-menu {
            min-width: 340px !important;
            max-width: 380px !important;
            padding: 0 !important;
            background: #ffffff !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 12px !important;
            box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.08), 0 8px 10px -6px rgba(15, 23, 42, 0.04) !important;
            overflow: hidden !important;
            margin-top: 8px !important;
        }

        /* Modern User Dropdown Menu */
        .header-user-menu {
            min-width: 230px !important;
            padding: 0 !important;
            background: #ffffff !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 12px !important;
            box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.08), 0 8px 10px -6px rgba(15, 23, 42, 0.04) !important;
            overflow: hidden !important;
            margin-top: 8px !important;
        }
        .header-user-menu-header {
            background: #ffffff;
            border-bottom: 1px solid #f1f5f9;
        }
        .user-menu-avatar-wrap {
            position: relative;
            flex-shrink: 0;
        }
        .user-menu-avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            object-fit: cover;
            border: 1px solid #e2e8f0;
            background: #f8fafc;
        }
        .user-menu-item {
            display: flex !important;
            align-items: center !important;
            gap: 10px !important;
            padding: 8px 12px !important;
            font-size: 0.8125rem !important;
            font-weight: 500 !important;
            color: #334155 !important;
            border-radius: 8px !important;
            transition: all 0.15s ease !important;
            background: transparent !important;
            border: none !important;
            width: 100% !important;
            text-align: left !important;
        }
        .user-menu-item:hover {
            color: #0f172a !important;
            background: #f1f5f9 !important;
        }
        .user-menu-item-icon {
            width: 26px;
            height: 26px;
            border-radius: 6px;
            background: #f8fafc;
            border: 1px solid #f1f5f9;
            color: #64748b;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9375rem;
            flex-shrink: 0;
            transition: all 0.15s ease;
        }
        .user-menu-item:hover .user-menu-item-icon {
            background: #ffffff;
            color: #0284c7;
            border-color: #e2e8f0;
        }

        /* Native Enterprise Admin - Sidebar Styling */
        .app-sidebar {
            background: #ffffff !important;
            width: 260px !important;
            min-width: 260px !important;
            flex: 0 0 260px !important;
            border-right: 1px solid #e2e8f0 !important;
            box-shadow: none !important;
            z-index: 15;
            padding-top: 60px !important;
            overflow: visible !important;
            transition: width 0.2s ease, flex 0.2s ease, min-width 0.2s ease !important;
            box-sizing: border-box !important;
        }
        .fixed-sidebar .app-main .app-main__outer {
            padding-left: 260px !important;
            transition: padding-left 0.2s ease !important;
        }
        .closed-sidebar .app-sidebar,
        .closed-sidebar .app-sidebar:hover {
            width: 80px !important;
            min-width: 80px !important;
            flex: 0 0 80px !important;
        }
        .closed-sidebar.fixed-sidebar .app-main .app-main__outer {
            padding-left: 80px !important;
        }
        .app-sidebar .scrollbar-sidebar {
            padding: 0.75rem 0 !important;
        }
        .app-sidebar__inner {
            padding: 0 0.5rem !important;
        }
        .app-sidebar__heading {
            font-size: 0.6875rem !important;
            text-transform: uppercase !important;
            letter-spacing: 0.08em !important;
            color: #94a3b8 !important;
            font-weight: 600 !important;
            padding: 0.75rem 1rem 0.35rem !important;
            margin: 0 !important;
        }
        .vertical-nav-menu {
            margin: 0;
            padding: 0;
        }
        .vertical-nav-menu li {
            margin-bottom: 2px;
        }
        .vertical-nav-menu li a {
            font-size: 0.835rem !important;
            font-weight: 500 !important;
            color: #64748b !important;
            padding: 0 0.875rem 0 42px !important;
            height: 2.35rem !important;
            line-height: 2.35rem !important;
            border-radius: 0 !important;
            transition: color 0.15s ease !important;
            display: block !important;
            position: relative !important;
            text-decoration: none !important;
            white-space: nowrap !important;
            background: transparent !important;
        }
        .vertical-nav-menu li a::after {
            display: none !important;
        }
        .vertical-nav-menu li a::before {
            content: '';
            position: absolute;
            left: 0;
            top: 20%;
            height: 60%;
            width: 3px;
            background: #0284c7;
            border-radius: 0 3px 3px 0;
            opacity: 0;
            transition: opacity 0.15s ease;
        }
        .vertical-nav-menu li a:hover {
            color: #0f172a !important;
            background: transparent !important;
        }
        .vertical-nav-menu li a:hover i.metismenu-icon {
            color: #0f172a !important;
        }
        .vertical-nav-menu li a.mm-active {
            color: #0284c7 !important;
            background: transparent !important;
            font-weight: 600 !important;
        }
        .vertical-nav-menu li a.mm-active::before {
            opacity: 1;
        }
        .vertical-nav-menu li a i.metismenu-icon {
            font-size: 1.15rem !important;
            color: #94a3b8 !important;
            position: absolute !important;
            left: 10px !important;
            top: 50% !important;
            margin-top: -12px !important;
            width: 24px !important;
            height: 24px !important;
            line-height: 24px !important;
            text-align: center !important;
            opacity: 1 !important;
            transition: color 0.15s ease;
        }
        .vertical-nav-menu li a.mm-active i.metismenu-icon {
            color: #0284c7 !important;
        }

        /* Closed Sidebar Styles */
        .closed-sidebar .app-header .app-header__logo {
            width: 80px !important;
            min-width: 80px !important;
            flex: 0 0 80px !important;
            padding: 0 0.5rem !important;
            justify-content: center !important;
            position: relative !important;
        }
        .closed-sidebar .app-header .app-header__logo .header-brand-text {
            display: none !important;
        }
        .closed-sidebar .app-header .app-header__logo .header-brand-wrap {
            justify-content: center !important;
        }
        .closed-sidebar .app-sidebar,
        .closed-sidebar .app-sidebar:hover {
            width: 80px !important;
            flex: 0 0 80px !important;
            min-width: 80px !important;
            transition: width 0.2s ease !important;
        }
        .closed-sidebar .app-sidebar .app-sidebar__inner,
        .closed-sidebar .app-sidebar:hover .app-sidebar__inner {
            padding: 0 !important;
        }
        .closed-sidebar .app-sidebar .app-sidebar__inner .app-sidebar__heading,
        .closed-sidebar .app-sidebar:hover .app-sidebar__inner .app-sidebar__heading {
            padding: 0.5rem 0 !important;
            margin: 0 !important;
            height: 1px !important;
            line-height: 0 !important;
            overflow: hidden !important;
            position: relative !important;
            text-indent: -9999px !important;
        }
        .closed-sidebar .app-sidebar .app-sidebar__inner .app-sidebar__heading::before,
        .closed-sidebar .app-sidebar:hover .app-sidebar__inner .app-sidebar__heading::before {
            display: block !important;
            background: #e2e8f0 !important;
            height: 1px !important;
            top: 50% !important;
            width: 32px !important;
            left: 50% !important;
            margin-left: -16px !important;
            content: "" !important;
            position: absolute !important;
        }
        .closed-sidebar .app-sidebar .app-sidebar__inner ul li a,
        .closed-sidebar .app-sidebar:hover .app-sidebar__inner ul li a {
            padding: 0 !important;
            text-align: center !important;
            justify-content: center !important;
        }
        .closed-sidebar .app-sidebar .app-sidebar__inner ul li a span,
        .closed-sidebar .app-sidebar:hover .app-sidebar__inner ul li a span {
            display: none !important;
        }
        .closed-sidebar .app-sidebar .app-sidebar__inner .metismenu-icon,
        .closed-sidebar .app-sidebar:hover .app-sidebar__inner .metismenu-icon {
            left: 50% !important;
            margin-left: -12px !important;
            position: absolute !important;
        }
        .closed-sidebar .app-sidebar .app-sidebar__inner ul li a::before,
        .closed-sidebar .app-sidebar:hover .app-sidebar__inner ul li a::before {
            left: 0 !important;
            width: 3px !important;
        }

        /* Hamburger Toggle Minimalist */
        .hamburger-inner,
        .hamburger-inner::before,
        .hamburger-inner::after {
            background-color: #475569 !important;
            width: 18px !important;
            height: 2px !important;
            border-radius: 2px !important;
        }
        .hamburger-box {
            width: 20px !important;
            height: 18px !important;
        }
        .close-sidebar-btn {
            padding: 6px !important;
            border-radius: 6px;
            transition: background 0.15s;
        }
        .close-sidebar-btn:hover {
            background: #f1f5f9;
        }

        /* Clean Native Admin Page Header */
        .app-page-title {
            background: transparent !important;
            padding: 0 0 1.25rem 0 !important;
            margin: 0 0 1.5rem 0 !important;
            border: none !important;
            border-bottom: 1px solid #e2e8f0 !important;
            box-shadow: none !important;
            border-radius: 0 !important;
        }
        .page-title-main-text {
            font-size: 1.5rem !important;
            font-weight: 700 !important;
            color: #0f172a !important;
            letter-spacing: -0.025em;
            line-height: 1.2;
            margin-bottom: 0.25rem;
        }
        .page-title-sub-text {
            font-size: 0.875rem !important;
            color: #64748b !important;
            font-weight: 400 !important;
            line-height: 1.4;
        }
    </style>
</head>
<body>
    <script>
    if (localStorage.getItem("sidebar_closed") === "true") {
        document.write('<div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header closed-sidebar">');
    } else {
        document.write('<div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">');
    }
    </script>
        <!-- ArchitectUI Top Header -->
        <?= $this->include('layout/header') ?>
        
        <div class="app-main">
            <!-- ArchitectUI Left Sidebar -->
            <?= $this->include('layout/sidebar') ?>
            
            <div class="app-main__outer">
                <div class="app-main__inner">
                    <!-- Page Header Title Bar -->
                    <div class="app-page-title">
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                            <div>
                                <h1 class="page-title-main-text m-0"><?= $title ?? 'Dashboard' ?></h1>
                                <div class="page-title-sub-text"><?= $description ?? 'Sistem Manajemen Neptunus Aquatic' ?></div>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <?= $page_actions ?? '' ?>
                            </div>
                        </div>
                    </div>

                    <!-- Dynamic Section Content -->
                    <?= $this->renderSection('content') ?>

                </div>
                <!-- ArchitectUI Footer -->
                <?= $this->include('layout/footer') ?>
            </div>
        </div>
    </div>

    <!-- ArchitectUI Bundle JS & Theme Scripts -->
    <!-- Base URL configuration for external scripts -->
    <script>
        window.BASE_URL = '<?= rtrim(base_url(), '/') ?>/';
    </script>
    <script type="text/javascript" src="<?= base_url('assets/scripts/main.js') ?>"></script>
    <script type="text/javascript" src="<?= base_url('assets/scripts/demo.js') ?>"></script>
    <!-- Application Modals Script -->
    <script type="text/javascript" src="<?= base_url('assets/scripts/modals.js') ?>"></script>

    <!-- Modals & Notifications -->
    <?= $this->include('layout/modals/toast_container') ?>
    <?= $this->include('layout/modals/modal_profil') ?>
    <?= $this->include('layout/modals/modal_pengaturan') ?>
    <?= $this->include('layout/modals/modal_backup') ?>
    <?= $this->include('layout/modals/modal_kalender') ?>
    <?= $this->include('layout/modals/modal_notifikasi_stok') ?>
    <?= $this->include('layout/modals/modal_kasir') ?>
    <?= $this->include('layout/modals/modal_konfirmasi_hapus') ?>

    <!-- Modals Section rendered at root body level -->
    <?= $this->renderSection('modals') ?>

    <!-- Persistent Sidebar State Handler -->
    <script>
    (function () {
        function applySidebarState() {
            const isClosed = localStorage.getItem("sidebar_closed") === "true";
            const appContainer = document.querySelector(".app-container");
            if (appContainer) {
                if (isClosed) {
                    appContainer.classList.add("closed-sidebar");
                } else {
                    appContainer.classList.remove("closed-sidebar");
                }
            }
            document.querySelectorAll(".close-sidebar-btn, .mobile-toggle-nav, .hamburger").forEach(function (btn) {
                if (isClosed) {
                    btn.classList.add("is-active");
                } else {
                    btn.classList.remove("is-active");
                }
            });
        }

        // Apply state immediately on DOMReady & window Load
        document.addEventListener("DOMContentLoaded", applySidebarState);
        window.addEventListener("load", applySidebarState);

        // Direct click handler for sidebar toggle to ensure reliability
        document.addEventListener("click", function (e) {
            const edgeBtn = e.target.closest(".btn-sidebar-edge-toggle");
            if (edgeBtn) {
                e.preventDefault();
                e.stopPropagation();
                const appContainer = document.querySelector(".app-container");
                if (appContainer) {
                    const isClosed = appContainer.classList.toggle("closed-sidebar");
                    localStorage.setItem("sidebar_closed", isClosed ? "true" : "false");
                    document.querySelectorAll(".close-sidebar-btn, .btn-sidebar-edge-toggle, .mobile-toggle-nav, .hamburger").forEach(function (b) {
                        if (isClosed) {
                            b.classList.add("is-active");
                        } else {
                            b.classList.remove("is-active");
                        }
                    });
                }
                return;
            }

            const headerBtn = e.target.closest(".close-sidebar-btn, .mobile-toggle-nav, [data-class='closed-sidebar']");
            if (headerBtn) {
                const appContainer = document.querySelector(".app-container");
                if (appContainer) {
                    setTimeout(function () {
                        const isClosed = appContainer.classList.contains("closed-sidebar");
                        localStorage.setItem("sidebar_closed", isClosed ? "true" : "false");
                        document.querySelectorAll(".btn-sidebar-edge-toggle").forEach(function (b) {
                            if (isClosed) {
                                b.classList.add("is-active");
                            } else {
                                b.classList.remove("is-active");
                            }
                        });
                    }, 50);
                }
            }
        });
    })();
    </script>
</body>
</html>
