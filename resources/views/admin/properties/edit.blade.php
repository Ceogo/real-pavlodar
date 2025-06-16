@extends('admin.layout')
@section('title', 'Редактировать объект')
@section('content')
    <h2 class="text-xl font-bold mb-4">Редактировать объект</h2>
    <form action="{{ url('/admin/properties/' . $property->id) }}" method="POST" class="bg-white p-6 shadow rounded">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label class="block text-gray-700">Адрес</label>
            <input type="text" name="address" value="{{ $property->address }}" class="w-full p-2 border rounded">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Тип сделки</label>
            <select name="deal" class="w-full p-2 border rounded">
                <option value="rent" {{ $property->deal === 'rent' ? 'selected' : '' }}>Аренда</option>
                <option value="sale" {{ $property->deal === 'sale' ? 'selected' : '' }}>Продажа</option>
            </select>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Цена</label>
            <input type="number" name="price" value="{{ $property->price }}" class="w-full p-2 border rounded">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Описание</label>
            <textarea name="description" class="w-full p-2 border rounded">{{ $property->description }}</textarea>
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Сохранить</button>
    </form>
@endsection
