@props(['status'])

@php
    $colors = [
        'tertunda' => 'bg-yellow-100 text-yellow-800',
        'diproses' => 'bg-blue-100 text-blue-800',
        'selesai' => 'bg-green-100 text-green-800',
        'dibatalkan' => 'bg-red-100 text-red-800',
    ];
    $colorClass = $colors[$status] ?? 'bg-gray-100 text-gray-800';
@endphp

<span class="px-2 py-1 text-xs rounded-full font-semibold {{ $colorClass }}">
    {{ ucfirst($status) }}
</span>