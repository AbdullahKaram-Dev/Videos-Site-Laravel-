<?php

namespace App\Http\Controllers;

use App\Http\Requests\FrontEnd\Comments\Store;
use App\Message;
use App\Models\Category;
use App\Models\Comments;
use App\Models\Page;
use App\Models\Skill;
use App\Models\Tag;
use App\Models\User;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->only([

        'commentUpdate','commentStore','profileUpdate'

        ]);
    }


    public function index()
    {
        $videos = Video::Published()->orderBy('id','desc');
         if(request()->has('search') && request()->get('search') != ''){

             $videos = Video::where('name','like','%'.request()->get('search').'%');
         }
        $videos = $videos->paginate(30);
        return view('home',compact('videos'));
    }


    public function category($id){

        $cat = Category::findOrfail($id);

        $videos = Video::Published()->where('cat_id',$id)->orderBy('id','desc')->paginate(30);
        return view('front-end.category.index',compact('videos','cat'));

    }

    public function video($id){


        $video = Video::Published()->with('skills','tags','cat','user','comments.user')->findOrfail($id);
        return view('front-end.video.index',compact('video'));

    }

    public function skills($id){

        $skill = Skill::findOrfail($id);
        $videos = Video::Published()->whereHas('skills',function ($query) use($id){

            $query->where('skill_id',$id);

        })->orderBy('id','desc')->paginate(30);
        return view('front-end.skill.index',compact('videos','skill'));

    }

    public function tags($id){

        $tag = Tag::findOrfail($id);
        $videos = Video::Published()->whereHas('tags',function ($query) use($id){

            $query->where('tag_id',$id);

        })->orderBy('id','desc')->paginate(30);
        return view('front-end.tag.index',compact('videos','tag'));

    }

    public function commentUpdate($id ,Store $request){

        $comment = Comments::findOrfail($id);
        if(($comment->user_id == auth()->user()->id) || auth()->user()->group == 'admin'){
            $comment->update(['comment'=>$request->comment]);
            alert()->success('your Comment has been Updated ','done');
        }
          return redirect()->route('frontend.video',['id'=>$comment->video_id,'#comments']);
    }

    public function commentStore($id ,Store $request){

        $video = Video::Published()->findOrfail($id);
        Comments::create([
            'user_id'=> auth()->user()->id,
            'video_id'=> $video->id,
            'comment'=> $request->comment
                        ]);


        return redirect()->route('frontend.video',['id'=>$video->id,'#comments']);
    }

    public function messageStore(Request $request){

        \App\Models\Message::create($request->all());

        return redirect()->route('frontend.landing');
    }


    public function welcome(){

        $videos = Video::Published()->orderBy('id','desc')->paginate(12);

        $videos_count = Video::Published()->count();
        $comments_count = Comments::count();
        $tags_count = Tag::count();

        return view('welcome',compact('videos','videos_count','comments_count','tags_count'));

    }

    public function page($id,$slug = null){

         $page = Page::findOrFail($id);
         return view('front-end.page.index',compact('page'));
    }

    public function profile($id,$slug = null){

        $user = User::findOrFail($id);
        return view('front-end.profile.index',compact('user'));
    }

    public function profileUpdate(\App\Http\Requests\FrontEnd\Users\Store $request){

        $user = User::findOrFail(auth()->user()->id);
        $array = [];

        if($request->email != $user->email){

            $email = User::where('email',$request->email)->first();
            if($email == null){

                $array['email'] =$request->email;
            }

        }

        if($request->name != $user->name){

            $array['name'] =$request->name;
        }

        if($request->password != ''){

            $array['password'] = Hash::make($request->password);
        }

        if(!empty($array)){

            $user->update($array);
        }
        return redirect()->route('front.profile',['id' => $user->id,'slug'=>slug($user->name)]);
    }

}
