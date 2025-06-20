<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\Realty;
use App\Models\UserPreference;
use Illuminate\Http\Request;

class FeedController extends Controller
{
    /**
     * Get personalized feed for the authenticated user
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $query = Realty::query()->where('status', 'active');

        // Validate favorites parameter if provided
        $requestFavorites = [];
        if ($request->has('favorites')) {
            $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
                'favorites' => 'array',
                'favorites.*' => 'integer|exists:realties,id',
            ]);

            if (!$validator->fails()) {
                $requestFavorites = $request->favorites;
            }
        }

        // If user is authenticated, personalize the feed
        if ($user) {
            // Get user preferences
            $preference = $user->preference;

            // Apply user preferences if they exist
            if ($preference) {
                // Filter by deal type (rent/sale)
                if ($preference->deal_type) {
                    $query->where('deal', $preference->deal_type);
                }

                // Filter by property type
                if ($preference->property_type) {
                    $query->where('type', $preference->property_type);
                }

                // Filter by price range
                if ($preference->price_min) {
                    $query->where('price', '>=', $preference->price_min);
                }
                if ($preference->price_max) {
                    $query->where('price', '<=', $preference->price_max);
                }

                // Filter by rooms range
                if ($preference->rooms_min) {
                    $query->where('rooms', '>=', $preference->rooms_min);
                }
                if ($preference->rooms_max) {
                    $query->where('rooms', '<=', $preference->rooms_max);
                }

                // Filter by new building
                if ($preference->is_new_building !== null) {
                    $query->where('is_new_building', $preference->is_new_building);
                }
            }

            // Get user favorites to prioritize similar properties
            $favorites = $user->favoriteRealties;

            // If user has favorites, prioritize similar properties
            if ($favorites->count() > 0) {
                // Get the most common property type from favorites
                $favoriteTypes = $favorites->pluck('type')->countBy()->sortDesc();
                $mostCommonType = $favoriteTypes->keys()->first();

                // Get the average price from favorites
                $avgPrice = $favorites->avg('price');

                // Order by similarity to favorites
                $query->orderByRaw("
                    CASE
                        WHEN type = ? THEN 1
                        ELSE 2
                    END,
                    ABS(price - ?)", [$mostCommonType, $avgPrice]);
            }
        } elseif (!empty($requestFavorites)) {
            // For guest users with favorites, prioritize similar properties
            $guestFavorites = Realty::whereIn('id', $requestFavorites)->get();

            if ($guestFavorites->count() > 0) {
                // Get the most common property type from favorites
                $favoriteTypes = $guestFavorites->pluck('type')->countBy()->sortDesc();
                $mostCommonType = $favoriteTypes->keys()->first();

                // Get the average price from favorites
                $avgPrice = $guestFavorites->avg('price');

                // Order by similarity to favorites
                $query->orderByRaw("
                    CASE
                        WHEN type = ? THEN 1
                        ELSE 2
                    END,
                    ABS(price - ?)", [$mostCommonType, $avgPrice]);
            }
        }

        // Apply additional filters from request
        // Filter by deal type (buy/rent)
        if ($request->has('deal')) {
            $query->where('deal', $request->deal);
        }

        // Filter by property type
        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        // Filter by price range
        if ($request->has('price_from')) {
            $query->where('price', '>=', $request->price_from);
        }
        if ($request->has('price_to')) {
            $query->where('price', '<=', $request->price_to);
        }

        // Get the realties with images
        $realties = $query->with('images')->paginate(10);

        // Check if user is authenticated and is a realtor to show owner contact information
        $isRealtor = $user && $user->isRealtor();

        // If user is not a realtor, hide owner contact information
        if (!$isRealtor) {
            $realties->getCollection()->transform(function ($realty) {
                $realty->makeHidden(['name', 'phone']);
                return $realty;
            });
        }

        // Add a flag to indicate if the realty is in user's favorites
        if ($user) {
            $userFavoriteIds = $user->favoriteRealties()->pluck('realties.id')->toArray();

            $realties->getCollection()->transform(function ($realty) use ($userFavoriteIds) {
                $realty->is_favorite = in_array($realty->id, $userFavoriteIds);
                return $realty;
            });
        } elseif (!empty($requestFavorites)) {
            // For guest users, mark favorites based on the request parameter
            $realties->getCollection()->transform(function ($realty) use ($requestFavorites) {
                $realty->is_favorite = in_array($realty->id, $requestFavorites);
                return $realty;
            });
        }

        return response()->json([
            'data' => $realties,
            'message' => 'Feed retrieved successfully'
        ]);
    }

    /**
     * Add or remove a realty from user's favorites
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function toggleFavorite(Request $request, $id)
    {
        $user = $request->user();
        $realty = Realty::findOrFail($id);

        // Check if the realty is already in favorites
        $isFavorite = $user->favoriteRealties()->where('realty_id', $id)->exists();

        if ($isFavorite) {
            // Remove from favorites
            $user->favoriteRealties()->detach($id);
            $message = 'Realty removed from favorites';
        } else {
            // Add to favorites
            $user->favoriteRealties()->attach($id);
            $message = 'Realty added to favorites';
        }

        return response()->json([
            'is_favorite' => !$isFavorite,
            'message' => $message
        ]);
    }

    /**
     * Update user preferences
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updatePreferences(Request $request)
    {
        $user = $request->user();

        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'deal_type' => 'nullable|string|in:rent,sale',
            'price_min' => 'nullable|integer|min:0',
            'price_max' => 'nullable|integer|min:0',
            'property_type' => 'nullable|string',
            'rooms_min' => 'nullable|integer|min:0',
            'rooms_max' => 'nullable|integer|min:0',
            'is_new_building' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        // Update or create user preferences
        $preference = UserPreference::updateOrCreate(
            ['user_id' => $user->id],
            $request->only([
                'deal_type',
                'price_min',
                'price_max',
                'property_type',
                'rooms_min',
                'rooms_max',
                'is_new_building',
            ])
        );

        return response()->json([
            'data' => $preference,
            'message' => 'Preferences updated successfully'
        ]);
    }
}
