<?php

namespace App\Console\Commands\Core;

use Carbon\Carbon;
use App\Models\Pair;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;
use App\Http\Services\ClientRequesterService;

class ProcessPairsCommand extends Command
{
    protected $signature = 'fetch:pairs {source? : Source of pairs [dx, tk]}';

    protected $description = 'Fetching pairs';

    private $requester;

    public function __construct(ClientRequesterService $requester)
    {
        parent::__construct();

        $this->requester = $requester;
    }

    public function handle()
    {
        $source = $this->argument('source') ?? "dx";

        if ($source === 'dx') {
            $this->fetchIndodax();
        } else if ($source === 'tk') {
            $this->fetchTokoCrypto();
        } else {
            return $this->line('source not recognized, exiting...');
        }
    }

    private function fetchIndodax()
    {
        $response = $this->requester->indodax('pairs');

        $pairs = $response->getBody()->getContents();
        $pairs = collect(json_decode($pairs));

        $newPairsData = [];
        $success = false;

        $existed = Pair::all();

        $integrityExisted = [];

        $existed->each(function ($exist) use (&$integrityExisted) {
            $integrityExisted[] = base64_encode(json_encode($exist->symbol_id));
        });

        $pairs->each(function ($pair) use ($integrityExisted, &$newPairsData) {
            $newData = [];
            foreach ($pair as $column => $value) {
                $newData[$column] = $value;
            }

            if (!isset($newData['old_ticker_id'])) $newData['old_ticker_id'] = NULL;

            $newData['source'] = "indodax";
            $newData['symbol_id'] = $newData['id'];
            unset($newData['id']);

            $integrityHash = base64_encode(json_encode($newData['symbol_id']));

            if (!in_array($integrityHash, $integrityExisted)) $newPairsData[] = $newData;
        });

        DB::beginTransaction();

        try {
            Pair::insert($newPairsData);

            DB::commit();
            $success = true;
            Log::channel('cron')->info('fetching pair data from Indodax DONE! ' . count($newPairsData) . " inserted");
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            if($errorCode == 1062){
                Log::channel('cron_error')->warning('Found duplicate data at ' . Carbon::now()->format('d-m-Y H:i:s') . ". Exiting ...");
            }

            Log::channel('cron_error')->error($e->getMessage());

            $success = true;
        } catch (\Exception $e) {
            DB::rollBack();

            Log::channel('cron_error')->warning($e->getMessage());
            Log::channel('cron_error')->info('fetching pair data from Indodax FAILED!');
        }

        if (!$success) $this->fetchIndodax();
    }

    private function fetchTokoCrypto()
    {
        $this->line('fetching TokoCrypto symbol pairs');
    }
}
