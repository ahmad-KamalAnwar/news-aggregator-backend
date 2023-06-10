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
        $newsAPIUrl = 'https://newsapi.org/v2/everything?q=The Guardian&apiKey=9951b04cad46414ab61c365610ce9466';
        $response = $this->callApiEndpoint($newsAPIUrl, 'GET');
        $articles = json_decode(json_encode($response->articles), true);

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

            Article::updateOrCreate(
                [
                    'title' => $article['title'],
                    'description' => $article['description'],
                    'web_url' => $article['url'],
                    'content' => $article['content'],
                    'published_at' => $article['publishedAt'],
                    'source_id' => $sourceId,
                    'category_id' => $categoryId,
                    'author_id' => $authorId
                ],
                []
            );
        }

        $nyTimesUrl = 'https://api.nytimes.com/svc/search/v2/articlesearch.json?api-key=4XLPVJlK6zU1vQDLet5OBMvotlBhAYKe';
        $response = $this->callApiEndpoint($nyTimesUrl, 'GET');
        $articles = json_decode(json_encode($response), true)['response']['docs'];

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

            Article::updateOrCreate(
                [
                    'title' => $article['headline']['main'],
                    'description' => $article['abstract'],
                    'web_url' => $article['web_url'],
                    'content' => $article['snippet'],
                    'published_at' => $article['pub_date'],
                    'source_id' => $sourceId,
                    'category_id' => $categoryId,
                    'author_id' => $authorId
                ],
                []
            );
        }

        return 0;
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

}
