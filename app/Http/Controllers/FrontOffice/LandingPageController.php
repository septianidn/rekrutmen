<?php

namespace App\Http\Controllers\FrontOffice;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Job;

use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    /*
     * Dashboard Pages Routs
     */
    public function index(Request $request)
    {
        $assets = ['slider', 'wow'];
        return view('frontoffice.landing-page', compact('assets'));
    }

    public function vacancy(Request $request)
    {
        $jobs = Job::open()->with(['employer'])->latest()->paginate(9);
        return view('frontoffice.vacancy', compact('jobs'));
    }

    public function articleIndex(Request $request)
    {
        $kategori = trim((string) $request->query('kategori', ''));

        $query = Article::approved()
            ->with('employer')
            ->orderByDesc('published_at');

        if ($kategori !== '') {
            $query->where('kategori', $kategori);
        }

        $articles = $query->paginate(9)->withQueryString();

        $categories = Article::approved()
            ->whereNotNull('kategori')
            ->where('kategori', '!=', '')
            ->select('kategori')
            ->distinct()
            ->orderBy('kategori')
            ->pluck('kategori');

        return view('frontoffice.article.index', compact('articles', 'categories', 'kategori'));
    }

    public function articleShow(string $slug)
    {
        $article = Article::approved()
            ->with('employer')
            ->where('slug', $slug)
            ->firstOrFail();

        $related = Article::approved()
            ->with('employer')
            ->where('id', '!=', $article->id)
            ->when($article->kategori, fn ($q) => $q->where('kategori', $article->kategori))
            ->orderByDesc('published_at')
            ->limit(3)
            ->get();

        return view('frontoffice.article.show', compact('article', 'related'));
    }
}
