@extends('layouts.app')

@section('title', 'Kituo cha Mawasiliano: SMS na WhatsApp - EAGT')

@section('content')
<div class="container-fluid px-4 py-3">
    <!-- Header -->
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h3 class="fw-bold mb-1 text-primary">
                <i class="bi bi-chat-dots-fill me-2"></i>Kituo cha Mawasiliano: SMS & WhatsApp
            </h3>
            <p class="text-muted small mb-0">Usimamizi wa mawasiliano ya haraka kwa washirika kupitia SMS za kawaida na ujumbe wa WhatsApp.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-success text-white px-3 py-2 rounded-pill shadow-sm">
                <i class="bi bi-whatsapp me-1"></i> WhatsApp: Imeunganishwa
            </span>
            <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2 rounded-pill">
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

    <!-- Navigation Tabs -->
    <ul class="nav nav-pills mb-4 gap-2" id="commTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active rounded-pill px-4 fw-bold" id="sms-tab" data-bs-toggle="tab" data-bs-target="#smsPane" type="button" role="tab">
                <i class="bi bi-chat-text-fill me-2"></i>Ujumbe wa SMS (Simu Zote)
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link rounded-pill px-4 fw-bold" id="whatsapp-tab" data-bs-toggle="tab" data-bs-target="#whatsappPane" type="button" role="tab" style="color: #128C7E;">
                <i class="bi bi-whatsapp me-2"></i>Mawasiliano ya WhatsApp
            </button>
        </li>
    </ul>

    <div class="tab-content" id="commTabsContent">
        <!-- 1. SMS Tab Pane -->
        <div class="tab-pane fade show active" id="smsPane" role="tabpanel">
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
                                    <label class="form-label fw-bold">Walengwa wa SMS <span class="text-danger">*</span></label>
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
                                    <input type="text" name="custom_phone" class="form-control" placeholder="k.m. 0715888999, 0765222333 (tenganisha kwa koma)">
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
                                        <i class="bi bi-send me-1"></i> Tuma SMS Sasa
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Instructions & Recent Logs -->
                <div class="col-lg-5">
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

        <!-- 2. WhatsApp Hub Pane -->
        <div class="tab-pane fade" id="whatsappPane" role="tabpanel">
            <div class="row g-4">
                <!-- WhatsApp Broadcast Generator -->
                <div class="col-lg-7">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white border-bottom py-3">
                            <h5 class="fw-bold mb-0 text-dark">
                                <i class="bi bi-whatsapp text-success me-2"></i>Tunga Ujumbe wa WhatsApp (Group au Mtu Binafsi)
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Namba ya Simu ya Mshirika (Si lazima kwa ujumbe wa Magroup)</label>
                                <input type="text" id="waPhone" class="form-control" placeholder="k.m. 0715888999 au acha wazi kama ni kwa ajili ya Group">
                            </div>

                            <div class="mb-3">
                                <label class="form-label small text-muted fw-bold">VIBONGO VYA HARAKA VYA WHATSAPP:</label>
                                <div class="d-flex flex-wrap gap-2">
                                    <button type="button" class="btn btn-sm btn-outline-success" onclick="applyWaTemplate('sunday')">
                                        <i class="bi bi-calendar2-check me-1"></i>Mwaliko wa Ibada
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-success" onclick="applyWaTemplate('building')">
                                        <i class="bi bi-hammer me-1"></i>Taarifa ya Ujenzi
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-success" onclick="applyWaTemplate('prayer')">
                                        <i class="bi bi-heart-pulse me-1"></i>Ombi la Maombi
                                    </button>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Maneno ya Ujumbe wa WhatsApp</label>
                                <textarea id="waMessage" rows="6" class="form-control" placeholder="Andika ujumbe wa WhatsApp hapa... Unaweza kutumia alama za *kwa herufi nzito* na _kwa herufi mlazo_"></textarea>
                            </div>

                            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 pt-2">
                                <button type="button" class="btn btn-outline-secondary" onclick="document.getElementById('waMessage').value = '';">
                                    Futa
                                </button>
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn btn-success px-4" onclick="openWhatsAppChat()">
                                        <i class="bi bi-whatsapp me-2"></i>Fungua WhatsApp & Tuma
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- WhatsApp Channels & Group Links -->
                <div class="col-lg-5">
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-white border-bottom py-3">
                            <h6 class="fw-bold mb-0 text-dark">
                                <i class="bi bi-diagram-3-fill text-success me-2"></i>Mawasiliano ya Moja kwa Moja ya Kanisa
                            </h6>
                        </div>
                        <div class="card-body p-4">
                            <div class="list-group list-group-flush">
                                <div class="list-group-item px-0 py-3 d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="fw-bold">Mchungaji Kiongozi</div>
                                        <small class="text-muted">+255 754 111 002 • Ushauri na Maombi</small>
                                    </div>
                                    <a href="{{ \App\Services\WhatsAppService::chatUrl('0754111002', 'Bwana Asifiwe Mchungaji! Ninaomba ushauri wa kichungaji na maombi.') }}" target="_blank" class="btn btn-sm btn-success rounded-pill px-3">
                                        <i class="bi bi-whatsapp"></i> Chat
                                    </a>
                                </div>
                                <div class="list-group-item px-0 py-3 d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="fw-bold">Ofisi ya Kanisa / Katibu</div>
                                        <small class="text-muted">+255 754 123 456 • Ratiba na Vyeti</small>
                                    </div>
                                    <a href="{{ \App\Services\WhatsAppService::chatUrl('0754123456', 'Bwana Asifiwe! Ninaulizia kuhusu taarifa za kanisa EAGT Golani.') }}" target="_blank" class="btn btn-sm btn-success rounded-pill px-3">
                                        <i class="bi bi-whatsapp"></i> Chat
                                    </a>
                                </div>
                                <div class="list-group-item px-0 py-3 d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="fw-bold">Kiongozi wa Vijana (CGM)</div>
                                        <small class="text-muted">+255 765 222 333 • Kambi & Kwaya</small>
                                    </div>
                                    <a href="{{ \App\Services\WhatsAppService::chatUrl('0765222333', 'Bwana Asifiwe Kiongozi! Ningependa taarifa za idara ya vijana CGM.') }}" target="_blank" class="btn btn-sm btn-success rounded-pill px-3">
                                        <i class="bi bi-whatsapp"></i> Chat
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Meta WhatsApp Cloud API Info -->
                    <div class="card shadow-sm border-0 bg-light">
                        <div class="card-body p-4">
                            <h6 class="fw-bold text-dark mb-2">
                                <i class="bi bi-cloud-check-fill text-success me-2"></i>WhatsApp Cloud API
                            </h6>
                            <p class="small text-muted mb-2">
                                Mfumo una uwezo wa kuunganishwa na <strong>Meta WhatsApp Business Cloud API</strong> kwa ajili ya kutuma ujumbe wa kiotomatiki moja kwa moja bila kuhitaji kufungua WhatsApp Web.
                            </p>
                            <p class="small text-muted mb-0">
                                Weka vigezo vya <code>WHATSAPP_TOKEN</code> na <code>WHATSAPP_PHONE_ID</code> kwenye faili la <code>.env</code> utakapotaka kutumia Cloud API rasmi ya Meta.
                            </p>
                        </div>
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

function applyWaTemplate(type) {
    const church = '{{ $church ? $church->name : "EAGT Golani" }}';
    let text = '';
    if (type === 'sunday') {
        text = `*BWANA ASIFIWE!* 🌟\n\nUongozi wa Kanisa la *${church}* unakukaribisha katika *Ibada Kuu ya Jumapili*:\n\n⏰ *Muda:* Saa 02:30 Asubuhi - 06:30 Mchana\n📍 *Mahali:* Hekalu Kuu la Golani, Kimara-Suka\n📖 *Neno:* Sifa, Kuabudu, Meza ya Bwana & Ukombozi.\n\n_\"Nilifurahi waliponiambia: Na twende nyumbani mwa Bwana\" (Zaburi 122:1)_\n\nNjoo na familia yako na rafiki tubarikiwe pamoja!`;
    } else if (type === 'building') {
        text = `*TAARIFA YA MRADI WA UJENZI WA HEKALU - ${church}* 🏛️\n\nWapendwa washirika na wadau wa maendeleo, ujenzi wa Hekalu jipya la ghorofa unaendelea vizuri. Tunawashukuru wote wanaoendelea kutoa michango na ahadi zao.\n\nMungu azidi kuwabariki na kuwainua!`;
    } else if (type === 'prayer') {
        text = `*MAOMBI NA MAOMBEZI - ${church}* 🙏\n\nJe, una hitaji la maombi au unahitaji Mchungaji akuombee? Wasiliana nasi au tuma ujumbe wako hapa tutasimama nawe katika imani. Mungu wetu anatenda miujiza!`;
    }
    document.getElementById('waMessage').value = text;
}

function openWhatsAppChat() {
    const rawPhone = document.getElementById('waPhone').value.trim();
    const msg = document.getElementById('waMessage').value.trim();

    if (!msg) {
        alert('Tafadhali andika ujumbe wa WhatsApp kabla ya kutuma.');
        return;
    }

    let url = 'https://wa.me/';
    if (rawPhone) {
        let clean = rawPhone.replace(/[^0-9]/g, '');
        if (clean.startsWith('0') && clean.length === 10) {
            clean = '255' + clean.substring(1);
        } else if (clean.length === 9) {
            clean = '255' + clean;
        }
        url += clean;
    }

    url += '?text=' + encodeURIComponent(msg);
    window.open(url, '_blank');
}
</script>
@endsection
