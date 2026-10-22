@extends('layouts.app')

@section('title', 'Mahubiri na Video za YouTube')

@section('content')
<div class="container-fluid px-0">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h3 class="fw-bold mb-1">Mahubiri, Vyombo vya Habari na Matangazo ya Moja kwa Moja (Live)</h3>
            <p class="text-muted mb-0 small">Tazama mahubiri ya neno la Mungu, ibada za moja kwa moja za Jumapili na mfululizo wa mafundisho</p>
        </div>
        <div class="d-flex gap-2">
            <a href="https://youtube.com/@eagt_golani?si=MQXrKVblnH6E7A7H" target="_blank" rel="noopener" class="btn btn-outline-danger btn-sm rounded-pill px-3 shadow-sm fw-bold">
                <i class="bi bi-youtube me-1"></i> Chaneli ya YouTube
            </a>
            <button class="btn btn-danger btn-sm rounded-pill px-3 shadow-sm fw-bold" data-bs-toggle="modal" data-bs-target="#addVideoModal">
                <i class="bi bi-plus-circle me-1"></i> Ongeza Hubiri / Video
            </button>
        </div>
    </div>

    <!-- Active Live Stream Showcase if available -->
    @if($liveVideo)
        <div class="card-custom p-4 mb-4 border-danger border-2">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-danger rounded-pill px-3 py-2 text-uppercase fw-bold">
                        <i class="bi bi-broadcast me-1"></i> MOJA KWA MOJA (LIVE)
                    </span>
                    <h5 class="fw-bold mb-0 text-dark">{{ $liveVideo->title }}</h5>
                </div>
                <form action="{{ route('media.toggleLive', $liveVideo) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill">
                        Sitisha Alama ya Moja kwa Moja
                    </button>
                </form>
            </div>

            <div class="ratio ratio-16x9 rounded-4 overflow-hidden shadow">
                <iframe src="https://www.youtube.com/embed/{{ $liveVideo->youtube_id }}?autoplay=1" title="{{ $liveVideo->title }}" allowfullscreen></iframe>
            </div>
        </div>
    @endif

    <!-- Videos Grid -->
    <div class="row g-4">
        @forelse($videos as $video)
            <div class="col-md-6 col-lg-4">
                <div class="card-custom overflow-hidden h-100 d-flex flex-column justify-content-between">
                    <div>
                        <!-- Thumbnail with Play Overlay -->
                        <div class="position-relative bg-dark" style="height: 190px;">
                            <img src="{{ $video->auto_thumbnail }}" alt="{{ $video->title }}" class="w-100 h-100 object-fit-cover">
                            <a href="https://www.youtube.com/watch?v={{ $video->youtube_id }}" target="_blank" class="position-absolute top-50 start-50 translate-middle btn btn-danger rounded-circle p-3 shadow-lg">
                                <i class="bi bi-play-fill fs-4"></i>
                            </a>
                            @if($video->is_live)
                                <span class="position-absolute top-0 start-0 m-2 badge bg-danger">LIVE</span>
                            @endif
                        </div>

                        <div class="p-3">
                            <span class="badge bg-light text-dark border mb-2">{{ $video->sermon_series ?? 'Ujumbe wa Jumapili' }}</span>
                            <h6 class="fw-bold text-dark mb-1">{{ $video->title }}</h6>
                            <small class="text-muted d-block mb-2">
                                <i class="bi bi-person me-1"></i> {{ $video->preacher_name ?? 'Mchungaji' }} • {{ $video->sermon_date ? $video->sermon_date->format('d/m/Y') : '' }}
                            </small>
                            <p class="small text-muted mb-0">{{ Str::limit($video->description, 90) }}</p>
                        </div>
                    </div>

                    <div class="p-3 pt-0 d-flex justify-content-between align-items-center">
                        <a href="https://www.youtube.com/watch?v={{ $video->youtube_id }}" target="_blank" class="btn btn-sm btn-outline-danger rounded-pill px-3">
                            <i class="bi bi-youtube me-1"></i> Tazama YouTube
                        </a>

                        <form action="{{ route('media.toggleLive', $video) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-light border rounded-pill" title="Washa/Zima Bango la Moja kwa Moja">
                                <i class="bi bi-broadcast {{ $video->is_live ? 'text-danger' : 'text-muted' }}"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5 text-muted">
                Hakuna video au mahubiri ya YouTube yaliyowekwa bado.
            </div>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $videos->links() }}
    </div>
</div>

<!-- Add Sermon Modal -->
<div class="modal fade" id="addVideoModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('media.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Weka Hubiri / Matangazo ya YouTube</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Kichwa cha Somo / Hubiri *</label>
                        <input type="text" name="title" class="form-control" placeholder="Mf. Nguvu ya Maombi na Kufunga" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Kiungo cha YouTube (URL) *</label>
                        <input type="url" name="video_url" class="form-control" placeholder="https://www.youtube.com/watch?v=..." required>
                        <small class="text-muted">Inapokea viungo vya kawaida vya YouTube au matangazo ya moja kwa moja.</small>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-semibold">Mhubiri / Mnenaji</label>
                            <input type="text" name="preacher_name" class="form-control" placeholder="Mch. Kiongozi">
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-semibold">Mfululizo wa Mafundisho</label>
                            <input type="text" name="sermon_series" class="form-control" placeholder="Mf. Somo la Imani">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Tarehe ya Hubiri</label>
                        <input type="date" name="sermon_date" class="form-control" value="{{ date('Y-m-d') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Maelezo Mafupi</label>
                        <textarea name="description" class="form-control" rows="2" placeholder="Mambo makuu yaliyofundishwa..."></textarea>
                    </div>
                    <div class="form-check p-2 bg-light rounded-3 border">
                        <input class="form-check-input ms-0 me-2" type="checkbox" name="is_live" id="liveCheck" value="1">
                        <label class="form-check-label small fw-semibold text-danger" for="liveCheck">
                            <i class="bi bi-broadcast"></i> Weka Alama ya Matangazo ya Moja kwa Moja (Live Now)
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Ghairi</button>
                    <button type="submit" class="btn btn-danger fw-bold">Hifadhi Video</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
