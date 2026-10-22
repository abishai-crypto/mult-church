@extends('layouts.app')

@section('title', 'Kituo cha Mawasiliano ya SMS - EAGT')

@section('content')
<div class="container-fluid px-4 py-3">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1 text-primary">
                <i class="bi bi-chat-dots-fill me-2"></i>Kituo cha Mawasiliano ya SMS (Bulk & Direct SMS)
            </h3>
            <p class="text-muted small mb-0">Tuma ujumbe mfupi kwa washirika wote, idara za kanisa au namba maalum kwa haraka.</p>
        </div>
        <div>
            <span class="badge bg-success-subtle text-success border border-success px-3 py-2">
                <i class="bi bi-broadcast me-1"></i> SMS Gateway: {{ strtoupper(env('SMS_PROVIDER', 'LOG (Majaribio)')) }}
            </span>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        <!-- Send SMS Form -->
        <div class="col-lg-7">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-send-fill text-primary me-2"></i>Tunga Ujumbe Mpya wa SMS
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('sms.send') }}" method="POST" id="smsForm">
                        @csrf

                        <!-- Target selection -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Walengwa wa Ujumbe (Recipients) <span class="text-danger">*</span></label>
                            <div class="row g-2">
                                <div class="col-md-4">
                                    <input type="radio" class="btn-check" name="target_type" id="targetAll" value="all_members" checked onchange="toggleTargetFields()">
                                    <label class="btn btn-outline-primary w-100 text-start py-2" for="targetAll">
                                        <i class="bi bi-people-fill me-1"></i> Waumini Wote
                                        <div class="small text-muted">{{ $membersCount }} wenye namba</div>
                                    </label>
                                </div>
                                <div class="col-md-4">
                                    <input type="radio" class="btn-check" name="target_type" id="targetDept" value="department" onchange="toggleTargetFields()">
                                    <label class="btn btn-outline-primary w-100 text-start py-2" for="targetDept">
                                        <i class="bi bi-diagram-3-fill me-1"></i> Kwa Idara
                                        <div class="small text-muted">Vijana, Kwaya, WWK...</div>
                                    </label>
                                </div>
                                <div class="col-md-4">
                                    <input type="radio" class="btn-check" name="target_type" id="targetCustom" value="custom" onchange="toggleTargetFields()">
                                    <label class="btn btn-outline-primary w-100 text-start py-2" for="targetCustom">
                                        <i class="bi bi-telephone-fill me-1"></i> Namba Maalum
                                        <div class="small text-muted">Andika kwa mkono</div>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Department select field -->
                        <div class="mb-3 d-none" id="departmentField">
                            <label class="form-label fw-bold">Chagua Idara <span class="text-danger">*</span></label>
                            <select name="department_id" class="form-select">
                                <option value="">-- Chagua Idara --</option>
                                @foreach($departments as $dept)
                                    <option value="{{ $dept->id }}">{{ $dept->name }} ({{ $dept->members()->count() }} washirika)</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Custom phone numbers field -->
                        <div class="mb-3 d-none" id="customPhoneField">
                            <label class="form-label fw-bold">Namba ya Simu <span class="text-danger">*</span></label>
                            <input type="text" name="custom_phone" class="form-select" placeholder="k.m. 0715888999, 0765222333 (tenganisha kwa koma)">
                            <div class="form-text">Unaweza kuweka namba moja au zaidi zilizotenganishwa kwa mkato (,).</div>
                        </div>

                        <!-- Quick Template Buttons -->
                        <div class="mb-3">
                            <label class="form-label small text-muted fw-bold">MIFANO YA HARAKA (TEMPLATES):</label>
                            <div class="d-flex flex-wrap gap-2">
                                <button type="button" class="btn btn-sm btn-light border" onclick="applyTemplate('sunday')">
                                    <i class="bi bi-bell me-1"></i>Kikumbusho cha Ibada
                                </button>
                                <button type="button" class="btn btn-sm btn-light border" onclick="applyTemplate('vigil')">
                                    <i class="bi bi-moon-stars me-1"></i>Mkesha wa Ijumaa
                                </button>
                                <button type="button" class="btn btn-sm btn-light border" onclick="applyTemplate('meeting')">
                                    <i class="bi bi-calendar-event me-1"></i>Kikao cha Idara
                                </button>
                            </div>
                        </div>

                        <!-- Message Textarea -->
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <label class="form-label fw-bold mb-0">Maneno ya Ujumbe <span class="text-danger">*</span></label>
                                <span class="small text-muted" id="charCounter">Herufi: 0 / 160 (SMS 1)</span>
                            </div>
                            <textarea name="message" id="smsMessage" rows="5" class="form-control" placeholder="Andika ujumbe wako hapa..." required oninput="updateCharCount()"></textarea>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary px-4 py-2">
                                <i class="bi bi-send me-1"></i> Tuma Ujumbe Sasa
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Instructions & Recent Logs -->
        <div class="col-lg-5">
            <!-- Setup Guide Card -->
            <div class="card shadow-sm border-0 mb-4 bg-light">
                <div class="card-body p-4">
                    <h6 class="fw-bold text-dark mb-2">
                        <i class="bi bi-info-circle-fill text-primary me-2"></i>Jinsi SMS Zinavyofanya Kazi
                    </h6>
                    <ul class="small text-muted mb-0 ps-3">
                        <li class="mb-1"><strong>Majaribio (Local):</strong> SMS zote zinarekodiwa kwenye logi za seva (<code>storage/logs/laravel.log</code>) bila gharama.</li>
                        <li class="mb-1"><strong>Cloud / Uzalishaji:</strong> Unaweza kuunganisha API ya <strong>Beem Africa</strong> au <strong>NextSMS</strong> kwa kuweka funguo kwenye faili la <code>.env</code>.</li>
                        <li><strong>Otomatiki:</strong> Mfumo unatuma SMS ya kiotomatiki ya risiti mara tu Zaka inapothibitishwa na Mzee wa Kanisa.</li>
                    </ul>
                </div>
            </div>

            <!-- Recent Dispatches -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom py-3">
                    <h6 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-clock-history text-secondary me-2"></i>Historia ya SMS Zilizotumwa
                    </h6>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush small">
                        @forelse($recentSms as $log)
                            <div class="list-group-item p-3">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="badge bg-primary-subtle text-primary">{{ $log->user_name }}</span>
                                    <span class="text-muted" style="font-size: 11px;">{{ $log->created_at->diffForHumans() }}</span>
                                </div>
                                <div class="text-dark">{{ $log->description }}</div>
                            </div>
                        @empty
                            <div class="p-4 text-center text-muted">
                                Bado hakuna ujumbe wa SMS uliotumwa.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function toggleTargetFields() {
    const isDept = document.getElementById('targetDept').checked;
    const isCustom = document.getElementById('targetCustom').checked;

    document.getElementById('departmentField').classList.toggle('d-none', !isDept);
    document.getElementById('customPhoneField').classList.toggle('d-none', !isCustom);
}

function updateCharCount() {
    const text = document.getElementById('smsMessage').value;
    const len = text.length;
    const count = Math.ceil(len / 160) || 1;
    document.getElementById('charCounter').textContent = `Herufi: ${len} / ${count * 160} (SMS ${count})`;
}

function applyTemplate(type) {
    const church = '{{ $church ? $church->name : "EAGT Golani" }}';
    let text = '';
    if (type === 'sunday') {
        text = `Bwana Asifiwe! Uongozi wa ${church} unakukaribisha katika Ibada Kuu ya Jumapili kuanzia saa 02:30 Asubuhi. Njoo na mwingine tubarikiwe pamoja!`;
    } else if (type === 'vigil') {
        text = `Mpendwa mshirika wa ${church}, usikose Mkesha Mkuu wa Ijumaa hii kuanzia saa 03:30 Usiku. Maombi ya nguvu, uponyaji na kufunguliwa!`;
    } else if (type === 'meeting') {
        text = `Mpendwa kiongozi/mwanaidara wa ${church}, unakumbushwa kuhusu kikao muhimu cha idara Jumamosi saa 10:00 Jioni. Tafadhali fika bila kukosa.`;
    }
    document.getElementById('smsMessage').value = text;
    updateCharCount();
}
</script>
@endsection
