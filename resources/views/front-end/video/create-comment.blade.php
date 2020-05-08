@if(auth()->user())
    <form action="{{route('front.commentStore',['id'=>$video->id])}}" method="POST">
        {{csrf_field()}}

        <div class="form-group">
            <label>Add Comment</label>
            <textarea name="comment" class="form-control" rows="4"></textarea>
        </div>
        <button type="submit" class="btn btn-default">Add Comment</button>
    </form>
@endif