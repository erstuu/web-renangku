<?php

namespace App\Http\Controllers\Coach;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\DataChangeRequest;

class DataChangeRequestController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $requests = DataChangeRequest::where('user_id', $user->id)
            ->with('reviewer')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('coach.data-change-requests.index', compact('requests'));
    }

    public function create()
    {
        $user = Auth::user();

        // Check if there's already a pending request
        $pendingRequest = DataChangeRequest::where('user_id', $user->id)
            ->where('status', 'pending')
            ->first();

        if ($pendingRequest) {
            return redirect()->route('coach.data-change-requests.index')
                ->with('warning', 'Anda sudah memiliki permintaan perubahan data yang sedang diproses. Harap tunggu hingga selesai.');
        }

        return view('coach.data-change-requests.create', compact('user'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        // Debug: Log request data
        Log::info('DataChangeRequest store method called', [
            'user_id' => $user->id,
            'request_data' => $request->all()
        ]);

        // Check if there's already a pending request
        $pendingRequest = DataChangeRequest::where('user_id', $user->id)
            ->where('status', 'pending')
            ->first();

        if ($pendingRequest) {
            return redirect()->route('coach.data-change-requests.index')
                ->with('error', 'Anda sudah memiliki permintaan perubahan data yang sedang diproses.');
        }

        try {
            $validated = $request->validate([
                'request_type' => 'required|in:name,email,both',
                'requested_name' => 'required_if:request_type,name,both|nullable|string|max:255',
                'requested_email' => 'required_if:request_type,email,both|nullable|email|max:255|unique:users,email,' . $user->id,
                'reason' => 'required|string|min:10|max:1000',
            ], [
                'request_type.required' => 'Pilih jenis perubahan data.',
                'requested_name.required_if' => 'Nama baru harus diisi.',
                'requested_email.required_if' => 'Email baru harus diisi.',
                'requested_email.email' => 'Format email tidak valid.',
                'requested_email.unique' => 'Email sudah digunakan oleh pengguna lain.',
                'reason.required' => 'Alasan perubahan harus diisi.',
                'reason.min' => 'Alasan minimal 10 karakter.',
                'reason.max' => 'Alasan maksimal 1000 karakter.',
            ]);

            Log::info('Validation passed', $validated);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed', [
                'errors' => $e->errors()
            ]);
            throw $e;
        }

        // Prepare data
        $data = [
            'user_id' => $user->id,
            'request_type' => $validated['request_type'],
            'reason' => $validated['reason'],
            'status' => 'pending',
        ];

        // Set current and requested values based on request type
        if (in_array($validated['request_type'], ['name', 'both'])) {
            $data['current_name'] = $user->full_name;
            $data['requested_name'] = $validated['requested_name'];
        }

        if (in_array($validated['request_type'], ['email', 'both'])) {
            $data['current_email'] = $user->email;
            $data['requested_email'] = $validated['requested_email'];
        }

        Log::info('Creating DataChangeRequest', $data);

        $request_created = DataChangeRequest::create($data);

        Log::info('DataChangeRequest created successfully', ['id' => $request_created->id]);

        return redirect()->route('coach.data-change-requests.index')
            ->with('success', 'Permintaan perubahan data berhasil dikirim. Admin akan meninjau permintaan Anda.');
    }

    public function show(DataChangeRequest $dataChangeRequest)
    {
        // Ensure coach owns this request
        if ($dataChangeRequest->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }

        return view('coach.data-change-requests.show', compact('dataChangeRequest'));
    }
}
