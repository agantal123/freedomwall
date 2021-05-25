<?php

namespace App\Http\Controllers;

use App\Models\FWuser;
use App\Models\Post;
use App\Models\Vote;
use App\Models\Comment;
use App\Models\Mobile_notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use DB;

use App\Notifications\MobileNotification;
use Notification;

class FWuserController extends Controller
{

    public function veiwPage()
    {
        $trending_Notifications = DB::table('notifications')
            ->join('posts','posts.id','=','notifications.data->post_id')
            ->join('f_wusers','f_wusers.id','=','posts.user_id')
            ->select('posts.id','notifications.read_at','notifications.created_at','posts.title','f_wusers.username')
            ->groupBy('posts.id','notifications.read_at','notifications.created_at','posts.title','f_wusers.username')
            ->orderBy('notifications.created_at','DESC')->get();
        
        return view('pages.manage-user', compact('trending_Notifications'));
    }
    

    public function index()
    {
      $users =  FWuser::paginate(5);
      return response()->json($users);
    }

    public function store(Request $request)
    {
        if(FWuser::where('username', '=', $request->username)->exists())
         {
             return response()->json('user already exists!');
         }
        else
         {
            $storeUser = new FWuser;
            $storeUser->username = $request->username;
            $storeUser->password = Hash::make($request->password);
            $storeUser->userToken = '';
            $storeUser->save();
                
            return response()->json('user created!');
        }
    }

    public function show($id)
    {
        $user = FWuser::findorfail($id);
        return response()->json($user);
    }

    public function destroy($id)
    {
        $user = FWuser::find($id);
        $post = Post::where('user_id',$id);
        $comment = Comment::where('user_id',$id);
        $votes = Vote::where('user_id',$id);

        $user->delete();
        $post->delete();
        $comment->delete();
        $votes->delete();

        return response()->json('User deleted!');
    }

     public function searchUser(Request $request)
     {
        $data = FWuser::where('username', 'like', '%' .$request->searchdata. '%')->paginate(5);
        return response()->json($data);
     }

     public function getUserdetails($id)
     {
        $userdetails = DB::table('f_wusers')->where('id', $id)->get();
       // $userpost = DB::table('posts')->where('user_id', $id)->get();
        
        $userpost = DB::table('posts')
        ->leftJoin('votes','votes.post_id','=','posts.id')
        ->leftJoin('comments','comments.post_id','=','posts.id')
        ->join('f_wusers','f_wusers.id','=','posts.user_id')                                                                               
        ->select('posts.id','posts.title','posts.description','posts.anonymous','posts.status','posts.upvote_count','posts.downvote_count','posts.user_id','posts.created_at','posts.updated_at','f_wusers.username', 
          DB::raw("count(comments.comment_content) as count_comments"))
        ->groupBy('posts.id','posts.title','posts.description','posts.anonymous','posts.status','posts.upvote_count','posts.downvote_count','posts.user_id','posts.created_at','posts.updated_at','f_wusers.username')
        ->where('posts.user_id', $id)
        ->orderBy('posts.created_at','DESC')->get();

        $useractivities_totalPost = Post::where('user_id',$id)->where('anonymous','')->count();
        $useractivities_totalapprovedPost = Post::where('user_id',$id)->where('status','1')->where('anonymous','')->count();
        $useractivities_comments = Comment::where('user_id',$id)->count();

        return response()->json(['userdetails' => $userdetails , 'userpost' => $userpost, 'useractivities_totalPost' => $useractivities_totalPost,
         'useractivities_totalapprovedPost' => $useractivities_totalapprovedPost, 'useractivities_comments' => $useractivities_comments, 
        ]);
     }

     public function updateUserpost($id)
    {
        Post::where('id', $id)->update(['status' => 1]);

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

        return response()->json('Post successfully updated!');
    }

    public function destroyUserpost($id)
    {
    
        $post = Post::find($id);
        $post->delete();
        
        $comments = Comment::where('post_id',$id);
        $comments->delete();

        $vote = Vote::where('post_id',$id);
        $vote->delete();

        return response()->json('Post deleted!');
    }

    public function view_user_page($id)
    {
        if(FWuser::where('id' ,'=', $id)->exists())
        {   
            $trending_Notifications = DB::table('notifications')
            ->join('posts','posts.id','=','notifications.data->post_id')
            ->join('f_wusers','f_wusers.id','=','posts.user_id')
            ->select('posts.id','notifications.read_at','notifications.created_at','posts.title','f_wusers.username')
            ->groupBy('posts.id','notifications.read_at','notifications.created_at','posts.title','f_wusers.username')
            ->orderBy('notifications.created_at','DESC')->get();
    
            return view('pages.manage-user',compact('trending_Notifications'));
        }
        else
        {
            abort(404);
        }
    }
    
   
    
}
