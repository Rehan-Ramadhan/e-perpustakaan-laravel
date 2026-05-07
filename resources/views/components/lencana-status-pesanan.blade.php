@props(['status'])

@php
    $dbStatus = trim($status);

    $statusMap = [
        'tertunda' => ['bg' => '#ffc107', 'text' => '#000', 'label' => 'Tertunda'],
        'diproses' => ['bg' => '#0dcaf0', 'text' => '#fff', 'label' => 'Diproses'],
        'selesai' => ['bg' => '#198754', 'text' => '#fff', 'label' => 'Selesai'],
        'dibatalkan' => ['bg' => '#6c757d', 'text' => '#fff', 'label' => 'Batal'],
        'ditolak' => ['bg' => '#dc3545', 'text' => '#fff', 'label' => 'Ditolak'],
    ];

    $current = $statusMap[$dbStatus] ?? [
        'bg' => '#6c757d',
        'text' => '#fff',
        'label' => ucfirst($dbStatus)
    ];
@endphp

<span {{ $attributes->merge(['class' => 'badge px-2 py-1 rounded-pill shadow-sm']) }}
    style="background-color: {{ $current['bg'] }} !important; color: {{ $current['text'] }} !important; opacity: 1 !important; font-size: 0.75rem;">
    {{ $current['label'] }}
</span>