<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Article;

echo "=== CLEANING UP TEST ARTICLES ===\n\n";

$testArticles = Article::where('slug', 'LIKE', '%-1')
    ->orWhere('slug', 'LIKE', '%-2')
    ->orWhere('slug', 'LIKE', '%-3')
    ->get();

echo "Found " . $testArticles->count() . " test articles to delete:\n";
foreach ($testArticles as $article) {
    echo "- " . $article->title . " (slug: " . $article->slug . ")\n";
}

$deletedCount = 0;
foreach ($testArticles as $article) {
    $article->delete();
    $deletedCount++;
    echo "Deleted: " . $article->title . " (slug: " . $article->slug . ")\n";
}

echo "\n=== FINAL ARTICLES STATUS ===\n\n";

$articles = Article::all();
foreach ($articles as $article) {
    echo "- " . $article->title . "\n";
    echo "  Slug: " . $article->slug . "\n";
    echo "  Status: " . $article->status . "\n";
    echo "  Published: " . ($article->published_at ? $article->published_at->format('Y-m-d') : 'not set') . "\n";
    echo "  Category: " . $article->category . "\n";
    echo "  Featured: " . ($article->is_featured ? 'Yes' : 'No') . "\n\n";
}

echo "Total remaining articles: " . $articles->count() . "\n";
echo "Published articles: " . Article::published()->count() . "\n";
echo "Featured articles: " . Article::published()->featured()->count() . "\n";
echo "\n✅ Cleanup completed! Deleted $deletedCount test articles.\n";