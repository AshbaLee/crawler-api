<?php

namespace App\Http\Controllers;

use App\Http\Requests\WebsiteRequest;
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

    public function store(WebsiteRequest $request)
    {
        $res = $this->crawlerService->store($request->all());
        return new WebsiteResource($res);
    }

    public function index(WebsiteRequest $request)
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
