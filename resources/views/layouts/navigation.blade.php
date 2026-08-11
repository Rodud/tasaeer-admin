<nav
    x-data="{ open: false, collapsed: false }"
    dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}"
>

    <!-- Mobile Overlay -->
    <div
        x-show="open"
        x-transition.opacity
        @click="open = false"
        class="sidebar-overlay"
    ></div>

    <!-- Sidebar -->
    <aside
    class="sidebar"
    :class="{
        'sidebar-open': open,
        'sidebar-collapsed': collapsed
    }"
>

        <!-- Logo -->
        <div class="sidebar-logo">
            <a href="{{ route('dashboard') }}" class="sidebar-brand">
                <img
                    src="{{ asset('images/rodud-logo.jpeg') }}"
                    alt="Rodud"
                    class="sidebar-logo-image"
                >
            </a>
        </div>

        <!-- Navigation -->
        <div class="sidebar-navigation">

            <p class="sidebar-section-title">
                {{ app()->getLocale() === 'ar' ? 'القائمة الرئيسية' : 'MAIN MENU' }}
            </p>

            <!-- Dashboard -->
            <a
                href="{{ route('dashboard') }}"
                class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
            >
                <span class="sidebar-icon">
                    <svg viewBox="0 0 24 24">
                        <rect x="3" y="3" width="7" height="7" rx="1"/>
                        <rect x="14" y="3" width="7" height="7" rx="1"/>
                        <rect x="3" y="14" width="7" height="7" rx="1"/>
                        <rect x="14" y="14" width="7" height="7" rx="1"/>
                    </svg>
                </span>

                <span>
                    {{ app()->getLocale() === 'ar' ? 'لوحة التحكم' : 'Dashboard' }}
                </span>
            </a>

            <!-- Quotes -->
            <a
                href="{{ route('admin.quotes') }}"
                class="sidebar-link {{ request()->routeIs('admin.quotes') ? 'active' : '' }}"
            >
                <span class="sidebar-icon">
                    <svg viewBox="0 0 24 24">
                        <path d="M6 3h12a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2Z"/>
                        <path d="M8 8h8"/>
                        <path d="M8 12h8"/>
                        <path d="M8 16h5"/>
                    </svg>
                </span>

                <span>
                    {{ app()->getLocale() === 'ar' ? 'طلبات التسعير' : 'Pricing Requests' }}
                </span>
            </a>

            <!-- Pricing -->
            <a
                href="{{ route('admin.pricing.index') }}"
                class="sidebar-link {{ request()->routeIs('admin.pricing.*') ? 'active' : '' }}"
            >
                <span class="sidebar-icon">
                    <svg viewBox="0 0 24 24">
                        <path d="M12 2v20"/>
                        <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                    </svg>
                </span>

                <span>
                    {{ app()->getLocale() === 'ar' ? 'التسعير' : 'Pricing' }}
                </span>
            </a>

        </div>

        <!-- Bottom -->
        <div class="sidebar-bottom">

            <!-- Language Switcher -->
            <a
            href="{{ route('admin.locale', app()->getLocale() === 'ar' ? 'en' : 'ar') }}"
            class="sidebar-link language-switcher"
            >
            <span class="sidebar-icon">
                <svg viewBox="0 0 24 24">
                    <path d="M12 3a9 9 0 1 0 0 18a9 9 0 0 0 0-18Z"/>
                    <path d="M3 12h18"/>
                    <path d="M12 3c2.5 2.5 3.5 5.5 3.5 9s-1 6.5-3.5 9"/>
                    <path d="M12 3c-2.5 2.5-3.5 5.5-3.5 9s1 6.5 3.5 9"/>
                </svg>
            </span>

            <span>
                {{ app()->getLocale() === 'ar' ? 'English' : 'العربية' }}
            </span>
            </a>

           

            <!-- User -->
            <div class="sidebar-user">

                <div class="sidebar-user-avatar">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>

                <div class="sidebar-user-info">
                    <strong>{{ Auth::user()->name }}</strong>
                    <span>{{ Auth::user()->email }}</span>
                </div>

            </div>

            <!-- Logout -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button
                    type="submit"
                    class="sidebar-link sidebar-logout"
                >
                    <span class="sidebar-icon">
                        <svg viewBox="0 0 24 24">
                            <path d="M10 17l5-5-5-5"/>
                            <path d="M15 12H3"/>
                            <path d="M21 3v18"/>
                        </svg>
                    </span>

                    <span>
                        {{ app()->getLocale() === 'ar' ? 'تسجيل الخروج' : 'Log Out' }}
                    </span>
                </button>
            </form>

        </div>

    </aside>

    <!-- Mobile Button -->
    <button
        type="button"
        @click="open = !open"
        class="sidebar-mobile-button"
    >
        <svg
            x-show="!open"
            viewBox="0 0 24 24"
        >
            <path d="M4 6h16"/>
            <path d="M4 12h16"/>
            <path d="M4 18h16"/>
        </svg>

        <svg
            x-show="open"
            viewBox="0 0 24 24"
        >
            <path d="M6 6l12 12"/>
            <path d="M18 6L6 18"/>
        </svg>
    </button>

</nav>

<style>
    .sidebar {
    position: fixed;
    top: 0;
    bottom: 0;
    width: 260px;
    background: #ffffff;
    border-right: 1px solid #E6E2EC;
    box-shadow: 0 6px 20px rgba(14, 10, 20, .06);
    display: flex;
    flex-direction: column;
    z-index: 1001;
}

    /* Collapsed Sidebar */
.sidebar {
    transition: width .25s ease;
}

.sidebar.sidebar-collapsed {
    width: 76px;
}

.sidebar.sidebar-collapsed .sidebar-section-title,
.sidebar.sidebar-collapsed .sidebar-link > span:not(.sidebar-icon),
.sidebar.sidebar-collapsed .sidebar-user-info {
    display: none;
}

.sidebar.sidebar-collapsed .sidebar-navigation {
    padding-left: 10px;
    padding-right: 10px;
}

.sidebar.sidebar-collapsed .sidebar-link {
    justify-content: center;
    padding-left: 10px;
    padding-right: 10px;
}

.sidebar.sidebar-collapsed .sidebar-icon {
    margin: 0;
}

.sidebar.sidebar-collapsed .sidebar-logo {
    justify-content: center;
    padding: 0;
}

.sidebar.sidebar-collapsed .sidebar-logo-image {
    width: 42px;
}

.sidebar.sidebar-collapsed .sidebar-user {
    justify-content: center;
}

.sidebar.sidebar-collapsed .sidebar-logout {
    justify-content: center;
}

    [dir="rtl"] .sidebar {
        right: 0;
        border-right: none;
        border-left: 1px solid #E6E2EC;
    }

    [dir="ltr"] .sidebar {
        left: 0;
    }

    .sidebar-logo {
        height: 82px;
        display: flex;
        align-items: center;
        padding: 0 24px;
        border-bottom: 1px solid #E6E2EC;
    }

    .sidebar-logo a {
        display: flex;
        align-items: center;
    }

    .sidebar-logo-image {
        width: 60px ;
        height: auto;
    }

    .sidebar-navigation {
        padding: 28px 16px;
        flex: 1;
    }

    .sidebar-section-title {
        margin: 0 12px 12px;
        color: #9B94A5;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .06em;
    }

    .sidebar-link {
        width: 100%;
        min-height: 46px;
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 13px;
        margin-bottom: 6px;
        border: 0;
        border-radius: 12px;
        background: transparent;
        color: #5B5468;
        text-decoration: none;
        font-family: inherit;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: .2s ease;
        text-align: start;
    }

    .sidebar-link:hover {
        background: #F7F0FC;
        color: #7818C0;
    }

    .sidebar-link.active {
        background: #F0E3F9;
        color: #5F12A0;
        font-weight: 800;
    }

    .sidebar-icon {
        width: 21px;
        height: 21px;
        flex: 0 0 21px;
        display: grid;
        place-items: center;
    }

    .sidebar-icon svg {
        width: 19px;
        height: 19px;
        stroke: currentColor;
        fill: none;
        stroke-width: 1.8;
        stroke-linecap: round;
        stroke-linejoin: round;
    }

    .sidebar-bottom {
        padding: 16px;
        border-top: 1px solid #E6E2EC;
    }

    .sidebar-user {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px 4px;
        margin-bottom: 6px;
    }

    .sidebar-user-avatar {
        width: 38px;
        height: 38px;
        border-radius: 11px;
        display: grid;
        place-items: center;
        background: #ECDFF7;
        color: #5F12A0;
        font-size: 14px;
        font-weight: 800;
        flex: 0 0 38px;
    }

    .sidebar-user-info {
        min-width: 0;
        display: flex;
        flex-direction: column;
    }

    .sidebar-user-info strong {
        color: #2B2333;
        font-size: 13px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .sidebar-user-info span {
        margin-top: 2px;
        color: #8A8497;
        font-size: 11px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .sidebar-logout {
        color: #8A8497;
    }

    .sidebar-logout:hover {
        color: #C0392B;
        background: #FFF5F4;
    }

    .sidebar-mobile-button,
    .sidebar-overlay {
        display: none;
    }

    @media (max-width: 768px) {

        .sidebar {
            width: 270px;
            transform: translateX(110%);
            transition: transform .25s ease;
        }

        [dir="ltr"] .sidebar {
            transform: translateX(-110%);
        }

        [dir="rtl"] .sidebar.sidebar-open {
            transform: translateX(0);
        }

        [dir="ltr"] .sidebar.sidebar-open {
            transform: translateX(0);
        }

        .sidebar-overlay {
            position: fixed;
            inset: 0;
            display: block;
            background: rgba(14, 10, 20, .35);
            z-index: 1000;
        }

        .sidebar-mobile-button {
            position: fixed;
            bottom: 20px;
            left: 20px;
            width: 44px;
            height: 44px;
            border: 1px solid #E6E2EC;
            border-radius: 12px;
            background: #fff;
            color: #5F12A0;
            display: grid;
            place-items: center;
            z-index: 1005;
            box-shadow: 0 4px 15px rgba(14, 10, 20, .12);
        }


        .sidebar-mobile-button svg {
            width: 21px;
            height: 21px;
            stroke: currentColor;
            fill: none;
            stroke-width: 2;
            stroke-linecap: round;
        }
    }
    .admin-content {
    min-height: 100vh;
    margin-inline-start: 260px;
    transition: margin .25s ease;
}

body.sidebar-is-collapsed .admin-content {
    margin-inline-start: 76px;
}

@media (max-width: 768px) {
    .admin-content {
        margin-inline-start: 0;
    }

    body.sidebar-is-collapsed .admin-content {
        margin-inline-start: 0;
    }
}

.sidebar-toggle {
    position: absolute;
    top: 88px;
    left: -14px;

    width: 28px;
    height: 28px;

    border: 1px solid #E6E2EC;
    border-radius: 50%;

    background: #fff;
    color: #5F12A0;

    display: grid;
    place-items: center;

    cursor: pointer;
    z-index: 1005;

    box-shadow: 0 3px 10px rgba(14, 10, 20, .12);
}

.sidebar-toggle svg {
    width: 16px;
    height: 16px;

    stroke: currentColor;
    fill: none;
    stroke-width: 2;
    stroke-linecap: round;
    stroke-linejoin: round;
}

[dir="rtl"] .sidebar-toggle {
    left: auto;
    right: -14px;
}
.language-switcher {
    margin-bottom: 8px;
}


</style>