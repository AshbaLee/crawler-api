<?php

namespace App\Repositories;

use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use App\Models\Website;

class WebsiteRepository
{
    protected $website;

    public function __construct(Website $website)
    {
        $this->website = $website;
    }

    public function store(array $request)
    {
        return $this->website->create($request);
    }

    public function index(array $request)
    {
        if (Arr::get($request, 'title')) {
            $this->website = $this->website->where('title', 'like', "%${request['title']}%");
        }

        if (Arr::get($request, 'description')) {
            $this->website = $this->website->where('description', 'like', "%${request['description']}%");
        }

        if (Arr::get($request, 'begin')) {
            $this->website = $this->website->whereBetween('created_at', [
                Carbon::createFromFormat('Y-m-d', $request['begin'])->startOfDay(),
                Carbon::createFromFormat('Y-m-d', $request['end'])->endOfDay()
            ]);
        }

        return $this->website->paginate(10);
    }

    public function show(string $id)
    {
        return $this->website->findOrFail($id);
    }
}
