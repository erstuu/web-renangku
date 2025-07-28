<?php

namespace App\Http\Controllers\Coach;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\SessionRegistration;

class EarningsReportController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $month = $request->input('month', now()->month);
        $year = $request->input('year', now()->year);

        $registrations = SessionRegistration::whereHas('trainingSession', function ($q) use ($user) {
            $q->where('coach_id', $user->id);
        })
            ->where('payment_status', 'paid')
            ->whereMonth('registered_at', $month)
            ->whereYear('registered_at', $year)
            ->with('trainingSession')
            ->get();

        $total = $registrations->sum(function ($reg) {
            return $reg->trainingSession->price;
        });

        return view('coach.earnings.report', compact('registrations', 'total', 'month', 'year'));
    }

    public function print(Request $request)
    {
        $user = Auth::user();
        $month = $request->input('month', now()->month);
        $year = $request->input('year', now()->year);

        $registrations = SessionRegistration::whereHas('trainingSession', function ($q) use ($user) {
            $q->where('coach_id', $user->id);
        })
            ->where('payment_status', 'paid')
            ->whereMonth('registered_at', $month)
            ->whereYear('registered_at', $year)
            ->with('trainingSession')
            ->get();

        $total = $registrations->sum(function ($reg) {
            return $reg->trainingSession->price;
        });

        $pdf = app('dompdf.wrapper')->loadView('coach.earnings.report_pdf', compact('registrations', 'total', 'month', 'year'));
        return $pdf->download('laporan_pendapatan_' . $month . '_' . $year . '.pdf');
    }
}
