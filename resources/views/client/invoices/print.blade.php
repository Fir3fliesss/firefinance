<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice {{ $invoice->invoice_number }} — FireFinance</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Arial, sans-serif; font-size: 13px; color: #1e293b; background: #fff; }
        .page { max-width: 800px; margin: 0 auto; padding: 40px; }
        .header { display: flex; justify-content: space-between; align-items: flex-start; padding-bottom: 24px; border-bottom: 2px solid #10b981; margin-bottom: 32px; }
        .brand { display: flex; flex-direction: column; }
        .brand-name { font-size: 22px; font-weight: 800; color: #0f172a; }
        .brand-name span { color: #10b981; }
        .brand-sub { font-size: 11px; color: #64748b; margin-top: 4px; }
        .invoice-meta { text-align: right; }
        .invoice-label { font-size: 10px; text-transform: uppercase; letter-spacing: 1.5px; color: #94a3b8; }
        .invoice-number { font-size: 18px; font-weight: 700; color: #f59e0b; font-family: monospace; margin-top: 4px; }
        .status-badge { display: inline-block; padding: 3px 10px; border-radius: 9999px; font-size: 10px; font-weight: 600; margin-top: 6px; }
        .status-unpaid { background: #fef3c7; color: #92400e; }
        .status-paid { background: #d1fae5; color: #065f46; }
        .status-cancelled { background: #fee2e2; color: #991b1b; }
        .section { display: grid; grid-template-columns: 1fr 1fr; gap: 32px; margin-bottom: 32px; }
        .section-label { font-size: 10px; text-transform: uppercase; letter-spacing: 1px; color: #94a3b8; margin-bottom: 8px; }
        .section-value { font-weight: 600; color: #0f172a; }
        .section-sub { color: #64748b; margin-top: 2px; }
        .table { width: 100%; border-collapse: collapse; margin-bottom: 24px; }
        .table th { text-align: left; padding: 10px 12px; background: #f1f5f9; font-size: 10px; text-transform: uppercase; letter-spacing: 1px; color: #64748b; font-weight: 600; }
        .table th:last-child { text-align: right; }
        .table td { padding: 14px 12px; border-bottom: 1px solid #e2e8f0; color: #1e293b; }
        .table td:last-child { text-align: right; font-weight: 600; }
        .table .service-name { font-weight: 600; color: #0f172a; }
        .table .service-cat { font-size: 11px; color: #94a3b8; margin-top: 2px; }
        .total-row { background: #f8fafc; }
        .total-row td { padding: 16px 12px; font-size: 15px; font-weight: 800; color: #10b981; border-top: 2px solid #10b981; }
        .footer { margin-top: 40px; padding-top: 20px; border-top: 1px solid #e2e8f0; text-align: center; color: #94a3b8; font-size: 11px; }
        .watermark { text-align: center; padding: 16px; background: #f0fdf4; border: 1px dashed #10b981; border-radius: 8px; color: #059669; font-size: 11px; font-weight: 600; letter-spacing: 1px; margin-bottom: 24px; }
        @media print {
            body { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>
    <div class="page">
        <div class="no-print" style="background:#1e293b;color:#94a3b8;text-align:center;padding:10px;font-size:12px;border-radius:6px;margin-bottom:20px;">
            ℹ️ Gunakan Ctrl+P / Cmd+P untuk mencetak atau simpan sebagai PDF
            <button onclick="window.print()" style="margin-left:12px;padding:4px 12px;background:#10b981;color:#fff;border:none;border-radius:4px;cursor:pointer;font-size:12px;">🖨️ Print Sekarang</button>
        </div>

        <div class="header">
            <div class="brand">
                <div class="brand-name">Fire<span>Finance</span></div>
                <div class="brand-sub">Platform Jasa Keuangan Premium</div>
                <div class="brand-sub">+62 812 3456 7890 | admin@firefinance.id</div>
            </div>
            <div class="invoice-meta">
                <div class="invoice-label">INVOICE</div>
                <div class="invoice-number">{{ $invoice->invoice_number }}</div>
                <div class="invoice-label" style="margin-top:8px;">Terkait Order</div>
                <div style="font-weight:700;color:#0f172a;font-family:monospace;">{{ $invoice->order->order_number }}</div>
                <span class="status-badge status-{{ $invoice->status }}">{{ $invoice->status_label }}</span>
            </div>
        </div>

        <div class="watermark">✓ VERIFIED ACCOUNTABILITY — INVOICE RESMI FIREFINANCE</div>

        <div class="section">
            <div>
                <div class="section-label">Ditagihkan kepada</div>
                <div class="section-value">{{ $invoice->order->user->name }}</div>
                <div class="section-sub">{{ $invoice->order->user->email }}</div>
                @if($invoice->order->user->phone)
                <div class="section-sub">{{ $invoice->order->user->phone }}</div>
                @endif
            </div>
            <div style="text-align:right;">
                <div class="section-label">Tanggal Invoice</div>
                <div class="section-value">{{ $invoice->issue_date->format('d M Y') }}</div>
                @if($invoice->due_date)
                <div class="section-label" style="margin-top:12px;">Jatuh Tempo</div>
                <div class="section-value">{{ $invoice->due_date->format('d M Y') }}</div>
                @endif
            </div>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>Layanan</th>
                    <th style="text-align:right;">Harga</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoice->order->items as $item)
                <tr>
                    <td>
                        <div class="service-name">{{ $item->service->title }}</div>
                        <div class="service-cat">{{ $item->service->category->name }}</div>
                    </td>
                    <td>Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="total-row">
                    <td>TOTAL</td>
                    <td style="color:#10b981;">{{ $invoice->order->formatted_total }}</td>
                </tr>
            </tfoot>
        </table>

        @if(isset($dynamicQris) && $dynamicQris)
        <div style="margin-bottom:24px; display: flex; align-items: center; gap: 24px; padding: 20px; border: 1px solid #e2e8f0; border-radius: 12px; background: #fafafa;">
            <div style="background: #fff; padding: 8px; border-radius: 8px; border: 1px solid #e2e8f0;">
                {!! QrCode::size(120)->generate($dynamicQris) !!}
            </div>
            <div>
                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px;">
                    <img src="{{ asset('qris.jpeg') }}" alt="QRIS" style="height: 16px; border: 1px solid #000;">
                    <span style="font-size: 12px; font-weight: 800; text-transform: uppercase; color: #0f172a;">Pembayaran QRIS</span>
                </div>
                <p style="font-size: 11px; color: #64748b; margin-bottom: 12px; max-width: 300px;">Silakan scan kode QR di atas untuk melakukan pembayaran langsung dari aplikasi perbankan atau e-wallet Anda.</p>
                <div style="display: inline-block; padding: 4px 10px; background: #f1f5f9; border-radius: 6px; font-size: 10px; color: #475569; font-weight: 700;">
                    MERCHANT: VIRTUAL OASIS CREATIONS
                </div>
            </div>
        </div>
        @endif

        @if($invoice->order->notes)
        <div style="margin-bottom:24px;padding:12px 16px;background:#f8fafc;border-radius:6px;border-left:3px solid #10b981;">
            <div class="section-label">Catatan</div>
            <div style="color:#475569;margin-top:4px;">{{ $invoice->order->notes }}</div>
        </div>
        @endif

        <div class="footer">
            <p>Terima kasih telah menggunakan layanan FireFinance.</p>
            <p style="margin-top:4px;">Invoice ini dibuat secara digital dan sah tanpa tanda tangan fisik.</p>
            <p style="margin-top:4px;">© {{ date('Y') }} FireFinance — firefinance.id</p>
        </div>
    </div>
</body>
</html>
