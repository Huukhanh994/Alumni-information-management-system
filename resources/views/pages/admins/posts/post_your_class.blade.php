@extends('layouts.admin')
@section('content')
<link rel="stylesheet" href="{{asset('/css/khanh_ho/style_index_2.css')}}">
<script type="text/javascript"
    src="https://www.viralpatel.net/demo/jquery/jquery.shorten.1.0.js"></script>
<div class="container">


    <div class="content-border pager-offset">
        <h2 class="black-bar-header">BẢN TIN TRÊN LỚP CỦA BẠN</h2>
        <div class="view view-news-recent view-id-news_recent view-display-id-paged_list view-dom-id-6eefa6e989759a55744d694dc2e0a2b2"> 
            @foreach ($post_user as $row)
                
              
            <!-- Start item -->
            <div class="panelizer-view-mode node node-teaser node-article node-2274 node-promoted"> 
                            
                <!-- ########## NEW HTML ############## -->
                <div class="white-stone">
                    <div class="white-stone-content">
                        <div class="gs-container">
                        <div class="default-1-3">
                            <div class="simple-border">
                                <div class="field field-name-field-article-media field-type-file field-label-hidden">
                                        <a title="" href="{{route('posts.slug',$row->post_slug)}}">
                                        <div class="field field-name-field-article-media field-type-file field-label-hidden">
                                            <div class="file file-image file-image-jpeg" id="file-1321">
                                                <img width="320" height="180" alt="" src="{{asset('/images/myfiles_cit/test_posts/Great-Leaders-Develop-Their-People-What-Development-Means.png')}}" typeof="foaf:Image">
                                            </div>
                                        </div>
                                    </a>
                
                                    </div>
                                </div>
                            </div>
                        <div class="default-2-3">
                            <h4><a href="{{route('posts.slug',$row->post_slug)}}">{{$row->post_title}}</a></h4>
                            <div class="teaser-content">
                                <div class="field field-name-field-body-medium field-type-text-long field-label-hidden">
                                    <small>Viết bởi 
                                       {{$row->user['name']}}
                                        được đăng trên lớp {{$row->class_name}}
                                    </small>
                                    <br>
                                    <div class="display">
                                        {{$row->post_content}}
                                    </div>
                                    <script type="text/javascript">
                                        $(document).ready(function() {
                                        
                                            $(".display").shorten();
                                        
                                        });
                                    </script>
                                    
                                </div>
                            </div>
                            <div class="horizontal-group">
                                <div class="horizontal-group-item">
                                    <div class="all-caps subtle icon-container icon-posted">   
                                        <span class="time-ago time-ago-node-2274">
                                            {{$row->created_at}}
                                        </span>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>		  
            </div>
            <!-- end item -->

            @endforeach 
            <div align="right">
                {!! $post_user->links() !!}
            </div> 
            
        </div>
    </div>



</div>
{{-- end container --}}
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
                                // TODO: Sau khi comment xong thì form sẽ slideDown lại
                                // $(`#form-${postId}`).slideDown('slow');
                            }
                        }
                    });
                    
               });
            });
    </script>
@endsection