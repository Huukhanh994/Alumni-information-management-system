@extends('layouts.admin')

@section('content')
<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v4.0"></script>
<link rel="stylesheet" href="{{asset('/css/style_posts_index.css')}}">
<style>
    a {
	color: #0254EB
    }
    a:visited {
        color: #0254EB
    }
    a.morelink {
        text-decoration:none;
        outline: none;
    }
    .morecontent span {
        display: none;
    }
    .comment {
        width: 400px;
        /* background-color: #f0f0f0; */
        margin: 10px;
    }
</style>
        <div class="row main">
            <div class="calendar-container">
                    @if($message = Session::get('success'))
                    <div class="alert alert-success" role="alert">
                        <p>{{$message}}</p>
                        <p class="mb-0"></p>
                    </div>
                    @endif
                <div class="col-sm-12 col-xs-12">
                    <div class="white-box">
                        <div class="posts_recommend">
                            <h3>Gợi ý bài viết cho bạn</h3>
                            <ul>
                            <li><a href="{{route('posts.categories_apply_job')}}">Tuyển dụng việc làm</a></li>
                            <li><a href="{{route('posts.categories_notifications')}}">Thông báo</a></li>
                            <li><a href="{{route('posts.categories_support_scholarship')}}">Hỗ trợ học bổng</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="calendar">
                        <div class="white-box">
                            <div id="calendar"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="white-box">
                        <div id="calendar-events" class="m-t-20">
                                <div class="calendar-events" data-class="bg-info"><i class="fa fa-circle text-info"></i> My Event One</div>
                                <div class="calendar-events" data-class="bg-success"><i class="fa fa-circle text-success"></i> My Event Two</div>
                                <div class="calendar-events" data-class="bg-danger"><i class="fa fa-circle text-danger"></i> My Event Three</div>
                                <div class="calendar-events" data-class="bg-warning"><i class="fa fa-circle text-warning"></i> My Event Four</div>
                            </div>
                            <!-- checkbox -->
                            <div class="checkbox">
                                <input id="drop-remove" type="checkbox">
                                <label for="drop-remove">
                                    Remove after drop
                                </label>
                            </div>
                            <a href="#" data-toggle="modal" data-target="#add-new-event" class="btn btn-lg m-t-40 btn-danger btn-block waves-effect waves-light">
                                <i class="ti-plus"></i> Add New Event
                            </a>
                    </div>
                </div>
                <!-- BEGIN MODAL -->
                <div class="modal none-border" id="my-event">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title"><strong>Add Event</strong></h4>
                                </div>
                                <div class="modal-body"></div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-white waves-effect" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-success save-event waves-effect waves-light">Create event</button>
                                    <button type="button" class="btn btn-danger delete-event waves-effect waves-light" data-dismiss="modal">Delete</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal Add Category -->
                    <div class="modal fade none-border" id="add-new-event">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title"><strong>Add</strong> a category</h4>
                                </div>
                                <div class="modal-body">
                                    <form role="form">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="control-label">Category Name</label>
                                                <input class="form-control form-white" placeholder="Enter name" type="text" name="category-name" />
                                            </div>
                                            <div class="col-md-6">
                                                <label class="control-label">Choose Category Color</label>
                                                <select class="form-control form-white" data-placeholder="Choose a color..." name="category-color">
                                                    <option value="success">Success</option>
                                                    <option value="danger">Danger</option>
                                                    <option value="info">Info</option>
                                                    <option value="primary">Primary</option>
                                                    <option value="warning">Warning</option>
                                                    <option value="inverse">Inverse</option>
                                                </select>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger waves-effect waves-light save-category" data-dismiss="modal">Save</button>
                                    <button type="button" class="btn btn-white waves-effect" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END MODAL -->
            </div>
            <div class="content-container">
                @foreach ($posts as $row)
                <div class="jumbotron" style="padding:24px 30px 24px 30px; height:500px;">
                    <div class="img">
                        <a href="{{url('posts/'.$row->category_slug.'/'.$row->post_slug)}}">
                        <img src="{{asset('/images/myfiles_cit/test_posts/cover-490x245.png')}}" alt="bai-dang-phan-quyen-sinh-vien image">
                        </a>
                    </div>
                    
                    <div class="content-body">
                        <div class="title">
                            <h3><a href="{{url('posts/'.$row->category_slug.'/'.$row->post_slug)}}">{{$row->post_title}}</a></h3>
                            <h5>Viết bởi <b>{{$row->user['name']}}</b> on {{date("d",strtotime($row->created_at))}} tháng {{date("m",strtotime($row->created_at))}} năm {{date("Y",strtotime($row->created_at))}}</h5>
                        </div>
                        <div class="content">
                            <div>
                                <div class="comment more">
                                    {!! $row->post_content !!}
                                </div>
                                <br /><br />
                            <a href="#" class="click_comment" data-post-id="{{$row->post_id}}"><span id="count_comment-{{$row->post_id}}">
                                {{-- TODO: Hiển thị số lượt comment theo Post_id --}}
                                @foreach ($count_comment as $item)
                                    @if ($item->post_id == $row->post_id)
                                        {{$item->count_comment}}
                                    @endif
                                @endforeach
                            </span>Comment</a>
                                <form id="form-{{$row->post_id}}" data-user-id="{{Auth::user()->user_id}}" style="display: none" data-post-id="{{$row->post_id}}">
                                    @csrf
                                    <textarea name="comment_content" maxlength="160"></textarea>
                                    <button type="submit" class="btn btn-success">Đăng</button>
                                </form>
                                {{-- TODO: Show comment theo Post_id --}}
                                <div id="show-{{$row->post_id}}" class="show-comment-button" data-post-id="{{$row->post_id}}" style="display:none;">
                                    {{-- <a href="#" class="load-more">view more comment previous</a><br> --}}
                                    <select multiple id="public-methods" name="public-methods[]" style="width:500px">
                                        @foreach ($show_comments as $show)
                                            @if ($show->post_id === $row->post_id)
                                                <b>{{$show->user['name']}}</b>: {{$show->comment_content}}. <br> 
                                                <option><b>{{$show->user['name']}}</b>: {{$show->comment_content}}.
                                                {{$show->created_at}}</option>
                                            @endif
                                        @endforeach 
                                    </select>
                                </div>
                            </div>
                            {{-- Start like button --}}
                            <div class="fb-like" 
                                data-href="https://sggalumni2019.000webhostapp.com/posts/{{$row->category_slug}}/{{$row->post_slug}}" 
                                data-width="" 
                                data-layout="standard" 
                                data-action="like" 
                                data-size="small" 
                                data-show-faces="true" 
                                data-share="true">
                            </div>
                            {{-- End like butotn --}}
                        </div>
                    </div>
                </div>
                @endforeach
                <div align="center">
                    {!! $posts->links() !!}
                </div>
            </div>
        </div>
<script>
$(document).ready(function () {
        /*
        $('.click_comment').click(function(e){
            e.preventDefault();
            const post_id = $(this).attr("data-postID");
            const user_id = $(this).attr("data-user_id");

            console.log(post_id);
            console.log(user_id);   

            //$('#comment_form').slideToggle('slow');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });

            $('#submit').click(function(e){
                e.preventDefault();
                const comment_content = $('#comment_content').val();

                // console.log(comment_content);
                
                $.ajax({
                    type: "POST",
                    url: "{{route('posts.comment_ajax')}}",
                    data: {comment_content: comment_content},
                    dataType: "JSON",
                    success: function (response) {
                        console.log("Content: ",response.commnet_content);
                        console.log(response.message);
                    }
                }); 
            })

            $.ajax({
                type: "POST",
                url: "{{route('posts.list_post_students')}}",
                data: {post_id : post_id, user_id: user_id},
                dataType: "JSON",
                success: function (response) {
                    console.log("Post_id: ",response.post_id);
                    console.log("User_id: ",response.user_id);
                }
            }); 
        })
        */
       $('.click_comment').click(function (event) {
            event.preventDefault();
            const post_id = $(this).attr("data-post-id");
            console.log(post_id);
            $(this).next('form').slideToggle();
            $(`div[id*=show-${post_id}]`).show()
       })

       $('form[id*="form-"').on('submit', function (event) {
           event.preventDefault();
           const userId = $(this).attr('data-user-id')
           const postId = $(this).attr('data-post-id')
           const commentContent = $(this).find('textarea').val();

           $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            
            $.ajax({
                type: "POST",
                url: "{{route('posts.comment_ajax')}}",
                data: {userId: userId, postId: postId, commentContent: commentContent},
                dataType: "json",
                success: function (response) {
                    // $(`#count_comment-${postId}`).text(response.count_comment.count_comment);
                    console.log(response.count_comment);
                    if (response.status === 'success') {
                        $(`#count_comment-${postId}`).text(response.count_comment[0].count_comment);
                        alert('Add comment successfully!');
                        $('form[id*=form-').slideDown();
                        location.reload();
                    }
                }
            });
            
       });
    });
</script>
<script>
$(document).ready(function() {
	var showChar = 100;
	var ellipsestext = "...";
	var moretext = "See more";
	var lesstext = "Less";
	$('.more').each(function() {
		var content = $(this).html();

		if(content.length > showChar) {

			var c = content.substr(0, showChar);
			var h = content.substr(showChar-1, content.length - showChar);

			var html = c + '<span class="moreellipses">' + ellipsestext+ '&nbsp;</span><span class="morecontent"><span>' + h + '</span>&nbsp;&nbsp;<a href="" class="morelink">' + moretext + '</a></span>';

			$(this).html(html);
		}

	});

	$(".morelink").click(function(){
		if($(this).hasClass("less")) {
			$(this).removeClass("less");
			$(this).html(moretext);
		} else {
			$(this).addClass("less");
			$(this).html(lesstext);
		}
		$(this).parent().prev().toggle();
		$(this).prev().toggle();
		return false;
	});
});
</script>
@endsection