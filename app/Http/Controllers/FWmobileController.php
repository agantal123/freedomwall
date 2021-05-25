<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Vote;
use App\Models\Post;
use App\Models\Mobile_notification;
use App\Models\Comment;
use App\Models\User;
use App\Models\FWuser;
use DB;

use App\Notifications\NewTrendingPostNotification;
use Notification;



class FWmobileController extends Controller
{
    public function loginFWuser(Request $request)
    {
       
        $json = file_get_contents('php://input');
        $user = json_decode($json,true);

        $username = $user['username'];
        $password = $user['password'];

        $user = DB::table('f_wusers')->where('username', $username)->first();
        if($user != null)
        {
            if(Hash::check($password, $user->password))
            {
                    $message_response = $user->id;
                    return response()->json($message_response);
            }
             else
            {
                $message_response = 'Invalid Credentials' ;
                return response()->json($message_response);
            }
        }
        else
        {
            $message_response = 'Invalid Credentials' ;
            return response()->json($message_response);
        }  
    }

    public function registerFWuser(Request $request)
    {
    
            $json = file_get_contents('php://input');
            $user = json_decode($json,true);
            
             $username = $user['username'];
             $checkuser = DB::table('users')->where('username',$username)->first();
             
             if($checkuser === null)
             {
                $add_user = new FWuser;
                $add_user->username = $username;
                $add_user->password = Hash::make($user['password']);
                $add_user->userToken = '';
               // $add_user->password = $user['password'];
                $add_user->save();
                
                $InvalidMSG = 'Account created successfully!';
                return response()->json($InvalidMSG);
             }
             else
             {
                 $InvalidMSG = 'Username already existed!' ;
                 return response()->json($InvalidMSG);
             }
    }

    public function change_password()
    {
        $json = file_get_contents('php://input');
        $user = json_decode($json,true);
            
        $username = $user['username'];
        $old_password = $user['password'];
        $new_password = $user['new_password'];

        $checkuser = DB::table('f_wusers')->where('username',$username)->first();
        
        if(Hash::check($old_password, $checkuser->password))
        {
            DB::table('f_wusers')->where('username', $username)->update(['password' => Hash::make($new_password) ]);

            $message_response = 'Password Changed!' ;
            return response()->json($message_response);
        }
        else
        {
            $message_response = 'Invalid old password' ;
            return response()->json($message_response);
        }
    }

    public function addTokenToUser()
    {
        $json = file_get_contents('php://input');
        $userInfo = json_decode($json,true);

        $username = $userInfo['username'];
        $token = $userInfo['userToken'];
        
        DB::table('f_wusers')->where('username', $username)->update(['userToken' => $token ]);
    
    }

    public function deleteMyToken()
    {
        $json = file_get_contents('php://input');
        $userInfo = json_decode($json,true);

        $username = $userInfo['username'];
        $emptyToken = '';
        DB::table('f_wusers')->where('username', $username)->update(['userToken' => $emptyToken ]);
    }

    public function getRecentPost()
    {
 
        $recentgpost = DB::table('posts')
        ->leftJoin('votes','votes.post_id','=','posts.id')
        ->leftJoin('comments','comments.post_id','=','posts.id')
        ->join('f_wusers','f_wusers.id','=','posts.user_id')                                                                               
        ->select('posts.id','posts.title','posts.description','posts.anonymous','posts.status','posts.upvote_count','posts.downvote_count','posts.user_id','posts.created_at','posts.updated_at','f_wusers.username', 
          DB::raw("count(comments.comment_content) as count_comments"))
         ->groupBy('posts.id','posts.title','posts.description','posts.anonymous','posts.status','posts.upvote_count','posts.downvote_count','posts.user_id','posts.created_at','posts.updated_at','f_wusers.username')
        ->orderBy('posts.created_at','DESC')->get();

        return response()->json($recentgpost);
    }

    public function getTrendingPost()
    {
        $trendingpost = DB::table('posts')
        ->leftJoin('votes','votes.post_id','=','posts.id')
        ->leftJoin('comments','comments.post_id','=','posts.id')
        ->join('f_wusers','f_wusers.id','=','posts.user_id')                                                                               
        ->select('posts.id','posts.title','posts.description','posts.anonymous','posts.status','posts.upvote_count','posts.downvote_count','posts.user_id','posts.created_at','posts.updated_at','f_wusers.username', 
         DB::raw("count(comments.comment_content) as count_comments"))
         ->groupBy('posts.id','posts.title','posts.description','posts.anonymous','posts.status','posts.upvote_count','posts.downvote_count','posts.user_id','posts.created_at','posts.updated_at','f_wusers.username')
        ->orderBy('posts.upvote_count','DESC')->get();
        
        return response()->json($trendingpost);
    }

    public function store_post()
    {
        $json = file_get_contents('php://input');
        $store = json_decode($json,true);
        
        $username = $store['user_post'];
        $userpost = db::table('f_wusers')->where('username','=',$username)->first();
        
        $store_post = new Post;
        $store_post->title = $store['title'];
        $store_post->description = $store['description'];
        $store_post->anonymous = $store['anon'];
        $store_post->status = 0;
        $store_post->user_id = $userpost->id;
        $store_post->save();
    }

    public function deleteMyPost()
    {
   
          $json = file_get_contents('php://input');
          $user_postID = json_decode($json,true);
          
          $post_id = $user_postID['post_id'];

          DB::table('posts')->where('id',$post_id)->delete();
          DB::table('votes')->where('post_id',$post_id)->delete();
          DB::table('comments')->where('post_id',$post_id)->delete();
          DB::table('mobile_notification')->where('post_id',$post_id)->delete();
    
    }

    public function checkUpvotePost()
    {
        $upvote = "upvote";
        $votes = DB::table('votes')
        ->leftJoin('f_wusers','f_wusers.id','=','votes.user_id')
        ->select('votes.id','votes.vote_type','votes.post_id','f_wusers.username')
        ->groupBy('votes.id','votes.vote_type','votes.post_id','f_wusers.username')
        ->orderBy('votes.created_at','desc')
        ->where('votes.vote_type',$upvote)
        ->get();
        return response()->json($votes);
    }
    
    public function checkDownvotePost()
    {
        $downvote = "downvote";
        $votes = DB::table('votes')
        ->leftJoin('f_wusers','f_wusers.id','=','votes.user_id')
        ->select('votes.id','votes.vote_type','votes.post_id','f_wusers.username')
        ->groupBy('votes.id','votes.vote_type','votes.post_id','f_wusers.username')
        ->orderBy('votes.created_at','desc')
        ->where('votes.vote_type',$downvote)
        ->get();
        return response()->json($votes);
    }

    public function mobileUpvotePost(Request $request)
    {
        $json = file_get_contents('php://input');
        $store = json_decode($json,true);
        
        $post_id = $store['post_id'];
        $user = $store['username'];
        
        $userpost = db::table('f_wusers')->where('username','=', $user)->first();
        $upvote = "upvote";
        $downvote = "downvote";

        $check_vote_upvote = DB::table('votes')->where('user_id', $userpost->id)->where('post_id',$post_id)->where('vote_type',$upvote)->first();
        $check_vote_downvote = DB::table('votes')->where('user_id', $userpost->id)->where('post_id',$post_id)->where('vote_type',$downvote)->first(); 

        if($check_vote_upvote === null)
        {
            if($check_vote_downvote === null)
            {
                DB::table('posts')->where('id', $post_id)->increment('upvote_count');
                $store_vote = new Vote;
                $store_vote->vote_type = $upvote;
                $store_vote->post_id = $post_id;
                $store_vote->user_id = $userpost->id;
                $store_vote->save();

                $get_trending_post = DB::table('posts')->where('upvote_count','>=',3)->get();
                foreach($get_trending_post as $records)
                {
                    $checkifexist = DB::table('notifications')->where('data->post_id','=', $records->id)->first();
                    if($checkifexist == null)
                    {
                        Notification::send(User::where('id',1)->first(),new NewTrendingPostNotification($records));
                    }
                }

                $SuccessMsg = 'post upvoted';
                return response()->json($SuccessMsg);
            }
            else
            {   
                DB::table('posts')->where('id', $post_id)->increment('upvote_count');
                DB::table('posts')->where('id', $post_id)->decrement('downvote_count');
                DB::table('votes')->where('user_id', $userpost->id)->where('post_id',$post_id)->update(['vote_type' => 'upvote' ]);
                
                foreach($get_trending_post as $records)
                    {
                        $checkifexist = DB::table('notifications')->where('data->post_id','=', $records->id)->first();
                        if($checkifexist == null)
                        {
                            Notification::send(User::where('id',1)->first(),new NewTrendingPostNotification($records));
                        }
                    }

                $SuccessMsg = 'post upvoted';
                return response()->json($SuccessMsg);
            }
        }
        else
        {
             DB::table('posts')->where('id', $post_id)->decrement('upvote_count');
             DB::table('votes')->where('user_id', $userpost->id)->where('post_id',$post_id)->delete();
             
             $InvalidMSG = 'post upvote removed';
             return response()->json($InvalidMSG);
        }
    }

    public function mobileDownvotePost(Request $request)
    {
        $json = file_get_contents('php://input');
        $store = json_decode($json,true);
        
        $post_id = $store['post_id'];
        $user = $store['username'];
        
        $userpost = db::table('f_wusers')->where('username','=', $user)->first();
        $upvote = "upvote";
        $downvote = "downvote";

        $check_vote_upvote = DB::table('votes')->where('user_id', $userpost->id)->where('post_id',$post_id)->where('vote_type',$upvote)->first();
        $check_vote_downvote = DB::table('votes')->where('user_id', $userpost->id)->where('post_id',$post_id)->where('vote_type',$downvote)->first();
        
        if($check_vote_downvote === null)
        {
            if($check_vote_upvote === null)
            {
                DB::table('posts')->where('id', $post_id)->increment('downvote_count');
                $store_vote = new Vote;
                $store_vote->vote_type = $downvote;
                $store_vote->post_id = $post_id;
                $store_vote->user_id = $userpost->id;
                $store_vote->save();

                $SuccessMsg = 'post downvote';
                return response()->json($SuccessMsg);
            }
            else
            {   
                DB::table('posts')->where('id', $post_id)->increment('downvote_count');
                DB::table('posts')->where('id', $post_id)->decrement('upvote_count');
                DB::table('votes')->where('user_id', $userpost->id)->where('post_id',$post_id)->update(['vote_type' => 'downvote' ]);
                
                $SuccessMsg = 'post downvote';
                return response()->json($SuccessMsg);
            }
        }
        else
        {
             DB::table('posts')->where('id', $post_id)->decrement('downvote_count');
             DB::table('votes')->where('user_id', $userpost->id)->where('post_id',$post_id)->delete();
             
             $InvalidMSG = 'post downvote';
             return response()->json($InvalidMSG);
        }
    }

    public function viewFullpost()
    {
         $json = file_get_contents('php://input');
         $id = json_decode($json,true);
      
         $postid = $id['id'];
        
        $postdetails = DB::table('posts')
        ->leftJoin('votes','votes.post_id','=','posts.id')
        ->leftJoin('comments','comments.post_id','=','posts.id')
        ->join('f_wusers','f_wusers.id','=','posts.user_id')                                                                               
        ->select('posts.id','posts.title','posts.description','posts.anonymous','posts.status','posts.upvote_count','posts.downvote_count','posts.user_id','posts.created_at','posts.updated_at','f_wusers.username', 
          DB::raw("count(comments.comment_content) as count_comments"))
         ->groupBy('posts.id','posts.title','posts.description','posts.anonymous','posts.status','posts.upvote_count','posts.downvote_count','posts.user_id','posts.created_at','posts.updated_at','f_wusers.username')
         ->where('posts.id', $postid)
         ->first();
        
       // $postdetails = DB::table('posts')->where('id', $postid)->get();
        return response()->json($postdetails);
    }

    public function view_comment()
    {
       // $comment = DB::table('comments')->orderBy('created_at','desc')->get();
        $comment = DB::table('comments')
        ->join('f_wusers','f_wusers.id','=','comments.user_id')
        ->select('comments.id','comments.comment_content','comments.user_id','comments.post_id','comments.created_at','f_wusers.username')
        ->groupBy('comments.id','comments.comment_content','comments.user_id','comments.post_id','comments.created_at','f_wusers.username')
        ->get();
        return response()->json($comment);
    }
    
    public function store_comment()
    {
        $json = file_get_contents('php://input');
        $store = json_decode($json,true);
        
        
        //$userFromPost = $store['username'];
        $this_postID = $store['post_id'];

        $username = $store['username'];
        $userpost = db::table('f_wusers')->where('username','=', $username)->first();
        
        
        $checkmypost = DB::table('posts')->select('id')->where('user_id',$userpost->id)->get();
        if($checkmypost->contains('id', $this_postID))  
        {
            $store_comment = new Comment;
            $store_comment->comment_content = $store['comment'];
            $store_comment->post_id = $store['post_id'];
            $store_comment->user_id = $userpost->id;
            $store_comment->save();
        
        }
        else
        {
            $store_comment = new Comment;
            $store_comment->comment_content = $store['comment'];
            $store_comment->post_id = $store['post_id'];
            $store_comment->user_id = $userpost->id;
            $store_comment->save();
            
            $store_notif = new Mobile_notification;
            $store_notif->notification_type = 'commented on your post';
            $store_notif->post_id = $store['post_id'];
            $store_notif->notification_from_user = $store['username'];
            $store_notif->seen_notification = 0;
            $store_notif->comment_id = $store_comment->id;
            $store_notif->save();
        }
    }

    public function deleteMyComment()
    {
          $json = file_get_contents('php://input');
          $user_commentID = json_decode($json,true);
          
          $comment_id = $user_commentID['comment_id'];
          DB::table('comments')->where('id',$comment_id)->delete();
          DB::table('mobile_notification')->where('comment_id',$comment_id)->delete();
          
    }

    public function view_my_notification()
    {
        $data = DB::table('mobile_notification')
        ->join('posts', 'mobile_notification.post_id', '=', 'posts.id')
        ->join('f_wusers', 'posts.user_id', '=', 'f_wusers.id')
        ->select('mobile_notification.notification_id','mobile_notification.notification_type','mobile_notification.notification_from_user','mobile_notification.post_id','mobile_notification.seen_notification','mobile_notification.updated_at','posts.user_id','f_wusers.username'
        )->orderBy('mobile_notification.updated_at','desc')
        ->get();
       // $my_notif = DB::table('mobile_notif')->orderBy('created_at','desc')->get();
        return response()->json($data);
    }

    public function seen_notification()
    {
          $json = file_get_contents('php://input');
          $user_cred = json_decode($json,true);
          
          $this_postID = $user_cred['notif_postId'];

          DB::table('mobile_notification')->where('notification_id', $this_postID)->update(['seen_notification' => 1 ]);
    }

    public function mobileUnreadNotificationCount()
    {
        $notification_count = DB::table('mobile_notification')
        ->join('posts', 'mobile_notification.post_id', '=', 'posts.id')
        ->join('f_wusers', 'posts.user_id', '=', 'f_wusers.id')
        ->select('mobile_notification.notification_id','mobile_notification.notification_type','mobile_notification.notification_from_user','mobile_notification.post_id','mobile_notification.seen_notification','mobile_notification.updated_at','posts.user_id','f_wusers.username')
        ->where('mobile_notification.seen_notification','0')
        ->count();

        return response()->json($notification_count);
    }

}
