<?php

namespace Database\Seeders;

use App\Models\Pair;
use App\Models\WatchList;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class PairAndWatchListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Artisan::call('fetch:pairs');

        $pairs = Pair::all();

        if ($pairs->count() === 0) {
            echo 'Pairs empty';
            return;
        }

        $watchLists = [];

        for ($i = 0; $i < 10; $i++) {
            $rand = rand(0, count($pairs) - 1);

            if (!isset($pairs[$rand])) {
                echo "Offset occured. recursing...";
                $i--;
                continue;
            }

            $watchList = [
                'pair_id' => $pairs[$rand]->id,
                'source' => $pairs[$rand]->source
            ];

            $watchLists[] = $watchList;
            unset($pairs[$rand]);
        }

        WatchList::insert($watchLists);
    }
}
