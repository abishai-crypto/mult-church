@extends('layouts.app')

@section('title', 'Matangazo na Kalenda ya Kanisa')

@section('content')
<div class="container-fluid px-0">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h3 class="fw-bold mb-1">Matangazo, Ratiba na Kalenda ya Kanisa</h3>
            <p class="text-muted mb-0 small">Kuwataarifu washirika na idara za kanisa kuhusu shughuli, semina, mikutano na matukio maalum</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-primary btn-sm rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#newEventModal">
                <i class="bi bi-calendar-plus me-1"></i> Panga Tukio / Kongamano
            </button>
            <button class="btn btn-primary-custom btn-sm rounded-pill px-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#newAnnouncementModal">
                <i class="bi bi-megaphone-fill me-1"></i> Tangaza Tangazo
            </button>
        </div>
    </div>

    <div class="row g-4">
        <!-- Announcements Column -->
        <div class="col-lg-7">
            <h5 class="fw-bold mb-3"><i class="bi bi-pin-angle-fill text-danger me-2"></i>Matangazo Rasmi ya Kanisa</h5>
            
            <!-- Pinned Announcements -->
            @foreach($pinnedAnnouncements as $pinned)
                <div class="card-custom p-4 mb-3 border-danger border-2">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="badge bg-danger rounded-pill px-3 py-1">
                            <i class="bi bi-pin-fill me-1"></i> TANGAZO MUHIMU SANA
                        </span>
                        <small class="text-muted">{{ $pinned->publish_date ? $pinned->publish_date->format('d/m/Y') : 'Hai' }}</small>
                    </div>
                    <h5 class="fw-bold text-dark mb-2">{{ $pinned->title }}</h5>
                    <p class="text-muted small mb-3">{{ $pinned->content }}</p>
                    <div class="small text-muted border-top pt-2">
                        <i class="bi bi-person me-1"></i> Limetangazwa na {{ $pinned->author?->name ?? 'Uongozi' }} • Walengwa: <span class="badge bg-light text-dark border">{{ strtoupper($pinned->audience) }}</span>
                    </div>
                </div>
            @endforeach

            <!-- Regular Announcements -->
            @forelse($regularAnnouncements as $ann)
                <div class="card-custom p-4 mb-3">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="badge bg-{{ $ann->priority == 'urgent' ? 'danger' : 'light text-dark' }} border">
                            Umuhimu: {{ ucfirst($ann->priority) }}
                        </span>
                        <small class="text-muted">{{ $ann->publish_date ? $ann->publish_date->format('d/m/Y') : '' }}</small>
                    </div>
                    <h6 class="fw-bold text-dark mb-2">{{ $ann->title }}</h6>
                    <p class="text-muted small mb-2">{{ $ann->content }}</p>
                    <div class="small text-muted border-top pt-2">
                        <i class="bi bi-person me-1"></i> {{ $ann->author?->name ?? 'Uongozi' }}
                    </div>
                </div>
            @empty
                <p class="text-muted small">Hakuna matangazo mengine kwa sasa.</p>
            @endforelse

            <div class="mt-4">
                {{ $regularAnnouncements->links() }}
            </div>
        </div>

        <!-- Events Calendar Column -->
        <div class="col-lg-5">
            <h5 class="fw-bold mb-3"><i class="bi bi-calendar3 text-primary me-2"></i>Kalenda ya Matukio Yanayokuja</h5>
            
            <div class="d-flex flex-column gap-3">
                @forelse($upcomingEvents as $evt)
                    <div class="card-custom p-3 border-start border-4" style="border-left-color: {{ $evt->color }} !important;">
                        <div class="d-flex align-items-center gap-3">
                            <div class="text-center rounded-3 p-2 text-white fw-bold" style="min-width: 60px; background: {{ $evt->color }};">
                                <small class="text-uppercase d-block" style="font-size: 0.72rem;">{{ $evt->start_time->format('M') }}</small>
                                <span class="fs-4">{{ $evt->start_time->format('d') }}</span>
                            </div>
                            <div>
                                <h6 class="fw-bold text-dark mb-1">{{ $evt->title }}</h6>
                                <div class="small text-muted mb-1">
                                    <i class="bi bi-clock me-1"></i> {{ $evt->start_time->format('h:i A') }}
                                    @if($evt->end_time) - {{ $evt->end_time->format('h:i A') }} @endif
                                </div>
                                <div class="small text-muted">
                                    <i class="bi bi-geo-alt me-1"></i> {{ $evt->location ?? 'Hekalu Kuu - EAGT Golani' }}
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="card-custom p-4 text-center text-muted">
                        Hakuna matukio yaliyopangwa kwenye kalenda bado.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- New Announcement Modal -->
<div class="modal fade" id="newAnnouncementModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('announcements.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Tangaza Tangazo Jipya</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Kichwa cha Tangazo *</label>
                        <input type="text" name="title" class="form-control" placeholder="Mf. Semina Maalum ya Neno la Mungu" required>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-semibold">Umuhimu (Priority) *</label>
                            <select name="priority" class="form-select" required>
                                <option value="normal" selected>Kawaida (Normal)</option>
                                <option value="high">Kipaumbele Kikubwa (High)</option>
                                <option value="urgent">Dharura / Muhimu Sana (Urgent)</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-semibold">Walengwa *</label>
                            <select name="audience" class="form-select" required>
                                <option value="all" selected>Kanisa Zima (Wote)</option>
                                <option value="members">Washirika Pekee</option>
                                <option value="leaders">Viongozi Pekee</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Ujumbe / Maelezo ya Tangazo *</label>
                        <textarea name="content" class="form-control" rows="4" placeholder="Andika maelezo ya tangazo hapa..." required></textarea>
                    </div>
                    <div class="form-check p-2 bg-light rounded-3 border">
                        <input class="form-check-input ms-0 me-2" type="checkbox" name="is_pinned" id="pinCheck" value="1">
                        <label class="form-check-label small fw-semibold text-danger" for="pinCheck">
                            <i class="bi bi-pin-fill"></i> Bandika Juu Kabisa ya Ubao wa Matangazo (Pinned)
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Ghairi</button>
                    <button type="submit" class="btn btn-primary">Chapisha Tangazo</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- New Event Modal -->
<div class="modal fade" id="newEventModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('announcements.events.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Panga Tukio Kwenye Kalenda</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Jina la Tukio / Kongamano *</label>
                        <input type="text" name="title" class="form-control" placeholder="Mf. Kongamano la Vijana (CPV)" required>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-semibold">Tarehe na Muda wa Kuanza *</label>
                            <input type="datetime-local" name="start_time" class="form-control" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-semibold">Tarehe na Muda wa Kumaliza</label>
                            <input type="datetime-local" name="end_time" class="form-control">
                        </div>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-8">
                            <label class="form-label small fw-semibold">Eneo / Ukumbi</label>
                            <input type="text" name="location" class="form-control" placeholder="Hekalu Kuu - EAGT Golani">
                        </div>
                        <div class="col-4">
                            <label class="form-label small fw-semibold">Rangi ya Utambulisho</label>
                            <input type="color" name="color" class="form-control form-control-color w-100" value="#2563eb">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Maelezo ya Tukio</label>
                        <textarea name="description" class="form-control" rows="2" placeholder="Ratiba fupi au waalika maalum..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Ghairi</button>
                    <button type="submit" class="btn btn-primary">Weka Kwenye Kalenda</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
