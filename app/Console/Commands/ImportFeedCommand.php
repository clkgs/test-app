<?php

namespace App\Console\Commands;

use App\Models\Article;
use App\Models\ArticleAuthor;
use App\Models\ArticleCategory;
use App\Models\ArticleSocial;
use App\Models\ArticleTag;
use App\Models\Author;
use App\Models\Category;
use App\Models\Content;
use App\Models\Media;
use App\Models\Social;
use App\Models\Tag;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class ImportFeedCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'feed:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import feed.json into database';

    /**
     * @var string
     */
    private string $fileName = 'feed.json';

    /**
     * @var array<int, array>
     */
    private array $articles = [];
    /**
     * @var array<int, array>
     */
    private array $categories = [];
    /**
     * @var array<int, array>
     */
    private array $authors = [];
    /**
     * @var array<int, array>
     */
    private array $medias = [];
    /**
     * @var array<int, array>
     */
    private array $tags = [];
    /**
     * @var array<int, array>
     */
    private array $socials = [];
    /**
     * @var array<int, array>
     */
    private array $contents = [];

    /**
     * @var array<int, array>
     */
    private array $articleTags = [];
    /**
     * @var array<int, array>
     */
    private array $articleCategories = [];
    /**
     * @var array<int, array>
     */
    private array $articleAuthors = [];
    /**
     * @var array<int, array>
     */
    private array $articleSocials = [];

    /**
     * @var array<int, string>
     */
    private array $articleFields = [
        'id',
        'source',
        'title',
        'subtitle',
        'slug',
        'format',
        'emoji',
    ];

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $feed = file_get_contents(storage_path($this->fileName));
        if ($feed === false) {
            $this->error('Cannot read file: ' . $this->fileName);

            return 1;
        }

        try {
            $articles = json_decode($feed, true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            $this->error($e->getMessage());

            return 1;
        }

        $this->parseArticles($articles);
        $this->storeData();

        return 0;
    }

    /**
     * @param array $contents
     * @param string $articleId
     *
     * @return void
     *
     * @throws \JsonException
     */
    private function parseContents(array $contents, string $articleId): void
    {
        foreach ($contents as $content) {
            $this->contents[] = array_merge([
                'id' => Str::uuid()->toString(),
                'article_id' => $articleId,
                'attributes' => json_encode($content['attributes'], JSON_THROW_ON_ERROR),
            ], Arr::except($content, 'attributes'));
        }
    }

    /**
     * @param array $categories
     *
     * @return array
     */
    private function parseCategories(array $categories): array
    {
        $ids = [];
        if (isset($categories['primary'])) {
            $ids[] = [
                'category_id' => $this->getCategory($categories['primary']),
                'is_primary' => true,
            ];
        }

        if (isset($categories['additional'])) {
            foreach ($categories['additional'] as $category) {
                $ids[] = [
                    'category_id' => $this->getCategory($category),
                    'is_primary' => false,
                ];
            }
        }

        return $ids;
    }

    /**
     * @param string $category
     *
     * @return string
     */
    private function getCategory(string $category): string
    {
        if (!isset($this->categories[$category])) {
            $this->categories[$category] = [
                'id' => Str::uuid()->toString(),
                'name' => $category,
            ];
        }

        return $this->categories[$category]['id'];
    }

    /**
     * @param array $authors
     *
     * @return array
     */
    private function parseAuthors(array $authors): array
    {
        $ids = [];

        foreach ($authors as $author) {
            if (!isset($this->authors[$author['id']])) {
                $this->authors[$author['id']] = Arr::except($author, ['@link']);
            }

            $ids[] = $author['id'];
        }

        return $ids;
    }


    /**
     * @param array $medias
     * @param string $articleId
     *
     * @return void
     *
     * @throws \JsonException
     */
    private function parseMedias(array $medias, string $articleId): void
    {
        foreach ($medias as $media) {
            if (!isset($this->medias[$media['media']['id']])) {
                $this->medias[$media['media']['id']] = array_merge([
                    'article_id' => $articleId,
                    'attributes' => json_encode($media['media']['attributes'], JSON_THROW_ON_ERROR),
                ],
                    Arr::except($media['media'], ['@link', 'properties', 'attributes']),
                    $media['media']['properties'],
                );
            }
        }
    }

    /**
     * @param array $tags
     *
     * @return array
     */
    private function parseTags(array $tags): array
    {
        $ids = [];

        foreach ($tags as $tag) {
            if (!isset($this->tags[$tag['id']])) {
                $this->tags[$tag['id']] = Arr::except($tag, ['@link']);
            }

            $ids[] = $tag['id'];
        }

        return $ids;
    }

    /**
     * @param array $socials
     *
     * @return array
     */
    private function parseSocials(array $socials): array
    {
        $ids = [];

        foreach ($socials as $social) {
            $socialId = $this->getSocialId($social['name']);

            $ids[] = [
                'social_id' => $socialId,
                'shares' => $social['shares'],
                'link' => $social['link'],
            ];
        }

        return $ids;
    }

    /**
     * @param string $name
     *
     * @return string
     */
    private function getSocialId(string $name): string
    {
        if (!isset($this->socials[$name])) {
            $this->socials[$name] = [
                'id' => Str::uuid()->toString(),
                'name' => $name,
            ];
        }

        return $this->socials[$name]['id'];
    }

    /**
     * @param array $articles
     *
     * @return void
     *
     * @throws \JsonException
     */
    private function parseArticles(array $articles): void
    {
        foreach ($articles as $article) {
            $articleId = $article['id'];
            $this->articles[] = array_merge(
                Arr::only($article, $this->articleFields),
                $article['properties'] ?? [],
            );

            $this->parseContents($article['content'], $articleId);

            foreach ($this->parseCategories($article['categories']) as $category) {
                $this->articleCategories[] = array_merge([
                    'id' => Str::uuid()->toString(),
                    'article_id' => $articleId,
                ], $category);
            }

            foreach ($this->parseAuthors($article['authors']) as $authorId) {
                $this->articleAuthors[] = [
                    'id' => Str::uuid()->toString(),
                    'article_id' => $articleId,
                    'author_id' => $authorId,
                ];
            }

            $this->parseMedias($article['media'], $articleId);

            foreach ($this->parseTags($article['tags']) as $tagId) {
                $this->articleTags[] = [
                    'id' => Str::uuid()->toString(),
                    'article_id' => $articleId,
                    'tag_id' => $tagId,
                ];
            }

            foreach ($this->parseSocials($article['social']) as $social) {
                $this->articleSocials[] = array_merge([
                    'id' => Str::uuid()->toString(),
                    'article_id' => $articleId,
                ], $social);
            }
        }
    }

    /**
     * @return void
     */
    private function storeData(): void
    {

        Article::query()
            ->upsert($this->articles, 'id');
        Category::query()
            ->upsert($this->categories, 'id');
        Author::query()
            ->upsert($this->authors, 'id');
        Media::query()
            ->upsert($this->medias, 'id');
        Tag::query()
            ->upsert($this->tags, 'id');
        Social::query()
            ->upsert($this->socials, 'id');
        Content::query()
            ->upsert($this->contents, 'id');

        ArticleAuthor::query()
            ->upsert($this->articleAuthors, 'id');
        ArticleCategory::query()
            ->upsert($this->articleCategories, 'id');
        ArticleTag::query()
            ->upsert($this->articleTags, 'id');
        ArticleSocial::query()
            ->upsert($this->articleSocials, 'id');
    }
}
