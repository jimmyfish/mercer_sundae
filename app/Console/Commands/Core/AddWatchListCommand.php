<?php

namespace App\Console\Commands\Core;

use App\Models\Pair;
use App\Models\WatchList;
use Illuminate\Console\Command;

class AddWatchListCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'watch:add {symbol}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add symbol to watch list';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $symbol = $this->argument('symbol');

        $pair = Pair::where('symbol_id', strtolower($symbol))->first();

        if (!$pair) return $this->line('Symbol not found');

        $watchList = WatchList::where('pair_id', $pair->id)->first();

        if ($watchList) return $this->line('Symbol already on the watch list');

        $watchList = new WatchList([
            'pair_id' => $pair->id,
            'source' => $pair->source
        ]);

        $watchList->save();

        return $this->line("Add $symbol DONE!");
    }
}
