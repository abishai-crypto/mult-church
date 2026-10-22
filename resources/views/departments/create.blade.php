@extends('layouts.app')

@section('title', 'Sajili Idara Mpya')

@section('content')
<div class="container-fluid px-0">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h3 class="fw-bold mb-1">Sajili Idara Mpya / Umoja wa Huduma</h3>
            <p class="text-muted mb-0 small">Ongeza umoja mpya wa huduma wenye uongozi na mfuko huru wa fedha</p>
        </div>
        <a href="{{ route('departments.index') }}" class="btn btn-sm btn-light border rounded-pill">
            <i class="bi bi-arrow-left me-1"></i> Rudi Kwenye Idara
        </a>
    </div>

    <div class="card-custom p-4" style="max-width: 800px; margin: 0 auto;">
        <form action="{{ route('departments.store') }}" method="POST">
            @csrf

            <div class="row g-3">
                <div class="col-md-8">
                    <label class="form-label small fw-semibold">Jina la Idara / Huduma *</label>
                    <input type="text" name="name" class="form-control" placeholder="Mf. Idara ya Watoto, Uinjilisti, Ndoa na Familia" value="{{ old('name') }}" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Rangi ya Utambulisho *</label>
                    <input type="color" name="banner_color" class="form-control form-control-color w-100" value="{{ old('banner_color', '#3b82f6') }}">
                </div>

                <div class="col-12">
                    <label class="form-label small fw-semibold">Maono na Majukumu ya Idara</label>
                    <textarea name="description" class="form-control" rows="3" placeholder="Eleza madhumuni, maono na malengo ya idara hii..."></textarea>
                </div>

                <div class="col-md-6">
                    <label class="form-label small fw-semibold">Jina la Mwenyekiti / Kiongozi</label>
                    <input type="text" name="leader_name" class="form-control" placeholder="Jina la kiongozi mkuu wa idara">
                </div>

                <div class="col-md-6">
                    <label class="form-label small fw-semibold">Namba ya Simu ya Kiongozi</label>
                    <input type="text" name="leader_phone" class="form-control" placeholder="+255 7XX XXX XXX">
                </div>

                <div class="col-md-6">
                    <label class="form-label small fw-semibold">Siku ya Vikao / Ushirika</label>
                    <select name="meeting_day" class="form-select">
                        <option value="Jumamosi">Kila Jumamosi</option>
                        <option value="Jumapili">Kila Jumapili Baada ya Ibada</option>
                        <option value="Jumamosi ya Kwanza">Jumamosi ya Kwanza ya Mwezi</option>
                        <option value="Jumamosi ya Pili">Jumamosi ya Pili ya Mwezi</option>
                        <option value="Jumatano">Kila Jumatano</option>
                        <option value="Ijumaa">Kila Ijumaa</option>
                        <option value="Kila Mwezi">Mara Moja kwa Mwezi</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label small fw-semibold">Muda wa Kikao</label>
                    <input type="time" name="meeting_time" class="form-control" value="16:00">
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('departments.index') }}" class="btn btn-light border px-4">Ghairi</a>
                <button type="submit" class="btn btn-primary-custom px-4">
                    <i class="bi bi-save me-1"></i> Sajili Idara
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
