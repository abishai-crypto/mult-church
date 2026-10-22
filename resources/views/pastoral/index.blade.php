@extends('layouts.app')

@section('title', 'Huduma ya Kichungaji na Maombi')

@section('content')
<div class="container-fluid px-0">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h3 class="fw-bold mb-1">Huduma ya Kichungaji, Kutembelea Washirika na Maombi</h3>
            <p class="text-muted mb-0 small">Uchungaji wa kundi la Mungu, kutembelea wagonjwa na familia, na maombi ya siri</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-warning btn-sm rounded-pill px-3 shadow-sm text-dark fw-bold" data-bs-toggle="modal" data-bs-target="#prayerModal">
                <i class="bi bi-heart-fill me-1"></i> Wasilisha Ombi la Maombi
            </button>
            @if(Auth::user()->isPastor() || Auth::user()->isElder())
                <button class="btn btn-primary-custom btn-sm rounded-pill px-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#visitModal">
                    <i class="bi bi-person-walking me-1"></i> Rekodi Ziara ya Kichungaji
                </button>
            @endif
        </div>
    </div>

    <!-- 3 Stat Cards -->
    <div class="row g-3 mb-4">
        <div class="col-sm-4">
            <div class="stat-card" style="background: linear-gradient(135deg, #d97706 0%, #f59e0b 100%);">
                <div class="stat-card-icon"><i class="bi bi-hourglass-split"></i></div>
                <div class="text-white-50 text-uppercase small fw-bold">Maombi Yanayosubiri</div>
                <h2 class="fw-bold my-2 text-white">{{ $pendingPrayers }}</h2>
                <div class="small text-white-50">Yanahitaji kupangiwa waombaji</div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="stat-card" style="background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);">
                <div class="stat-card-icon"><i class="bi bi-fire"></i></div>
                <div class="text-white-50 text-uppercase small fw-bold">Yanaombewa Sasa</div>
                <h2 class="fw-bold my-2 text-white">{{ $prayingCount }}</h2>
                <div class="small text-white-50">Yamo kwenye maombi ya viongozi</div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="stat-card" style="background: linear-gradient(135deg, #059669 0%, #10b981 100%);">
                <div class="stat-card-icon"><i class="bi bi-check-all"></i></div>
                <div class="text-white-50 text-uppercase small fw-bold">Yaliyojibiwa (Shuhuda)</div>
                <h2 class="fw-bold my-2 text-white">{{ $answeredPrayers }}</h2>
                <div class="small text-white-50">Matendo makuu ya Mungu kwa washirika</div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Prayer Requests Section -->
        <div class="col-lg-7">
            <div class="card-custom p-4 h-100">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div>
                        <h5 class="fw-bold mb-0">Maombi na Shuhuda za Ushindi</h5>
                        <small class="text-muted">
                            @if(Auth::user()->isPastor() || Auth::user()->isElder())
                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle">
                                    <i class="bi bi-eye-fill"></i> Hali ya Siri Imewashwa (Mchungaji & Wazee wa Kanisa)
                                </span>
                            @else
                                Ubao wa maombi ya kanisa
                            @endif
                        </small>
                    </div>
                </div>

                <div class="d-flex flex-column gap-3">
                    @forelse($prayerRequests as $prayer)
                        <div class="p-3 rounded-3 border {{ $prayer->is_confidential ? 'bg-danger-subtle border-danger-subtle' : 'bg-light' }}">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <strong class="text-dark">{{ $prayer->requester_name }}</strong>
                                    @if($prayer->is_confidential)
                                        <span class="badge bg-danger rounded-pill ms-1"><i class="bi bi-lock-fill"></i> SIRI YA KICHUNGAJI</span>
                                    @endif
                                    <span class="badge bg-light text-dark border ms-1">{{ $prayer->category }}</span>
                                </div>
                                <span class="badge bg-{{ $prayer->status == 'answered' ? 'success' : ($prayer->status == 'praying' ? 'primary' : 'warning text-dark') }} rounded-pill">
                                    @if($prayer->status == 'answered') Limejibiwa @elseif($prayer->status == 'praying') Linaombewa @else Linasubiri @endif
                                </span>
                            </div>

                            <p class="small text-dark mb-2">{{ $prayer->request_text }}</p>

                            @if($prayer->pastoral_notes && (Auth::user()->isPastor() || Auth::user()->isElder()))
                                <div class="p-2 bg-white rounded border border-danger-subtle small mb-2 text-danger">
                                    <strong><i class="bi bi-shield-lock"></i> Maoni ya Siri ya Kichungaji:</strong> {{ $prayer->pastoral_notes }}
                                </div>
                            @endif

                            @if($prayer->testimony)
                                <div class="p-2 bg-white rounded border border-success-subtle small text-success">
                                    <strong><i class="bi bi-trophy"></i> Ushuhuda / Sifa kwa Mungu:</strong> {{ $prayer->testimony }}
                                </div>
                            @endif

                            <!-- Pastoral Update Status Button -->
                            @if(Auth::user()->isPastor() || Auth::user()->isElder())
                                <div class="mt-2 pt-2 border-top d-flex justify-content-end">
                                    <button class="btn btn-outline-dark btn-sm rounded-pill" data-bs-toggle="modal" data-bs-target="#updatePrayerModal_{{ $prayer->id }}">
                                        <i class="bi bi-pencil-square me-1"></i> Badili Hali / Weka Maoni ya Kichungaji
                                    </button>
                                </div>

                                <!-- Update Prayer Modal -->
                                <div class="modal fade" id="updatePrayerModal_{{ $prayer->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="{{ route('pastoral.prayers.updateStatus', $prayer) }}" method="POST">
                                                @csrf
                                                <div class="modal-header">
                                                    <h5 class="modal-title fw-bold">Sasisha Hali ya Ombi la Maombi</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label class="form-label small fw-semibold">Hali *</label>
                                                        <select name="status" class="form-select" required>
                                                            <option value="pending" {{ $prayer->status == 'pending' ? 'selected' : '' }}>Linasubiri (Pending)</option>
                                                            <option value="praying" {{ $prayer->status == 'praying' ? 'selected' : '' }}>Linaombewa (Currently Praying)</option>
                                                            <option value="answered" {{ $prayer->status == 'answered' ? 'selected' : '' }}>Limejibiwa - Shuhuda (Answered)</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label small fw-semibold">Maelezo ya Siri ya Kichungaji</label>
                                                        <textarea name="pastoral_notes" class="form-control" rows="2">{{ $prayer->pastoral_notes }}</textarea>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label small fw-semibold">Ushuhuda wa Kujibiwa kwa Maombi</label>
                                                        <textarea name="testimony" class="form-control" rows="2" placeholder="Weka ushuhuda wa mshirika jinsi Mungu alivyotenda...">{{ $prayer->testimony }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Ghairi</button>
                                                    <button type="submit" class="btn btn-primary">Hifadhi Mabadiliko</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @empty
                        <p class="text-center text-muted py-4">Hakuna maombi yaliyorekodiwa bado.</p>
                    @endforelse
                </div>

                <div class="mt-4">
                    {{ $prayerRequests->links() }}
                </div>
            </div>
        </div>

        <!-- Pastoral Visits Section -->
        <div class="col-lg-5">
            <div class="card-custom p-4 h-100">
                <h5 class="fw-bold mb-3"><i class="bi bi-person-walking text-primary me-2"></i>Ziara za Kichungaji</h5>
                <div class="d-flex flex-column gap-3">
                    @forelse($visits as $visit)
                        <div class="p-3 bg-light rounded-3 border-start border-4 border-primary">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <strong class="text-dark">{{ $visit->member->full_name }}</strong>
                                <span class="badge bg-primary-subtle text-primary">{{ $visit->visit_type }}</span>
                            </div>
                            <div class="small text-muted mb-2">
                                <i class="bi bi-calendar-event me-1"></i>{{ $visit->visit_date->format('d/m/Y') }} • Mtumishi: {{ $visit->pastor->name }}
                            </div>
                            <p class="small text-muted mb-1">{{ $visit->notes }}</p>
                            @if($visit->follow_up_required)
                                <span class="badge bg-warning-subtle text-warning border">
                                    <i class="bi bi-bell-fill me-1"></i> Ufuatiliaji: {{ $visit->follow_up_date ? $visit->follow_up_date->format('d/m/Y') : 'Inahitajika' }}
                                </span>
                            @endif
                        </div>
                    @empty
                        <p class="text-center text-muted py-4">Hakuna kumbukumbu za ziara za kichungaji.</p>
                    @endforelse
                </div>

                <div class="mt-4">
                    {{ $visits->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Submit Prayer Request Modal -->
<div class="modal fade" id="prayerModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('pastoral.prayers.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Wasilisha Ombi la Maombi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Jina Lako *</label>
                        <input type="text" name="requester_name" class="form-control" value="{{ Auth::user()->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Namba ya Simu</label>
                        <input type="text" name="requester_phone" class="form-control" value="{{ Auth::user()->phone }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Kundi la Hitaji *</label>
                        <select name="category" class="form-select" required>
                            <option value="Uponyaji">Afya na Uponyaji (Health & Healing)</option>
                            <option value="Familia">Familia na Ndoa (Family & Marriage)</option>
                            <option value="Uchumi">Uchumi, Kazi na Biashara (Financial Breakthrough)</option>
                            <option value="Ufunguo">Kufunguliwa na Ulinzi wa Kiroho (Deliverance)</option>
                            <option value="Shukrani">Shukrani na Sifa (Thanksgiving)</option>
                            <option value="Maombi ya Jumla">Maombi ya Jumla (General Intercession)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Maelezo ya Hitaji Lako *</label>
                        <textarea name="request_text" class="form-control" rows="4" placeholder="Eleza hitaji lako kwa ufupi..." required></textarea>
                    </div>
                    <div class="form-check p-3 bg-light rounded-3 border">
                        <input class="form-check-input ms-0 me-2" type="checkbox" name="is_confidential" id="confidentialCheck" value="1">
                        <label class="form-check-label fw-bold text-danger small" for="confidentialCheck">
                            <i class="bi bi-shield-lock-fill"></i> Liwe Hitaji la Siri ya Kichungaji
                        </label>
                        <small class="d-block text-muted">Likiwekwa kama la siri, ni Mchungaji Kiongozi na Wazee wa Kanisa walioidhinishwa pekee watakaoona ombi hili.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Ghairi</button>
                    <button type="submit" class="btn btn-warning fw-bold text-dark">Wasilisha Ombi</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Log Pastoral Visit Modal -->
<div class="modal fade" id="visitModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('pastoral.visits.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Rekodi Ziara ya Kichungaji</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Mshirika Aliyetembelewa *</label>
                        <select name="member_id" class="form-select" required>
                            <option value="">-- Chagua Mshirika --</option>
                            @foreach($members as $m)
                                <option value="{{ $m->id }}">{{ $m->full_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-semibold">Aina ya Ziara *</label>
                            <select name="visit_type" class="form-select" required>
                                <option value="Ziara ya Nyumbani">Ziara ya Nyumbani (Home Visit)</option>
                                <option value="Hospitali">Kutembelea Hospitali (Hospital Visit)</option>
                                <option value="Ushauri wa Kichungaji">Kikao cha Ushauri (Counseling Session)</option>
                                <option value="Msiba / Faraja">Faraja ya Msiba (Bereavement)</option>
                                <option value="Mawasiliano ya Simu">Kujulia Hali kwa Simu (Phone Call)</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-semibold">Tarehe ya Ziara *</label>
                            <input type="date" name="visit_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Maelezo ya Ziara na Ushauri Uliotolewa</label>
                        <textarea name="notes" class="form-control" rows="3" placeholder="Hali ya familia, maombi yaliyofanyika, ushauri uliopewa..."></textarea>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <div class="form-check pt-2">
                                <input class="form-check-input" type="checkbox" name="follow_up_required" id="followUpCheck" value="1">
                                <label class="form-check-label small fw-semibold" for="followUpCheck">Ufuatiliaji Unahitajika</label>
                            </div>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-semibold">Tarehe ya Ufuatiliaji</label>
                            <input type="date" name="follow_up_date" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Ghairi</button>
                    <button type="submit" class="btn btn-primary">Hifadhi Ziara</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
