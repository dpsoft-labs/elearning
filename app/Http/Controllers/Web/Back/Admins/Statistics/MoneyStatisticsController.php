<?php

namespace App\Http\Controllers\Web\Back\Admins\Statistics;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Shetabit\Visitor\Models\Visit;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use App\Models\Setting;
use Spatie\Analytics\Facades\Analytics;
use Spatie\Analytics\Period;
use App\Models\Invoice;

class MoneyStatisticsController extends Controller
{
    public function index(Request $request)
    {
        if (!Gate::allows('show money_statistics')) {
            return view('themes/default/back.permission-denied');
        }

        // إحصائيات عامة
        $totalRevenue = Invoice::where('status', 'paid')->sum('amount');
        $pendingPayments = Invoice::where('status', 'pending')->sum('amount');
        $failedPayments = Invoice::where('status', 'failed')->sum('amount');
        $refundedPayments = Invoice::where('status', 'refunded')->sum('amount');

        // إحصائيات الشهر الحالي
        $currentMonthRevenue = Invoice::where('status', 'paid')
            ->whereMonth('paid_at', now()->month)
            ->whereYear('paid_at', now()->year)
            ->sum('amount');

        // إحصائيات آخر 6 أشهر
        $monthlyRevenue = Invoice::where('status', 'paid')
            ->where('paid_at', '>=', now()->subMonths(6))
            ->selectRaw('MONTH(paid_at) as month, YEAR(paid_at) as year, SUM(amount) as total')
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        // إحصائيات طرق الدفع
        $paymentMethods = Invoice::where('status', 'paid')
            ->selectRaw('payment_method, COUNT(*) as count, SUM(amount) as total')
            ->groupBy('payment_method')
            ->get();

        return view('themes.default.back.admins.statistics.money.money-statistics', [
            'totalRevenue' => $totalRevenue,
            'pendingPayments' => $pendingPayments,
            'failedPayments' => $failedPayments,
            'refundedPayments' => $refundedPayments,
            'currentMonthRevenue' => $currentMonthRevenue,
            'monthlyRevenue' => $monthlyRevenue,
            'paymentMethods' => $paymentMethods
        ]);
    }
}