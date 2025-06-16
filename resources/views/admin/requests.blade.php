@extends('admin.layout')
@section('title', 'Заявки покупателей')
@section('content')
    <h2 class="text-xl font-bold mb-4">Заявки покупателей</h2>
    <table class="min-w-full bg-white shadow-md rounded">
        <thead>
            <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                <th class="py-3 px-6 text-left">ID</th>
                <th class="py-3 px-6 text-left">Имя</th>
                <th class="py-3 px-6 text-left">Телефон</th>
                <th class="py-3 px-6 text-left">Объект</th>
                <th class="py-3 px-6 text-left">Статус</th>
                <th class="py-3 px-6 text-left">Действия</th>
            </tr>
        </thead>
        <tbody class="text-gray-600 text-sm">
            @foreach($requests as $request)
                <tr class="border-b border-gray-200 hover:bg-gray-100">
                    <td class="py-3 px-6">{{ $request->id }}</td>
                    <td class="py-3 px-6">{{ $request->name }}</td>
                    <td class="py-3 px-6">{{ $request->phone }}</td>
                    <td class="py-3 px-6">{{ $request->reality->address }}</td>
                    <td class="py-3 px-6">{{ $request->status }}</td>
                    <td class="py-3 px-6">
                        <form action="{{ url('/admin/requests/' . $request->id . '/update') }}" method="POST" class="inline">
                            @csrf
                            @method('PUT')
                            <select name="status" class="border rounded p-1" onchange="this.form.submit()">
                                <option value="new" {{ $request->status === 'new' ? 'selected' : '' }}>Новая</option>
                                <option value="in_progress" {{ $request->status === 'in_progress' ? 'selected' : '' }}>В работе</option>
                                <option value="completed" {{ $request->status === 'completed' ? 'selected' : '' }}>Завершена</option>
                                <option value="rejected" {{ $request->status === 'rejected' ? 'selected' : '' }}>Отклонена</option>
                            </select>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
