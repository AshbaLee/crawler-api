<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Cache;
use Psr\Http\Message\UriInterface;
use Psr\Http\Message\ResponseInterface;
use Spatie\Browsershot\Browsershot;
use Spatie\Crawler\Crawler;
use Spatie\Crawler\CrawlObservers\CrawlObserver;
use Symfony\Component\DomCrawler\Crawler as DOM;
use App\Repositories\WebsiteRepository;

class CrawlerService
{
    protected $websiteRepo;

    public function __construct(
        WebsiteRepository $websiteRepo
    ) {
        $this->websiteRepo = $websiteRepo;
    }

    public function store(array $request)
    {
        $crawler = new Crawler(new Client);
        $browsershot = (new Browsershot)->noSandbox()->windowSize(1920, 1080);
        $crawler->setCrawlObserver(new class extends CrawlObserver
        {
            public function crawled(
                UriInterface $url,
                ResponseInterface $response,
                UriInterface $foundOnurl = null
            ) {
                Cache::put('body', (string) $response->getBody());
            }

            public function crawlFailed(
                UriInterface $url,
                RequestException $requestException,
                ?UriInterface $foundOnUrl = null
            ) {
            }
        })->setBrowsershot($browsershot)
            ->executeJavaScript()
            ->setTotalCrawlLimit(1)
            ->startCrawling($request['url']);

        $body = Cache::pull('body');
        $dom = new DOM($body);

        // $crawler->getBrowsershot()->save(base_path() . '/storage/a.png');

        return $this->websiteRepo->store([
            'url' => $request['url'],
            'title' => $body ? $dom->filter('title')->first()->text() : '',
            'description' => $body ? $dom->filterXpath("//meta[@name='description']")->extract(array('content'))[0] : '',
            'body' => $body,
            'screenshot' => $crawler->getBrowsershot()->base64Screenshot()
        ]);
    }

    public function index(array $request)
    {
        return $this->websiteRepo->index($request);
    }

    public function show(string $id)
    {
        return $this->websiteRepo->show($id);
    }
}
