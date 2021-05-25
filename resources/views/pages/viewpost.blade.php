@extends('layouts.app')

@section('content')

<div class=" flex justify-center mt-5">
<div class="px-5 mx-5 py-4 bg-white dark:bg-gray-800 shadow rounded-lg w-2/3">
<div class="flex justify-between items-center">
    
    <div class="flex mb-4">
      <img class="w-12 h-12 rounded-full" src="https://www.logolynx.com/images/logolynx/97/97e88682fa82ed11f3bf96dcf8479635.png"/>
      <div class="ml-2 mt-0.5">
        @if($mypost->anonymous === '')
        <div>
          <span class="block font-medium text-base leading-snug text-black dark:text-gray-100 font-bold">{{$mypost->username }}</span>
        </div>
        @else
        <div>
          <span class="block font-medium text-base leading-snug text-black dark:text-gray-100 font-bold">Anonymous</span>
        </div>
        @endif
        <span class="block text-sm text-gray-500 dark:text-gray-400 font-light leading-snug">{{ \Carbon\Carbon::parse($mypost->created_at)->format('M j, Y - h:i A')  }} </span>
      </div>
    </div>
    <div>
    <!-- $mypost->created_at->format('M j, Y - h:i:s A') -->
    <div class="relative">
         <button href="#" onclick="deleteConfirm('deletepost')" class="bg-transparent hover:bg-red-500 text-red-700 font-semibold hover:text-white py-1 px-2 border border-red-500 hover:border-transparent rounded">
            <p class="text-sm"> Delete post</p>
         </button>
         <form id="deletepost" class="absolute" action="{{ route('deletePost', $mypost->id) }}" method="POST">
         {{csrf_field()}}
         {{ method_field('POST') }}
         </form>
         @if($mypost->status == 0)
         <button href="#" onclick="document.getElementById('approvePost').submit();" class="bg-transparent hover:bg-green-500 text-green-700 font-semibold hover:text-white py-1 px-2 border border-green-500 hover:border-transparent rounded">
             <p class="text-sm">  Mark post as <b>Seen by Admin</b></p>
         </button>
         <form id="approvePost" class="absolute" action="{{ route('approvePost', $mypost->id) }}" method="POST">
         {{csrf_field()}}
         {{ method_field('PATCH') }}
         </form>
         @else
         <div></div>
         @endif
    </div>


    </div>
</div>

@if($mypost->status == 1)
  <div class="flex mr-5">
        <svg class="p-0.5 h-6 w-6 rounded-full z-20 bg-white text-green-500 dark:bg-gray-800 " fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
        </svg>
        <span class="text-green-500 dark:text-gray-400 font-light">Noticed by USeP admin</span>
    </div>
@else
<div class="flex mr-5">
       
    </div>
@endif 


    <p class="text-gray-800 dark:text-gray-100 leading-snug md:leading-normal text-lg font-bold mb-3">
    {{$mypost->title}}
    </p>
    

    <p class="text-gray-800 dark:text-gray-100 leading-snug md:leading-normal">
    {{$mypost->description}}
    </p>
   
    <div class="flex justify-right items-center mt-5 pt-3 border-t-2 border-gray-200">
        <div class="flex mr-5">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                </svg>
                <span class="ml-1 text-gray-500 dark:text-gray-400  font-light">{{$mypost->upvote_count}}</span>
        </div> 
        <div class="flex mr-5">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
                <span class="ml-1 text-gray-500 dark:text-gray-400  font-light">{{$mypost->downvote_count}}</span>
        </div>
    </div>

  @forelse($comments as $comment)
    <div class="flex justify-right items-center mt-5 pt-3">
    <div class="row">
    <div class="flex mb-4">
      <img class="w-12 h-12 rounded-full" src="https://www.logolynx.com/images/logolynx/97/97e88682fa82ed11f3bf96dcf8479635.png"/>
      <div class="ml-2 mt-0.5 p-2 border-2 border-gray-200 rounded-md bg-gray-100">
        <div>
          <span class="block text-sm text-black dark:text-gray-100 font-bold">{{$comment->username}}</span>
        </div>
        <span class="block text-xs text-gray-500 dark:text-gray-400 font-light leading-snug">{{ Carbon\Carbon::parse($comment->created_at)->format('M j, Y - h:i A') }} </span>
        <p class="mt-1">{{$comment->comment_content}} </p>    
      </div>
    </div>
    @empty
    <div class="flex justify-center m-5 w-auto">
       <div>
          <h4>This post has no comment.</h4>
       </div>
    </div>
    @endforelse
    



    </div>
    </div>

</div>
</div>

@endsection
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script type="text/javascript">
    function deletepost(id) {
        swal({
                    text: "are you sure you want to delete this post?",
                    showCancelButton: true,
                    confirmButtonColor: '#f47f7f',
                    cancelButtonColor: '#aeb0b4',
                    confirmButtonText: 'Delete'
        }).then((result) => {
            if (result.value == true) {
              var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    type: 'POST',
                    url: "{{url('/deletePost')}}/" + id,
                    data: {_token: CSRF_TOKEN},
                    dataType: 'JSON',
                    success: function (results) {
                      window.location.href = redirect;
                    }
                });

            } else {
                result.dismiss;
            }
        }, function (dismiss) {
            return false;
        })
    }
</script>