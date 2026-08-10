@extends('layouts.app')

@section('content')
<style>
  :root {
      --v-700: #5F12A0;
      --v-500: #7818C0;
      --v-400: #9646D3;
      --v-200: #D7B8EE;
      --v-100: #ECDFF7;
      --v-050: #F7F0FC;

      --s-500: #00AC8A;
      --s-100: #D5F1EA;

      --surface-0: #FFFFFF;
      --surface-50: #F7F5FA;
      --line: #E6E2EC;

      --ink-400: #8A8497;
      --ink-500: #5B5468;
      --ink-700: #2B2333;
      --ink-900: #0E0A14;

      --success: #1E9E6A;
      --warning: #C8821A;

      --r4: 20px;

      --sh1:
          0 1px 2px rgba(14,10,20,.04),
          0 1px 3px rgba(14,10,20,.05);

      --sh2:
          0 6px 20px rgba(14,10,20,.09);
  }

  .dashboard-page {
      background: var(--surface-50);
      min-height: calc(100vh - 65px);
      padding: 36px 32px 70px;
      font-family: "Tajawal", "Cairo", sans-serif;
      color: var(--ink-900);
  }

  .dashboard-container {
      max-width: 1320px;
      margin: 0 auto;
  }

  /* Header */

  .dashboard-heading {
      display: flex;
      align-items: flex-end;
      justify-content: space-between;
      gap: 20px;
      margin-bottom: 28px;
  }

  .dashboard-heading h1 {
      margin: 0;
      font-size: 34px;
      font-weight: 800;
      color: var(--ink-900);
      line-height: 1.3;
  }

  .dashboard-heading p {
      margin: 8px 0 0;
      color: var(--ink-500);
      font-size: 15px;
  }

  .dashboard-date {
      background: #fff;
      border: 1px solid var(--line);
      border-radius: 999px;
      padding: 9px 16px;
      color: var(--ink-500);
      font-size: 13px;
      white-space: nowrap;
      box-shadow: var(--sh1);
  }

  /* Welcome */

  .welcome-card {
      position: relative;
      overflow: hidden;
      background:
          linear-gradient(
              135deg,
              var(--v-700),
              var(--v-500)
          );
      border-radius: var(--r4);
      padding: 30px 32px;
      margin-bottom: 24px;
      box-shadow: var(--sh2);
      color: #fff;
  }

  .welcome-card::after {
      content: "";
      position: absolute;
      width: 220px;
      height: 220px;
      border-radius: 50%;
      background: rgba(255,255,255,.08);
      top: -90px;
      inset-inline-end: -50px;
  }

  .welcome-card::before {
      content: "";
      position: absolute;
      width: 140px;
      height: 140px;
      border-radius: 50%;
      background: rgba(255,255,255,.05);
      bottom: -80px;
      inset-inline-start: 35%;
  }

  .welcome-content {
      position: relative;
      z-index: 1;
  }

  .welcome-card h2 {
      margin: 0;
      font-size: 25px;
      font-weight: 800;
  }

  .welcome-card p {
      margin: 8px 0 0;
      font-size: 15px;
      color: rgba(255,255,255,.82);
  }

  /* Statistics */

  .stats-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 18px;
      margin-bottom: 24px;
  }

  .stat-card {
      background: var(--surface-0);
      border: 1px solid var(--line);
      border-radius: var(--r4);
      padding: 22px;
      box-shadow: var(--sh1);
      position: relative;
      overflow: hidden;
      transition: .2s ease;
  }

  .stat-card:hover {
      transform: translateY(-2px);
      box-shadow: var(--sh2);
  }

  .stat-top {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 12px;
  }

  .stat-label {
      color: var(--ink-500);
      font-size: 14px;
      font-weight: 600;
  }

  .stat-icon {
      width: 42px;
      height: 42px;
      border-radius: 12px;
      background: var(--v-050);
      color: var(--v-500);
      display: grid;
      place-items: center;
      flex: 0 0 auto;
  }

  .stat-icon svg {
      width: 20px;
      height: 20px;
      stroke: currentColor;
      fill: none;
      stroke-width: 1.8;
      stroke-linecap: round;
      stroke-linejoin: round;
  }

  .stat-value {
      margin-top: 16px;
      font-size: 32px;
      line-height: 1;
      font-weight: 800;
      color: var(--v-700);
  }

  .stat-card.success .stat-icon {
      background: var(--s-100);
      color: var(--s-500);
  }

  .stat-card.success .stat-value {
      color: var(--success);
  }

  .stat-card.warning .stat-icon {
      background: #FFF5E5;
      color: var(--warning);
  }

  .stat-card.warning .stat-value {
      color: var(--warning);
  }

  /* Main grid */

  .dashboard-grid {
      display: grid;
      grid-template-columns: 1.55fr 1fr;
      gap: 24px;
      margin-bottom: 24px;
  }

  .dashboard-card {
      background: var(--surface-0);
      border: 1px solid var(--line);
      border-radius: var(--r4);
      box-shadow: var(--sh1);
      overflow: hidden;
  }

  .card-header {
      padding: 22px 24px 18px;
      border-bottom: 1px solid var(--line);
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 15px;
  }

  .card-header h3 {
      margin: 0;
      font-size: 19px;
      font-weight: 800;
      color: var(--ink-900);
  }

  .card-header p {
      margin: 4px 0 0;
      color: var(--ink-400);
      font-size: 13px;
  }

  .card-body {
      padding: 24px;
  }

  /* Last 7 days */

  .days-list {
      display: flex;
      flex-direction: column;
      gap: 16px;
  }

  .day-row {
      display: grid;
      grid-template-columns: 55px 1fr 35px;
      align-items: center;
      gap: 12px;
  }

  .day-label {
      color: var(--ink-500);
      font-size: 13px;
      font-weight: 600;
  }

  .day-bar-wrapper {
      height: 10px;
      background: var(--v-050);
      border-radius: 999px;
      overflow: hidden;
  }

  .day-bar {
      height: 100%;
      min-width: 3px;
      background: linear-gradient(
          90deg,
          var(--v-400),
          var(--v-500)
      );
      border-radius: 999px;
      transition: width .4s ease;
  }

  .day-count {
      color: var(--v-700);
      font-size: 14px;
      font-weight: 800;
      text-align: end;
  }

  /* Confirmed value */

  .value-card-body {
      padding: 28px 24px;
  }

  .value-label {
      color: var(--ink-500);
      font-size: 14px;
      font-weight: 600;
  }

  .confirmed-value {
      margin-top: 12px;
      font-size: 38px;
      line-height: 1.1;
      font-weight: 800;
      color: var(--v-700);
  }

  .currency {
      font-size: 17px;
      color: var(--v-400);
      margin-inline-start: 6px;
  }

  .value-divider {
      height: 1px;
      background: var(--line);
      margin: 24px 0;
  }

  .mini-stat {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 15px;
      padding: 12px 0;
  }

  .mini-stat + .mini-stat {
      border-top: 1px solid var(--line);
  }

  .mini-stat-label {
      color: var(--ink-500);
      font-size: 14px;
  }

  .mini-stat-value {
      font-size: 17px;
      font-weight: 800;
      color: var(--ink-900);
  }

  /* Quick links */

  .quick-links {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 14px;
  }

  .quick-link {
      display: flex;
      align-items: center;
      gap: 14px;
      padding: 17px;
      border: 1px solid var(--line);
      border-radius: 14px;
      text-decoration: none;
      color: var(--ink-900);
      background: #fff;
      transition: .2s ease;
  }

  .quick-link:hover {
      border-color: var(--v-200);
      background: var(--v-050);
      transform: translateY(-2px);
  }

  .quick-icon {
      width: 42px;
      height: 42px;
      border-radius: 12px;
      background: var(--v-050);
      color: var(--v-500);
      display: grid;
      place-items: center;
      flex: 0 0 auto;
  }

  .quick-icon svg {
      width: 19px;
      height: 19px;
      stroke: currentColor;
      fill: none;
      stroke-width: 1.8;
      stroke-linecap: round;
      stroke-linejoin: round;
  }

  .quick-link strong {
      display: block;
      font-size: 14px;
      font-weight: 800;
  }

  .quick-link span {
      display: block;
      margin-top: 2px;
      font-size: 12px;
      color: var(--ink-400);
  }
  .dashboard-filter {
    background: #fff;
    border: 1px solid #e9dff3;
    border-radius: 18px;
    padding: 18px 22px;
    margin-bottom: 24px;
    box-shadow: 0 4px 15px rgba(88, 28, 135, 0.05);
}

.filter-form {
    display: flex;
    align-items: end;
    gap: 16px;
    flex-wrap: wrap;
}

.filter-field {
    display: flex;
    flex-direction: column;
    gap: 7px;
}

.filter-field label {
    font-size: 13px;
    color: #6b7280;
}

.filter-field input {
    height: 42px;
    min-width: 180px;
    padding: 0 12px;
    border: 1px solid #ddd6e8;
    border-radius: 10px;
    background: #fff;
    color: #374151;
}

.filter-button {
    height: 42px;
    padding: 0 24px;
    border: none;
    border-radius: 10px;
    background: #7e22ce;
    color: #fff;
    font-weight: 600;
    cursor: pointer;
}

.filter-button:hover {
    background: #6b21a8;
}

.filter-reset {
    height: 42px;
    display: inline-flex;
    align-items: center;
    padding: 0 18px;
    border: 1px solid #ddd6e8;
    border-radius: 10px;
    color: #7e22ce;
    text-decoration: none;
    font-size: 14px;
}

  /* Responsive */

  @media (max-width: 1100px) {
      .stats-grid {
          grid-template-columns: repeat(2, 1fr);
      }

      .dashboard-grid {
          grid-template-columns: 1fr;
      }
  }

  @media (max-width: 640px) {
      .dashboard-page {
          padding: 24px 16px 50px;
      }

      .dashboard-heading {
          align-items: flex-start;
          flex-direction: column;
      }

      .dashboard-heading h1 {
          font-size: 28px;
      }

      .dashboard-date {
          display: none;
      }

      .welcome-card {
          padding: 24px;
      }

      .stats-grid {
          grid-template-columns: 1fr;
      }

      .quick-links {
          grid-template-columns: 1fr;
      }

      .day-row {
          grid-template-columns: 48px 1fr 28px;
      }
  }

  /* Quotes Chart */

.chart-card {
    width: 100%;
}

.chart-container {
    position: relative;
    height: 380px;
    padding: 20px 24px 24px;
}
</style>


<div class="dashboard-page" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

  <div class="dashboard-container">

      {{-- Page Heading --}}
      <div class="dashboard-heading">

          <div>
              <h1>
                  {{ app()->getLocale() === 'ar' ? 'لوحة التحكم' : 'Dashboard' }}
              </h1>

              <p>
                  {{ app()->getLocale() === 'ar'
                      ? 'نظرة سريعة على طلبات التسعير وأداء المنصة.'
                      : 'A quick overview of your pricing requests.' }}
              </p>
          </div>
      </div>


      {{-- Welcome --}}
      <div class="welcome-card">

          <div class="welcome-content">

              <h2>
                  {{ app()->getLocale() === 'ar'
                      ? 'مرحباً بك في لوحة التحكم '
                      : 'Welcome back ' }}
              </h2>

              <p>
                  {{ app()->getLocale() === 'ar'
                      ? 'تابع طلبات التسعير وحالاتها وقيمتها من مكان واحد.'
                      : "Here's an overview of your pricing requests." }}
              </p>

          </div>

      </div>

      <!-- Date Filter -->
<div class="dashboard-filter">
  <form method="GET" action="{{ route('dashboard') }}" class="filter-form">

      <div class="filter-field">
          <label for="from">
              {{ app()->getLocale() === 'ar'
                  ? 'من تاريخ'
                  : 'From Date' }}
          </label>

          <input
              type="date"
              id="from"
              name="from"
              value="{{ request('from', $startDate->format('Y-m-d')) }}"
          >
      </div>

      <div class="filter-field">
          <label for="to">
             {{ app()->getLocale() === 'ar'
                  ? 'إلى تاريخ'
                  : 'To Date' }}
          </label>

          <input
              type="date"
              id="to"
              name="to"
              value="{{ request('to', $endDate->format('Y-m-d')) }}"
          >
      </div>

      <button type="submit" class="filter-button">
         {{ app()->getLocale() === 'ar'
              ? 'تصفية'
              : 'Filter' }}
      </button>

      <a href="{{ route('dashboard') }}" class="filter-reset">
         {{ app()->getLocale() === 'ar'
              ? 'إعادة تعيين'
              : 'Reset' }}
      </a>

  </form>
</div>


      {{-- Statistics --}}
      <div class="stats-grid">

          {{-- Total --}}
          <div class="stat-card">

              <div class="stat-top">

                  <span class="stat-label">
                      {{ app()->getLocale() === 'ar'
                          ? 'إجمالي الطلبات'
                          : 'Total Quotes' }}
                  </span>

                  <div class="stat-icon">
                      <svg viewBox="0 0 24 24">
                          <path d="M8 6h13"/>
                          <path d="M8 12h13"/>
                          <path d="M8 18h13"/>
                          <path d="M3 6h.01"/>
                          <path d="M3 12h.01"/>
                          <path d="M3 18h.01"/>
                      </svg>
                  </div>

              </div>

              <div class="stat-value">
                  {{ $totalQuotes }}
              </div>

          </div>


          {{-- Today --}}
          {{-- <div class="stat-card">

              <div class="stat-top">

                  <span class="stat-label">
                      {{ app()->getLocale() === 'ar'
                          ? 'طلبات اليوم'
                          : "Today's Quotes" }}
                  </span>

                  <div class="stat-icon">
                      <svg viewBox="0 0 24 24">
                          <rect x="3" y="4" width="18" height="17" rx="2"/>
                          <path d="M16 2v4"/>
                          <path d="M8 2v4"/>
                          <path d="M3 10h18"/>
                      </svg>
                  </div>

              </div>

              <div class="stat-value">
                  {{$dailyQuotes}}
              </div>

          </div> --}}


          {{-- New --}}
          <div class="stat-card warning">

              <div class="stat-top">

                  <span class="stat-label">
                      {{ app()->getLocale() === 'ar'
                          ? 'طلبات جديدة'
                          : 'New Quotes' }}
                  </span>

                  <div class="stat-icon">
                      <svg viewBox="0 0 24 24">
                          <path d="M12 5v14"/>
                          <path d="M5 12h14"/>
                      </svg>
                  </div>

              </div>

              <div class="stat-value">
                  {{ $newQuotes }}
              </div>

          </div>


          {{-- Pricing --}}
        <div class="stat-card warning">

          <div class="stat-top">

              <span class="stat-label">
                  {{ app()->getLocale() === 'ar'
                      ? 'قيد التسعير'
                      : 'Pricing' }}
              </span>

              <div class="stat-icon">
                  <svg viewBox="0 0 24 24">
                      <path d="M12 2v20"/>
                      <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                  </svg>
              </div>

          </div>

          <div class="stat-value">
              {{ $pricingQuotes }}
          </div>

        </div>


          {{-- Confirmed --}}
          <div class="stat-card success">

              <div class="stat-top">

                  <span class="stat-label">
                      {{ app()->getLocale() === 'ar'
                          ? 'طلبات مؤكدة'
                          : 'Confirmed' }}
                  </span>

                  <div class="stat-icon">
                      <svg viewBox="0 0 24 24">
                          <path d="m5 12 4 4L19 6"/>
                      </svg>
                  </div>

              </div>

              <div class="stat-value">
                  {{ $confirmedQuotes }}
              </div>

          </div>

      </div>


      {{-- Main Dashboard Grid --}}
      <div class="dashboard-grid">

      <!-- Quotes Chart -->
<div class="dashboard-card chart-card">

  <div class="card-header">
      <div>
          <h3>
              {{ app()->getLocale() === 'ar'
                  ? 'الطلبات حسب الفترة'
                  : 'Quotes by Period' }}
          </h3>

          <p>
              {{ app()->getLocale() === 'ar'
                  ? 'عدد الطلبات المستلمة يومياً'
                  : 'Number of quotes received per day' }}
          </p>
      </div>
  </div>

  <div class="chart-container">
      <canvas id="quotesChart"></canvas>
  </div>

</div>

          {{-- <div class="bar-chart">

            @php
                $maxCount = collect($dailyQuotes)->max('count') ?: 1;
            @endphp
        
            @foreach($dailyQuotes as $day)
                <div class="bar-item">
        
                    <div class="bar-value">
                        {{ $day['count'] }}
                    </div>
        
                    <div class="bar-wrapper">
                        <div
                            class="bar"
                            style="height: {{ ($day['count'] / $maxCount) * 100 }}%;"
                        ></div>
                    </div>
        
                    <div class="bar-label">
                        {{ $day['label'] }}
                    </div>
        
                </div>
            @endforeach
        
        </div> --}}


          {{-- Confirmed Value --}}
          <div class="dashboard-card">

              <div class="card-header">

                  <div>
                      <h3>
                          {{ app()->getLocale() === 'ar'
                              ? 'القيمة المؤكدة'
                              : 'Confirmed Value' }}
                      </h3>

                      <p>
                          {{ app()->getLocale() === 'ar'
                              ? 'إجمالي قيمة الطلبات المؤكدة'
                              : 'Total value of confirmed quotes' }}
                      </p>
                  </div>

              </div>


              <div class="value-card-body">

                  <div class="value-label">
                      {{ app()->getLocale() === 'ar'
                          ? 'إجمالي القيمة'
                          : 'Total Value' }}
                  </div>

                  <div class="confirmed-value">
                      {{ number_format($confirmedValue, 2) }}

                      <span class="currency">
                          SAR
                      </span>
                  </div>


                  <div class="value-divider"></div>


                  <div class="mini-stat">

                    <span class="mini-stat-label">
                      {{ app()->getLocale() === 'ar'
                          ? 'قيد التسعير'
                          : 'Pricing' }}
                  </span>
                  
                  <span class="mini-stat-value">
                      {{ $pricingQuotes }}
                  </span>

                  </div>


                  <div class="mini-stat">

                      <span class="mini-stat-label">
                          {{ app()->getLocale() === 'ar'
                              ? 'طلبات مؤكدة'
                              : 'Confirmed Quotes' }}
                      </span>

                      <span class="mini-stat-value">
                          {{ $confirmedQuotes }}
                      </span>

                  </div>

              </div>

          </div>

      </div>

  </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const dailyQuotes = @json($dailyQuotes);

    const labels = dailyQuotes.map(day => day.label);
    const data = dailyQuotes.map(day => day.count);

    const ctx = document.getElementById('quotesChart');

    new Chart(ctx, {
        type: 'bar',

        data: {
            labels: labels,

            datasets: [{
                label: '{{ app()->getLocale() === "ar" ? "عدد الطلبات" : "Quotes" }}',
                data: data,

                backgroundColor: '#8b2bd9',
                borderRadius: 6,

                barThickness: 28,

                borderSkipped: false
            }]
        },

        options: {
            responsive: true,

            maintainAspectRatio: false,

            plugins: {
                legend: {
                    display: false
                },

                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return ' ' + context.parsed.y;
                        }
                    }
                }
            },

            scales: {

                x: {
                    title: {
                        display: true,
                        text: '{{ app()->getLocale() === "ar" ? "التاريخ" : "Date" }}'
                    },

                    grid: {
                        display: false
                    }
                },

                y: {
                    beginAtZero: true,

                    ticks: {
                        precision: 0,
                        stepSize: 1
                    },

                    title: {
                        display: true,
                        text: '{{ app()->getLocale() === "ar" ? "عدد الطلبات" : "Number of Quotes" }}'
                    },

                    grid: {
                        color: '#eee'
                    }
                }
            }
        }
    });
</script>
@endsection