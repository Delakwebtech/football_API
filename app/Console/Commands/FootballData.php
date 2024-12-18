<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use App\Models\LeagueTable;

class FootballData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:stages';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch stages of competitions and save them to the database';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Fetch data from the Football API
        $client = new Client();

        $leagues = [
            [
                'country' => 'england',
                'league' => 'premier-league',
            ],
            [
                'country' => 'spain',
                'league' => 'la-liga',
            ],
            [
                'country' => 'germany',
                'league' => 'bundesliga',
            ],
            [
                'country' => 'italy',
                'league' => 'serie-a',
            ],
        ];

        foreach ($leagues as $league) {
            $response = $client->request('GET', 'https://livescore6.p.rapidapi.com/leagues/v2/get-table', [
                'query' => [
                    'Category' => 'soccer',
                    'Ccd' => $league['country'],
                    'Scd' => $league['league'],
                ],
                'headers' => [
                    'x-rapidapi-host' => 'livescore6.p.rapidapi.com',
                    'x-rapidapi-key' => 'de073dc2d6mshb6ca4bac1559e41p1fdffejsn881527b32c9f',
                ],
            ]);

            $data = json_decode($response->getBody(), true);

            if (!empty($data['LeagueTable']['L'][0]['Tables'][0]['team'])) {
                foreach ($data['LeagueTable']['L'][0]['Tables'][0]['team'] as $team) {
                    LeagueTable::updateOrCreate(
                        [
                            'league_id' => $data['Scd'],
                            'team_name' => $team['Tnm'],
                        ],
                        [
                            'rank' => $team['rnk'],
                            'points' => $team['pts'],
                            'played' => $team['pld'],
                            'won' => $team['win'],
                            'drawn' => $team['drw'],
                            'lost' => $team['lot'],
                            'goals_for' => $team['gf'],
                            'goals_against' => $team['ga'],
                            'goal_difference' => $team['gd'],
                            'team_image' => $team['Img'],
                        ]
                    );
                }
            }
        }

        $this->info('League table data has been successfully fetched and saved!');
    }
}
