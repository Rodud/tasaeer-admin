<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quote;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class QuoteController extends Controller
{
    /**
     * عرض صفحة الإدارة
     */
    public function index()
    {
        return view('admin.quotes');
    }

    /**
     * جلب جميع الطلبات
     */
    public function getQuotes()
    {
        return response()->json(
            Quote::latest()->get()
        );
    }

    /**
     * حفظ طلب جديد
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'company'      => 'nullable|string|max:255',
            'phone'        => 'required|string|max:50',
            'email'        => 'nullable|email|max:255',

            'origin'       => 'required|string|max:255',
            'destination'  => 'required|string|max:255',

            'truck_type'   => 'required|string|max:255',
            'cargo_type'   => 'required|string|max:255',
            'weight_band'  => 'required|string|max:255',

            'truck_count'  => 'required|integer|min:1',

            'load_date'    => 'nullable|date',
            'readiness'    => 'nullable|string|max:255',
            'notes'        => 'nullable|string',

            'subtotal'     => 'nullable|numeric',
            'vat'          => 'nullable|numeric',
            'total'        => 'nullable|numeric',

            'price_source' => 'nullable|string|max:255',
        ]);

        $validated['ref'] = 'Q-' . strtoupper(Str::random(8));

        $quote = Quote::create($validated);

        return response()->json($quote);
    }

    /**
     * تحديث حالة الطلب
     */
    public function updateStatus(Request $request, Quote $quote)
    {
        $request->validate([
            'status' => 'required',
        ]);

        $quote->update([
            'status' => $request->status,
        ]);

        return response()->json([
            'success' => true,
        ]);
    }

    /**
     * تصدير CSV
     */
    public function exportCsv()
    {
        $quotes = Quote::all();

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="quotes.csv"',
        ];

        $callback = function () use ($quotes) {

            $file = fopen('php://output', 'w');

            // دعم اللغة العربية في Excel
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($file, [
                'Reference',
                'Customer',
                'Phone',
                'Origin',
                'Destination',
                'Truck',
                'Total',
                'Status',
                'Created At',
            ]);

            foreach ($quotes as $quote) {

                fputcsv($file, [
                    $quote->ref,
                    $quote->name,
                    $quote->phone,
                    $quote->origin,
                    $quote->destination,
                    $quote->truck_type,
                    $quote->total,
                    $quote->status,
                    "'" . $quote->created_at->format('Y-m-d H:i'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}