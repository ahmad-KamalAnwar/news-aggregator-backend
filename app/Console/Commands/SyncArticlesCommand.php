<?php

namespace App\Console\Commands;

use App\Models\Article;
use App\Models\Author;
use App\Models\Category;
use App\Models\Source;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

class SyncArticlesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:articles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return int
     * @throws \Exception
     */
    public function handle()
    {
        $newsAPIUrl = config('app.NEWS_API_URL') . '&apiKey=' . config('app.NEWS_API_KEY');
        $nyTimesUrl = config('app.NEWYORK_TIME_API_URL') . '?api-key=' . config('app.NY_TIMES_API_KEY');
        $theGuardiansUrl = config('app.THE_GAURDIANS_API_URL') . '?api-key=' . config('app.THE_GUARDIANS_API_KEY');

        $response = $this->callApiEndpoint($newsAPIUrl, 'GET');
        $newsAPIArticles = json_decode(json_encode($response->articles), true);
        $this->createNewsApiArticles($newsAPIArticles);

        $response = $this->callApiEndpoint($nyTimesUrl, 'GET');
        $nyTimesArticles = json_decode(json_encode($response), true)['response']['docs'];
        $this->createNyTimesArticles($nyTimesArticles);

        $response = $this->callApiEndpoint($theGuardiansUrl, 'GET');
        $theGuardianArticles = json_decode(json_encode($response), true)['response']['results'];
        $this->createtheGuardianArticles($theGuardianArticles);

        return 0;
    }

    private function createNyTimesArticles($articles)
    {
        foreach ($articles as $article) {
            $authorId = null;
            $sourceId = null;
            $categoryId = null;
            $category = isset($article['section_name']) && !empty($article['section_name']) ?
                $article['section_name'] : Category::GENERAL;
            $categoryId = $this->getCategoryId($category);

            if (isset($article['source']) && !empty($article['source'])) {
                $sourceId = $this->getSourceId($article['source']);
            }

            if (isset($article['author']) && !empty($article['author'])) {
                $authorId = $this->getAuthorId($article['author']);
            }

            $this->createArticle(
                [
                    'title' => $article['headline']['main'],
                    'description' => $article['abstract'],
                    'web_url' => $article['web_url'],
                    'content' => $article['snippet'],
                    'published_at' => $article['pub_date'],
                    'source_id' => $sourceId,
                    'category_id' => $categoryId,
                    'author_id' => $authorId
                ]
            );
        }
    }

    private function createtheGuardianArticles($articles)
    {
        $sourceId = $this->getSourceId(Source::THE_GUARDIAN);

        foreach ($articles as $article) {
            $authorId = null;
            $categoryId = null;
            $category = isset($article['sectionName']) && !empty($article['sectionName']) ?
                $article['sectionName'] : Category::GENERAL;
            $categoryId = $this->getCategoryId($category);


            if (isset($article['author']) && !empty($article['author'])) {
                $authorId = $this->getAuthorId($article['author']);
            }

            $this->createArticle(
                [
                    'title' => $article['webTitle'],
                    'description' => null,
                    'web_url' => $article['webUrl'],
                    'content' => null,
                    'published_at' => $article['webPublicationDate'],
                    'source_id' => $sourceId,
                    'category_id' => $categoryId,
                    'author_id' => $authorId
                ]
            );
        }
    }

    private function createNewsApiArticles($articles)
    {
        foreach ($articles as $article) {
            $authorId = null;
            $sourceId = null;
            $categoryId = null;
            $category = isset($article['category']) && !empty($article['category']) ?
                $article['category'] : Category::GENERAL;
            $categoryId = $this->getCategoryId($category);

            if (isset($article['source']['name']) && !empty($article['source']['name'])) {
                $sourceId = $this->getSourceId($article['source']['name']);
            }

            if (isset($article['author']) && !empty($article['author'])) {
                $authorId = $this->getAuthorId($article['author']);
            }

            $this->createArticle(
                [
                    'title' => $article['title'],
                    'description' => $article['description'],
                    'web_url' => $article['url'],
                    'content' => $article['content'],
                    'published_at' => $article['publishedAt'],
                    'source_id' => $sourceId,
                    'category_id' => $categoryId,
                    'author_id' => $authorId
                ]
            );
        }
    }

    private function callApiEndpoint($url, $method, $options = [])
    {
        try {
            $client = new Client();
            $response = $client->request($method, $url, $options);

            return json_decode($response->getBody());
        } catch (\Exception $e) {
            throw $e;
        }
    }

    private function getAuthorId($articleAuthor)
    {
        $author = Author::where('name', $articleAuthor)->first();

        if (is_null($author)) {
            $author = Author::updateOrCreate(['name' => $articleAuthor], []);
        }

        return $author->id;
    }

    private function getSourceId($articleSource)
    {
        $source = Source::where('name', $articleSource)->first();

        if (is_null($source)) {
            $source = Source::updateOrCreate(['name' => $articleSource], []);
        }

        return $source->id;
    }

    private function getCategoryId($articleCategory)
    {
        $category = Category::where('name', $articleCategory)->first();

        if (is_null($category)) {
            $category = Category::updateOrCreate(['name' => $articleCategory], []);
        }

        return $category->id;
    }

    private function createArticle($data)
    {
        Article::updateOrCreate(
            [
                'title' => $data['title'],
                'description' => $data['description'],
                'web_url' => $data['web_url'],
                'content' => $data['content'],
                'published_at' => $data['published_at'],
                'source_id' => $data['source_id'],
                'category_id' => $data['category_id'],
                'author_id' => $data['author_id']
            ],
            []
        );
    }
}
