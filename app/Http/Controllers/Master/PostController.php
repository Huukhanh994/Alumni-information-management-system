<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Post;
// use App\User;
use App\Models\User;
use Hash;
use Illuminate\Support\Facades\Auth;
use DB;
use App\Models\Comment;
use App\Models\Category;
use App\Models\CategoryPost;
use App\Models\Classes;

class PostController extends Controller
{
    // // TODO FORM ĐĂNG KÝ TÀI KHOẢN
    // public function register()
    // {
    //     return view('pages.admins.login.register');
    // }


    // // TODO FORM LƯU TÀI KHOẢN
    // public function register_store(Request $request)
    // {
    //     $this->validate($request,[
    //         'email'         => 'required',
    //         'password'      => 'required|confirmed',
    //     ]);
    //     $user = new User([
    //         'email'         => $request->get('email'),
    //         'password'      => Hash::make($request->get('password')),
    //     ]);
    //     $user->save();
    //     return redirect('posts/success')->with('success','Thêm người dùng thành công');   
    // }


    // // TODO ĐĂNG NHẬP
    // public function login()
    // {
    //     return view('pages.admins.login.login');
    // }


    // // TODO ĐĂNG NHẬP CHO ĐẸP HƠN
    // public function login2()
    // {
    //     return view('pages.admins.login.login2');
    // }


    // // TODO LOGOUT
    // public function logout()
    // {
    //     Auth::logout();
    //     return redirect('/public/login');
    // }


    // // TODO KIỂM TRA LOGIN
    // public function checklogin(Request $request)
    // {
    //     $this->validate($request,[
    //         'email'  => 'required|email',
    //         'password'  => 'required|min:3'
    //     ]);

    //     $user_data = array(
    //         'email' => $request->get('email'),
    //         'password'  => $request->get('password'),
    //     );

    //     if(Auth::attempt($user_data))
    //     {
    //         return view('pages.admins.posts.success')->with('sucess','Login successfully');
    //     }
    //     else{
    //         return \back()->with('error','Wrong Login Details');
    //     }
    // }


    // // TODO REDIRECT KHI LOGIN THÀNH CÔNG
    // public function sucess()
    // {
    //     return view('pages.admins.posts.success');
    // }

    // TODO TRANG INDEX CỦA QUẢN LÝ BÀI ĐĂNG
    public function index()
    {
        $posts = Post::inRandomOrder()
            ->join('categorys_posts','posts.post_id','categorys_posts.post_id')
            ->join('categories','categorys_posts.category_id','categories.category_id')
            ->select('categories.*','posts.*')
            ->where('post_status','accepted')
            ->orderBy('posts.post_id', 'desc')
            ->paginate(5);
        $count_comment = DB::table('posts')
            ->join('comments','posts.post_id','=','comments.post_id')
            ->select(DB::raw('count(*) as count_comment,comments.post_id'))
            ->where('comments.post_id','<>',0)
            ->groupBy('comments.post_id')
            ->get();

        $show_comments = Comment::with('user')->get();

        return view('pages.admins.posts.index',compact('posts'))
        ->with('count_comment',$count_comment)
        ->with('show_comments',$show_comments);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    // TODO INDEX CỦA CHỨC NĂNG ĐĂNG BÀI
    public function add_posts()
    {
        // $posts = DB::table('posts')
        //     ->select('posts.*', 'users.name', 'users.email')
        //     ->join('users', 'posts.user_id', '=', 'users.user_id')
        //     ->orderBy('posts.post_id', 'desc')
        //     ->get();
        // TODO Tìm ra được số bài đăng của người dùng trong bảng posts
        $count = Post::with('user')
            ->select(DB::raw('count(*) as user_count, user_id'))
            ->where('user_id', '<>', 0)
            ->groupBy('user_id')
            ->get();

        $categories = Category::all();

        $classes = Classes::all();
        $userID = DB::table('posts')->select('posts.user_id')
            ->where([
                ['status_user','blocked'],
                ['posts.user_id','=',Auth::user()->user_id]
                ])->value('posts.user_id');
        // dd($userID);
        return view('pages.admins.posts.add_posts')
        // ->with('posts',$posts)
        ->with('categories',$categories)
        ->with('count',$count)
        ->with('userID',$userID)
        ->with('classes',$classes);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    
    // TODO LƯU KHI CREATE BÀI VIẾT
    public function store(Request $request)
    {
       $this->validate($request,[
            'category_id'   => 'required',
            'post_title'    => 'required',
            'post_content'  => 'required',
            'post_slug'     => 'required',
            'post_file.*'   => 'mimes:doc,docx,pdf,zip',     

       ]);
       if($request->hasFile('post_file'))
       {
           foreach ($request->file('post_file') as $file) {
               $name = $file->getClientOriginalName();
               $file->move(public_path().'/files/',$name);
               $data[] = $name;
           }
       }
        $host_CIT = 'http://cit.ctu.edu.vn/sv/';

        $posts = new Post();
        $posts->user_id              = Auth::user()->user_id;
        $posts->post_title           = $request->get('post_title');
        $posts->post_content         = $request->get('post_content');
        $posts->post_slug            = $request->get('post_slug');
        $posts->role_id              = $request->input('role_name');
        $posts->class_id             = $request->input('class_name');
        $posts->category_id          = $request->input('category_id');
        $posts->post_link            = $request->get('post_link');
        if(isset($name))
        {
            $posts->post_file            = $host_CIT.$name;   
            $posts->save();
        }
        else
        {
            $posts->save();
        }
        
        
        $posts->save();
         // ROLES
         // 1 là m tạo thêm bảng post_roles pivot
         $posts->roles()->attach($posts->role_id);
         // CLASSES
         $posts->classes()->attach($posts->class_id);
         // CATEGORY
         $posts->posts_categories()->attach($posts->category_id);
         $posts->posts_categories()->attach($posts->post_id);
         $posts->posts_categories()->detach($posts->post_id);
         
       return redirect()->route('posts.add_posts')->with('success','The post successfully');
    }


    // TODO Hiển thị các bài viết cần chờ Admin duyệt của chức năng Duyệt bài
    public function list_post()
    {
        $posts = Post::with('user')->where('post_status','pending')->orderBy('post_id','desc')->get();
        $post_categories = Post::with('posts_categories')->get();

        $class_names = Post::with('classes')->get();
        // dd($class_names);
        foreach ($class_names as $class) {
            // echo $class . '<hr>';
            foreach ($class->classes as $class_name) {
                //echo $class_name->pivot->post_id . ' , ' .$class_name->class_name . '<br>';
            }
        }
        $role_names = Post::with('roles')->get();
        foreach ($role_names as $role) {
            foreach ($role->roles as $role_name) {
                //echo $role_name->pivot->post_id . ' , ' . $role_name->role_name . '<br>';
            }
        }
        return view('pages.admins.posts.list_post')
            ->with('posts',$posts)
            ->with('post_categories',$post_categories);
    }


    // TODO Nhận dữ liệu từ view gửi qua thuộc chức năng Duyệt bài của Admin
    public function list_post_ajax(Request $request)
    {
        if(request()->ajax()){
            $postId = $request->get('postId');

            DB::table('posts')->where('post_id', $postId)->update(['post_status' => 'accepted']);
            return response()->json(["result" => "success"]);
        }
    }

    public function show_post_detail_of_admin(Request $request, $post_id)
    {
        $posts = Post::with('user')->where('post_status','pending')->get()->find($post_id);
        return view('pages.admins.posts.show_post_detail_of_admin',compact('posts','post_id'));
    }


    // TODO CHỨC NĂNG KHÓA TÀI KHOẢN NGƯỜI DÙNG NẾU ĐĂNG KO HỢP LÝ
    public function block_user_ajax(Request $request)
    {
        if(request()->ajax())
        {
            $userID = $request->get('userID');
            DB::table('posts')->where('user_id',$userID)->update(['status_user' => 'blocked']);
            return response()->json(['result' => "success"]);
        }
    }


    // TODO HIỂN THỊ DANH SÁCH TÀI KHOẢN BỊ KHÓA VÀ UNBLOCK THAT'S ACCOUNT
    public function lists_account_blocked()
    {
        $account_blocked = Post::with('user')
            ->where('posts.status_user','blocked')
            ->get();
            
        $count_block = DB::table('posts')
                        ->select(DB::raw('count(*) as solankhoa'))
                        ->where('status_user','blocked')
                        ->groupBy('posts.user_id')
                        ->value('solankhoa');
        //dd($count_block);  
        return view('pages.admins.posts.lists_account_blocked')
        ->with('account_blocked',$account_blocked)
        ->with('count_block',$count_block);
    }


    // TODO CHỨC NĂNG MỞ KHÓA TÀI KHOẢN
    public function unblock_account_ajax(Request $request)
    {
        if(request()->ajax())
        {
            $userID = $request->get('userID');
            DB::table('posts')->where('user_id',$userID)->update(['status_user' => 'active']);
            return response()->json(['result' => "success"]);
        }
    }
    /**
     * 
     * 
     */
    // TODO Danh sách bài đăng thuộc role = student *
    public function list_post_students()
    {
        $query = DB::table('posts')
            ->join('post_classes','posts.post_id','=','post_classes.post_id')
            ->join('classes','post_classes.class_id','=','classes.class_id')
            ->select('classes.*','posts.*')
            ->get();
        //echo $query .'<hr>' . '<br>';

        // $post_users = User::with('post_classes')->get();

        // dd($post_users);
        //echo 'Auth_user_ID: ' . Auth::user()->user_id . '<br>';

        // foreach($post_users as $post)
        // {
        //     // if($post->user_id === Auth::user()->user_id){
        //         // echo $post.'<hr>' . '<br>';
        //         foreach ($post->post_classes as $post_class) {
        //             //echo $post_class . '<hr>' . "<br>";
        //         }
        //     //}
        // }
        //dd($post_users);

        // FIXME:
        // Đếm comment theo post_id
        $count_comment = DB::table('posts')
            ->join('comments','posts.post_id','=','comments.post_id')
            ->select(DB::raw('count(*) as count_comment,comments.post_id'))
            ->where('comments.post_id','<>',0)
            ->groupBy('comments.post_id')
            ->get();
        //echo $count_comment . '<hr>';

        $show_comments = Comment::with('user')->get();
        /**
         * * SUCCESSFULLY!
         */
        //dd($show_comments);
        foreach ($show_comments as $show) {
            //echo $show->user->name;
        }

        $class_names = Post::with('classes')->get();
        /**
         * * SUCCESSFULLY!
         */
        //dd($class_names);
        foreach ($class_names as $class) {
            // echo $class->classes;
            foreach ($class->classes as $class_name) {
                //echo $class_name->pivot->post_id . ', ' . $class_name->class_name. '<br>';
                // echo $class_name->class_name;
                // echo $tenlop;
            }
        }
        // dd($class_names);
        $post_students = Post::with('user')
            ->join('categorys_posts','posts.post_id','categorys_posts.post_id')
            ->join('categories','categorys_posts.category_id','categories.category_id')
            ->select('categories.*','posts.*')
            ->where([
                ['role_id','=',3],
                ['post_status','accepted'],
            ])->orderBy('posts.post_id', 'desc')->paginate(5);

        // posts join classes, if user co class_id thuoc post_classes thi moi thay dc bai dang
        // $post_category = Post::with('posts_categories')->get();
        // dd($post_category);
        //echo $post->created_at . '<br>'; // Y-m-d

        // $day = strtotime($post->created_at);
        // echo "Day: " . date("d",$day) ;    // jusn get specific day
        // echo "Month: " . date("m",$day);    // jusn get specific month
        // echo "Year: " . date("Y",$day);    // jusn get specific year


        return view('pages.admins.posts.list_post_students')
        ->with('i',(request()->input('page',1) - 1 ) * 3)
        ->with('post_students',$post_students)
        ->with('class_names',$class_names)
        ->with('count_comment',$count_comment)
        ->with('show_comments',$show_comments);
    }


    // TODO: HIỂN THỊ CHI TIẾT BÀI VIẾT KHI CLICK VÀO  https://domain.com/posts/news/{slug}
    public function posts_slug(Request $request,$category_slug, $slug)
    {
        $post_radom = Post::inRandomOrder()
            ->join('categorys_posts','posts.post_id','categorys_posts.post_id')
            ->join('categories','categorys_posts.category_id','categories.category_id')
            ->select('categories.*','posts.*')
            ->where('post_status','accepted')
            ->orderBy('post_id', 'desc')
            ->paginate(3);
        
        $post_slug = Post::with('posts_categories')
        ->join('categorys_posts','posts.post_id','categorys_posts.post_id')
        ->join('categories','categorys_posts.category_id','categories.category_id')
        ->where([
            ['posts.post_status','accepted'],
            ['categories.category_slug',$category_slug],
            ['posts.post_slug',$slug]
        ])
        ->join('users','posts.user_id','=','users.user_id')
        ->get();

        $create_post = Post::with('posts_categories')
        ->where([
            ['post_status','accepted'],
            ['post_slug',$slug]
        ])->get();
        // dd($post_slug);
        
        return view('pages.admins.posts.details_an_article')
        ->with('post_slug',$post_slug)
        ->with('create_post',$create_post)
        ->with('post_radom',$post_radom);
    }


    // TODO Chức năng xem bài đăng của mình, những bài đăng nào mình được thấy trên lớp của mình đăng theo học
    // TODO Khi giảng viên đăng  1 bài đăng muốn chỉ trên lớp đó thấy thôi, và các sih viên thuộc lớp đó sẽ thấy, còn sinh viên khác thì không.
    // public function post_yourself()
    // {
    //     /**
    //      * * SUCCESSFULLY!
    //      */
    //     $data = Post::with('user')
    //     ->join('post_classes','posts.post_id','=','post_classes.post_id')
    //     ->join('class_users','post_classes.class_id','=','class_users.class_id')
    //     ->join('users','users.user_id','=','class_users.user_id')
    //     ->join('classes','classes.class_id','=','class_users.class_id')
    //         ->select('users.*','classes.*','class_users.class_id','post_classes.post_id','posts.*')
    //         ->where([
    //             ['users.user_id','=',Auth::user()->user_id],
    //             ['post_status','accepted'],
    //             ])
    //         ->get();
    //     //echo 'Data: ' . $data . '<br>' . '<hr>';

    //     // FIXME:
    //     // Đếm comment theo post_id
    //     $count_comment = DB::table('posts')
    //         ->join('comments','posts.post_id','=','comments.post_id')
    //         ->select(DB::raw('count(*) as count_comment,comments.post_id'))
    //         ->where('comments.post_id','<>',0)
    //         ->groupBy('comments.post_id')
    //         ->get();
    //     //echo $count_comment . '<hr>';

    //     $show_comments = Comment::with('user')->get();


    //     return view('pages.admins.posts.post_yourself')
    //         ->with('data',$data)
    //         ->with('count_comment',$count_comment)
    //         ->with('show_comments',$show_comments);
    // }


    // TODO Danh sách bài đăng thuộc role = teacher * 
    public function list_post_teachers()
    {
        // FIXME:
        // Đếm comment theo post_id
        $count_comment = DB::table('posts')
            ->join('comments','posts.post_id','=','comments.post_id')
            ->select(DB::raw('count(*) as count_comment,comments.post_id'))
            ->where('comments.post_id','<>',0)
            ->groupBy('comments.post_id')
            ->get();
        //echo $count_comment . '<hr>';

        $show_comments = Comment::with('user')->get();

        $post_teachers = Post::with('user')
            ->join('categorys_posts','posts.post_id','categorys_posts.post_id')
            ->join('categories','categorys_posts.category_id','categories.category_id')
            ->select('categories.*','posts.*')
            ->where([
                ['role_id','=',2],
                ['post_status','accepted'],
            ])->orderBy('posts.post_id', 'desc')->paginate(5);
        
        return view('pages.admins.posts.list_post_teachers')
        ->with('post_teachers',$post_teachers)
        ->with('count_comment',$count_comment)
        ->with('show_comments',$show_comments);
    }


    // TODO CHỨC NĂNG LOAD COMMENT TRÊN BÀI VIẾT
    public function comment_ajax(Request $request)
    {
        if(request()->ajax())
        {
            $userId            = $request->get('userId');
            $commentContent    = $request->get('commentContent');
            $postId            = $request->get('postId');

            DB::table('comments')->insertGetId([
                'post_id'           => $postId,
                'user_id'           => $userId,
                'comment_content'  => $commentContent,
            ]);
            $count_comment = DB::table('comments')->select(DB::raw('count(*) as count_comment'))->where('post_id',$postId)->get();
            return response()->json(['postId' => $postId,'userId' => $userId ,'commentContent' => $commentContent ,'status' => 'success','count_comment' => $count_comment]);
        }

    }


    // TODO HIỂN THỊ CÁC BÀI VIẾT TRÊN LỚP CỦA MÌNH HỌC
    public function post_your_class(Request $request,$id)
    {
        $count_comment = DB::table('posts')
            ->join('comments','posts.post_id','=','comments.post_id')
            ->select(DB::raw('count(*) as count_comment,comments.post_id'))
            ->where('comments.post_id','<>',0)
            ->groupBy('comments.post_id')
            ->get();

        $show_comments = Comment::with('user')->get();

        // FIXME: Cái này lỗi vì ngày created_at của bảng posts không lấy ra đúng
        // $post_user = Post::with('user')
        //     ->join('post_classes','posts.post_id','=','post_classes.post_id')
        //     ->join('class_users','post_classes.class_id','=','class_users.class_id')
        //     ->join('classes','class_users.class_id','=','classes.class_id')
        //     ->join('users','class_users.user_id','=','users.user_id')
        //     ->select('users.*','posts.*','classes.*')
        //     ->where([
        //         ['class_users.user_id','=',$id],
        //         ['post_status','accepted'],
        //         ])
        //         ->orderBy('post_id', 'desc')->paginate(5);
        //echo $post_user;

        // FIXMED: 
        $post_user = User::with('classes')      // === class_users tại đặt tên nhầm
                ->join('class_users','users.user_id','class_users.user_id')
                ->join('classes','class_users.class_id','classes.class_id')

                ->join('post_classes','classes.class_id','post_classes.class_id')
                ->join('posts','post_classes.post_id','posts.post_id')
                ->select('classes.*','posts.*')
                ->where([
                    ['users.user_id',$id],
                    ['posts.post_status','accepted']
                ])
                ->orderBy('post_id', 'desc')->paginate(5);


        return view('pages.admins.posts.post_your_class')
        ->with('post_user',$post_user)
        ->with('count_comment',$count_comment)
        ->with('show_comments',$show_comments);
    }

    /*******************************************************************************
     * 
     * TODO          CÁC BÀI ĐĂNG LIÊN QUAN ĐẾN THỂ LOẠI
     *
     *****************************************************************************/

                // TODO BÀI VIẾT THUỘC THỂ LOẠI TÌM VIỆC LÀM CHO SINH VIÊN
                public function categories_find_job()
                {
                    $count_comment = DB::table('posts')
                    ->join('comments','posts.post_id','=','comments.post_id')
                    ->select(DB::raw('count(*) as count_comment,comments.post_id'))
                    ->where('comments.post_id','<>',0)
                    ->groupBy('comments.post_id')
                    ->get();
        
                    $show_comments = Comment::with('user')->get();

                    $post_categories = Post::with('user')
                            ->join('categorys_posts','posts.post_id','categorys_posts.post_id')
                            ->join('categories','categorys_posts.category_id','categories.category_id')
                            ->select('categories.*','posts.*')
                            ->where([
                                ['categorys_posts.category_id','=',1],
                                ['posts.post_status','accepted'],
                            ])
                    ->orderBy('post_id', 'desc')->paginate(5);
                    //echo $post_categories . '<br>';

                    return view('pages.admins.posts.categories_find_job')
                    ->with('post_categories',$post_categories)
                    ->with('count_comment',$count_comment)
                    ->with('show_comments',$show_comments);
                }


                // TODO BÀI VIẾT THUỘC THỂ LOẠI TUYỂN DỤNG VIỆC LÀM CỦA CÁC CÔNG TY
                public function categories_apply_job()
                {
                    $count_comment = DB::table('posts')
                    ->join('comments','posts.post_id','=','comments.post_id')
                    ->select(DB::raw('count(*) as count_comment,comments.post_id'))
                    ->where('comments.post_id','<>',0)
                    ->groupBy('comments.post_id')
                    ->get();
        
                    $show_comments = Comment::with('user')->get();

                    // $post_categories = Post::with('posts_categories')
                    //     ->join('users','posts.user_id','=','users.user_id')
                    //     ->select('posts.*','users.name')
                    //     ->where([
                    //         ['category_id','=',2],
                    //         ['post_status','accepted'],
                    //         ])
                    //     ->orderBy('post_id', 'desc')->paginate(5);
                    $post_categories = Post::with('user')
                            ->join('categorys_posts','posts.post_id','categorys_posts.post_id')
                            ->join('categories','categorys_posts.category_id','categories.category_id')
                            ->select('categories.*','posts.*')
                            ->where([
                                ['categorys_posts.category_id','=',2],
                                ['posts.post_status','accepted'],
                            ])
                    ->orderBy('post_id', 'desc')->paginate(5);

                    return view('pages.admins.posts.categories_apply_job')
                    ->with('post_categories',$post_categories)
                    ->with('count_comment',$count_comment)
                    ->with('show_comments',$show_comments);
                }


                // TODO BÀI VIẾT THUỘC THỂ LOẠI HỢP LỚP GẶP MẶT CỦA SINH VIÊN
                public function categories_class_meeting()
                {
                    $count_comment = DB::table('posts')
                    ->join('comments','posts.post_id','=','comments.post_id')
                    ->select(DB::raw('count(*) as count_comment,comments.post_id'))
                    ->where('comments.post_id','<>',0)
                    ->groupBy('comments.post_id')
                    ->get();
        
                    $show_comments = Comment::with('user')->get();

                    $post_categories = Post::with('user')
                            ->join('categorys_posts','posts.post_id','categorys_posts.post_id')
                            ->join('categories','categorys_posts.category_id','categories.category_id')
                            ->select('categories.*','posts.*')
                            ->where([
                                ['categorys_posts.category_id','=',3],
                                ['posts.post_status','accepted'],
                            ])
                    ->orderBy('post_id', 'desc')->paginate(5);
                    //echo $post_categories . '<br>';
                    return view('pages.admins.posts.categories_class_meeting')
                    ->with('post_categories',$post_categories)
                    ->with('count_comment',$count_comment)
                    ->with('show_comments',$show_comments);
                }


                // TODO BÀI VIẾT THUỘC THỂ LOẠI HỖ TRỢ HỌC BỔNG
                public function categories_support_scholarship()
                {
                    $count_comment = DB::table('posts')
                    ->join('comments','posts.post_id','=','comments.post_id')
                    ->select(DB::raw('count(*) as count_comment,comments.post_id'))
                    ->where('comments.post_id','<>',0)
                    ->groupBy('comments.post_id')
                    ->get();
        
                    $show_comments = Comment::with('user')->get();

                    $post_categories = Post::with('user')
                            ->join('categorys_posts','posts.post_id','categorys_posts.post_id')
                            ->join('categories','categorys_posts.category_id','categories.category_id')
                            ->select('categories.*','posts.*')
                            ->where([
                                ['categorys_posts.category_id','=',4],
                                ['posts.post_status','accepted'],
                            ])
                    ->orderBy('post_id', 'desc')->paginate(5);
                    //echo $post_categories . '<br>';
                    return view('pages.admins.posts.categories_support_scholarship')
                    ->with('post_categories',$post_categories)
                    ->with('count_comment',$count_comment)
                    ->with('show_comments',$show_comments);
                }


                // TODO BÀI VIẾT THUỘC THỂ LOẠI QUYÊN GÓP TRANG THIẾT BỊ
                public function categories_donations()
                {
                    $count_comment = DB::table('posts')
                    ->join('comments','posts.post_id','=','comments.post_id')
                    ->select(DB::raw('count(*) as count_comment,comments.post_id'))
                    ->where('comments.post_id','<>',0)
                    ->groupBy('comments.post_id')
                    ->get();
        
                    $show_comments = Comment::with('user')->get();

                    $post_categories = Post::with('user')
                            ->join('categorys_posts','posts.post_id','categorys_posts.post_id')
                            ->join('categories','categorys_posts.category_id','categories.category_id')
                            ->select('categories.*','posts.*')
                            ->where([
                                ['categorys_posts.category_id','=',5],
                                ['posts.post_status','accepted'],
                            ])
                    ->orderBy('post_id', 'desc')->paginate(5);
                    //echo $post_categories . '<br>';
                    return view('pages.admins.posts.categories_donations')
                    ->with('post_categories',$post_categories)
                    ->with('count_comment',$count_comment)
                    ->with('show_comments',$show_comments);
                }


                // TODO BÀI VIẾT THUỘC THỂ LOẠI "THÔNG BÁO"
                public function categories_notifications()
                {
                    $count_comment = DB::table('posts')
                    ->join('comments','posts.post_id','=','comments.post_id')
                    ->select(DB::raw('count(*) as count_comment,comments.post_id'))
                    ->where('comments.post_id','<>',0)
                    ->groupBy('comments.post_id')
                    ->get();
        
                    $show_comments = Comment::with('user')->get();

                    $post_categories = Post::with('user')
                            ->join('categorys_posts','posts.post_id','categorys_posts.post_id')
                            ->join('categories','categorys_posts.category_id','categories.category_id')
                            ->select('categories.*','posts.*')
                            ->where([
                                ['categorys_posts.category_id','=',6],
                                ['posts.post_status','accepted'],
                            ])
                    ->orderBy('post_id', 'desc')->paginate(5);
                    //echo $post_categories . '<br>';
                    return view('pages.admins.posts.categories_notifications')
                    ->with('post_categories',$post_categories)
                    ->with('count_comment',$count_comment)
                    ->with('show_comments',$show_comments);
                }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
