<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $employer = Auth::user()->employer;
        abort_unless($employer, 403);

        $status = $request->query('status', 'all');
        $allowed = ['all', Article::STATUS_PENDING, Article::STATUS_APPROVED, Article::STATUS_REJECTED];
        if (!in_array($status, $allowed, true)) {
            $status = 'all';
        }

        $query = $employer->articles()->latest();
        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $articles = $query->paginate(10)->withQueryString();

        $counts = [
            'all'      => $employer->articles()->count(),
            'pending'  => $employer->articles()->where('status', Article::STATUS_PENDING)->count(),
            'approved' => $employer->articles()->where('status', Article::STATUS_APPROVED)->count(),
            'rejected' => $employer->articles()->where('status', Article::STATUS_REJECTED)->count(),
        ];

        return view('frontoffice.employer.article.index', compact('articles', 'status', 'counts'));
    }

    public function create()
    {
        $employer = Auth::user()->employer;
        abort_unless($employer, 403);

        if (!$employer->canPostArticle()) {
            return redirect()->route('employer.membership.index')
                ->with('error', 'Anda perlu membership dengan akses artikel atau status mitra kerja untuk memublikasikan artikel.');
        }

        return view('frontoffice.employer.article.create', [
            'article' => new Article(),
        ]);
    }

    public function store(Request $request)
    {
        $employer = Auth::user()->employer;
        abort_unless($employer, 403);

        if (!$employer->canPostArticle()) {
            return redirect()->route('employer.membership.index')
                ->with('error', 'Anda perlu membership dengan akses artikel atau status mitra kerja untuk memublikasikan artikel.');
        }

        $data = $this->validatedData($request);

        $coverPath = null;
        if ($request->hasFile('cover_image')) {
            $coverPath = $request->file('cover_image')->store('articles/covers', 'public');
        }

        $article = Article::create([
            'employer_id' => $employer->id,
            'judul'       => $data['judul'],
            'slug'        => Article::generateUniqueSlug($data['judul']),
            'isi'         => $data['isi'],
            'kategori'    => $data['kategori'] ?? null,
            'cover_image' => $coverPath,
            'status'      => Article::STATUS_PENDING,
        ]);

        return redirect()->route('employer.article.show', $article)
            ->with('success', 'Artikel dikirim untuk ditinjau admin. Anda akan diberitahu setelah ada keputusan.');
    }

    public function show(Article $article)
    {
        $this->authorizeOwn($article);

        return view('frontoffice.employer.article.show', compact('article'));
    }

    public function edit(Article $article)
    {
        $this->authorizeOwn($article);

        return view('frontoffice.employer.article.edit', compact('article'));
    }

    public function update(Request $request, Article $article)
    {
        $this->authorizeOwn($article);

        $data = $this->validatedData($request);

        $updates = [
            'judul'    => $data['judul'],
            'isi'      => $data['isi'],
            'kategori' => $data['kategori'] ?? null,
        ];

        if ($request->hasFile('cover_image')) {
            if ($article->cover_image) {
                Storage::disk('public')->delete($article->cover_image);
            }
            $updates['cover_image'] = $request->file('cover_image')->store('articles/covers', 'public');
        }

        // Editing an approved article reverts it to pending — public copy disappears
        // until admin re-approves. Mirrors the employer change-request safety pattern.
        if ($article->isApproved()) {
            $updates['status']       = Article::STATUS_PENDING;
            $updates['reviewed_by']  = null;
            $updates['reviewed_at']  = null;
            $updates['admin_note']   = null;
            $flash = 'Artikel diperbarui dan dikirim ulang untuk ditinjau admin.';
        } elseif ($article->isRejected()) {
            // Resubmission after rejection: clear note, reset to pending
            $updates['status']       = Article::STATUS_PENDING;
            $updates['reviewed_by']  = null;
            $updates['reviewed_at']  = null;
            $updates['admin_note']   = null;
            $flash = 'Artikel diperbarui dan dikirim ulang untuk ditinjau admin.';
        } else {
            $flash = 'Artikel diperbarui.';
        }

        $article->update($updates);

        return redirect()->route('employer.article.show', $article)->with('success', $flash);
    }

    public function destroy(Article $article)
    {
        $this->authorizeOwn($article);

        if ($article->cover_image) {
            Storage::disk('public')->delete($article->cover_image);
        }
        $article->delete();

        return redirect()->route('employer.article.index')
            ->with('success', 'Artikel dihapus.');
    }

    public function serveCover(Article $article)
    {
        $this->authorizeOwn($article);

        if (!$article->cover_image) {
            abort(404);
        }
        return Storage::disk('public')->response($article->cover_image);
    }

    protected function authorizeOwn(Article $article): void
    {
        $employer = Auth::user()->employer;
        if (!$employer || $article->employer_id !== $employer->id) {
            abort(403);
        }
    }

    protected function validatedData(Request $request): array
    {
        return $request->validate([
            'judul'       => 'required|string|max:150',
            'isi'         => 'required|string|min:50',
            'kategori'    => 'nullable|string|max:50',
            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'judul.required'    => 'Judul artikel wajib diisi.',
            'judul.max'         => 'Judul maksimal 150 karakter.',
            'isi.required'      => 'Isi artikel wajib diisi.',
            'isi.min'           => 'Isi artikel minimal 50 karakter.',
            'cover_image.image' => 'Cover harus berupa gambar.',
            'cover_image.mimes' => 'Cover harus berformat JPG, PNG, atau WEBP.',
            'cover_image.max'   => 'Cover maksimal 2MB.',
        ]);
    }
}
