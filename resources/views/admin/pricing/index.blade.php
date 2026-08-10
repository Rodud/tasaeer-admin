@extends('layouts.app')

@section('content')

<!DOCTYPE html>
<html
    lang="{{ app()->getLocale() }}"
    dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}"
>

<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ __('destination_prices') }}</title>

    <link
        href="https://fonts.googleapis.com/css2?family=Cairo:wght@700;900&family=IBM+Plex+Sans+Arabic:wght@400;500;600&family=IBM+Plex+Mono:wght@500&display=swap"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
    >

    <style>

        :root {
            --v-700: #5F12A0;
            --v-500: #7818C0;
            --v-400: #9646D3;
            --v-200: #D7B8EE;
            --v-050: #F7F0FC;

            --surface-0: #FFFFFF;
            --surface-50: #F7F5FA;
            --line-200: #E6E2EC;

            --ink-300: #B7B2C2;
            --ink-400: #8A8497;
            --ink-500: #5B5468;
            --ink-900: #0E0A14;

            --success: #1E9E6A;
            --danger: #D23A3A;

            --r4: 20px;
            --pill: 999px;
        }


        * {
            box-sizing: border-box;
        }


        body {
            margin: 0;
            background: var(--surface-50);
            color: var(--ink-900);
            font-family: "IBM Plex Sans Arabic", system-ui, Tahoma, sans-serif;
            font-size: 15px;
        }


        h1 {
            font-family: "Cairo", sans-serif;
            font-weight: 900;
            font-size: 26px;
            margin: 0;
        }


        .top {
            background: var(--surface-0);
            border-bottom: 1px solid var(--line-200);
            padding: 20px 32px;
            display: flex;
            align-items: center;
            gap: 20px;
            flex-wrap: wrap;
        }


        .top .end {
            margin-inline-start: auto;
            display: flex;
            gap: 10px;
            align-items: center;
        }


        .wrap {
            padding: 28px 32px 80px;
        }


        .btn {
            background: var(--v-500);
            color: #fff;
            border: 0;
            border-radius: var(--pill);
            padding: 9px 20px;
            font-family: "Cairo", sans-serif;
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }


        .btn:hover {
            background: var(--v-700);
        }


        .btn.ghost {
            background: transparent;
            color: var(--v-500);
            border: 1.5px solid var(--v-200);
        }


        .btn.ghost:hover {
            background: var(--v-050);
        }


        /* Header */

        .page-intro {
            margin-bottom: 22px;
        }


        .page-intro p {
            margin: 6px 0 0;
            color: var(--ink-400);
            font-size: 14px;
        }


        /* Stats */

        .stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            margin-bottom: 24px;
        }


        .stat {
            background: var(--surface-0);
            border: 1px solid var(--line-200);
            border-radius: var(--r4);
            padding: 20px;
        }


        .stat .label {
            color: var(--ink-400);
            font-size: 13px;
            margin-bottom: 5px;
        }


        .stat .value {
            font-family: "Cairo", sans-serif;
            font-size: 28px;
            font-weight: 900;
            color: var(--v-500);
        }


        /* Search */

        .toolbar {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 18px;
            flex-wrap: wrap;
        }


        .search {
            flex: 1;
            min-width: 240px;
            position: relative;
        }


        .search i {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--ink-400);
        }


        .search input {
            width: 100%;
            height: 44px;
            border: 1.5px solid var(--line-200);
            border-radius: var(--pill);
            background: var(--surface-0);
            padding: 0 42px 0 16px;
            font-family: inherit;
            font-size: 14px;
            outline: none;
        }


        .search input:focus {
            border-color: var(--v-400);
            box-shadow: 0 0 0 4px var(--v-050);
        }


        /* Table */

        .table-card {
            background: var(--surface-0);
            border: 1px solid var(--line-200);
            border-radius: var(--r4);
            overflow: hidden;
        }


        .table-scroll {
            overflow-x: auto;
        }


        table {
            width: 100%;
            border-collapse: collapse;
        }


        th {
            text-align: start;
            font-size: 12px;
            font-weight: 600;
            color: var(--ink-400);
            padding: 15px 18px;
            background: var(--surface-50);
            border-bottom: 1px solid var(--line-200);
            white-space: nowrap;
        }


        td {
            padding: 15px 18px;
            border-bottom: 1px solid var(--line-200);
            font-size: 14px;
            vertical-align: middle;
        }


        tr:last-child td {
            border-bottom: 0;
        }


        tr:hover td {
            background: var(--v-050);
        }


        .route {
            font-weight: 600;
        }


        .route i {
            color: var(--v-400);
            margin: 0 6px;
        }


        .distance {
            color: var(--ink-500);
            font-variant-numeric: tabular-nums;
            white-space: nowrap;
        }


        .price-form {
            display: flex;
            align-items: center;
            gap: 8px;
        }


        .price-input {
            width: 130px;
            height: 40px;
            border: 1.5px solid var(--line-200);
            border-radius: 10px;
            padding: 0 12px;
            font-family: "IBM Plex Mono", monospace;
            font-size: 14px;
            direction: ltr;
            text-align: left;
            background: #fff;
        }


        .price-input:focus {
            border-color: var(--v-400);
            outline: none;
            box-shadow: 0 0 0 4px var(--v-050);
        }


        .save-btn {
            width: 40px;
            height: 40px;
            border: 0;
            border-radius: 10px;
            background: var(--v-500);
            color: #fff;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }


        .save-btn:hover {
            background: var(--v-700);
        }


        .firm {
            display: inline-block;
            border: 1px solid var(--success);
            color: var(--success);
            border-radius: var(--pill);
            padding: 4px 10px;
            font-size: 11.5px;
            font-weight: 600;
        }


        .calculated {
            display: inline-block;
            border: 1px solid var(--ink-300);
            color: var(--ink-500);
            border-radius: var(--pill);
            padding: 4px 10px;
            font-size: 11.5px;
        }


        .empty {
            text-align: center;
            padding: 70px 20px;
            color: var(--ink-400);
        }


        /* Pagination */

        .pagination-wrap {
            padding: 18px;
            border-top: 1px solid var(--line-200);
            display: flex;
            justify-content: center;
        }


        .pagination {
            display: flex;
            gap: 6px;
            align-items: center;
        }


        .pagination a,
        .pagination span {
            min-width: 38px;
            height: 38px;
            padding: 0 10px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            border: 1px solid var(--line-200);
            background: #fff;
            color: var(--ink-500);
            font-size: 13px;
        }


        .pagination .active span {
            background: var(--v-500);
            color: #fff;
            border-color: var(--v-500);
        }


        .pagination a:hover {
            background: var(--v-050);
            color: var(--v-500);
        }


        /* Success message */

        .alert {
            background: #EAF8F5;
            color: #00795F;
            border: 1px solid #9FDECF;
            border-radius: 12px;
            padding: 12px 16px;
            margin-bottom: 20px;
            font-size: 14px;
        }


        @media (max-width: 800px) {

            .stats {
                grid-template-columns: 1fr;
            }

            .top,
            .wrap {
                padding-inline: 16px;
            }

            .top .end {
                width: 100%;
                justify-content: flex-start;
            }

            .toolbar {
                align-items: stretch;
            }

            .search {
                min-width: 100%;
            }
        }

    </style>

</head>


<body>


<div class="top">

    <h1>
        {{ __('destination_prices') }}
    </h1>


    <div class="end">

        <a class="btn ghost" href="/admin">
            <i class="fa-solid fa-arrow-right"></i>
            {{ __('pricing_requests') }}
        </a>

    </div>

</div>


<div class="wrap">


    <div class="page-intro">

        <h2 style="font-family:Cairo,sans-serif;font-weight:900;margin:0;">
            {{ __('transport_pricing_management') }}
        </h2>


        <p>
            {{ __('pricing_management_description') }}
        </p>

    </div>


    @if(session('success'))

        <div class="alert">

            <i class="fa-solid fa-circle-check"></i>

            {{ session('success') }}

        </div>

    @endif


    <div class="stats">


        <div class="stat">

            <div class="label">
                {{ __('total_routes') }}
            </div>

            <div class="value">
                {{ $pricingLanes->total() }}
            </div>

        </div>


        <div class="stat">

            <div class="label">
                {{ __('displayed_routes') }}
            </div>

            <div class="value">
                {{ $pricingLanes->count() }}
            </div>

        </div>


        <div class="stat">

            <div class="label">
                {{ __('status') }}
            </div>

            <div class="value" style="font-size:20px;">

                {{ __('active') }}

            </div>

        </div>


    </div>


    <div class="toolbar">

        <div class="search">

            <i class="fa-solid fa-magnifying-glass"></i>

            <input
                type="search"
                id="routeSearch"
                placeholder="{{ __('search_city_or_destination') }}"
            >

        </div>

    </div>


    <div class="table-card">

        <div class="table-scroll">

            <table>

                <thead>

                <tr>

                    <th>{{ __('from') }}</th>

                    <th>{{ __('to') }}</th>

                    <th>{{ __('distance') }}</th>

                    <th>{{ __('current_price') }}</th>

                    <th>{{ __('price_type') }}</th>

                    <th>{{ __('edit') }}</th>

                </tr>

                </thead>


                <tbody id="pricingTable">


                @forelse($pricingLanes as $lane)


                    <tr>


                        <td class="route">

                            {{ $lane->origin }}

                        </td>


                        <td class="route">

                            <i class="fa-solid {{ app()->getLocale() === 'ar' ? 'fa-arrow-left' : 'fa-arrow-right' }}"></i>

                            {{ $lane->destination }}

                        </td>


                        <td class="distance">

                            {{ number_format($lane->distance_km) }}

                            {{ __('km') }}

                        </td>


                        <td>


                            <form
                                class="price-form"
                                method="POST"
                                action="{{ route('admin.pricing.update', $lane) }}"
                            >

                                @csrf

                                @method('PATCH')


                                <input
                                    class="price-input"
                                    type="number"
                                    name="price"
                                    value="{{ $lane->price }}"
                                    min="0"
                                    step="0.01"
                                    required
                                >


                                <button
                                    class="save-btn"
                                    type="submit"
                                    title="{{ __('save_price') }}"
                                >

                                    <i class="fa-solid fa-check"></i>

                                </button>


                            </form>


                        </td>


                        <td>


                            @if($lane->is_firm)

                                <span class="firm">
                                    {{ __('fixed_price') }}
                                </span>

                            @else

                                <span class="calculated">
                                    {{ __('editable') }}
                                </span>

                            @endif


                        </td>


                        <td>

                            <span class="muted">
                                {{ __('edit_price_only') }}
                            </span>

                        </td>


                    </tr>


                @empty


                    <tr>

                        <td colspan="6">

                            <div class="empty">

                                {{ __('no_pricing_routes') }}

                            </div>

                        </td>

                    </tr>


                @endforelse


                </tbody>

            </table>

        </div>


        @if($pricingLanes->hasPages())

            <div class="pagination-wrap">

                {{ $pricingLanes->links() }}

            </div>

        @endif


    </div>


</div>


<script>

    const searchInput = document.getElementById('routeSearch');

    searchInput.addEventListener('input', function () {

        const value = this.value.trim().toLowerCase();

        const rows = document.querySelectorAll('#pricingTable tr');

        rows.forEach(row => {

            const text = row.textContent.toLowerCase();

            row.style.display =
                text.includes(value) ? '' : 'none';

        });

    });

</script>


</body>

</html>

@endsection