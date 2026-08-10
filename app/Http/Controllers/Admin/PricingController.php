<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PricingLane;
use Illuminate\Http\Request;

class PricingController extends Controller
{
    /**
     * Display the pricing lanes.
     */
    public function index()
    {
        $pricingLanes = PricingLane::query()
            ->where('is_active', true)
            ->orderBy('origin')
            ->orderBy('destination')
            ->paginate(20);

        return view('admin.pricing.index', compact('pricingLanes'));
    }

    /**
     * Return complete pricing data for the public calculator.
     *
     * Static pricing configuration comes from config/pricing.php.
     * Pricing lanes come from the database so admin price changes
     * are reflected immediately on the public calculator.
     */
    /**
 * Return pricing configuration with latest lane prices from database.
 */
public function data()
{
    // البيانات الأساسية من pricing.php
    $pricing = config('pricing');

    // الأسعار الحالية من قاعدة البيانات
    $pricingLanes = PricingLane::query()
        ->where('is_active', true)
        ->get([
            'origin',
            'destination',
            'distance_km',
            'price',
            'is_firm',
        ]);

    // نستبدل lanes القديمة بالأسعار الموجودة في قاعدة البيانات
    $pricing['lanes'] = $pricingLanes->map(function ($lane) {
        return [
            'o' => $lane->origin,
            'd' => $lane->destination,
            'km' => (int) $lane->distance_km,
            'price' => (float) $lane->price,
            'firm' => (bool) $lane->is_firm,
        ];
    })->values()->all();

    return response()->json($pricing);
}

    /**
     * Update a pricing lane.
     */
    public function update(Request $request, PricingLane $pricingLane)
    {
        $validated = $request->validate([
            'price' => ['required', 'numeric', 'min:0'],
        ]);

        $pricingLane->update([
            'price' => $validated['price'],
        ]);

        return back()->with('success', 'تم تحديث السعر بنجاح.');
    }
}