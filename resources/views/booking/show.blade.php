@extends('layouts.app')

@section('title', 'Invoice Pemesanan')

@section('css')
    <style>
        .invoice-container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .invoice-hero {
            padding: 40px 20px;
            margin-bottom: 30px;
            border-radius: 12px;
        }

        .invoice-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 3px solid #f1c40f;
            padding-bottom: 30px;
            margin-bottom: 40px;
        }

        .invoice-logo {
            font-size: 2.5rem;
            font-weight: 900;
            color: #1e3a5f;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .invoice-number {
            text-align: right;
        }

        .invoice-number-label {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 5px;
        }

        .invoice-number-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1e3a5f;
        }

        .invoice-status-badge {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.85rem;
            margin-top: 10px;
        }

        .status-pending {
            background: #fff3cd;
            color: #856404;
        }

        .status-paid {
            background: #d4edda;
            color: #155724;
        }

        .status-confirmed {
            background: #cce5ff;
            color: #004085;
        }

        .status-completed {
            background: #d1ecf1;
            color: #0c5460;
        }

        .status-cancelled {
            background: #f8d7da;
            color: #721c24;
        }

        .invoice-section {
            margin-bottom: 35px;
        }

        .invoice-section-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: #1e3a5f;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #f1c40f;
        }

        .invoice-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 30px;
        }

        .invoice-item {
            display: flex;
            flex-direction: column;
        }

        .invoice-item-label {
            font-size: 0.85rem;
            color: #666;
            margin-bottom: 5px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .invoice-item-value {
            font-size: 1rem;
            color: #333;
            font-weight: 500;
        }

        .invoice-homestay {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        /* image block: show on screen (small), hidden in print via print rules */
        .invoice-image {
            display: block;
            max-width: 220px;
            margin: 0 auto 14px;
        }

        .invoice-image img {
            width: 100%;
            height: auto;
            border-radius: 8px;
        }

        .invoice-homestay-name {
            font-size: 1.2rem;
            font-weight: 700;
            color: #1e3a5f;
            margin-bottom: 8px;
        }

        .invoice-homestay-location {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 15px;
        }

        .invoice-homestay-detail {
            display: flex;
            justify-content: space-between;
            font-size: 0.9rem;
            color: #555;
            margin: 8px 0;
        }

        .payment-table {
            width: 100%;
            color: #1e3a5f;
            border-collapse: collapse;
        }

        .btn-secondary-invoice:hover {
            background: #e8b900;
        }

        .btn-ghost-invoice {
            background: transparent;
            color: #666;
            border: 1px solid #ddd;
        }

        .btn-ghost-invoice:hover {
            background: #f8f9fa;
        }

        @media print {

            /* Single-column A4 layout for PDF/print */
            /* tighten top spacing and margins to avoid blank area on printed PDF */
            @page {
                size: A4 portrait;
                margin: 6mm;
            }

            html,
            body {
                background: white !important;
                height: auto !important;
                -webkit-print-color-adjust: exact !important;
                color-adjust: exact !important;
                font-family: Arial, Helvetica, sans-serif;
                font-size: 12px;
                margin: 0 !important;
                padding: 0 !important;
            }

            /* Neutralize hero background for print */
            .invoice-hero {
                background: transparent !important;
                padding: 0 !important;
                margin: 0 !important;
                border-radius: 0 !important;
            }

            /* Force single, centered column sized for A4 printable area */
            .invoice-container {
                box-shadow: none !important;
                background: white !important;
                width: 170mm !important;
                /* A4 width minus margins */
                max-width: 170mm !important;
                margin: 0 auto !important;
                padding: 6mm 12mm !important;
                /* reduce top padding */
                display: block !important;
                margin-top: 0 !important;
            }

            /* Large centered logo/header for clarity */
            .invoice-header {
                display: block !important;
                text-align: center !important;
                border-bottom: none !important;
                padding-bottom: 6px !important;
                margin: 0 0 6px 0 !important;
            }

            .invoice-logo {
                font-size: 2.4rem !important;
                font-weight: 900 !important;
                color: #1e3a5f !important;
                justify-content: center !important;
            }

            .invoice-logo i {
                font-size: 2.6rem !important;
            }

            /* Compact the sections so they fit on one A4 page */
            .invoice-grid {
                grid-template-columns: 1fr !important;
                gap: 8px !important;
            }

            .invoice-section {
                margin-bottom: 8px !important;
            }

            .invoice-homestay {
                background: transparent !important;
                padding: 6px 0 !important;
                margin-bottom: 6px !important;
            }

            .invoice-item-label {
                font-size: 0.78rem !important;
            }

            .invoice-item-value {
                font-size: 0.95rem !important;
            }

            .payment-table td {
                padding: 6px 0 !important;
            }

            .payment-table .total-row .label,
            .payment-table .total-row .amount {
                font-size: 1rem !important;
                font-weight: 800 !important;
            }

            /* Hide interactive elements in print; keep footer visible */
            .invoice-actions,
            .btn,
            a.btn-ghost-invoice {
                display: none !important;
            }

            .no-print {
                display: none !important;
            }

            /* Hide the large homestay image to save vertical space for single-page fit */
            .invoice-image {
                display: none !important;
            }

            /* Hide site-wide header/navbar and footer when printing invoice */
            .site-header,
            .header-top,
            .header-inner,
            .navbar,
            #mobileSearchOverlay,
            .footer {
                display: none !important;
            }

            /* Hide owner contact on print to save space and fit one page */
            .invoice-owner-contact {
                display: none !important;
            }

            /* Footer should be concise and centered */
            .invoice-footer {
                display: block !important;
                text-align: center !important;
                margin-top: 12px !important;
                padding-top: 8px !important;
                border-top: 1px solid #eee !important;
                color: #666 !important;
                font-size: 11px !important;
            }

            /* Ensure colors and key text print correctly */
            .invoice-section-title {
                color: #000 !important;
            }

            .invoice-number-value {
                color: #000 !important;
            }

            /* Prevent page breaks inside important blocks */
            .invoice-homestay,
            .invoice-section,
            .payment-table {
                page-break-inside: avoid;
            }
        }

        @media (max-width: 768px) {
            .invoice-container {
                padding: 20px;
            }

            .invoice-header {
                flex-direction: column;
                text-align: center;
            }

            .invoice-grid {
                grid-template-columns: 1fr;
            }

            .invoice-logo {
                justify-content: center;
                margin-bottom: 20px;
            }

            .invoice-number {
                text-align: center;
                margin-top: 20px;
            }

            .invoice-footer {
                flex-direction: column;
                gap: 20px;
            }
        }
    </style>
@endsection

@section('content')
    <div class="invoice-hero">
        <div class="invoice-container">
            {{-- left column image for print view --}}
            <!-- Header Invoice -->
            <div class="invoice-header">
                <div class="invoice-logo">
                    <i class="fas fa-home"></i>
                    <span>AdaKamar</span>
                </div>
                <div class="invoice-number">
                    <div class="invoice-number-label">Nomor Invoice</div>
                    <div class="invoice-number-value">#INV-{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</div>
                    <span class="invoice-status-badge status-{{ $booking->status }}">
                        {{ ucfirst($booking->status) === 'Paid' ? 'Lunas' : (ucfirst($booking->status) === 'Pending' ? 'Menunggu Pembayaran' : (ucfirst($booking->status) === 'Confirmed' ? 'Dikonfirmasi' : (ucfirst($booking->status) === 'Completed' ? 'Selesai' : 'Dibatalkan'))) }}
                    </span>
                </div>
            </div>

            <div class="invoice-body">

                <!-- Informasi Kamar -->
                <div class="invoice-section">
                    <div class="invoice-section-title">📍 Informasi Kamar</div>
                    <div class="invoice-homestay">
                        <div class="invoice-homestay-name">{{ $booking->homestay->name }}</div>
                        <div class="invoice-homestay-location">📌 {{ $booking->homestay->location }}</div>
                        <div class="invoice-homestay-detail">
                            <span><strong>Check-in:</strong>
                                {{ optional($booking->check_in_date)->format('d M Y') ?? '—' }}</span>
                            <span><strong>Check-out:</strong>
                                {{ optional($booking->check_out_date)->format('d M Y') ?? '—' }}</span>
                        </div>
                        <div class="invoice-homestay-detail">
                            <span><strong>Jumlah Tamu:</strong> {{ $booking->total_guests }} orang</span>
                            <span><strong>Tanggal Pemesanan:</strong> {{ $booking->created_at->format('d M Y') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Data Diri Pemesan -->
                <div class="invoice-section">
                    <div class="invoice-section-title">👤 Data Diri Pemesan</div>
                    <div class="invoice-grid">
                        <div class="invoice-item">
                            <span class="invoice-item-label">Nama Lengkap</span>
                            <span class="invoice-item-value">{{ $booking->nama ?? '—' }}</span>
                        </div>
                        <div class="invoice-item">
                            <span class="invoice-item-label">Email</span>
                            <span class="invoice-item-value">{{ $booking->email ?? '—' }}</span>
                        </div>
                        <div class="invoice-item">
                            <span class="invoice-item-label">Nomor HP</span>
                            <span class="invoice-item-value">{{ $booking->nomor_hp ?? '—' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Rincian Pembayaran -->
                <div class="invoice-section">
                    <div class="invoice-section-title">💰 Rincian Pembayaran</div>
                    <table class="payment-table">
                        <tr>
                            <td class="label">Subtotal Pemesanan</td>
                            <td class="amount">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td class="label">Diskon / Promo</td>
                            <td class="amount">Rp 0</td>
                        </tr>
                        <tr>
                            <td class="label">Biaya Admin</td>
                            <td class="amount">Rp 0</td>
                        </tr>
                        <tr>
                            <td class="label">Pajak (PPN 10%)</td>
                            <td class="amount">Rp 0</td>
                        </tr>
                        <tr class="total-row">
                            <td class="label">Total Yang Harus Dibayar</td>
                            <td class="amount">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                        </tr>
                    </table>
                </div>

                <!-- Kontak Pemilik -->
                @if($booking->homestay->owner)
                    <div class="invoice-section invoice-owner-contact">
                        <div class="invoice-section-title">👨‍💼 Kontak Pemilik Kamar</div>
                        <div class="invoice-grid">
                            <div class="invoice-item">
                                <span class="invoice-item-label">Nama Pemilik</span>
                                <span class="invoice-item-value">{{ $booking->homestay->owner->name }}</span>
                            </div>
                            <div class="invoice-item">
                                <span class="invoice-item-label">Kontak</span>
                                <span class="invoice-item-value">
                                    {{ $booking->homestay->owner->phone ?? $booking->homestay->owner->email }}
                                </span>
                            </div>
                        </div>
                    </div>
                @endif

            </div>

            <!-- Footer dengan Aksi -->
            <div class="invoice-footer">
                <div>
                    <p style="margin: 0; color: #999; font-size: 0.9rem;">
                        <i class="fas fa-info-circle"></i> Invoice ini dibuat secara otomatis oleh sistem AdaKamar
                    </p>
                </div>
                <div style="text-align: right; color: #999; font-size: 0.9rem;">
                    <div class="invoice-actions no-print">
                        @if(auth()->id() === $booking->user_id && $booking->status === 'pending')
                            <a href="{{ route('booking.pay.form', $booking->slug) }}" class="btn btn-primary-invoice">
                                <i class="fas fa-credit-card"></i> Bayar Sekarang
                            </a>
                        @endif
                        <button onclick="window.print()" class="btn btn-secondary-invoice">
                            <i class="fas fa-print"></i> Cetak
                        </button>
                        <a href="{{ route('home') }}" class="btn btn-ghost-invoice">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                    <div class="copyright">
                        &copy; {{ date('Y') }} AdaKamar. Semua hak cipta dilindungi.
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection