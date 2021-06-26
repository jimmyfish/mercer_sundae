<?php

namespace App\Console\Commands\Core;

use App\Http\Services\ClientRequesterService;
use App\Models\Ticker;
use App\Models\WatchList;
use Illuminate\Console\Command;

class ProcessTickerDataCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:ticker';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch ticker according to watch list';

    private $requester;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ClientRequesterService $requester)
    {
        parent::__construct();

        $this->requester = $requester;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $watchLists = WatchList::all();

        $watchLists->each(function ($watchList) {
            $symbol = $watchList->pair->symbol_id;
            $response = $this->requester->indodax("ticker/$symbol");

            $ticker = $response->getBody()->getContents();
            $ticker = json_decode($ticker);
            $ticker = collect($ticker->ticker);

            $newTickerData = [];
            foreach ($ticker as $key => $value) {
                if (strpos($key, 'vol') !== false) {
                    $symbolTruncated = str_replace("vol_", "", $key);

                    if (strpos($symbol, $symbolTruncated) === 0) {
                        $newTickerData['vol_left'] = $value;
                    } else {
                        $newTickerData['vol_right'] = $value;
                    }

                    continue;
                }

                if ($key === 'server_time') continue;

                $newTickerData[$key] = $value;
            }

            $tickerData = new Ticker($newTickerData);
            $tickerData->save();
        });
    }
}
