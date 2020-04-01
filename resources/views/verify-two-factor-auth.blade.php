<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Two factor verification</title>
    <link rel="stylesheet" href="{{ asset('vendor/junges/laravel-2fa/css/tailwind/tailwind.css') }}">
</head>
<body class="flex justify-center">
<div class="flex justify-center align-middle">
    <div class="rounded overflow-hidden shadow-lg mt-64">
        <div class="px-6 py-4">
            <form action="{{ route('two_factor_code.verify.store') }}" method="POST">
                @csrf
                <div class="font-bold text-xl mb-2">Two factor verification</div>
                @if(session()->has('message'))
                    <div class="bg-orange-100 border-l-4 border-orange-500 text-orange-700 p-4 mt-2 mb-4" role="alert">
                        <p class="font-bold">Code sent</p>
                        <p>Your code have been sent. Please, check your mail.</p>
                    </div>
                @endif
                <label class="text-gray-700 text-base" for="two-factor-code">Type the code you have received via email</label>
                <div class="flex justify-between align-middle align-items-center">
                    <input type="text"
                           placeholder="Type your 2FA code here"
                           class="w-full border rounded-lg py-1
                                        h-12
                                        px-4 mt-2 outline-none focus:border-blue-500"
                           name="two_factor_code">
                </div>
                <button class="bg-transparent hover:bg-blue-500 text-blue-700
                                    font-semibold hover:text-white mt-2 h-8 w-full
                                    px-4 border border-blue-500 hover:border-transparent rounded">
                    Verify
                </button>
            </form>
            <p class="text-gray-700 mt-2 text-sm text-right">
                If you haven't received your code,
                <a class="text-blue-500 hover:underline hover:cursor-pointer" href="{{ route('two_factor_code.resend') }}">click here</a>
            </p>
        </div>
    </div>
</div>
</body>
</html>
