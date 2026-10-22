@extends('layouts.app')

@section('title', $department->name . ' - Kituo cha Huduma')

@section('content')
<div class="container-fluid px-0">
    @php
        $deptImg = null;
        if (stripos($department->name, 'kwaya') !== false || stripos($department->name, 'sifa') !== false || stripos($department->name, 'ebeneza') !== false) {
            $deptImg = 'assets/images/worship_soloist_choir_leading.jpg';
        } elseif (stripos($department->name, 'wanawake') !== false || stripos($department->name, 'wwk') !== false) {
            $deptImg = 'assets/images/worship_women_congregation.jpg';
        } elseif (stripos($department->name, 'wanaume') !== false || stripos($department->name, 'wazee') !== false) {
            $deptImg = 'assets/images/men_fellowship_wanaume_imani.jpg';
        } elseif (stripos($department->name, 'watoto') !== false || stripos($department->name, 'cwi') !== false || stripos($department->name, 'sunday') !== false) {
            $deptImg = 'assets/images/cwi_children_sunday_school.jpg';
        } elseif (stripos($department->name, 'vijana') !== false || stripos($department->name, 'cgm') !== false) {
            $deptImg = 'assets/images/cgm_youth_choir_uniform.jpg';
        } elseif (stripos($department->name, 'ujenzi') !== false) {
            $deptImg = 'assets/images/church_building.jpg';
        }
    @endphp
    @if($deptImg)
        <div class="card-custom mb-4 overflow-hidden position-relative rounded-4 shadow-sm" style="max-height: 200px;">
            <img src="{{ asset($deptImg) }}" alt="{{ $department->name }}" class="w-100 object-fit-cover" style="height: 200px;">
            <div class="position-absolute bottom-0 start-0 end-0 p-3" style="background: linear-gradient(180deg, transparent 0%, rgba(15, 23, 42, 0.90) 100%);">
                <span class="badge px-3 py-1 rounded-pill fw-bold" style="background: {{ $department->banner_color }}; color: #fff;">
                    Picha Halisi ya Huduma • {{ $department->name }}
                </span>
            </div>
        </div>
    @endif

    <!-- Header Banner -->
    <div class="card-custom p-4 mb-4" style="border-top: 6px solid {{ $department->banner_color }};">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div>
                <a href="{{ route('departments.index') }}" class="btn btn-sm btn-light border rounded-pill mb-2">
                    <i class="bi bi-arrow-left me-1"></i> Idara Zote
                </a>
                <h3 class="fw-bold mb-1">{{ $department->name }}</h3>
                <p class="text-muted small mb-0">{{ $department->description }}</p>
            </div>
            <div class="d-flex align-items-center gap-3">
                <div class="text-end">
                    <div class="small text-muted">Kiongozi wa Idara</div>
                    <strong class="text-dark">{{ $department->leader_name ?? 'Bado Hajateuliwa' }}</strong>
                    <div class="small text-muted">{{ $department->leader_phone }}</div>
                </div>
                <div class="vr d-none d-sm-block"></div>
                <div class="text-start">
                    <div class="small text-muted">Ratiba ya Vikao</div>
                    <strong class="text-dark">{{ $department->meeting_day ?? 'Dharura / Kupangwa' }}</strong>
                    <div class="small text-muted">Saa {{ $department->meeting_time ?? 'Kupangwa' }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <ul class="nav nav-pills mb-4 gap-2" id="deptTabs" role="tablist">
        <li class="nav-item">
            <button class="nav-link active rounded-pill fw-semibold px-4" data-bs-toggle="pill" data-bs-target="#tab-members">
                <i class="bi bi-people-fill me-1"></i> Washirika wa Idara ({{ $department->departmentMembers->count() }})
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link rounded-pill fw-semibold px-4" data-bs-toggle="pill" data-bs-target="#tab-finances">
                <i class="bi bi-cash-stack me-1"></i> Mfuko na Fedha za Idara
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link rounded-pill fw-semibold px-4" data-bs-toggle="pill" data-bs-target="#tab-events">
                <i class="bi bi-calendar-event me-1"></i> Matukio na Shughuli
            </button>
        </li>
    </ul>

    <div class="tab-content">
        <!-- MEMBERS TAB -->
        <div class="tab-pane fade show active" id="tab-members">
            <div class="card-custom p-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h5 class="fw-bold mb-0">Daftari la Washirika wa Idara</h5>
                    <button class="btn btn-primary-custom btn-sm rounded-pill px-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#enrollModal">
                        <i class="bi bi-person-plus-fill me-1"></i> Unganisha Mshirika
                    </button>
                </div>

                <!-- Enroll Modal -->
                <div class="modal fade" id="enrollModal" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('departments.addMember', $department) }}" method="POST">
                                @csrf
                                <div class="modal-header">
                                    <h5 class="modal-title fw-bold">Unganisha Mshirika kwenye {{ $department->name }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label small fw-semibold">Chagua Mshirika *</label>
                                        <select name="member_id" class="form-select" required>
                                            <option value="">-- Chagua Mshirika --</option>
                                            @foreach($allMembers as $m)
                                                <option value="{{ $m->id }}">{{ $m->full_name }} ({{ $m->member_number }})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label small fw-semibold">Nafasi Kwenye Idara *</label>
                                        <select name="role_in_department" class="form-select" required>
                                            <option value="Mshirika wa Kawaida">Mshirika wa Kawaida</option>
                                            <option value="Mwenyekiti / Kiongozi">Mwenyekiti / Kiongozi</option>
                                            <option value="Makamu Mwenyekiti">Makamu Mwenyekiti</option>
                                            <option value="Katibu">Katibu</option>
                                            <option value="Mhazini wa Idara">Mhazini wa Idara</option>
                                            <option value="Mjumbe wa Kamati">Mjumbe wa Kamati</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Ghairi</button>
                                    <button type="submit" class="btn btn-primary">Unganisha</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover table-custom mb-0 align-middle">
                        <thead>
                            <tr>
                                <th>Jina la Mshirika</th>
                                <th>Nafasi / Cheo</th>
                                <th>Namba ya Simu</th>
                                <th>Barua Pepe</th>
                                <th>Tarehe ya Kujiunga</th>
                                <th class="text-end">Vitendo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($department->departmentMembers as $dm)
                                <tr>
                                    <td>
                                        <a href="{{ route('members.show', $dm->member) }}" class="fw-bold text-dark text-decoration-none">
                                            {{ $dm->member->full_name }}
                                        </a>
                                        <small class="text-muted d-block">{{ $dm->member->member_number }}</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-1 rounded-pill">
                                            {{ $dm->role_in_department }}
                                        </span>
                                    </td>
                                    <td><small>{{ $dm->member->phone ?? 'Hakuna' }}</small></td>
                                    <td><small>{{ $dm->member->email ?? 'Hakuna' }}</small></td>
                                    <td><small>{{ $dm->joined_at ? $dm->joined_at->format('d/m/Y') : 'Hai' }}</small></td>
                                    <td class="text-end">
                                        <form action="{{ route('departments.removeMember', [$department, $dm->member]) }}" method="POST" class="d-inline" onsubmit="return confirm('Je, una uhakika unataka kumuondoa mshirika huyu kwenye idara hii?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger border-0" title="Ondoa">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">Hakuna washirika waliojiunga na idara hii bado.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- FINANCES TAB -->
        <div class="tab-pane fade" id="tab-finances">
            <!-- 3 Stat Cards for Department Treasury -->
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="stat-card" style="background: linear-gradient(135deg, #059669 0%, #10b981 100%);">
                        <div class="stat-card-icon"><i class="bi bi-arrow-down-circle"></i></div>
                        <div class="text-white-50 text-uppercase small fw-bold">Mapato / Michango ya Idara</div>
                        <h2 class="fw-bold my-2 text-white">Tsh {{ number_format($totalIncome) }}</h2>
                        <div class="small text-white-50">Ada, sadaka na michango</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card" style="background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%);">
                        <div class="stat-card-icon"><i class="bi bi-arrow-up-circle"></i></div>
                        <div class="text-white-50 text-uppercase small fw-bold">Matumizi ya Idara</div>
                        <h2 class="fw-bold my-2 text-white">Tsh {{ number_format($totalExpense) }}</h2>
                        <div class="small text-white-50">Vifaa, safari, maandalizi</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card" style="background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);">
                        <div class="stat-card-icon"><i class="bi bi-safe"></i></div>
                        <div class="text-white-50 text-uppercase small fw-bold">Salio Lililopo Mfukoni</div>
                        <h2 class="fw-bold my-2 text-white">Tsh {{ number_format($balance) }}</h2>
                        <div class="small text-white-50">Fedha kamili za huduma ya idara</div>
                    </div>
                </div>
            </div>

            <div class="card-custom p-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h5 class="fw-bold mb-0">Daftari la Fedha za Idara</h5>
                    <button class="btn btn-success btn-sm rounded-pill px-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#financeModal">
                        <i class="bi bi-plus-circle me-1"></i> Rekodi Mapato / Matumizi
                    </button>
                </div>

                <!-- Log Finance Modal -->
                <div class="modal fade" id="financeModal" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('departments.storeFinance', $department) }}" method="POST">
                                @csrf
                                <div class="modal-header">
                                    <h5 class="modal-title fw-bold">Rekodi Muamala wa Fedha za Idara</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row g-3">
                                        <div class="col-6">
                                            <label class="form-label small fw-semibold">Aina *</label>
                                            <select name="type" class="form-select" required>
                                                <option value="income">Mapato (Michango / Ada)</option>
                                                <option value="expense">Matumizi (Gharama za Idara)</option>
                                            </select>
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label small fw-semibold">Kiasi (Tsh) *</label>
                                            <input type="number" step="1" min="1" name="amount" class="form-control" placeholder="10,000" required>
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label small fw-semibold">Kipengele / Kundi *</label>
                                            <input type="text" name="category" class="form-control" placeholder="Mf. Michango ya Mwezi, Sare, Semina" required>
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label small fw-semibold">Tarehe *</label>
                                            <input type="date" name="transaction_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label small fw-semibold">Njia ya Malipo</label>
                                            <select name="payment_method" class="form-select">
                                                <option value="cash">Pesa Taslimu (Cash)</option>
                                                <option value="mobile_money">M-Pesa / Tigo Pesa / Airtel</option>
                                                <option value="bank_transfer">Benki (NMB / CRDB)</option>
                                            </select>
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label small fw-semibold">Mchangiaji / Mpokeaji</label>
                                            <input type="text" name="member_name" class="form-control" placeholder="Jina la mshirika au mzabuni">
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label small fw-semibold">Maelezo</label>
                                            <textarea name="description" class="form-control" rows="2" placeholder="Maelezo ya muamala huu..."></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Ghairi</button>
                                    <button type="submit" class="btn btn-primary">Hifadhi Muamala</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover table-custom mb-0 align-middle">
                        <thead>
                            <tr>
                                <th>Tarehe</th>
                                <th>Aina</th>
                                <th>Kundi</th>
                                <th>Kiasi</th>
                                <th>Mhusika</th>
                                <th>Maelezo</th>
                                <th>Mrekodiji</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($department->finances as $fin)
                                <tr>
                                    <td><small>{{ $fin->transaction_date->format('d/m/Y') }}</small></td>
                                    <td>
                                        <span class="badge bg-{{ $fin->type == 'income' ? 'success' : 'danger' }}-subtle text-{{ $fin->type == 'income' ? 'success' : 'danger' }} border px-2 py-1 rounded-pill">
                                            {{ $fin->type == 'income' ? 'Mapato' : 'Matumizi' }}
                                        </span>
                                    </td>
                                    <td><strong>{{ $fin->category }}</strong></td>
                                    <td class="fw-bold {{ $fin->type == 'income' ? 'text-success' : 'text-danger' }}">
                                        {{ $fin->type == 'income' ? '+' : '-' }}Tsh {{ number_format($fin->amount) }}
                                    </td>
                                    <td><small>{{ $fin->member_name ?? '-' }}</small></td>
                                    <td><small class="text-muted">{{ $fin->description }}</small></td>
                                    <td><small class="text-muted">{{ $fin->recorder?->name ?? 'Kiongozi' }}</small></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-muted">Hakuna miamala ya fedha iliyorekodiwa kwenye idara hii bado.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- EVENTS TAB -->
        <div class="tab-pane fade" id="tab-events">
            <div class="card-custom p-4">
                <h5 class="fw-bold mb-3">Mikutano na Shughuli za Idara</h5>
                <div class="row g-3">
                    @forelse($department->events as $evt)
                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded-3 border-start border-4 border-primary">
                                <h6 class="fw-bold text-dark mb-1">{{ $evt->title }}</h6>
                                <p class="small text-muted mb-2">{{ $evt->description }}</p>
                                <div class="small text-muted">
                                    <i class="bi bi-clock me-1"></i> {{ $evt->start_time->format('d/m/Y - h:i A') }} • {{ $evt->location }}
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-4 text-muted">Hakuna matukio maalum yaliyopangwa kwa idara hii bado.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
