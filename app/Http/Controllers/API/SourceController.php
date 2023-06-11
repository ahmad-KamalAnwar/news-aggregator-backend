<?php

namespace App\Http\Controllers\API;

use App\Services\SourceService;
use Illuminate\Routing\Controller;

class SourceController extends Controller
{
    /**
     * @var SourceService
     */
    protected $sourceService;

    /**
     * SourceController constructor.
     * @param SourceService $sourceService
     */
    public function __construct(SourceService $sourceService)
    {
        $this->sourceService = $sourceService;
    }

    public function getSources() {
        $response = $this->sourceService->getAllSources();

        return response($response, 201);
    }
}
