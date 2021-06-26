<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Http\Services\ClientRequesterService;
use Illuminate\Http\Request;

class GetPairListsAction extends Controller
{
    private $requester;

    public function __construct(ClientRequesterService $requester)
    {
        $this->requester = $requester;
    }
    
    public function __invoke()
    {
        $response = $this->requester->indodax("pairs");

        dd($response);
    }
}