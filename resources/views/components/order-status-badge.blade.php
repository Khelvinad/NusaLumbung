@props(['status' => 'Tersedia'])

@php
$config = match($status) {
    'Tersedia'  => ['bg' => 'bg-[#F9FBF9]', 'text' => 'text-[#7FB069]', 'border' => 'border-[#7FB069]'],
    'Habis'     => ['bg' => 'bg-red-50', 'text' => 'text-[#D32F2F]', 'border' => 'border-[#D32F2F]'],
    'Pending'   => ['bg' => 'bg-yellow-50', 'text' => 'text-yellow-600', 'border' => 'border-yellow-400'],
    'Proses'    => ['bg' => 'bg-blue-50', 'text' => 'text-blue-600', 'border' => 'border-blue-400'],
    'Dikirim'   => ['bg' => 'bg-purple-50', 'text' => 'text-purple-600', 'border' => 'border-purple-400'],
    'Selesai'   => ['bg' => 'bg-green-50', 'text' => 'text-[#2D5A27]', 'border' => 'border-[#2D5A27]'],
    'Dibatalkan'=> ['bg' => 'bg-gray-50', 'text' => 'text-gray-500', 'border' => 'border-gray-300'],
    default     => ['bg' => 'bg-[#F9FBF9]', 'text' => 'text-[#7FB069]', 'border' => 'border-[#7FB069]'],
};
@endphp

<span class="text-xs {{ $config['bg'] }} {{ $config['text'] }} border {{ $config['border'] }} px-2 py-1 rounded-full">
    {{ $status }}
</span>