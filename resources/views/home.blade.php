<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EVANGELIST ASSEMBLIES OF GOD TANZANIA (EAGT) - GOLANI, KIMARA-SUKA</title>
    <meta name="description" content="Kanisa la Pentekoste la EVANGELIST ASSEMBLIES OF GOD TANZANIA (EAGT) - Golani, Kimara-Suka, Dar es Salaam. Mahali pa Neno la Mungu, Sifa, Uponyaji na Kufunguliwa.">

    <!-- Local Bootstrap 5 CSS & Bootstrap Icons -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/icons/bootstrap-icons.min.css') }}">

    <!-- PWA & Mobile Web App Meta -->
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#1e3a8a">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="EAGT Golani">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Cinzel:wght@600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #1e3a8a;
            --primary-dark: #0f172a;
            --gold: #d97706;
            --gold-light: #fef3c7;
            --accent: #2563eb;
            --bg-light: #f8fafc;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #334155;
            background-color: #ffffff;
            overflow-x: hidden;
        }

        .heading-serif {
            font-family: 'Cinzel', serif;
            letter-spacing: 0.5px;
        }

        /* Top Bar */
        .topbar {
            background-color: var(--primary-dark);
            color: #cbd5e1;
            font-size: 0.84rem;
            padding: 8px 0;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }

        /* Navbar */
        .church-nav {
            background: rgba(255, 255, 255, 0.96);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(226, 232, 240, 0.8);
            position: sticky;
            top: 0;
            z-index: 1050;
            transition: all 0.3s ease;
        }

        .nav-link {
            font-weight: 600;
            font-size: 0.92rem;
            color: #1e293b !important;
            padding: 0.75rem 1rem !important;
            transition: color 0.2s ease;
        }

        .nav-link:hover {
            color: var(--gold) !important;
        }

        /* Hero Section */
        .hero-section {
            position: relative;
            min-height: 85vh;
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.90) 0%, rgba(30, 58, 138, 0.85) 100%),
                        url("{{ asset('assets/images/praise_worship_team.jpg') }}") center/cover no-repeat;
            display: flex;
            align-items: center;
            color: #fff;
            padding: 90px 0 110px;
        }

        .hero-badge {
            background: rgba(217, 119, 6, 0.25);
            border: 1px solid rgba(217, 119, 6, 0.6);
            color: #fbbf24;
            font-size: 0.82rem;
            letter-spacing: 1.5px;
            padding: 6px 18px;
            border-radius: 50px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .hero-title {
            font-size: 3.2rem;
            font-weight: 800;
            line-height: 1.18;
            color: #ffffff;
            text-shadow: 0 4px 20px rgba(0,0,0,0.4);
        }

        @media (max-width: 768px) {
            .hero-title { font-size: 2.2rem; }
        }

        .countdown-box {
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 16px;
            padding: 20px;
            text-align: center;
        }

        .countdown-num {
            font-size: 2rem;
            font-weight: 800;
            color: #fbbf24;
            line-height: 1;
        }

        .countdown-label {
            font-size: 0.72rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #e2e8f0;
            margin-top: 4px;
        }

        /* Cards and Elements */
        .service-card {
            background: #ffffff;
            border-radius: 20px;
            border: 1px solid #e2e8f0;
            padding: 32px 28px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.04);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 100%;
            position: relative;
            overflow: hidden;
        }

        .service-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: linear-gradient(90deg, var(--primary), var(--gold));
        }

        .service-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(30, 58, 138, 0.12);
        }

        .dept-card {
            background: #fff;
            border-radius: 18px;
            border: 1px solid #e2e8f0;
            overflow: hidden;
            transition: all 0.3s ease;
            height: 100%;
        }

        .dept-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 16px 36px rgba(0,0,0,0.08);
            border-color: var(--gold);
        }

        .feature-icon-circle {
            width: 64px;
            height: 64px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.75rem;
            margin-bottom: 20px;
        }

        .section-header {
            text-align: center;
            max-width: 750px;
            margin: 0 auto 50px;
        }

        .section-tag {
            color: var(--gold);
            font-weight: 700;
            font-size: 0.82rem;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 8px;
            display: inline-block;
        }

        .section-title {
            font-weight: 800;
            color: #0f172a;
            font-size: 2.3rem;
            letter-spacing: -0.5px;
        }

        /* Pillars Section */
        .pillar-card {
            background: #ffffff;
            border-radius: 16px;
            padding: 24px;
            border: 1px solid #e2e8f0;
            height: 100%;
            transition: all 0.25s ease;
        }

        .pillar-card:hover {
            background: #f8fafc;
            border-color: var(--primary);
        }

        /* Footer */
        .church-footer {
            background: #090d16;
            color: #94a3b8;
            padding: 70px 0 30px;
            border-top: 4px solid var(--gold);
        }

        .footer-heading {
            color: #ffffff;
            font-weight: 700;
            font-size: 1.1rem;
            margin-bottom: 20px;
        }

        .footer-link {
            color: #94a3b8;
            text-decoration: none;
            display: block;
            margin-bottom: 10px;
            font-size: 0.9rem;
            transition: color 0.2s;
        }

        .footer-link:hover {
            color: #fbbf24;
        }

        /* Photo Gallery Styling */
        .church-gallery-card {
            border-radius: 20px;
            overflow: hidden;
            border: 1px solid #e2e8f0;
            background: #ffffff;
            transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 10px 25px rgba(0,0,0,0.03);
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .church-gallery-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(30, 58, 138, 0.12);
            border-color: #d97706;
        }

        .church-gallery-img {
            transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
            width: 100%;
            height: 280px;
            object-fit: cover;
        }

        .church-gallery-card:hover .church-gallery-img {
            transform: scale(1.06);
        }

        .gallery-img-container {
            overflow: hidden;
            position: relative;
            background-color: #0f172a;
        }

        .upload-slot-card {
            border: 2px dashed rgba(30, 58, 138, 0.35);
            background: rgba(30, 58, 138, 0.03);
            border-radius: 20px;
            height: 100%;
            transition: all 0.3s ease;
        }

        .upload-slot-card:hover {
            border-color: #d97706;
            background: rgba(217, 119, 6, 0.05);
            transform: translateY(-4px);
        }

        /* WhatsApp Floating Widget */
        .whatsapp-float-container {
            position: fixed;
            bottom: 24px;
            right: 24px;
            z-index: 1080;
        }

        .whatsapp-float-btn {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, #25D366 0%, #128C7E 100%);
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            box-shadow: 0 8px 24px rgba(37, 211, 102, 0.45);
            border: none;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            animation: pulse-green 2.5s infinite;
        }

        .whatsapp-float-btn:hover {
            transform: scale(1.1) rotate(5deg);
            color: #ffffff;
        }

        @keyframes pulse-green {
            0% { box-shadow: 0 0 0 0 rgba(37, 211, 102, 0.6); }
            70% { box-shadow: 0 0 0 16px rgba(37, 211, 102, 0); }
            100% { box-shadow: 0 0 0 0 rgba(37, 211, 102, 0); }
        }

        .whatsapp-popup-card {
            display: none;
            position: absolute;
            bottom: 75px;
            right: 0;
            width: 320px;
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 16px 40px rgba(0,0,0,0.2);
            overflow: hidden;
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
        }

        .whatsapp-popup-card.show {
            display: block;
            animation: slideUp 0.3s ease;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

<!-- 1. Top Bar -->
<div class="topbar">
    <div class="container">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
            <div class="d-flex align-items-center gap-4">
                <span><i class="bi bi-geo-alt-fill text-warning me-1"></i> Golani, Kimara-Suka - Dar es Salaam</span>
                <span class="d-none d-md-inline"><i class="bi bi-telephone-fill text-warning me-1"></i> +255 754 123 456</span>
                <span class="d-none d-lg-inline"><i class="bi bi-envelope-fill text-warning me-1"></i> golani@eagt.org</span>
            </div>
            <div class="d-flex align-items-center gap-3">
                <div class="d-flex align-items-center gap-2 me-2">
                    <a href="https://www.facebook.com/profile.php?id=61585945186115" target="_blank" rel="noopener" class="text-white-50 text-hover-warning" title="Facebook"><i class="bi bi-facebook"></i></a>
                    <a href="https://www.instagram.com/eagt_golani?rpxt=amU0Y3R5a2FlYWJ5" target="_blank" rel="noopener" class="text-white-50 text-hover-warning" title="Instagram"><i class="bi bi-instagram"></i></a>
                    <a href="https://www.tiktok.com/@eagt.golani?_r=1&_t=ZS-9AijKazxKBY" target="_blank" rel="noopener" class="text-white-50 text-hover-warning" title="TikTok"><i class="bi bi-tiktok"></i></a>
                    <a href="https://youtube.com/@eagt_golani?si=MQXrKVblnH6E7A7H" target="_blank" rel="noopener" class="text-danger" title="YouTube"><i class="bi bi-youtube"></i></a>
                </div>
                <span class="text-white-50">|</span>
                <span class="text-warning fw-semibold"><i class="bi bi-fire me-1"></i> Kanisa la Pentekoste</span>
                <span class="text-white-50">|</span>
                @if(Auth::check())
                    <a href="{{ route('dashboard') }}" class="btn btn-warning btn-sm rounded-pill px-3 py-1 fw-bold text-dark" style="font-size: 0.8rem;">
                        <i class="bi bi-speedometer2 me-1"></i> Dashibodi Yangu
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm rounded-pill px-3 py-1 fw-bold" style="font-size: 0.8rem;">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Ingia Kwenye Mfumo (Portal)
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- 2. Sticky Navbar -->
<nav class="navbar navbar-expand-lg church-nav shadow-sm">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2 py-2" href="{{ route('home') }}">
            <img src="{{ asset('assets/images/eagt_logo.jpg') }}" alt="EAGT Logo" class="rounded-circle shadow-sm" style="width: 46px; height: 46px; object-fit: contain; background: #ffffff; padding: 2px; border: 2px solid #d97706;">
            <div>
                <span class="fw-bold d-block text-dark lh-1" style="font-size: 1.05rem; letter-spacing: 0.5px;">EAGT GOLANI</span>
                <small class="text-muted fw-semibold" style="font-size: 0.72rem; letter-spacing: 0.3px;">EVANGELIST ASSEMBLIES OF GOD TANZANIA</small>
            </div>
        </a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#churchNavContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="churchNavContent">
            <ul class="navbar-nav ms-auto align-items-lg-center">
                <li class="nav-item"><a class="nav-link" href="#mwanzo">Mwanzo</a></li>
                <li class="nav-item"><a class="nav-link" href="#kuhusu">Kuhusu Sisi</a></li>
                <li class="nav-item"><a class="nav-link" href="#ratiba">Ibada & Ratiba</a></li>
                <li class="nav-item"><a class="nav-link" href="#idara">Idara Zetu</a></li>
                <li class="nav-item"><a class="nav-link" href="#uzinduzi"><i class="bi bi-disc-fill me-1 text-danger"></i> Uzinduzi wa Albamu</a></li>
                <li class="nav-item"><a class="nav-link" href="#picha"><i class="bi bi-images me-1 text-warning"></i> Picha za Kanisa</a></li>
                <li class="nav-item"><a class="nav-link" href="#ujenzi">Mradi wa Ujenzi</a></li>
                <li class="nav-item"><a class="nav-link" href="#mahubiri">Mahubiri</a></li>
                <li class="nav-item"><a class="nav-link" href="#maombi">Hitaji la Maombi</a></li>
                <li class="nav-item ms-lg-2">
                    <button type="button" class="btn btn-outline-warning rounded-pill px-3 py-2 fw-bold" data-bs-toggle="modal" data-bs-target="#givingModal">
                        <i class="bi bi-heart-fill text-danger me-1"></i> Toa Sadaka
                    </button>
                </li>
                <li class="nav-item ms-lg-2 mt-2 mt-lg-0">
                    @if(Auth::check())
                        <a href="{{ route('dashboard') }}" class="btn btn-primary rounded-pill px-4 py-2 fw-bold shadow-sm" style="background: #1e3a8a;">
                            <i class="bi bi-person-circle me-1"></i> Dashibodi
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-warning rounded-pill px-4 py-2 fw-bold text-dark shadow-sm">
                            <i class="bi bi-shield-lock-fill me-1"></i> Mfumo wa Kanisa
                        </a>
                    @endif
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- 3. Hero Section -->
<header id="mwanzo" class="hero-section">
    <div class="container">
        <div class="row align-items-center gy-5">
            <div class="col-lg-7">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <img src="{{ asset('assets/images/eagt_logo.jpg') }}" alt="EAGT Logo" class="rounded-circle shadow bg-white p-1" style="width: 54px; height: 54px; object-fit: contain; border: 2px solid #fbbf24;">
                    <div class="hero-badge">
                        <i class="bi bi-fire text-warning"></i> EVANGELIST ASSEMBLIES OF GOD TANZANIA
                    </div>
                </div>
                <h1 class="hero-title mb-3">
                    Karibu EAGT Golani, Kimara-Suka
                </h1>
                <p class="fs-5 text-white-50 mb-4" style="line-height: 1.6; max-width: 620px;">
                    Mahali pa Neno la Msalaba lenye nguvu ya Mungu, sifa na kuabudu katika Roho na kweli, uponyaji wa miili, na kufunguliwa kwa vifungo vyote kupitia jina la Yesu Kristo!
                </p>

                <div class="d-flex flex-wrap gap-3 mb-4">
                    <button type="button" class="btn btn-warning btn-lg rounded-pill px-4 fw-bold text-dark shadow" data-bs-toggle="modal" data-bs-target="#givingModal">
                        <i class="bi bi-gift-fill me-2 text-danger"></i> Toa Sadaka / Zaka Mtandaoni
                    </button>
                    <a href="#ratiba" class="btn btn-outline-light btn-lg rounded-pill px-4 fw-bold">
                        <i class="bi bi-calendar-check-fill me-2"></i> Ratiba za Ibada
                    </a>
                    <a href="#maombi" class="btn btn-outline-light btn-lg rounded-pill px-4 fw-bold">
                        <i class="bi bi-heart-fill me-2 text-danger"></i> Ombi la Maombi
                    </a>
                </div>

                <div class="d-flex align-items-center gap-3 pt-3 border-top border-white border-opacity-20 text-white-50 small">
                    <div><i class="bi bi-check-circle-fill text-warning me-1"></i> Ubatizo wa Maji Mengi</div>
                    <div><i class="bi bi-check-circle-fill text-warning me-1"></i> Kujazwa Roho Mtakatifu</div>
                    <div><i class="bi bi-check-circle-fill text-warning me-1"></i> Uponyaji & Kufunguliwa</div>
                </div>
            </div>

            <div class="col-lg-5">
                <!-- Countdown to Sunday Service -->
                <div class="card p-4 shadow-lg border-0" style="background: rgba(15, 23, 42, 0.85); backdrop-filter: blur(16px); border-radius: 24px; border: 1px solid rgba(255,255,255,0.15);">
                    <div class="d-flex align-items-center gap-2 mb-3 text-warning">
                        <i class="bi bi-clock-history fs-4"></i>
                        <h6 class="fw-bold mb-0 text-white">Ibada Inayofuata ya Jumapili</h6>
                    </div>
                    <p class="small text-white-50 mb-4">
                        Jiunge nasi hekalu kuu la EAGT Golani kwa ibada ya pekee ya sifa, kuabudu, Meza ya Bwana na Neno lenye mguso wa Roho Mtakatifu.
                    </p>

                    <div class="row g-2 mb-4">
                        <div class="col-3">
                            <div class="countdown-box">
                                <div class="countdown-num" id="cd-days">02</div>
                                <div class="countdown-label">Siku</div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="countdown-box">
                                <div class="countdown-num" id="cd-hours">14</div>
                                <div class="countdown-label">Masaa</div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="countdown-box">
                                <div class="countdown-num" id="cd-mins">45</div>
                                <div class="countdown-label">Dakika</div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="countdown-box">
                                <div class="countdown-num" id="cd-secs">30</div>
                                <div class="countdown-label">Sekunde</div>
                            </div>
                        </div>
                    </div>

                    <div class="p-3 rounded-3 bg-white bg-opacity-10 text-white small mb-3">
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <i class="bi bi-calendar3 text-warning"></i>
                            <strong>Kila Jumapili:</strong> Saa 02:30 Asubuhi - 06:30 Mchana
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-geo-alt text-warning"></i>
                            <span>Hekalu Kuu - Mtaa wa Golani, Kimara-Suka</span>
                        </div>
                    </div>

                    <a href="#maombi" class="btn btn-warning w-100 fw-bold rounded-pill text-dark">
                        <i class="bi bi-send-fill me-1"></i> Wasiliana na Wachungaji
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Official Banner & Social Media Connection Bar -->
<section class="bg-white py-3 border-bottom shadow-sm">
    <div class="container">
        <div class="row align-items-center gy-3">
            <div class="col-lg-6 text-center text-lg-start">
                <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start gap-3">
                    <img src="{{ asset('assets/images/eagt_golani_banner.jpg') }}" alt="EAGT Golani Christian Center" class="img-fluid rounded-3 shadow-sm bg-light p-1" style="max-height: 82px; object-fit: contain;">
                </div>
            </div>
            <div class="col-lg-6 text-center text-lg-end">
                <div class="d-inline-flex flex-column align-items-center align-items-lg-end gap-2">
                    <div class="d-flex flex-wrap justify-content-center justify-content-lg-end gap-2">
                        <span class="badge bg-warning text-dark px-3 py-1 rounded-pill fw-bold">
                            <i class="bi bi-geo-alt-fill me-1"></i> Kimara-Suka, Golani
                        </span>
                        <span class="badge bg-primary px-3 py-1 rounded-pill fw-bold">
                            <i class="bi bi-shield-check me-1"></i> Kanisa la Pentekoste
                        </span>
                    </div>
                    <div class="d-flex flex-wrap justify-content-center justify-content-lg-end gap-2">
                        <a href="https://youtube.com/@eagt_golani?si=MQXrKVblnH6E7A7H" target="_blank" rel="noopener" class="btn btn-sm btn-outline-danger rounded-pill px-3 py-1 fw-bold" style="font-size: 0.8rem;">
                            <i class="bi bi-youtube me-1"></i> YouTube
                        </a>
                        <a href="https://www.tiktok.com/@eagt.golani?_r=1&_t=ZS-9AijKazxKBY" target="_blank" rel="noopener" class="btn btn-sm btn-outline-dark rounded-pill px-3 py-1 fw-bold" style="font-size: 0.8rem;">
                            <i class="bi bi-tiktok me-1"></i> TikTok
                        </a>
                        <a href="https://www.facebook.com/profile.php?id=61585945186115" target="_blank" rel="noopener" class="btn btn-sm btn-outline-primary rounded-pill px-3 py-1 fw-bold" style="font-size: 0.8rem;">
                            <i class="bi bi-facebook me-1"></i> Facebook
                        </a>
                        <a href="https://www.instagram.com/eagt_golani?rpxt=amU0Y3R5a2FlYWJ5" target="_blank" rel="noopener" class="btn btn-sm rounded-pill px-3 py-1 fw-bold text-white shadow-sm" style="font-size: 0.8rem; background: linear-gradient(45deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888);">
                            <i class="bi bi-instagram me-1"></i> Instagram
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 4. Flash Success Message for Prayer Request -->
@if(session('prayer_success'))
    <div class="container mt-4">
        <div class="alert alert-success alert-dismissible fade show shadow-sm rounded-4 p-4 border-0" role="alert" style="background: #ecfdf5; border-left: 6px solid #10b981 !important;">
            <div class="d-flex align-items-center gap-3">
                <i class="bi bi-check-circle-fill text-success fs-1"></i>
                <div>
                    <h5 class="fw-bold text-success mb-1">Hitaji Lako Limepokelewa!</h5>
                    <p class="mb-0 text-dark">{{ session('prayer_success') }}</p>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
@endif

<!-- 4b. Ujumbe wa Mchungaji Kiongozi Lukas J. Kittu -->
<section class="py-5 bg-white border-bottom">
    <div class="container py-4">
        <div class="card border-0 rounded-4 overflow-hidden shadow-lg" style="background: linear-gradient(135deg, #0b1329 0%, #1e3a8a 100%); color: #fff;">
            <div class="row g-0 align-items-center">
                <div class="col-lg-5">
                    <div class="position-relative h-100" style="min-height: 440px;">
                        <img src="{{ asset('assets/images/pastor_lukas_kittu_preaching.jpg') }}" alt="Mchungaji Lukas J. Kittu - EAGT Golani" class="w-100 h-100 object-fit-cover" style="min-height: 440px;">
                        <div class="position-absolute bottom-0 start-0 end-0 p-3" style="background: linear-gradient(180deg, transparent 0%, rgba(11, 19, 41, 0.95) 100%);">
                            <span class="badge bg-warning text-dark fw-bold px-3 py-1 rounded-pill">
                                <i class="bi bi-mic-fill me-1"></i> Mchungaji Kiongozi
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7 p-4 p-md-5">
                    <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold mb-3">
                        <i class="bi bi-award-fill me-1"></i> UONGOZI WA KICHUNGAJI
                    </span>
                    <h2 class="fw-bold mb-2" style="font-size: 2.3rem;">
                        Karibu Hekaluni EAGT Golani Christian Center
                    </h2>
                    <h5 class="text-warning mb-3 fw-bold">Mchungaji Lukas J. Kittu — Mchungaji Kiongozi</h5>
                    <p class="text-white-50 mb-4" style="line-height: 1.8; font-size: 1.02rem;">
                        "Namshukuru Mungu aliyetuita katika wakati kama huu kupeleka ujumbe safi wa Neno la Msalaba lenye nguvu ya kuokoa, kufungua waliofungwa na kuponya wagonjwa. Kanisa la EAGT Golani lipo Kimara-Suka kama hekalu la makimbilio, sifa na uwepo halisi wa Roho Mtakatifu. Karibu ushiriki nasi Jumapili na katikati ya juma!"
                    </p>
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <div class="p-3 bg-white bg-opacity-10 rounded-3 border border-white border-opacity-15">
                                <strong class="text-warning d-block mb-1"><i class="bi bi-geo-alt-fill me-1"></i> Mahali Tulipo:</strong>
                                <small class="text-white-50 d-block">Kimarasuka Golani Madoxi kuelekea Casino, Dar es Salaam</small>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="p-3 bg-white bg-opacity-10 rounded-3 border border-white border-opacity-15">
                                <strong class="text-warning d-block mb-1"><i class="bi bi-telephone-fill me-1"></i> Ushauri wa Kichungaji:</strong>
                                <small class="text-white-50 d-block">+255 754 123 456 / pastor@eagt.org</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 5. Misingi ya Imani ya Kipentekoste (Pentecostal Creed) -->
<section id="kuhusu" class="py-5 bg-light border-bottom">
    <div class="container py-4">
        <div class="section-header">
            <span class="section-tag">Kanisa la Kipentekoste</span>
            <h2 class="section-title">Misingi ya Imani ya EAGT</h2>
            <p class="text-muted">
                Kama Kanisa la Kipentekoste la EVANGELIST ASSEMBLIES OF GOD TANZANIA, tunasimamia mafundisho safi ya Neno la Mungu (Biblia Takatifu) bila kufuata taratibu au mila za kiliturujia za kiroma.
            </p>
        </div>

        <div class="row g-4">
            <div class="col-md-6 col-lg-4">
                <div class="pillar-card shadow-sm">
                    <div class="feature-icon-circle bg-primary bg-opacity-10 text-primary">
                        <i class="bi bi-book-half"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-2">1. Wokovu kwa Neema</h5>
                    <p class="text-muted small mb-0">
                        Mwanadamu anahesabiwa haki kwa njia ya toba na kumwamini Yesu Kristo kama Bwana na Mwokozi kwa imani, na si kwa matendo au ibada za kidini za wanadamu.
                    </p>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="pillar-card shadow-sm">
                    <div class="feature-icon-circle bg-warning bg-opacity-10 text-warning">
                        <i class="bi bi-water"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-2">2. Ubatizo wa Maji Mengi</h5>
                    <p class="text-muted small mb-0">
                        Tunabatiza kwa maji mengi (kuzamishwa kabisa) mtu mzima anayeamini, kwa jina la Baba, Mwana na Roho Mtakatifu, kama ushahidi wa kufa na kufufuka pamoja na Kristo.
                    </p>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="pillar-card shadow-sm">
                    <div class="feature-icon-circle bg-danger bg-opacity-10 text-danger">
                        <i class="bi bi-fire"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-2">3. Kujazwa Roho Mtakatifu</h5>
                    <p class="text-muted small mb-0">
                        Tunasadiki ubatizo wa Roho Mtakatifu wenye uthibitisho wa kunena kwa lugha mpya (Matendo 2:4) na kutembea katika nguvu na karama zake takatifu.
                    </p>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="pillar-card shadow-sm">
                    <div class="feature-icon-circle bg-success bg-opacity-10 text-success">
                        <i class="bi bi-heart-pulse-fill"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-2">4. Uponyaji na Kufunguliwa</h5>
                    <p class="text-muted small mb-0">
                        Uponyaji wa kimungu na ukombozi wa roho, nafsi na mwili umetolewa katika upatanisho wa Msalaba wa Kristo kupitia maombi ya imani na kuwekewa mikono.
                    </p>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="pillar-card shadow-sm">
                    <div class="feature-icon-circle bg-info bg-opacity-10 text-info">
                        <i class="bi bi-cup-hot-fill"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-2">5. Meza ya Bwana</h5>
                    <p class="text-muted small mb-0">
                        Kushiriki mkate na kikombe cha agano jipya kama ukumbusho mtakatifu wa mateso, kifo na ushindi wa Bwana wetu Yesu Kristo mpaka ajapo.
                    </p>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="pillar-card shadow-sm">
                    <div class="feature-icon-circle bg-purple bg-opacity-10 text-primary">
                        <i class="bi bi-cloud-sun-fill"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-2">6. Ujio wa Pili wa Kristo</h5>
                    <p class="text-muted small mb-0">
                        Unyakuo wa kanisa na kurudi kwa Bwana Yesu Kristo kwa utukufu mkuu kuanzisha ufalme wake wa milele usio na mwisho.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 6. Ratiba za Ibada za Kanisa -->
<section id="ratiba" class="py-5">
    <div class="container py-4">
        <div class="section-header">
            <span class="section-tag">Ratiba za Kanisa</span>
            <h2 class="section-title">Ibada na Vipindi vya Kiroho</h2>
            <p class="text-muted">Karibu ushiriki nasi katika ibada za nguvu hekalu la EAGT Golani, Kimara-Suka.</p>
        </div>

        <div class="row g-4">
            @forelse($services as $svc)
                <div class="col-lg-4 col-md-6">
                    <div class="service-card d-flex flex-column justify-content-between">
                        <div>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2 rounded-pill fw-bold">
                                    {{ $svc->day_of_week }}
                                </span>
                                <span class="badge bg-warning-subtle text-warning border px-2 py-1">
                                    <i class="bi bi-clock me-1"></i> {{ date('h:i A', strtotime($svc->start_time)) }}
                                </span>
                            </div>

                            <h4 class="fw-bold text-dark mb-2">{{ $svc->title }}</h4>
                            <p class="text-muted small mb-4" style="line-height: 1.6;">
                                {{ $svc->description }}
                            </p>
                        </div>

                        <div class="border-top pt-3 text-muted small">
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <i class="bi bi-geo-alt-fill text-danger"></i>
                                <span>{{ $svc->location ?? 'Hekalu Kuu la EAGT Golani' }}</span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-hourglass-split text-primary"></i>
                                <span>Muda: {{ date('h:i A', strtotime($svc->start_time)) }} - {{ date('h:i A', strtotime($svc->end_time)) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-4 text-muted">
                    Ratiba za ibada zitasasishwa hivi karibuni.
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- 7. Idara za Kanisa (Ministries: CGM, CWI, Ujenzi, WWK, n.k.) -->
<section id="idara" class="py-5 bg-light">
    <div class="container py-4">
        <div class="section-header">
            <span class="section-tag">Umoja wa Huduma</span>
            <h2 class="section-title">Idara za Kanisa EAGT Golani</h2>
            <p class="text-muted">Kila mshirika ana nafasi ya kulelewa na kutumika kulingana na wito wake katika idara zetu za kanisa.</p>
        </div>

        <!-- 1. Picha ya Sifa na Kuabudu / Ebeneza Revival Choir -->
        <div class="card border-0 rounded-4 overflow-hidden shadow mb-4">
            <div class="row g-0 align-items-center">
                <div class="col-lg-6">
                    <img src="{{ asset('assets/images/worship_soloist_choir_leading.jpg') }}" alt="Ebeneza Revival Choir EAGT Golani" class="w-100 h-100 object-fit-cover" style="min-height: 350px;">
                </div>
                <div class="col-lg-6 p-4 p-md-5">
                    <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold mb-2">EBENEZA REVIVAL CHOIR & SIFA</span>
                    <h3 class="fw-bold text-dark mb-2">Ebeneza Revival Choir (ERC) & Timu ya Sifa</h3>
                    <p class="text-muted" style="line-height: 1.7;">
                        Kwaya Kuu ya Ebeneza Revival Choir (ERC) pamoja na Timu ya Sifa inaongoza kanisa katika sifa za kuinua mioyo, kuabudu kwa kina na kufungua uwepo wa Roho Mtakatifu. Kwaya imezindua albamu rasmi ya <strong>"Mungu ni Mwema"</strong> kwa ajili ya uinjilisti.
                    </p>
                    <div class="d-flex flex-wrap gap-3 mt-3">
                        <div class="p-3 bg-white rounded-3 border">
                            <strong class="text-primary d-block">Mazoezi ya Kwaya</strong>
                            <small class="text-muted">Kila Alhamisi & Jumamosi Saa 10:30 Jioni</small>
                        </div>
                        <div class="p-3 bg-white rounded-3 border">
                            <strong class="text-danger d-block">Albamu Mpya</strong>
                            <small class="text-muted">"Mungu ni Mwema" (ERC Golani)</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. Picha ya Wanawake wa Kristo (WWK) -->
        <div class="card border-0 rounded-4 overflow-hidden shadow mb-4">
            <div class="row g-0 align-items-center flex-lg-row-reverse">
                <div class="col-lg-6">
                    <img src="{{ asset('assets/images/worship_women_congregation.jpg') }}" alt="WWK - Wanawake wa Kristo EAGT Golani" class="w-100 h-100 object-fit-cover" style="min-height: 350px;">
                </div>
                <div class="col-lg-6 p-4 p-md-5">
                    <span class="badge bg-danger text-white px-3 py-2 rounded-pill fw-bold mb-2">WANAWAKE WA KRISTO (WWK)</span>
                    <h3 class="fw-bold text-dark mb-2">Idara ya Wanawake wa Kristo (WWK)</h3>
                    <p class="text-muted" style="line-height: 1.7;">
                        Idara ya kina mama na mabinti inayosimamia maombi ya kina ya familia, uinjilisti wa nyumba kwa nyumba, kutembelea wagonjwa na wajane, na kulea mabinti katika heshima na hofu ya Mungu.
                    </p>
                    <div class="d-flex flex-wrap gap-3 mt-3">
                        <div class="p-3 bg-white rounded-3 border">
                            <strong class="text-danger d-block">Maombi ya Akina Mama</strong>
                            <small class="text-muted">Kila Jumanne Saa 09:00 Alasiri</small>
                        </div>
                        <div class="p-3 bg-white rounded-3 border">
                            <strong class="text-primary d-block">Kiongozi wa WWK</strong>
                            <small class="text-muted">Mama Mchungaji Neema Mwambungu</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3. Picha ya Umoja wa Wanaume wa Imani -->
        <div class="card border-0 rounded-4 overflow-hidden shadow mb-4">
            <div class="row g-0 align-items-center">
                <div class="col-lg-6">
                    <img src="{{ asset('assets/images/men_fellowship_wanaume_imani.jpg') }}" alt="Umoja wa Wanaume wa Imani EAGT Golani" class="w-100 h-100 object-fit-cover" style="min-height: 350px;">
                </div>
                <div class="col-lg-6 p-4 p-md-5">
                    <span class="badge bg-primary text-white px-3 py-2 rounded-pill fw-bold mb-2">UMOJA WA WANAUME WA IMANI</span>
                    <h3 class="fw-bold text-dark mb-2">Umoja wa Wanaume wa Imani & Wazee wa Kanisa</h3>
                    <p class="text-muted" style="line-height: 1.7;">
                        Wanaume na wazee wa hekalu wakisimama kama nguzo kuu ya kiroho, maombi ya madhabahuni, ushauri, kulea vijana na kuongoza miradi ya maendeleo na ujenzi wa kanisa kuu la EAGT Golani.
                    </p>
                    <div class="d-flex flex-wrap gap-3 mt-3">
                        <div class="p-3 bg-white rounded-3 border">
                            <strong class="text-primary d-block">Vikao vya Wanaume</strong>
                            <small class="text-muted">Kila Jumapili ya Mwisho wa Mwezi</small>
                        </div>
                        <div class="p-3 bg-white rounded-3 border">
                            <strong class="text-dark d-block">Mwenyekiti wa Wanaume</strong>
                            <small class="text-muted">Mzee Daudi Makundi</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 4. Picha ya Vijana CGM -->
        <div class="card border-0 rounded-4 overflow-hidden shadow mb-4">
            <div class="row g-0 align-items-center flex-lg-row-reverse">
                <div class="col-lg-6">
                    <img src="{{ asset('assets/images/cgm_youth_choir_uniform.jpg') }}" alt="CGM Vijana EAGT Golani" class="w-100 h-100 object-fit-cover" style="min-height: 350px;">
                </div>
                <div class="col-lg-6 p-4 p-md-5">
                    <span class="badge bg-success text-white px-3 py-2 rounded-pill fw-bold mb-2">CGM - CHRIST GOSPEL MESSENGERS</span>
                    <h3 class="fw-bold text-dark mb-2">Idara ya Vijana (CGM Golani)</h3>
                    <p class="text-muted" style="line-height: 1.7;">
                        Jeshi la vijana wa Pentekoste lililo tayari kwa ajili ya uinjilisti wa mijini na vijijini, kambi za vijana, kwaya ya vijana na semina za stadi za maisha na uongozi bora.
                    </p>
                    <div class="d-flex flex-wrap gap-3 mt-3">
                        <div class="p-3 bg-white rounded-3 border">
                            <strong class="text-success d-block">Ibada ya Vijana</strong>
                            <small class="text-muted">Kila Jumamosi Saa 10:00 Jioni</small>
                        </div>
                        <div class="p-3 bg-white rounded-3 border">
                            <strong class="text-primary d-block">Kiongozi wa CGM</strong>
                            <small class="text-muted">Kaka Baraka Mwakyoma</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 5. Picha ya CWI Watoto (Sunday School) -->
        <div class="card border-0 rounded-4 overflow-hidden shadow mb-5">
            <div class="row g-0 align-items-center">
                <div class="col-lg-6">
                    <img src="{{ asset('assets/images/cwi_children_sunday_school.jpg') }}" alt="CWI Sunday School Watoto EAGT Golani" class="w-100 h-100 object-fit-cover" style="min-height: 350px;">
                </div>
                <div class="col-lg-6 p-4 p-md-5">
                    <span class="badge bg-info text-white px-3 py-2 rounded-pill fw-bold mb-2">CWI - IDARA YA WATOTO</span>
                    <h3 class="fw-bold text-dark mb-2">CWI Watoto (Sunday School)</h3>
                    <p class="text-muted" style="line-height: 1.7;">
                        Watoto wetu wanalelewa tangu wadogo katika hofu ya Mungu, Neno, uimbaji na maadili safi ya Kikristo. Kila Jumapili asubuhi watoto wakiwa na walimu wao wanapata mafundisho yanayoendana na rika zao.
                    </p>
                    <div class="d-flex flex-wrap gap-3 mt-3">
                        <div class="p-3 bg-white rounded-3 border">
                            <strong class="text-info d-block">Sunday School</strong>
                            <small class="text-muted">Kila Jumapili Saa 08:30 Asubuhi</small>
                        </div>
                        <div class="p-3 bg-white rounded-3 border">
                            <strong class="text-success d-block">Mwalimu Kiongozi</strong>
                            <small class="text-muted">Mwalimu Zawadi Mollel</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            @foreach($departments as $dept)
                <div class="col-md-6 col-lg-4">
                    <div class="dept-card p-4 d-flex flex-column justify-content-between">
                        <div>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="badge rounded-pill px-3 py-1" style="background: {{ $dept->banner_color }}15; color: {{ $dept->banner_color }}; font-weight: 700;">
                                    {{ $dept->name }}
                                </span>
                            </div>
                            <h5 class="fw-bold text-dark mb-2">{{ $dept->name }}</h5>
                            <p class="text-muted small mb-3" style="line-height: 1.6;">
                                {{ Str::limit($dept->description, 130) }}
                            </p>
                        </div>

                        <div class="border-top pt-3 small text-muted">
                            <div class="mb-1"><i class="bi bi-person-fill text-primary me-1"></i> Kiongozi: <strong>{{ $dept->leader_name ?? 'Uongozi wa Idara' }}</strong></div>
                            @if($dept->meeting_day)
                                <div><i class="bi bi-calendar-event text-warning me-1"></i> {{ $dept->meeting_day }} saa {{ $dept->meeting_time ?? 'Kupangwa' }}</div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- 7b. Tukio Maalum: Uzinduzi wa Albamu Kuu ya Kwaya (ERC) -->
<section id="uzinduzi" class="py-5 bg-white border-bottom">
    <div class="container py-4">
        <div class="card border-0 rounded-4 overflow-hidden shadow-lg" style="background: linear-gradient(135deg, #1e1b4b 0%, #312e81 50%, #4338ca 100%); color: #fff;">
            <div class="row g-0 align-items-center">
                <div class="col-lg-5 text-center p-4 p-md-5">
                    <img src="{{ asset('assets/images/ebeneza_choir_album_launch.jpg') }}" alt="Uzinduzi wa Album Mungu ni Mwema - Ebeneza Revival Choir" class="img-fluid rounded-4 shadow-lg border border-white border-opacity-25" style="max-height: 480px; object-fit: contain;">
                </div>
                <div class="col-lg-7 p-4 p-md-5">
                    <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
                        <span class="badge bg-danger px-3 py-2 rounded-pill fw-bold">
                            <i class="bi bi-disc-fill me-1"></i> UZINDUZI WA ALBUM MPYA
                        </span>
                        <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold">
                            <i class="bi bi-stars me-1"></i> EBENEZA REVIVAL CHOIR (ERC)
                        </span>
                    </div>
                    <h2 class="fw-bold mb-3 display-6">
                        Uzinduzi Rasmi wa Albamu: <span class="text-warning">"Mungu Ni Mwema"</span>
                    </h2>
                    <p class="text-white-50 mb-4" style="line-height: 1.8; font-size: 1.05rem;">
                        Kanisa la Pentekoste la <strong>EAGT Golani Christian Center</strong> linakukaribisha kwa furaha katika tamasha na uzinduzi mkubwa wa albamu ya sifa na kuabudu kutoka kwa Kwaya Kuu ya <strong>Ebeneza Revival Choir (ERC)</strong> chini ya uongozi na baraka za <strong>Mchungaji Lukas J. Kittu</strong>.
                    </p>

                    <div class="row g-3 mb-4">
                        <div class="col-sm-6">
                            <div class="p-3 bg-white bg-opacity-10 rounded-3 border border-white border-opacity-15">
                                <strong class="text-warning d-block mb-1"><i class="bi bi-calendar-event me-2"></i> Tarehe & Muda:</strong>
                                <span class="text-white fw-bold">14 Juni 2026</span> • <span class="text-white-50">Kuanzia Saa 07:00 Mchana</span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="p-3 bg-white bg-opacity-10 rounded-3 border border-white border-opacity-15">
                                <strong class="text-warning d-block mb-1"><i class="bi bi-geo-alt-fill me-2"></i> Mahali pa Tukio:</strong>
                                <span class="text-white fw-bold">Hekalu la EAGT Golani</span>
                                <small class="text-white-50 d-block">Kimarasuka Golani Madoxi kuelekea Casino</small>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex flex-wrap gap-3">
                        <a href="#mawasiliano" class="btn btn-warning rounded-pill px-4 py-2 fw-bold text-dark shadow">
                            <i class="bi bi-telephone-fill me-2"></i> Mawasiliano & Maelekezo
                        </a>
                        <a href="#picha" class="btn btn-outline-light rounded-pill px-4 py-2 fw-bold">
                            <i class="bi bi-images me-2"></i> Picha za Kwaya
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 8. Mradi Mkuu wa Ujenzi na Maendeleo ya Kanisa -->
<section id="ujenzi" class="py-5">
    <div class="container py-4">
        <div class="card border-0 rounded-4 overflow-hidden shadow-lg" style="background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 100%); color: #fff;">
            <div class="row g-0 align-items-center">
                <div class="col-lg-6 p-4 p-md-5">
                    <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold mb-3">
                        <i class="bi bi-hammer me-1"></i> IDARA YA UJENZI NA MAENDELEO YA KANISA
                    </span>
                    <h2 class="fw-bold mb-3" style="font-size: 2.3rem;">
                        Ujenzi wa Hekalu Jipya la Ghorofa - EAGT Golani
                    </h2>
                    <p class="text-white-50 mb-4" style="line-height: 1.7;">
                        Kanisa lipo katika mradi mkubwa wa ujenzi wa Hekalu la kisasa litakalochukua waumini zaidi ya 1,200, vyumba vya mafundisho ya watoto (CWI), ofisi za wachungaji na ukumbi wa vijana (CGM).
                    </p>

                    <!-- Progress Bar -->
                    @php
                        $mainProject = $projects->first();
                        $targetCost = $mainProject ? $mainProject->estimated_cost : 150000000;
                        $raised = $mainProject ? $mainProject->raised_amount : 84500000;
                        $percent = $mainProject ? $mainProject->progressPercent() : 56;
                    @endphp
                    <div class="mb-4 p-3 bg-white bg-opacity-10 rounded-3 border border-white border-opacity-15">
                        <div class="d-flex justify-content-between small fw-bold mb-2">
                            <span>Michango Iliyopatikana:</span>
                            <span class="text-warning">Tsh {{ number_format($raised) }} ({{ $percent }}%)</span>
                        </div>
                        <div class="progress" style="height: 12px; border-radius: 6px;">
                            <div class="progress-bar bg-warning progress-bar-striped progress-bar-animated" style="width: {{ $percent }}%;"></div>
                        </div>
                        <div class="d-flex justify-content-between small text-white-50 mt-2">
                            <span>Lengo: Tsh {{ number_format($targetCost) }}</span>
                            <span>Bado: Tsh {{ number_format(max(0, $targetCost - $raised)) }}</span>
                        </div>
                    </div>

                    <!-- Giving Details -->
                    <h6 class="fw-bold text-warning mb-2"><i class="bi bi-wallet2 me-1"></i> Njia za Kutoa Sadaka na Michango ya Ujenzi:</h6>
                    <div class="row g-2 small text-white">
                        <div class="col-sm-6">
                            <div class="p-2 rounded bg-black bg-opacity-25 border border-white border-opacity-10">
                                <strong>M-Pesa / Tigo Pesa:</strong><br>
                                <span class="text-warning fw-bold">Lipa Namba: 5544332</span> (EAGT Golani)
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="p-2 rounded bg-black bg-opacity-25 border border-white border-opacity-10">
                                <strong>Akaunti ya Benki (NMB):</strong><br>
                                <span class="text-warning fw-bold">20810012345</span> (EAGT Golani Ujenzi)
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <img src="{{ asset('assets/images/church_building.jpg') }}" alt="Hekalu la EAGT Golani" class="w-100 h-100 object-fit-cover" style="min-height: 480px;">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 8b. Picha za Matukio Halisi ya Kanisa (Photo Gallery) -->
<section id="picha" class="py-5 bg-white border-top">
    <div class="container py-4">
        <div class="section-header">
            <span class="section-tag"><i class="bi bi-camera-fill me-1"></i> MATUKIO NA PICHA HALISI</span>
            <h2 class="section-title">Picha za Kanisa Hekaluni EAGT Golani</h2>
            <p class="text-muted">
                Tazama picha halisi za ibada, huduma ya sifa, ushirika wa waumini na shughuli za kiroho katika Kanisa Kuu la EAGT Golani, Kimara-Suka.
            </p>
        </div>

        <div class="row g-4">
            <!-- 1. Mchungaji Lukas J. Kittu -->
            <div class="col-md-6 col-lg-4">
                <div class="church-gallery-card">
                    <div class="gallery-img-container">
                        <img src="{{ asset('assets/images/pastor_lukas_kittu_preaching.jpg') }}" alt="Mchungaji Lukas J. Kittu Akihubiri" class="church-gallery-img">
                        <span class="position-absolute top-0 start-0 m-3 badge bg-warning text-dark fw-bold px-3 py-2 rounded-pill shadow-sm">
                            <i class="bi bi-mic-fill me-1"></i> Mchungaji Kiongozi
                        </span>
                    </div>
                    <div class="p-4 flex-grow-1 d-flex flex-column justify-content-between">
                        <div>
                            <h5 class="fw-bold text-dark mb-1">Mchungaji Lukas J. Kittu Akihubiri</h5>
                            <p class="text-muted small mb-0" style="line-height: 1.6;">
                                Neno la Msalaba lenye nguvu ya Roho Mtakatifu likihubiriwa wakati wa ibada kuu ya Jumapili hekalu la Golani.
                            </p>
                        </div>
                        <div class="pt-3 border-top mt-3 text-muted small d-flex justify-content-between">
                            <span><i class="bi bi-person-badge text-danger me-1"></i> Mch. Lukas J. Kittu</span>
                            <span class="text-primary fw-semibold">Ibada ya Jumapili</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. Ebeneza Revival Choir Soloist -->
            <div class="col-md-6 col-lg-4">
                <div class="church-gallery-card">
                    <div class="gallery-img-container">
                        <img src="{{ asset('assets/images/worship_soloist_choir_leading.jpg') }}" alt="Ebeneza Revival Choir EAGT Golani" class="church-gallery-img">
                        <span class="position-absolute top-0 start-0 m-3 badge bg-danger text-white fw-bold px-3 py-2 rounded-pill shadow-sm">
                            <i class="bi bi-music-note-beamed me-1"></i> Ebeneza Revival Choir
                        </span>
                    </div>
                    <div class="p-4 flex-grow-1 d-flex flex-column justify-content-between">
                        <div>
                            <h5 class="fw-bold text-dark mb-1">Uimbaji & Kuabudu kwa Kina</h5>
                            <p class="text-muted small mb-0" style="line-height: 1.6;">
                                Mwimbaji kiongozi akiongoza Ebeneza Revival Choir (ERC) na kusanyiko katika uwepo wa pekee wa Mungu.
                            </p>
                        </div>
                        <div class="pt-3 border-top mt-3 text-muted small d-flex justify-content-between">
                            <span><i class="bi bi-award-fill text-warning me-1"></i> ERC Kwaya Kuu</span>
                            <span class="text-success fw-semibold">Sifa & Kuabudu</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 3. Watoto wa Sunday School CWI -->
            <div class="col-md-6 col-lg-4">
                <div class="church-gallery-card">
                    <div class="gallery-img-container">
                        <img src="{{ asset('assets/images/cwi_children_sunday_school.jpg') }}" alt="Watoto wa Sunday School CWI EAGT Golani" class="church-gallery-img">
                        <span class="position-absolute top-0 start-0 m-3 badge bg-info text-white fw-bold px-3 py-2 rounded-pill shadow-sm">
                            <i class="bi bi-balloon-heart-fill me-1"></i> CWI Watoto
                        </span>
                    </div>
                    <div class="p-4 flex-grow-1 d-flex flex-column justify-content-between">
                        <div>
                            <h5 class="fw-bold text-dark mb-1">Watoto wa Sunday School (CWI)</h5>
                            <p class="text-muted small mb-0" style="line-height: 1.6;">
                                Watoto wakiwa katika sare zao nadhifu za Sunday School pamoja na walimu wao wakilelewa katika misingi ya Neno.
                            </p>
                        </div>
                        <div class="pt-3 border-top mt-3 text-muted small d-flex justify-content-between">
                            <span><i class="bi bi-heart-fill text-danger me-1"></i> Sunday School</span>
                            <span class="text-info fw-bold">Rika la Watoto</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 4. Umoja wa Wanaume wa Imani -->
            <div class="col-md-6 col-lg-4">
                <div class="church-gallery-card">
                    <div class="gallery-img-container">
                        <img src="{{ asset('assets/images/men_fellowship_wanaume_imani.jpg') }}" alt="Umoja wa Wanaume wa Imani EAGT Golani" class="church-gallery-img">
                        <span class="position-absolute top-0 start-0 m-3 badge bg-primary text-white fw-bold px-3 py-2 rounded-pill shadow-sm">
                            <i class="bi bi-people-fill me-1"></i> Wanaume wa Imani
                        </span>
                    </div>
                    <div class="p-4 flex-grow-1 d-flex flex-column justify-content-between">
                        <div>
                            <h5 class="fw-bold text-dark mb-1">Wanaume wa Imani & Wazee wa Kanisa</h5>
                            <p class="text-muted small mb-0" style="line-height: 1.6;">
                                Wanaume na wazee wa hekalu wakiongoza nyimbo za vitabu na sifa madhabahuni, wakisimama kama nguzo ya kiroho.
                            </p>
                        </div>
                        <div class="pt-3 border-top mt-3 text-muted small d-flex justify-content-between">
                            <span><i class="bi bi-shield-fill text-primary me-1"></i> Wazee & Wanaume</span>
                            <span class="text-warning fw-bold">Umoja wa Huduma</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 5. Vijana wa CGM Sare -->
            <div class="col-md-6 col-lg-4">
                <div class="church-gallery-card">
                    <div class="gallery-img-container">
                        <img src="{{ asset('assets/images/cgm_youth_choir_uniform.jpg') }}" alt="Kwaya ya Vijana CGM EAGT Golani" class="church-gallery-img">
                        <span class="position-absolute top-0 start-0 m-3 badge bg-success text-white fw-bold px-3 py-2 rounded-pill shadow-sm">
                            <i class="bi bi-lightning-charge-fill me-1"></i> CGM Vijana
                        </span>
                    </div>
                    <div class="p-4 flex-grow-1 d-flex flex-column justify-content-between">
                        <div>
                            <h5 class="fw-bold text-dark mb-1">Kwaya ya Vijana CGM Katika Sare</h5>
                            <p class="text-muted small mb-0" style="line-height: 1.6;">
                                Vijana wa Christ Gospel Messengers wakimsifu Bwana kwa uimbaji wa moto, heshima na mavazi nadhifu.
                            </p>
                        </div>
                        <div class="pt-3 border-top mt-3 text-muted small d-flex justify-content-between">
                            <span><i class="bi bi-fire text-danger me-1"></i> Moto wa Uinjilisti</span>
                            <span class="text-success fw-bold">CGM Golani</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 6. Sifa za Shangwe na Kucheza -->
            <div class="col-md-6 col-lg-4">
                <div class="church-gallery-card">
                    <div class="gallery-img-container">
                        <img src="{{ asset('assets/images/joyful_praise_dancing_congregation.jpg') }}" alt="Sifa za Shangwe na Kucheza Hekaluni" class="church-gallery-img">
                        <span class="position-absolute top-0 start-0 m-3 badge bg-warning text-dark fw-bold px-3 py-2 rounded-pill shadow-sm">
                            <i class="bi bi-stars me-1"></i> Shangwe Hekaluni
                        </span>
                    </div>
                    <div class="p-4 flex-grow-1 d-flex flex-column justify-content-between">
                        <div>
                            <h5 class="fw-bold text-dark mb-1">Sifa za Shangwe na Kucheza</h5>
                            <p class="text-muted small mb-0" style="line-height: 1.6;">
                                Furaha ya Roho Mtakatifu ikifurika kanisani waumini na vijana wakimchezea Mungu kwa nguvu na vigelegele.
                            </p>
                        </div>
                        <div class="pt-3 border-top mt-3 text-muted small d-flex justify-content-between">
                            <span><i class="bi bi-emoji-smile-fill text-warning me-1"></i> Furaha ya Wokovu</span>
                            <span class="text-primary fw-semibold">Zaburi 150</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 7. Wanawake wa Kristo (WWK) -->
            <div class="col-md-6 col-lg-4">
                <div class="church-gallery-card">
                    <div class="gallery-img-container">
                        <img src="{{ asset('assets/images/worship_women_congregation.jpg') }}" alt="Wanawake wa Kristo WWK EAGT Golani" class="church-gallery-img">
                        <span class="position-absolute top-0 start-0 m-3 badge bg-danger text-white fw-bold px-3 py-2 rounded-pill shadow-sm">
                            <i class="bi bi-heart-fill me-1"></i> WWK Wanawake
                        </span>
                    </div>
                    <div class="p-4 flex-grow-1 d-flex flex-column justify-content-between">
                        <div>
                            <h5 class="fw-bold text-dark mb-1">Ushirika wa Akina Mama (WWK)</h5>
                            <p class="text-muted small mb-0" style="line-height: 1.6;">
                                Kina mama na washirika wakimshangilia Mungu kwa mikono juu na nyoyo zilizofunguliwa katika ibada ya Jumapili.
                            </p>
                        </div>
                        <div class="pt-3 border-top mt-3 text-muted small d-flex justify-content-between">
                            <span><i class="bi bi-people-fill text-danger me-1"></i> Kina Mama WWK</span>
                            <span class="text-success fw-semibold">Jumanne & Jumapili</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 8. Maombi ya Nguvu na Kufunguliwa -->
            <div class="col-md-6 col-lg-4">
                <div class="church-gallery-card">
                    <div class="gallery-img-container">
                        <img src="{{ asset('assets/images/prayer_service_congregation.jpg') }}" alt="Maombi ya Nguvu na Kufunguliwa" class="church-gallery-img">
                        <span class="position-absolute top-0 start-0 m-3 badge bg-primary text-white fw-bold px-3 py-2 rounded-pill shadow-sm">
                            <i class="bi bi-fire me-1"></i> Maombi & Maombezi
                        </span>
                    </div>
                    <div class="p-4 flex-grow-1 d-flex flex-column justify-content-between">
                        <div>
                            <h5 class="fw-bold text-dark mb-1">Mkesha na Kilio cha Maombi</h5>
                            <p class="text-muted small mb-0" style="line-height: 1.6;">
                                Maombi ya toba, ukombozi wa ndoa na uponyaji wa magonjwa katika uwepo na nguvu ya Roho Mtakatifu.
                            </p>
                        </div>
                        <div class="pt-3 border-top mt-3 text-muted small d-flex justify-content-between">
                            <span><i class="bi bi-shield-shaded text-primary me-1"></i> Mkesha wa Miujiza</span>
                            <span class="text-warning fw-semibold">Ijumaa 03:00 Usiku</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 9. Uzinduzi wa Albamu ya Ebeneza Choir -->
            <div class="col-md-6 col-lg-4">
                <div class="church-gallery-card">
                    <div class="gallery-img-container bg-light d-flex align-items-center justify-content-center p-2" style="height: 280px;">
                        <img src="{{ asset('assets/images/ebeneza_choir_album_launch.jpg') }}" alt="Uzinduzi wa Albamu Mungu ni Mwema" class="img-fluid rounded-3 shadow-sm" style="max-height: 270px; object-fit: contain;">
                        <span class="position-absolute top-0 start-0 m-3 badge bg-dark text-white fw-bold px-3 py-2 rounded-pill shadow-sm">
                            <i class="bi bi-disc-fill text-warning me-1"></i> Uzinduzi wa Albamu
                        </span>
                    </div>
                    <div class="p-4 flex-grow-1 d-flex flex-column justify-content-between">
                        <div>
                            <h5 class="fw-bold text-dark mb-1">Albamu: 'Mungu ni Mwema'</h5>
                            <p class="text-muted small mb-0" style="line-height: 1.6;">
                                Uzinduzi rasmi wa albamu ya Ebeneza Revival Choir (ERC) chini ya ulezi wa Mchungaji Lukas J. Kittu.
                            </p>
                        </div>
                        <div class="pt-3 border-top mt-3 text-muted small d-flex justify-content-between">
                            <span><i class="bi bi-disc text-primary me-1"></i> Ebeneza Choir (ERC)</span>
                            <span class="text-danger fw-bold">Albamu Mpya</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 10. Ushirika wa Vijana CGM wa Nje -->
            <div class="col-md-6 col-lg-4">
                <div class="church-gallery-card">
                    <div class="gallery-img-container">
                        <img src="{{ asset('assets/images/cgm_youth_fellowship.jpg') }}" alt="Ushirika wa Vijana CGM EAGT Golani" class="church-gallery-img">
                        <span class="position-absolute top-0 start-0 m-3 badge bg-success text-white fw-bold px-3 py-2 rounded-pill shadow-sm">
                            <i class="bi bi-people me-1"></i> Umoja wa Vijana
                        </span>
                    </div>
                    <div class="p-4 flex-grow-1 d-flex flex-column justify-content-between">
                        <div>
                            <h5 class="fw-bold text-dark mb-1">Ushirika wa Vijana CGM</h5>
                            <p class="text-muted small mb-0" style="line-height: 1.6;">
                                Vijana wa kike na kiume wakijumuika katika upendo, kambi za mafunzo na ushirika wa pamoja nje ya ibada.
                            </p>
                        </div>
                        <div class="pt-3 border-top mt-3 text-muted small d-flex justify-content-between">
                            <span><i class="bi bi-tree text-success me-1"></i> Kambi & Mafunzo</span>
                            <span class="text-primary fw-semibold">CGM Fellowship</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 11. Mchungaji Lukas J. Kittu - Ujumbe wa Msalaba -->
            <div class="col-md-6 col-lg-4">
                <div class="church-gallery-card">
                    <div class="gallery-img-container">
                        <img src="{{ asset('assets/images/pastor_preaching_red_tie.jpg') }}" alt="Mchungaji Lukas J. Kittu" class="church-gallery-img">
                        <span class="position-absolute top-0 start-0 m-3 badge bg-dark text-white fw-bold px-3 py-2 rounded-pill shadow-sm">
                            <i class="bi bi-bookmark-check-fill text-warning me-1"></i> Mahubiri
                        </span>
                    </div>
                    <div class="p-4 flex-grow-1 d-flex flex-column justify-content-between">
                        <div>
                            <h5 class="fw-bold text-dark mb-1">Ujumbe wa Msalaba na Uponyaji</h5>
                            <p class="text-muted small mb-0" style="line-height: 1.6;">
                                Mchungaji Lukas J. Kittu akifundisha kwa kina Neno la uzima lenye kuweka huru roho na miili ya watu wa Mungu.
                            </p>
                        </div>
                        <div class="pt-3 border-top mt-3 text-muted small d-flex justify-content-between">
                            <span><i class="bi bi-book-fill text-warning me-1"></i> Neno la Mungu</span>
                            <span class="text-dark fw-bold">EAGT Golani</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 12. Mradi wa Hekalu la Ghorofa -->
            <div class="col-md-6 col-lg-4">
                <div class="church-gallery-card">
                    <div class="gallery-img-container">
                        <img src="{{ asset('assets/images/church_building.jpg') }}" alt="Ujenzi wa Hekalu EAGT Golani" class="church-gallery-img">
                        <span class="position-absolute top-0 start-0 m-3 badge bg-success text-white fw-bold px-3 py-2 rounded-pill shadow-sm">
                            <i class="bi bi-hammer me-1"></i> Ujenzi wa Hekalu
                        </span>
                    </div>
                    <div class="p-4 flex-grow-1 d-flex flex-column justify-content-between">
                        <div>
                            <h5 class="fw-bold text-dark mb-1">Mradi wa Hekalu la Ghorofa</h5>
                            <p class="text-muted small mb-0" style="line-height: 1.6;">
                                Maendeleo ya ujenzi wa jengo jipya la kisasa la kanisa kuu la EAGT Golani litakalochukua waumini zaidi ya 1,200.
                            </p>
                        </div>
                        <div class="pt-3 border-top mt-3 text-muted small d-flex justify-content-between">
                            <span><i class="bi bi-building text-success me-1"></i> Mradi Unaendelea</span>
                            <span class="text-warning fw-semibold">Uongozi wa Ujenzi</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 9. Mahubiri na Vyombo vya Habari (YouTube Sermons) -->
<section id="mahubiri" class="py-5 bg-light">
    <div class="container py-4">
        <div class="section-header">
            <span class="section-tag">Chakula cha Kiroho</span>
            <h2 class="section-title">Mahubiri ya Neno la Mungu</h2>
            <p class="text-muted">Sikiliza na utazame mahubiri ya ukombozi, imani na nguvu ya Roho Mtakatifu kutoka hekalu la Golani.</p>
        </div>

        @if($video)
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                        <div class="ratio ratio-16x9">
                            <iframe src="https://www.youtube.com/embed/{{ $video->youtube_id }}" title="{{ $video->title }}" allowfullscreen></iframe>
                        </div>
                        <div class="p-4 bg-white">
                            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-3">
                                <div>
                                    <span class="badge bg-danger px-3 py-2 rounded-pill me-2">
                                        <i class="bi bi-youtube me-1"></i> Mahubiri ya EAGT Golani
                                    </span>
                                    <small class="text-muted"><i class="bi bi-person-fill text-primary me-1"></i> {{ $video->preacher_name ?? 'Mchungaji Lukas J. Kittu' }}</small>
                                </div>
                                <div class="d-flex flex-wrap gap-2">
                                    <a href="https://youtu.be/DGN4B4CFn3g?si=wWVp4S-zjOJqjY2M" target="_blank" rel="noopener" class="btn btn-outline-danger btn-sm rounded-pill px-3 fw-bold">
                                        <i class="bi bi-play-circle-fill me-1"></i> Tazama YouTube
                                    </a>
                                    <a href="https://youtube.com/@eagt_golani?si=MQXrKVblnH6E7A7H" target="_blank" rel="noopener" class="btn btn-danger btn-sm rounded-pill px-3 fw-bold text-white shadow-sm">
                                        <i class="bi bi-youtube me-1"></i> Jiunge na Chaneli (Subscribe)
                                    </a>
                                </div>
                            </div>
                            <h4 class="fw-bold text-dark mb-2">{{ $video->title }}</h4>
                            <p class="text-muted mb-0 small" style="line-height: 1.7;">{{ $video->description }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="card border-0 shadow-lg rounded-4 overflow-hidden bg-white">
                        <div class="row g-0 align-items-center">
                            <div class="col-lg-5">
                                <img src="{{ asset('assets/images/pastor_preaching_red_tie.jpg') }}" alt="Mchungaji Lukas J. Kittu Akihubiri" class="w-100 h-100 object-fit-cover" style="min-height: 360px;">
                            </div>
                            <div class="col-lg-7 p-4 p-md-5">
                                <span class="badge bg-danger text-white px-3 py-2 rounded-pill fw-bold mb-3">
                                    <i class="bi bi-mic-fill me-1"></i> NENO LA MSALABA
                                </span>
                                <h3 class="fw-bold text-dark mb-2">Ujumbe wa Uzima na Nguvu ya Roho Mtakatifu</h3>
                                <h6 class="text-primary mb-3 fw-bold">Mchungaji Lukas J. Kittu • Ibada ya Jumapili</h6>
                                <p class="text-muted" style="line-height: 1.8;">
                                    "Kwa maana neno la msalaba kwao wanaopotea ni upuzi; bali kwetu sisi tunaookolewa ni nguvu ya Mungu." — <strong>1 Wakorintho 1:18</strong>. Karibu ushiriki nasi hekaluni kupokea Neno lililovuviwa ambalo linabadilisha maisha, linavunja vifungo na kuleta uponyaji.
                                </p>
                                <div class="d-flex flex-wrap gap-2 mt-4">
                                    <a href="#ratiba" class="btn btn-warning rounded-pill px-4 py-2 fw-bold text-dark shadow-sm">
                                        <i class="bi bi-calendar-check-fill me-1"></i> Ratiba ya Ibada
                                    </a>
                                    <a href="#maombi" class="btn btn-outline-danger rounded-pill px-4 py-2 fw-semibold">
                                        <i class="bi bi-heart-fill me-1"></i> Ombi la Maombi
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>

<!-- 10. Shuhuda za Ushindi (Testimonies of Deliverance) -->
<section class="py-5">
    <div class="container py-4">
        <div class="section-header">
            <span class="section-tag">Matendo ya Mungu</span>
            <h2 class="section-title">Shuhuda za Kujibiwa Maombi</h2>
            <p class="text-muted">Mungu anayeponya, kufungua na kuokoa anatenda mambo makuu katika kanisa letu la EAGT Golani.</p>
        </div>

        <div class="row g-4">
            @forelse($testimonies as $t)
                <div class="col-md-4">
                    <div class="card p-4 border-0 rounded-4 shadow-sm h-100 bg-light">
                        <div class="text-warning mb-3 fs-3"><i class="bi bi-quote"></i></div>
                        <p class="text-dark small mb-3 fst-italic" style="line-height: 1.7;">
                            "{{ $t->testimony }}"
                        </p>
                        <div class="border-top pt-3 mt-auto">
                            <strong class="text-primary d-block">{{ $t->requester_name }}</strong>
                            <small class="text-muted">Hitaji: {{ $t->category }}</small>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-md-4">
                    <div class="card p-4 border-0 rounded-4 shadow-sm h-100 bg-light">
                        <div class="text-warning mb-3 fs-3"><i class="bi bi-quote"></i></div>
                        <p class="text-dark small mb-3 fst-italic" style="line-height: 1.7;">
                            "Baada ya maombi ya kufunga na kuomba ya siku tatu kanisani EAGT Golani, Mungu alifungua milango ya ajira na amani ikarejea kwenye familia yangu!"
                        </p>
                        <div class="border-top pt-3 mt-auto">
                            <strong class="text-primary d-block">Mshirika wa EAGT Golani</strong>
                            <small class="text-muted">Ushuhuda wa Ushindi</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card p-4 border-0 rounded-4 shadow-sm h-100 bg-light">
                        <div class="text-warning mb-3 fs-3"><i class="bi bi-quote"></i></div>
                        <p class="text-dark small mb-3 fst-italic" style="line-height: 1.7;">
                            "Nilikuwa naumwa kwa miezi sita bila nafuu. Baada ya maombezi ya kuwekewa mikono katika Mkesha wa Ijumaa wa Miujiza, Bwana aliniponya kabisa!"
                        </p>
                        <div class="border-top pt-3 mt-auto">
                            <strong class="text-primary d-block">Dada Mshirika</strong>
                            <small class="text-muted">Uponyaji wa Kimungu</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card p-4 border-0 rounded-4 shadow-sm h-100 bg-light">
                        <div class="text-warning mb-3 fs-3"><i class="bi bi-quote"></i></div>
                        <p class="text-dark small mb-3 fst-italic" style="line-height: 1.7;">
                            "Namshukuru Mungu kwa ulinzi wake mkuu na kufanikisha watoto wangu wote kuanza masomo kwa neema na amani ya Kristo."
                        </p>
                        <div class="border-top pt-3 mt-auto">
                            <strong class="text-primary d-block">Familia ya Kikristo</strong>
                            <small class="text-muted">Ushuhuda wa Shukrani</small>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- 11. Wasilisha Hitaji Lako la Maombi (Direct Prayer Request Form) -->
<section id="maombi" class="py-5 bg-light border-top">
    <div class="container py-4">
        <div class="row g-4 align-items-stretch">
            <div class="col-lg-5">
                <div class="card border-0 rounded-4 shadow-lg overflow-hidden h-100 bg-white d-flex flex-column">
                    <div class="position-relative" style="height: 290px;">
                        <img src="{{ asset('assets/images/prayer_service_congregation.jpg') }}" alt="Maombi na Maombezi EAGT Golani" class="w-100 h-100 object-fit-cover">
                        <div class="position-absolute bottom-0 start-0 end-0 p-3" style="background: linear-gradient(180deg, transparent 0%, rgba(15, 23, 42, 0.92) 100%);">
                            <span class="badge bg-warning text-dark fw-bold px-3 py-1 rounded-pill">
                                <i class="bi bi-fire me-1"></i> Ibada ya Maombi & Kufunguliwa
                            </span>
                        </div>
                    </div>
                    <div class="p-4 flex-grow-1 d-flex flex-column justify-content-between">
                        <div>
                            <h4 class="fw-bold text-dark mb-2">Maombi ya Nguvu na Kufunguliwa</h4>
                            <p class="text-muted small mb-3" style="line-height: 1.7;">
                                <em>"Maombi ya mwenye haki yanafaa sana, yakifanya kazi kwa bidii."</em> — <strong>Yakobo 5:16</strong>
                            </p>
                            <p class="text-muted small" style="line-height: 1.7;">
                                Kanisa la EAGT Golani linasimama nawe katika kila jaribu, ugonjwa, vita vya kiroho au mahitaji ya kifamilia. Mchungaji Kiongozi na jopo la maombezi huweka mikono na kuliombea kila hitaji linalowasilishwa hapa.
                            </p>
                        </div>
                        <div class="pt-3 border-top mt-3">
                            <div class="d-flex align-items-center gap-2 text-danger small fw-semibold mb-2">
                                <i class="bi bi-shield-lock-fill"></i> Siri ya Kichungaji Imehakikishwa
                            </div>
                            <div class="d-flex align-items-center gap-2 text-primary small fw-semibold">
                                <i class="bi bi-calendar2-check-fill text-warning"></i> Mkesha wa Miujiza: Kila Ijumaa Saa 03:00 Usiku
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="card border-0 rounded-4 shadow-lg p-4 p-md-5 bg-white h-100">
                    <div class="mb-4">
                        <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold mb-2">
                            <i class="bi bi-heart-fill text-danger me-1"></i> MAOMBEZI NA USHAURI
                        </span>
                        <h3 class="fw-bold text-dark">Wasilisha Hitaji Lako la Maombi</h3>
                        <p class="text-muted small mb-0">
                            Je, una hitaji la uponyaji, wokovu, ukombozi wa kifamilia au biashara? Andika hapa chini, Mchungaji Kiongozi na Wazee wa Kanisa watalibeba mbele za Mungu.
                        </p>
                    </div>

                    <form action="{{ route('home.prayer') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Jina Lako Kamili *</label>
                                <input type="text" name="requester_name" class="form-control" placeholder="Mf. Daudi Mwita" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Namba ya Simu</label>
                                <input type="text" name="requester_phone" class="form-control" placeholder="+255 7XX XXX XXX">
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-semibold">Aina ya Hitaji *</label>
                                <select name="category" class="form-select" required>
                                    <option value="Uponyaji wa Kimwili">Uponyaji wa Kimwili & Afya</option>
                                    <option value="Kufunguliwa & Ulinzi">Kufunguliwa Kiroho & Ulinzi dhidi ya Nguvu za Giza</option>
                                    <option value="Amani ya Ndoa na Familia">Amani ya Ndoa & Malezi ya Familia</option>
                                    <option value="Uchumi, Kazi na Biashara">Uchumi, Kazi na Mafanikio ya Biashara</option>
                                    <option value="Kumpokea Yesu (Wokovu)">Kumpokea Yesu kama Bwana na Mwokozi (Wokovu)</option>
                                    <option value="Shukrani kwa Mungu">Shukrani kwa Matendo Makuu ya Mungu</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-semibold">Eleza Hitaji Lako kwa Ufupi *</label>
                                <textarea name="request_text" class="form-control" rows="4" placeholder="Andika mzigo wako wa maombi hapa..." required></textarea>
                            </div>
                            <div class="col-12">
                                <div class="form-check p-3 bg-light rounded-3 border">
                                    <input class="form-check-input ms-0 me-2" type="checkbox" name="is_confidential" id="confidentialPrayerCheck" value="1">
                                    <label class="form-check-label fw-bold text-danger small" for="confidentialPrayerCheck">
                                        <i class="bi bi-shield-lock-fill"></i> Liwe Hitaji la Siri ya Kichungaji
                                    </label>
                                    <small class="d-block text-muted">Likiwekwa kama la siri, Mchungaji Kiongozi pekee ndiye atakayeona maelezo haya.</small>
                                </div>
                            </div>
                            <div class="col-12 text-center mt-3">
                                <button type="submit" class="btn btn-warning btn-lg rounded-pill px-5 fw-bold text-dark shadow w-100 w-sm-auto">
                                    <i class="bi bi-send-fill me-2"></i> Wasilisha Ombi la Maombi
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 12. Mawasiliano na Mahali Tulipo (Location & Directions) -->
<section id="mawasiliano" class="py-5">
    <div class="container py-4">
        <div class="row g-4 align-items-center">
            <div class="col-lg-5">
                <span class="section-tag">Wasiliana Nasi</span>
                <h2 class="fw-bold text-dark mb-4" style="font-size: 2.2rem;">Karibu Hekaluni Golani</h2>
                <p class="text-muted mb-4" style="line-height: 1.7;">
                    Hekalu letu linapatikana eneo tulivu la Golani, Kimara-Suka jijini Dar es Salaam. Kuna maegesho salama ya kutosha ya magari na usalama wa uhakika.
                </p>

                <div class="d-flex flex-column gap-3 mb-4">
                    <div class="d-flex align-items-start gap-3">
                        <div class="p-3 bg-primary bg-opacity-10 text-primary rounded-3 fs-4">
                            <i class="bi bi-geo-alt-fill"></i>
                        </div>
                        <div>
                            <strong class="text-dark d-block">Eneo la Kanisa:</strong>
                            <span class="text-muted small">Mtaa wa Golani, Kimara-Suka, Manispaa ya Ubungo, Dar es Salaam.</span>
                        </div>
                    </div>

                    <div class="d-flex align-items-start gap-3">
                        <div class="p-3 bg-warning bg-opacity-10 text-warning rounded-3 fs-4">
                            <i class="bi bi-telephone-fill"></i>
                        </div>
                        <div>
                            <strong class="text-dark d-block">Mawasiliano ya Simu:</strong>
                            <span class="text-muted small">+255 754 123 456 / +255 765 222 333</span>
                        </div>
                    </div>

                    <div class="d-flex align-items-start gap-3">
                        <div class="p-3 bg-success bg-opacity-10 text-success rounded-3 fs-4">
                            <i class="bi bi-envelope-fill"></i>
                        </div>
                        <div>
                            <strong class="text-dark d-block">Barua Pepe:</strong>
                            <span class="text-muted small">golani@eagt.org / mchungaji@eagt.org</span>
                        </div>
                    </div>
                </div>

                <a href="{{ route('login') }}" class="btn btn-primary-custom rounded-pill px-4 py-2 fw-bold shadow">
                    <i class="bi bi-box-arrow-in-right me-1"></i> Kuingia Kwenye Mfumo (Viongozi & Washirika)
                </a>
            </div>

            <div class="col-lg-7">
                <div class="card border-0 rounded-4 overflow-hidden shadow-lg p-2 bg-white">
                    <div class="p-4 bg-light rounded-4 text-center py-5">
                        <div class="display-1 text-primary mb-3"><i class="bi bi-compass"></i></div>
                        <h4 class="fw-bold text-dark">Maelekezo ya Kufika Hekaluni:</h4>
                        <p class="text-muted max-w-lg mx-auto small mb-4" style="max-width: 480px;">
                            Ukiwa Kituo cha Mabasi ya Mwendokasi (BRT) Kimara Mwisho au Kimara-Suka kwenye Barabara ya Morogoro, panda usafiri wa kuelekea Mtaa wa Golani Kanisa Kuu la EAGT. Ni umbali wa dakika 5 tu kutoka barabara kuu.
                        </p>
                        <div class="badge bg-primary px-3 py-2 rounded-pill fs-6">
                            <i class="bi bi-car-front-fill me-1"></i> EAGT GOLANI - KIMARA SUKA
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 13. Footer -->
<footer class="church-footer">
    <div class="container">
        <div class="row g-4 mb-5">
            <div class="col-lg-4">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <img src="{{ asset('assets/images/eagt_logo.jpg') }}" alt="EAGT Logo" class="rounded-circle shadow-sm" style="width: 48px; height: 48px; object-fit: contain; background: #fff; padding: 2px;">
                    <div>
                        <h5 class="fw-bold text-white mb-0">EAGT GOLANI</h5>
                        <small class="text-warning fw-semibold">Christian Center</small>
                    </div>
                </div>
                <p class="small text-muted mb-3" style="line-height: 1.7;">
                    EVANGELIST ASSEMBLIES OF GOD TANZANIA (EAGT). Kanisa la Pentekoste linalomhubiri Yesu Kristo aliye hai, anayeokoa, kubatiza kwa Roho Mtakatifu na kuponya miili.
                </p>
                <div class="text-warning small fst-italic mb-3">
                    "Neno la Msalaba ni nguvu ya Mungu kwetu sisi tunaookolewa." — 1 Wakorintho 1:18
                </div>
                <div class="pt-3 border-top border-secondary border-opacity-25">
                    <span class="text-white small fw-bold d-block mb-2">Tufuate Kwenye Mitandao Rasmi:</span>
                    <div class="d-flex align-items-center gap-2">
                        <a href="https://youtube.com/@eagt_golani?si=MQXrKVblnH6E7A7H" target="_blank" rel="noopener" class="btn btn-outline-danger btn-sm rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 36px; height: 36px;" title="YouTube Channel">
                            <i class="bi bi-youtube"></i>
                        </a>
                        <a href="https://www.tiktok.com/@eagt.golani?_r=1&_t=ZS-9AijKazxKBY" target="_blank" rel="noopener" class="btn btn-outline-light btn-sm rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 36px; height: 36px;" title="TikTok">
                            <i class="bi bi-tiktok"></i>
                        </a>
                        <a href="https://www.facebook.com/profile.php?id=61585945186115" target="_blank" rel="noopener" class="btn btn-outline-primary btn-sm rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 36px; height: 36px;" title="Facebook">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="https://www.instagram.com/eagt_golani?rpxt=amU0Y3R5a2FlYWJ5" target="_blank" rel="noopener" class="btn btn-outline-warning btn-sm rounded-circle d-inline-flex align-items-center justify-content-center text-white" style="width: 36px; height: 36px; border-color: #dc2743;" title="Instagram">
                            <i class="bi bi-instagram" style="color: #f09433;"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-6 col-lg-2">
                <h6 class="footer-heading">Viungo vya Haraka</h6>
                <a href="#mwanzo" class="footer-link">Mwanzo</a>
                <a href="#kuhusu" class="footer-link">Kuhusu EAGT</a>
                <a href="#ratiba" class="footer-link">Ratiba za Ibada</a>
                <a href="#idara" class="footer-link">Idara Zetu</a>
                <a href="#uzinduzi" class="footer-link">Uzinduzi wa Albamu</a>
                <a href="#picha" class="footer-link">Picha za Kanisa</a>
                <a href="#ujenzi" class="footer-link">Mradi wa Hekalu</a>
            </div>

            <div class="col-6 col-lg-2">
                <h6 class="footer-heading">Idara Kuu</h6>
                <a href="#idara" class="footer-link">CGM (Vijana)</a>
                <a href="#idara" class="footer-link">CWI (Watoto)</a>
                <a href="#idara" class="footer-link">Idara ya Ujenzi</a>
                <a href="#idara" class="footer-link">WWK (Wanawake)</a>
                <a href="#idara" class="footer-link">Wanaume wa Imani</a>
            </div>

            <div class="col-lg-4">
                <h6 class="footer-heading">Usimamizi wa Mfumo</h6>
                <p class="small text-muted mb-3">
                    Viongozi wa kanisa, wachungaji, wazee wa kanisa, mhazini na makatibu wanaweza kuingia kwenye mfumo rasmi wa kanisa hapa:
                </p>
                <a href="{{ route('login') }}" class="btn btn-warning rounded-pill px-4 py-2 fw-bold text-dark w-100 shadow">
                    <i class="bi bi-shield-lock-fill me-1"></i> Bofya Hapa Kuingia Mfumoni (Portal)
                </a>
                <div class="mt-3 text-center small text-white-50">
                    <i class="bi bi-lock-fill"></i> Ulinzi wa Data za Zaka & Sadaka Umeimarishwa
                </div>
            </div>
        </div>

        <div class="pt-4 border-top border-secondary border-opacity-25 d-flex flex-wrap justify-content-between align-items-center gap-2 small">
            <div>
                &copy; {{ date('Y') }} EVANGELIST ASSEMBLIES OF GOD TANZANIA (EAGT) - GOLANI, KIMARA-SUKA. Haki zote zimehifadhiwa.
            </div>
            <div>
                Kanisa la Pentekoste • Dar es Salaam, Tanzania
            </div>
        </div>
    </div>
</footer>

<!-- Success Alert for Giving -->
@if(session('giving_success'))
    <div class="modal fade show d-block" tabindex="-1" style="background: rgba(0,0,0,0.6);" id="successGivingModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="modal-body p-4 text-center">
                    <div class="bg-success text-white p-3 rounded-circle d-inline-flex mb-3">
                        <i class="bi bi-check-circle-fill fs-1"></i>
                    </div>
                    <h4 class="fw-bold text-dark mb-2">Bwana Asifiwe, {{ session('giving_success')['donor'] }}!</h4>
                    <p class="text-muted small mb-3">
                        Sadaka / Zaka yako ya <strong>Tsh {{ number_format(session('giving_success')['amount']) }}</strong> ({{ session('giving_success')['category'] }}) kupitia <strong>{{ session('giving_success')['method'] }}</strong> imepokelewa kikamilifu.
                    </p>
                    <div class="p-3 bg-light border rounded-3 mb-3 text-start small">
                        <div><strong>Kumbukumbu ya Malipo:</strong> <code>{{ session('giving_success')['code'] }}</code></div>
                        <div><strong>Hali:</strong> <span class="badge bg-success">Imethibitishwa na Mfumo</span></div>
                        <div class="mt-1 text-muted" style="font-size: 11px;">Ujumbe wa SMS ya uthibitisho umetumwa kwenye namba yako ya simu.</div>
                    </div>
                    <button type="button" class="btn btn-primary rounded-pill px-4" onclick="document.getElementById('successGivingModal').remove()">
                        Sawa, Ubarikiwe!
                    </button>
                </div>
            </div>
        </div>
    </div>
@endif

<!-- Online Giving Modal -->
<div class="modal fade" id="givingModal" tabindex="-1" aria-labelledby="givingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header border-0 text-white p-4" style="background: linear-gradient(135deg, #1e3a8a 0%, #0f172a 100%);">
                <div>
                    <h4 class="modal-title fw-bold" id="givingModalLabel">
                        <i class="bi bi-gift-fill text-warning me-2"></i>Toa Sadaka / Zaka Mtandaoni
                    </h4>
                    <small class="text-white-50">EAGT Golani, Kimara-Suka • Toa kwa moyo wa ukarimu (2 Wakorintho 9:7)</small>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form action="{{ route('home.giveOnline') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Jina Lako Kamili <span class="text-danger">*</span></label>
                            <input type="text" name="donor_name" class="form-control" placeholder="k.m. Rehema Swai" required value="{{ Auth::user()?->name }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Namba ya Simu ya Malipo <span class="text-danger">*</span></label>
                            <input type="text" name="phone" class="form-control" placeholder="k.m. 0715888999" required value="{{ Auth::user()?->phone }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Aina ya Sadaka / Mchango <span class="text-danger">*</span></label>
                            <select name="category" class="form-select" required>
                                <option value="tithe">Zaka ya Mwezi (Tithe)</option>
                                <option value="regular_offering" selected>Sadaka ya Kawaida (Offering)</option>
                                <option value="building_offering">Mchango wa Ujenzi wa Hekalu</option>
                                <option value="thanksgiving">Sadaka ya Shukrani</option>
                                <option value="special_contribution">Harambee / Mchango Maalum</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Kiasi cha Kutoa (Tsh) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text fw-bold">Tsh</span>
                                <input type="number" name="amount" class="form-control" placeholder="k.m. 10000" min="500" required>
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold">Chagua Njia ya Kulipa <span class="text-danger">*</span></label>
                            <div class="row g-2 text-center">
                                <div class="col-4 col-md-2">
                                    <input type="radio" class="btn-check" name="payment_method" id="payMpesa" value="mpesa" checked>
                                    <label class="btn btn-outline-danger w-100 py-2 small fw-bold" for="payMpesa">
                                        <i class="bi bi-phone d-block fs-5"></i>M-Pesa
                                    </label>
                                </div>
                                <div class="col-4 col-md-2">
                                    <input type="radio" class="btn-check" name="payment_method" id="payTigo" value="tigopesa">
                                    <label class="btn btn-outline-primary w-100 py-2 small fw-bold" for="payTigo">
                                        <i class="bi bi-phone d-block fs-5"></i>Tigo Pesa
                                    </label>
                                </div>
                                <div class="col-4 col-md-2">
                                    <input type="radio" class="btn-check" name="payment_method" id="payAirtel" value="airtel">
                                    <label class="btn btn-outline-danger w-100 py-2 small fw-bold" for="payAirtel">
                                        <i class="bi bi-phone d-block fs-5"></i>Airtel
                                    </label>
                                </div>
                                <div class="col-4 col-md-2">
                                    <input type="radio" class="btn-check" name="payment_method" id="payHalo" value="halopesa">
                                    <label class="btn btn-outline-warning w-100 py-2 small fw-bold text-dark" for="payHalo">
                                        <i class="bi bi-phone d-block fs-5"></i>Halopesa
                                    </label>
                                </div>
                                <div class="col-4 col-md-2">
                                    <input type="radio" class="btn-check" name="payment_method" id="payCRDB" value="crdb">
                                    <label class="btn btn-outline-success w-100 py-2 small fw-bold" for="payCRDB">
                                        <i class="bi bi-bank d-block fs-5"></i>CRDB
                                    </label>
                                </div>
                                <div class="col-4 col-md-2">
                                    <input type="radio" class="btn-check" name="payment_method" id="payNMB" value="nmb">
                                    <label class="btn btn-outline-info w-100 py-2 small fw-bold text-dark" for="payNMB">
                                        <i class="bi bi-bank d-block fs-5"></i>NMB
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label small text-muted">Maelezo ya Ziada au Ombi Maalum (Si lazima):</label>
                            <input type="text" name="notes" class="form-control" placeholder="k.m. Sadaka ya kushukuru kwa kufaulu mtihani / Ahadi ya ujenzi">
                        </div>

                        <div class="col-12 mt-4 text-end">
                            <button type="button" class="btn btn-light rounded-pill px-4 me-2" data-bs-dismiss="modal">Ghairi</button>
                            <button type="submit" class="btn btn-primary rounded-pill px-5 fw-bold shadow-sm" style="background: #1e3a8a;">
                                <i class="bi bi-send-check me-1"></i> Kamilisha Sadaka Yako
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Floating WhatsApp Widget -->
<div class="whatsapp-float-container">
    <!-- Popup Card -->
    <div class="whatsapp-popup-card" id="whatsappPopup">
        <div class="p-3 text-white" style="background: linear-gradient(135deg, #128C7E 0%, #075E54 100%);">
            <div class="d-flex align-items-center gap-2 mb-1">
                <i class="bi bi-whatsapp fs-4"></i>
                <h6 class="fw-bold mb-0">EAGT Golani WhatsApp</h6>
            </div>
            <div class="small text-white-50 d-flex align-items-center gap-1">
                <span class="rounded-circle bg-success" style="width: 8px; height: 8px; display: inline-block;"></span>
                Mtandaoni • Zungumza nasi sasa
            </div>
        </div>
        <div class="p-3 bg-light" style="font-size: 13px; color: #475569;">
            Bwana Asifiwe! Chagua ofisi au idara unayotaka kuwasiliana nayo:
        </div>
        <div class="list-group list-group-flush small">
            <a href="https://wa.me/255754111002?text={{ urlencode('Bwana Asifiwe Mchungaji! Ninaomba ushauri na maombi...') }}" target="_blank" class="list-group-item list-group-item-action d-flex align-items-center gap-3 p-3">
                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 38px; height: 38px; flex-shrink: 0;">
                    <i class="bi bi-person-fill"></i>
                </div>
                <div>
                    <div class="fw-bold text-dark">Mchungaji Kiongozi</div>
                    <div class="text-muted" style="font-size: 11px;">Ushauri wa Kichungaji & Maombi</div>
                </div>
            </a>
            <a href="https://wa.me/255754123456?text={{ urlencode('Bwana Asifiwe! Ninaulizia kuhusu kanisa na ratiba za ibada EAGT Golani...') }}" target="_blank" class="list-group-item list-group-item-action d-flex align-items-center gap-3 p-3">
                <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center" style="width: 38px; height: 38px; flex-shrink: 0;">
                    <i class="bi bi-building"></i>
                </div>
                <div>
                    <div class="fw-bold text-dark">Ofisi ya Kanisa / Katibu</div>
                    <div class="text-muted" style="font-size: 11px;">Ratiba, Vyeti vya Ubatizo & Taarifa</div>
                </div>
            </a>
            <a href="https://wa.me/255765222333?text={{ urlencode('Bwana Asifiwe Kiongozi wa Vijana! Ningependa kujiunga na Vijana CGM EAGT Golani...') }}" target="_blank" class="list-group-item list-group-item-action d-flex align-items-center gap-3 p-3">
                <div class="rounded-circle bg-warning text-dark d-flex align-items-center justify-content-center" style="width: 38px; height: 38px; flex-shrink: 0;">
                    <i class="bi bi-fire"></i>
                </div>
                <div>
                    <div class="fw-bold text-dark">Vijana CGM (Christ Gospel Messengers)</div>
                    <div class="text-muted" style="font-size: 11px;">Kambi za Vijana, Uinjilisti & Kwaya</div>
                </div>
            </a>
        </div>
        <div class="p-2 text-center bg-light border-top">
            <small class="text-muted" style="font-size: 11px;">Tunaanza kujibu ndani ya dakika chache</small>
        </div>
    </div>

    <!-- Float Button -->
    <button class="whatsapp-float-btn" type="button" onclick="toggleWhatsAppPopup()" title="Zungumza nasi WhatsApp">
        <i class="bi bi-whatsapp"></i>
    </button>
</div>

<!-- Countdown Timer Script -->
<script>
    function toggleWhatsAppPopup() {
        const popup = document.getElementById('whatsappPopup');
        popup.classList.toggle('show');
    }

    // Funga popup mtumiaji akibonyeza nje
    document.addEventListener('click', function(e) {
        const container = document.querySelector('.whatsapp-float-container');
        const popup = document.getElementById('whatsappPopup');
        if (container && !container.contains(e.target)) {
            popup?.classList.remove('show');
        }
    });

    function updateCountdown() {
        const now = new Date();
        const nextSunday = new Date();
        const day = now.getDay();
        const diff = (7 - day) % 7 || 7;
        nextSunday.setDate(now.getDate() + diff);
        nextSunday.setHours(8, 30, 0, 0);

        const diffMs = nextSunday - now;
        if (diffMs > 0) {
            const days = Math.floor(diffMs / (1000 * 60 * 60 * 24));
            const hours = Math.floor((diffMs % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const mins = Math.floor((diffMs % (1000 * 60 * 60)) / (1000 * 60));
            const secs = Math.floor((diffMs % (1000 * 60)) / 1000);

            document.getElementById('cd-days').innerText = String(days).padStart(2, '0');
            document.getElementById('cd-hours').innerText = String(hours).padStart(2, '0');
            document.getElementById('cd-mins').innerText = String(mins).padStart(2, '0');
            document.getElementById('cd-secs').innerText = String(secs).padStart(2, '0');
        }
    }
    setInterval(updateCountdown, 1000);
    updateCountdown();

    // PWA Service Worker
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', function() {
            navigator.serviceWorker.register('/sw.js').catch(function(err) {
                console.log('SW error:', err);
            });
        });
    }
</script>

<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
