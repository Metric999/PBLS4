@extends('layouts.admin')
@section('title', 'Tambah Jadwal')

@push('styles')
<style>
.sched-header{display:flex;align-items:flex-end;gap:14px;margin-bottom:16px;flex-wrap:wrap}
.sched-header .fg{margin:0;display:flex;flex-direction:column;gap:4px}
.sched-header label{font-size:13px;font-weight:500;color:#374151}
.sched-header select,.sched-header input[type=text]{padding:9px 30px 9px 11px;border:1.5px solid #D1D5DB;border-radius:7px;font-size:13px;color:#111827;background:#fff;outline:none;cursor:pointer;min-width:160px;appearance:none;background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%236B7280' stroke-width='1.5' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");background-repeat:no-repeat;background-position:right 10px center}
.sched-header select:focus,.sched-header input:focus{border-color:#1B5FE0;box-shadow:0 0 0 3px rgba(27,95,224,.1)}
.sched-header input[type=text]{background-image:none;padding-right:11px}

/* Grid card */
.sched-card{background:#fff;border:1px solid #E5E7EB;border-radius:12px;overflow:hidden;margin-bottom:18px}
.sched-wrap{overflow-x:auto}
.sched-tbl{width:100%;border-collapse:collapse;font-size:12px;min-width:720px}

/* Headers */
.sched-tbl .h-sem{background:#1B5FE0;color:#fff;text-align:center;font-weight:700;font-size:13px;padding:9px 12px;letter-spacing:.4px}
.sched-tbl .h-kls{background:#1E40AF;color:#fff;text-align:center;font-weight:600;font-size:12px;padding:7px 8px;border-left:1px solid rgba(255,255,255,.15)}
.sched-tbl .h-col{background:#2563EB;color:#fff;text-align:center;font-weight:600;font-size:11.5px;padding:7px 6px;border-left:1px solid rgba(255,255,255,.2)}
.sched-tbl .h-lbl{background:#1E40AF;color:#fff;text-align:center;font-weight:700;font-size:12px;padding:7px 8px}

/* Cells */
.sched-tbl td{border:1px solid #E5E7EB;padding:0;height:36px;vertical-align:middle}
.td-day{background:#EFF6FF;text-align:center;font-weight:700;font-size:11.5px;color:#1D4ED8;padding:4px 6px;white-space:nowrap;width:60px}
.td-jam{background:#F9FAFB;text-align:center;color:#374151;font-size:11.5px;padding:3px 8px;white-space:nowrap;width:110px}
.td-sep{background:#E0E7FF;height:5px;padding:0}

/* Clickable schedule cells */
.sc{width:100%;height:36px;display:flex;align-items:center;justify-content:center;cursor:pointer;transition:background .12s;position:relative;padding:3px 6px}
.sc.emp:hover{background:#EFF6FF}
.sc.emp:hover::after{content:'+';font-size:16px;color:#93C5FD}
.sc.fil{background:#DBEAFE;flex-direction:column;align-items:flex-start;height:auto;min-height:36px;cursor:pointer}
.sc.fil:hover{background:#BFDBFE}
.sc-mk{font-size:10.5px;font-weight:600;color:#1E40AF;line-height:1.3;word-break:break-word}
.sc-info{font-size:10px;color:#6B7280;line-height:1.2}
.sc-del{position:absolute;top:2px;right:3px;background:none;border:none;cursor:pointer;color:#EF4444;font-size:12px;line-height:1;display:none}
.sc.fil:hover .sc-del{display:block}

/* Modal */
.mo{display:none;position:fixed;inset:0;background:rgba(0,0,0,.45);z-index:9999;align-items:center;justify-content:center}
.mo.open{display:flex}
.mo-box{background:#fff;border-radius:14px;padding:26px 26px 22px;width:100%;max-width:420px;box-shadow:0 20px 60px rgba(0,0,0,.22);animation:fu .18s ease}
@keyframes fu{from{opacity:0;transform:translateY(14px)}to{opacity:1;transform:translateY(0)}}
.mo-ttl{font-size:14.5px;font-weight:600;color:#111827;margin-bottom:2px}
.mo-sub{font-size:12px;color:#6B7280;margin-bottom:18px}
.mo-fg{margin-bottom:12px}
.mo-fg label{font-size:12.5px;font-weight:500;color:#374151;display:block;margin-bottom:4px}
.mo-fg select{width:100%;padding:8px 28px 8px 10px;border:1.5px solid #D1D5DB;border-radius:7px;font-size:13px;color:#111827;outline:none;appearance:none;background:#fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%236B7280' stroke-width='1.5' fill='none' stroke-linecap='round'/%3E%3C/svg%3E") no-repeat right 10px center;cursor:pointer;transition:border-color .15s}
.mo-fg select:focus{border-color:#1B5FE0;box-shadow:0 0 0 3px rgba(27,95,224,.1)}
.mo-acts{display:flex;gap:10px;margin-top:18px}
.mo-save{flex:1;padding:10px;background:#1B5FE0;color:#fff;border:none;border-radius:7px;font-size:13.5px;font-weight:500;cursor:pointer}
.mo-save:hover{background:#1347B4}
.mo-cancel{padding:10px 16px;background:#fff;color:#374151;border:1.5px solid #D1D5DB;border-radius:7px;font-size:13.5px;cursor:pointer}
.mo-cancel:hover{background:#F3F4F6}

/* Bottom actions */
.pg-acts{display:flex;gap:12px;align-items:center}
.btn-save-all{padding:10px 28px;background:#1B5FE0;color:#fff;border:none;border-radius:7px;font-size:14px;font-weight:600;cursor:pointer}
.btn-save-all:hover{background:#1347B4}
.btn-cncl-lnk{font-size:13px;color:#6B7280;text-decoration:none}
.btn-cncl-lnk:hover{color:#111827}
</style>
@endpush

@section('content')

{{-- ── Kelas & Semester picker ── --}}
<div class="sched-header">
    <div class="fg">
        <label>Semester</label>
        <select id="selSem">
            @for($i=1;$i<=8;$i++)
                <option value="{{$i}}">Semester {{$i}}</option>
            @endfor
        </select>
    </div>
    <div class="fg">
        <label>Kelas <span style="color:#DC2626">*</span></label>
        <select id="selKelas">
            <option value="">-- Pilih Kelas --</option>
            @foreach($kelasList as $k)
                <option value="{{$k}}">{{$k}}</option>
            @endforeach
            <option value="__new__">+ Kelas Baru...</option>
        </select>
    </div>
    <div class="fg" id="newKelasWrap" style="display:none">
        <label>Nama Kelas</label>
        <input type="text" id="newKelasVal" placeholder="cth: IF4C-Pagi" style="width:140px">
    </div>
    <div style="align-self:flex-end;font-size:11.5px;color:#9CA3AF;padding-bottom:10px">
        Klik cell kosong untuk mengisi jadwal
    </div>
</div>

{{-- ── Grid ── --}}
<div class="sched-card">
    <div class="sched-wrap">
        <table class="sched-tbl" id="schedTbl">
            <thead>
                <tr>
                    <th class="h-lbl" rowspan="3" style="width:60px">Hari</th>
                    <th class="h-lbl" rowspan="3" style="width:110px">Jam</th>
                    <th class="h-sem" colspan="3" id="hSem">SEMESTER 1</th>
                </tr>
                <tr>
                    <th class="h-kls" colspan="3" id="hKls">-- Pilih Kelas --</th>
                </tr>
                <tr>
                    <th class="h-col">Mata Kuliah</th>
                    <th class="h-col" style="width:90px">Dosen</th>
                    <th class="h-col" style="width:80px">Ruang</th>
                </tr>
            </thead>
            <tbody id="schedBody"></tbody>
        </table>
    </div>
</div>

{{-- ── Hidden form for submit ── --}}
<form id="schedForm" method="POST" action="{{ route('admin.jadwal.store') }}">
    @csrf
    <input type="hidden" name="kelas"    id="fKelas">
    <input type="hidden" name="semester" id="fSem">
    <div id="hiddenData"></div>
    <div class="pg-acts">
        <button type="submit" class="btn-save-all" onclick="return submitAll()">Simpan Jadwal</button>
        <a href="{{ route('admin.jadwal.index') }}" class="btn-cncl-lnk">Batal</a>
    </div>
</form>

{{-- ── Modal ── --}}
<div class="mo" id="modal">
    <div class="mo-box">
        <div class="mo-ttl" id="moTtl">Tambah Jadwal</div>
        <div class="mo-sub" id="moSub">Senin · 09:30 – 10:20</div>
        <div class="mo-fg">
            <label>Mata Kuliah <span style="color:#DC2626">*</span></label>
            <select id="mMk">
                <option value="">Pilih Mata Kuliah</option>
                @foreach($matkuls as $mk)
                    <option value="{{$mk->id_matkul}}" data-n="{{$mk->nama_matkul}}">{{$mk->nama_matkul}}</option>
                @endforeach
            </select>
        </div>
        <div class="mo-fg">
            <label>Dosen <span style="color:#DC2626">*</span></label>
            <select id="mDs">
                <option value="">Pilih Dosen</option>
                @foreach($dosens as $d)
                    <option value="{{$d->nidn}}" data-n="{{$d->nama}}">{{$d->nama}}</option>
                @endforeach
            </select>
        </div>
        <div class="mo-fg">
            <label>Ruangan <span style="color:#DC2626">*</span></label>
            <select id="mRu">
                <option value="">Pilih Ruangan</option>
                @foreach($ruangans as $r)
                    <option value="{{$r->id_ruangan}}" data-n="{{$r->id_ruangan}}">{{$r->id_ruangan}} – {{$r->nama_ruangan}}</option>
                @endforeach
            </select>
        </div>
        <div class="mo-acts">
            <button class="mo-save"   type="button" onclick="saveCell()">Simpan</button>
            <button class="mo-cancel" type="button" onclick="closeModal()">Batal</button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
const DAYS  = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
const SLOTS = [
    '07:00-07:50','07:50-08:40','08:40-09:30',
    '09:30-10:20','10:20-11:10','11:10-12:00',
    '12:00-12:50','12:50-13:40','13:40-14:30',
    '14:30-15:20','15:20-16:10','16:10-17:00'
];

// jadwalData[day][slot] = {id_matkul, mkNama, nidn, dsNama, id_ruangan}
const J = {};
DAYS.forEach(d => J[d] = {});

let curDay = null, curSlot = null;

// ── Build grid ──────────────────────────────────────────────────────
function buildGrid() {
    const body = document.getElementById('schedBody');
    body.innerHTML = '';

    DAYS.forEach((day, di) => {
        SLOTS.forEach((slot, si) => {
            const data = J[day][slot];
            const tr   = document.createElement('tr');

            // Day column (merged for all slots of a day)
            if (si === 0) {
                const td = document.createElement('td');
                td.className = 'td-day'; td.rowSpan = SLOTS.length;
                td.textContent = day;
                tr.appendChild(td);
            }

            // Time column
            const tdJ = document.createElement('td');
            tdJ.className   = 'td-jam';
            tdJ.textContent = slot.replace('-', ' – ');
            tr.appendChild(tdJ);

            if (data) {
                // Mata kuliah cell
                const tdMk = document.createElement('td');
                const cMk  = mkCell(day, slot, data.mkNama, data);
                tdMk.appendChild(cMk); tr.appendChild(tdMk);
                // Dosen cell
                const tdDs = document.createElement('td');
                const cDs  = mkCell(day, slot, data.dsNama, data, true);
                tdDs.appendChild(cDs); tr.appendChild(tdDs);
                // Ruangan cell
                const tdRu = document.createElement('td');
                const cRu  = mkCell(day, slot, data.id_ruangan, data, true);
                tdRu.appendChild(cRu); tr.appendChild(tdRu);
            } else {
                const tdEmp = document.createElement('td');
                tdEmp.colSpan = 3;
                const c = document.createElement('div');
                c.className = 'sc emp';
                c.onclick   = () => openModal(day, slot);
                tdEmp.appendChild(c); tr.appendChild(tdEmp);
            }

            body.appendChild(tr);
        });

        // Separator row
        const sep = document.createElement('tr');
        const std = document.createElement('td');
        std.colSpan = 5; std.className = 'td-sep';
        sep.appendChild(std); body.appendChild(sep);
    });
}

function mkCell(day, slot, label, data, noDelete=false) {
    const c = document.createElement('div');
    c.className = 'sc fil';
    c.onclick   = () => openModal(day, slot);
    if (!noDelete) {
        const del = document.createElement('button');
        del.className = 'sc-del'; del.type = 'button'; del.innerHTML = '✕';
        del.onclick = (e) => { e.stopPropagation(); delete J[day][slot]; buildGrid(); };
        c.appendChild(del);
        const txt = document.createElement('div');
        txt.className = 'sc-mk'; txt.textContent = label;
        c.appendChild(txt);
    } else {
        const txt = document.createElement('div');
        txt.className = 'sc-info'; txt.textContent = label;
        c.appendChild(txt);
    }
    return c;
}

// ── Modal ────────────────────────────────────────────────────────────
function openModal(day, slot) {
    if (!getKelas()) { alert('Pilih kelas terlebih dahulu!'); return; }
    curDay = day; curSlot = slot;
    const [s, e] = slot.split('-');
    document.getElementById('moTtl').textContent = 'Tambah Jadwal – ' + day;
    document.getElementById('moSub').textContent = day + ' · ' + s + ' – ' + e;
    const d = J[day][slot];
    document.getElementById('mMk').value = d?.id_matkul  ?? '';
    document.getElementById('mDs').value = d?.nidn        ?? '';
    document.getElementById('mRu').value = d?.id_ruangan  ?? '';
    document.getElementById('modal').classList.add('open');
}
function closeModal() {
    document.getElementById('modal').classList.remove('open');
    curDay = curSlot = null;
}
function saveCell() {
    const mk = document.getElementById('mMk');
    const ds = document.getElementById('mDs');
    const ru = document.getElementById('mRu');
    if (!mk.value || !ds.value || !ru.value) { alert('Lengkapi semua field!'); return; }
    J[curDay][curSlot] = {
        id_matkul: mk.value, mkNama: mk.options[mk.selectedIndex].dataset.n,
        nidn: ds.value,      dsNama: ds.options[ds.selectedIndex].dataset.n,
        id_ruangan: ru.value,
    };
    closeModal(); buildGrid();
}
document.getElementById('modal').addEventListener('click', e => { if(e.target===document.getElementById('modal')) closeModal(); });

// ── Header update ────────────────────────────────────────────────────
function getKelas() {
    const s = document.getElementById('selKelas');
    if (s.value === '__new__') return document.getElementById('newKelasVal').value.trim();
    return s.value;
}
function updHeader() {
    const sem = document.getElementById('selSem').value;
    const kls = getKelas() || '-- Pilih Kelas --';
    document.getElementById('hSem').textContent = 'SEMESTER ' + sem;
    document.getElementById('hKls').textContent = kls;
}
document.getElementById('selKelas').addEventListener('change', function(){
    document.getElementById('newKelasWrap').style.display = this.value==='__new__'?'block':'none';
    updHeader();
});
document.getElementById('newKelasVal').addEventListener('input', updHeader);
document.getElementById('selSem').addEventListener('change', updHeader);

// ── Submit ───────────────────────────────────────────────────────────
function submitAll() {
    const kelas = getKelas();
    if (!kelas) { alert('Pilih atau isi nama kelas!'); return false; }
    document.getElementById('fKelas').value = kelas;
    document.getElementById('fSem').value   = document.getElementById('selSem').value;

    const cont = document.getElementById('hiddenData');
    cont.innerHTML = ''; let idx = 0;
    DAYS.forEach(day => {
        SLOTS.forEach(slot => {
            const d = J[day][slot]; if(!d) return;
            const [s, e] = slot.split('-');
            const p = `jadwals[${idx}]`;
            cont.innerHTML += `
                <input type="hidden" name="${p}[hari]"        value="${day}">
                <input type="hidden" name="${p}[jam_mulai]"   value="${s}:00">
                <input type="hidden" name="${p}[jam_selesai]" value="${e}:00">
                <input type="hidden" name="${p}[id_matkul]"   value="${d.id_matkul}">
                <input type="hidden" name="${p}[nidn]"        value="${d.nidn}">
                <input type="hidden" name="${p}[id_ruangan]"  value="${d.id_ruangan}">
            `; idx++;
        });
    });
    if (idx === 0) { alert('Belum ada jadwal yang diisi!'); return false; }
    return true;
}

buildGrid();
</script>
@endpush