@extends('admin.layout')
@section('title', 'Дашборд')
@section('content')
    @if(auth()->user()->role === 'moderator')
        <h2 class="text-xl font-bold mb-4">Ожидающие проверки объекты</h2>
        @include('admin.properties.index', ['properties' => $pendingProperties])
    @else
        <h2 class="text-xl font-bold mb-4">Статистика</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white p-4 shadow rounded">
                <h3 class="text-lg font-semibold">Всего объектов</h3>
                <p class="text-2xl">{{ $totalProperties }}</p>
            </div>
            <div class="bg-white p-4 shadow rounded">
                <h3 class="text-lg font-semibold">Ожидающих проверки</h3>
                <p class="text-2xl">{{ $pendingPropertiesCount }}</p>
            </div>
            <div class="bg-white p-4 shadow rounded">
                <h3 class="text-lg font-semibold">Всего пользователей</h3>
                <p class="text-2xl">{{ $totalUsers }}</p>
            </div>
            <div class="bg-white p-4 shadow rounded">
                <h3 class="text-lg font-semibold">Заявок покупателей</h3>
                <p class="text-2xl">{{ $totalRequests }}</p>
            </div>
        </div>
    @endif
@endsection
