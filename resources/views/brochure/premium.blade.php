<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Brosur</title>

<style>
@page {
    size: A4 landscape;
    margin: 12mm;
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: DejaVu Sans, sans-serif;
    background: #0d4280;
}

/* ================= WRAPPER ================= */

.page {
    width: 100%;
    height: 180mm;
    background: #ffffff;
    padding: 8mm;
}

.page-strip {
    width: 100%;
    height: 100%;
    background: #0d4280;
    border-right: 8mm solid #f57c00;
}

table.main-layout {
    width: 100%;
    height: 100%;
    border-collapse: collapse;
    table-layout: fixed;
}

/* ================= FOTO ================= */

td.col-photo {
    width: 60%;
    vertical-align: top;
}

table.g-main3,
table.g-2col,
table.g-3col {
    width: 100%;
    height: 100%;
    border-collapse: collapse;
    table-layout: fixed;
}

td.g-big {
    width: 65%;
    vertical-align: top;
    overflow: hidden;
}

td.g-big img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

td.g-smalls {
    width: 35%;
    vertical-align: top;
}

.g-small-slot {
    height: 33.33%;
    overflow: hidden;
    background: #1a3a5c;
}

.g-small-slot img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

.g2-slot,
.g3-slot {
    overflow: hidden;
    background: #1a3a5c;
}

.g2-slot img,
.g3-slot img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

.g2-gap-h, .g3-gap-h { width: 4px; }
.g2-gap-v, .g3-gap-v { height: 4px; }

.slot-empty {
    width: 100%;
    height: 100%;
    background: #1a3a5c;
}

/* ================= INFO PANEL ================= */

td.col-info {
    height: 100%;
    vertical-align: top;
}

.info-panel {
    background: #ffffff;
    border-radius: 12px;
    padding: 14px;
    height: 100%;
}

/* Header */

table.hdr {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 10px;
}

.hdr-logo {
    font-size: 18px;
    font-weight: bold;
    color: #0d4280;
}

.hdr-logo-dot { color: #f57c00; }

.hdr-bank {
    font-size: 10px;
    font-weight: bold;
    color: #003087;
    background: #e8f0fe;
    padding: 4px 8px;
    border-radius: 4px;
    border: 1px solid #003087;
    text-align: right;
    white-space: nowrap;
}

/* Title */

.title-bar {
    background: #1565c0;
    color: #fff;
    padding: 8px 10px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: bold;
    margin-bottom: 8px;
}

/* Location */

.loc-row {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 8px;
}

.loc-dot {
    width: 10px;
    height: 10px;
    background: #e53935;
    border-radius: 50%;
    display: inline-block;
}

.loc-text {
    font-size: 10px;
    color: #e53935;
    font-weight: bold;
}

/* Facility */

.fac-box {
    background: #e8f0fb;
    border-radius: 6px;
    padding: 8px;
    margin-bottom: 8px;
}

.fac-title {
    font-size: 8px;
    font-weight: bold;
    margin-bottom: 4px;
}

.fac-item {
    font-size: 10px;
    line-height: 1.6;
}

/* Jadwal */

.jadwal {
    font-size: 9px;
    margin-bottom: 8px;
}

.jadwal-val {
    font-weight: bold;
    color: #1565c0;
}

/* WhatsApp */

.wa-row {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 8px;
}

.wa-circle {
    width: 32px;
    height: 32px;
    background: #25d366;
    border-radius: 50%;
    text-align: center;
}

.wa-circle img {
    margin-top: 6px;
}

.wa-num {
    font-size: 14px;
    font-weight: bold;
    color: #1565c0;
}

.wa-name {
    font-size: 9px;
    color: #555;
}

/* QR */

.qr-row {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 8px;
}

.qr-lbl {
    background: #1565c0;
    color: #fff;
    font-size: 7px;
    font-weight: bold;
    text-align: center;
    padding: 2px;
    border-radius: 3px;
    margin-bottom: 3px;
}

.qr-box {
    width: 80px;
    height: 80px;
    border: 2px solid #1565c0;
}

.qr-box img {
    width: 100%;
    height: 100%;
}

/* CTA */

.cta-title {
    font-size: 15px;
    font-weight: bold;
    color: #1565c0;
    margin-bottom: 6px;
}

.cta-btn {
    background: #e53935;
    color: #fff;
    font-size: 10px;
    font-weight: bold;
    padding: 6px 14px;
    border-radius: 20px;
    display: inline-block;
}

/* Price */

.price-bar {
    background: #0d4280;
    color: #fff;
    text-align: center;
    padding: 10px;
    border-radius: 6px;
    font-size: 16px;
    font-weight: bold;
    margin-bottom: 6px;
}

/* Footer */

.footer-txt {
    font-size: 8px;
    color: #777;
    border-top: 1px solid #eee;
    padding-top: 6px;
}
</style>
</head>
<body>

<div class="page">
<div class="page-strip">

<table class="main-layout">
<tr>

<td class="col-photo">

    @if($catalog['grid_mode'] === 'main+3')
    <table class="g-main3">
        <tr>
            <td class="g-big">
                @php $p=$sp(0); @endphp
                @if($p)
                    <img src="{{ $p }}">
                @else
                    <div class="slot-empty"></div>
                @endif
            </td>
            <td class="g-smalls">
                @for($i=1;$i<=3;$i++)
                    @php $p=$sp($i); @endphp
                    <div class="g-small-slot" style="position:relative;">
                        @if($p)
                            <img src="{{ $p }}">
                        @else
                            <div class="slot-empty"></div>
                        @endif

                        @if($i===3 && $total>4)
                        <div style="position:absolute;top:0;left:0;width:100%;height:100%;
                             background:rgba(0,0,0,.55);color:#fff;
                             font-size:18px;font-weight:bold;
                             text-align:center;line-height:190px;">
                            +{{ $total-4 }}
                        </div>
                        @endif
                    </div>
                @endfor
            </td>
        </tr>
    </table>

    @elseif($catalog['grid_mode'] === '2col')
    <table class="g-2col">
        @for($row=0;$row<2;$row++)
        <tr>
            @for($col=0;$col<2;$col++)
                @php $idx=$row*2+$col; $p=$sp($idx); @endphp
                <td class="g2-slot" style="position:relative;">
                    @if($p)
                        <img src="{{ $p }}">
                    @else
                        <div class="slot-empty"></div>
                    @endif

                    @if($idx===3 && $total>4)
                    <div style="position:absolute;top:0;left:0;width:100%;height:100%;
                         background:rgba(0,0,0,.55);color:#fff;
                         font-size:20px;font-weight:bold;
                         text-align:center;line-height:280px;">
                        +{{ $total-4 }}
                    </div>
                    @endif
                </td>
                @if($col<1)<td class="g2-gap-h"></td>@endif
            @endfor
        </tr>
        @if($row<1)<tr><td colspan="3" class="g2-gap-v"></td></tr>@endif
        @endfor
    </table>

    @elseif($catalog['grid_mode'] === '3col')
    <table class="g-3col">
        @for($row=0;$row<2;$row++)
        <tr>
            @for($col=0;$col<3;$col++)
                @php $idx=$row*3+$col; $p=$sp($idx); @endphp
                <td class="g3-slot" style="position:relative;">
                    @if($p)
                        <img src="{{ $p }}">
                    @else
                        <div class="slot-empty"></div>
                    @endif

                    @if($idx===5 && $total>6)
                    <div style="position:absolute;top:0;left:0;width:100%;height:100%;
                         background:rgba(0,0,0,.55);color:#fff;
                         font-size:20px;font-weight:bold;
                         text-align:center;line-height:280px;">
                        +{{ $total-6 }}
                    </div>
                    @endif
                </td>
                @if($col<2)<td class="g3-gap-h"></td>@endif
            @endfor
        </tr>
        @if($row<1)<tr><td colspan="5" class="g3-gap-v"></td></tr>@endif
        @endfor
    </table>

    @else
        @php $p=$sp(0); @endphp
        @if($p)
            <img src="{{ $p }}" style="width:100%;height:100%;object-fit:cover;">
        @else
            <div class="slot-empty"></div>
        @endif
    @endif

</td>



<td class="col-info">
<div class="info-panel">

    {{-- Header --}}
    <table class="hdr">
        <tr>
            <td class="hdr-logo">
                <span class="hdr-logo-dot">&#9679;</span>
                {{ $branding['siteName'] ?? 'Lentera' }}
            </td>
            @if(!empty($branding['bankName']))
            <td class="hdr-bank">
                {{ $branding['bankName'] }}
            </td>
            @endif
        </tr>
    </table>

    {{-- Judul --}}
    <div class="title-bar">
        {{ $catalog['title'] ?? '-' }}
    </div>

    {{-- Lokasi --}}
    <table class="loc-row">
        <tr>
            <td style="width:16px;vertical-align:top;">
                <span class="loc-dot"></span>
            </td>
            <td class="loc-text">
                {{ $catalog['address'] ?? '-' }}
                @if($showCity && !empty($catalog['city']))
                    , {{ $catalog['city'] }}
                @endif
            </td>
        </tr>
    </table>

    {{-- Fasilitas --}}
    @if(count($facilities) > 0)
    <div class="fac-box">
        <div class="fac-title">Akses dan Fasilitas</div>
        @foreach($facilities as $f)
            <div class="fac-item">
                • {{ $f['name'] ?? '' }}
            </div>
        @endforeach
    </div>
    @endif

    {{-- Jadwal --}}
    @if(($showDate && $tanggal !== '-') || ($showTime && $jam))
    <div class="jadwal">
        @if($showDate)
            Batas Akhir Lelang:
            <span class="jadwal-val">{{ $tanggal }}</span>
        @endif

        @if($showTime && $jam)
            &nbsp;&nbsp;Pukul:
            <span class="jadwal-val">{{ $jam }}</span>
        @endif
    </div>
    @endif

    {{-- WhatsApp --}}
    @if($showWa && $wa)
    <table class="wa-row">
        <tr>
            <td style="width:40px;vertical-align:middle;">
                <div class="wa-circle">
                    <img src="{{ $waIcon }}" width="18">
                </div>
            </td>
            <td style="vertical-align:middle;padding-left:8px;">
                <div class="wa-num">{{ $wa }}</div>
                @if($waName)
                    <div class="wa-name">{{ $waName }}</div>
                @endif
            </td>
        </tr>
    </table>
    @endif

    {{-- QR --}}
    @if($showQr && $qrCode)
    <table class="qr-row">
        <tr>
            <td style="width:90px;vertical-align:top;">
                <div class="qr-lbl">SCAN ME</div>
                <div class="qr-box">
                    <img src="{{ $qrCode }}">
                </div>
            </td>
            <td style="vertical-align:middle;padding-left:10px;">
                <div class="cta-title">Cek Sekarang</div>
                <div class="cta-btn">Lelang.go.id ↗</div>
            </td>
        </tr>
    </table>
    @endif

    {{-- Harga --}}
    <div class="price-bar">
        Harga Limit: Rp {{ number_format($catalog['reserve_price'] ?? 0, 0, ',', '.') }}
    </div>

    {{-- Footer --}}
    @if($showFooter && !empty($branding['brochureFooter']))
        <div class="footer-txt">
            {{ $branding['brochureFooter'] }}
        </div>
    @endif

</div>
</td>

</tr>
</table>

</div>
</div>

</body>
</html>