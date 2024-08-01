<?php

namespace App\Http\Controllers;

use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class ZoneController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'zones' => 'required|array',
            'zones.*' => 'required|string|max:255'
        ]);

        $user = auth()->user(); // Assuming the user is authenticated
        try {
        $providerZone = Zone::updateOrCreate(
            ['provider_id' => $user->id],
            ['zones' => $request->zones]
        );
        return response()->json([
            'message' => 'Zones assigned successfully',
            'providerZone' => $providerZone
        ], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to assign zones'], 500);
        }
    }

    public function index()
    {
        $user = Auth::user();
        $zones = $user->zones;

        return response()->json(['zones' => $zones]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'zones' => 'required|array',
            'zones.*' => 'required|string|max:255'
        ]);

        $user = auth()->user(); // Assuming the user is authenticated

        $providerZone = Zone::where('provider_id', $user->id)->first();
        try{
            if ($providerZone) {
                // Merge new zones with existing zones
                $existingZones = $providerZone->zones;
                $newZones = $request->zones;
                $mergedZones = array_unique(array_merge($existingZones, $newZones));
        
                // Update the provider's zones
                $providerZone->zones = $mergedZones;
                $providerZone->save();
            } else {
                // If no existing zones, create a new record
                $providerZone = Zone::create([
                    'provider_id' => $user->id,
                    'zones' => $request->zones
                ]);
            }
        
            return response()->json([
                'message' => 'Zones updated successfully',
                'providerZone' => $providerZone
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to update zones'], 500);
        }
    }

    // delete one zone form array of zones not all
    public function deleteZoneItem(Request $request)
    {
        // Validate the request data
        $request->validate([
            'zone' => 'required|string|max:255'
        ]);

        $user = auth()->user(); // Assuming the user is authenticated

        // Fetch the provider's zone record
        $providerZone = Zone::where('provider_id', $user->id)->first();
        try{
            if ($providerZone) {
                // Retrieve current zones
                $zones = $providerZone->zones;

                // Remove the specified zone
                $updatedZones = array_filter($zones, function($z) use ($request) {
                    return $z !== $request->zone;
                });

                // Re-index the array to remove any gaps in keys
                $updatedZones = array_values($updatedZones);

                // Update the provider's zones
                $providerZone->zones = $updatedZones;
                $providerZone->save();

                return response()->json([
                    'message' => 'Zone deleted successfully',
                    'providerZone' => $providerZone
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Provider not found'
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to delete zone'], 500);
        }
    }


    public function destroy($id)
    {
        $zone = Zone::where('id', $id)->where('provider_id', Auth::id())->first();

        if (!$zone) {
            return response()->json(['message' => 'Zone not found or you are not authorized to delete it'], 404);
        }

        $zone->delete();

        return response()->json(['message' => 'Zone deleted successfully']);
    }

}
