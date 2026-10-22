<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kuingia Kwenye Mfumo - EAGT GOLANI, KIMARA-SUKA</title>
    
    <!-- Local Assets -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/icons/bootstrap-icons.min.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, #070d1e 0%, #172554 50%, #070d1e 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }

        .login-card {
            border: 1px solid rgba(255, 255, 255, 0.12);
            background: rgba(11, 19, 41, 0.90);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.6);
            overflow: hidden;
            max-width: 1040px;
            width: 100%;
        }

        .left-banner {
            background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%);
            padding: 3.5rem;
            color: #fff;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
        }

        .role-pill {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.15);
            color: #e2e8f0;
            border-radius: 12px;
            padding: 0.65rem 0.9rem;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.83rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .role-pill:hover {
            background: rgba(255, 255, 255, 0.20);
            color: #fff;
            transform: translateY(-2px);
            border-color: #f59e0b;
        }

        .form-control-custom {
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.15);
            color: #fff;
            border-radius: 12px;
            padding: 0.75rem 1rem;
        }

        .form-control-custom:focus {
            background: rgba(255, 255, 255, 0.12);
            border-color: #3b82f6;
            color: #fff;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.25);
        }

        .form-control-custom::placeholder {
            color: #94a3b8;
        }
    </style>
</head>
<body>

<div class="login-card">
    <div class="row g-0">
        <!-- Upande wa Kushoto: Nembo na Utangulizi wa Kanisa -->
        <div class="col-lg-5 left-banner d-none d-lg-flex">
                <div class="d-inline-flex align-items-center justify-content-center bg-white rounded-circle p-1 shadow-lg mb-4" style="width: 80px; height: 80px;">
                    <img src="{{ asset('assets/images/eagt_logo.jpg') }}" alt="EAGT Logo" class="rounded-circle w-100 h-100 object-fit-contain">
                </div>
                <div class="mb-3">
                    <img src="{{ asset('assets/images/eagt_golani_banner.jpg') }}" alt="EAGT Golani Christian Center" class="img-fluid rounded-3 shadow-sm bg-white p-1" style="max-height: 52px; object-fit: contain;">
                </div>
                <h4 class="fw-bold tracking-tight text-white mb-1">EVANGELIST ASSEMBLIES OF GOD TANZANIA</h4>
                <div class="badge bg-warning text-dark fw-bold mb-3 px-3 py-2 rounded-pill" style="font-size: 0.85rem;">
                    EAGT GOLANI - KIMARA-SUKA
                </div>
                <p class="text-white-50" style="font-size: 0.92rem; line-height: 1.6;">
                    Mfumo jumuishi wa kidigitali wa kanisa unaosimamia waumini, mahudhurio, idara za CGM, CWI, WWK, ujenzi, sadaka, miradi na huduma za kichungaji.
                </p>

                <div class="mt-4 pt-3 border-top border-white border-opacity-15">
                    <div class="d-flex align-items-center gap-2 mb-1 text-warning fw-semibold">
                        <i class="bi bi-shield-check"></i> Utaratibu Maalum wa Zaka
                    </div>
                    <small class="text-white-50 d-block" style="line-height: 1.5;">
                        Zaka zikithibitishwa na Wazee wa Kanisa hazihifadhiwi bali zinapelekwa moja kwa moja kwa Mchungaji Kiongozi. Mhazini haruhusiwi kuona kumbukumbu za Zaka kwenye leja yake.
                    </small>
                </div>
            </div>

            <div class="mt-5">
                <span class="badge bg-white bg-opacity-10 text-white border border-white border-opacity-20 px-3 py-2 rounded-pill">
                    <i class="bi bi-geo-alt-fill me-1 text-warning"></i> Kimara-Suka, Dar es Salaam
                </span>
            </div>
        </div>

        <!-- Upande wa Kulia: Fomu ya Kuingia na Vitufe vya Majaribio -->
        <div class="col-lg-7 p-4 p-md-5 text-white">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="fw-bold text-white mb-1">Karibu Kwenye Mfumo</h4>
                    <p class="text-secondary small mb-0">Weka barua pepe na nenosiri lako kuingia</p>
                </div>
                <a href="{{ route('home') }}" class="btn btn-outline-light btn-sm rounded-pill px-3" style="font-size: 0.8rem;">
                    <i class="bi bi-house-door me-1"></i> Tovuti Kuu
                </a>
            </div>

            @if(session('info'))
                <div class="alert alert-info py-2 small border-0 rounded-3 mb-3">{{ session('info') }}</div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger py-2 small border-0 rounded-3 mb-3">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" class="mb-4">
                @csrf
                <div class="mb-3">
                    <label class="form-label text-light small fw-semibold">Barua Pepe (Email)</label>
                    <input type="email" name="email" class="form-control form-control-custom" placeholder="mfano: pastor@eagt.org" value="{{ old('email', 'pastor@eagt.org') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label text-light small fw-semibold">Nenosiri (Password)</label>
                    <input type="password" name="password" class="form-control form-control-custom" placeholder="••••••••" value="password" required>
                </div>

                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" checked>
                        <label class="form-check-label text-light small" for="remember">Nikumbuke</label>
                    </div>
                    <span class="text-secondary small">Nenosiri la majaribio: <code>password</code></span>
                </div>

                <button type="submit" class="btn btn-warning w-100 py-2 fw-bold text-dark rounded-3 shadow">
                    <i class="bi bi-box-arrow-in-right me-1"></i> Ingia Kwenye Mfumo
                </button>
            </form>

            <!-- Vitufe vya Majaribio ya Haraka (1-Click Instant Demo Login) -->
            <div class="pt-3 border-top border-white border-opacity-10">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <span class="text-warning small fw-bold text-uppercase">
                        <i class="bi bi-lightning-fill me-1"></i> Jaribu Mfumo kwa Kubofya Mara 1:
                    </span>
                    <span class="badge bg-secondary-subtle text-secondary small">Majukumu Yote</span>
                </div>

                <div class="row g-2">
                    <div class="col-6 col-md-4">
                        <a href="{{ route('demo.login', 'pastor') }}" class="role-pill">
                            <i class="bi bi-heart-pulse text-primary fs-5"></i>
                            <div class="text-truncate">
                                <div class="fw-bold">Mchungaji</div>
                                <small class="text-secondary" style="font-size: 0.72rem;">Kiongozi Mkuu</small>
                            </div>
                        </a>
                    </div>
                    <div class="col-6 col-md-4">
                        <a href="{{ route('demo.login', 'elder') }}" class="role-pill">
                            <i class="bi bi-person-check text-success fs-5"></i>
                            <div class="text-truncate">
                                <div class="fw-bold">Mzee wa Kanisa</div>
                                <small class="text-secondary" style="font-size: 0.72rem;">Athibitisha Mapato</small>
                            </div>
                        </a>
                    </div>
                    <div class="col-6 col-md-4">
                        <a href="{{ route('demo.login', 'treasurer') }}" class="role-pill">
                            <i class="bi bi-cash-coin text-warning fs-5"></i>
                            <div class="text-truncate">
                                <div class="fw-bold">Mhazini</div>
                                <small class="text-secondary" style="font-size: 0.72rem;">Mtunza Hazina</small>
                            </div>
                        </a>
                    </div>
                    <div class="col-6 col-md-4">
                        <a href="{{ route('demo.login', 'secretary') }}" class="role-pill">
                            <i class="bi bi-pen text-info fs-5"></i>
                            <div class="text-truncate">
                                <div class="fw-bold">Katibu</div>
                                <small class="text-secondary" style="font-size: 0.72rem;">Waumini & Mahudhurio</small>
                            </div>
                        </a>
                    </div>
                    <div class="col-6 col-md-4">
                        <a href="{{ route('demo.login', 'youth_leader') }}" class="role-pill">
                            <i class="bi bi-diagram-3 text-secondary fs-5"></i>
                            <div class="text-truncate">
                                <div class="fw-bold">Kiongozi CPV</div>
                                <small class="text-secondary" style="font-size: 0.72rem;">Idara ya Vijana</small>
                            </div>
                        </a>
                    </div>
                    <div class="col-6 col-md-4">
                        <a href="{{ route('demo.login', 'member') }}" class="role-pill">
                            <i class="bi bi-person text-muted fs-5"></i>
                            <div class="text-truncate">
                                <div class="fw-bold">Mshirika</div>
                                <small class="text-secondary" style="font-size: 0.72rem;">Muumini wa Kawaida</small>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="mt-3 text-center">
                    <a href="{{ route('demo.login', 'super_admin') }}" class="text-white-50 small text-decoration-none">
                        <i class="bi bi-shield-shaded me-1"></i> Ingia kama Msimamizi Mkuu wa Mfumo (Super Admin)
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
