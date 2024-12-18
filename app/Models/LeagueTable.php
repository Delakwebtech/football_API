<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeagueTable extends Model
{

    // Allow these attributes for mass assignment
    protected $fillable = [
        'league_id',
        'team_name',
        'rank',
        'points',
        'played',
        'won',
        'drawn',
        'lost',
        'goals_for',
        'goals_against',
        'goal_difference',
        'team_image',
    ];
}
