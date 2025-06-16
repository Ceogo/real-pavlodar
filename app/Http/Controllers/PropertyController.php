<?php

namespace App\Http\Controllers;

use App\Models\Realty;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        if ($user->role === 'moderator') {
            $properties = Realty::where('status', 'pending')->paginate(10);
        } else {
            $properties = Realty::paginate(10);
        }
        return view('admin.properties.index', compact('properties'));
    }

    public function create()
    {
        return view('admin.properties.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'deal' => 'required|in:rent,sale',
            'type' => 'required|string',
            'price' => 'required|integer|min:0',
            'address' => 'required|string',
            'rooms' => 'integer|min:1',
            'description' => 'nullable|string',
            'year_built' => 'nullable|integer|min:1800|max:' . date('Y'),
            'height' => 'nullable|integer',
            'balcony' => 'nullable|string|in:none,balcony,loggia',
            'furniture' => 'nullable|string|in:none,partial,full',
            'flooring' => 'nullable|string',
            'parking' => 'nullable|string|in:none,ground,underground',
            'floor' => 'nullable|integer',
            'floors' => 'nullable|integer',
            'is_first_floor' => 'boolean',
            'is_last_floor' => 'boolean',
            'is_new_building' => 'boolean',
            'total_floors' => 'nullable|integer',
            'coordinates' => 'nullable|string',
        ]);

        $property = Realty::create($validated);
        return redirect()->route('admin.properties.index')->with('success', 'Объект создан');
    }

    public function edit($id)
    {
        $property = Realty::findOrFail($id);
        if (auth()->user()->role === 'moderator' && $property->status !== 'pending') {
            abort(403, 'Вы не можете редактировать этот объект');
        }
        return view('admin.properties.edit', compact('property'));
    }

    public function update(Request $request, $id)
    {
        $property = Realty::findOrFail($id);
        if (auth()->user()->role === 'moderator' && $property->status !== 'pending') {
            abort(403, 'Вы не можете редактировать этот объект');
        }

        $validated = $request->validate([
            'deal' => 'required|in:rent,sale',
            'type' => 'required|string',
            'price' => 'required|integer|min:0',
            'address' => 'required|string',
            'rooms' => 'integer|min:1',
            'description' => 'nullable|string',
            'year_built' => 'nullable|integer|min:1800|max:' . date('Y'),
            'height' => 'nullable|integer',
            'balcony' => 'nullable|string|in:none,balcony,loggia',
            'furniture' => 'nullable|string|in:none,partial,full',
            'flooring' => 'nullable|string',
            'parking' => 'nullable|string|in:none,ground,underground',
            'floor' => 'nullable|integer',
            'floors' => 'nullable|integer',
            'is_first_floor' => 'boolean',
            'is_last_floor' => 'boolean',
            'is_new_building' => 'boolean',
            'total_floors' => 'nullable|integer',
            'coordinates' => 'nullable|string',
        ]);

        $property->update($validated);
        return redirect()->route('admin.properties.index')->with('success', 'Объект обновлен');
    }

    public function approve($id)
    {
        $property = Realty::findOrFail($id);
        if ($property->status !== 'pending') {
            abort(403, 'Этот объект не ожидает проверки');
        }
        $property->status = 'approved';
        $property->save();
        return redirect()->back()->with('success', 'Объект одобрен');
    }

    public function reject($id)
    {
        $property = Realty::findOrFail($id);
        if ($property->status !== 'pending') {
            abort(403, 'Этот объект не ожидает проверки');
        }
        $property->status = 'rejected';
        $property->save();
        return redirect()->back()->with('success', 'Объект отклонен');
    }

    public function destroy($id)
    {
        $property = Realty::findOrFail($id);
        $property->delete();
        return redirect()->back()->with('success', 'Объект удален');
    }
}
