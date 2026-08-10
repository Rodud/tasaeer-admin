<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quote;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index(Request $request)
    {
        // الفترة الافتراضية: الشهر الحالي
        $startDate = $request->filled('from')
            ? Carbon::parse($request->from)->startOfDay()
            : Carbon::now()->startOfMonth();

        $endDate = $request->filled('to')
            ? Carbon::parse($request->to)->endOfDay()
            : Carbon::now()->endOfDay();

        // الطلبات ضمن الفترة المختارة
        $baseQuery = Quote::query()
            ->whereBetween('created_at', [$startDate, $endDate]);

        // إجمالي الطلبات
        $totalQuotes = (clone $baseQuery)->count();

        // الطلبات الجديدة
        $newQuotes = (clone $baseQuery)
            ->where('status', 'جديد')
            ->count();

         $pricingQuotes = Quote::where('status', 'قيد التسعير')->count();

        // الطلبات المؤكدة
        $confirmedQuotes = (clone $baseQuery)
            ->where('status', 'مؤكد')
            ->count();

        // إجمالي قيمة الطلبات المؤكدة
        $confirmedValue = (clone $baseQuery)
            ->where('status', 'مؤكد')
            ->sum('total');

        // البيانات اليومية للرسم البياني
        $dailyQuotes = collect();

        $currentDate = $startDate->copy()->startOfDay();

        while ($currentDate->lte($endDate)) {

            $date = $currentDate->copy();

            $dailyQuotes->push([
                'date' => $date->format('Y-m-d'),
                'label' => $date->format('d/m'),

                'count' => Quote::query()
                    ->whereDate('created_at', $date)
                    ->count(),
            ]);

            $currentDate->addDay();
        }

        return view('admin.dashboard', compact(
            'startDate',
            'endDate',
            'totalQuotes',
            'newQuotes',
            'pricingQuotes',
            'confirmedQuotes',
            'confirmedValue',
            'dailyQuotes'
        ));
    }
}