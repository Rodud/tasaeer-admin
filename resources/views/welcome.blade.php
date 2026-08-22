<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
<link rel="stylesheet" href="https://unpkg.com/aos@2.3.4/dist/aos.css">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>{{ __('بوابة النقل للخدمات اللوجستية') }}</title>
<meta name="description" content="{{ __('احسب تكلفة شحنتك داخل المملكة وإلى دول الجوار، واطلب عرض سعر مباشرة.') }}">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;800&display=swap" rel="stylesheet">


<style>
:root{
  --v-700:#5F12A0; --v-500:#7818C0; --v-400:#9646D3;
  --v-200:#D7B8EE; --v-100:#ECDFF7; --v-050:#F7F0FC;
  --s-700:#00795F; --s-500:#00AC8A; --s-400:#3FC0A5;
  --s-200:#9FDECF; --s-100:#D5F1EA; --s-050:#EAF8F5;
  --surface-0:#FFFFFF; --surface-50:#F7F5FA; --line:#E6E2EC;
  --ink-300:#B7B2C2; --ink-400:#8A8497; --ink-500:#5B5468;
  --ink-700:#2B2333; --ink-900:#0E0A14;
  --success:#1E9E6A; --warning:#C8821A; --danger:#D23A3A;
  --r2:10px; --r4:20px; --pill:999px;
  --sh1:0 1px 2px rgba(14,10,20,.04), 0 1px 3px rgba(14,10,20,.05);
  --sh2:0 6px 20px rgba(14,10,20,.09);
}
*{box-sizing:border-box}
html,body{margin:0;padding:0;width:100%;
    overflow-x:hidden;}
    body{
    background:var(--surface-50);
    color:var(--ink-900);
    font-family:"IBM Plex Sans Arabic",system-ui,Tahoma,sans-serif;
    font-size:16px;
    line-height:1.75;
    -webkit-font-smoothing:antialiased
}
h1,h2,h3{
    font-family:"Tajawal",sans-serif;
    font-weight:800;
    margin:0;
    line-height:1.28
}
a{color:var(--v-700);text-decoration:none}
:focus-visible{outline:2px solid var(--v-500);outline-offset:3px;border-radius:4px}
.wrap{
    max-width:1320px;
    margin:0 auto;
    padding:0 32px;
}

/* الشريط العلوي */
.top{background:var(--surface-0);border-bottom:1px solid var(--line);position:sticky;top:0;z-index:30}
.top-in{
    max-width:1320px;
    margin:0 auto;
    padding:8px 32px;
    display:flex;
    align-items:center;
}
.lockup{display:flex;align-items:center;gap:16px}
.lockup .logo{
    height:40px;
    width:auto;
}
.lockup .sep{width:2px;height:36px;border-radius:1px;
  background:linear-gradient(to bottom, var(--v-500) 50%, var(--s-500) 50%)}
  .top .end{
    margin-inline-start:auto;
    display:flex;
    align-items:center;
    gap:14px;
    position:relative;
}
.tel{font-family:"IBM Plex Mono",monospace;font-size:14px;color:var(--ink-500);direction:ltr}
.btn{background:var(--v-500);color:#fff;border:0;border-radius:var(--pill);padding:11px 24px;
  font-family:"Cairo",sans-serif;font-weight:700;font-size:15px;cursor:pointer;text-decoration:none;
  display:inline-block;text-align:center}
.btn:hover{background:var(--v-700)}
.btn[disabled]{background:var(--ink-300);cursor:not-allowed}
.btn.ghost{background:transparent;color:var(--v-500);border:1.5px solid var(--v-200)}
.btn.ghost:hover{background:var(--v-050)}

/* الواجهة */
.hero{
    background:
        linear-gradient(
          rgba(106,27,154,.30),
          rgba(123,31,162,.35)
        ),
        url('/images/truk.png');

    background-size:cover;
    background-position: left 65%;
    background-repeat: no-repeat;
}
.hero-in{
    max-width:1320px;
    margin:0 auto;
    padding: 70px 32px 70px;
}

.eyebrow{
    display:none;
}

.hero h1{
    font-size:44px;
    max-width:16ch;
    letter-spacing:-.02em;
    color:#fff;
}

.hero .rule{
    width:90px;
    height:4px;
    margin:18px 0;
}

.hero p{
    font-size:17px;
    max-width:52ch;
    color:#fff;
}

.hero .tags{
    display:flex;
    gap:36px;
    flex-wrap:wrap;
    margin-top:32px;
}

.hero .tags span{
    display:flex;
    align-items:center;
    gap:8px;
    color:#fff;
    font-size:15px;
    font-weight:500;

}

.hero .tags i{
    color:#fffcfc;
    font-size:18px;
    width:auto;
    height:auto;
    background:none;

}

/* الترحيب */
.welcome{max-width:1320px;margin:0 auto;padding:32px 32px 0}
.welcome .card{background:var(--surface-0);border:1px solid var(--line);border-inline-start:4px solid var(--s-500);
  border-radius:var(--r4);padding:24px 28px;box-shadow:var(--sh1)}
.welcome p{margin:0;font-size:16px;color:var(--ink-700)}
.welcome p + p{margin-top:10px}

/* الشبكة */
.grid{display:grid;grid-template-columns:1fr 400px;gap:30px;align-items:start;padding:32px 0 88px}
.card{background:var(--surface-0);border:1px solid var(--line);border-radius:var(--r4);box-shadow:var(--sh1)}
.card-h{padding:24px 28px 14px}
.card-h h2{font-size:22px}
.card-h p{margin:6px 0 0;font-size:14px;color:var(--ink-400)}

/* النموذج */
form{margin:0}
.fields{padding:8px 28px 30px;display:grid;grid-template-columns:repeat(2,1fr);gap:20px 24px}
.divider{grid-column:span 2;border-top:1px solid var(--line);margin:8px 0 0;padding-top:24px}
.divider h2{font-size:22px;font-family:"Cairo",sans-serif;font-weight:900}
.f{display:flex;flex-direction:column;gap:8px;min-width:0}
.f.full{grid-column:span 2}
label{font-size:13px;font-weight:600;color:var(--ink-500)}
label .req{color:var(--danger)}
input,select,textarea{font-family:inherit;font-size:16px;color:var(--ink-900);
  border:1.5px solid var(--line);border-radius:var(--r2);padding:12px 14px;background:var(--surface-0);width:100%}
input[type=number]{font-family:"IBM Plex Mono",monospace;direction:ltr;text-align:right}
input:focus,select:focus,textarea:focus{border-color:var(--v-500);outline:none;box-shadow:0 0 0 4px var(--v-050)}
select{appearance:none;background-image:linear-gradient(45deg,transparent 50%,var(--ink-400) 50%),linear-gradient(135deg,var(--ink-400) 50%,transparent 50%);
  background-position:16px 22px,21px 22px;background-size:5px 5px;background-repeat:no-repeat;padding-inline-start:36px}
optgroup{font-family:"Cairo",sans-serif;font-weight:700;color:var(--ink-500)}
textarea{resize:vertical;line-height:1.7}
.hintline{font-size:11.5px;color:var(--ink-400);margin-top:-2px}

/* بطاقة العرض */
.quote{position:sticky;top:92px}
.qcard{background:var(--surface-0);border:1px solid var(--line);border-radius:var(--r4);box-shadow:var(--sh2);overflow:hidden}
.qcard .strip{height:5px;background:linear-gradient(to left, var(--v-500) 50%, var(--s-500) 50%)}
.qhead{padding:20px 24px 18px;border-bottom:1px solid var(--line)}
.qtop{display:flex;align-items:center;justify-content:space-between;gap:12px;margin-bottom:16px}
.qtop img{height:26px}
.scope{display:inline-block;border-radius:var(--pill);padding:5px 14px;font-family:"Cairo",sans-serif;
  font-weight:700;font-size:12.5px;background:var(--v-050);color:var(--v-700)}
.scope.intl{background:var(--s-050);color:var(--s-700)}
.lane{display:flex;align-items:flex-start;gap:14px}
.icon-sq{width:44px;height:44px;border-radius:var(--r2);background:var(--v-050);display:grid;place-items:center;flex:0 0 auto;color:var(--v-500)}
.icon-sq svg{width:22px;height:22px;stroke:currentColor;stroke-width:1.5;fill:none;stroke-linecap:round;stroke-linejoin:round}
.lane .t{font-family:"Cairo",sans-serif;font-weight:700;font-size:17px;line-height:1.35}
.lane .s{font-size:13px;color:var(--ink-400);line-height:1.55}

.qrows{padding:8px 24px}
.qr{display:flex;justify-content:space-between;gap:16px;padding:11px 0;border-bottom:1px solid var(--line);font-size:14.5px}
.qr:last-child{border-bottom:0}
.qr .l{color:var(--ink-500)}
.qr .v{font-variant-numeric:tabular-nums;white-space:nowrap;font-weight:500}

.qtotal{background:var(--v-050);margin:8px 16px 16px;border-radius:var(--r2);padding:18px 20px}
.qtotal .lbl{font-size:13px;color:var(--ink-500);font-weight:600}
.qtotal .big{font-family:"Cairo",sans-serif;font-weight:900;font-size:36px;color:var(--v-500);
  line-height:1.15;margin-top:4px;font-variant-numeric:tabular-nums}
.qtotal .big .cur{font-size:16px;color:var(--v-400);margin-inline-start:8px}
.qtotal .cap{font-size:12.5px;color:var(--ink-400);margin-top:2px}
.qtotal.err .big{font-size:19px;color:var(--danger);line-height:1.5}

/* شرح السعر — الشفافية التي كانت في ملف إكسل */
.why{background:var(--surface-50);border-top:1px solid var(--line);padding:18px 24px}
.why b{font-family:"Cairo",sans-serif;font-weight:700;font-size:13.5px;display:block;margin-bottom:10px}
.why ul{margin:0;padding:0;list-style:none}
.why li{font-size:13.5px;color:var(--ink-500);margin:7px 0;line-height:1.6;
  padding-inline-start:20px;position:relative}
.why li::before{content:"";position:absolute;inset-inline-start:0;top:8px;
  width:7px;height:7px;border-radius:50%;background:var(--v-200)}

.qactions{padding:18px 24px 24px}
.qactions .btn{width:100%;padding:14px}
.qactions .btn.ghost{margin-top:10px}
.qnote{font-size:12.5px;color:var(--ink-400);margin:14px 0 0;line-height:1.65}

/* الخطوات والأسئلة */
.steps{display:grid;grid-template-columns:repeat(3,1fr);gap:24px;padding-bottom:84px}
.step{background:var(--surface-0);border:1px solid var(--line);border-radius:var(--r4);padding:28px}
.step .n{font-family:"IBM Plex Mono",monospace;font-size:13px;color:var(--v-400);font-weight:500}
.step h3{font-size:19px;margin:12px 0 8px}
.step p{margin:0;font-size:14.5px;color:var(--ink-500)}
.faq{padding-bottom:84px}
.faq h2{
    font-size:38px;
    margin-bottom:28px;
    color:var(--ink-900);
}
details{background:var(--surface-0);border:1px solid var(--line);border-radius:var(--r2);margin-bottom:12px;padding:18px 24px}
details[open]{border-color:var(--v-200)}
summary{cursor:pointer;font-family:"Cairo",sans-serif;font-weight:700;font-size:16px;list-style:none;display:flex;justify-content:space-between;gap:16px}
summary::-webkit-details-marker{display:none}
summary::after{content:"+";color:var(--v-500);font-family:"IBM Plex Mono",monospace}
details[open] summary::after{content:"–"}
details p{margin:14px 0 0;font-size:15px;color:var(--ink-500)}

footer{background:var(--ink-900);color:var(--ink-300)}
.ft{max-width:1180px;margin:0 auto;padding:52px 32px;display:grid;grid-template-columns:repeat(3,1fr);gap:32px;font-size:14px}
.ft-logos{
    display:flex;
    align-items:center;
    gap:14px;
    background:transparent;
    padding:0;
    border-radius:0;
    width:auto;
}
.ft-logos img.togoo{height:24px} .ft-logos img.seda{height:34px}
.ft-logos .sep{width:2px;height:28px;border-radius:1px;background:linear-gradient(to bottom, var(--v-500) 50%, var(--s-500) 50%)}
.ft b{color:#fff;font-family:"Cairo",sans-serif;font-weight:700;display:block;margin-bottom:10px;font-size:14px}
.ft a{color:var(--s-200)}
.ft-base{border-top:1px solid rgba(255,255,255,.09);padding:20px 32px;max-width:1180px;margin:0 auto;
  display:flex;justify-content:space-between;font-size:12.5px;color:var(--ink-500);gap:16px;flex-wrap:wrap}

.toast{position:fixed;bottom:26px;left:50%;transform:translateX(-50%) translateY(18px);background:var(--ink-900);
  color:#fff;padding:13px 26px;border-radius:var(--pill);font-size:15px;opacity:0;pointer-events:none;transition:.22s;z-index:90}
.toast.show{opacity:1;transform:translateX(-50%) translateY(0)}

@media (max-width:1040px){
  .grid{grid-template-columns:1fr} .quote{position:static}
  .hero h1{font-size:38px} .steps{grid-template-columns:1fr} .ft{grid-template-columns:1fr;gap:28px}
}
@media (max-width:640px){
  .wrap,.top-in,.hero-in,.welcome,.ft{padding-inline:20px}
  .fields{grid-template-columns:1fr;padding-inline:20px}
  .f.full,.divider{grid-column:span 1}
  .hero h1{font-size:29px} .hero p{font-size:17px ;color: #f0f2f5}
  .faq h2{font-size:28px} .qtotal .big{font-size:30px}
  .lockup img.seda{height:34px} .lockup img.togoo{height:24px}
}
@media (prefers-reduced-motion:reduce){*{transition:none !important}}

input[type="date"]::-webkit-date-and-time-value{
    text-align:center;
}

@media (max-width: 640px) {
    html[dir="rtl"] input[type="date"] {
        padding-right: 40px;
    }

    html[dir="ltr"] input[type="date"] {
        padding-left: 40px;
    }
}
.ft-logos .logo{
    height:42px;
    width:auto;
}

.brand-title{
    font-family:"Cairo",sans-serif;
    font-size:22px;
    font-weight:800;
    color: #1F2937;
    margin:0;
    line-height:1.1;
}

.brand-subtitle{
    font-size:13px;
    color:#1F2937;
    margin-top:2px;
    line-height:1;
}
.brand{
    display:flex;
    flex-direction:column;
    gap:0;
    line-height:1.1;
}

.money-value {
    display: inline-flex;
    align-items: center;
    gap: 5px;
}

.riyal-icon {
    width: 18px;
    height: 18px;
    object-fit: contain;
    vertical-align: middle;
}
.mobile-menu-btn,
.mobile-menu {
    display: none;
  
}

@media (max-width: 768px) {
  .top-in {
    position: relative;
}

    .desktop-actions {
        display: none !important;
    }

    .mobile-menu-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 42px;
        height: 42px;
        border: 1px solid var(--v-200);
        border-radius: 12px;
        background: #fff;
        color: var(--v-700);
        font-size: 22px;
        cursor: pointer;
    }

    .mobile-menu {
    position: absolute;
    top: calc(100% + 8px);
    inset-inline-end: 0;
    inset-inline-start: auto;
    width: 190px;
    padding: 10px;
    background: #fff;
    border: 1px solid var(--v-200);
    border-radius: 14px;
    box-shadow: var(--sh-2);
    z-index: 1000;
}


    .mobile-menu.open {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .mobile-menu a {
        display: block;
        padding: 12px 14px;
        border-radius: 10px;
        color: var(--ink-900);
        text-decoration: none;
        font-weight: 700;
    }

    .mobile-menu a:hover {
        background: var(--v-050);
    }
}

@media (max-width: 640px) {
    input[type="date"] {
        position: relative;
    }

    html[dir="rtl"] input[type="date"] {
        padding-right: 40px;
    }

    html[dir="ltr"] input[type="date"] {
        padding-left: 40px;
    }

    html[dir="rtl"] input[type="date"]::-webkit-calendar-picker-indicator {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
    }

    html[dir="ltr"] input[type="date"]::-webkit-calendar-picker-indicator {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
    }
}
html[dir="rtl"] input[type="number"] {
    text-align: right;
}

html[dir="ltr"] input[type="number"] {
    text-align: left;
}
.hero h1 {

    color: #fff !important;
}

</style>
</head>
<body>

<div id="fatal" style="display:none;background:#FDF1F0;border-bottom:3px solid #D23A3A;
     color:#8A2620;padding:18px 32px;font-size:15px;line-height:1.8"></div>

<header class="top">
  <div class="top-in">
    <div class="lockup">
      <img class="logo" src="{{ asset('images/rodud-logo.jpeg') }}" alt="Rodud Logistics">

      <div class="brand">
          <div class="brand-title">Rodud Logistics</div>
          <div class="brand-subtitle">Pricing Portal</div>
      </div>
  </div>
    <div class="end">
      <div class="desktop-actions">
   
    
        <a id="waTop" href="#" target="_blank" rel="noopener">
            <button class="btn" type="button" data-i18n="تواصل معنا">
                {{ __('تواصل معنا') }}
            </button>
        </a>
    
        <button
            class="btn ghost"
            type="button"
            onclick="window.location='{{ route('locale', app()->getLocale() === 'ar' ? 'en' : 'ar') }}'">
            {{ app()->getLocale() === 'ar' ? 'EN' : 'العربية' }}
        </button>
    </div>
    
    <button class="mobile-menu-btn" type="button" onclick="toggleMobileMenu()">
        ☰
    </button>
    
    <div class="mobile-menu" id="mobileMenu">
        <a id="waMobile" href="#" target="_blank" rel="noopener">
            {{ __('تواصل معنا') }}
        </a>
    
        <a href="{{ route('locale', app()->getLocale() === 'ar' ? 'en' : 'ar') }}">
            {{ app()->getLocale() === 'ar' ? 'EN' : 'العربية' }}
        </a>
    </div>
    </div>
  </div>
</header>

<section class="hero" data-aos="fade-down">
  <div class="hero-in">
    <div class="eyebrow" data-i18n="حصري لعملاء هيئة تنمية الصادرات السعودية">{{ __('حصري لعملاء هيئة تنمية الصادرات السعودية') }}</div>
    <h1 data-i18n="حلول نقل تدعم نمو صادراتك">{{ __('حلول نقل تدعم نمو صادراتك') }}</h1>
    <div class="rule"></div>
    <p><span data-i18n="حلول نقل بري موثوقة تربط منتجاتك بالأسواق داخل المملكة ودول الخليج والأردن، بتسعير واضح وخطوات سهلة.">
        {{ __('حلول نقل بري موثوقة تربط منتجاتك بالأسواق داخل المملكة ودول الخليج والأردن، بتسعير واضح وخطوات سهلة.') }}
    </span>
      <div class="tags">

        <span>
          <i class="fa-solid fa-map-location-dot"></i>
            <b id="tagCities">0</b> <span data-i18n="مدينة">{{ __('مدينة') }}</span>
        </span>

        <span>
            <i class="fa-solid fa-earth-asia"></i>
            <b id="tagCountries">0</b> <span data-i18n="دول">{{ __('دول') }}</span>
        </span>

        <span>
            <i class="fa-solid fa-bolt"></i>
            <span data-i18n="تسعير فوري">{{ __('تسعير فوري') }}</span>
        </span>

    </div>
  </div>
</section>

<div class="welcome">
  <div class="card" data-aos="fade-right">
   <p data-i18n="منصة Rodud Logistics تساعدك في احتساب تكلفة الشحن بسرعة وسهولة، مع إمكانية إرسال طلبك مباشرة لفريقنا للحصول على عرض سعر رسمي.">{{ __('منصة Rodud Logistics تساعدك في احتساب تكلفة الشحن بسرعة وسهولة، مع إمكانية إرسال طلبك مباشرة لفريقنا للحصول على عرض سعر رسمي.') }}</p>
  </div>
</div>

<div class="wrap">
  <div class="grid">

    <form class="card" onsubmit="return false">
      <div class="card-h">
        <h2 data-i18n="احسب تكلفة الشحن">{{ __('احسب تكلفة الشحن') }}</h2>
        <p data-i18n="اختر الوجهة والشاحنة — السعر يظهر مباشرة.">{{ __('اختر الوجهة والشاحنة — السعر يظهر مباشرة.') }}</p>
      </div>
      <div class="fields">
        <div class="f"><label for="from" data-i18n="مكان التحميل">{{ __('مكان التحميل') }}</label><select id="from"></select></div>
        <div class="f"><label for="to" data-i18n="مكان التفريغ">{{ __('مكان التفريغ') }}</label><select id="to"></select></div>
        <div class="f"><label for="truck" data-i18n="نوع الشاحنة">{{ __('نوع الشاحنة') }}</label><select id="truck"></select></div>
        <div class="f"><label for="cargo" data-i18n="نوع البضاعة">{{ __('نوع البضاعة') }}</label><select id="cargo"></select></div>
        <div class="f"><label for="weight" data-i18n="وزن الحمولة">{{ __('وزن الحمولة') }}</label><select id="weight"></select></div>
        <div class="f"><label for="count" data-i18n="عدد الشاحنات">{{ __('عدد الشاحنات') }}</label><input type="number" id="count" value="1" min="1" max="50" step="1"></div>
        <div class="f"><label for="date" data-i18n="تاريخ التحميل">{{ __('تاريخ التحميل') }}</label><input type="date" id="date"></div>
        <div class="f"><label for="ready" data-i18n="جاهزية الشحنة">{{ __('جاهزية الشحنة') }}</label>
          <select id="ready">
            <option value="جاهزة الآن" data-i18n="جاهزة الآن">{{ __('جاهزة الآن') }}</option>
            <option value="خلال أسبوع" data-i18n="خلال أسبوع">{{ __('خلال أسبوع') }}</option>
            <option value="لم تتحدد بعد" data-i18n="لم تتحدد بعد">{{ __('لم تتحدد بعد') }}</option>
          </select></div>

        <div class="divider"><h2 data-i18n="بيانات المصدّر">{{ __('بيانات المصدّر') }}</h2></div>
        <div class="f"><label for="name"><span data-i18n="الاسم">{{ __('الاسم') }}</span> <span class="req">*</span></label><input type="text" id="name" autocomplete="name"></div>
        <div class="f"><label for="phone"><span data-i18n="رقم الجوال">{{ __('رقم الجوال') }}</span> <span class="req">*</span></label><input type="tel" id="phone" inputmode="tel" placeholder="05XXXXXXXX" autocomplete="tel"></div>
        <div class="f"><label for="company" data-i18n="اسم المنشأة">{{ __('اسم المنشأة') }}</label><input type="text" id="company" autocomplete="organization"></div>
        <div class="f"><label for="email" data-i18n="البريد الإلكتروني">{{ __('البريد الإلكتروني') }}</label><input type="email" id="email" autocomplete="email"></div>
        <div class="f full"><label for="notes" data-i18n="تفاصيل إضافية">{{ __('تفاصيل إضافية') }}</label><textarea id="notes" rows="3" placeholder="{{ __('طبيعة البضاعة، متطلبات التحميل، أي تفاصيل تساعد الفريق…') }}" data-i18n-placeholder="طبيعة البضاعة، متطلبات التحميل، أي تفاصيل تساعد الفريق…"></textarea></div>
        <input type="text" id="website" tabindex="-1" autocomplete="off" aria-hidden="true" style="display:none">
      </div>
    </form>

    <div class="quote">
      <div class="qcard">
        <div class="strip"></div>
        <div class="qhead">
          <div class="qtop">
          <span class="scope" id="scopeTag">—</span>
          </div>
          <div class="lane">
            <div class="icon-sq">
              <svg viewBox="0 0 24 24"><path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"/><path d="M15 18H9"/><path d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.624l-3.48-4.35A1 1 0 0 0 17.52 8H14"/><circle cx="17" cy="18" r="2"/><circle cx="7" cy="18" r="2"/></svg>
            </div>
            <div>
              <div class="t" id="lane">—</div>
              <div class="s" id="meta">—</div>
            </div>
          </div>
        </div>

        <div class="qrows" id="rows"></div>

        <div class="qtotal" id="totalBox">
          <div class="lbl" id="totalLbl">{{ __('الإجمالي شامل الضريبة') }}</div>
          <div class="big" id="total">—</div>
          <div class="cap" id="totalCap"></div>
        </div>

        <div class="why">
          <b>{{ __('السعر يشمل') }}</b>
          <ul id="inclList">
            <li>{{ __('النقل البري من موقع التحميل إلى موقع التفريغ') }}</li>
            <li>{{ __('متابعة الشحنة حتى التسليم') }}</li>
            <li>{{ __('فاتورة ضريبية معتمدة') }}</li>
          </ul>
        </div>

        <div class="qactions">
          <button class="btn" id="send" onclick="send('wa')" disabled>{{ __('أرسل الطلب') }}</button>
          <button class="btn ghost" onclick="send('copy')">{{ __('انسخ التفاصيل') }}</button>
          <p class="qnote" id="qnote">{{ __('اكتب اسمك وجوالك ليتواصل معك الفريق.') }}</p>
        </div>
      </div>
    </div>
  </div>

  <section class="steps">
    <div class="step"><div class="n">01</div><h3>{{ __('ترسل الطلب') }}</h3><p>{{ __('يصلنا بنفس التفاصيل والسعر الذي ظهر لك — دون إعادة شرح.') }}</p></div>
    <div class="step"><div class="n">02</div><h3>{{ __('نؤكد العرض') }}</h3><p>{{ __('فريق متخصص يراجع الوجهة وطبيعة الشحنة ويعود إليك بعرض نهائي مكتوب.') }}</p></div>
    <div class="step"><div class="n">03</div><h3>{{ __('تنطلق الشحنة') }}</h3><p>{{ __('نوفّر الناقل المناسب ونتابع الرحلة حتى التسليم.') }}</p></div>
  </section>

  <section class="faq">
    <h2>{{ __('أسئلة متكررة') }}</h2>
    <details><summary>{{ __('هل السعر نهائي؟') }}</summary><p>{{ __('لا. السعر تقديري وغير ملزم. يُعتمد بعد مراجعة تفاصيل الشحنة وموقعي التحميل والتفريغ.') }}</p></details>
    <details><summary>{{ __('هل تشملون الشحن خارج المملكة؟') }}</summary><p>{{ __('نعم — النقل البري إلى دول الجوار عبر المنافذ الحدودية. الحاسبة تختار أقصر مسار وتعرض المنفذ المستخدم. الشحن البحري والجوي يحتاج عرضًا خاصًا من الفريق.') }}</p></details>
    <details><summary>{{ __('كيف تتم الفوترة؟') }}</summary><p>{{ __('تصدر فاتورة ضريبية متوافقة مع متطلبات هيئة الزكاة والضريبة والجمارك بعد إتمام النقل.') }}</p></details>
  </section>
</div>

<footer>
  <div class="ft">
    <div>
      <div class="ft-logos">
        <img class="logo" src="{{ asset('images/rodud-logo.jpeg') }}" alt="ردود للخدمات اللوجستية">
    </div>
    <div style="margin-top:12px;line-height:1.5">
      <div style="font-size:18px;font-weight:700;color:#fff">
          Rodud Logistics
      </div>

      <div style="font-size:14px;color:#B7B2C2">
          Pricing Portal
      </div>
  </div>
    </div>
    <div><b>{{ __('المشغّل') }}</b><div>{{ __('ردود للخدمات اللوجستية') }}</div><div id="ftPhone">—</div><div id="ftMail">—</div></div>
    <div><b>{{ __('تنويه') }}</b><div>{{ __('الأسعار المعروضة تقديرية وغير ملزمة، وتُعتمد بعد تأكيد تفاصيل الشحنة.') }}</div></div>
  </div>
  <div class="ft-base">
    <span id="crLine">—</span>
    <span>{{ __('تعرفة سارية من') }} <span id="tariffDate">—</span></span>
    <span>© <span id="yr"></span></span>
  </div>
</footer>

<div class="toast" id="toast"></div>

{{-- ═══════════════════════════════════════════════════════════
     كائن الترجمة للجافاسكربت — يُبنى من نفس ملفات lang/ar.json و lang/en.json
     عبر __() بحيث تتغيّر النصوص المتولدة ديناميكياً (رسائل، تسميات) حسب اللغة الحالية.
     ═══════════════════════════════════════════════════════════ --}}
     <script>
      window.CITY_TRANSLATIONS = @json(
          app()->getLocale() === 'en'
              ? json_decode(file_get_contents(base_path('lang/en.json')), true)
              : json_decode(file_get_contents(base_path('lang/ar.json')), true)
      );
  </script>

<script>
window.I18N = {
  'داخل المملكة': @json(__('داخل المملكة')),
  'دولية': @json(__('دولية')),
  'دولية · منفذ :name': @json(__('دولية · منفذ :name')),
  'غير مسعَّر': @json(__('غير مسعَّر')),
  'أجرة النقل للشاحنة': @json(__('أجرة النقل للشاحنة')),
  '× :count شاحنة': @json(__('× :count شاحنة')),
  'ضريبة القيمة المضافة :rate٪': @json(__('ضريبة القيمة المضافة :rate٪')),
  'ريال لكل كيلومتر': @json(__('ريال لكل كيلومتر')),
  'الإجمالي شامل الضريبة': @json(__('الإجمالي شامل الضريبة')),
  'النطاق التقديري شامل الضريبة': @json(__('النطاق التقديري شامل الضريبة')),
  'سعر تقديري — يؤكده الفريق': @json(__('سعر تقديري — يؤكده الفريق')),
  'سعر ثابت لهذا الخط': @json(__('سعر ثابت لهذا الخط')),
  'النقل البري من موقع التحميل إلى موقع التفريغ': @json(__('النقل البري من موقع التحميل إلى موقع التفريغ')),
  'متابعة الشحنة حتى التسليم': @json(__('متابعة الشحنة حتى التسليم')),
  'فاتورة ضريبية معتمدة': @json(__('فاتورة ضريبية معتمدة')),
  'العبور عبر منفذ :name': @json(__('العبور عبر منفذ :name')),
  'أرسل الطلب': @json(__('أرسل الطلب')),
  'جارٍ الإرسال…': @json(__('جارٍ الإرسال…')),
  'اكتب اسمك وجوالك ليتواصل معك الفريق.': @json(__('اكتب اسمك وجوالك ليتواصل معك الفريق.')),
  'العرض تقديري وغير ملزم، وصالح :days أيام.': @json(__('العرض تقديري وغير ملزم، وصالح :days أيام.')),
  'أرسل الطلب وسيتواصل معك فريق متخصص بعرض مخصص.': @json(__('أرسل الطلب وسيتواصل معك فريق متخصص بعرض مخصص.')),
  'تم نسخ تفاصيل الطلب': @json(__('تم نسخ تفاصيل الطلب')),
  'تعذّر النسخ — انسخه يدويًا': @json(__('تعذّر النسخ — انسخه يدويًا')),
  'الصفحة ما قدرت تحمّل بيانات الأسعار.': @json(__('الصفحة ما قدرت تحمّل بيانات الأسعار.')),
  'النقل داخل المدينة الواحدة خارج نطاق النموذج': @json(__('النقل داخل المدينة الواحدة خارج نطاق النموذج')),
  'المدينتان خارج المملكة — هذي الرحلة خارج نطاق التسعير': @json(__('المدينتان خارج المملكة — هذي الرحلة خارج نطاق التسعير')),
  'مدينة غير معروفة: :city': @json(__('مدينة غير معروفة: :city')),
  'ما فيه منفذ حدودي مسجّل لـ :country': @json(__('ما فيه منفذ حدودي مسجّل لـ :country')),
  'كم': @json(__('كم')),
  'شاحنة': @json(__('شاحنة')),

  /* تسميات القوائم المنسدلة — القيمة الفعلية (value) تبقى بالعربي دايماً
     لأنها هي نفسها مفاتيح ملف الأسعار (pricing-v3.json)، وهذا فقط النص الظاهر */

  'الرياض': @json(__('الرياض')),
  'جدة': @json(__('جدة')),
  'مكة': @json(__('مكة')),
  'المدينة': @json(__('المدينة')),
  truck: {
    'سطحة / ستارة': @json(__('سطحة / ستارة')),
    'جوانب': @json(__('جوانب')),
    'مبردة': @json(__('مبردة')),
    'لوبد / نقل ثقيل': @json(__('لوبد / نقل ثقيل')),
    'دينة صغيرة': @json(__('دينة صغيرة'))
  },
  cargo: {
    'عادية': @json(__('عادية')),
    'حاويات': @json(__('حاويات')),
    'مواد غذائية ': @json(__('مواد غذائية ')),
    'مواد بناء وحديد وأعلاف': @json(__('مواد بناء وحديد وأعلاف'))
  },
  weight: {
    'حتى 15 طن': @json(__('حتى 15 طن')),
    'حتى 25 طن': @json(__('حتى 25 طن')),
    'أكثر من 30 طن': @json(__('أكثر من 30 طن'))
  }
};

/** استبدال placeholders على طريقة لارافيل: T('مفتاح', {name:'x'}) */
function T(key, params){
  let str = window.I18N[key] ?? key;
  if(params) for(const k in params) str = str.replace(':' + k, params[k]);
  return str;
}
</script>

<script>
window.PORTAL = {
  whatsapp:"966549133000",
  phone:"+966 54 913 3000",
  email:"info@rodud.com",
  cr:"ردود للخدمات اللوجستية · السجل التجاري: 7017565156 · الرقم الضريبي: 310649816700003",
  validDays:7,
  arabicDigits: {{ app()->getLocale() === 'ar' ? 'true' : 'false' }}
};
</script>
<script>


/**
 * محرك تسعير البيع — ردود · الإصدار 3
 * منقول حرفياً عن «الحاسبة النهائية» مع إصلاح معاملَي اتجاه كانا مفقودين.
 * المخرج سعر بيع فقط. كل الأرقام من pricing-v3.json — لا قيمة مكتوبة هنا.
 */

const R = 6371;

function straightLineKm(a, b) {
  const rad = Math.PI / 180;
  const dLat = (b.lat - a.lat) * rad;
  const dLon = (b.lon - a.lon) * rad;
  const h = Math.sin(dLat / 2) ** 2 +
    Math.cos(a.lat * rad) * Math.cos(b.lat * rad) * Math.sin(dLon / 2) ** 2;
  return 2 * R * Math.asin(Math.sqrt(h));
}

function tripScope(A, B) {
  const a = A.country === 'السعودية', b = B.country === 'السعودية';
  if (a && b) return 'داخلية';
  if (a || b) return 'دولية';
  return 'خارج النطاق';
}

function directionKey(A, B) {
  return `${A.class === 'مركز' ? 'مركز' : 'طرفية'} ← ${B.class === 'مركز' ? 'مركز' : 'طرفية'}`;
}

function bestCrossing(A, B, P) {
  const foreign = A.country === 'السعودية' ? B.country : A.country;
  const options = P.crossings.filter(c => c.country === foreign);
  if (!options.length) return null;
  let best = null;
  for (const c of options) {
    const km = Math.round(
      (straightLineKm(A, c) + straightLineKm(c, B)) * P.formula.road_factor);
    if (!best || km < best.km) best = { crossing: c, km };
  }
  return best;
}

function sellPrice(i, P) {
  const A = P.cities.find(c => c.name === i.origin);
  const B = P.cities.find(c => c.name === i.destination);
  if (!A) throw new Error(T('مدينة غير معروفة: :city', {city: i.origin}));
  if (!B) throw new Error(T('مدينة غير معروفة: :city', {city: i.destination}));
  if (A.name === B.name) throw new Error(T('النقل داخل المدينة الواحدة خارج نطاق النموذج'));

  const scope = tripScope(A, B);
  if (scope === 'خارج النطاق')
    throw new Error(T('المدينتان خارج المملكة — هذي الرحلة خارج نطاق التسعير'));

  const F = P.formula;

  let km, crossing = null, direction = null;
  if (scope === 'دولية') {
    const bc = bestCrossing(A, B, P);
    if (!bc) throw new Error(T('ما فيه منفذ حدودي مسجّل لـ :country', {country: A.country === 'السعودية' ? B.country : A.country}));
    km = bc.km; crossing = bc.crossing;
  } else {
    km = Math.round(straightLineKm(A, B) * F.road_factor);
    direction = directionKey(A, B);
  }

  const lane = P.lanes.find(l => l.o === i.origin && l.d === i.destination);
  if (lane) km = lane.km;

  let base, source, trips = lane ? (lane.trips ?? 0) : 0;

    if (lane) {
  base = lane.price;
  source = 'جدولكم';
} else {
  const raw = F.fixed_sar + F.per_km_sar * km;
  const factor = scope === 'دولية'
    ? (A.country === 'السعودية' ? F.export_factor : F.import_factor)
    : (F.direction_factors[direction] ?? 1);

  base = raw * factor;
  source = 'حساب';
}

  const M = P.multipliers;
  const mTruck  = M.truck[i.truck]   ?? 1;
  const mCargo  = M.cargo[i.cargo]   ?? 1;
  const mWeight = M.weight[i.weight] ?? 1;
  const mult = mTruck * mCargo * mWeight;

  const step = P.rules.rounding_sar;
  const unit = Math.ceil((base * mult) / step) * step;

  const count = Math.max(1, Math.round(i.truckCount || 1));
  const net   = unit * count;
  const vat   = Math.round(net * P.rules.vat_rate);

  return {
    scope, km, crossing, direction,
    source, trips,
    unitPrice: unit,
    truckCount: count,
    net, vat, total: net + vat,
    perKm: km > 0 ? +(unit / km).toFixed(2) : 0,
    multiplier: +mult.toFixed(3),
    multipliersDetail: { truck: mTruck, cargo: mCargo, weight: mWeight },
    isEstimate: source === 'حساب',
    range: source === 'حساب'
      ? { low:  Math.floor((net * 0.85) / step) * step,
          high: Math.ceil((net * 1.15) / step) * step }
      : { low:  Math.floor((net * 0.95) / step) * step,
          high: Math.ceil((net * 1.05) / step) * step }
  };
}

const engineError = null;

const BIZ = window.PORTAL || {};
let P = null, LAST = null;

const $  = id => document.getElementById(id);
const LC = () => BIZ.arabicDigits ? 'ar-SA-u-nu-arab' : 'en-US';
const n0 = x => new Intl.NumberFormat(LC(), { maximumFractionDigits: 0 }).format(Math.round(x || 0));
const nL = x => new Intl.NumberFormat('en-US', { maximumFractionDigits: 0 }).format(Math.round(x || 0));
const esc = x => String(x ?? '').replace(/[&<>"']/g, c => ({ '&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;' }[c]));
function toast(m){ const t=$('toast'); t.textContent=m; t.classList.add('show'); setTimeout(()=>t.classList.remove('show'),2100); }

function fatal(msg, hint){
  const b = $('fatal');
  b.style.display = 'block';
  b.innerHTML = `<b>${T('الصفحة ما قدرت تحمّل بيانات الأسعار.')}</b> ${esc(msg)}` +
    (hint ? `<div style="margin-top:10px;font-size:14px">${hint}</div>` : '');
  $('total').textContent = '—';
}

const FILE_HINT = `يبدو أنك فتحتِ الملف بالنقر المزدوج. المتصفح يمنع قراءة ملفات
  مجاورة عبر <code>file://</code> لأسباب أمنية، فتطلع القوائم فاضية.<br>
  <b>الحل:</b> شغّلي الخادم <code>npm start</code> وافتحي
  <code>http://localhost:3000</code> — أو استخدمي نسخة الملف الواحد
  <code>بوابة-النقل-ملف-واحد.html</code> التي تعمل بالنقر المزدوج.`;

/* قوائم المدن مجمّعة حسب الدولة — القيمة (value) تبقى بالعربي دائماً لأنها
   نفس مفاتيح pricing-v3.json. المدن نفسها غير مترجمة حالياً (خارج نطاق هذا الملف). */

   function fillCities(el, selected) {
    const byCountry = new Map();

    for (const c of P.cities) {
        if (!byCountry.has(c.country)) {
            byCountry.set(c.country, []);
        }

        byCountry.get(c.country).push(c.name);
    }

    const order = [
        'السعودية',
        ...[...byCountry.keys()]
            .filter(k => k !== 'السعودية')
            .sort((a, b) => a.localeCompare(b, 'ar'))
    ];

    el.innerHTML = order.map(country => {

        const countryLabel =
            window.CITY_TRANSLATIONS[country] || country;

        const cities = byCountry.get(country)
            .sort((a, b) => a.localeCompare(b, 'ar'));

        return `
            <optgroup label="${esc(countryLabel)}">
                ${cities.map(city => {

                    const cityLabel =
                        window.CITY_TRANSLATIONS[city] || city;

                    return `
                        <option value="${esc(city)}"${city === selected ? ' selected' : ''}>
                            ${esc(cityLabel)}
                        </option>
                    `;
                }).join('')}
            </optgroup>
        `;
    }).join('');
}

/** يعبّي select بقيم عربية (value) ثابتة، مع تسمية مترجمة (label) من I18N[i18nGroup] */
function fillSel(el, arr, sel, i18nGroup){
  const dict = i18nGroup ? (window.I18N[i18nGroup] || {}) : {};
  el.innerHTML = arr.map(v =>
    `<option value="${esc(v)}"${v===sel?' selected':''}>${esc(dict[v] ?? v)}</option>`
  ).join('');
}

function animateCounter(element, target, duration =2500) {

let start = 0;
const startTime = performance.now();

function update(currentTime) {

    const progress = Math.min((currentTime - startTime) / duration, 1);

    const eased = 1 - Math.pow(1 - progress, 3);

    const value = Math.floor(eased * target);

    element.textContent = value.toLocaleString(LC())

    if (progress < 1) {
        requestAnimationFrame(update);
    } else {
        element.textContent = value.toLocaleString(LC())
    }
}

requestAnimationFrame(update);
}

  async function boot(){
    const isFile = location.protocol === 'file:';

    try {
        const r = await fetch('/pricing-data', {
            cache: 'no-store'
        });

        if (!r.ok) {
            throw new Error(`تعذّر تحميل جدول الأسعار (رمز ${r.status})`);
        }

        P = await r.json();

    } catch(e) {
        return fatal(e.message, isFile ? FILE_HINT : '');
    }

    if(engineError)
    return fatal(
        'تعذّر تحميل محرك التسعير: ' + engineError,
        isFile ? FILE_HINT : ''
    );

if(!P?.cities?.length)
    return fatal('جدول الأسعار لا يحتوي مدنًا.');


  fillCities($('from'), 'جدة');
  fillCities($('to'),   'الرياض');
  fillSel($('truck'),  Object.keys(P.multipliers.truck),  Object.keys(P.multipliers.truck)[0], 'truck');
  fillSel($('cargo'),  Object.keys(P.multipliers.cargo),  'عادية', 'cargo');
  fillSel($('weight'), Object.keys(P.multipliers.weight), 'حتى 25 طن', 'weight');

  animateCounter(
    $('tagCities'),
    P.cities.length
);

animateCounter(
    $('tagCountries'),
    new Set(P.cities.map(c => c.country)).size
);
  $('tariffDate').textContent   = P.date;
  $('waTop').href = 'https://wa.me/' + BIZ.whatsapp;
  $('ftPhone').textContent = BIZ.phone;
  $('ftMail').textContent  = BIZ.email;
  $('crLine').textContent  = BIZ.cr;
  $('yr').textContent = new Date().getFullYear();

  const d = new Date(); d.setDate(d.getDate()+2);
  $('date').value = d.toISOString().slice(0,10);
  $('date').min   = new Date().toISOString().slice(0,10);

  const form = document.querySelector('form');
  form.addEventListener('input', quote);
  form.addEventListener('change', quote);
  quote();
}
const RIYAL_ICON = @json(asset('images/saudi-riyal.svg'));

function formatSAR(value) {
    return `
        <span class="money-value">
            ${n0(value)}
            <img src="${RIYAL_ICON}" class="riyal-icon" alt="SAR">
        </span>
    `;
}

function quote(){
  if(!P) return;
  const input = {
    origin:$('from').value, destination:$('to').value,
    truck:$('truck').value, cargo:$('cargo').value, weight:$('weight').value,
    truckCount: Math.min(50, Math.max(1, +$('count').value || 1))
  };

  let r;
  try{ r = sellPrice(input, P); }
  catch(e){
    $('lane').textContent   = `${input.origin} ← ${input.destination}`;
    $('meta').textContent   = '';
    $('scopeTag').textContent = T('غير مسعَّر');
    $('scopeTag').className = 'scope';
    $('rows').innerHTML     = '';
    $('totalBox').className = 'qtotal err';
    $('totalLbl').textContent = '';
    $('total').textContent  = e.message;
    $('totalCap').textContent = '';
    $('inclList').innerHTML = `<li>${T('أرسل الطلب وسيتواصل معك فريق متخصص بعرض مخصص.')}</li>`;
    LAST = null; checkReady(); return;
  }

  const intl = r.scope === 'دولية';
  $('scopeTag').textContent = intl
    ? (r.crossing ? T('دولية · منفذ :name', {name: r.crossing.name}) : T('دولية'))
    : T('داخل المملكة');
  $('scopeTag').className = 'scope' + (intl ? ' intl' : '');
  $('lane').textContent =
    `${window.CITY_TRANSLATIONS[input.origin] || input.origin} ← ${window.CITY_TRANSLATIONS[input.destination] || input.destination}`;
  $('meta').textContent = `${n0(r.km)} ${T('كم')} · ${(window.I18N.truck && window.I18N.truck[input.truck]) || input.truck} · ${n0(r.truckCount)} ${T('شاحنة')}`;

  const rows = [[T('أجرة النقل للشاحنة'), r.unitPrice]];
  if(r.truckCount > 1) rows.push([T('× :count شاحنة', {count: n0(r.truckCount)}), r.net]);
  rows.push([T('ضريبة القيمة المضافة :rate٪', {rate: n0(P.rules.vat_rate*100)}), r.vat]);
  rows.push([T('ريال لكل كيلومتر'), r.perKm]);
  $('rows').innerHTML = rows.map(x =>
    `<div class="qr">
        <span class="l">${x[0]}</span>
        <span class="v">${formatSAR(x[1])}</span>
    </div>`
).join('');
  $('totalBox').className = 'qtotal';
  $('totalLbl').textContent = r.isEstimate ? T('النطاق التقديري شامل الضريبة') : T('الإجمالي شامل الضريبة');
  if(r.isEstimate){
    const lo = Math.round(r.range.low  * (1 + P.rules.vat_rate));
    const hi = Math.round(r.range.high * (1 + P.rules.vat_rate));
    $('total').innerHTML = `
    <span style="font-size:.72em">
        ${n0(lo)} – ${n0(hi)}
    </span>
    <img src="${RIYAL_ICON}" class="riyal-icon" alt="SAR">
`;
    $('totalCap').textContent = T('سعر تقديري — يؤكده الفريق');
  }else{
    $('total').innerHTML = formatSAR(r.total);
    $('totalCap').textContent = T('سعر ثابت لهذا الخط');
  }

  const base = [T('النقل البري من موقع التحميل إلى موقع التفريغ'),
                T('متابعة الشحنة حتى التسليم'), T('فاتورة ضريبية معتمدة')];
  if(intl) base.splice(1, 0, T('العبور عبر منفذ :name', {name: esc(r.crossing.name)}));
  $('inclList').innerHTML = base.map(t => `<li>${t}</li>`).join('');

  LAST = { ...input, ...r };
  checkReady();
}

function checkReady(){
  const nm = $('name').value.trim(), ph = $('phone').value.trim();
  const ok = nm.length > 1 && ph.replace(/[^0-9]/g,'').length >= 9;
  $('send').disabled = !ok;
  $('qnote').textContent = ok
    ? T('العرض تقديري وغير ملزم، وصالح :days أيام.', {days: n0(BIZ.validDays)})
    : T('اكتب اسمك وجوالك ليتواصل معك الفريق.');
}

function reqText(){
  const d = LAST;
  const L = ['طلب خدمة نقل — بوابة الصادرات','———————————————'];
  L.push(`الاسم: ${$('name').value.trim()}`);
  if($('company').value.trim()) L.push(`المنشأة: ${$('company').value.trim()}`);
  L.push(`الجوال: ${$('phone').value.trim()}`);
  if($('email').value.trim()) L.push(`البريد: ${$('email').value.trim()}`);
  L.push('', `خط السير: ${$('from').value} ← ${$('to').value}`);
  if(d){
    L.push(`النوع: ${d.scope}${d.crossing ? ` عبر منفذ ${d.crossing.name}` : ''} — ${nL(d.km)} كم`);
    L.push(`الشاحنة: ${d.truck} — عدد ${nL(d.truckCount)}`);
    L.push(`الحمولة: ${d.weight} · ${d.cargo}`);
  }
  L.push(`تاريخ التحميل: ${$('date').value} · ${$('ready').value}`);
  if($('notes').value.trim()) L.push(`ملاحظات: ${$('notes').value.trim()}`);
  L.push('');
  if(!d) L.push('هذي الوجهة خارج نطاق التسعير الآلي — مطلوب عرض من الفريق.');
  else if(d.isEstimate){
    L.push(`النطاق التقديري: ${nL(d.range.low)} – ${nL(d.range.high)} ر.س قبل الضريبة`);
    L.push('(يُثبَّت السعر بعد مراجعة الفريق)');
  }else{
    L.push(`قبل الضريبة: ${nL(d.net)} ر.س`);
    L.push(`ضريبة القيمة المضافة: ${nL(d.vat)} ر.س`);
    L.push(`الإجمالي التقديري: ${nL(d.total)} ر.س`);
  }
  L.push('', 'السعر تقديري وغير ملزم حتى تأكيد الطلب.');
  return L.join('\n');
}

async function saveToServer(){
  const d = LAST;
  const payload = {
    name:$('name').value.trim(), phone:$('phone').value.trim(),
    company:$('company').value.trim(), email:$('email').value.trim(),
    notes:$('notes').value.trim(), website:$('website').value,
    origin:$('from').value, destination:$('to').value,
    load_date:$('date').value, readiness:$('ready').value,
    truck_type:$('truck').value, cargo_type:$('cargo').value,
    weight_band:$('weight').value, truck_count:+$('count').value || 1,
    scope: d ? d.scope : 'غير مسعَّر',
    crossing: d?.crossing?.name || '',
    distance_km: d ? d.km : 0,
    price_source: d ? d.source : '',
    trips_in_history: d ? d.trips : 0,
    multiplier: d ? d.multiplier : 1,
    price_low: d ? d.range.low : 0, price_high: d ? d.range.high : 0,
    subtotal: d ? d.net : 0, vat: d ? d.vat : 0, total: d ? d.total : 0
  };
  try{
    const r = await fetch('/quotes', { method:'POST',
      headers:{'Content-Type':'application/json'}, body:JSON.stringify(payload) });
    const j = await r.json();
    if(!r.ok) throw new Error(j.error || 'تعذّر الإرسال');
    return j.ref;
  }catch(e){ console.warn('حفظ الطلب فشل:', e.message); return null; }
}

async function send(mode){
    const txt = reqText();

    if(mode === 'copy'){
        navigator.clipboard.writeText(txt)
            .then(()=>toast(T('تم نسخ تفاصيل الطلب')))
            .catch(()=>toast(T('تعذّر النسخ — انسخه يدويًا')));
        return;
    }

    const btn = $('send');
    btn.disabled = true;
    btn.textContent = T('جارٍ الإرسال…');

    const ref = await saveToServer();

    const body = ref ? `${txt}\n\nرقم الطلب: ${ref}` : txt;

    window.open(
        'https://wa.me/' + BIZ.whatsapp + '?text=' + encodeURIComponent(body),
        '_blank',
        'noopener'
    );

    btn.textContent = T('أرسل الطلب');
    btn.disabled = false;
}
function toggleMobileMenu() {
    $('mobileMenu').classList.toggle('open');

    const mobileWa = $('waMobile');

    if (mobileWa && BIZ?.whatsapp) {
        mobileWa.href = 'https://wa.me/' + BIZ.whatsapp;
    }
}

window.send = send;
boot();

</script>
<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>

<script>
AOS.init({
    duration: 900,
    once: true,
    easing: 'ease-out',

    offset: 80
});
</script>
</body>
</html>