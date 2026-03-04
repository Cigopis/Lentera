{{-- resources/views/livewire/catalog-image-manager.blade.php --}}

<div
    x-data="imageManager(@js($imageList), @js($gridMode))"
    x-init="init()"
    x-on:livewire-updated.window="syncFromLivewire(@js($imageList), @js($gridMode))"
    wire:key="img-mgr-{{ $catalogId }}"
>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,600;9..40,700&display=swap" rel="stylesheet">

<style>
/* ─────────────────────────────────────────────────
   TOKENS  (light defaults)
───────────────────────────────────────────────── */
.imgm {
  --p:          #0f1117;
  --s:          #6b7280;
  --m:          #9ca3af;
  --f:          #d1d5db;

  --bg0:        #ffffff;
  --bg1:        #f7f8fa;
  --bg2:        #f0f2f6;
  --bg3:        #e5e8ef;
  --bgi:        #f0f2f5;

  --b0:         rgba(0,0,0,.09);
  --b1:         rgba(0,0,0,.06);
  --b2:         rgba(0,0,0,.04);

  --acc:        #6366f1;
  --acc-glow:   rgba(99,102,241,.22);
  --acc-soft:   rgba(99,102,241,.09);
  --acc-b:      rgba(99,102,241,.28);

  --grn:        #059669;
  --red:        #dc2626;
  --red-soft:   rgba(220,38,38,.09);
  --red-b:      rgba(220,38,38,.2);

  --sh-card:    0 1px 3px rgba(0,0,0,.07), 0 4px 12px rgba(0,0,0,.05);
  --sh-primary: 0 0 0 2px #6366f1, 0 0 0 5px rgba(99,102,241,.12), 0 4px 16px rgba(0,0,0,.1);
  --sh-hidden:  0 0 0 1.5px rgba(220,38,38,.35), 0 4px 12px rgba(0,0,0,.07);
  --sh-modal:   0 20px 60px rgba(0,0,0,.15), 0 0 0 1px rgba(0,0,0,.06);

  --bar-from:   rgba(0,0,0,.88);
  --bar-mid:    rgba(0,0,0,.52);

  --chip-bg:    rgba(0,0,0,.52);
  --chip-b:     rgba(255,255,255,.14);
  --chip-c:     rgba(255,255,255,.82);

  --vignette:   rgba(0,0,0,.18);
  --stripe:     rgba(0,0,0,.04);

  --mo-bg:      #ffffff;
  --mo-b:       rgba(0,0,0,.08);
}

/* ─────────────────────────────────────────────────
   DARK OVERRIDES
───────────────────────────────────────────────── */
.dark .imgm {
  --p:          rgba(255,255,255,.88);
  --s:          rgba(255,255,255,.44);
  --m:          rgba(255,255,255,.28);
  --f:          rgba(255,255,255,.14);

  --bg0:        #0d0f14;
  --bg1:        rgba(255,255,255,.02);
  --bg2:        #080b10;
  --bg3:        #101318;
  --bgi:        rgba(255,255,255,.05);

  --b0:         rgba(255,255,255,.07);
  --b1:         rgba(255,255,255,.05);
  --b2:         rgba(255,255,255,.03);

  --acc-glow:   rgba(99,102,241,.38);
  --acc-soft:   rgba(99,102,241,.14);
  --acc-b:      rgba(99,102,241,.32);

  --grn:        #34d399;
  --red:        #f87171;
  --red-soft:   rgba(239,68,68,.13);
  --red-b:      rgba(239,68,68,.26);

  --sh-card:    0 4px 14px rgba(0,0,0,.32);
  --sh-primary: 0 0 0 2px #6366f1, 0 0 0 5px rgba(99,102,241,.16), 0 8px 24px rgba(0,0,0,.44);
  --sh-hidden:  0 0 0 1.5px rgba(239,68,68,.28), 0 4px 14px rgba(0,0,0,.32);
  --sh-modal:   0 40px 80px rgba(0,0,0,.6), 0 0 0 1px rgba(255,255,255,.04);

  --bar-from:   rgba(0,0,0,.94);
  --bar-mid:    rgba(0,0,0,.6);

  --chip-bg:    rgba(0,0,0,.65);
  --chip-b:     rgba(255,255,255,.1);
  --chip-c:     rgba(255,255,255,.72);

  --vignette:   rgba(0,0,0,.34);
  --stripe:     rgba(255,255,255,.025);

  --mo-bg:      #111318;
  --mo-b:       rgba(255,255,255,.08);
}

/* ─────────────────────────────────────────────────
   BASE
───────────────────────────────────────────────── */
.imgm, .imgm * {
  font-family: 'DM Sans', system-ui, sans-serif;
  box-sizing: border-box;
}

/* ── Panel ── */
.imgm__panel {
  background: var(--bg0);
  border: 1px solid var(--b0);
  border-radius: 16px;
  overflow: hidden;
  box-shadow: var(--sh-card);
  transition: background .2s, border-color .2s;
}

/* ── Header ── */
.imgm__hdr {
  display: flex; align-items: center; justify-content: space-between; gap: 12px;
  padding: 13px 18px;
  background: var(--bg1);
  border-bottom: 1px solid var(--b1);
}
.imgm__hdr-icon {
  width: 32px; height: 32px; border-radius: 10px; flex-shrink: 0;
  display: flex; align-items: center; justify-content: center;
  background: var(--acc-soft); border: 1px solid var(--acc-b);
  color: var(--acc);
}
.imgm__hdr-title { font-size: 13px; font-weight: 600; color: var(--p); margin-bottom: 3px; }
.imgm__hdr-meta  { display: flex; align-items: center; gap: 5px; font-size: 11px; }
.imgm__hdr-val   { color: var(--s); font-weight: 600; }
.imgm__hdr-dot   { color: var(--f); }
.imgm__hdr-grn   { color: var(--grn); font-weight: 500; }
.imgm__hdr-red   { color: var(--red); }

/* ── Layout switcher ── */
.imgm__switcher {
  display: flex; gap: 2px; padding: 3px;
  background: var(--bgi); border: 1px solid var(--b1); border-radius: 10px;
}
.imgm__sw-btn {
  width: 28px; height: 28px; border-radius: 7px; border: none; outline: none;
  display: flex; align-items: center; justify-content: center;
  cursor: pointer; color: var(--m); background: transparent;
  transition: background .14s, color .14s, box-shadow .14s;
}
.imgm__sw-btn:hover { background: var(--b1); color: var(--s); }
.imgm__sw-btn--on {
  background: var(--acc) !important; color: #fff !important;
  box-shadow: 0 3px 10px var(--acc-glow);
}

/* ── Section label ── */
.imgm__lbl {
  display: flex; align-items: center; gap: 7px; margin-bottom: 10px;
}
.imgm__lbl-dot {
  width: 6px; height: 6px; border-radius: 99px;
  background: #f59e0b; box-shadow: 0 0 7px rgba(245,158,11,.55);
  animation: pulse 2s infinite;
}
.imgm__lbl-text {
  font-size: 10px; font-weight: 600;
  text-transform: uppercase; letter-spacing: .12em; color: var(--m);
}
.imgm__lbl-sub { font-size: 10px; color: var(--f); }

/* ── Preview frame ── */
.imgm__preview {
  height: 480px;
  border-radius: 10px;
  overflow: hidden;
  border: 1px solid var(--b1);
  background: var(--bg2);
  position: relative; /* penting — jadi acuan position:absolute grid di dalamnya */
}

/*
 * KEY FIX: Semua 3 grid preview di-render sekaligus dengan position:absolute.
 * Toggle visibility pakai opacity + pointer-events, BUKAN x-show/display.
 * Ini mencegah Alpine.js meng-override display:grid menjadi display:block.
 */
.imgm__pv {
  position: absolute;
  inset: 0;
  display: grid;       /* selalu grid, tidak pernah berubah */
  transition: opacity .15s;
}
.imgm__pv--hidden {
  opacity: 0;
  pointer-events: none;
}

/* Slot di dalam preview */
.imgm__slot {
  position: relative;
  overflow: hidden;
  background: var(--bg3);
  width: 100%;
  height: 100%;
}
.imgm__slot-empty {
  width: 100%; height: 100%;
  background-image: repeating-linear-gradient(
    -45deg,
    var(--stripe) 0px, var(--stripe) 1px,
    transparent 1px, transparent 8px
  );
}

/* ── Separator ── */
.imgm__sep {
  height: 1px; margin: 0 18px;
  background: linear-gradient(to right, transparent, var(--b0) 25%, var(--b0) 75%, transparent);
}

/* ── Grid header ── */
.imgm__grid-hdr {
  display: flex; align-items: center; justify-content: space-between; margin-bottom: 13px;
}
.imgm__grid-lbl { display: flex; align-items: center; gap: 7px; }
.imgm__grid-lbl-txt {
  font-size: 10px; font-weight: 600;
  text-transform: uppercase; letter-spacing: .12em; color: var(--m);
}
.imgm__grid-pill {
  font-size: 10px; padding: 2px 8px; border-radius: 99px;
  background: var(--bgi); color: var(--m); border: 1px solid var(--b1);
}
.imgm__grid-hint { display: flex; align-items: center; gap: 5px; font-size: 11px; color: var(--f); }

/* ── Photo card ── */
.imgm__card {
  border-radius: 10px; overflow: hidden;
  cursor: grab; position: relative;
  transition: transform .18s cubic-bezier(.4,0,.2,1), box-shadow .18s;
}
.imgm__card:hover              { transform: translateY(-2px); }
.imgm__card.sortable-ghost     { opacity: .18; }
.imgm__card.sortable-chosen    {
  transform: scale(1.04) rotate(.4deg);
  box-shadow: 0 0 0 2px var(--acc), 0 20px 40px rgba(0,0,0,.38) !important;
  z-index: 50;
}

/*
 * KEY FIX: Ganti padding-top:72% trick dengan aspect-ratio.
 * aspect-ratio membuat elemen punya height otomatis tanpa perlu
 * child position:absolute yang bergantung pada parent punya height.
 */
.imgm__card-img-wrap {
  position: relative;
  width: 100%;
  aspect-ratio: 6 / 3;
}

/* ── Chip on image ── */
.imgm__chip {
  width: 20px; height: 20px; border-radius: 6px;
  display: flex; align-items: center; justify-content: center;
  background: var(--chip-bg); border: 1px solid var(--chip-b); color: var(--chip-c);
  font-size: 9px; font-weight: 700; font-variant-numeric: tabular-nums;
  backdrop-filter: blur(6px);
}
.imgm__chip--star { background: #f59e0b; border-color: transparent; box-shadow: 0 2px 8px rgba(245,158,11,.5); }
.imgm__chip--eye  { background: rgba(239,68,68,.7); border-color: transparent; }

/* ── Action bar ── */
.imgm__bar {
  position: absolute; bottom: 0; left: 0; right: 0;
  transform: translateY(110%); opacity: 0;
  transition: transform .2s cubic-bezier(.4,0,.2,1), opacity .15s;
}
.imgm__card:hover .imgm__bar { transform: translateY(0); opacity: 1; }
.imgm__bar-inner {
  padding: 20px 7px 7px;
  display: flex; align-items: flex-end; justify-content: space-between; gap: 5px;
  background: linear-gradient(to top, var(--bar-from) 0%, var(--bar-mid) 55%, transparent 100%);
}

/* Action buttons */
.imgm__abtn-text {
  height: 24px; padding: 0 8px; border-radius: 6px; border: none; outline: none;
  display: inline-flex; align-items: center; gap: 4px;
  font-size: 10px; font-weight: 600; cursor: pointer; white-space: nowrap;
  background: rgba(255,255,255,.14); color: rgba(255,255,255,.88);
  border: 1px solid rgba(255,255,255,.12);
  transition: background .14s, color .14s, border-color .14s;
}
.imgm__abtn-text:hover:not([disabled]) { background: #f59e0b; color: #78350f; border-color: transparent; }
.imgm__abtn-text--on { background: #f59e0b !important; color: #78350f !important; border-color: transparent !important; cursor: default; }

.imgm__abtn-icon {
  width: 24px; height: 24px; border-radius: 6px; border: none; outline: none;
  display: flex; align-items: center; justify-content: center; cursor: pointer;
  transition: background .14s, color .14s, border-color .14s;
}
.imgm__abtn-icon--vis {
  background: rgba(255,255,255,.14); color: rgba(255,255,255,.88);
  border: 1px solid rgba(255,255,255,.12);
}
.imgm__abtn-icon--vis:hover { background: #fff; color: #111; border-color: transparent; }
.imgm__abtn-icon--hid {
  background: rgba(239,68,68,.65); color: #fff; border: 1px solid transparent;
}
.imgm__abtn-icon--hid:hover { background: #f87171; }
.imgm__abtn-icon--del {
  background: rgba(255,255,255,.14); color: rgba(255,255,255,.88);
  border: 1px solid rgba(255,255,255,.12);
}
.imgm__abtn-icon--del:hover { background: rgba(239,68,68,.8); color: #fff; border-color: transparent; }

/* ── Badge in preview ── */
.imgm__badge {
  display: inline-flex; align-items: center; gap: 3px;
  font-size: 9px; font-weight: 700; letter-spacing: .04em; text-transform: uppercase;
  padding: 3px 7px 3px 5px; border-radius: 99px; line-height: 1;
  background: #fef3c7; color: #78350f;
}

/* ── Empty state ── */
.imgm__empty {
  display: flex; flex-direction: column; align-items: center; justify-content: center;
  padding: 44px 16px;
  border: 1px dashed var(--b0); border-radius: 12px;
}
.imgm__empty-icon {
  width: 46px; height: 46px; border-radius: 14px; margin-bottom: 14px;
  display: flex; align-items: center; justify-content: center;
  background: var(--bgi); border: 1px solid var(--b1); color: var(--m);
}
.imgm__empty-t { font-size: 13px; font-weight: 500; color: var(--s); }
.imgm__empty-s { font-size: 12px; color: var(--m); margin-top: 4px; }

/* ── Modal ── */
.imgm__overlay {
  position: fixed; inset: 0; z-index: 9999;
  display: flex; align-items: center; justify-content: center;
  background: rgba(0,0,0,.58); backdrop-filter: blur(10px);
}
.imgm__modal {
  width: 100%; max-width: 316px; margin: 0 16px;
  border-radius: 18px; padding: 20px;
  background: var(--mo-bg); border: 1px solid var(--mo-b);
  box-shadow: var(--sh-modal);
  transition: background .2s, border-color .2s;
}
.imgm__modal-icon {
  width: 44px; height: 44px; border-radius: 13px; margin-bottom: 14px;
  display: flex; align-items: center; justify-content: center;
  background: var(--red-soft); border: 1px solid var(--red-b); color: var(--red);
}
.imgm__modal-title { font-size: 15px; font-weight: 600; color: var(--p); margin-bottom: 5px; }
.imgm__modal-desc  { font-size: 13px; line-height: 1.6; color: var(--s); margin-bottom: 18px; }
.imgm__modal-row   { display: flex; gap: 8px; }
.imgm__mbtn {
  flex: 1; height: 36px; border-radius: 10px;
  font-size: 13px; font-weight: 500; cursor: pointer; border: none; outline: none;
  transition: opacity .14s, background .14s;
}
.imgm__mbtn--cancel {
  background: var(--bgi); color: var(--s); border: 1px solid var(--b1);
}
.imgm__mbtn--cancel:hover { opacity: .75; }
.imgm__mbtn--del {
  background: var(--red); color: #fff; font-weight: 600;
  box-shadow: 0 4px 14px rgba(220,38,38,.28);
}
.imgm__mbtn--del:hover { opacity: .85; }

@keyframes pop-in {
  from { opacity:0; transform: scale(.93) translateY(6px); }
  to   { opacity:1; transform: scale(1)   translateY(0);   }
}
.imgm__pop { animation: pop-in .2s cubic-bezier(.34,1.56,.64,1) both; }
</style>

{{-- ═══════════════════════════════════════════════ PANEL ═══ --}}
<div class="imgm">
<div class="imgm__panel">

  {{-- ── HEADER ── --}}
  <div class="imgm__hdr">
    <div style="display:flex;align-items:center;gap:11px;">
      <div class="imgm__hdr-icon">
        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
        </svg>
      </div>
      <div>
        <div class="imgm__hdr-title">Kelola Foto</div>
        <div class="imgm__hdr-meta">
          <span class="imgm__hdr-val" x-text="images.length"></span>
          <span style="color:var(--f)">foto</span>
          <span class="imgm__hdr-dot">·</span>
          <span class="imgm__hdr-grn" x-text="visibleImages.length + ' aktif'"></span>
          <template x-if="images.filter(i=>!i.is_visible).length > 0">
            <span style="display:flex;align-items:center;gap:5px;">
              <span class="imgm__hdr-dot">·</span>
              <span class="imgm__hdr-red" x-text="images.filter(i=>!i.is_visible).length + ' hidden'"></span>
            </span>
          </template>
        </div>
      </div>
    </div>

    {{-- Layout switcher --}}
    <div class="imgm__switcher">
      <template x-for="m in [
        {k:'main+3',l:'Card',d:'M2 3h9v10H2zM13 3h9v4h-9zM13 9h9v4h-9zM13 15h9v6h-9z'},
        {k:'2col',  l:'2×2', d:'M2 2h9v9H2zM13 2h9v9h-9zM2 13h9v9H2zM13 13h9v9h-9z'},
        {k:'3col',  l:'3×3', d:'M2 2h5v5H2zM9.5 2h5v5h-5zM17 2h5v5h-5zM2 9.5h5v5H2zM9.5 9.5h5v5h-5zM17 9.5h5v5h-5zM2 17h5v5H2zM9.5 17h5v5h-5zM17 17h5v5h-5z'}
      ]" :key="m.k">
        <button 
            type="button" 
            :title="m.l"
            class="imgm__sw-btn"
            :class="gridMode === m.k ? 'imgm__sw-btn--on' : ''"
            @click="
                gridMode = m.k;
                $wire.setGridMode(m.k);
            "
        >
          <svg width="13" height="13" fill="currentColor" viewBox="0 0 24 24"><path :d="m.d"/></svg>
        </button>
      </template>
    </div>
    
  </div>

  {{-- ── LIVE PREVIEW ── --}}
  <div style="padding:16px 18px 13px;">
    <div class="imgm__lbl">
      <span class="imgm__lbl-dot"></span>
      <span class="imgm__lbl-text">Live Preview</span>
      <span class="imgm__lbl-sub">— tampilan di halaman publik</span>
    </div>

    {{-- Preview: semua 3 grid selalu di-render (position:absolute),
         toggle via :class imgm__pv--hidden (opacity:0) bukan x-show --}}
    <div class="imgm__preview">

      {{-- ── Card layout (main+3) ── --}}
      <div class="imgm__pv"
           :class="gridMode !== 'main+3' ? 'imgm__pv--hidden' : ''"
           style="grid-template-columns:2fr 1fr;gap:2px;background:var(--b1);">

        {{-- Foto utama --}}
        <div class="imgm__slot">
          <template x-if="visibleImages[0]">
            <img :src="visibleImages[0].url"
                 style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;transition:opacity .2s;"/>
          </template>
          <template x-if="!visibleImages[0]">
            <div class="imgm__slot-empty"></div>
          </template>
          <div style="position:absolute;inset:0;pointer-events:none;
                      background:linear-gradient(to top,rgba(0,0,0,.42) 0%,transparent 52%);"></div>
          <template x-if="visibleImages[0]">
            <div style="position:absolute;bottom:9px;left:9px;">
              <span class="imgm__badge">
                <svg width="9" height="9" fill="currentColor" viewBox="0 0 20 20">
                  <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
                Thumbnail
              </span>
            </div>
          </template>
        </div>

        {{-- 3 foto kecil --}}
        <div style="display:grid;grid-template-rows:1fr 1fr 1fr;gap:2px;">
          <template x-for="idx in [1,2,3]" :key="idx">
            <div class="imgm__slot">
              <template x-if="visibleImages[idx]">
                <img :src="visibleImages[idx].url"
                     style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;"/>
              </template>
              <template x-if="!visibleImages[idx]">
                <div class="imgm__slot-empty"></div>
              </template>
              <template x-if="idx===3 && visibleImages.length > 4">
                <div style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;
                            background:rgba(0,0,0,.65);backdrop-filter:blur(4px);">
                  <span style="color:#fff;font-size:11px;font-weight:700;"
                        x-text="'+' + (visibleImages.length-4)"></span>
                </div>
              </template>
            </div>
          </template>
        </div>
      </div>

      {{-- ── 2×2 ── --}}
      <div class="imgm__pv"
           :class="gridMode !== '2col' && 'imgm__pv--hidden'"
           style="grid-template-columns:1fr 1fr;gap:2px;background:var(--b1);">
        <template x-for="(img,i) in visibleImages.slice(0,4)" :key="img.id">
          <div class="imgm__slot">
            <img :src="img.url"
                 style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;"/>
            <template x-if="i===0">
              <div style="position:absolute;bottom:7px;left:7px;">
                <span class="imgm__badge">
                  <svg width="9" height="9" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                  </svg>
                  Thumbnail
                </span>
              </div>
            </template>
            <template x-if="i===3 && visibleImages.length > 4">
              <div style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;
                          background:rgba(0,0,0,.65);backdrop-filter:blur(4px);">
                <span style="color:#fff;font-weight:700;"
                      x-text="'+' + (visibleImages.length-4)"></span>
              </div>
            </template>
          </div>
        </template>
        <template x-for="i in Math.max(0, 4-visibleImages.slice(0,4).length)" :key="'e'+i">
          <div class="imgm__slot"><div class="imgm__slot-empty"></div></div>
        </template>
      </div>

      {{-- ── 3×2 ── --}}
      <div class="imgm__pv"
           :class="gridMode !== '3col' && 'imgm__pv--hidden'"
           style="grid-template-columns:1fr 1fr 1fr;gap:2px;background:var(--b1);">
        <template x-for="(img,i) in visibleImages.slice(0,6)" :key="img.id">
          <div class="imgm__slot">
            <img :src="img.url"
                 style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;"/>
            <template x-if="i===0">
              <div style="position:absolute;bottom:6px;left:6px;">
                <span class="imgm__badge">
                  <svg width="9" height="9" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                  </svg>
                  Thumbnail
                </span>
              </div>
            </template>
            <template x-if="i===5 && visibleImages.length > 6">
              <div style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;
                          background:rgba(0,0,0,.65);backdrop-filter:blur(4px);">
                <span style="color:#fff;font-weight:700;"
                      x-text="'+' + (visibleImages.length-6)"></span>
              </div>
            </template>
          </div>
        </template>
        <template x-for="i in Math.max(0, 6-visibleImages.slice(0,6).length)" :key="'e'+i">
          <div class="imgm__slot"><div class="imgm__slot-empty"></div></div>
        </template>
      </div>

    </div>{{-- /imgm__preview --}}
  </div>

  {{-- ── SEPARATOR ── --}}
  <div class="imgm__sep"></div>

  {{-- ── PHOTO GRID ── --}}
  <div style="padding:15px 18px 22px;">

    <div class="imgm__grid-hdr">
      <div class="imgm__grid-lbl">
        <span class="imgm__grid-lbl-txt">Urutan Foto</span>
        <span class="imgm__grid-pill">drag &amp; drop</span>
      </div>
      <div class="imgm__grid-hint">
        <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M7 16V4m0 0L3 8m4-4l4 4M17 8v12m0 0l4-4m-4 4l-4-4"/>
        </svg>
        reorder
      </div>
    </div>

    <div class="grid"
            style="
            display:grid;
            grid-template-columns:repeat(auto-fill,minmax(160px,1fr));
            gap:8px;
            "
            x-ref="grid">

      <template x-for="(img, index) in images" :key="img.id">
        <div :data-id="img.id"
             class="imgm__card"
             :style="img.is_primary
               ? 'box-shadow:var(--sh-primary)'
               : img.is_visible
                 ? 'box-shadow:var(--sh-card)'
                 : 'box-shadow:var(--sh-hidden)'">

          {{-- aspect-ratio:4/3 — otomatis punya tinggi, tidak perlu padding-top trick --}}
          <div class="imgm__card-img-wrap">

            <img :src="img.url" draggable="false"
                 style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;transition:filter .2s;"
                 :style="!img.is_visible ? 'filter:saturate(0) brightness(.45)' : ''"/>

            <div style="position:absolute;inset:0;pointer-events:none;
                        background:radial-gradient(ellipse at center,transparent 46%,var(--vignette) 100%);"></div>

            {{-- Top badges --}}
            <div style="position:absolute;top:0;left:0;right:0;
                        display:flex;align-items:flex-start;justify-content:space-between;padding:7px;">
              <div class="imgm__chip" x-text="index+1"></div>
              <template x-if="img.is_primary">
                <div class="imgm__chip imgm__chip--star">
                  <svg width="10" height="10" fill="#78350f" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                  </svg>
                </div>
              </template>
              <template x-if="!img.is_primary && !img.is_visible">
                <div class="imgm__chip imgm__chip--eye">
                  <svg width="10" height="10" fill="none" stroke="#fff" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M3 3l18 18"/>
                  </svg>
                </div>
              </template>
            </div>

            {{-- Action bar --}}
            <div class="imgm__bar">
              <div class="imgm__bar-inner">
                <button type="button"
                  class="imgm__abtn-text"
                  :class="img.is_primary && 'imgm__abtn-text--on'"
                  :disabled="img.is_primary"
                  @click.prevent="setPrimary(img.id)">
                  <svg width="9" height="9" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                  </svg>
                  <span x-text="img.is_primary ? 'Thumbnail' : 'Set'"></span>
                </button>
                <div style="display:flex;gap:4px;">
                  <button type="button"
                    class="imgm__abtn-icon"
                    :class="img.is_visible ? 'imgm__abtn-icon--vis' : 'imgm__abtn-icon--hid'"
                    @click.prevent="toggleVisibility(img.id)">
                    <template x-if="img.is_visible">
                      <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M2.458 12C3.732 7.943 7.522 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.478 0-8.268-2.943-9.542-7z"/>
                      </svg>
                    </template>
                    <template x-if="!img.is_visible">
                      <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M3 3l18 18"/>
                      </svg>
                    </template>
                  </button>
                  <button type="button"
                    class="imgm__abtn-icon imgm__abtn-icon--del"
                    @click.prevent="confirmDeleteId = img.id">
                    <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                  </button>
                </div>
              </div>
            </div>

          </div>{{-- /imgm__card-img-wrap --}}
        </div>
      </template>
    </div>

    {{-- Empty state --}}
    <template x-if="images.length === 0">
      <div class="imgm__empty">
        <div class="imgm__empty-icon">
          <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
          </svg>
        </div>
        <p class="imgm__empty-t">Belum ada foto tersimpan</p>
        <p class="imgm__empty-s">Upload foto di bagian atas terlebih dahulu</p>
      </div>
    </template>

  </div>

</div>{{-- /panel --}}
</div>{{-- /imgm --}}

{{-- ══ MODAL HAPUS ══ --}}
<div x-show="confirmDeleteId !== null" x-cloak
     x-transition:enter="transition ease-out duration-200"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-150"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="imgm imgm__overlay"
     @click.self="confirmDeleteId = null">
  <div class="imgm__modal imgm__pop">
    <div class="imgm__modal-icon">
      <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round"
              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
      </svg>
    </div>
    <p class="imgm__modal-title">Hapus foto ini?</p>
    <p class="imgm__modal-desc">File akan dihapus permanen dari server.<br>Tindakan ini tidak dapat dibatalkan.</p>
    <div class="imgm__modal-row">
      <button class="imgm__mbtn imgm__mbtn--cancel" @click="confirmDeleteId = null">Batal</button>
      <button class="imgm__mbtn imgm__mbtn--del" @click="doDelete()">Hapus Permanen</button>
    </div>
  </div>
</div>

</div>{{-- /x-data --}}

<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.3/Sortable.min.js"></script>
<script>
function imageManager(initialImages, initialMode) {
    return {
        images: initialImages,
        gridMode: initialMode,
        confirmDeleteId: null,
        sortable: null,

        get visibleImages() {
            return this.images.filter(i => i.is_visible);
        },

        init() {
            this.$nextTick(() => {
                this.sortable = Sortable.create(this.$refs.grid, {
                    animation: 160,
                    ghostClass:  'sortable-ghost',
                    chosenClass: 'sortable-chosen',
                    onEnd: ({ newIndex, oldIndex }) => {
                        if (newIndex === oldIndex) return;
                        const moved = this.images.splice(oldIndex, 1)[0];
                        this.images.splice(newIndex, 0, moved);
                        this.$wire.reorder(this.images.map(i => i.id));
                    },
                });
            });
        },

        syncFromLivewire(newImages, newMode) {
            this.images   = newImages;
            this.gridMode = newMode;
        },

        setPrimary(id) {
            this.images = this.images.map(i => ({ ...i, is_primary: i.id === id }));
            this.$wire.setPrimary(id);
        },

        toggleVisibility(id) {
            const img = this.images.find(i => i.id === id);
            if (!img) return;
            if (img.is_visible && this.visibleImages.length <= 1) return;
            img.is_visible = !img.is_visible;
            if (!img.is_visible && img.is_primary) {
                const next = this.images.find(i => i.is_visible);
                if (next) this.images = this.images.map(i => ({ ...i, is_primary: i.id === next.id }));
            }
            this.$wire.toggleVisibility(id);
        },

        doDelete() {
            const id  = this.confirmDeleteId;
            const img = this.images.find(i => i.id === id);
            const wasPrimary = img?.is_primary;
            this.images = this.images.filter(i => i.id !== id);
            if (wasPrimary && this.images.length > 0) {
                const next = this.images.find(i => i.is_visible) || this.images[0];
                if (next) next.is_primary = true;
            }
            this.confirmDeleteId = null;
            this.$wire.set('confirmDeleteId', id);
            this.$wire.deleteConfirmed();
        },
    };
}
</script>