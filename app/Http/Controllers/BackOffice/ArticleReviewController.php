<?php

namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ArticleReviewController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', Article::STATUS_PENDING);
        $allowed = [Article::STATUS_PENDING, Article::STATUS_APPROVED, Article::STATUS_REJECTED];
        if (!in_array($status, $allowed, true)) {
            $status = Article::STATUS_PENDING;
        }

        $articles = Article::with(['employer.user', 'reviewer'])
            ->where('status', $status)
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $counts = [
            Article::STATUS_PENDING  => Article::where('status', Article::STATUS_PENDING)->count(),
            Article::STATUS_APPROVED => Article::where('status', Article::STATUS_APPROVED)->count(),
            Article::STATUS_REJECTED => Article::where('status', Article::STATUS_REJECTED)->count(),
        ];

        return view('backoffice.article-review.index', compact('articles', 'status', 'counts'));
    }

    public function show(Article $article)
    {
        $article->load(['employer.user', 'reviewer']);
        return view('backoffice.article-review.show', compact('article'));
    }

    public function approve(Article $article)
    {
        if ($article->isApproved()) {
            return redirect()->route('backoffice.article-review.show', $article)
                ->with('info', 'Artikel ini sudah disetujui sebelumnya.');
        }

        $article->update([
            'status'       => Article::STATUS_APPROVED,
            'admin_note'   => null,
            'reviewed_by'  => Auth::id(),
            'reviewed_at'  => now(),
            'published_at' => $article->published_at ?? now(),
        ]);

        NotificationService::send(
            $article->employer->user_id,
            'article_approved',
            'Artikel Disetujui',
            "Artikel \"{$article->judul}\" telah disetujui dan tayang untuk publik.",
            route('employer.article.show', $article),
        );

        return redirect()->route('backoffice.article-review.index')
            ->with('success', 'Artikel disetujui dan tayang publik.');
    }

    public function reject(Request $request, Article $article)
    {
        if ($article->isRejected()) {
            return redirect()->route('backoffice.article-review.show', $article)
                ->with('info', 'Artikel ini sudah ditolak sebelumnya.');
        }

        $data = $request->validate([
            'admin_note' => 'required|string|max:1000',
        ], [
            'admin_note.required' => 'Catatan untuk employer wajib diisi.',
        ]);

        $article->update([
            'status'      => Article::STATUS_REJECTED,
            'admin_note'  => $data['admin_note'],
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
        ]);

        NotificationService::send(
            $article->employer->user_id,
            'article_rejected',
            'Artikel Ditolak',
            "Artikel \"{$article->judul}\" ditolak admin. Catatan: {$data['admin_note']}",
            route('employer.article.edit', $article),
        );

        return redirect()->route('backoffice.article-review.index')
            ->with('success', 'Artikel ditolak. Notifikasi terkirim ke employer.');
    }

    public function serveCover(Article $article)
    {
        if (!$article->cover_image) {
            abort(404);
        }
        return Storage::disk('public')->response($article->cover_image);
    }
}
