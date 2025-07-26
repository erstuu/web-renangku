<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DataChangeRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DataChangeRequestController extends Controller
{
    public function index(Request $request)
    {
        $query = DataChangeRequest::with(['user']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by request type
        if ($request->filled('request_type')) {
            $query->where('request_type', $request->request_type);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('full_name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->orWhere('username', 'LIKE', "%{$search}%");
            });
        }

        // Sort
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'status':
                $query->orderBy('status', 'asc')->orderBy('created_at', 'desc');
                break;
            default: // latest
                $query->orderBy('created_at', 'desc');
        }

        $requests = $query->paginate(15);

        // Stats
        $totalRequests = DataChangeRequest::count();
        $pendingRequests = DataChangeRequest::where('status', 'pending')->count();
        $approvedRequests = DataChangeRequest::where('status', 'approved')->count();
        $rejectedRequests = DataChangeRequest::where('status', 'rejected')->count();

        // Handle AJAX request
        if ($request->ajax() || $request->get('ajax')) {
            $html = view('admin.data-change-requests._index_list', compact('requests'))->render();
            return response()->json(['html' => $html]);
        }

        return view('admin.data-change-requests.index', compact(
            'requests',
            'totalRequests',
            'pendingRequests',
            'approvedRequests',
            'rejectedRequests'
        ));
    }

    public function show($id)
    {
        $request = DataChangeRequest::with(['user'])->findOrFail($id);
        return view('admin.data-change-requests.show', compact('request'));
    }

    public function approve($id)
    {
        $changeRequest = DataChangeRequest::findOrFail($id);

        // Apply the changes to the user
        $user = $changeRequest->user;

        // Update user data based on request type
        if ($changeRequest->request_type === 'name' || $changeRequest->request_type === 'both') {
            $user->full_name = $changeRequest->requested_name;
        }

        if ($changeRequest->request_type === 'email' || $changeRequest->request_type === 'both') {
            $user->email = $changeRequest->requested_email;
        }

        $user->save();

        // Mark request as approved
        $changeRequest->update([
            'status' => 'approved',
            'reviewed_at' => now(),
            'reviewed_by' => Auth::id(),
        ]);

        return redirect()->route('admin.data-change-requests.index')
            ->with('success', 'Permintaan perubahan data berhasil disetujui dan diterapkan!');
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'admin_notes' => 'nullable|string|max:500'
        ]);

        $changeRequest = DataChangeRequest::findOrFail($id);

        $changeRequest->update([
            'status' => 'rejected',
            'admin_notes' => $request->admin_notes,
            'reviewed_at' => now(),
            'reviewed_by' => Auth::id(),
        ]);

        return redirect()->route('admin.data-change-requests.index')
            ->with('success', 'Permintaan perubahan data berhasil ditolak!');
    }
}
