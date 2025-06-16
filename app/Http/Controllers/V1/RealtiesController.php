<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\Realty;
use Illuminate\Http\Request;

class RealtiesController extends Controller
{
    public function index(Request $request)
    {
        $query = Realty::query();

        // Filter by deal type (buy/rent)
        if ($request->has('deal')) {
            $query->where('deal', $request->deal);
        }

        // Filter by property type
        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        // Filter by new building
        if ($request->has('is_new_building')) {
            $query->where('is_new_building', $request->boolean('is_new_building'));
        }

        // Filter by number of rooms
        if ($request->has('rooms')) {
            $query->where('rooms', $request->rooms);
        }

        // Filter by price range
        if ($request->has('price_from')) {
            $query->where('price', '>=', $request->price_from);
        }
        if ($request->has('price_to')) {
            $query->where('price', '<=', $request->price_to);
        }

        // Filter by year built range
        if ($request->has('year_from')) {
            $query->where('year_built', '>=', $request->year_from);
        }
        if ($request->has('year_to')) {
            $query->where('year_built', '<=', $request->year_to);
        }

        // Filter by not first floor
        if ($request->has('not_first_floor') && $request->boolean('not_first_floor')) {
            $query->where('is_first_floor', false);
        }

        // Filter by not last floor
        if ($request->has('not_last_floor') && $request->boolean('not_last_floor')) {
            $query->where('is_last_floor', false);
        }

        // Filter by area (height) range
        if ($request->has('area_from')) {
            $query->where('height', '>=', $request->area_from);
        }
        if ($request->has('area_to')) {
            $query->where('height', '<=', $request->area_to);
        }

        // Filter by balcony
        if ($request->has('balcony')) {
            $query->where('balcony', '!=', 'none');
        }

        // Filter by parking
        if ($request->has('parking')) {
            $query->where('parking', '!=', 'none');
        }

        // Filter by furniture
        if ($request->has('furniture')) {
            $query->where('furniture', '!=', 'none');
        }

        // Filter by properties with images
        if ($request->has('with_photos') && $request->boolean('with_photos')) {
            $query->whereHas('images');
        }

        $realties = $query->with('images')->paginate(10);

        // Check if user is authenticated and is a realtor to show owner contact information
        $user = $request->user();
        $isRealtor = $user && $user->isRealtor();

        // If user is not a realtor, hide owner contact information
        if (!$isRealtor) {
            $realties->getCollection()->transform(function ($realty) {
                $realty->makeHidden(['name', 'phone']);
                return $realty;
            });
        }

        return response()->json([
            'data' => $realties,
            'message' => 'Realties retrieved successfully'
        ]);
    }

    /**
     * Store a newly created realty in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'status' => 'required|string|in:inactive,active,sold',
            'deal' => 'required|string|in:rent,sale',
            'type' => 'required|string',
            'price' => 'required|numeric|min:0',
            'address' => 'required|string',
            'rooms' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'year_built' => 'nullable|integer',
            'height' => 'nullable|integer',
            'balcony' => 'nullable|string',
            'furniture' => 'nullable|string',
            'parking' => 'nullable|string',
            'floor' => 'nullable|integer',
            'floors' => 'nullable|integer',
            'is_first_floor' => 'nullable|boolean',
            'is_last_floor' => 'nullable|boolean',
            'is_new_building' => 'nullable|boolean',
            'total_floors' => 'nullable|integer',
            'coordinates' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $realty = Realty::create($request->all());

        return response()->json([
            'data' => $realty,
            'message' => 'Realty created successfully'
        ], 201);
    }

    /**
     * Display the specified realty.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $realty = Realty::with('images')->findOrFail($id);

        return response()->json([
            'data' => $realty,
            'message' => 'Realty retrieved successfully'
        ]);
    }

    /**
     * Update the specified realty in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $realty = Realty::findOrFail($id);

        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'phone' => 'sometimes|string|max:20',
            'status' => 'sometimes|string|in:inactive,active,sold',
            'deal' => 'sometimes|string|in:rent,sale',
            'type' => 'sometimes|string',
            'price' => 'sometimes|numeric|min:0',
            'address' => 'sometimes|string',
            'rooms' => 'sometimes|integer|min:1',
            'description' => 'nullable|string',
            'year_built' => 'nullable|integer',
            'height' => 'nullable|integer',
            'balcony' => 'nullable|string',
            'furniture' => 'nullable|string',
            'parking' => 'nullable|string',
            'floor' => 'nullable|integer',
            'floors' => 'nullable|integer',
            'is_first_floor' => 'nullable|boolean',
            'is_last_floor' => 'nullable|boolean',
            'is_new_building' => 'nullable|boolean',
            'total_floors' => 'nullable|integer',
            'coordinates' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $realty->update($request->all());

        return response()->json([
            'data' => $realty,
            'message' => 'Realty updated successfully'
        ]);
    }
}
