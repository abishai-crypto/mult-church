@extends('layouts.app')

@section('title', 'Sajili Mshirika')

@section('content')
<div class="container-fluid px-0">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h3 class="fw-bold mb-1">Sajili Mshirika Mpya</h3>
            <p class="text-muted mb-0 small">Ongeza mshirika mpya wa kanisa kwenye daftari kuu la washirika</p>
        </div>
        <a href="{{ route('members.index') }}" class="btn btn-sm btn-light border rounded-pill">
            <i class="bi bi-arrow-left me-1"></i> Rudi Kwenye Orodha
        </a>
    </div>

    <div class="card-custom p-4">
        <form action="{{ route('members.store') }}" method="POST">
            @csrf

            <h5 class="fw-bold mb-3 text-primary border-bottom pb-2">1. Taarifa Binafsi</h5>
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Jina la Kwanza *</label>
                    <input type="text" name="first_name" class="form-control" value="{{ old('first_name') }}" required placeholder="Mf. Daudi">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Jina la Ukoo *</label>
                    <input type="text" name="last_name" class="form-control" value="{{ old('last_name') }}" required placeholder="Mf. Mwita">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Jinsia *</label>
                    <select name="gender" class="form-select" required>
                        <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Mwanaume</option>
                        <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Mwanamke</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Tarehe ya Kuzaliwa</label>
                    <input type="date" name="date_of_birth" class="form-control" value="{{ old('date_of_birth') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Hali ya Ndoa</label>
                    <select name="marital_status" class="form-select">
                        <option value="Single">Hajaoa / Hujaolewa</option>
                        <option value="Married">Ameoa / Ameolewa</option>
                        <option value="Widowed">Mjane / Mgane</option>
                        <option value="Divorced">Ameachika</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Kazi / Taaluma</label>
                    <input type="text" name="occupation" class="form-control" placeholder="Mf. Mwalimu, Mfanyabiashara, Daktari" value="{{ old('occupation') }}">
                </div>
            </div>

            <h5 class="fw-bold mb-3 text-primary border-bottom pb-2">2. Mawasiliano na Makazi</h5>
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Namba ya Simu</label>
                    <input type="text" name="phone" class="form-control" placeholder="+255 7XX XXX XXX" value="{{ old('phone') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Barua Pepe (Email)</label>
                    <input type="email" name="email" class="form-control" placeholder="mshirika@barua.com" value="{{ old('email') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Eneo la Makazi</label>
                    <input type="text" name="residential_address" class="form-control" placeholder="Mf. Kimara-Suka, Golani" value="{{ old('residential_address') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-semibold">Mtu wa Karibu wa Dharura (Jina)</label>
                    <input type="text" name="emergency_contact_name" class="form-control" placeholder="Jina kamili la ndugu au mlezi" value="{{ old('emergency_contact_name') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-semibold">Namba ya Simu ya Dharura</label>
                    <input type="text" name="emergency_contact_phone" class="form-control" placeholder="+255 7XX XXX XXX" value="{{ old('emergency_contact_phone') }}">
                </div>
            </div>

            <h5 class="fw-bold mb-3 text-primary border-bottom pb-2">3. Hali ya Ushirika na Idara za Kanisa</h5>
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Hali ya Ushirika *</label>
                    <select name="membership_status" class="form-select" required>
                        <option value="Active">Hai (Active)</option>
                        <option value="Inactive">Hajachangamka (Inactive)</option>
                        <option value="Transferred">Amehama (Transferred)</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Ubatizo wa Maji Mengi *</label>
                    <select name="baptism_status" class="form-select" required>
                        <option value="Baptized">Amebatizwa</option>
                        <option value="Not Baptized">Bado Hajabatizwa</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Tarehe ya Kujiunga na Kanisa</label>
                    <input type="date" name="joined_date" class="form-control" value="{{ old('joined_date', date('Y-m-d')) }}">
                </div>
                <div class="col-12">
                    <label class="form-label small fw-semibold">Panga Kwenye Idara za Kanisa</label>
                    <div class="row g-2">
                        @foreach($departments as $dept)
                            <div class="col-md-4">
                                <div class="form-check p-2 border rounded-3 bg-light">
                                    <input class="form-check-input ms-0 me-2" type="checkbox" name="departments[]" value="{{ $dept->id }}" id="dept_{{ $dept->id }}">
                                    <label class="form-check-label small fw-semibold" for="dept_{{ $dept->id }}">
                                        {{ $dept->name }}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-12">
                    <label class="form-label small fw-semibold">Maelezo ya Ziada / Historia</label>
                    <textarea name="notes" class="form-control" rows="2" placeholder="Maelezo yoyote muhimu kuhusu mshirika..."></textarea>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('members.index') }}" class="btn btn-light border px-4">Ghairi</a>
                <button type="submit" class="btn btn-primary-custom px-4">
                    <i class="bi bi-save me-1"></i> Sajili Mshirika
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
