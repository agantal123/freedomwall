@extends('layouts.app')

@section('content')
<div class="mt-10">
<div class="ml-5">
<p class="text-gray-800 dark:text-white text-lg font-semibold">You searched for: <b>{{$keyword_search}}</b></p>
</div>
<div class="flex flex-row">
   
    <div class="w-2/3 m-5 bg-white rounded mt-4">
            <div class="py-4 px-6">
                 <!-- <h2 class="text-lg font-semibold text-gray-800">POSTS</h2> -->
                 @forelse($filteredPosts as $filteredPost)

                 <div class="px-5 mb-3 py-4 bg-white hover:bg-gray-50 dark:bg-gray-800 shadow rounded-lg max-w-full">
                <a href="{{ route('viewpost', $filteredPost->id) }}">
                <div class="flex justify-between items-center">
                    <div class="flex mb-4">
                    <img class="w-12 h-12 rounded-full" src="https://www.logolynx.com/images/logolynx/97/97e88682fa82ed11f3bf96dcf8479635.png"/>
                    <div class="ml-2 mt-0.5">
                    @if($filteredPost->anonymous === '')
                        <div>
                        <span class="block font-medium text-base leading-snug text-black dark:text-gray-100 font-bold">{{$filteredPost->username }}</span>
                        </div>
                    @else
                        <div>
                        <span class="block font-medium text-base leading-snug text-black dark:text-gray-100 font-bold">Anonymous</span>
                        </div>
                    @endif
                        <span class="block text-sm text-gray-500 dark:text-gray-400 font-light leading-snug">{{ Carbon\Carbon::parse($filteredPost->created_at)->format('M j, Y - h:i A')}}</span>
                    </div>
                    </div>
                    <div>
                 </div>
                </div>
           
                @if($filteredPost->status == 1)
                    <div class="flex mr-5">
                        <svg class="p-0.5 h-6 w-6 rounded-full z-20 bg-white text-green-500 dark:bg-gray-800 " fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span class="text-green-500 dark:text-gray-400 font-light">Noticed by USeP admin</span>
                    </div> 
                @else
                    <div></div>
                @endif
                    <p class="text-gray-800 dark:text-gray-100 leading-snug md:leading-normal text-lg font-bold mb-3">
                    {{$filteredPost->title}}
                    </p>
                
                    <p class="text-gray-800 dark:text-gray-100 leading-snug md:leading-normal">
                    {{$filteredPost->description}}
                    </p>
                    <div class="flex justify-right items-center mt-5">
                        <div class="flex mr-5">
                                <svg class="p-0.5 h-6 w-6 rounded-full z-20 bg-white dark:bg-gray-800 " xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                                </svg>
                                <span class="ml-1 text-gray-500 dark:text-gray-400  font-light">{{$filteredPost->upvote_count}}</span>
                        </div> 
                        <div class="flex mr-5">
                                <svg class="p-0.5 h-6 w-6 rounded-full z-20 bg-white dark:bg-gray-800 " xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 17l-4 4m0 0l-4-4m4 4V3" />
                                </svg>
                                <span class="ml-1 text-gray-500 dark:text-gray-400  font-light">{{$filteredPost->downvote_count}}</span>
                        </div>
                       <div class="flex mr-5">
                                <svg class="p-0.5 h-6 w-6 rounded-full z-20 bg-white dark:bg-gray-800 " xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                </svg>
                                <span class="ml-1 text-gray-500 dark:text-gray-400  font-light">{{$filteredPost->count_comments}}</span>
                        </div>  
                        
                    </div>
                </a>
                </div>


                 @empty
                <p class="text-gray-800 dark:text-white text-lg font-semibold">No results</p>
                 @endforelse
            </div>
    </div>
    <!-- <div class="w-1/3 m-5 bg-white rounded mt-4">
            <div class="py-4 px-6">
                <h2 class="text-lg font-semibold text-gray-800">USERS</h2>
            </div>
    </div> -->
</div>
<div>
@endsection