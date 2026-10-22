<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kuingia Kwenye Mfumo - EAGT GOLANI, KIMARA-SUKA</title>
    
    <!-- Local & Google Assets -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/icons/bootstrap-icons.min.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Cinzel:wght@600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-navy: #060c1d;
            --secondary-navy: #0f1d40;
            --accent-gold: #f59e0b;
            --accent-gold-hover: #d97706;
            --royal-blue: #1e40af;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: 
                radial-gradient(circle at 15% 20%, rgba(30, 64, 175, 0.45) 0%, transparent 45%),
                radial-gradient(circle at 85% 80%, rgba(245, 158, 11, 0.18) 0%, transparent 45%),
                radial-gradient(circle at 50% 50%, rgba(15, 29, 64, 0.8) 0%, transparent 70%),
                linear-gradient(135deg, #030712 0%, #0a1329 50%, #030712 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2.5rem 1rem;
            position: relative;
            overflow-x: hidden;
        }

        /* Subtle sacred background glow elements */
        body::before {
            content: '';
            position: absolute;
            width: 600px;
            height: 600px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.15) 0%, transparent 70%);
            top: -150px;
            left: -150px;
            pointer-events: none;
        }

        body::after {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(245, 158, 11, 0.12) 0%, transparent 70%);
            bottom: -120px;
            right: -120px;
            pointer-events: none;
        }

        .login-card {
            border: 1px solid rgba(255, 255, 255, 0.14);
            background: rgba(10, 18, 38, 0.92);
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            border-radius: 28px;
            box-shadow: 
                0 25px 60px -15px rgba(0, 0, 0, 0.75),
                0 0 50px -10px rgba(30, 64, 175, 0.25),
                inset 0 1px 1px rgba(255, 255, 255, 0.1);
            overflow: hidden;
            max-width: 1020px;
            width: 100%;
            position: relative;
            z-index: 10;
        }

        .left-banner {
            background: linear-gradient(145deg, #102a70 0%, #1a3d99 50%, #0c1e54 100%);
            padding: 3.5rem 3rem;
            color: #fff;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
            border-right: 1px solid rgba(255, 255, 255, 0.08);
        }

        .left-banner::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 80% 20%, rgba(245, 158, 11, 0.15) 0%, transparent 50%);
            pointer-events: none;
        }

        .form-panel {
            background: rgba(8, 15, 33, 0.88);
            padding: 3.5rem 3.2rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .church-emblem-ring {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            padding: 4px;
            background: linear-gradient(135deg, #f59e0b 0%, #ffffff 50%, #d97706 100%);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.4);
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .church-emblem-img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: contain;
            background: #ffffff;
            padding: 3px;
        }

        .brand-title {
            font-family: 'Cinzel', serif;
            font-weight: 700;
            letter-spacing: 0.8px;
            font-size: 1.18rem;
            line-height: 1.35;
        }

        .scripture-card {
            background: rgba(255, 255, 255, 0.07);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 16px;
            padding: 1.25rem;
            margin-top: 1.5rem;
            position: relative;
        }

        .form-control-custom {
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.16);
            color: #ffffff;
            border-radius: 12px;
            padding: 0.85rem 1rem;
            font-size: 0.95rem;
            transition: all 0.25s ease;
        }

        .form-control-custom:focus {
            background: rgba(255, 255, 255, 0.12);
            border-color: #f59e0b;
            color: #ffffff;
            box-shadow: 0 0 0 4px rgba(245, 158, 11, 0.22);
        }

        .form-control-custom::placeholder {
            color: #94a3b8;
            font-size: 0.9rem;
        }

        .input-icon-group {
            position: relative;
        }

        .input-icon-group .icon-addon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            pointer-events: none;
            font-size: 1.1rem;
            transition: color 0.2s ease;
        }

        .input-icon-group .form-control-custom {
            padding-left: 2.85rem;
        }

        .input-icon-group:focus-within .icon-addon {
            color: #f59e0b;
        }

        .password-toggle-btn {
            position: absolute;
            right: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #94a3b8;
            cursor: pointer;
            padding: 0.25rem 0.5rem;
            font-size: 1.15rem;
            transition: color 0.2s ease;
        }

        .password-toggle-btn:hover {
            color: #ffffff;
        }

        .btn-church-gold {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            border: none;
            color: #0c1a3d;
            font-weight: 700;
            letter-spacing: 0.3px;
            border-radius: 12px;
            padding: 0.85rem 1.5rem;
            transition: all 0.3s ease;
            box-shadow: 0 10px 25px -5px rgba(245, 158, 11, 0.4);
        }

        .btn-church-gold:hover {
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
            color: #0c1a3d;
            transform: translateY(-2px);
            box-shadow: 0 15px 30px -5px rgba(245, 158, 11, 0.55);
        }

        .support-box {
            background: rgba(255, 255, 255, 0.04);
            border: 1px dashed rgba(255, 255, 255, 0.12);
            border-radius: 14px;
            padding: 1rem;
        }

        @media (max-width: 991px) {
            .left-banner {
                padding: 2.5rem 1.75rem;
                text-align: center;
                align-items: center;
            }
            .form-panel {
                padding: 2.5rem 1.75rem;
            }
        }
    </style>
</head>
<body>

<div class="login-card">
    <div class="row g-0 align-items-stretch">
        
        <!-- UPANDE WA KUSHOTO: NEMBO NA UTAMBULISHO WA KIKANISA -->
        <div class="col-lg-5 left-banner">
            <div>
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="church-emblem-ring">
                        <img src="{{ asset('assets/images/eagt_logo.jpg') }}" alt="EAGT Logo" class="church-emblem-img">
                    </div>
                    <div>
                        <span class="badge bg-warning text-dark fw-bold px-3 py-1 rounded-pill mb-1" style="font-size: 0.75rem;">
                            EAGT TANZANIA
                        </span>
                        <div class="small text-white-50">Evangelist Assemblies of God</div>
                    </div>
                </div>

                <div class="mb-3">
                    <img src="{{ asset('assets/images/eagt_golani_banner.jpg') }}" alt="EAGT Golani Christian Center" class="img-fluid rounded-3 shadow-sm bg-white p-1" style="max-height: 48px; object-fit: contain;">
                </div>

                <h4 class="brand-title text-white mb-2">
                    EAGT GOLANI CHRISTIAN CENTER
                </h4>
                <div class="text-warning fw-semibold small mb-3">
                    <i class="bi bi-geo-alt-fill me-1"></i> Kimara-Suka, Dar es Salaam • Tanzania
                </div>

                <p class="text-white-50 small mb-0" style="line-height: 1.65;">
                    Mfumo jumuishi wa kikanisa unaosimamia Daftari la Waumini, Mahudhurio ya Ibada Kuu, Idara za Kanisa (CPV, CWI, WWK), Ujenzi wa Hekalu, Miradi ya Maendeleo na Huduma za Kichungaji.
                </p>

                <!-- Kadi ya Neno la Kiroho -->
                <div class="scripture-card">
                    <div class="d-flex align-items-center gap-2 mb-1 text-warning fw-bold small">
                        <i class="bi bi-book-half"></i> Zaburi 122:1
                    </div>
                    <small class="text-white text-opacity-90 fst-italic d-block" style="line-height: 1.5;">
                        "Nalifurahi waliponiambia: Na twende nyumbani mwa BWANA."
                    </small>
                </div>
            </div>

            <!-- Ilani ya Faragha & Usalama -->
            <div class="mt-4 pt-3 border-top border-white border-opacity-10">
                <div class="d-flex align-items-center gap-2 text-white-50 small">
                    <i class="bi bi-shield-lock-fill text-warning fs-5"></i>
                    <span>Upatikanaji salama na faragha kamili ya taarifa na sadaka za kanisa.</span>
                </div>
            </div>
        </div>

        <!-- UPANDE WA KULIA: FOMU RASMI YA KUINGIA KWENYE MFUMO -->
        <div class="col-lg-7 form-panel">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h3 class="fw-bold text-white mb-1">Kuingia Kwenye Mfumo</h3>
                    <p class="text-white-50 small mb-0">Ingiza barua pepe yako na nenosiri salama kuendelea</p>
                </div>
                <a href="{{ route('home') }}" class="btn btn-sm btn-outline-light rounded-pill px-3 py-1 fw-semibold d-inline-flex align-items-center" style="font-size: 0.82rem;">
                    <i class="bi bi-house-door me-1 text-warning"></i> Tovuti Kuu
                </a>
            </div>

            <!-- Arifa za Mfumo -->
            @if(session('info'))
                <div class="alert alert-info border-0 rounded-3 py-2 px-3 small d-flex align-items-center gap-2 mb-3">
                    <i class="bi bi-info-circle-fill fs-5"></i>
                    <div>{{ session('info') }}</div>
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success border-0 rounded-3 py-2 px-3 small d-flex align-items-center gap-2 mb-3">
                    <i class="bi bi-check-circle-fill fs-5"></i>
                    <div>{{ session('success') }}</div>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger border-0 rounded-3 py-2 px-3 small d-flex align-items-center gap-2 mb-3">
                    <i class="bi bi-exclamation-triangle-fill fs-5 text-danger"></i>
                    <div>{{ $errors->first() }}</div>
                </div>
            @endif

            <!-- Fomu Halisi ya Kuingia (Bila Demo) -->
            <form action="{{ route('login') }}" method="POST">
                @csrf

                <!-- Barua Pepe -->
                <div class="mb-3">
                    <label class="form-label text-light small fw-semibold">
                        <i class="bi bi-envelope-fill text-warning me-1"></i> Barua Pepe (Email Address) *
                    </label>
                    <div class="input-icon-group">
                        <i class="bi bi-envelope icon-addon"></i>
                        <input type="email" 
                               name="email" 
                               class="form-control form-control-custom" 
                               placeholder="mfano: jina@eagt.org au barua pepe yako" 
                               value="{{ old('email') }}" 
                               autocomplete="email" 
                               required 
                               autofocus>
                    </div>
                </div>

                <!-- Nenosiri -->
                <div class="mb-3">
                    <label class="form-label text-light small fw-semibold">
                        <i class="bi bi-lock-fill text-warning me-1"></i> Nenosiri (Password) *
                    </label>
                    <div class="input-icon-group">
                        <i class="bi bi-key icon-addon"></i>
                        <input type="password" 
                               name="password" 
                               id="passwordInput" 
                               class="form-control form-control-custom pe-5" 
                               placeholder="Weka nenosiri lako salama" 
                               autocomplete="current-password" 
                               required>
                        <button type="button" class="password-toggle-btn" id="togglePasswordBtn" title="Onyesha / Ficha Nenosiri">
                            <i class="bi bi-eye" id="togglePasswordIcon"></i>
                        </button>
                    </div>
                </div>

                <!-- Chaguo la Nikumbuke na Kiungo cha Umesahau Nenosiri -->
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" checked>
                        <label class="form-check-label text-light small user-select-none" for="remember">
                            Nikumbuke kwenye kifaa hiki
                        </label>
                    </div>
                    <a href="{{ route('password.request') }}" class="text-warning text-decoration-none small fw-semibold">
                        <i class="bi bi-question-circle me-1"></i> Umesahau Nenosiri?
                    </a>
                </div>

                <!-- Kitufe Kikuu cha Kuingia -->
                <button type="submit" class="btn btn-church-gold w-100 py-3 d-flex align-items-center justify-content-center gap-2 fs-6 shadow">
                    <i class="bi bi-box-arrow-in-right fs-5"></i>
                    <span>Ingia Kwenye Mfumo wa Kanisa</span>
                </button>
            </form>

            <!-- Sehemu ya Msaada na Uongozi wa Kanisa -->
            <div class="support-box mt-4 text-center">
                <div class="small text-white-50 mb-1">
                    <i class="bi bi-info-circle text-warning me-1"></i> <strong>Huna akaunti au unahitaji usaidizi wa kuingia?</strong>
                </div>
                <div class="small text-white text-opacity-80">
                    Wasiliana na Katibu wa Kanisa au Wazee wa Kanisa: <span class="text-warning fw-bold">+255 754 888 999</span> / <span class="text-warning fw-bold">+255 715 123 456</span>
                </div>
            </div>

            <!-- Kiungo cha Chini -->
            <div class="mt-3 text-center text-white-50" style="font-size: 0.78rem;">
                Multi-Church Integrated System • EAGT Golani Christian Center © {{ date('Y') }}
            </div>
        </div>

    </div>
</div>

<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
<script>
    // Onyesha / Ficha nenosiri
    const toggleBtn = document.getElementById('togglePasswordBtn');
    const pwdInput = document.getElementById('passwordInput');
    const toggleIcon = document.getElementById('togglePasswordIcon');

    if (toggleBtn && pwdInput && toggleIcon) {
        toggleBtn.addEventListener('click', function () {
            if (pwdInput.type === 'password') {
                pwdInput.type = 'text';
                toggleIcon.classList.remove('bi-eye');
                toggleIcon.classList.add('bi-eye-slash');
            } else {
                pwdInput.type = 'password';
                toggleIcon.classList.remove('bi-eye-slash');
                toggleIcon.classList.add('bi-eye');
            }
        });
    }
</script>
</body>
</html>
