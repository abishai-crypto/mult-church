<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kurejesha Nenosiri - EAGT GOLANI, KIMARA-SUKA</title>
    
    <!-- Local & Google Assets -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/icons/bootstrap-icons.min.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Cinzel:wght@600;700;800&display=swap" rel="stylesheet">

    <style>
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
        }

        .recovery-card {
            border: 1px solid rgba(255, 255, 255, 0.14);
            background: rgba(10, 18, 38, 0.94);
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            border-radius: 28px;
            box-shadow: 0 30px 70px -15px rgba(0, 0, 0, 0.8), 0 0 50px -10px rgba(30, 64, 175, 0.3);
            max-width: 620px;
            width: 100%;
            padding: 3rem 2.5rem;
            color: #ffffff;
            position: relative;
            z-index: 10;
        }

        .church-emblem-ring {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            padding: 3px;
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
        }

        .input-icon-group .form-control-custom {
            padding-left: 2.85rem;
        }

        .input-icon-group:focus-within .icon-addon {
            color: #f59e0b;
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

        .church-policy-box {
            background: rgba(30, 64, 175, 0.15);
            border: 1px solid rgba(59, 130, 246, 0.25);
            border-radius: 14px;
            padding: 1.15rem;
        }
    </style>
</head>
<body>

<div class="recovery-card">
    <div class="text-center mb-4">
        <div class="church-emblem-ring mb-3">
            <img src="{{ asset('assets/images/eagt_logo.jpg') }}" alt="EAGT Logo" class="church-emblem-img">
        </div>
        <div class="badge bg-warning text-dark fw-bold px-3 py-1 rounded-pill mb-2">
            EAGT GOLANI - KIMARA-SUKA
        </div>
        <h3 class="fw-bold mb-1 text-white">Kurejesha Nenosiri la Kikanisa</h3>
        <p class="text-white-50 small mb-0">Uthibitisho na mwongozo wa usalama wa akaunti chini ya Wazee wa Kanisa na Mchungaji</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 rounded-4 p-3 mb-4 d-flex align-items-center gap-3">
            <i class="bi bi-check-circle-fill fs-3 text-success"></i>
            <div>
                <h6 class="fw-bold mb-1">Ombi Limewasilishwa Salama!</h6>
                <small class="text-white-50 d-block">{{ session('success') }}</small>
            </div>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger border-0 rounded-3 py-2 px-3 small mb-3">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('password.email') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label text-light small fw-semibold">
                <i class="bi bi-person-badge-fill text-warning me-1"></i> Barua Pepe au Namba ya Simu Iliyosajiliwa *
            </label>
            <div class="input-icon-group">
                <i class="bi bi-envelope icon-addon"></i>
                <input type="text" 
                       name="identifier" 
                       class="form-control form-control-custom" 
                       placeholder="mfano: mshirika@eagt.org au 07XXXXXXXX" 
                       value="{{ old('identifier') }}" 
                       required 
                       autofocus>
            </div>
            <small class="text-white-50" style="font-size: 0.8rem;">Weka barua pepe au namba ya simu iliyopo kwenye daftari la waumini.</small>
        </div>

        <div class="mb-3">
            <label class="form-label text-light small fw-semibold">
                <i class="bi bi-person-fill text-warning me-1"></i> Jina Lako Kamili (Kama Linavyofahamika Kanisani)
            </label>
            <input type="text" 
                   name="requester_name" 
                   class="form-control form-control-custom" 
                   placeholder="mfano: Daudi Samweli Mushi" 
                   value="{{ old('requester_name') }}">
        </div>

        <div class="mb-4">
            <label class="form-label text-light small fw-semibold">
                <i class="bi bi-chat-text-fill text-warning me-1"></i> Sababu au Maelezo ya Ziada (Hiari)
            </label>
            <textarea name="reason" 
                      class="form-control form-control-custom" 
                      rows="2" 
                      placeholder="mfano: Nimebadili simu / Nimesahau nenosiri la akaunti yangu..."></textarea>
        </div>

        <!-- Mwongozo wa Kikanisa -->
        <div class="church-policy-box mb-4">
            <div class="d-flex align-items-center gap-2 mb-2 text-warning fw-bold small">
                <i class="bi bi-shield-check fs-5"></i> Taratibu za Usalama wa Kikanisa:
            </div>
            <small class="text-white text-opacity-80 d-block" style="line-height: 1.55; font-size: 0.83rem;">
                Kwa mujibu wa taratibu za kanisa, maombi ya kurejesha nenosiri yanakaguliwa na kuthibitishwa na <strong>Wazee wa Kanisa au Mchungaji Kiongozi</strong> ili kulinda usalama na faragha ya taarifa za usharika. Nenosiri jipya la muda litatumwa kwa njia ya SMS au Barua Pepe pindi litakapoidhinishwa.
            </small>
        </div>

        <button type="submit" class="btn btn-church-gold w-100 py-3 d-flex align-items-center justify-content-center gap-2 fs-6 shadow">
            <i class="bi bi-send-fill fs-5"></i>
            <span>Wasilisha Ombi la Kurejesha Nenosiri</span>
        </button>
    </form>

    <div class="text-center mt-4 pt-3 border-top border-white border-opacity-10">
        <a href="{{ route('login') }}" class="text-warning text-decoration-none small fw-semibold">
            <i class="bi bi-arrow-left me-1"></i> Rudi Kwenye Ukurasa wa Kuingia (Login)
        </a>
    </div>

    <!-- Mawasiliano ya Haraka -->
    <div class="text-center mt-3 text-white-50" style="font-size: 0.8rem;">
        Msaada wa Dharura: Mchungaji Kiongozi: <span class="text-warning">+255 754 111 222</span> | Katibu: <span class="text-warning">+255 754 888 999</span>
    </div>
</div>

<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
