@extends('admin.layout')
@section('title', 'Пользователи')
@section('content')
    <h2 class="text-xl font-bold mb-4">Пользователи</h2>
    <a href="{{ url('/admin/users/create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">Добавить пользователя</a>
    <table class="min-w-full bg-white shadow-md rounded">
        <thead>
            <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                <th class="py-3 px-6 text-left">ID</th>
                <th class="py-3 px-6 text-left">Имя</th>
                <th class="py-3 px-6 text-left">Email</th>
                <th class="py-3 px-6 text-left">Роль</th>
                <th class="py-3 px-6 text-left">Действия</th>
            </tr>
        </thead>
        <tbody class="text-gray-600 text-sm">
            @foreach($users as $user)
                <tr class="border-b border-gray-200 hover:bg-gray-100">
                    <td class="py-3 px-6">{{ $user->id }}</td>
                    <td class="py-3 px-6">{{ $user->name }}</td>
                    <td class="py-3 px-6">{{ $user->email }}</td>
                    <td class="py-3 px-6">{{ $user->role }}</td>
                    <td class="py-3 px-6">
                        <a href="{{ url('/admin/users/' . $user->id . '/edit') }}" class="text-blue-500 hover:underline">Редактировать</a>
                        <form action="{{ url('/admin/users/' . $user->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:underline ml-2">Удалить</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
