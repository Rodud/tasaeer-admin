<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
<link rel="stylesheet" href="https://unpkg.com/aos@2.3.4/dist/aos.css">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>{{ __('بوابة النقل للخدمات اللوجستية · عملاء هيئة تنمية الصادرات السعودية') }}</title>
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
.top .end{margin-inline-start:auto;display:flex;align-items:center;gap:14px}
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
.faq h2{font-size:38px;margin-bottom:28px}
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
  .hero h1{font-size:29px} .hero p{font-size:17px}
  .faq h2{font-size:28px} .qtotal .big{font-size:30px}
  .lockup img.seda{height:34px} .lockup img.togoo{height:24px}
}
@media (prefers-reduced-motion:reduce){*{transition:none !important}}

input[type="date"]::-webkit-date-and-time-value{
    text-align:center;
}

input[type="date"]::-webkit-calendar-picker-indicator{
    position:absolute;
    right:12px;
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
    color:#6B7280;
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

      <a class="tel" id="telLink" href="#">—</a>
      <a id="waTop" href="#" target="_blank" rel="noopener"><button class="btn" type="button" data-i18n="تواصل معنا">{{ __('تواصل معنا') }}</button></a>
            <button
    class="btn ghost"
    type="button"
    onclick="window.location='{{ route('locale', app()->getLocale() === 'ar' ? 'en' : 'ar') }}'">

    {{ app()->getLocale() === 'ar' ? 'EN' : 'العربية' }}

</button>
    </div>
  </div>
</header>

<section class="hero" data-aos="fade-down">
  <div class="hero-in">
    <div class="eyebrow" data-i18n="حصري لعملاء هيئة تنمية الصادرات السعودية">{{ __('حصري لعملاء هيئة تنمية الصادرات السعودية') }}</div>
    <h1 data-i18n="احسب تكلفة الشحن خلال ثوانٍ">{{ __('احسب تكلفة الشحن خلال ثوانٍ') }}</h1>
    <div class="rule"></div>
    <p><span data-i18n="احصل على تقدير فوري لتكلفة الشحن داخل المملكة باستخدام بوابة Rodud Logistics.">{{ __('احصل على تقدير فوري لتكلفة الشحن داخل المملكة باستخدام بوابة Rodud Logistics.') }}</span>
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
    <details><summary>{{ __('هل الخدمة حصرية لعملاء الهيئة؟') }}</summary><p>{{ __('هذه البوابة مخصصة لعملاء هيئة تنمية الصادرات السعودية. اذكر اسم منشأتك عند إرسال الطلب.') }}</p></details>
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
  cr:"ردود للخدمات اللوجستية · السجل التجاري: —  ·  الرقم الضريبي: —",
  validDays:7,
  arabicDigits: {{ app()->getLocale() === 'ar' ? 'true' : 'false' }}
};
</script>
<script>

/* ══════════════════════════════════════════════════════════════
   نسخة الملف الواحد — بُنيت آلياً بواسطة build-single.js
   لا تعدّل هذا الملف. عدّل ملفات public/ ثم: node build-single.js
   ملاحظة: مفاتيح المدن/الشاحنات/البضاعة هنا تبقى بالعربي دائماً — هي معرّفات
   بيانات (IDs) لا نصوص واجهة، وتُترجم للعرض فقط عبر window.I18N أعلاه.
   ══════════════════════════════════════════════════════════════ */
window.PRICING_DATA = {
 "version": "3.0",
 "date": "2026-07-29",
 "multipliers": {
  "truck": {
   "سطحة / ستارة": 1,
   "جوانب": 1,
   "مبردة": 1.33,
   "لوبد / نقل ثقيل": 1.3,
   "دينة صغيرة": 0.57
  },
  "cargo": {
   "عادية": 1,
   "حاويات": 1.3,
   "مواد غذائية ": 1.2,
   "مواد بناء وحديد وأعلاف": 0.87
  },
  "weight": {
   "حتى 15 طن": 0.93,
   "حتى 25 طن": 1,
   "أكثر من 30 طن": 1.38
  }
 },
 "formula": {
  "fixed_sar": 754,
  "per_km_sar": 1.57,
  "road_factor": 1.12,
  "export_factor": 1.95,
  "import_factor": 1.8,
  "direction_factors": {
   "مركز ← مركز": 0.908,
   "مركز ← طرفية": 1.227,
   "طرفية ← مركز": 0.768,
   "طرفية ← طرفية": 1.2
  }
 },
 "rules": {
  "rounding_sar": 50,
  "vat_rate": 0.15,
  "min_trips_for_lane": 5
 },
 "cities": [
  {"name":"الرياض","country":"السعودية","class":"مركز","lat":24.71,"lon":46.68},
  {"name":"الخرج","country":"السعودية","class":"مركز","lat":24.15,"lon":47.31},
  {"name":"الدرعية","country":"السعودية","class":"مركز","lat":24.73,"lon":46.57},
  {"name":"المزاحمية","country":"السعودية","class":"طرفية","lat":24.47,"lon":46.26},
  {"name":"ضرما","country":"السعودية","class":"طرفية","lat":24.59,"lon":46.2},
  {"name":"حريملاء","country":"السعودية","class":"طرفية","lat":25.11,"lon":46.11},
  {"name":"ثادق","country":"السعودية","class":"طرفية","lat":25.29,"lon":45.86},
  {"name":"المجمعة","country":"السعودية","class":"طرفية","lat":25.91,"lon":45.35},
  {"name":"سدير","country":"السعودية","class":"طرفية","lat":25.9,"lon":45.35},
  {"name":"الغاط","country":"السعودية","class":"طرفية","lat":26.03,"lon":44.95},
  {"name":"الزلفي","country":"السعودية","class":"طرفية","lat":26.3,"lon":44.8},
  {"name":"شقراء","country":"السعودية","class":"طرفية","lat":25.24,"lon":45.25},
  {"name":"الدوادمي","country":"السعودية","class":"طرفية","lat":24.51,"lon":44.39},
  {"name":"عفيف","country":"السعودية","class":"طرفية","lat":23.91,"lon":42.92},
  {"name":"رماح","country":"السعودية","class":"طرفية","lat":25.56,"lon":47.15},
  {"name":"حوطة بني تميم","country":"السعودية","class":"طرفية","lat":23.52,"lon":46.85},
  {"name":"الحريق","country":"السعودية","class":"طرفية","lat":23.62,"lon":46.53},
  {"name":"ليلى","country":"السعودية","class":"طرفية","lat":22.28,"lon":46.73},
  {"name":"السليل","country":"السعودية","class":"طرفية","lat":20.46,"lon":45.57},
  {"name":"وادي الدواسر","country":"السعودية","class":"طرفية","lat":20.47,"lon":44.8},
  {"name":"الرين","country":"السعودية","class":"طرفية","lat":23.55,"lon":45.51},
  {"name":"جدة","country":"السعودية","class":"مركز","lat":21.49,"lon":39.19},
  {"name":"مكة","country":"السعودية","class":"مركز","lat":21.39,"lon":39.86},
  {"name":"الطائف","country":"السعودية","class":"مركز","lat":21.27,"lon":40.42},
  {"name":"رابغ","country":"السعودية","class":"مركز","lat":22.8,"lon":39.03},
  {"name":"الجموم","country":"السعودية","class":"مركز","lat":21.62,"lon":39.7},
  {"name":"بحرة","country":"السعودية","class":"طرفية","lat":21.4,"lon":39.42},
  {"name":"خليص","country":"السعودية","class":"طرفية","lat":22.15,"lon":39.31},
  {"name":"الكامل","country":"السعودية","class":"طرفية","lat":22.16,"lon":39.79},
  {"name":"القنفذة","country":"السعودية","class":"طرفية","lat":19.13,"lon":41.08},
  {"name":"الليث","country":"السعودية","class":"طرفية","lat":20.15,"lon":40.27},
  {"name":"أضم","country":"السعودية","class":"طرفية","lat":20.85,"lon":40.1},
  {"name":"تربة","country":"السعودية","class":"طرفية","lat":21.21,"lon":41.63},
  {"name":"رنية","country":"السعودية","class":"طرفية","lat":21.86,"lon":42.85},
  {"name":"الخرمة","country":"السعودية","class":"طرفية","lat":21.92,"lon":42.05},
  {"name":"المدينة","country":"السعودية","class":"مركز","lat":24.47,"lon":39.61},
  {"name":"ينبع","country":"السعودية","class":"مركز","lat":24.09,"lon":38.06},
  {"name":"بدر","country":"السعودية","class":"طرفية","lat":23.78,"lon":38.79},
  {"name":"العلا","country":"السعودية","class":"طرفية","lat":26.61,"lon":37.92},
  {"name":"خيبر","country":"السعودية","class":"طرفية","lat":25.7,"lon":39.29},
  {"name":"المهد","country":"السعودية","class":"طرفية","lat":23.5,"lon":40.86},
  {"name":"الحناكية","country":"السعودية","class":"طرفية","lat":24.86,"lon":40.51},
  {"name":"بريدة","country":"السعودية","class":"مركز","lat":26.33,"lon":43.97},
  {"name":"عنيزة","country":"السعودية","class":"مركز","lat":26.09,"lon":43.99},
  {"name":"الرس","country":"السعودية","class":"طرفية","lat":25.87,"lon":43.5},
  {"name":"المذنب","country":"السعودية","class":"طرفية","lat":25.86,"lon":44.22},
  {"name":"البكيرية","country":"السعودية","class":"طرفية","lat":26.14,"lon":43.66},
  {"name":"البدائع","country":"السعودية","class":"طرفية","lat":26.15,"lon":43.66},
  {"name":"رياض الخبراء","country":"السعودية","class":"طرفية","lat":26.06,"lon":43.53},
  {"name":"عيون الجواء","country":"السعودية","class":"طرفية","lat":26.53,"lon":43.7},
  {"name":"النبهانية","country":"السعودية","class":"طرفية","lat":25.51,"lon":43.1},
  {"name":"الأسياح","country":"السعودية","class":"طرفية","lat":26.42,"lon":44.28},
  {"name":"القصيباء","country":"السعودية","class":"طرفية","lat":26.3,"lon":43.2},
  {"name":"الدمام","country":"السعودية","class":"مركز","lat":26.43,"lon":50.1},
  {"name":"الخبر","country":"السعودية","class":"مركز","lat":26.28,"lon":50.21},
  {"name":"الظهران","country":"السعودية","class":"مركز","lat":26.29,"lon":50.15},
  {"name":"الجبيل","country":"السعودية","class":"مركز","lat":27.01,"lon":49.66},
  {"name":"الأحساء","country":"السعودية","class":"مركز","lat":25.38,"lon":49.59},
  {"name":"القطيف","country":"السعودية","class":"مركز","lat":26.56,"lon":49.99},
  {"name":"سيهات","country":"السعودية","class":"مركز","lat":26.49,"lon":50.03},
  {"name":"رأس تنورة","country":"السعودية","class":"مركز","lat":26.65,"lon":50.16},
  {"name":"بقيق","country":"السعودية","class":"مركز","lat":25.94,"lon":49.66},
  {"name":"النعيرية","country":"السعودية","class":"طرفية","lat":27.47,"lon":48.48},
  {"name":"حفر الباطن","country":"السعودية","class":"طرفية","lat":28.43,"lon":45.97},
  {"name":"الخفجي","country":"السعودية","class":"طرفية","lat":28.42,"lon":48.49},
  {"name":"قرية العليا","country":"السعودية","class":"طرفية","lat":27.55,"lon":47.68},
  {"name":"سلوى","country":"السعودية","class":"طرفية","lat":24.75,"lon":50.77},
  {"name":"أبها","country":"السعودية","class":"طرفية","lat":18.22,"lon":42.51},
  {"name":"خميس مشيط","country":"السعودية","class":"طرفية","lat":18.31,"lon":42.73},
  {"name":"أحد رفيدة","country":"السعودية","class":"طرفية","lat":18.16,"lon":42.71},
  {"name":"محايل عسير","country":"السعودية","class":"طرفية","lat":18.55,"lon":42.05},
  {"name":"سراة عبيدة","country":"السعودية","class":"طرفية","lat":17.98,"lon":43.05},
  {"name":"ظهران الجنوب","country":"السعودية","class":"طرفية","lat":17.65,"lon":43.51},
  {"name":"النماص","country":"السعودية","class":"طرفية","lat":19.15,"lon":42.12},
  {"name":"تنومة","country":"السعودية","class":"طرفية","lat":18.93,"lon":42.15},
  {"name":"رجال ألمع","country":"السعودية","class":"طرفية","lat":18.2,"lon":42.3},
  {"name":"بيشة","country":"السعودية","class":"طرفية","lat":20,"lon":42.6},
  {"name":"سبت العلاية","country":"السعودية","class":"طرفية","lat":19.63,"lon":41.71},
  {"name":"بلقرن","country":"السعودية","class":"طرفية","lat":19.6,"lon":41.9},
  {"name":"جازان","country":"السعودية","class":"طرفية","lat":16.89,"lon":42.57},
  {"name":"صبيا","country":"السعودية","class":"طرفية","lat":17.15,"lon":42.63},
  {"name":"أبو عريش","country":"السعودية","class":"طرفية","lat":16.97,"lon":42.83},
  {"name":"صامطة","country":"السعودية","class":"طرفية","lat":16.6,"lon":42.94},
  {"name":"بيش","country":"السعودية","class":"طرفية","lat":17.38,"lon":42.58},
  {"name":"الدرب","country":"السعودية","class":"طرفية","lat":17.73,"lon":42.25},
  {"name":"أحد المسارحة","country":"السعودية","class":"طرفية","lat":16.71,"lon":42.95},
  {"name":"نجران","country":"السعودية","class":"طرفية","lat":17.49,"lon":44.13},
  {"name":"شرورة","country":"السعودية","class":"طرفية","lat":17.49,"lon":47.11},
  {"name":"حبونا","country":"السعودية","class":"طرفية","lat":17.94,"lon":44.32},
  {"name":"الباحة","country":"السعودية","class":"طرفية","lat":20.01,"lon":41.47},
  {"name":"بلجرشي","country":"السعودية","class":"طرفية","lat":19.86,"lon":41.56},
  {"name":"المندق","country":"السعودية","class":"طرفية","lat":20.17,"lon":41.28},
  {"name":"العقيق","country":"السعودية","class":"طرفية","lat":20.26,"lon":41.66},
  {"name":"تبوك","country":"السعودية","class":"طرفية","lat":28.38,"lon":36.57},
  {"name":"ضباء","country":"السعودية","class":"طرفية","lat":27.35,"lon":35.7},
  {"name":"الوجه","country":"السعودية","class":"طرفية","lat":26.24,"lon":36.46},
  {"name":"أملج","country":"السعودية","class":"طرفية","lat":25.03,"lon":37.27},
  {"name":"حقل","country":"السعودية","class":"طرفية","lat":29.29,"lon":34.94},
  {"name":"تيماء","country":"السعودية","class":"طرفية","lat":27.63,"lon":38.55},
  {"name":"البدع","country":"السعودية","class":"طرفية","lat":28.47,"lon":35.01},
  {"name":"نيوم","country":"السعودية","class":"طرفية","lat":28,"lon":35.3},
  {"name":"حائل","country":"السعودية","class":"طرفية","lat":27.52,"lon":41.69},
  {"name":"بقعاء","country":"السعودية","class":"طرفية","lat":27.9,"lon":42.75},
  {"name":"الشنان","country":"السعودية","class":"طرفية","lat":27.1,"lon":42.72},
  {"name":"الغزالة","country":"السعودية","class":"طرفية","lat":26.9,"lon":41.3},
  {"name":"موقق","country":"السعودية","class":"طرفية","lat":27.6,"lon":41},
  {"name":"عرعر","country":"السعودية","class":"طرفية","lat":30.98,"lon":41.04},
  {"name":"رفحاء","country":"السعودية","class":"طرفية","lat":29.63,"lon":43.5},
  {"name":"طريف","country":"السعودية","class":"طرفية","lat":31.68,"lon":38.66},
  {"name":"العويقيلة","country":"السعودية","class":"طرفية","lat":30.33,"lon":42.25},
  {"name":"سكاكا","country":"السعودية","class":"طرفية","lat":29.97,"lon":40.21},
  {"name":"دومة الجندل","country":"السعودية","class":"طرفية","lat":29.81,"lon":39.87},
  {"name":"القريات","country":"السعودية","class":"طرفية","lat":31.33,"lon":37.34},
  {"name":"طبرجل","country":"السعودية","class":"طرفية","lat":30.5,"lon":38.22},
  {"name":"دبي","country":"الإمارات","class":"دولي","lat":25.2,"lon":55.27},
  {"name":"أبوظبي","country":"الإمارات","class":"دولي","lat":24.45,"lon":54.38},
  {"name":"الشارقة","country":"الإمارات","class":"دولي","lat":25.35,"lon":55.39},
  {"name":"العين","country":"الإمارات","class":"دولي","lat":24.21,"lon":55.74},
  {"name":"عجمان","country":"الإمارات","class":"دولي","lat":25.41,"lon":55.44},
  {"name":"رأس الخيمة","country":"الإمارات","class":"دولي","lat":25.79,"lon":55.94},
  {"name":"الفجيرة","country":"الإمارات","class":"دولي","lat":25.13,"lon":56.33},
  {"name":"أم القيوين","country":"الإمارات","class":"دولي","lat":25.56,"lon":55.55},
  {"name":"جبل علي","country":"الإمارات","class":"دولي","lat":25.01,"lon":55.06},
  {"name":"ميناء خليفة","country":"الإمارات","class":"دولي","lat":24.8,"lon":54.65},
  {"name":"مدينة الكويت","country":"الكويت","class":"دولي","lat":29.38,"lon":47.99},
  {"name":"الأحمدي","country":"الكويت","class":"دولي","lat":29.08,"lon":48.08},
  {"name":"الجهراء","country":"الكويت","class":"دولي","lat":29.34,"lon":47.66},
  {"name":"الشعيبة","country":"الكويت","class":"دولي","lat":29.05,"lon":48.15},
  {"name":"ميناء عبدالله","country":"الكويت","class":"دولي","lat":29.02,"lon":48.15},
  {"name":"المنامة","country":"البحرين","class":"دولي","lat":26.23,"lon":50.59},
  {"name":"الرفاع","country":"البحرين","class":"دولي","lat":26.13,"lon":50.56},
  {"name":"الحد","country":"البحرين","class":"دولي","lat":26.24,"lon":50.66},
  {"name":"مدينة عيسى","country":"البحرين","class":"دولي","lat":26.17,"lon":50.55},
  {"name":"الدوحة","country":"قطر","class":"دولي","lat":25.29,"lon":51.53},
  {"name":"الريان","country":"قطر","class":"دولي","lat":25.29,"lon":51.42},
  {"name":"مسيعيد","country":"قطر","class":"دولي","lat":24.99,"lon":51.55},
  {"name":"رأس لفان","country":"قطر","class":"دولي","lat":25.9,"lon":51.55},
  {"name":"أم صلال","country":"قطر","class":"دولي","lat":25.42,"lon":51.4},
  {"name":"مسقط","country":"عُمان","class":"دولي","lat":23.59,"lon":58.41},
  {"name":"صلالة","country":"عُمان","class":"دولي","lat":17.02,"lon":54.09},
  {"name":"صحار","country":"عُمان","class":"دولي","lat":24.34,"lon":56.71},
  {"name":"نزوى","country":"عُمان","class":"دولي","lat":22.93,"lon":57.53},
  {"name":"الدقم","country":"عُمان","class":"دولي","lat":19.66,"lon":57.7},
  {"name":"صور","country":"عُمان","class":"دولي","lat":22.57,"lon":59.53},
  {"name":"البريمي","country":"عُمان","class":"دولي","lat":24.25,"lon":55.79},
  {"name":"عمّان","country":"الأردن","class":"دولي","lat":31.95,"lon":35.93},
  {"name":"العقبة","country":"الأردن","class":"دولي","lat":29.53,"lon":35},
  {"name":"الزرقاء","country":"الأردن","class":"دولي","lat":32.07,"lon":36.09},
  {"name":"إربد","country":"الأردن","class":"دولي","lat":32.55,"lon":35.85},
  {"name":"بغداد","country":"العراق","class":"دولي","lat":33.31,"lon":44.36},
  {"name":"البصرة","country":"العراق","class":"دولي","lat":30.51,"lon":47.78},
  {"name":"أربيل","country":"العراق","class":"دولي","lat":36.19,"lon":44.01},
  {"name":"النجف","country":"العراق","class":"دولي","lat":32.03,"lon":44.34},
  {"name":"الموصل","country":"العراق","class":"دولي","lat":36.34,"lon":43.13},
  {"name":"صنعاء","country":"اليمن","class":"دولي","lat":15.35,"lon":44.21},
  {"name":"عدن","country":"اليمن","class":"دولي","lat":12.79,"lon":45.04},
  {"name":"المكلا","country":"اليمن","class":"دولي","lat":14.54,"lon":49.13},
  {"name":"الحديدة","country":"اليمن","class":"دولي","lat":14.8,"lon":42.95},
  {"name":"سيئون","country":"اليمن","class":"دولي","lat":15.94,"lon":48.79},
  {"name":"الدوحة الصناعية","country":"قطر","class":"دولي","lat":25.2,"lon":51.4}
 ],
 "crossings": [
  {"country":"الإمارات","name":"البطحاء","lat":24.13,"lon":51.61,"note":"المسار الرئيسي للشاحنات"},
  {"country":"قطر","name":"سلوى","lat":24.73,"lon":50.77,"note":"المنفذ البري المباشر"},
  {"country":"البحرين","name":"جسر الملك فهد","lat":26.19,"lon":50.36,"note":"تحققي من قيود وأوقات عبور الشاحنات"},
  {"country":"الكويت","name":"الخفجي","lat":28.42,"lon":48.49,"note":"الساحلي — من الشرقية"},
  {"country":"الكويت","name":"الرقعي","lat":29.06,"lon":46.55,"note":"الغربي — من الرياض والقصيم"},
  {"country":"عُمان","name":"الربع الخالي","lat":19.95,"lon":54.9,"note":"مباشر — طويل وقليل الخدمات"},
  {"country":"عُمان","name":"البطحاء","lat":24.13,"lon":51.61,"note":"عبر الإمارات — الأكثر استخداماً"},
  {"country":"الأردن","name":"الحديثة","lat":31.52,"lon":38,"note":"الأنسب للأردن وبلاد الشام"},
  {"country":"الأردن","name":"حالة عمار","lat":29.35,"lon":36.05,"note":"من تبوك والشمال الغربي"},
  {"country":"الأردن","name":"الدرة","lat":29.35,"lon":34.96,"note":"الساحلي — قرب العقبة"},
  {"country":"العراق","name":"جديدة عرعر","lat":31.05,"lon":41.3,"note":"المنفذ البري المباشر"},
  {"country":"اليمن","name":"الوديعة","lat":17.02,"lon":47.02,"note":"الأكثر استخداماً"}
 ],
 "lanes": [
  {"o":"جدة","d":"الرياض","km":947,"price":2000,"firm":true},
  {"o":"بريدة","d":"الرياض","km":365,"price":1000,"firm":true},
  {"o":"جدة","d":"الدمام","km":1385,"price":2300,"firm":true},
  {"o":"جدة","d":"المدينة","km":374,"price":1250,"firm":true},
  {"o":"رابغ","d":"الرياض","km":904,"price":2000,"firm":true},
  {"o":"ينبع","d":"جدة","km":349,"price":1200,"firm":true},
  {"o":"بريدة","d":"جدة","km":812,"price":1850,"firm":true},
  {"o":"الخرج","d":"جدة","km":989,"price":2150,"firm":true},
  {"o":"جدة","d":"تبوك","km":908,"price":2400,"firm":true},
  {"o":"رابغ","d":"بريدة","km":711,"price":1850,"firm":true},
  {"o":"بريدة","d":"مكة","km":773,"price":1850,"firm":true},
  {"o":"بريدة","d":"الدمام","km":684,"price":1450,"firm":true},
  {"o":"الدمام","d":"الرياض","km":440,"price":1200,"firm":true},
  {"o":"جدة","d":"خميس مشيط","km":573,"price":2200,"firm":true},
  {"o":"الرياض","d":"جازان","km":1085,"price":3600,"firm":true},
  {"o":"جدة","d":"سكاكا","km":1062,"price":2500,"firm":true},
  {"o":"جدة","d":"ينبع","km":349,"price":1200,"firm":true},
  {"o":"ينبع","d":"الرياض","km":981,"price":2250,"firm":true},
  {"o":"رابغ","d":"الدمام","km":1332,"price":2300,"firm":true},
  {"o":"رابغ","d":"خميس مشيط","km":706,"price":2500,"firm":true},
  {"o":"حائل","d":"الرياض","km":659,"price":1400,"firm":true},
  {"o":"رابغ","d":"جدة","km":164,"price":950,"firm":true},
  {"o":"الرياض","d":"جدة","km":947,"price":2100,"firm":true},
  {"o":"جدة","d":"حائل","km":803,"price":2000,"firm":true},
  {"o":"الرياض","d":"خميس مشيط","km":919,"price":2650,"firm":true},
  {"o":"الرياض","d":"المدينة","km":801,"price":2200,"firm":true},
  {"o":"بريدة","d":"المدينة","km":542,"price":1050,"firm":true},
  {"o":"المدينة","d":"العلا","km":327,"price":1450,"firm":true},
  {"o":"المدينة","d":"الرياض","km":801,"price":2500,"firm":true},
  {"o":"ينبع","d":"الدمام","km":1386,"price":2500,"firm":true},
  {"o":"المدينة","d":"جدة","km":374,"price":1500,"firm":true},
  {"o":"المدينة","d":"بريدة","km":542,"price":1600,"firm":true},
  {"o":"بريدة","d":"الطائف","km":749,"price":1850,"firm":true},
  {"o":"الخرج","d":"المدينة","km":875,"price":2200,"firm":true},
  {"o":"رابغ","d":"عرعر","km":1043,"price":3000,"firm":true},
  {"o":"جازان","d":"الرياض","km":1085,"price":2100,"firm":true},
  {"o":"الخرج","d":"بريدة","km":464,"price":1250,"firm":true},
  {"o":"جدة","d":"بريدة","km":812,"price":2000,"firm":true},
  {"o":"الخرج","d":"سدير","km":311,"price":1100,"firm":true},
  {"o":"المدينة","d":"جازان","km":1005,"price":2900,"firm":true},
  {"o":"بريدة","d":"ينبع","km":722,"price":1300,"firm":true},
  {"o":"جدة","d":"رابغ","km":164,"price":950,"firm":true},
  {"o":"الدمام","d":"جدة","km":1385,"price":3200,"firm":true},
  {"o":"جدة","d":"الخرج","km":989,"price":2200,"firm":true},
  {"o":"المدينة","d":"نجران","km":1016,"price":3450,"firm":true},
  {"o":"رابغ","d":"المدينة","km":218,"price":1200,"firm":true},
  {"o":"حائل","d":"الدمام","km":943,"price":1650,"firm":true},
  {"o":"الرياض","d":"الدمام","km":440,"price":1200,"firm":true},
  {"o":"المدينة","d":"الأحساء","km":1133,"price":2900,"firm":true},
  {"o":"الرياض","d":"محايل عسير","km":936,"price":3200,"firm":true},
  {"o":"حائل","d":"المدينة","km":445,"price":950,"firm":true},
  {"o":"الخرج","d":"حائل","km":757,"price":1850,"firm":true},
  {"o":"الرياض","d":"بريدة","km":365,"price":1300,"firm":true},
  {"o":"سدير","d":"جدة","km":891,"price":2150,"firm":true},
  {"o":"المدينة","d":"خميس مشيط","km":848,"price":3050,"firm":true},
  {"o":"المدينة","d":"حائل","km":445,"price":1700,"firm":true},
  {"o":"المدينة","d":"الطائف","km":409,"price":1750,"firm":true},
  {"o":"الرياض","d":"الجبيل","km":440,"price":1150,"firm":true},
  {"o":"المدينة","d":"الدمام","km":1204,"price":2900,"firm":true},
  {"o":"الرياض","d":"مكة","km":884,"price":2250,"firm":true},
  {"o":"الدمام","d":"حائل","km":943,"price":3200,"firm":true},
  {"o":"رماح","d":"المدينة","km":862,"price":2850,"firm":true},
  {"o":"الخرج","d":"الدمام","km":423,"price":1200,"firm":true},
  {"o":"الرياض","d":"نجران","km":947,"price":2700,"firm":true},
  {"o":"جدة","d":"جازان","km":697,"price":2200,"firm":true},
  {"o":"الخرج","d":"الرياض","km":100,"price":750,"firm":true},
  {"o":"جدة","d":"حفر الباطن","km":1154,"price":2500,"firm":true},
  {"o":"بريدة","d":"رابغ","km":711,"price":1750,"firm":true},
  {"o":"المدينة","d":"القنفذة","km":686,"price":2400,"firm":true},
  {"o":"جدة","d":"الطائف","km":145,"price":1200,"firm":true},
  {"o":"المدينة","d":"تبوك","km":593,"price":2400,"firm":true},
  {"o":"الدمام","d":"خميس مشيط","km":1320,"price":3600,"firm":true},
  {"o":"رماح","d":"الخرج","km":177,"price":1050,"firm":true},
  {"o":"الخرج","d":"وادي الدواسر","km":542,"price":1650,"firm":true},
  {"o":"جدة","d":"الدوادمي","km":705,"price":1850,"firm":true},
  {"o":"المدينة","d":"الباحة","km":595,"price":2800,"firm":true},
  {"o":"المدينة","d":"طبرجل","km":766,"price":2650,"firm":true},
  {"o":"رابغ","d":"سبت العلاية","km":503,"price":2300,"firm":true},
  {"o":"جازان","d":"مكة","km":645,"price":950,"firm":true},
  {"o":"المدينة","d":"سكاكا","km":688,"price":2400,"firm":true},
  {"o":"رماح","d":"جدة","km":1040,"price":3000,"firm":true},
  {"o":"جدة","d":"أبها","km":563,"price":2300,"firm":true},
  {"o":"الدمام","d":"بريدة","km":684,"price":1750,"firm":true},
  {"o":"الدمام","d":"تبوك","km":1515,"price":3850,"firm":true},
  {"o":"الخرج","d":"تبوك","km":1309,"price":3450,"firm":true},
  {"o":"سدير","d":"الدمام","km":535,"price":1300,"firm":true},
  {"o":"الدمام","d":"الخرج","km":423,"price":1300,"firm":true},
  {"o":"رابغ","d":"الخرج","km":960,"price":2100,"firm":true},
  {"o":"رماح","d":"ينبع","km":1043,"price":3450,"firm":true},
  {"o":"رابغ","d":"الأحساء","km":1242,"price":2350,"firm":true},
  {"o":"الرياض","d":"الطائف","km":836,"price":2100,"firm":true},
  {"o":"الجبيل","d":"الرياض","km":440,"price":1450,"firm":true},
  {"o":"الرياض","d":"سيهات","km":437,"price":1150,"firm":true},
  {"o":"حفر الباطن","d":"المدينة","km":864,"price":2300,"firm":true},
  {"o":"الجبيل","d":"جدة","km":1372,"price":3450,"firm":true},
  {"o":"ينبع","d":"الخرج","km":1051,"price":2400,"firm":true},
  {"o":"الدمام","d":"جازان","km":1473,"price":4500,"firm":true},
  {"o":"ينبع","d":"الأحساء","km":1314,"price":2500,"firm":true},
  {"o":"الخرج","d":"البدائع","km":481,"price":1400,"firm":true},
  {"o":"الخرج","d":"الدوادمي","km":334,"price":1650,"firm":true},
  {"o":"الخرج","d":"جازان","km":1059,"price":3600,"firm":true},
  {"o":"الخرج","d":"عنيزة","km":446,"price":1400,"firm":true},
  {"o":"سدير","d":"المدينة","km":671,"price":2000,"firm":true},
  {"o":"رابغ","d":"رفحاء","km":986,"price":3100,"firm":true},
  {"o":"الدمام","d":"المدينة","km":1204,"price":3250,"firm":true},
  {"o":"جدة","d":"القنفذة","km":368,"price":1300,"firm":true},
  {"o":"الرياض","d":"رابغ","km":904,"price":2300,"firm":true},
  {"o":"المدينة","d":"رابغ","km":218,"price":1200,"firm":true},
  {"o":"رابغ","d":"تبوك","km":748,"price":2400,"firm":true},
  {"o":"المدينة","d":"الدرعية","km":789,"price":2000,"firm":true},
  {"o":"الخرج","d":"مكة","km":922,"price":2200,"firm":false},
  {"o":"الخرج","d":"نجران","km":908,"price":2850,"firm":false},
  {"o":"جدة","d":"سدير","km":891,"price":1900,"firm":false},
  {"o":"الخرج","d":"الزلفي","km":389,"price":1400,"firm":false},
  {"o":"رابغ","d":"سكاكا","km":903,"price":3000,"firm":false},
  {"o":"جدة","d":"الوجه","km":668,"price":1950,"firm":false},
  {"o":"الرياض","d":"وادي الدواسر","km":571,"price":1850,"firm":false},
  {"o":"المدينة","d":"مكة","km":385,"price":1400,"firm":false},
  {"o":"الرياض","d":"عفيف","km":438,"price":2000,"firm":false},
  {"o":"رماح","d":"الرياض","km":118,"price":850,"firm":false},
  {"o":"الخرج","d":"الباحة","km":848,"price":3200,"firm":false},
  {"o":"الخرج","d":"حفر الباطن","km":554,"price":2000,"firm":false},
  {"o":"الدمام","d":"رابغ","km":1332,"price":3300,"firm":false},
  {"o":"جدة","d":"الأحساء","km":1283,"price":2300,"firm":false},
  {"o":"جدة","d":"الجبيل","km":1372,"price":2400,"firm":false},
  {"o":"عرعر","d":"رابغ","km":1043,"price":3000,"firm":false},
  {"o":"ينبع","d":"بريدة","km":722,"price":1850,"firm":false},
  {"o":"المدينة","d":"رفحاء","km":774,"price":2650,"firm":false},
  {"o":"الخرج","d":"تنومة","km":883,"price":2750,"firm":false},
  {"o":"البدائع","d":"المدينة","km":502,"price":1150,"firm":false},
  {"o":"وادي الدواسر","d":"الخرج","km":542,"price":700,"firm":false},
  {"o":"ينبع","d":"الليث","km":553,"price":1450,"firm":false},
  {"o":"سدير","d":"الرياض","km":211,"price":1100,"firm":false},
  {"o":"رابغ","d":"حائل","km":660,"price":2050,"firm":false},
  {"o":"خميس مشيط","d":"جدة","km":573,"price":1400,"firm":false},
  {"o":"ينبع","d":"المدينة","km":182,"price":1150,"firm":false},
  {"o":"جدة","d":"النعيرية","km":1289,"price":5100,"firm":false},
  {"o":"جدة","d":"مكة","km":79,"price":1050,"firm":false},
  {"o":"بريدة","d":"الخفجي","km":564,"price":1350,"firm":false},
  {"o":"خميس مشيط","d":"رابغ","km":706,"price":1400,"firm":false},
  {"o":"تبوك","d":"الخرج","km":1309,"price":2650,"firm":false},
  {"o":"المدينة","d":"ينبع","km":182,"price":900,"firm":false},
  {"o":"الخرج","d":"الطائف","km":869,"price":2200,"firm":false},
  {"o":"الخرج","d":"الجموم","km":928,"price":2500,"firm":false},
  {"o":"جدة","d":"القريات","km":1243,"price":2500,"firm":false},
  {"o":"الأحساء","d":"سلوى","km":155,"price":1650,"firm":false},
  {"o":"الدمام","d":"مكة","km":1323,"price":4050,"firm":false},
  {"o":"الدمام","d":"ينبع","km":1386,"price":3400,"firm":false},
  {"o":"الرياض","d":"الأحساء","km":339,"price":1150,"firm":false},
  {"o":"الرياض","d":"الباحة","km":838,"price":3100,"firm":false},
  {"o":"الدمام","d":"النعيرية","km":222,"price":1400,"firm":false},
  {"o":"الدمام","d":"الأحساء","km":143,"price":900,"firm":false},
  {"o":"الدمام","d":"الجبيل","km":87,"price":1500,"firm":false},
  {"o":"الخرج","d":"سكاكا","km":1070,"price":3100,"firm":false},
  {"o":"الخرج","d":"شقراء","km":270,"price":950,"firm":false},
  {"o":"الخرج","d":"خميس مشيط","km":901,"price":3100,"firm":false},
  {"o":"الرياض","d":"سدير","km":211,"price":1050,"firm":false},
  {"o":"الرياض","d":"بيشة","km":751,"price":2650,"firm":false},
  {"o":"الرياض","d":"ينبع","km":981,"price":2450,"firm":false},
  {"o":"المدينة","d":"النعيرية","km":1061,"price":2900,"firm":false},
  {"o":"المدينة","d":"حفر الباطن","km":864,"price":2400,"firm":false},
  {"o":"جدة","d":"الخبر","km":1389,"price":2200,"firm":false},
  {"o":"تبوك","d":"رابغ","km":748,"price":2400,"firm":false},
  {"o":"تبوك","d":"مكة","km":946,"price":2400,"firm":false},
  {"o":"بريدة","d":"حفر الباطن","km":342,"price":1850,"firm":false},
  {"o":"القصيباء","d":"الدمام","km":770,"price":1650,"firm":false},
  {"o":"المدينة","d":"الخرج","km":875,"price":1850,"firm":false},
  {"o":"حفر الباطن","d":"الدمام","km":520,"price":950,"firm":false},
  {"o":"حفر الباطن","d":"الخرج","km":554,"price":1200,"firm":false},
  {"o":"رابغ","d":"الجبيل","km":1310,"price":2400,"firm":false},
  {"o":"رابغ","d":"الخفجي","km":1271,"price":2850,"firm":false},
  {"o":"سبت العلاية","d":"رابغ","km":503,"price":1600,"firm":false},
  {"o":"رماح","d":"مكة","km":981,"price":3000,"firm":false},
  {"o":"عنيزة","d":"حفر الباطن","km":365,"price":1500,"firm":false},
  {"o":"سلوى","d":"الجبيل","km":308,"price":1650,"firm":false},
  {"o":"ينبع","d":"خميس مشيط","km":901,"price":2850,"firm":false},
  {"o":"ينبع","d":"مكة","km":395,"price":1200,"firm":false},
  {"o":"جدة","d":"الدوحة","km":1497,"price":7000,"firm":true},
  {"o":"جدة","d":"مدينة الكويت","km":1491,"price":8000,"firm":true},
  {"o":"جدة","d":"دبي","km":1898,"price":9500,"firm":true},
  {"o":"الرياض","d":"مدينة الكويت","km":637,"price":3200,"firm":true},
  {"o":"الدمام","d":"دبي","km":768,"price":3200,"firm":true},
  {"o":"الدمام","d":"مدينة الكويت","km":436,"price":2800,"firm":true},
  {"o":"ينبع","d":"الدوحة","km":1554,"price":8000,"firm":true},
  {"o":"المنامة","d":"جدة","km":1426,"price":6500,"firm":true},
  {"o":"جدة","d":"المنامة","km":1426,"price":6000,"firm":true},
  {"o":"جدة","d":"مسقط","km":2240,"price":7150,"firm":true},
  {"o":"جدة","d":"جبل علي","km":1869,"price":9750,"firm":true},
  {"o":"الدمام","d":"مسقط","km":1110,"price":3800,"firm":true},
  {"o":"الرياض","d":"دبي","km":999,"price":3500,"firm":true},
  {"o":"رابغ","d":"المنامة","km":1377,"price":6000,"firm":true},
  {"o":"الدمام","d":"الدوحة","km":336,"price":2000,"firm":true},
  {"o":"جازان","d":"دبي","km":1822,"price":9750,"firm":true},
  {"o":"ينبع","d":"مدينة الكويت","km":1416,"price":5600,"firm":true},
  {"o":"ينبع","d":"مسقط","km":2317,"price":4150,"firm":true},
  {"o":"ينبع","d":"دبي","km":1975,"price":5500,"firm":true},
  {"o":"الرياض","d":"مسقط","km":1341,"price":3400,"firm":true},
  {"o":"الرياض","d":"الدوحة","km":574,"price":2500,"firm":true},
  {"o":"جدة","d":"الشارقة","km":1917,"price":10800,"firm":true},
  {"o":"الدمام","d":"المنامة","km":68,"price":4000,"firm":true},
  {"o":"الجبيل","d":"مدينة الكويت","km":349,"price":2300,"firm":true},
  {"o":"رابغ","d":"جبل علي","km":1852,"price":10000,"firm":true},
  {"o":"الخرج","d":"مدينة الكويت","km":680,"price":3500,"firm":false},
  {"o":"الأحساء","d":"المنامة","km":159,"price":2000,"firm":false},
  {"o":"ينبع","d":"الشارقة","km":1994,"price":4750,"firm":false}
 ]
};

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
  const laneIsFirm = lane
    ? (lane.firm ?? (lane.carrier_offer != null || lane.trips >= P.rules.min_trips_for_lane))
    : false;
  if (lane && lane.carrier_offer != null) {
    base = lane.carrier_offer; source = 'عرض ناقل';
  } else if (lane && laneIsFirm) {
    base = lane.price; source = 'جدولكم';
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
  if(window.PRICING_DATA){
    P = window.PRICING_DATA;
  }else{
    try{
      const r = await fetch('/api/pricing', { cache:'no-store' });
      if(!r.ok) throw new Error(`تعذّر تحميل جدول الأسعار (رمز ${r.status})`);
      P = await r.json();
    }catch(e){ return fatal(e.message, isFile ? FILE_HINT : ''); }
  }

  if(engineError && !window.PRICING_DATA)
    return fatal('تعذّر تحميل محرك التسعير: ' + engineError, isFile ? FILE_HINT : '');
  if(!P?.cities?.length) return fatal('جدول الأسعار لا يحتوي مدنًا.');

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
  $('telLink').textContent = BIZ.phone;
  $('telLink').href = 'tel:' + String(BIZ.phone||'').replace(/[^0-9+]/g,'');
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