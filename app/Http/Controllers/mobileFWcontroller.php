<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class mobileFWcontroller extends Controller
{
    public function store(Request $request)
    {
       
       // $coins = Coin::all();
       // return response()->json($coins);

        $json = file_get_contents('php://input');
        $user = json_decode($json,true);
        
        
         $username = $user['username'];
         $checkuser = DB::table('users')->where('username',$username)->first();
         
         if($checkuser === null)
         {
            $add_user = new FW_users;
            $add_user->username = $username;
            $add_user->password = $user['password'];
            $add_user->save();
            
            $InvalidMSG = 'Account created successfully!';
            return response()->json($InvalidMSG);
         }
         else
         {
             $InvalidMSG = 'Username already existed!' ;
             return response()->json($InvalidMSG);
         }

      //  $add_user = new FW_users;
     //   $add_user->username = $user['username'];
       // $add_user->password = $user['password'];
      //  $add_user->save();
        
        /*
        $names = ['test1','test2','test3'];
        return response()->json(['names' => $names]);
        */
        
    }
    public function login(Request $request){
       
        $json = file_get_contents('php://input');
        $user = json_decode($json,true);

        $username = $user['username'];
        $password = $user['password'];

        $user = DB::table('users')->where('username', $username)->where('password',$password)->first();
       
        if($user === null){

             // If the record inserted successfully then show the message.
             $InvalidMSG = 'Invalid Username or Password Please Try Again' ;
            
             // Converting the message into JSON format.
            // $InvalidMSGJSon = json_encode($InvalidMSG);
            return response()->json($InvalidMSG);
            
            }
            
            else{

                $SuccessLoginMsg = 'Data Matched';
            
                // Converting the message into JSON format.
              // $SuccessLoginJson = json_encode($SuccessLoginMsg);
            
               return response()->json($SuccessLoginMsg);
            }
            }
       /* $loginDetails = FW_users::all();
        if(Auth::attempt($loginDetails)){
            return response()->json(['message' => 'login successful', 'code' => 200]);
        }else{
            return response()->json(['message' => 'wrong login details', 'code' => 501]);
        }
        */
    
    public function store_post()
    {
        $json = file_get_contents('php://input');
        $store = json_decode($json,true);
        
        $date_now = Carbon::now();
        
        $store_post = new Post;
        $store_post->title = $store['title'];
        $store_post->description = $store['description'];
        $store_post->date = $date_now;
        $store_post->user_post = $store['user_post'];
        $store_post->status = '';
        $store_post->anon = $store['anon'];
        $store_post->votes = 0;
        $store_post->save();
    }
    
    
    
    public function store_comment()
    {
        $json = file_get_contents('php://input');
        $store = json_decode($json,true);
        
        $date_now = Carbon::now();
        
        $userFromPost = $store['username'];
        $this_postID = $store['post_id'];
        
        $checkmypost = DB::table('post')->select('id')->where('user_post',$userFromPost)->get();
        
        if($checkmypost->contains('id', $this_postID))
        {
            $store_comment = new Comment;
            $store_comment->comment = $store['comment'];
            $store_comment->date = $date_now;
            $store_comment->post_id = $store['post_id'];
            $store_comment->username = $store['username'];
            $store_comment->save();
            
            
        }
        else
        {
            $store_comment = new Comment;
            $store_comment->comment = $store['comment'];
            $store_comment->date = $date_now;
            $store_comment->post_id = $store['post_id'];
            $store_comment->username = $store['username'];
            $store_comment->save();
            
            $store_notif = new mobile_notification;
            $store_notif->notif_type = 'commented on your post';
            $store_notif->post_id = $store['post_id'];
            $store_notif->username = $store['username'];
            $store_notif->background_color = '#e8dbdb';
            $store_notif->comment_id = $store_comment->id;
            $store_notif->save();
        }
    }
    
    
    
       public function unvote_post()
    {
        $json = file_get_contents('php://input');
        $store = json_decode($json,true);
        
        $post_id = $store['post_id'];
        DB::table('post')->where('id', $post_id)->decrement('votes');

    }
    


    public function test()
    {
        $names = ['Warren', 'jawad','Mark'];
        $things = ['Phone','Candles','battery'];
        return response()->json(['names' => $names, 'things' => $things]);
    }

    public function view_post()
    {
       // $data = DB::table('registry')->orderBy('reg_date', 'desc')->get();

        $post1 = DB::table('post')->orderBy('created_at','desc')->get();
        return response()->json($post1);
    }
    
        public function sort_post()
    {
      
        $post2 = DB::table('post')->orderBy('votes','desc')->get();
        return response()->json($post2);
    }
    
    public function view_comment()
    {
        $comment = DB::table('comment')->orderBy('created_at','desc')->get();
        return response()->json($comment);
    }
    
    private $var;
    public function view_my_post()
    {
       
       
        $json = file_get_contents('php://input');
        $user = json_decode($json,true);

        $username = $user['userDetails'];
        
        $this->var = $username;
        $this->view_my_post2();

      //  $mypost = DB::table('users')->where('user', $username)->orderBy('created_at','desc')->get();
        
      //  return response()->json($mypost);
     

    }
    public function view_my_post2()
    {
        
        $data= $this->var;
        $mypost = DB::table('users')->where('user_post', $data)->orderBy('created_at','desc')->get();
        
        return response()->json($mypost);
    }
    public function viewcomment()
    {
          $json = file_get_contents('php://input');
          $id = json_decode($json,true);
        
          $postid = $id['id'];
          $postdetails = DB::table('post')->where('id', $postid)->get();
          return response()->json($postdetails);
       // $checkuser = DB::table('users')->where('username',$username)->first();
    }
    public function change_password(Request $request)
    {
          $json = file_get_contents('php://input');
          $user_cred = json_decode($json,true);
          
          $username = $user_cred['username'];
          $password = $user_cred['password'];
          $new_password = $user_cred['new_password'];
          
          
          $userz = DB::table('users')->where('username', $username)->where('password',$password)->first();
          
       //   $user = DB::table('users')->where('username', $username)->where('password', $password)-first();
          if($userz === null)
          {
             $InvalidMSG = 'Invalid Password Please Try Again' ;
             return response()->json($InvalidMSG);
            
          }
          else
          {
              //$updatedata = FW_users::find($username);
             // $updatedata->password = $user_cred['new_password'];
             // $updatedata->save();
              DB::table('users')->where('username', $username)->update(['password' => $new_password]);
              
              $SuccessLoginMsg = 'Password Changed!';
              return response()->json($SuccessLoginMsg);
          }
          
    }
    
    public function vote_post(Request $request)
    {
        $json = file_get_contents('php://input');
        $store = json_decode($json,true);
        
        $post_id = $store['post_id'];
        $user = $store['username'];
        
        
        $check_vote = DB::table('votes')->where('username', $user)->where('post_id',$post_id)->first();
        if($check_vote === null)
        {
            DB::table('post')->where('id', $post_id)->increment('votes');
        
            $store_vote = new Votes;
            $store_vote->post_id = $post_id;
            $store_vote->username = $user;
            $store_vote->save();
            
             $SuccessMsg = 'post upvoted';
             return response()->json($SuccessMsg);

             $check_post = DB::table('posts')
             ->leftJoin('votes','votes.post_id','=','posts.id')
             ->leftJoin('comments','comments.post_id','=','posts.id')
             ->join('f_wusers','f_wusers.id','=','posts.user_id')                                                                               
             ->select('posts.id','posts.title','posts.description','posts.anonymous','posts.status','posts.user_id','posts.upvote_count','posts.downvote_count','posts.created_at','posts.updated_at','f_wusers.username', 
              DB::raw("count(comments.comment_content) as count_comments"))
             ->where('posts.upvote_count','>=',3)
             ->groupBy('posts.id','posts.title','posts.description','posts.anonymous','posts.status','posts.user_id','posts.upvote_count','posts.downvote_count','posts.created_at','posts.updated_at','votes.vote_type','f_wusers.username')
             ->get();
               foreach($check_post as $records)
               {
                   $checkifexist = DB::table('notifications')->where('data->post_id','=', $records->id)->first();
                   if($checkifexist == null)
                   {
                       auth()->user()->notify(new NewTrendingPostNotification($records));
                   }
               } 
        }
        else
        {
             DB::table('post')->where('id', $post_id)->decrement('votes');
             DB::table('votes')->where('username', $user)->where('post_id',$post_id)->delete();
             
             $InvalidMSG = 'post downvoted';
             return response()->json($InvalidMSG);
        }
    }
    
    public function check_like_post()
    {
        $votes = DB::table('votes')->orderBy('created_at','desc')->get();
        return response()->json($votes);
    }

    public function check_notif_count()
    {
       
        /*
        $color = '#e8dbdb';
        $get_notif_count = DB::table('mobile_notif')
        ->join('post', 'mobile_notif.post_id', '=', 'post.id')      
        ->select('mobile_notif.notif_id as notif_id','post.user_post', DB::raw("count(mobile_notif.background_color) as notif_count"))
        ->where('mobile_notif.background_color', '=', $color)
        ->groupBy('mobile_notif.notif_id','post.user_post') 
        ->get();
        */
        
        $color = '#e8dbdb';
        $get_notif_count = DB::table('mobile_notif')
        ->select('user_post', DB::raw("count(mobile_notif.background_color) as notif_count"))
        ->where('background_color', $color )
        ->groupBy('user_post')
        ->get();
        
        return response()->json($get_notif_count);
    }
    
    
    
     public function view_notification()
    {
        $data = DB::table('mobile_notif')
        ->join('post', 'mobile_notif.post_id', '=', 'post.id')
        ->select('mobile_notif.notif_id','mobile_notif.notif_type','mobile_notif.username','mobile_notif.post_id','mobile_notif.background_color','mobile_notif.updated_at','post.user_post')->orderBy('updated_at','desc')
        ->get();
       // $my_notif = DB::table('mobile_notif')->orderBy('created_at','desc')->get();
        return response()->json($data);
    }
    
    public function seen_notification()
    {
          $json = file_get_contents('php://input');
          $user_cred = json_decode($json,true);
          
          $this_postID = $user_cred['notif_postId'];
          $seen_color = 'white';
          DB::table('mobile_notif')->where('notif_id', $this_postID)->update(['background_color' => $seen_color ]);
    }
    
    public function deleteMyPost()
    {
          $json = file_get_contents('php://input');
          $user_postID = json_decode($json,true);
          
          $post_id = $user_postID['post_id'];
          DB::table('post')->where('id',$post_id)->delete();
          DB::table('votes')->where('post_id',$post_id)->delete();
          DB::table('comment')->where('post_id',$post_id)->delete();
    }
    
    public function deleteMyComment()
    {
          $json = file_get_contents('php://input');
          $user_commentID = json_decode($json,true);
          
          $comment_id = $user_commentID['comment_id'];
          DB::table('comment')->where('id',$comment_id)->delete();
          
    }
}
