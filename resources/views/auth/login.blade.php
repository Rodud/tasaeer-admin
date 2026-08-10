<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>تسجيل دخول الإدارة</title>

    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@600;700;900&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css','resources/js/app.js'])

    <style>
        body{
            margin:0;
            background:#f6f4fb;
            font-family:'Cairo',sans-serif;
        }
        
        .login-page{
            min-height:100vh;
            display:flex;
            align-items:center;
            justify-content:center;
            padding:20px;
        }
        
        .login-card{
            width:420px;
            background:#fff;
            border-radius:22px;
            padding:40px;
            box-shadow:0 15px 40px rgba(0,0,0,.08);
            border:1px solid #ece7f5;
        }
        
        .login-card h1{
            margin:0;
            text-align:center;
            color:#5F12A0;
            font-size:34px;
            font-weight:900;
        }
        
        .login-card p{
            text-align:center;
            color:#777;
            margin:8px 0 35px;
        }
        
        .field{
            margin-bottom:22px;
        }
        
        .field label{
            display:block;
            margin-bottom:8px;
            font-size:14px;
            font-weight:700;
        }
        
        .field input{
            width:100%;
            padding:14px 18px;
            border-radius:14px;
            border:1px solid #ddd;
            outline:none;
            font-family:inherit;
            transition:.2s;
        }
        
        .field input:focus{
            border-color:#7818C0;
            box-shadow:0 0 0 4px rgba(120,24,192,.12);
        }
        
        .field small{
            color:#d32f2f;
            display:block;
            margin-top:6px;
        }
        
        .login-btn{
            width:100%;
            padding:15px;
            border:none;
            border-radius:999px;
            background:#7818C0;
            color:#fff;
            font-size:16px;
            font-weight:700;
            cursor:pointer;
            transition:.2s;
        }
        
        .login-btn:hover{
            background:#5F12A0;
        }
        .logos{
            display:flex;
            justify-content:center;
            align-items:center;
            gap:18px;
            margin-bottom:24px;
        }

        .divider{
            width:2px;
            height:50px;
            background:#00AC8A;
            border-radius:2px;
        }

        .authority-logo{
            height:50px;
            width:auto;
        }

        .rodud-logo{
            width:48px;
            height:48px;
        }
        .login-card h2{
            text-align:center;
            font-size:22px;
            font-weight:800;
            color:#111827;
            margin:22px 0 30px;
        }
        .logos{
            display:flex;
            justify-content:center;
            align-items:center;
            gap:14px;
            margin-bottom:24px;
        }
        </style>

</head>

<body>

<div class="login-page">

    <div class="login-card">

        <div class="logos">

            {{-- <img
            class="authority-logo"
            src="{{ asset('images/export-logo.png') }}"
            alt="هيئة تنمية الصادرات السعودية"> --}}
        
            {{-- <span class="divider"></span> --}}
        
            <img
                class="rodud-logo"
                src="{{ asset('images/rodud-logo.jpeg') }}"
                alt="ردود">
        
        </div>
    
    <h2>إدارة طلبات التسعير</h2>

        <form method="POST" action="{{ route('login') }}">

            @csrf
        
            <div class="field">
        
                <label>البريد الإلكتروني</label>
        
                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                >
        
                @error('email')
                    <small>{{ $message }}</small>
                @enderror
        
            </div>
        
            <div class="field">
        
                <label>كلمة المرور</label>
        
                <input
                    type="password"
                    name="password"
                    required
                >
        
                @error('password')
                    <small>{{ $message }}</small>
                @enderror
        
            </div>
        
            <button class="login-btn">
        
                تسجيل الدخول
        
            </button>
        
        </form>

    </div>

</div>

</body>
</html>