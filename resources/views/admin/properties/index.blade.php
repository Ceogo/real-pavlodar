@extends('admin.layout')
@section('title', 'Объекты')
@section('content')
    <h2 class="text-xl font-bold mb-4">Объекты</h2>
    @if(auth()->user()->role === 'administrator')
        <a href="{{ url('/admin/properties/create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">Добавить объект</a>
    @endif
    <table class="min-w-full bg-white shadow-md rounded">
        <thead>
            <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                <th class="py-3 px-6 text-left">ID</th>
                <th class="py-3 px-6 text-left">Адрес</th>
                <th class="py-3 px-6 text-left">Тип сделки</th>
                <th class="py-3 px-6 text-left">Цена</th>
                <th class="py-3 px-6 text-left">Статус</th>
                <th class="py-3 px-6 text-left">Действия</th>
            </tr>
        </thead>
        <tbody class="text-gray-600 text-sm">
            @foreach($properties as $property)
                <tr class="border-b border-gray-200 hover:bg-gray-100">
                    <td class="py-3 px-6">{{ $property->id }}</td>
                    <td class="py-3 px-6">{{ $property->address }}</td>
                    <td class="py-3 px-6">{{ $property->deal }}</td>
                    <td class="py-3 px-6">{{ number_format($property->price, 0, ',', ' ') }} руб.</td>
                    <td class="py-3 px-6">{{ $property->status }}</td>
                    <td class="py-3 px-6">
                        @if(auth()->user()->role === 'moderator' && $property->status === 'pending')
                            <a href="{{ url('/admin/properties/' . $property->id . '/edit') }}" class="text-blue-500 hover:underline">Редактировать</a>
                            <form action="{{ url('/admin/properties/' . $property->id . '/approve') }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-green-500 hover:underline ml-2">Одобрить</button>
                            </form>
                            <form action="{{ url('/admin/properties/' . $property->id . '/reject') }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-red-500 hover:underline ml-2">Отклонить</button>
                            </form>
                        @elseif(auth()->user()->role === 'administrator')
                            <a href="{{ url('/admin/properties/' . $property->id . '/edit') }}" class="text-blue-500 hover:underline">Редактировать</a>
                            <form action="{{ url('/admin/properties/' . $property->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:underline ml-2">Удалить</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mt-4">
        {{ $properties->links() }}
    </div>
@endsection
