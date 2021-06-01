<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use App\Models\Vote;
use App\Models\Mobile_notification;
use Illuminate\Http\Request;
use DB;
use App\Notifications\MobileNotification;
use Notification;

class PostController extends Controller
{
   
    public function index()
    {
        
        $vote1 = "upvote";
        $vote2 = "downvote";

        $recentgpost = DB::table('posts')
        ->leftJoin('votes','votes.post_id','=','posts.id')
        ->leftJoin('comments','comments.post_id','=','posts.id')
        ->join('f_wusers','f_wusers.id','=','posts.user_id')                                                                               
        ->select('posts.id','posts.title','posts.description','posts.anonymous','posts.status','posts.upvote_count','posts.downvote_count','posts.user_id','posts.created_at','posts.updated_at','f_wusers.username', 
          DB::raw("count(comments.comment_content) as count_comments"))
         ->groupBy('posts.id','posts.title','posts.description','posts.anonymous','posts.status','posts.upvote_count','posts.downvote_count','posts.user_id','posts.created_at','posts.updated_at','f_wusers.username')
        ->orderBy('posts.created_at','DESC')->get();

        $trendingpost = DB::table('posts')
        ->leftJoin('votes','votes.post_id','=','posts.id')
        ->leftJoin('comments','comments.post_id','=','posts.id')
        ->join('f_wusers','f_wusers.id','=','posts.user_id')                                                                               
        ->select('posts.id','posts.title','posts.description','posts.anonymous','posts.status','posts.upvote_count','posts.downvote_count','posts.user_id','posts.created_at','posts.updated_at','f_wusers.username', 
         DB::raw("count(comments.comment_content) as count_comments"))
         ->groupBy('posts.id','posts.title','posts.description','posts.anonymous','posts.status','posts.upvote_count','posts.downvote_count','posts.user_id','posts.created_at','posts.updated_at','f_wusers.username')
        ->orderBy('posts.upvote_count','DESC')->get();

        return response()->json(['postsdata' => $recentgpost, 'trendingpostdata' => $trendingpost]);
    }

    public function update($id)
    {
        Post::where('id', $id)->update(['status' => 1]);

        $post = DB::table('posts')->where('id',$id)->first();
        $this_user = DB::table('f_wusers')->where('id',$post->user_id)->first();

        $notifyUser = $this_user->userToken;
        if($this_user->userToken != '')
        {
            Notification::send($notifyUser, new MobileNotification($notifyUser));
            
            $store_notif = new Mobile_notification;
            $store_notif->notification_type = "marked your post to 'Noticed'";
            $store_notif->post_id = $id;
            $store_notif->notification_from_user = 'USeP admin';
            $store_notif->seen_notification = 0;
          //  $store_notif->comment_id = $store_comment->id;
            $store_notif->save();
        }
        else
        {
            $store_notif = new Mobile_notification;
            $store_notif->notification_type = "marked your post to 'Noticed'";
            $store_notif->post_id = $id;
            $store_notif->notification_from_user = 'USeP admin';
            $store_notif->seen_notification = 0;
           // $store_notif->comment_id = $store_comment->id;
            $store_notif->save();
        }
        return response()->json('Post successfully updated!');
    }
    public function show()
    {
        //
    }

    public function destroy($id)
    {
    
        $post = Post::find($id);
        $post->delete();
        
        $comments = Comment::where('post_id',$id);
        $comments->delete();

        $vote = Vote::where('post_id',$id);
        $vote->delete();

        return response()->json('Post deleted!');
    }

}
