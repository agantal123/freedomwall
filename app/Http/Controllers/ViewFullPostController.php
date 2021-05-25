<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Vote;
use App\Models\FWuser;
use App\Models\Mobile_notification;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Notifications\MobileNotification;
use Notification;


class ViewFullPostController extends Controller
{
   
    public function userpost($id)
    {   

        if(Post::where('id' ,'=',$id)->exists())
        {   
    
            $mypost = DB::table('posts')
            ->join('f_wusers','f_wusers.id','=','posts.user_id')                                                                               
            ->select('posts.id','posts.title','posts.description','posts.anonymous','posts.status','posts.user_id','posts.upvote_count','posts.downvote_count','posts.created_at','posts.updated_at','f_wusers.username')
             ->groupBy('posts.id','posts.title','posts.description','posts.anonymous','posts.status','posts.user_id','posts.upvote_count','posts.downvote_count','posts.created_at','posts.updated_at','f_wusers.username')
            ->where('posts.id',$id)->first();
    
            $comments = DB::table('comments')
            ->join('f_wusers','f_wusers.id','=','comments.user_id')
            ->select('comments.id','comments.comment_content','comments.created_at','f_wusers.username')
            ->where('comments.post_id',$id)
            ->orderBy('created_at','DESC')->get();

            $trending_Notifications = DB::table('notifications')
            ->join('posts','posts.id','=','notifications.data->post_id')
            ->join('f_wusers','f_wusers.id','=','posts.user_id')
            ->select('posts.id','notifications.read_at','notifications.created_at','posts.title','f_wusers.username')
            ->groupBy('posts.id','notifications.read_at','notifications.created_at','posts.title','f_wusers.username')
            ->orderBy('notifications.created_at','DESC')->get();
        
            return view('pages.viewpost', compact('mypost','comments','trending_Notifications'));
        }
        else
        {
            abort(404);
        }
       
    }

    public function deletePost($id)
    {

        $post = Post::find($id);
        $post->delete();

        $comments = Comment::where('post_id',$id);
        $comments->delete();

        $comments = Vote::where('post_id',$id);
        $comments->delete();

        return redirect('/');
    }
    
    public function approvePost($id)
    {
        $updatePost = Post::find($id);
        $updatePost->status = 1;
        $updatePost->save();

        $post = DB::table('posts')->where('id',$id)->first();
        $this_user = DB::table('f_wusers')->where('id',$post->user_id)->first();


        $post = DB::table('posts')->where('id',$id)->first();
        $this_user = DB::table('f_wusers')->where('id',$post->user_id)->first();

        $notifyUser = $this_user->userToken;
        if($this_user->userToken != '')
        {
            Notification::send($notifyUser, new MobileNotification($notifyUser));
            
            $store_notif = new Mobile_notification;
            $store_notif->notification_type = 'Approved your post';
            $store_notif->post_id = $id;
            $store_notif->notification_from_user = 'USeP admin';
            $store_notif->seen_notification = 0;
          //  $store_notif->comment_id = $store_comment->id;
            $store_notif->save();
        }
        else
        {
            $store_notif = new Mobile_notification;
            $store_notif->notification_type = 'Approved your post';
            $store_notif->post_id = $id;
            $store_notif->notification_from_user = 'USeP admin';
            $store_notif->seen_notification = 0;
           // $store_notif->comment_id = $store_comment->id;
            $store_notif->save();
        }
        
        return redirect()->back();
    }

    public function viewPost_Notification($id)
    {
        if(Post::where('id' ,'=',$id)->exists())
        {   
    
            $mypost = DB::table('posts')
            ->join('f_wusers','f_wusers.id','=','posts.user_id')                                                                               
            ->select('posts.id','posts.title','posts.description','posts.anonymous','posts.status','posts.user_id','posts.upvote_count','posts.downvote_count','posts.created_at','posts.updated_at','f_wusers.username')
             ->groupBy('posts.id','posts.title','posts.description','posts.anonymous','posts.status','posts.user_id','posts.upvote_count','posts.downvote_count','posts.created_at','posts.updated_at','f_wusers.username')
            ->where('posts.id',$id)->first();
    
            $comments = DB::table('comments')
            ->join('f_wusers','f_wusers.id','=','comments.user_id')
            ->select('comments.id','comments.comment_content','comments.created_at','f_wusers.username')
            ->where('comments.post_id',$id)
            ->orderBy('created_at','DESC')->get();
            
            $date_now = Carbon::now();
            DB::table('notifications')->where('data->post_id', $id)->update(['read_at' => $date_now ]);

            $trending_Notifications = DB::table('notifications')
            ->join('posts','posts.id','=','notifications.data->post_id')
            ->join('f_wusers','f_wusers.id','=','posts.user_id')
            ->select('posts.id','notifications.read_at','notifications.created_at','posts.title','f_wusers.username')
            ->groupBy('posts.id','notifications.read_at','notifications.created_at','posts.title','f_wusers.username')
            ->orderBy('notifications.created_at','DESC')->get();

            return view('pages.viewpost', compact('mypost','comments','trending_Notifications'));
        }
        else
        {
            abort(404);
        }
    }

}
