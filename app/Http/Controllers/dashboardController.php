<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\FWuser;
use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Notifications\MobileNotification;
use App\Notifications\NewTrendingPostNotification;
use Notification;


class dashboardController extends Controller
{
    //
    
    public function index()
    {


        $current_date = Carbon::today()->toDateString();
        $FWusercount = FWuser::count();
        $postCount_currDate = Post::whereDate('created_at', Carbon::today())->count();
        $approvedPost = Post::where('status',1)->count();

        $recentlyApproved = Post::where('status','1')->orderBy('created_at','DESC')->take(2)->get();
        
        $trending_Notifications = DB::table('notifications')
        ->join('posts','posts.id','=','notifications.data->post_id')
        ->join('f_wusers','f_wusers.id','=','posts.user_id')
        ->select('posts.id','notifications.read_at','notifications.created_at','posts.title','f_wusers.username')
        ->groupBy('posts.id','notifications.read_at','notifications.created_at','posts.title','f_wusers.username')
        ->orderBy('notifications.created_at','DESC')->get();

        return view('pages.home', compact('FWusercount','postCount_currDate','approvedPost','trending_Notifications','recentlyApproved'));
    }

    public function notifications()
    {

        $trending_Notifications = DB::table('notifications')
        ->join('posts','posts.id','=','notifications.data->post_id')
        ->join('f_wusers','f_wusers.id','=','posts.user_id')
        ->select('posts.id','notifications.read_at','notifications.created_at','posts.title','f_wusers.username')
        ->groupBy('posts.id','notifications.read_at','notifications.created_at','posts.title','f_wusers.username')
        ->orderBy('notifications.created_at','DESC')->get();
    
        return view('layouts.app', compact('trending_Notifications'));
    }

    public function dashboardsearch(Request $request)
    {   
      
        $keyword_search = $request->search;
        $filteredPosts = Post::where('title', 'like', '%' .$request->search. '%')
                             ->orWhere('description', 'like', '%' .$request->search. '%')
                             ->leftJoin('comments','comments.post_id','=','posts.id')
                            ->join('f_wusers','f_wusers.id','=','posts.user_id')                                                                               
                            ->select('posts.id','posts.title','posts.description','posts.anonymous','posts.status','posts.user_id','posts.upvote_count','posts.downvote_count','posts.created_at','posts.updated_at','f_wusers.username', DB::raw("count(comments.comment_content) as count_comments"))
                            ->groupBy('posts.id','posts.title','posts.description','posts.anonymous','posts.status','posts.user_id','posts.upvote_count','posts.downvote_count','posts.created_at','posts.updated_at','f_wusers.username')
                             ->get();
    
        $trending_Notifications = DB::table('notifications')
        ->join('posts','posts.id','=','notifications.data->post_id')
        ->join('f_wusers','f_wusers.id','=','posts.user_id')
        ->select('posts.id','notifications.read_at','notifications.created_at','posts.title','f_wusers.username')
        ->groupBy('posts.id','notifications.read_at','notifications.created_at','posts.title','f_wusers.username')
        ->orderBy('notifications.created_at','DESC')->get();
                             
    
        return view('pages.searchpage', compact('filteredPosts','keyword_search','trending_Notifications'));
    }
        
    public function userpost($id)
    {   
        $mypost = Post::where('id', $id)->first();
        return view('pages.viewpost', compact('mypost'));
    }

    public function adminNotification()
    {
        $trending_Notifications = DB::table('notifications')
        ->join('posts','posts.id','=','notifications.data->post_id')
        ->join('f_wusers','f_wusers.id','=','posts.user_id')
        ->select('posts.id','posts.anonymous','notifications.read_at','notifications.created_at','posts.title','f_wusers.username')
        ->groupBy('posts.id','posts.anonymous','notifications.read_at','notifications.created_at','posts.title','f_wusers.username')
        ->orderBy('notifications.created_at','DESC')->get();

        $trending_notification_count = DB::table('notifications')->whereNull('read_at')->count();
       
        return response()->json(compact('trending_Notifications','trending_notification_count'));
    }
}
