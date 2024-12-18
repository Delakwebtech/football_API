<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LeagueTable;

class LeagueTableController extends Controller
{
    /**
     * Fetch league table data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        // Filter by league if query parameter exists
        $leagueId = $request->query('league_id');

        $query = LeagueTable::query();

        if ($leagueId) {
            $query->where('league_id', $leagueId);
        }

        // Fetch data with optional sorting and pagination
        $leagueTables = $query->orderBy('rank', 'asc')->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $leagueTables,
        ]);
    }
}
