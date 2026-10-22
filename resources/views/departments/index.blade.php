@extends('layouts.app')

@section('title', 'Idara za Kanisa')

@section('content')
<div class="container-fluid px-0">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h3 class="fw-bold mb-1">Idara na Umoja wa Huduma za Kanisa</h3>
            <p class="text-muted mb-0 small">Makundi ya kiidara yenye daftari huru la washirika na fedha za idara</p>
        </div>
        <div>
            <a href="{{ route('departments.create') }}" class="btn btn-primary-custom btn-sm rounded-pill px-3 shadow-sm">
                <i class="bi bi-plus-circle me-1"></i> Sajili Idara Mpya
            </a>
        </div>
    </div>

    <div class="row g-4">
        @forelse($departments as $dept)
            <div class="col-md-6 col-lg-4">
                <div class="card-custom h-100 overflow-hidden d-flex flex-column">
                    @php
                        $deptImg = null;
                        if (stripos($dept->name, 'kwaya') !== false || stripos($dept->name, 'sifa') !== false || stripos($dept->name, 'ebeneza') !== false) {
                            $deptImg = 'assets/images/worship_soloist_choir_leading.jpg';
                        } elseif (stripos($dept->name, 'wanawake') !== false || stripos($dept->name, 'wwk') !== false) {
                            $deptImg = 'assets/images/worship_women_congregation.jpg';
                        } elseif (stripos($dept->name, 'wanaume') !== false || stripos($dept->name, 'wazee') !== false) {
                            $deptImg = 'assets/images/men_fellowship_wanaume_imani.jpg';
                        } elseif (stripos($dept->name, 'watoto') !== false || stripos($dept->name, 'cwi') !== false || stripos($dept->name, 'sunday') !== false) {
                            $deptImg = 'assets/images/cwi_children_sunday_school.jpg';
                        } elseif (stripos($dept->name, 'vijana') !== false || stripos($dept->name, 'cgm') !== false) {
                            $deptImg = 'assets/images/cgm_youth_choir_uniform.jpg';
                        } elseif (stripos($dept->name, 'ujenzi') !== false) {
                            $deptImg = 'assets/images/church_building.jpg';
                        }
                    @endphp
                    @if($deptImg)
                        <div style="height: 140px; overflow: hidden;" class="position-relative">
                            <img src="{{ asset($deptImg) }}" alt="{{ $dept->name }}" class="w-100 h-100 object-fit-cover">
                            <div class="position-absolute bottom-0 start-0 end-0" style="height: 4px; background: {{ $dept->banner_color }};"></div>
                        </div>
                    @else
                        <!-- Color Banner -->
                        <div style="height: 8px; background: {{ $dept->banner_color }};"></div>
                    @endif
                    
                    <div class="p-4 flex-grow-1 d-flex flex-column justify-content-between">
                        <div>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <h5 class="fw-bold mb-0 text-dark">{{ $dept->name }}</h5>
                                <span class="badge rounded-pill" style="background: {{ $dept->banner_color }}15; color: {{ $dept->banner_color }};">
                                    Washirika {{ $dept->department_members_count }}
                                </span>
                            </div>

                            <p class="text-muted small mb-3">
                                {{ Str::limit($dept->description, 110) }}
                            </p>

                            <div class="border-top pt-3 small">
                                <div class="d-flex align-items-center gap-2 mb-1">
                                    <i class="bi bi-person-fill text-muted"></i>
                                    <span>Kiongozi: <strong>{{ $dept->leader_name ?? 'Bado Hajateuliwa' }}</strong></span>
                                </div>
                                @if($dept->meeting_day)
                                    <div class="d-flex align-items-center gap-2 text-muted">
                                        <i class="bi bi-calendar-event"></i>
                                        <span>{{ $dept->meeting_day }} saa {{ $dept->meeting_time ?? 'Kupangwa' }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="mt-4 pt-3 border-top">
                            <a href="{{ route('departments.show', $dept) }}" class="btn btn-light border btn-sm w-100 fw-semibold rounded-pill">
                                Tazama Idara Hii <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <p class="text-muted">Hakuna idara zilizosajiliwa bado.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
