<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Mfumo wa Usimamizi wa Kanisa') - {{ $currentChurch->name ?? 'EAGT Kanisa Kuu' }}</title>
    
    <!-- Local Bootstrap 5 CSS & Bootstrap Icons -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/icons/bootstrap-icons.min.css') }}">

    <!-- PWA & Mobile Web App Meta -->
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="{{ $currentChurch->primary_color ?? '#1e3a8a' }}">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="EAGT Kanisa">
    
    <!-- Google Fonts Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-color: {{ $currentChurch->primary_color ?? '#1e3a8a' }};
            --secondary-color: {{ $currentChurch->secondary_color ?? '#d97706' }};
            --bg-canvas: #f8fafc;
            --sidebar-bg: #0f172a;
            --sidebar-text: #94a3b8;
            --card-border: rgba(226, 232, 240, 0.85);
        }

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background-color: var(--bg-canvas);
            color: #1e293b;
            min-height: 100vh;
        }

        /* Sidebar Styling */
        .sidebar {
            width: 280px;
            background: linear-gradient(180deg, #0b1329 0%, #172554 100%);
            color: #fff;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 1040;
            overflow-y: auto;
            transition: all 0.3s ease;
            box-shadow: 4px 0 24px rgba(0,0,0,0.08);
        }

        .sidebar-brand {
            padding: 1.4rem 1.25rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .brand-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.35rem;
            color: #fff;
            box-shadow: 0 4px 12px rgba(0,0,0,0.25);
            flex-shrink: 0;
        }

        .sidebar-heading {
            font-size: 0.72rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #94a3b8;
            font-weight: 700;
            padding: 1.2rem 1.25rem 0.4rem;
        }

        .nav-link-custom {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0.68rem 1.25rem;
            color: #cbd5e1;
            font-size: 0.90rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s ease;
            border-left: 3px solid transparent;
        }

        .nav-link-custom:hover {
            color: #f8fafc;
            background: rgba(255, 255, 255, 0.06);
            border-left-color: var(--secondary-color);
        }

        .nav-link-custom.active {
            color: #fff;
            background: rgba(255, 255, 255, 0.12);
            border-left-color: var(--secondary-color);
            font-weight: 700;
        }

        .nav-link-custom i {
            font-size: 1.15rem;
            width: 22px;
        }

        /* Topbar & Content */
        .main-wrapper {
            margin-left: 280px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease;
        }

        .top-navbar {
            height: 72px;
            background: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            padding: 0 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 1020;
            box-shadow: 0 1px 4px rgba(0,0,0,0.02);
        }

        .content-body {
            padding: 2rem;
            flex: 1;
        }

        /* Card Enhancements */
        .card-custom {
            border: 1px solid var(--card-border);
            border-radius: 16px;
            box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.04);
            background: #fff;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card-custom:hover {
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.06);
        }

        .stat-card {
            border: none;
            border-radius: 16px;
            padding: 1.5rem;
            color: #fff;
            position: relative;
            overflow: hidden;
            box-shadow: 0 8px 24px -4px rgba(0,0,0,0.12);
        }

        .stat-card-icon {
            position: absolute;
            right: 1.25rem;
            bottom: 1.25rem;
            font-size: 3.5rem;
            opacity: 0.18;
        }

        .btn-primary-custom {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: #fff;
            border-radius: 10px;
            font-weight: 600;
            padding: 0.6rem 1.25rem;
            transition: all 0.2s ease;
        }

        .btn-primary-custom:hover {
            opacity: 0.92;
            color: #fff;
            transform: translateY(-1px);
        }

        .table-custom th {
            font-size: 0.78rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #64748b;
            font-weight: 700;
            border-bottom-width: 1px;
            padding: 1rem;
        }

        .table-custom td {
            padding: 1rem;
            vertical-align: middle;
        }

        @media (max-width: 992px) {
            .sidebar {
                margin-left: -280px;
            }
            .sidebar.show {
                margin-left: 0;
            }
            .main-wrapper {
                margin-left: 0;
            }
        }
    </style>
    @yield('styles')
</head>
<body>

    <!-- Menyu ya Kushoto (Sidebar) -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            @if(isset($currentChurch) && $currentChurch->logo_path)
                <img src="{{ asset($currentChurch->logo_path) }}" alt="{{ $currentChurch->name }}" class="rounded-circle shadow-sm" style="width: 44px; height: 44px; object-fit: contain; background: #fff; padding: 2px; flex-shrink: 0;">
            @else
                <img src="{{ asset('assets/images/eagt_logo.jpg') }}" alt="EAGT Logo" class="rounded-circle shadow-sm" style="width: 44px; height: 44px; object-fit: contain; background: #fff; padding: 2px; flex-shrink: 0;">
            @endif
            <div class="overflow-hidden">
                <h6 class="mb-0 text-white text-truncate fw-bold" style="font-size: 0.95rem;">
                    {{ $currentChurch->name ?? 'EAGT TANZANIA' }}
                </h6>
                <small class="text-warning text-truncate d-block fw-semibold" style="font-size: 0.75rem;">
                    <i class="bi bi-geo-alt-fill"></i> Golani, Kimara-Suka
                </small>
            </div>
        </div>

        <nav class="py-2">
            <div class="sidebar-heading">Menyu Kuu</div>
            <a href="{{ route('dashboard') }}" class="nav-link-custom {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2-fill"></i> Dashibodi ya Kanisa
            </a>

            @if(Auth::user()->isSuperAdmin())
                <div class="sidebar-heading text-warning"><i class="bi bi-shield-shaded"></i> Utawala wa Mfumo</div>
                <a href="{{ route('superadmin.churches.index') }}" class="nav-link-custom {{ request()->routeIs('superadmin.churches.*') ? 'active' : '' }}">
                    <i class="bi bi-buildings-fill text-warning"></i> Makanisa na Leseni
                </a>
            @endif

            <div class="sidebar-heading">Waumini na Huduma</div>
            <a href="{{ route('members.index') }}" class="nav-link-custom {{ request()->routeIs('members.*') ? 'active' : '' }}">
                <i class="bi bi-people-fill"></i> Daftari la Waumini
            </a>
            <a href="{{ route('departments.index') }}" class="nav-link-custom {{ request()->routeIs('departments.*') ? 'active' : '' }}">
                <i class="bi bi-diagram-3-fill"></i> Idara za Kanisa (CPV, WWK...)
            </a>
            <a href="{{ route('attendance.index') }}" class="nav-link-custom {{ request()->routeIs('attendance.*') ? 'active' : '' }}">
                <i class="bi bi-clipboard-check-fill"></i> Mahudhurio ya Ibada
            </a>

            <div class="sidebar-heading">
                @if(Auth::user()->isMember())
                    Ujenzi na Matumizi
                @else
                    Hazina na Fedha
                @endif
            </div>
            <a href="{{ route('finances.index') }}" class="nav-link-custom {{ request()->routeIs('finances.index', 'finances.create') ? 'active' : '' }}">
                <i class="bi bi-cash-stack"></i> 
                @if(Auth::user()->isMember())
                    Michango ya Ujenzi & Miradi
                @elseif(Auth::user()->isTreasurer())
                    Sadaka na Michango
                @else
                    Zaka, Sadaka na Michango
                @endif
            </a>
            <a href="{{ route('finances.expenses') }}" class="nav-link-custom {{ request()->routeIs('finances.expenses*') ? 'active' : '' }}">
                <i class="bi bi-receipt-cutoff"></i> Matumizi ya Kanisa
            </a>

            <div class="sidebar-heading">Uchungaji na Injili</div>
            <a href="{{ route('pastoral.index') }}" class="nav-link-custom {{ request()->routeIs('pastoral.*') ? 'active' : '' }}">
                <i class="bi bi-heart-pulse-fill"></i> Huduma ya Kichungaji & Maombi
            </a>
            <a href="{{ route('media.index') }}" class="nav-link-custom {{ request()->routeIs('media.*') ? 'active' : '' }}">
                <i class="bi bi-youtube text-danger"></i> Mahubiri & Ibada Moja kwa Moja
            </a>
            <a href="{{ route('documents.index') }}" class="nav-link-custom {{ request()->routeIs('documents.*') ? 'active' : '' }}">
                <i class="bi bi-file-earmark-text-fill"></i> Maktaba ya Nyaraka
            </a>
            <a href="{{ route('projects.index') }}" class="nav-link-custom {{ request()->routeIs('projects.*') ? 'active' : '' }}">
                <i class="bi bi-hammer"></i> Miradi na Mali za Kanisa
            </a>
            <a href="{{ route('announcements.index') }}" class="nav-link-custom {{ request()->routeIs('announcements.*') ? 'active' : '' }}">
                <i class="bi bi-megaphone-fill"></i> Matangazo na Kalenda
            </a>

            @if(!Auth::user()->isMember())
            <div class="sidebar-heading">Mawasiliano & Taarifa</div>
            <a href="{{ route('sms.index') }}" class="nav-link-custom {{ request()->routeIs('sms.*') ? 'active' : '' }}">
                <i class="bi bi-chat-dots-fill text-info"></i> Kituo cha SMS (Mawasiliano)
            </a>
            @endif

            @if(Auth::user()->isChurchAdmin() || Auth::user()->isSuperAdmin())
                <div class="sidebar-heading">Usalama na Ukaguzi</div>
                <a href="{{ route('audit.index') }}" class="nav-link-custom {{ request()->routeIs('audit.*') ? 'active' : '' }}">
                    <i class="bi bi-journal-text"></i> Kumbukumbu za Ukaguzi (Audit)
                </a>
            @endif
        </nav>
    </aside>

    <!-- Sehemu Kuu ya Maudhui -->
    <div class="main-wrapper">
        <header class="top-navbar">
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-light d-lg-none" id="sidebarToggle">
                    <i class="bi bi-list fs-5"></i>
                </button>

                <div class="d-none d-md-flex align-items-center gap-2">
                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-3 py-2 fw-semibold">
                        <i class="bi bi-geo-alt-fill me-1 text-danger"></i> EAGT Golani, Kimara-Suka - Dar es Salaam
                    </span>
                </div>
            </div>

            <!-- Udhibiti wa Kulia: Jaribio la Haraka na Akaunti -->
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('home') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3 d-none d-md-inline-flex align-items-center" target="_blank">
                    <i class="bi bi-globe me-1 text-primary"></i> Tovuti Kuu
                </a>

                <!-- Kitufe cha Majaribio ya Haraka (1-Click Demo Login) -->
                <div class="dropdown d-none d-sm-block">
                    <button class="btn btn-sm btn-light border dropdown-toggle fw-semibold rounded-pill px-3 shadow-sm" type="button" data-bs-toggle="dropdown">
                        <i class="bi bi-person-gear text-primary me-1"></i> Badili Jukumu (Majaribio)
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3" style="min-width: 240px;">
                        <li><h6 class="dropdown-header text-uppercase">Bofya Kuingia Kirole Mara Moja:</h6></li>
                        <li><a class="dropdown-item py-2" href="{{ route('demo.login', 'pastor') }}"><i class="bi bi-heart-pulse text-primary me-2"></i> Mchungaji Kiongozi</a></li>
                        <li><a class="dropdown-item py-2" href="{{ route('demo.login', 'elder') }}"><i class="bi bi-person-check text-success me-2"></i> Mzee wa Kanisa</a></li>
                        <li><a class="dropdown-item py-2" href="{{ route('demo.login', 'treasurer') }}"><i class="bi bi-cash-coin text-warning me-2"></i> Mhazini (Mtunza Hazina)</a></li>
                        <li><a class="dropdown-item py-2" href="{{ route('demo.login', 'secretary') }}"><i class="bi bi-pen text-info me-2"></i> Katibu wa Kanisa</a></li>
                        <li><a class="dropdown-item py-2" href="{{ route('demo.login', 'youth_leader') }}"><i class="bi bi-diagram-3 text-secondary me-2"></i> Kiongozi wa Idara (CGM)</a></li>
                        <li><a class="dropdown-item py-2" href="{{ route('demo.login', 'member') }}"><i class="bi bi-person text-muted me-2"></i> Mshirika wa Kawaida</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item py-2" href="{{ route('demo.login', 'super_admin') }}"><i class="bi bi-shield-shaded text-danger me-2"></i> Msimamizi Mkuu (Super Admin)</a></li>
                    </ul>
                </div>

                <!-- Akaunti ya Mtumiaji -->
                <div class="dropdown">
                    <button class="btn btn-light d-flex align-items-center gap-2 p-1 pe-3 border rounded-pill" type="button" data-bs-toggle="dropdown">
                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fw-bold" style="width: 38px; height: 38px; font-size: 0.95rem;">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <div class="text-start d-none d-md-block" style="line-height: 1.2;">
                            <span class="fw-bold d-block text-dark" style="font-size: 0.85rem;">{{ Auth::user()->name }}</span>
                            @php
                                $roleNames = [
                                    'super_admin' => 'Msimamizi Mkuu',
                                    'church_admin' => 'Msimamizi wa Kanisa',
                                    'pastor' => 'Mchungaji Kiongozi',
                                    'elder' => 'Mzee wa Kanisa',
                                    'treasurer' => 'Mhazini',
                                    'secretary' => 'Katibu wa Kanisa',
                                    'department_leader' => 'Kiongozi wa Idara',
                                    'member' => 'Mshirika',
                                ];
                            @endphp
                            <span class="badge bg-secondary-subtle text-secondary small fw-bold">
                                {{ $roleNames[Auth::user()->role] ?? Auth::user()->role }}
                            </span>
                        </div>
                        <i class="bi bi-chevron-down text-muted ms-1" style="font-size: 0.75rem;"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3 mt-2">
                        <li><a class="dropdown-item py-2" href="{{ route('profile') }}"><i class="bi bi-person-circle me-2 text-primary"></i> Wasifu Wangu</a></li>
                        <li><a class="dropdown-item py-2" href="{{ route('home') }}" target="_blank"><i class="bi bi-globe me-2 text-info"></i> Tovuti Kuu ya Kanisa</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item py-2 text-danger">
                                    <i class="bi bi-box-arrow-right me-2"></i> Toka Kwenye Mfumo (Logout)
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </header>

        <!-- Ujumbe wa Mfumo (Flash Messages) -->
        <main class="content-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm border-0 d-flex align-items-center gap-2" role="alert">
                    <i class="bi bi-check-circle-fill fs-5 text-success"></i>
                    <div>{{ session('success') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('info'))
                <div class="alert alert-info alert-dismissible fade show rounded-3 shadow-sm border-0 d-flex align-items-center gap-2" role="alert">
                    <i class="bi bi-info-circle-fill fs-5 text-info"></i>
                    <div>{{ session('info') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('warning'))
                <div class="alert alert-warning alert-dismissible fade show rounded-3 shadow-sm border-0 d-flex align-items-center gap-2" role="alert">
                    <i class="bi bi-exclamation-triangle-fill fs-5 text-warning"></i>
                    <div>{{ session('warning') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm border-0" role="alert">
                    <div class="fw-bold mb-1"><i class="bi bi-x-circle-fill me-1"></i> Tafadhali rekebisha hitilafu zifuatazo:</div>
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <!-- Scripts za Ndani (Local Assets) -->
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/chart.umd.js') }}"></script>
    <script>
        document.getElementById('sidebarToggle')?.addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('show');
        });

        // Sajili Service Worker ya PWA
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function() {
                navigator.serviceWorker.register('/sw.js').catch(function(err) {
                    console.log('SW registration error:', err);
                });
            });
        }
    </script>
    @yield('scripts')
</body>
</html>
