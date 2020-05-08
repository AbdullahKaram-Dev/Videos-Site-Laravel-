@extends('layouts.app')

@section('title',$video->name)

@section('meta_keyword',$video->meta_keyword)

@section('meta_des',$video->meta_des)

@section('content')
    <div class="section section-buttons">
        <div class="container">
            <div class="title">
                <h1>{{$video->name}}</h1>
            </div>
            <div class="row">

                <div class="col-md-12">

                    @php $url =getYoutubeId($video->youtube) @endphp


                    @if($url)
                        <iframe width="100%" height="500" src="https://www.youtube.com/embed/{{$url}}" frameborder="0"
                                style="margin-bottom: 20px" allowfullscreen></iframe>
                        <br>
                    @endif

                </div>
            </div>
            <div class="row">
                <div class="row badge-pill badge-red">

                    <ul>
                        <li class="nc-icon nc-align-center">


                            <p>
                                {{$video->user->name}}
                            </p>
                        </li>
                    </ul>

                    <ul>
                        <li class="nav-item">
                            <p>
                                {{$video->created_at}}
                            </p>
                        </li>
                    </ul>


                    <ul>
                        <li class="nav-item">
                            <p>
                                {{$video->des}}
                            </p>
                        </li>
                    </ul>


                    <ul>
                        <li class="nav-item">
                            <p>
                                <a href="{{ route('front.category',['id'=>$video->cat->id]) }}">
                                    {{$video->cat->name}}
                                </a>
                            </p>
                        </li>
                    </ul>


                    <ul>TAGS
                        <li class="nav-item card">
                            <p>

                                @foreach($video->tags as $tag)
                                    <br>
                                    <a href="{{ route('front.tags',['id'=>$tag->id]) }}">

                                        <span class="badge badge-pill badge-primary">{{$tag->name}}</span>
                                    </a>
                                @endforeach
                            </p>
                        </li>
                    </ul>

                    <ul>SKILLS
                        <li class="nav-item card">
                            <p>

                                @foreach($video->skills as $skill)
                                    <br>
                                    <a href="{{ route('front.skill',['id'=>$skill->id]) }}">
                                        <span class="badge badge-pill badge-info">{{$skill->name}}</span>
                                    </a>
                                @endforeach
                            </p>
                        </li>
                    </ul>
                </div>
            </div>

            <br><br>

            <div class="row" id="comments">

                <div class="col-md-12">

                    <div class="card text-left">
                        <div class="card-header card-header-rose">
                            @php $comments = $video->comments  @endphp
                            <h5>Comments({{count($comments)}})</h5>

                        </div>
            @include('front-end.video.comments')
                    </div>
                </div>
            </div>
            @include('front-end.video.create-comment')
        </div>
    </div>
@endsection
