@extends('layouts.app')

@section('title', 'Ratiba za Ibada za Kanisa')

@section('content')
<div class="container-fluid px-0">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h3 class="fw-bold mb-1">Ratiba za Ibada za Kanisa</h3>
            <p class="text-muted mb-0 small">Ibada za Jumapili, maombi ya katikati ya wiki, mkesha wa maombi na vipindi maalum</p>
        </div>
        <a href="{{ route('attendance.index') }}" class="btn btn-sm btn-light border rounded-pill">
            <i class="bi bi-arrow-left me-1"></i> Rudi Kwenye Mahudhurio
        </a>
    </div>

    <div class="row g-4">
        <!-- Services List -->
        <div class="col-lg-8">
            <div class="card-custom p-4">
                <h5 class="fw-bold mb-3">Ibada Zinazoendelea Kanisani</h5>
                <div class="table-responsive">
                    <table class="table table-hover table-custom mb-0">
                        <thead>
                            <tr>
                                <th>Jina la Ibada</th>
                                <th>Aina ya Ibada</th>
                                <th>Siku & Muda</th>
                                <th>Mahali</th>
                                <th>Kumbukumbu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($services as $svc)
                                <tr>
                                    <td>
                                        <strong class="text-dark">{{ $svc->title }}</strong>
                                        <small class="text-muted d-block">{{ $svc->description }}</small>
                                    </td>
                                    <td><span class="badge bg-primary-subtle text-primary border border-primary-subtle">{{ $svc->service_type }}</span></td>
                                    <td>
                                        <span class="small fw-semibold">{{ $svc->day_of_week }}</span><br>
                                        <small class="text-muted">{{ $svc->start_time ? date('h:i A', strtotime($svc->start_time)) : '' }} - {{ $svc->end_time ? date('h:i A', strtotime($svc->end_time)) : '' }}</small>
                                    </td>
                                    <td><small>{{ $svc->location ?? 'Hekalu Kuu' }}</small></td>
                                    <td><span class="badge bg-light text-dark border">{{ $svc->attendances_count }} mara</span></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">Hakuna ibada zilizosanidiwa bado.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Add Service Form -->
        <div class="col-lg-4">
            <div class="card-custom p-4">
                <h5 class="fw-bold mb-3">Ongeza Ibada Mpya</h5>
                <form action="{{ route('attendance.services.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Jina la Ibada *</label>
                        <input type="text" name="title" class="form-control" placeholder="Mf. Ibada ya Kusifu na Kuabudu" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Aina ya Ibada *</label>
                        <select name="service_type" class="form-select" required>
                            <option value="Sunday Worship">Ibada ya Jumapili</option>
                            <option value="Midweek Prayer">Maombi ya Katikati ya Wiki & Mafundisho</option>
                            <option value="Youth Service">Ibada ya Vijana (CPV)</option>
                            <option value="All-Night Vigil">Mkesha wa Maombi</option>
                            <option value="Special Service">Mkutano Maalum wa Injili / Semina</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Siku ya Ibada</label>
                        <select name="day_of_week" class="form-select">
                            <option value="Sunday">Jumapili (Sunday)</option>
                            <option value="Wednesday">Jumatano (Wednesday)</option>
                            <option value="Friday">Ijumaa (Friday)</option>
                            <option value="Saturday">Jumamosi (Saturday)</option>
                            <option value="Monday">Jumatatu (Monday)</option>
                            <option value="Tuesday">Jumanne (Tuesday)</option>
                            <option value="Thursday">Alhamisi (Thursday)</option>
                        </select>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-semibold">Muda wa Kuanza</label>
                            <input type="time" name="start_time" class="form-control" value="09:00">
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-semibold">Muda wa Kumaliza</label>
                            <input type="time" name="end_time" class="form-control" value="12:00">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Mahali / Ukumbi</label>
                        <input type="text" name="location" class="form-control" placeholder="Hekalu Kuu la EAGT Golani">
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Maelezo</label>
                        <textarea name="description" class="form-control" rows="2" placeholder="Maelezo kuhusu ibada hii..."></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary-custom w-100">
                        <i class="bi bi-plus-circle me-1"></i> Sajili Ibada
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
