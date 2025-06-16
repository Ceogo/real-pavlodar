<?php

namespace App\Http\Controllers;

use App\Models\Buyer;
use Illuminate\Http\Request;

class RequestController extends Controller
{
    public function index()
    {
        $requests = Buyer::with('realty')->paginate(10);
        return view('admin.requests.index', compact('requests'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:new,in_progress,completed,rejected',
        ]);

        $buyer = Buyer::findOrFail($id);
        $buyer->status = $validated['status'];
        $buyer->save();
        return redirect()->back()->with('success', 'Статус заявки обновлен');
    }
}
