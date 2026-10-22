@extends('layouts.app')

@section('title', 'Hariri Taarifa za Mshirika - ' . $member->full_name)

@section('content')
<div class="container-fluid px-0">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h3 class="fw-bold mb-1">Hariri Taarifa za Mshirika</h3>
            <p class="text-muted mb-0 small">Kurekebisha taarifa za {{ $member->full_name }} (Namba: {{ $member->member_number }})</p>
        </div>
        <a href="{{ route('members.show', $member) }}" class="btn btn-sm btn-light border rounded-pill">
            <i class="bi bi-arrow-left me-1"></i> Rudi Kwenye Wasifu
        </a>
    </div>

    <div class="card-custom p-4">
        <form action="{{ route('members.update', $member) }}" method="POST">
            @csrf
            @method('PUT')

            <h5 class="fw-bold mb-3 text-primary border-bottom pb-2">1. Taarifa Binafsi</h5>
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Jina la Kwanza *</label>
                    <input type="text" name="first_name" class="form-control" value="{{ old('first_name', $member->first_name) }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Jina la Ukoo *</label>
                    <input type="text" name="last_name" class="form-control" value="{{ old('last_name', $member->last_name) }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Jinsia *</label>
                    <select name="gender" class="form-select" required>
                        <option value="Male" {{ old('gender', $member->gender) == 'Male' ? 'selected' : '' }}>Mwanaume</option>
                        <option value="Female" {{ old('gender', $member->gender) == 'Female' ? 'selected' : '' }}>Mwanamke</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Tarehe ya Kuzaliwa</label>
                    <input type="date" name="date_of_birth" class="form-control" value="{{ old('date_of_birth', $member->date_of_birth?->format('Y-m-d')) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Hali ya Ndoa</label>
                    <select name="marital_status" class="form-select">
                        <option value="Single" {{ $member->marital_status == 'Single' ? 'selected' : '' }}>Hajaoa / Hujaolewa</option>
                        <option value="Married" {{ $member->marital_status == 'Married' ? 'selected' : '' }}>Ameoa / Ameolewa</option>
                        <option value="Widowed" {{ $member->marital_status == 'Widowed' ? 'selected' : '' }}>Mjane / Mgane</option>
                        <option value="Divorced" {{ $member->marital_status == 'Divorced' ? 'selected' : '' }}>Ameachika</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Kazi / Taaluma</label>
                    <input type="text" name="occupation" class="form-control" value="{{ old('occupation', $member->occupation) }}">
                </div>
            </div>

            <h5 class="fw-bold mb-3 text-primary border-bottom pb-2">2. Mawasiliano na Makazi</h5>
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Namba ya Simu</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone', $member->phone) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Barua Pepe (Email)</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $member->email) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Eneo la Makazi</label>
                    <input type="text" name="residential_address" class="form-control" value="{{ old('residential_address', $member->residential_address) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-semibold">Mtu wa Karibu wa Dharura (Jina)</label>
                    <input type="text" name="emergency_contact_name" class="form-control" value="{{ old('emergency_contact_name', $member->emergency_contact_name) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-semibold">Namba ya Simu ya Dharura</label>
                    <input type="text" name="emergency_contact_phone" class="form-control" value="{{ old('emergency_contact_phone', $member->emergency_contact_phone) }}">
                </div>
            </div>

            <h5 class="fw-bold mb-3 text-primary border-bottom pb-2">3. Hali ya Ushirika na Idara za Kanisa</h5>
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Hali ya Ushirika *</label>
                    <select name="membership_status" class="form-select" required>
                        <option value="Active" {{ $member->membership_status == 'Active' ? 'selected' : '' }}>Hai (Active)</option>
                        <option value="Inactive" {{ $member->membership_status == 'Inactive' ? 'selected' : '' }}>Hajachangamka (Inactive)</option>
                        <option value="Transferred" {{ $member->membership_status == 'Transferred' ? 'selected' : '' }}>Amehama (Transferred)</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Ubatizo wa Maji Mengi *</label>
                    <select name="baptism_status" class="form-select" required>
                        <option value="Baptized" {{ $member->baptism_status == 'Baptized' ? 'selected' : '' }}>Amebatizwa</option>
                        <option value="Not Baptized" {{ $member->baptism_status == 'Not Baptized' ? 'selected' : '' }}>Bado Hajabatizwa</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Tarehe ya Kujiunga na Kanisa</label>
                    <input type="date" name="joined_date" class="form-control" value="{{ old('joined_date', $member->joined_date?->format('Y-m-d')) }}">
                </div>
                <div class="col-12">
                    <label class="form-label small fw-semibold">Idara Alizopangiwa</label>
                    <div class="row g-2">
                        @foreach($departments as $dept)
                            <div class="col-md-4">
                                <div class="form-check p-2 border rounded-3 bg-light">
                                    <input class="form-check-input ms-0 me-2" type="checkbox" name="departments[]" value="{{ $dept->id }}" id="dept_{{ $dept->id }}" {{ in_array($dept->id, $memberDeptIds) ? 'checked' : '' }}>
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
                    <textarea name="notes" class="form-control" rows="2">{{ old('notes', $member->notes) }}</textarea>
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <button type="button" class="btn btn-outline-danger btn-sm rounded-pill" onclick="if(confirm('Je, una uhakika unataka kumfuta mshirika huyu?')) { document.getElementById('delete-member-form').submit(); }">
                    <i class="bi bi-trash me-1"></i> Futa Mshirika
                </button>

                <div class="d-flex gap-2">
                    <a href="{{ route('members.show', $member) }}" class="btn btn-light border px-4">Ghairi</a>
                    <button type="submit" class="btn btn-primary-custom px-4">
                        <i class="bi bi-check-circle me-1"></i> Hifadhi Mabadiliko
                    </button>
                </div>
            </div>
        </form>

        <form id="delete-member-form" action="{{ route('members.destroy', $member) }}" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    </div>
</div>
@endsection
