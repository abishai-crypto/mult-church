@extends('layouts.app')

@section('title', 'Usimamizi wa Manenosiri ya Kikanisa')

@section('content')
<div class="container-fluid px-0">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h3 class="fw-bold mb-1">Usimamizi wa Manenosiri na Usalama wa Kikanisa</h3>
            <p class="text-muted mb-0 small">Mamlaka ya kikanisa ya kubadilisha na kurejesha manenosiri kwa Mchungaji Kiongozi, Wazee wa Kanisa na Wasimamizi</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-primary text-white px-3 py-2 rounded-pill fw-semibold shadow-sm">
                <i class="bi bi-shield-check me-1"></i> 
                @php
                    $roleTitles = [
                        'pastor' => 'Mchungaji Kiongozi (Mamlaka Kuu)',
                        'elder' => 'Mzee wa Kanisa (Usimamizi wa Washirika)',
                        'super_admin' => 'Msimamizi Mkuu wa Mfumo',
                        'church_admin' => 'Msimamizi wa Kanisa',
                    ];
                @endphp
                {{ $roleTitles[$currentUser->role] ?? $currentUser->role }}
            </span>
        </div>
    </div>

    <!-- Mwongozo wa Mamlaka ya Kikanisa -->
    <div class="alert alert-light border border-warning-subtle shadow-sm rounded-4 p-3 mb-4 d-flex align-items-center gap-3">
        <div class="bg-warning text-dark p-2 rounded-circle fs-4 flex-shrink-0">
            <i class="bi bi-shield-lock-fill"></i>
        </div>
        <div class="small">
            <strong class="d-block text-dark fw-bold mb-1">Mamlaka ya Kikanisa ya Manenosiri (Ecclesiastical Password Governance):</strong>
            <ul class="mb-0 text-dark-emphasis ps-3">
                <li><strong>Mchungaji Kiongozi & Super Admin:</strong> Wana mamlaka ya kubadilisha au kurejesha manenosiri ya akaunti zote za kanisa (Wazee, Wahazini, Makatibu, Viongozi na Washirika).</li>
                <li><strong>Wazee wa Kanisa:</strong> Wana mamlaka kikanisa ya kurejesha manenosiri ya Viongozi wa Idara na Washirika (hawawezi kubadili akaunti ya Mchungaji Kiongozi au Msimamizi Mkuu).</li>
                <li><strong>Ukaguzi & Uthibitisho (Audit Trail):</strong> Kila zoezi la kubadili au kurejesha nenosiri linarekodiwa kwenye kumbukumbu za ukaguzi pamoja na sababu yake.</li>
            </ul>
        </div>
    </div>

    <!-- Kadi 3 za Takwimu -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="stat-card" style="background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);">
                <div class="stat-card-icon"><i class="bi bi-people-fill"></i></div>
                <div class="text-white-50 text-uppercase small fw-bold">Akaunti Zote za Mfumo</div>
                <h2 class="fw-bold my-2 text-white">{{ $users->total() }}</h2>
                <div class="small text-white-50"><i class="bi bi-shield-check"></i> Watumiaji waliosajiliwa kanisani</div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="stat-card" style="background: linear-gradient(135deg, #d97706 0%, #f59e0b 100%);">
                <div class="stat-card-icon"><i class="bi bi-hourglass-split"></i></div>
                <div class="text-white-50 text-uppercase small fw-bold">Maombi Yanayosubiri Wazee</div>
                <h2 class="fw-bold my-2 text-white">{{ $pendingRequests->count() }}</h2>
                <div class="small text-white-50">Kutoka kwa waumini waliyosahau</div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="stat-card" style="background: linear-gradient(135deg, #059669 0%, #10b981 100%);">
                <div class="stat-card-icon"><i class="bi bi-key-fill"></i></div>
                <div class="text-white-50 text-uppercase small fw-bold">Manenosiri Yaliyoidhinishwa</div>
                <h2 class="fw-bold my-2 text-white">{{ $recentResets->count() }}</h2>
                <div class="small text-white-50">Mabadiliko ya hivi karibuni</div>
            </div>
        </div>
    </div>

    <!-- SEHEMU YA 1: MAOMBI YA KUREJESHA NENOSIRI YANAYOSUBIRI UTHIBITISHO -->
    @if($pendingRequests->count() > 0)
    <div class="card-custom p-4 mb-4 border-warning border-2">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <div>
                <span class="badge bg-warning text-dark px-3 py-1 rounded-pill fw-bold mb-1">
                    <i class="bi bi-exclamation-circle-fill me-1"></i> Idhini ya Kikanisa Inahitajika
                </span>
                <h5 class="fw-bold mb-0 text-dark">Maombi ya Kurejesha Nenosiri kutoka kwa Washirika ({{ $pendingRequests->count() }})</h5>
                <small class="text-muted">Hakiki utambulisho wa muumini kabla ya kuidhinisha nenosiri jipya la muda.</small>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover table-custom mb-0 align-middle">
                <thead class="bg-light">
                    <tr>
                        <th>Tarehe</th>
                        <th>Jina la Muumini</th>
                        <th>Barua Pepe / Namba ya Simu</th>
                        <th>Sababu Iliyoelezwa</th>
                        <th>Hadhi</th>
                        <th class="text-end">Hatua ya Kikanisa</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pendingRequests as $req)
                        <tr>
                            <td><small>{{ $req->created_at->format('d M, Y H:i') }}</small></td>
                            <td>
                                <strong>{{ $req->requester_name ?? ($req->user?->name ?? 'Mshirika') }}</strong>
                                @if($req->user)
                                    <span class="badge bg-light text-dark border ms-1">{{ $req->user->role }}</span>
                                @endif
                            </td>
                            <td>
                                <div class="small fw-semibold">{{ $req->email }}</div>
                                @if($req->phone)
                                    <small class="text-muted"><i class="bi bi-phone me-1"></i>{{ $req->phone }}</small>
                                @endif
                            </td>
                            <td><small class="text-muted">{{ $req->reason ?? 'Nimesahau nenosiri' }}</small></td>
                            <td>
                                <span class="badge bg-warning text-dark"><i class="bi bi-clock me-1"></i> Inasubiri Wazee</span>
                            </td>
                            <td class="text-end">
                                <div class="d-inline-flex gap-2">
                                    <button type="button" class="btn btn-success btn-sm rounded-pill px-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#approveModal_{{ $req->id }}">
                                        <i class="bi bi-check2-circle me-1"></i> Idhinisha & Weka Nenosiri
                                    </button>

                                    <button type="button" class="btn btn-outline-danger btn-sm rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#rejectModal_{{ $req->id }}">
                                        <i class="bi bi-x-circle me-1"></i> Kataa
                                    </button>
                                </div>

                                <!-- Modal ya Kuidhinisha -->
                                <div class="modal fade" id="approveModal_{{ $req->id }}" tabindex="-1">
                                    <div class="modal-dialog text-start">
                                        <div class="modal-content">
                                            <form action="{{ route('security.passwords.approve', $req) }}" method="POST">
                                                @csrf
                                                <div class="modal-header">
                                                    <h5 class="modal-title fw-bold">Idhinisha Kurejesha Nenosiri</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p class="small text-muted mb-3">
                                                        Unakaribia kuidhinisha kurejesha nenosiri la <strong>{{ $req->requester_name }}</strong> ({{ $req->email }}). Mfumo utazalisha nenosiri jipya la muda na kumtumia kwa njia ya SMS kama simu ipo.
                                                    </p>
                                                    <div class="mb-3">
                                                        <label class="form-label small fw-semibold">Maelezo ya Kiongozi (Hiari)</label>
                                                        <input type="text" name="notes" class="form-control" placeholder="mfano: Mhusika amethibitishwa ofisini na Mzee wa Kanisa">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Ghairi</button>
                                                    <button type="submit" class="btn btn-success fw-bold">Thibitisha & Tuma Nenosiri</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal ya Kukataa -->
                                <div class="modal fade" id="rejectModal_{{ $req->id }}" tabindex="-1">
                                    <div class="modal-dialog text-start">
                                        <div class="modal-content">
                                            <form action="{{ route('security.passwords.reject', $req) }}" method="POST">
                                                @csrf
                                                <div class="modal-header">
                                                    <h5 class="modal-title fw-bold">Kataa Ombi la Nenosiri</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label class="form-label small fw-semibold">Sababu ya Kukataa *</label>
                                                        <textarea name="reason" class="form-control" rows="3" placeholder="Eleza sababu ya kukataa (mfano: namba haitambuliki kwenye kanisa)..." required></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Ghairi</button>
                                                    <button type="submit" class="btn btn-danger">Thibitisha Kukataa</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    <!-- SEHEMU YA 2: ORODHA YA WATUMIAJI NA MAMLAKA YA KUBADILI NENOSIRI -->
    <div class="card-custom p-4">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-3">
            <div>
                <h5 class="fw-bold mb-0">Daftari la Watumiaji & Mamlaka ya Manenosiri</h5>
                <small class="text-muted">Badilisha nenosiri la mtumiaji kulingana na ngazi yako ya mamlaka kikanisa.</small>
            </div>
        </div>

        <!-- Fomu ya Kutafuta & Kuchuja -->
        <form method="GET" action="{{ route('security.passwords.index') }}" class="row g-2 mb-4">
            <div class="col-md-5">
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-light"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control" placeholder="Tafuta kwa jina, barua pepe au simu..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-4">
                <select name="role" class="form-select form-select-sm">
                    <option value="">Majukumu Yote ya Kikanisa</option>
                    <option value="pastor" {{ request('role') == 'pastor' ? 'selected' : '' }}>Mchungaji Kiongozi</option>
                    <option value="elder" {{ request('role') == 'elder' ? 'selected' : '' }}>Mzee wa Kanisa</option>
                    <option value="treasurer" {{ request('role') == 'treasurer' ? 'selected' : '' }}>Mhazini</option>
                    <option value="secretary" {{ request('role') == 'secretary' ? 'selected' : '' }}>Katibu wa Kanisa</option>
                    <option value="department_leader" {{ request('role') == 'department_leader' ? 'selected' : '' }}>Kiongozi wa Idara (CPV, WWK...)</option>
                    <option value="member" {{ request('role') == 'member' ? 'selected' : '' }}>Mshirika wa Kawaida</option>
                    <option value="church_admin" {{ request('role') == 'church_admin' ? 'selected' : '' }}>Msimamizi wa Kanisa</option>
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-dark btn-sm w-100 fw-semibold rounded-3">Chuja</button>
                <a href="{{ route('security.passwords.index') }}" class="btn btn-light btn-sm border rounded-3">Rudisha</a>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover table-custom mb-0 align-middle">
                <thead>
                    <tr>
                        <th>Jina Kamili</th>
                        <th>Barua Pepe (Email)</th>
                        <th>Namba ya Simu</th>
                        <th>Jukumu Kikanisa</th>
                        <th>Hali ya Akaunti</th>
                        <th class="text-end">Mamlaka ya Nenosiri</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $u)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fw-bold" style="width: 34px; height: 34px; font-size: 0.85rem;">
                                        {{ substr($u->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">{{ $u->name }}</div>
                                        @if($u->id === $currentUser->id)
                                            <small class="badge bg-info-subtle text-info border">Akaunti Yako</small>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td><code>{{ $u->email }}</code></td>
                            <td>{{ $u->phone ?? '-' }}</td>
                            <td>
                                @php
                                    $badgeColors = [
                                        'pastor' => 'primary',
                                        'elder' => 'success',
                                        'treasurer' => 'warning',
                                        'secretary' => 'info',
                                        'department_leader' => 'secondary',
                                        'member' => 'light text-dark border',
                                        'church_admin' => 'danger',
                                        'super_admin' => 'dark',
                                    ];
                                @endphp
                                <span class="badge bg-{{ $badgeColors[$u->role] ?? 'secondary' }} rounded-pill text-capitalize px-3 py-1">
                                    {{ str_replace('_', ' ', $u->role) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill">
                                    {{ ucfirst($u->status) }}
                                </span>
                            </td>
                            <td class="text-end">
                                @if($currentUser->canResetPasswordFor($u))
                                    <button type="button" class="btn btn-outline-warning btn-sm rounded-pill px-3 shadow-sm text-dark fw-bold" data-bs-toggle="modal" data-bs-target="#userResetModal_{{ $u->id }}">
                                        <i class="bi bi-key-fill text-warning me-1"></i> Rejesha Nenosiri
                                    </button>

                                    <!-- Modal ya Kubadilisha Nenosiri la Mtumiaji Huyu -->
                                    <div class="modal fade" id="userResetModal_{{ $u->id }}" tabindex="-1">
                                        <div class="modal-dialog text-start">
                                            <div class="modal-content">
                                                <form action="{{ route('security.passwords.reset', $u) }}" method="POST">
                                                    @csrf
                                                    <div class="modal-header">
                                                        <h5 class="modal-title fw-bold">Rejesha Nenosiri la {{ $u->name }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="alert alert-light border rounded-3 p-3 mb-3 small">
                                                            <strong>Mtumiaji:</strong> {{ $u->name }} ({{ $u->email }})<br>
                                                            <strong>Jukumu:</strong> <span class="badge bg-secondary">{{ $u->role }}</span><br>
                                                            <strong>Mamlaka Yako:</strong> Unaidhinishwa kikanisa kubadilisha nenosiri hili.
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label small fw-semibold">Nenosiri Jipya *</label>
                                                            <div class="input-group">
                                                                <input type="text" name="new_password" id="input_pwd_{{ $u->id }}" class="form-control fw-bold" value="Eagt@{{ rand(1000, 9999) }}" required>
                                                                <button type="button" class="btn btn-outline-secondary" onclick="document.getElementById('input_pwd_{{ $u->id }}').value = 'Eagt@' + Math.floor(1000 + Math.random() * 9000)" title="Zalisha jipya">
                                                                    <i class="bi bi-arrow-repeat"></i>
                                                                </button>
                                                            </div>
                                                            <small class="text-muted">Unaweza kuweka nenosiri unalotaka au kutumia lililozalishwa kiotomatiki.</small>
                                                        </div>

                                                        @if($u->phone)
                                                        <div class="form-check mb-3">
                                                            <input class="form-check-input" type="checkbox" name="send_sms" id="smsCheck_{{ $u->id }}" value="1" checked>
                                                            <label class="form-check-label small fw-semibold" for="smsCheck_{{ $u->id }}">
                                                                Tuma SMS ya nenosiri jipya kwenye simu ya mtumiaji ({{ $u->phone }})
                                                            </label>
                                                        </div>
                                                        @endif

                                                        <div class="mb-3">
                                                            <label class="form-label small fw-semibold">Sababu ya Kikanisa (Inarekodiwa kwenye Audit Log)</label>
                                                            <input type="text" name="notes" class="form-control" placeholder="mfano: Ombi la mhusika ofisini / Uthibitisho wa Mzee wa Kanisa">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Ghairi</button>
                                                        <button type="submit" class="btn btn-warning fw-bold text-dark">
                                                            <i class="bi bi-shield-check me-1"></i> Hifadhi & Sasisha Nenosiri
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <span class="badge bg-light text-muted border px-3 py-2 rounded-pill" title="Huna mamlaka ya kubadilisha akaunti ya kiongozi huyu">
                                        <i class="bi bi-lock-fill me-1"></i> Imelindwa Kikanisa
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">Hakuna watumiaji waliopatikana kulingana na utafutaji wako.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection
