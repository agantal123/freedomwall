<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <title>@yield('title')</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet">

        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    </head>
    <body>
             <div class="flex h-screen">
                <div class="m-auto">
                             <div class="mb-5">
                              <h1 class="text-2xl font-semibold capitalize text-gray-800 dark:text-white">{{ config('app.name')}}</h1>
                            </div>
                            <div class="text-lg text-gray-600 uppercase tracking-wider">
                                @yield('code') | @yield('message')
                            </div>
                            
                            <a href="{{url('/')}}">
                                <div class="flex">
                                  <div class="flex m-auto p-5">
                                    <svg class="p-0.5 h-6 w-6 rounded-full z-20 bg-white dark:bg-gray-800 " xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path fill-rule="evenodd" d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                                    </svg>
                                    <span class=" text-black-800 dark:text-gray-400  font-light">Back to home</span>
                                  </div>
                                </div>
                            </a>
                </div>
            </div>
    </body>
</html>
