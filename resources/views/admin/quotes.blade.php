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

    <title>{{ __('pricing_requests') }}</title>

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

            --v-100: #ECDFF7;
            --v-050: #F7F0FC;

            --surface-0: #FFFFFF;
            --surface-50: #F7F5FA;
            --line-200: #E6E2EC;

            --ink-300: #B7B2C2;
            --ink-400: #8A8497;
            --ink-500: #5B5468;
            --ink-900: #0E0A14;

            --success: #1E9E6A;
            --warning: #C8821A;
            --danger: #D23A3A;
            --info: #2E6BD6;

            --r2: 10px;
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

        .filters {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }

        .filters button {
            background: var(--surface-0);
            border: 1.5px solid var(--line-200);
            border-radius: var(--pill);
            padding: 7px 16px;
            font-family: inherit;
            font-size: 13.5px;
            cursor: pointer;
            color: var(--ink-500);
        }

        .filters button[aria-pressed="true"] {
            background: var(--v-500);
            border-color: var(--v-500);
            color: #fff;
            font-weight: 600;
        }

        .kpis {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 16px;
            margin-bottom: 24px;
        }

        .kpi {
            background: var(--surface-0);
            border: 1px solid var(--line-200);
            border-radius: var(--r4);
            padding: 20px;
        }

        .kpi .l {
            font-size: 13px;
            color: var(--ink-400);
        }

        .kpi .v {
            font-family: "Cairo", sans-serif;
            font-weight: 900;
            font-size: 30px;
            color: var(--v-500);
            line-height: 1.2;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: var(--surface-0);
            border: 1px solid var(--line-200);
            border-radius: var(--r4);
            overflow: hidden;
        }

        th {
            text-align: start;
            font-size: 12px;
            font-weight: 600;
            color: var(--ink-400);
            padding: 14px 16px;
            background: var(--surface-50);
            border-bottom: 1px solid var(--line-200);
            white-space: nowrap;
        }

        td {
            padding: 14px 16px;
            border-bottom: 1px solid var(--line-200);
            font-size: 14px;
            vertical-align: top;
        }

        tr:last-child td {
            border-bottom: 0;
        }

        tr:hover td {
            background: var(--v-050);
        }

        .ref {
            font-family: "IBM Plex Mono", monospace;
            font-size: 12.5px;
            color: var(--v-500);
            direction: ltr;
        }

        .money {
            font-variant-numeric: tabular-nums;
            font-weight: 600;
            white-space: nowrap;
        }

        .ph {
            font-family: "IBM Plex Mono", monospace;
            font-size: 13px;
            direction: ltr;
            color: var(--ink-500);
        }

        select {
            font-family: inherit;
            font-size: 13px;
            border: 1.5px solid var(--line-200);
            border-radius: var(--pill);
            padding: 6px 12px;
            background: var(--surface-0);
            cursor: pointer;
        }

        .muted {
            color: var(--ink-400);
            font-size: 12.5px;
        }

        .badge {
            display: inline-block;
            border: 1.5px solid;
            border-radius: var(--pill);
            padding: 2px 10px;
            font-size: 11.5px;
            font-weight: 600;
        }

        .empty {
            text-align: center;
            padding: 64px 20px;
            color: var(--ink-400);
        }

        .note {
            font-size: 13px;
            color: var(--ink-500);
            max-width: 60ch;
            line-height: 1.7;
        }

        @media (max-width: 1200px) {
            .kpis {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 900px) {
            .kpis {
                grid-template-columns: repeat(2, 1fr);
            }

            .wrap,
            .top {
                padding-inline: 16px;
            }

            table {
                display: block;
                overflow-x: auto;
            }
        }
    </style>
</head>

<body>

    <div class="top">

        <h1>{{ __('pricing_requests') }}</h1>

        <div class="end">

            <a class="btn ghost" href="/quotes.csv">
                {{ __('export_csv') }}
            </a>

            <button class="btn" onclick="load()">
                {{ __('refresh') }}
            </button>

        </div>

    </div>


    <div class="wrap">

        <div class="kpis" id="kpis"></div>

        <div class="filters" id="filters"></div>

        <div id="table"></div>

        <p class="note" style="margin-top:20px">
            {{ __('saved_automatically') }}
            {{ __('export_includes_all_quotes') }}
        </p>

    </div>


    <script>

        /*
         * IMPORTANT:
         * The Arabic values below are the actual values stored in the database.
         * Do not translate/change them because they are used for filtering
         * and updating the quote status.
         */

        const STATUSES = [
            'جديد',
            'قيد التسعير',
            'أُرسل العرض',
            'مؤكد',
            'مرفوض'
        ];

        const STATUS_LABELS = {
            'جديد': @json(__('new')),
            'قيد التسعير': @json(__('pricing')),
            'أُرسل العرض': @json(__('quote_sent')),
            'مؤكد': @json(__('confirmed')),
            'مرفوض': @json(__('rejected'))
        };


        const COLORS = {
            'جديد': 'var(--info)',
            'قيد التسعير': 'var(--warning)',
            'أُرسل العرض': 'var(--v-500)',
            'مؤكد': 'var(--success)',
            'مرفوض': 'var(--danger)'
        };


        let ROWS = [];
        let FILTER = '';


        const fmt = n =>
            new Intl.NumberFormat(
                '{{ app()->getLocale() === "ar" ? "ar-SA" : "en-US" }}',
                {
                    maximumFractionDigits: 0
                }
            ).format(n || 0);


        const when = iso =>
            new Date(iso).toLocaleString(
                '{{ app()->getLocale() === "ar" ? "ar-SA" : "en-US" }}',
                {
                    day: '2-digit',
                    month: '2-digit',
                    year: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                }
            );


        async function load() {

            const r = await fetch('/quotes');

            if (!r.ok) {

                document.getElementById('table').innerHTML =
                    '<div class="empty">{{ __("failed_to_load_quotes") }}</div>';

                return;
            }

            ROWS = await r.json();

            render();
        }


        function render() {

            const shown = FILTER
                ? ROWS.filter(r => r.status === FILTER)
                : ROWS;


            document.getElementById('filters').innerHTML = [

                [
                    '',
                    @json(__('all'))
                ],

                ...STATUSES.map(s => [
                    s,
                    STATUS_LABELS[s]
                ])

            ].map(([v, l]) =>

                `<button
                    aria-pressed="${FILTER === v}"
                    onclick="FILTER='${v}';render()"
                >
                    ${l}
                </button>`

            ).join('');


            if (!shown.length) {

                document.getElementById('table').innerHTML =
                    '<div class="empty">{{ __("no_quotes") }}</div>';

                return;
            }


            document.getElementById('table').innerHTML = `

                <table>

                    <thead>

                        <tr>

                            <th>{{ __('reference') }}</th>

                            <th>{{ __('date') }}</th>

                            <th>{{ __('customer') }}</th>

                            <th>{{ __('trip') }}</th>

                            <th>{{ __('truck') }}</th>

                            <th>{{ __('total_and_price_source') }}</th>

                            <th>{{ __('status') }}</th>

                        </tr>

                    </thead>


                    <tbody>

                        ${shown.map(r => `

                            <tr>

                                <td>
                                    <span class="ref">
                                        ${r.ref}
                                    </span>
                                </td>


                                <td class="muted">
                                    ${when(r.created_at)}
                                </td>


                                <td>

                                    <div style="font-weight:600">
                                        ${esc(r.name)}
                                    </div>

                                    ${
                                        r.company
                                            ? `<div class="muted">${esc(r.company)}</div>`
                                            : ''
                                    }

                                    <div class="ph">
                                        ${esc(r.phone)}
                                    </div>

                                    ${
                                        r.email
                                            ? `<div class="muted">${esc(r.email)}</div>`
                                            : ''
                                    }

                                </td>


                                <td>

                                    <div>
                                        ${esc(r.origin)}
                                        ←
                                        ${esc(r.destination)}
                                    </div>


                                    <div class="muted">

                                        ${esc(r.scope || '')}

                                        ${
                                            r.crossing
                                                ? ` · {{ __("gate") }} ${esc(r.crossing)}`
                                                : ''
                                        }

                                        ·
                                        ${fmt(r.distance_km)}
                                        {{ __("km") }}

                                    </div>


                                    <div class="muted">

                                        ${esc(r.load_date || '')}

                                        ${
                                            r.readiness
                                                ? ` · ${esc(r.readiness)}`
                                                : ''
                                        }

                                    </div>


                                    ${
                                        r.notes
                                            ? `<div class="muted">📝 ${esc(r.notes)}</div>`
                                            : ''
                                    }

                                </td>


                                <td>

                                    <div>
                                        ${esc(r.truck_type)}
                                    </div>


                                    <div class="muted">

                                        {{ __("count") }}
                                        ${fmt(r.truck_count)}

                                        ·
                                        ${esc(r.weight_band || '')}

                                        ·
                                        ${esc(r.cargo_type || '')}

                                    </div>


                                    ${
                                        r.multiplier && r.multiplier !== 1
                                            ? `
                                                <div class="muted">
                                                    {{ __("multiplier") }}
                                                    ×${(+r.multiplier).toFixed(2)}
                                                </div>
                                              `
                                            : ''
                                    }

                                </td>


                                <td class="money">

                                    ${fmt(r.total)}

                                    <div
                                        class="muted"
                                        style="font-weight:400"
                                    >
                                        {{ __("before_tax") }}
                                        ${fmt(r.subtotal)}
                                    </div>

                                    ${src(r)}

                                </td>


                                <td>

                                    <select
                                        onchange="setStatus(${r.id}, this.value)"
                                        style="
                                            border-color:${COLORS[r.status]};
                                            color:${COLORS[r.status]};
                                            font-weight:600
                                        "
                                    >

                                        ${STATUSES.map(s => `
                                            <option
                                                value="${s}"
                                                ${s === r.status ? 'selected' : ''}
                                            >
                                                ${STATUS_LABELS[s]}
                                            </option>
                                        `).join('')}

                                    </select>

                                </td>

                            </tr>

                        `).join('')}

                    </tbody>

                </table>

            `;
        }


        const SRC = {

            'عرض ناقل': [
                @json(__('confirmed_carrier_offer')),
                'var(--success)'
            ],

            'جدولكم': [
                @json(__('from_routes_table')),
                'var(--info)'
            ],

            'حساب': [
                @json(__('calculated_by_formula')),
                'var(--warning)'
            ]

        };


        function src(r) {

            const c =
                SRC[r.price_source] ||
                [
                    @json(__('unpriced')),
                    'var(--danger)'
                ];


            const detail =

                r.price_source === 'جدولكم'
                    ? `${fmt(r.trips_in_history)} {{ __("previous_trip_on_route") }}`

                : r.price_source === 'حساب'
                    ? `{{ __("range") }} ${fmt(r.price_low)}–${fmt(r.price_high)} — {{ __("needs_confirmation") }}`

                : r.price_source === 'عرض ناقل'
                    ? '{{ __("fixed_carrier_price") }}'

                : '{{ __("outside_automatic_pricing_range") }}';


            return `

                <div style="margin-top:6px">

                    <span
                        class="badge"
                        style="
                            border-color:${c[1]};
                            color:${c[1]}
                        "
                    >
                        ${c[0]}
                    </span>

                    <div
                        class="muted"
                        style="font-weight:400"
                    >
                        ${detail}
                    </div>

                </div>

            `;
        }


        function esc(s) {

            return String(s ?? '').replace(
                /[&<>"']/g,
                c => ({
                    '&': '&amp;',
                    '<': '&lt;',
                    '>': '&gt;',
                    '"': '&quot;',
                    "'": '&#39;'
                }[c])
            );

        }


        async function setStatus(id, status) {

            await fetch('/quotes/' + id, {

                method: 'PATCH',

                headers: {
                    'Content-Type': 'application/json'
                },

                body: JSON.stringify({
                    status
                })

            });


            const row = ROWS.find(r => r.id === id);

            if (row) {
                row.status = status;
            }

            render();
        }


        load();

    </script>

</body>
</html>

@endsection