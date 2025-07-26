<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Announcement;
use Illuminate\Support\Facades\Auth;

class AnnouncementController extends Controller
{
    public function index(Request $request)
    {
        $query = Announcement::with(['admin']);

        // Filter by status
        if ($request->filled('status')) {
            if ($request->status === 'published') {
                $query->where('is_published', true);
            } elseif ($request->status === 'draft') {
                $query->where('is_published', false);
            }
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                    ->orWhere('content', 'LIKE', "%{$search}%");
            });
        }

        $announcements = $query->orderBy('created_at', 'desc')->paginate(15);

        // Stats
        $totalAnnouncements = Announcement::count();
        $publishedAnnouncements = Announcement::where('is_published', true)->count();
        $draftAnnouncements = Announcement::where('is_published', false)->count();

        return view('admin.announcements.index', compact(
            'announcements',
            'totalAnnouncements',
            'publishedAnnouncements',
            'draftAnnouncements'
        ));
    }

    public function create()
    {
        return view('admin.announcements.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'is_published' => 'boolean',
        ]);

        $announcement = Announcement::create([
            'admin_id' => Auth::id(),
            'title' => $request->title,
            'content' => $request->content,
            'is_published' => $request->boolean('is_published', false),
            'published_at' => $request->boolean('is_published', false) ? now() : null,
        ]);

        $message = $announcement->is_published
            ? 'Pengumuman berhasil dibuat dan dipublikasikan!'
            : 'Pengumuman berhasil disimpan sebagai draft!';

        return redirect()->route('admin.announcements.index')->with('success', $message);
    }

    public function show($id)
    {
        $announcement = Announcement::with(['admin'])->findOrFail($id);
        return view('admin.announcements.show', compact('announcement'));
    }

    public function edit($id)
    {
        $announcement = Announcement::findOrFail($id);
        return view('admin.announcements.edit', compact('announcement'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'is_published' => 'boolean',
        ]);

        $announcement = Announcement::findOrFail($id);

        $wasPublished = $announcement->is_published;
        $willBePublished = $request->boolean('is_published', false);

        $announcement->update([
            'title' => $request->title,
            'content' => $request->content,
            'is_published' => $willBePublished,
            'published_at' => $willBePublished && !$wasPublished ? now() : $announcement->published_at,
        ]);

        return redirect()->route('admin.announcements.index')
            ->with('success', 'Pengumuman berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $announcement = Announcement::findOrFail($id);
        $title = $announcement->title;
        $announcement->delete();

        return redirect()->route('admin.announcements.index')
            ->with('success', "Pengumuman \"{$title}\" berhasil dihapus!");
    }

    public function togglePublishStatus($id)
    {
        $announcement = Announcement::findOrFail($id);

        $announcement->update([
            'is_published' => !$announcement->is_published,
            'published_at' => !$announcement->is_published ? now() : $announcement->published_at,
        ]);

        $status = $announcement->is_published ? 'dipublikasikan' : 'dijadikan draft';

        return redirect()->route('admin.announcements.index')
            ->with('success', "Pengumuman berhasil {$status}!");
    }
}
