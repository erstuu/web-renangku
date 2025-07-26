<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of announcements for members.
     */
    public function index()
    {
        $announcements = Announcement::with('admin')
            ->where('is_published', true)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('member.announcements.index', compact('announcements'));
    }

    /**
     * Display the specified announcement.
     */
    public function show($id)
    {
        $announcement = Announcement::with('admin')
            ->where('is_published', true)
            ->findOrFail($id);

        return view('member.announcements.show', compact('announcement'));
    }
}
