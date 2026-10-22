@extends('layouts.app')

@section('title', 'Maktaba ya Nyaraka')

@section('content')
<div class="container-fluid px-0">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h3 class="fw-bold mb-1">Maktaba ya Nyaraka na Miongozo ya Kanisa</h3>
            <p class="text-muted mb-0 small">Katiba ya kanisa, miongozo ya ibada, ripoti za uwazi za fedha, na vitabu vya uongozi</p>
        </div>
        <div>
            <button class="btn btn-primary-custom btn-sm rounded-pill px-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#uploadDocModal">
                <i class="bi bi-cloud-arrow-up-fill me-1"></i> Pakia Nyaraka Mpya
            </button>
        </div>
    </div>

    <!-- Upload Modal -->
    <div class="modal fade" id="uploadDocModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold">Pakia Nyaraka ya Kanisa</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Jina la Nyaraka *</label>
                            <input type="text" name="title" class="form-control" placeholder="Mf. Mwongozo wa Uongozi wa EAGT Golani" required>
                        </div>
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <label class="form-label small fw-semibold">Kundi la Nyaraka *</label>
                                <select name="category" class="form-select" required>
                                    <option value="Katiba">Katiba na Kanuni</option>
                                    <option value="Ratiba ya Ibada">Ratiba / Mwongozo wa Ibada</option>
                                    <option value="Ripoti ya Fedha">Ripoti ya Fedha</option>
                                    <option value="Miongozo">Miongozo ya Kanisa & Usalama</option>
                                    <option value="Muhtasari wa Mahubiri">Muhtasari wa Mahubiri</option>
                                    <option value="Fomu">Fomu za Usajili / Maombi</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="form-label small fw-semibold">Ruhusa ya Kuona (Access Level) *</label>
                                <select name="access_level" class="form-select" required>
                                    <option value="public">Umma Wote (Wazi)</option>
                                    <option value="members" selected>Washirika Pekee</option>
                                    <option value="leaders">Viongozi & Wazee wa Kanisa</option>
                                    <option value="admin">Wasimamizi wa Mfumo Pekee</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Idara Husika (Si lazima)</label>
                            <select name="department_id" class="form-select">
                                <option value="">-- Nyaraka Kuu ya Kanisa Zima --</option>
                                @foreach($departments as $dept)
                                    <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Chagua Faili (PDF, DOC, DOCX - upeo 20MB) *</label>
                            <input type="file" name="file" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Maelezo Mafupi</label>
                            <textarea name="description" class="form-control" rows="2" placeholder="Nyaraka hii inahusu nini..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Ghairi</button>
                        <button type="submit" class="btn btn-primary">Pakia Faili</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Documents Grid -->
    <div class="row g-4">
        @forelse($documents as $doc)
            <div class="col-md-6 col-lg-4">
                <div class="card-custom p-4 h-100 d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <span class="badge bg-light text-dark border">{{ $doc->category }}</span>
                            <span class="badge bg-secondary-subtle text-secondary small text-uppercase">
                                <i class="bi bi-shield-lock me-1"></i> {{ $doc->access_level }}
                            </span>
                        </div>

                        <div class="d-flex align-items-start gap-3 mb-3">
                            <div class="p-3 bg-danger-subtle text-danger rounded-3 fs-3">
                                <i class="bi bi-file-earmark-pdf-fill"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1 text-dark">{{ $doc->title }}</h6>
                                <small class="text-muted d-block">{{ Str::limit($doc->description, 80) }}</small>
                            </div>
                        </div>

                        <div class="small text-muted mb-3">
                            <div><i class="bi bi-file-text me-1"></i> {{ $doc->file_name }} ({{ $doc->fileSizeFormatted() }})</div>
                            <div><i class="bi bi-cloud-arrow-down me-1"></i> Imepakuliwa mara {{ $doc->download_count }}</div>
                        </div>
                    </div>

                    <div class="pt-3 border-top">
                        <a href="{{ route('documents.download', $doc) }}" class="btn btn-light border btn-sm w-100 fw-semibold rounded-pill">
                            <i class="bi bi-download me-1 text-primary"></i> Pakua Nyaraka
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5 text-muted">
                Hakuna nyaraka zilizopakiwa bado.
            </div>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $documents->links() }}
    </div>
</div>
@endsection
