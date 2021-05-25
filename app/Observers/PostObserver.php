<?php

namespace App\Observers;

use App\Notifications\NewTrendingPostNotification;
use App\Models\Post;
use App\Models\User;
use Notification;
use DB;

class PostObserver
{
    /**
     * Handle the Post "created" event.
     *
     * @param  \App\Models\Post  $post
     * @return void
     */

    public function viewTrending(Post $post)
    {
        // $trendingpost = DB::table('post')->where('votes','>=', 3)->get();
        // foreach($trendingpost as $records)
        // {
        //     $checkifexist = DB::table('notification')->where('data','=', $records->id)->first();
        //      if($checkifexist == null)
        //      { 
        //          Notification::send(new NewTrendingPostNotification($event->trendingpost));
        //      }
        // }
    }
    public function created(Post $post)
    {
       /* $vote1 = "upvote";
        $user = User::where('id',1);
        $post = DB::table('posts')
        ->leftJoin('votes','votes.post_id','=','posts.id')
        ->join('f_wusers','f_wusers.id','=','posts.user_id')                                                                               
        ->select(array('posts.id','posts.title','posts.description','posts.anonymous','posts.status','posts.user_id','posts.created_at','posts.updated_at','f_wusers.username', 
         ))
         ->selectRaw("count(votes.vote_type = '$vote1') as count_upvotes")
         ->havingRaw('count_upvotes >= 3')
         ->groupBy('posts.id','posts.title','posts.description','posts.anonymous','posts.status','posts.user_id','posts.created_at','posts.updated_at','f_wusers.username')
         ->get();
        
         Notification::send($user,new NewTrendingPostNotification($post));*/
    }

    /**
     * Handle the Post "updated" event.
     *
     * @param  \App\Models\Post  $post
     * @return void
     */
    public function updated(Post $post)
    {
        //
        // if($post->wasChanged('upvote_count'))
        // {
        //     auth()->user()->notify(new NewTrendingPostNotification($records));
        //   }
        // if($post->upvote_count >= 3)
        // {
        //     foreach($post as $records)
        //     {
        //         $checkifexist = DB::table('notifications')->where('data->post_id','=', $records->id)->first();
        //         if($checkifexist == null)
        //         {
        //             auth()->user()->notify(new NewTrendingPostNotification($records));
        //         }
        //     } 
        // }
    }

    /**
     * Handle the Post "deleted" event.
     *
     * @param  \App\Models\Post  $post
     * @return void
     */
    public function deleted(Post $post)
    {
        //
    }

    /**
     * Handle the Post "restored" event.
     *
     * @param  \App\Models\Post  $post
     * @return void
     */
    public function restored(Post $post)
    {
        //
    }

    /**
     * Handle the Post "force deleted" event.
     *
     * @param  \App\Models\Post  $post
     * @return void
     */
    public function forceDeleted(Post $post)
    {
        //
    }
}
