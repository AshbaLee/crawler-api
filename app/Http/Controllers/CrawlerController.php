<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CrawlerService;
use App\Http\Resources\WebsiteResource;

class CrawlerController extends Controller
{
    protected $crawlerService;

    public function __construct(
        CrawlerService $crawlerService
    ) {
        $this->crawlerService = $crawlerService;
    }

    public function store(Request $request)
    {
        $res = $this->crawlerService->store($request->all());
        return new WebsiteResource($res);
    }

    public function index(Request $request)
    {
        $res = $this->crawlerService->index($request->all());
        return new WebsiteResource($res);
    }

    public function show(string $id)
    {
        $res = $this->crawlerService->show($id);
        return new WebsiteResource($res);
    }
}
