<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usajili wa Mshirika Mpya - EAGT Golani Christian Center</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('assets/images/eagt_logo.jpg') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --church-navy: #060d1f;
            --church-blue: #0c1a3d;
            --church-royal: #132d73;
            --church-gold: #f59e0b;
            --church-gold-hover: #d97706;
            --card-glass: rgba(10, 20, 44, 0.88);
            --border-glass: rgba(255, 255, 255, 0.12);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--church-navy);
            background-image: 
                radial-gradient(at 0% 0%, rgba(30, 64, 175, 0.35) 0px, transparent 50%),
                radial-gradient(at 100% 0%, rgba(217, 119, 6, 0.22) 0px, transparent 50%),
                radial-gradient(at 50% 100%, rgba(15, 23, 42, 0.95) 0px, transparent 70%),
                radial-gradient(at 80% 50%, rgba(29, 78, 216, 0.25) 0px, transparent 50%),
                linear-gradient(180deg, #050b18 0%, #0a1738 50%, #040813 100%);
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2.5rem 1rem;
            color: #e2e8f0;
            position: relative;
            overflow-x: hidden;
        }

        /* Nyota na Mwangaza hafifu */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                radial-gradient(2px 2px at 20px 30px, #ffffff, rgba(0,0,0,0)),
                radial-gradient(2px 2px at 90px 170px, rgba(255,255,255,0.7), rgba(0,0,0,0)),
                radial-gradient(1.5px 1.5px at 150px 80px, #f59e0b, rgba(0,0,0,0)),
                radial-gradient(2px 2px at 280px 220px, rgba(255,255,255,0.6), rgba(0,0,0,0));
            background-repeat: repeat;
            background-size: 300px 300px;
            opacity: 0.25;
            pointer-events: none;
            z-index: 0;
        }

        .register-card {
            background: var(--card-glass);
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            border: 1px solid var(--border-glass);
            border-radius: 24px;
            box-shadow: 
                0 25px 60px -15px rgba(0, 0, 0, 0.75),
                0 0 50px -10px rgba(30, 64, 175, 0.25),
                inset 0 1px 1px rgba(255, 255, 255, 0.1);
            overflow: hidden;
            max-width: 1100px;
            width: 100%;
            position: relative;
            z-index: 10;
        }

        .left-banner {
            background: linear-gradient(145deg, #102a70 0%, #1a3d99 50%, #0c1e54 100%);
            padding: 3.5rem 2.8rem;
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
            padding: 3.2rem 3rem;
        }

        .church-emblem-ring {
            width: 85px;
            height: 85px;
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
            font-size: 1.15rem;
            line-height: 1.35;
        }

        .scripture-card {
            background: rgba(255, 255, 255, 0.06);
            border-left: 3px solid #f59e0b;
            border-radius: 0 12px 12px 0;
            padding: 1.1rem 1.25rem;
            margin-top: 1.5rem;
            backdrop-filter: blur(8px);
        }

        .benefit-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 0.9rem;
            font-size: 0.88rem;
            color: rgba(255, 255, 255, 0.85);
            line-height: 1.45;
        }

        .benefit-icon {
            color: #f59e0b;
            font-size: 1.1rem;
            flex-shrink: 0;
            margin-top: 1px;
        }

        .form-control-custom, .form-select-custom {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.12);
            color: #ffffff;
            border-radius: 12px;
            padding: 0.72rem 1rem;
            font-size: 0.92rem;
            transition: all 0.25s ease;
        }

        .form-control-custom:focus, .form-select-custom:focus {
            background: rgba(255, 255, 255, 0.09);
            border-color: #f59e0b;
            color: #ffffff;
            box-shadow: 0 0 0 0.25rem rgba(245, 158, 11, 0.25);
        }

        .form-select-custom option {
            background: #0d1b3e;
            color: #ffffff;
        }

        .form-control-custom::placeholder {
            color: #64748b;
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
            z-index: 5;
        }

        .input-icon-group .form-control-custom {
            padding-left: 2.75rem;
        }

        .password-toggle-btn {
            position: absolute;
            right: 0.85rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #94a3b8;
            cursor: pointer;
            padding: 0.25rem 0.5rem;
            font-size: 1.1rem;
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

        @media (max-width: 991px) {
            .left-banner {
                padding: 2.5rem 1.75rem;
                text-align: center;
                align-items: center;
            }
            .form-panel {
                padding: 2.5rem 1.75rem;
            }
            .benefit-item {
                text-align: left;
            }
        }
    </style>
</head>
<body>

<div class="register-card">
    <div class="row g-0 align-items-stretch">
        
        <!-- UPANDE WA KUSHOTO: MAELEZO YA USHIRIKA WA KIKANISA -->
        <div class="col-lg-4 left-banner">
            <div>
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="church-emblem-ring">
                        <img src="{{ asset('assets/images/eagt_logo.jpg') }}" alt="EAGT Logo" class="church-emblem-img">
                    </div>
                    <div>
                        <span class="badge bg-warning text-dark fw-bold px-3 py-1 rounded-pill mb-1" style="font-size: 0.72rem;">
                            EAGT TANZANIA
                        </span>
                        <div class="small text-white-50">Evangelist Assemblies of God</div>
                    </div>
                </div>

                <h4 class="brand-title text-white mb-2">
                    EAGT GOLANI CHRISTIAN CENTER
                </h4>
                <div class="text-warning fw-semibold small mb-4">
                    <i class="bi bi-geo-alt-fill me-1"></i> Kimara-Suka, Dar es Salaam
                </div>

                <div class="border-top border-white border-opacity-10 pt-3 mb-3">
                    <h6 class="text-white fw-bold mb-3 small text-uppercase" style="letter-spacing: 0.5px;">
                        <i class="bi bi-check2-circle text-warning me-1"></i> Faida za Kujiunga na Ushirika:
                    </h6>

                    <div class="benefit-item">
                        <i class="bi bi-person-vcard benefit-icon"></i>
                        <span>Kutambuliwa rasmi kwenye daftari la waumini na kupata <strong>Nambari ya Ushirika</strong>.</span>
                    </div>

                    <div class="benefit-item">
                        <i class="bi bi-heart-pulse benefit-icon"></i>
                        <span>Kupokea huduma za kichungaji, maombezi, na ufuatiliaji wa kiroho wa familia yako.</span>
                    </div>

                    <div class="benefit-item">
                        <i class="bi bi-people-fill benefit-icon"></i>
                        <span>Kujiunga na idara za kanisa (CGM Vijana, WWK Wanawake, Wanaume wa Imani, Kwaya Kuu, n.k.).</span>
                    </div>

                    <div class="benefit-item">
                        <i class="bi bi-bricks benefit-icon"></i>
                        <span>Kushiriki kikamilifu katika miradi ya maendeleo ya kanisa na ujenzi wa Hekalu.</span>
                    </div>
                </div>

                <!-- Nukuu ya Kiroho -->
                <div class="scripture-card">
                    <div class="d-flex align-items-center gap-2 mb-1 text-warning fw-bold small">
                        <i class="bi bi-book-half"></i> Zaburi 100:3
                    </div>
                    <small class="text-white text-opacity-90 fst-italic d-block" style="line-height: 1.5;">
                        "Mjueni kwamba BWANA ndiye Mungu; Ndiye aliyetuumba na sisi tu watu wake, Na kondoo wa malisho yake."
                    </small>
                </div>
            </div>

            <!-- Ilani ya Faragha -->
            <div class="mt-4 pt-3 border-top border-white border-opacity-10">
                <div class="d-flex align-items-center gap-2 text-white-50 small">
                    <i class="bi bi-shield-check text-warning fs-5"></i>
                    <span>Taarifa zako zote zitahifadhiwa kwa siri na heshima kubwa ya kichungaji.</span>
                </div>
            </div>
        </div>

        <!-- UPANDE WA KULIA: FOMU YA USAJILI WA MSHIRIKA -->
        <div class="col-lg-8 form-panel">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h3 class="fw-bold text-white mb-1">
                        <i class="bi bi-person-plus-fill text-warning me-2"></i>Usajili wa Mshirika Mpya
                    </h3>
                    <p class="text-white-50 small mb-0">Jaza taarifa zako hapa chini kujiunga rasmi na kanisa la EAGT Golani Christian Center</p>
                </div>
                <a href="{{ route('login') }}" class="btn btn-sm btn-outline-light rounded-pill px-3 py-1 fw-semibold d-inline-flex align-items-center" style="font-size: 0.82rem;">
                    <i class="bi bi-box-arrow-in-right me-1 text-warning"></i> Ingia (Login)
                </a>
            </div>

            <!-- Ujumbe wa Hitilafu -->
            @if($errors->any())
                <div class="alert alert-danger border-0 rounded-3 py-2 px-3 small d-flex align-items-center gap-2 mb-3">
                    <i class="bi bi-exclamation-triangle-fill fs-5 text-danger flex-shrink-0"></i>
                    <div>{{ $errors->first() }}</div>
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST">
                @csrf

                <!-- SEHEMU YA 1: MAJINA KAMILI -->
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label text-light small fw-semibold">
                            Jina la Kwanza *
                        </label>
                        <div class="input-icon-group">
                            <i class="bi bi-person icon-addon"></i>
                            <input type="text" 
                                   name="first_name" 
                                   class="form-control form-control-custom" 
                                   placeholder="mfano: Emmanuel" 
                                   value="{{ old('first_name') }}" 
                                   required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-light small fw-semibold">
                            Jina la Pili / Ukoo *
                        </label>
                        <div class="input-icon-group">
                            <i class="bi bi-person icon-addon"></i>
                            <input type="text" 
                                   name="last_name" 
                                   class="form-control form-control-custom" 
                                   placeholder="mfano: Mushi" 
                                   value="{{ old('last_name') }}" 
                                   required>
                        </div>
                    </div>
                </div>

                <!-- SEHEMU YA 2: MAWASILIANO -->
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label text-light small fw-semibold">
                            Nambari ya Simu * <span class="text-warning small">(Itatumika kuingia na kupokea SMS)</span>
                        </label>
                        <div class="input-icon-group">
                            <i class="bi bi-phone icon-addon"></i>
                            <input type="text" 
                                   name="phone" 
                                   class="form-control form-control-custom" 
                                   placeholder="mfano: 0715 888 999" 
                                   value="{{ old('phone') }}" 
                                   required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-light small fw-semibold">
                            Barua Pepe (Email) <span class="text-white-50 small">(Hiari)</span>
                        </label>
                        <div class="input-icon-group">
                            <i class="bi bi-envelope icon-addon"></i>
                            <input type="email" 
                                   name="email" 
                                   class="form-control form-control-custom" 
                                   placeholder="mfano: jina@gmail.com" 
                                   value="{{ old('email') }}">
                        </div>
                    </div>
                </div>

                <!-- SEHEMU YA 3: JINSIA NA TAREHE YA KUZALIWA -->
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label text-light small fw-semibold">
                            Jinsia *
                        </label>
                        <select name="gender" class="form-select form-select-custom" required>
                            <option value="">-- Chagua Jinsia --</option>
                            <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Mwanaume</option>
                            <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Mwanamke</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-light small fw-semibold">
                            Tarehe ya Kuzaliwa <span class="text-white-50 small">(Hiari)</span>
                        </label>
                        <input type="date" 
                               name="date_of_birth" 
                               class="form-control form-control-custom" 
                               value="{{ old('date_of_birth') }}">
                    </div>
                </div>

                <!-- SEHEMU YA 4: HALI YA NDOA NA MAKAZI -->
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label text-light small fw-semibold">
                            Hali ya Ndoa
                        </label>
                        <select name="marital_status" class="form-select form-select-custom">
                            <option value="Single" {{ old('marital_status') == 'Single' ? 'selected' : '' }}>Sijaoa / Sijaolewa</option>
                            <option value="Married" {{ old('marital_status') == 'Married' ? 'selected' : '' }}>Nimeoa / Nimeolewa</option>
                            <option value="Widowed" {{ old('marital_status') == 'Widowed' ? 'selected' : '' }}>Mjane / Mgane</option>
                            <option value="Divorced" {{ old('marital_status') == 'Divorced' ? 'selected' : '' }}>Nimetengana</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-light small fw-semibold">
                            Mtaa / Makazi Unapoishi
                        </label>
                        <div class="input-icon-group">
                            <i class="bi bi-geo-alt icon-addon"></i>
                            <input type="text" 
                                   name="residential_address" 
                                   class="form-control form-control-custom" 
                                   placeholder="mfano: Kimara-Suka, Mtaa wa Golani" 
                                   value="{{ old('residential_address') }}">
                        </div>
                    </div>
                </div>

                <!-- SEHEMU YA 5: KAZI NA UBATIZO -->
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label text-light small fw-semibold">
                            Kazi / Shughuli
                        </label>
                        <div class="input-icon-group">
                            <i class="bi bi-briefcase icon-addon"></i>
                            <input type="text" 
                                   name="occupation" 
                                   class="form-control form-control-custom" 
                                   placeholder="mfano: Mwalimu, Mfanyabiashara, n.k." 
                                   value="{{ old('occupation') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-light small fw-semibold">
                            Ubatizo wa Maji Mengi
                        </label>
                        <select name="baptism_status" class="form-select form-select-custom">
                            <option value="Not Baptized" {{ old('baptism_status') == 'Not Baptized' ? 'selected' : '' }}>Bado sijabatizwa kwa Maji Mengi</option>
                            <option value="Baptized" {{ old('baptism_status') == 'Baptized' ? 'selected' : '' }}>Ndiyo, nimebatizwa kwa Maji Mengi</option>
                        </select>
                    </div>
                </div>

                <!-- SEHEMU YA 6: IDARA YA KIKANISA -->
                <div class="mb-3">
                    <label class="form-label text-light small fw-semibold">
                        Idara Unayopenda Kujiunga Nayo <span class="text-white-50 small">(Hiari)</span>
                    </label>
                    <select name="department_id" class="form-select form-select-custom">
                        <option value="">-- Chagua Idara ya Kanisa --</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept->id }}" {{ old('department_id') == $dept->id ? 'selected' : '' }}>
                                {{ $dept->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- SEHEMU YA 7: NENOSIRI SALAMA LA KUINGILIA MFUMO -->
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label text-light small fw-semibold">
                            <i class="bi bi-lock-fill text-warning me-1"></i> Nenosiri la Kuingilia (Password) *
                        </label>
                        <div class="input-icon-group">
                            <i class="bi bi-key icon-addon"></i>
                            <input type="password" 
                                   name="password" 
                                   id="regPassword" 
                                   class="form-control form-control-custom pe-5" 
                                   placeholder="Herufi 6 au zaidi" 
                                   required>
                            <button type="button" class="password-toggle-btn" id="toggleRegPwdBtn" title="Onyesha / Ficha">
                                <i class="bi bi-eye" id="toggleRegPwdIcon"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-light small fw-semibold">
                            <i class="bi bi-lock-check text-warning me-1"></i> Thibitisha Nenosiri *
                        </label>
                        <div class="input-icon-group">
                            <i class="bi bi-key icon-addon"></i>
                            <input type="password" 
                                   name="password_confirmation" 
                                   id="regPasswordConfirm" 
                                   class="form-control form-control-custom pe-5" 
                                   placeholder="Rudia nenosiri lile lile" 
                                   required>
                            <button type="button" class="password-toggle-btn" id="toggleConfirmPwdBtn" title="Onyesha / Ficha">
                                <i class="bi bi-eye" id="toggleConfirmPwdIcon"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Kitufe Kikuu cha Kutengeneza Akaunti -->
                <button type="submit" class="btn btn-church-gold w-100 py-3 d-flex align-items-center justify-content-center gap-2 fs-6 shadow">
                    <i class="bi bi-person-check-fill fs-5"></i>
                    <span>Tengeneza Akaunti na Kamilisha Usajili wa Ushirika</span>
                </button>
            </form>

            <!-- Kiungo cha Kuwa na Akaunti -->
            <div class="mt-4 pt-3 border-top border-white border-opacity-10 text-center">
                <span class="text-white-50 small">Tayari una akaunti ya mfumo?</span>
                <a href="{{ route('login') }}" class="text-warning text-decoration-none fw-bold ms-2 small">
                    <i class="bi bi-box-arrow-in-right me-1"></i> Ingia Hapa
                </a>
            </div>

            <!-- Maelezo ya Chini -->
            <div class="mt-3 text-center text-white-50" style="font-size: 0.76rem;">
                Multi-Church Integrated System • EAGT Golani Christian Center © {{ date('Y') }}
            </div>
        </div>

    </div>
</div>

<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
<script>
    // Kuonyesha / Kuficha Nenosiri
    function setupPasswordToggle(buttonId, inputId, iconId) {
        const btn = document.getElementById(buttonId);
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);

        if (btn && input && icon) {
            btn.addEventListener('click', function () {
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('bi-eye');
                    icon.classList.add('bi-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.remove('bi-eye-slash');
                    icon.classList.add('bi-eye');
                }
            });
        }
    }

    setupPasswordToggle('toggleRegPwdBtn', 'regPassword', 'toggleRegPwdIcon');
    setupPasswordToggle('toggleConfirmPwdBtn', 'regPasswordConfirm', 'toggleConfirmPwdIcon');
</script>
</body>
</html>
