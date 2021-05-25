@extends('layouts.app')

@section('content')
<div class="w-full overflow-x-hidden flex flex-col">
  <main class="w-full flex-grow p-5">
    <h1 class="text-3xl text-black -mt-2 pb-2"><b>Home</b></h1>
      <div class="flex flex-wrap">   
        <!-- left side container start -->       
         <div class="w-full lg:w-2/3 pr-0 lg:pr-2">
         <!-- Search start -->
         <div class=" mb-5 pt-2 relative text-gray-600">
          <form action="{{ route('dashboardsearch')}}" method="get">
                  <input class="border-2 border-gray-300 bg-white h-10 px-3 pr-10 rounded-lg text-sm focus:outline-none w-full"
                    type="search" name="search" placeholder="Search post" required>
                  <button type="submit" class="absolute right-0 top-0 mt-5 mr-4">
                    <svg class="text-gray-600 h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg"
                      xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px"
                      viewBox="0 0 56.966 56.966" style="enable-background:new 0 0 56.966 56.966;" xml:space="preserve"
                      width="512px" height="512px">
                      <path
                        d="M55.146,51.887L41.588,37.786c3.486-4.144,5.396-9.358,5.396-14.786c0-12.682-10.318-23-23-23s-23,10.318-23,23  s10.318,23,23,23c4.761,0,9.298-1.436,13.177-4.162l13.661,14.208c0.571,0.593,1.339,0.92,2.162,0.92  c0.779,0,1.518-0.297,2.079-0.837C56.255,54.982,56.293,53.08,55.146,51.887z M23.984,6c9.374,0,17,7.626,17,17s-7.626,17-17,17  s-17-7.626-17-17S14.61,6,23.984,6z" />
                    </svg>
                  </button>
            </form>
          </div>
        <!-- Search end -->
        <!-- Post start -->
        <dashboard-all-posts></dashboard-all-posts>
        <!-- Post end -->
         </div>
        <!-- left side container end -->

        <!-- right side container start -->
         <div class="w-full lg:w-1/3 pl-0 lg:pl-2 mt-12 lg:mt-0">
            
          <!-- Dashboard info start -->
          <div class="bg-white rounded mt-4">
              <div class="py-4 px-6">
                  <h1 class="text-2xl font-semibold text-gray-800">DASHBOARD INFO</h1>
                  <!-- <p class="py-2 text-lg text-gray-700">sample text</p> -->
                  <div class="flex items-center mt-5 text-gray-700">
                  <svg class="p-0.5 h-6 w-6 bg-white dark:bg-gray-800" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                  </svg>
                      <h1 class="px-2 text-sm">Total number of users: <b>{{$FWusercount}}</b></h1>
                  </div>
                  <div class="flex items-center mt-5 text-gray-700">
                  <svg class="p-0.5 h-6 w-6 bg-white dark:bg-gray-800" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                  </svg>
                      <h1 class="px-2 text-sm">Number of post this day: <b>{{$postCount_currDate}}</b></h1>
                  </div>
                  <div class="flex items-center mt-5 text-gray-700">
                  <svg class="p-0.5 h-6 w-6 bg-white dark:bg-gray-800" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                  </svg>
                      <h1 class="px-2 text-sm">Posts set to <b>noticed by admin</b>: <b>{{$approvedPost}}</b></h1>
                  </div>
              </div>
          </div>
          <!-- Dashboard Info end-->
          <!-- User activity -->
            <div class="mt-5 bg-white">
            <div class="py-4 px-6">
            <h1 class="text-lg font-semibold text-gray-800">Most recent approved post</h1>
                @forelse($recentlyApproved as $recentlyApproved)
                <div class="shadow-lg rounded-lg bg-white mx-auto m-8 p-4 notification-box">
                    <div class="text-sm pb-2">
                    <p class="text-sm"><b>{{ $recentlyApproved->title }} </b> - {{ \Carbon\Carbon::parse($recentlyApproved->created_at)->format('M j, Y - h:i A')  }}</p>
                    </div>
                      <div class="flex mr-5">
                        <svg class="p-0.5 h-5 w-5 bg-white text-green-500 dark:bg-gray-800 " fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span class="text-xs text-green-500 dark:text-gray-400 font-light">Noticed by USeP admin</span>
                      </div>
                    <div class="text-sm text-gray-600  tracking-tight ">
                    {{ $recentlyApproved->description }} 
                    </div>
                  </div>
                @empty
                  <div>
                    <h3>no approved post yet.</h3>
                  </div>
                @endforelse
            </div>
            </div> 
            <!-- user activity end -->
         </div>
         <!-- right side container end --> 
      </div>

 </main>
</div>

@endsection
