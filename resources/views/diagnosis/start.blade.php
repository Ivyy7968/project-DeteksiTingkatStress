@extends('layouts.app')
@section('title','Diagnosa Tingkat Stres')

@section('sidebar-menu')
<li><a href="{{ route('siswa.dashboard') }}" class="nav-link"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
<li><a href="{{ route('siswa.diagnosa') }}" class="nav-link active"><i class="bi bi-clipboard2-pulse"></i> Mulai Diagnosa</a></li>
<li><a href="{{ route('siswa.riwayat') }}" class="nav-link"><i class="bi bi-clock-history"></i> Riwayat</a></li>
@endsection

@push('styles')
<link href="{{ asset('css/start.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="question-card">
  <div class="text-center mb-4">
    <h4 class="fw-bold mb-1"><i class="bi bi-clipboard2-pulse text-primary me-2"></i>Diagnosa Tingkat Stres</h4>
    <p class="text-muted small">Jawab setiap pertanyaan dengan jujur berdasarkan kondisi yang kamu rasakan</p>
  </div>

  {{-- Progress Bar --}}
  <div class="card mb-4 p-3">
    <div class="d-flex justify-content-between align-items-center mb-2">
      <span class="small text-muted">Pertanyaan <span id="qCurrentNum">1</span> dari {{ $gejala->count() }}</span>
      <span class="small fw-semibold text-primary" id="progressPct">0%</span>
    </div>
    <div class="progress progress-custom">
      <div class="progress-bar bg-primary" id="progressBar" style="width:0%;transition:width .4s"></div>
    </div>
    <div class="d-flex flex-wrap gap-1 mt-2 justify-content-center" id="dotNav">
      @foreach($gejala as $i => $g)
      <button class="nav-dot {{ $i === 0 ? 'current' : '' }}" onclick="jumpTo({{ $i }})" title="{{ $g->kode }}"></button>
      @endforeach
    </div>
  </div>

  {{-- Question Card --}}
  <div class="card p-4" id="questionCard">
    <div class="q-number mb-2" id="qCode">G01</div>
    <h5 class="fw-semibold mb-4" id="qText">...</h5>
    <div class="d-flex flex-column gap-2">
      <button class="option-btn" id="btnYa" onclick="answer('ya')">
        <div class="check-circle" id="circleYa"></div>
        <div>
          <p class="mb-0 fw-semibold">Ya, saya mengalaminya</p>
          <p class="mb-0 text-muted small">Gejala ini sering atau selalu saya rasakan</p>
        </div>
      </button>
      <button class="option-btn" id="btnTidak" onclick="answer('tidak')">
        <div class="check-circle" id="circleTidak"></div>
        <div>
          <p class="mb-0 fw-semibold">Tidak, saya tidak mengalaminya</p>
          <p class="mb-0 text-muted small">Gejala ini jarang atau tidak pernah saya rasakan</p>
        </div>
      </button>
    </div>
  </div>

  {{-- Gejala yang dipilih --}}
  <div class="card p-3 mt-3" id="selectedBox" style="display:none">
    <p class="small fw-semibold mb-2 text-muted">
      <i class="bi bi-check2-all me-1 text-success"></i>
      Gejala yang dipilih: <span id="selectedCount">0</span>
    </p>
    <div id="selectedChips" class="d-flex flex-wrap gap-1"></div>
  </div>

  {{-- Navigation --}}
  <div class="d-flex justify-content-between mt-3">
    <button class="btn btn-outline-secondary" id="btnPrev" onclick="prevQ()" disabled><i class="bi bi-arrow-left me-1"></i>Sebelumnya</button>
    <button class="btn btn-primary" id="btnNext" onclick="nextQ()" disabled>Selanjutnya<i class="bi bi-arrow-right ms-1"></i></button>
  </div>

  {{-- Submit Form --}}
  <form id="diagnosaForm" action="{{ route('siswa.diagnosa.submit') }}" method="POST" style="display:none">
    @csrf
    <div id="gejalInputs"></div>
  </form>
</div>
@endsection

@push('scripts')
<script>
const gejala  = @json($gejala->values());
const total   = gejala.length;
let current   = 0;
const answers = {};

function render() {
  const g = gejala[current];
  document.getElementById('qCode').textContent       = g.kode;
  document.getElementById('qText').textContent       = g.nama;
  document.getElementById('qCurrentNum').textContent = current + 1;

  const pct = Math.round((Object.keys(answers).length / total) * 100);
  document.getElementById('progressBar').style.width  = pct + '%';
  document.getElementById('progressPct').textContent  = pct + '%';

  ['Ya','Tidak'].forEach(opt => {
    document.getElementById('btn' + opt).classList.remove('selected');
    document.getElementById('circle' + opt).innerHTML = '';
  });

  const prev = answers[g.kode];
  if (prev) {
    const btn = document.getElementById('btn' + (prev === 'ya' ? 'Ya' : 'Tidak'));
    btn.classList.add('selected');
    btn.querySelector('.check-circle').innerHTML = '<i class="bi bi-check text-white" style="font-size:.8rem"></i>';
  }

  document.getElementById('btnPrev').disabled = current === 0;
  document.getElementById('btnNext').disabled = !answers[g.kode];

  const dots = document.querySelectorAll('.nav-dot');
  dots.forEach((d, i) => {
    d.className = 'nav-dot';
    if (answers[gejala[i].kode]) d.classList.add('answered');
    if (i === current) d.classList.add('current');
  });

  updateChips();
}

function answer(val) {
  answers[gejala[current].kode] = val;
  render();
  setTimeout(() => {
    if (current < total - 1) { current++; render(); }
  }, 350);
}

function prevQ() { if (current > 0) { current--; render(); } }

function nextQ() {
  if (current < total - 1) { current++; render(); }
  else { submitDiagnosa(); }
}

function jumpTo(i) { current = i; render(); }

function updateChips() {
  const chips = document.getElementById('selectedChips');
  const box   = document.getElementById('selectedBox');
  const ya    = Object.entries(answers).filter(([, v]) => v === 'ya').map(([k]) => k);

  document.getElementById('selectedCount').textContent = ya.length;
  box.style.display = ya.length > 0 ? '' : 'none';
  chips.innerHTML   = ya.map(k => `<span class="gejala-chip"><i class="bi bi-check2"></i>${k}</span>`).join('');

  const btnNext = document.getElementById('btnNext');
  if (current === total - 1 && answers[gejala[current].kode]) {
    btnNext.innerHTML  = '<i class="bi bi-send me-1"></i>Lihat Hasil';
    btnNext.className  = 'btn btn-success';
    btnNext.disabled   = false;
  } else {
    btnNext.innerHTML  = 'Selanjutnya<i class="bi bi-arrow-right ms-1"></i>';
    btnNext.className  = 'btn btn-primary';
  }
}

function submitDiagnosa() {
  const ya     = Object.entries(answers).filter(([, v]) => v === 'ya').map(([k]) => k);
  const inputs = document.getElementById('gejalInputs');
  inputs.innerHTML = ya.map(k => `<input type="hidden" name="gejala[]" value="${k}">`).join('');
  document.getElementById('diagnosaForm').submit();
}

render();
</script>
@endpush