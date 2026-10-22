@extends('layouts.app')

@section('title', 'Wasifu Wangu')

@section('content')
<div class="container-fluid px-0">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h3 class="fw-bold mb-1">Wasifu wa Akaunti Yangu</h3>
            <p class="text-muted mb-0 small">Badili taarifa zako binafsi na usalama wa nenosiri</p>
        </div>
        <a href="{{ route('dashboard') }}" class="btn btn-sm btn-light border rounded-pill">
            <i class="bi bi-arrow-left me-1"></i> Rudi Dashibodi
        </a>
    </div>

    <div class="card-custom p-4" style="max-width: 700px; margin: 0 auto;">
        <div class="d-flex align-items-center gap-3 mb-4 pb-3 border-bottom">
            <div class="rounded-circle bg-primary text-white fs-2 fw-bold d-flex align-items-center justify-content-center shadow" style="width: 64px; height: 64px;">
                {{ substr($user->name, 0, 1) }}
            </div>
            <div>
                <h5 class="fw-bold mb-0 text-dark">{{ $user->name }}</h5>
                <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-1 rounded-pill text-capitalize">
                    @php
                        $roleMap = [
                            'super_admin' => 'Msimamizi Mkuu (Super Admin)',
                            'pastor' => 'Mchungaji Kiongozi',
                            'elder' => 'Mzee wa Kanisa',
                            'treasurer' => 'Mhazini (Hazina)',
                            'secretary' => 'Katibu wa Kanisa',
                            'department_leader' => 'Kiongozi wa Idara',
                            'member' => 'Mshirika',
                        ];
                    @endphp
                    {{ $roleMap[$user->role] ?? str_replace('_', ' ', $user->role) }}
                </span>
                <small class="text-muted d-block mt-1">{{ $user->church?->name ?? 'Msimamizi Mkuu wa Mfumo' }}</small>
            </div>
        </div>

        <form action="{{ route('profile.update') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label small fw-semibold">Barua Pepe ya Kuingilia (Email ID)</label>
                <input type="email" class="form-control bg-light" value="{{ $user->email }}" disabled>
                <small class="text-muted">Barua pepe hii inasimamiwa na msimamizi mkuu wa kanisa.</small>
            </div>

            <div class="mb-3">
                <label class="form-label small fw-semibold">Jina Kamili *</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
            </div>

            <div class="mb-4">
                <label class="form-label small fw-semibold">Namba ya Simu</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}" placeholder="+255 7XX XXX XXX">
            </div>

            <div id="passwordSection" class="pt-2">
                <h6 class="fw-bold text-primary border-bottom pb-2 mb-3">
                    <i class="bi bi-shield-lock-fill text-warning me-1"></i> Usalama na Kubadilisha Nenosiri Lako
                </h6>
            </div>

            <div class="mb-3">
                <label class="form-label small fw-semibold">Nenosiri la Sasa (Linahitajika unapotaka kubadili tu)</label>
                <input type="password" name="current_password" class="form-control" placeholder="Weka nenosiri la sasa">
            </div>

            <div class="row g-2 mb-4">
                <div class="col-6">
                    <label class="form-label small fw-semibold">Nenosiri Jipya</label>
                    <input type="password" name="new_password" class="form-control" placeholder="Herufi 6 au zaidi">
                </div>
                <div class="col-6">
                    <label class="form-label small fw-semibold">Thibitisha Nenosiri Jipya</label>
                    <input type="password" name="new_password_confirmation" class="form-control" placeholder="Rudia nenosiri jipya">
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <button type="submit" class="btn btn-primary-custom px-4">
                    <i class="bi bi-save me-1"></i> Hifadhi Mabadiliko
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
