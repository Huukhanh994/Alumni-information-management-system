<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use DB;
use App\Models\Status;
use Illuminate\Support\Facades\Hash;

// Excel
use App\Imports\AlumniImport;
use App\Exports\AlumniExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\GraduateImport;
use App\Models\StatusUser;
use Illuminate\Support\Facades\Crypt;
use App\Models\RegisterGraduate;
use App\Imports\RegisterGraduateImport;
// use Maatwebsite\Excel\Facades\Excel;

class AlumniController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        // FIXME: https://viblo.asia/q/join-query-builder-trong-laravel-WrZn07pr5xw
        // FIXME: https://stackoverflow.com/questions/46846225/property-name-does-not-exist-on-this-collection-instance
        //$alumnies = User::latest()->get();
        
        //$alumnies = User::latest()->paginate(5);              // phân trang. Nhưng gộp lại thành $users luôn

        // Lấy ra trạng thái tương ứng với người dùng đó
        $users = User::all();
        $status_users = User::with('statuses')->get();
        //dd($status);
        return view('pages.admins.alumnies.index',compact(['users','status_users']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.admins.alumnies.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $config = [
        //     'model' => new User(),
        //     'request'   => $request,
        // ];
        // $this->config($config);
        // $alumnies = $this->model->web_insert($this->request);


        $this->validate($request,[
            'code'          => 'required',
            'course'        => 'required',
            'name'          => 'required',
            'password'      => 'required|min:3',
            'nation'        => 'required',
            'tel'           => 'required',
            'email'         => 'required|email',
            'birth'         => 'required',
            'address'       => 'required',
            'family_tel'    => 'required',
            'family_address'=> 'required',
            'status_id'     => 'required',
        ]);
        $status_id = '';
        $alumnies = new User();

        $alumnies->code             = $request->get('code');
        $alumnies->course           = $request->get('course');
        $alumnies->name             = $request->get('name');
        $alumnies->password         = Hash::make($request->get('password'));
        $alumnies->nation           = $request->get('nation');
        $alumnies->tel              = $request->get('tel');
        $alumnies->email            = $request->get('email');
        $alumnies->gender           = $request->get('gender');
        $alumnies->birth            = $request->get('birth');
        $alumnies->address          = $request->get('address');
        $alumnies->family_tel       = $request->get('family_tel');
        $alumnies->family_address   = $request->get('family_address');
        $alumnies->status_id        = $request->input('status_id');

        $alumnies->save();
        /****************************************************************************************
         * ***************************************************************************************
         *  TODO: Thêm dữ liệu bên bảng users sẽ thêm status_id bên bảng pivot status_users luôn. 
         * 
         * ***************************************************************************************/
        $alumnies->statuses()->attach($alumnies->status_id);
        return redirect('alumnies')->with('success','Add Data Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $user_id
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$alumni_id)
    {
        //$alumnies = User::findOrFail($alumni_id);
        $alumnies = User::with('statuses')->get()->find($alumni_id);

        $class_code = '';
        $class_name = '';
        $major_name = '' ;
        $major_branch_name = '';
        $academy_name = '';
        $alumni = User::with('classes')
            ->join('class_users','users.user_id','=','class_users.user_id')
            ->join('classes','class_users.class_id','=','classes.class_id')
            ->join('major_branchs','classes.major_branch_id','=','major_branchs.major_branch_id')
            ->join('majors','major_branchs.major_id','=','majors.major_id')
            ->join('academies','majors.academy_id','=','academies.academy_id')
            // ->select('classes.*','majors.*','major_branchs.*','academies.*')
            ->where('users.user_id','=',$alumni_id)
            ->get()
            ->find($alumni_id);
        // echo $alumni->class_code. '<br>';
        // dd($alumni);              
        //echo $alumnies->statuses . '<br>';
        //dd($alumnies);

        /****************************************************************************************
         * ***************************************************************************************
         * TODO: 2 biến để dổ dữ liệu của status_name và status_reason sang View alumnies/show.blade.php
         * 
         * ***************************************************************************************
         ****************************************************************************************/
        $status_name = '';
        $status_reason = '';
        foreach($alumnies->statuses as $status)
        {
            //return $status_name = $status->status_name. '<br>';
            $status_name = $status->status_name;
            //return $status_reason = $status->pivot->status_users_reason;
            $status_reason = $status->status_reason;
        }

        $alumnies_graduates = User::findOrFail($alumni_id);
        //$alumnies_graduates = User::with('graduates')->get()->where('user_id',$alumni_id);  // that's awesome !
        $alumnies_graduates = DB::table('users')
            ->join('register_graduate','users.code','=','register_graduate.register_graduate_code')
            ->where('users.user_id',$alumni_id)
            ->get();

        return view('pages.admins.alumnies.show',\compact('alumnies','alumni_id'))
                ->with('status_name',$status_name)
                ->with('status_reason',$status_reason)
                ->with('alumni',$alumni)
                ->with('alumnies_graduates',$alumnies_graduates);
    }


    // TODO: HIỂN THỊ THÔNG TIN CHI TIẾT CÔNG VIỆC CỦA NGƯỜI DÙNG
    public function show_details_work(Request $request,$alumni_id)
    {
        $work_user = DB::table('users')
        // ->join('work_users','users.user_id','=','work_users.user_id')
        // ->join('works','work_users.work_id','=','works.work_id')
        // ->join('companies','works.company_id','=','companies.company_id')
        // ->join('wards','companies.ward_id','=','wards.ward_id')
        // ->join('districts','wards.district_id','=','districts.district_id')
        // ->join('cities','districts.city_id','=','cities.city_id')
        // ->select('users.*','works.*','work_users.*','companies.*','wards.*','districts.*','cities.*')
        ->join('work_users','users.user_id','=','work_users.user_id')
        ->join('works','work_users.work_id','=','works.work_id')
        ->join('work_companies','works.work_id','=','work_companies.work_id')
        ->join('companies','work_companies.company_id','=','companies.company_id')
        ->select('users.*','work_users.*','works.*','companies.*')
        ->where('users.user_id','=',"$alumni_id")
        ->get();

        //echo $work_user;
        foreach($work_user as $work)
        {
            // foreach ($work->work_users as $user) {
            //     echo $user->work_name;
            // }
        }
        // foreach ($work_user as $work) {
        //     echo $work->work_user_id . '<hr>'. '<br>';
        //     foreach ($work->work_users as $user) {
        //         echo $user->pivot->work_id . ',';
        //     }
        // }
        //dd($work_user);
        //dd($work_user);
        // echo $work_user . '<hr>' . "<br>";
        //dd($work_user);
        return view('pages.admins.alumnies.show_details_work')
        ->with('work_user',$work_user);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($user_id)
    {
        $alumni = User::findOrFail($user_id);
        //dd($alumni);

        return view('pages.admins.alumnies.edit',compact('alumni'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $user_id)
    {
        
        $alumni = User::findOrFail($user_id);
        $alumni->code           =   $request->get('code');
        $alumni->course         =   $request->get('course');
        $alumni->name           =   $request->get('name');
        $alumni->password       =   $request->get('password');
        $alumni->nation         =   $request->get('nation');
        $alumni->tel            =   $request->get('tel');
        $alumni->email          =   $request->get('email');
        $alumni->gender         =   $request->get('gender');
        $alumni->birth          =   $request->get('birth');
        $alumni->address        =   $request->get('address');
        $alumni->family_tel     =   $request->get('family_tel');
        $alumni->family_address =   $request->get('family_address');
        $alumni->status_id      =   $request->get('status_id');
        $alumni->ward_id        =   $request->get('ward_id');

        //dd($request->all());
        //dd($alumni);
        $alumni->save();
        return redirect('alumnies')->with('success','Updated Data Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($user_id)
    {
        $alumni = User::findOrFail($user_id);
        $alumni->delete();
        return redirect('alumnies')->with('success','Data Deleted Success');
    }


    // TODO: IMPORT DANH SÁCH CỰU SINH VIÊN
    public function import(Request $request)
    {
        $user = Excel::ToCollection(new AlumniImport(), $request->file('file'));
        foreach ($user[0] as $user) {

            User::where('code', $user[0])->insert([
                'code'                  => $user[0],
                'course'                => $user[1],
                'name'                  => $user[2],
                'password'              => Hash::make($user[3]),
                'nation'                => $user[4],
                'tel'                   => $user[5],
                'email'                 => $user[6],
                'gender'                => $user[7],
                'birth'                 => date('Y-m-d H:i:s', strtotime($user[8])),
                'address'               => $user[9],
                'family_tel'            => $user[10],
                'family_address'        => $user[11],
                'status_id'             => $user[12],
                'ward_id'               => $user[13],
            ]);
            $temp1= User::where('code',$user[0])->first();
            $temp2= Status::where('status_id',$user[12])->first();
            StatusUser::insert([
                'user_id'       => $temp1->user_id,
                'status_id'     => $temp2->status_id,
            ]);

        }
        return back()->with('success','Thêm danh sách Cựu sinh viên thành công!');  

    }


    // TODO: XUẤT FILE EXCEL
    // public function export()
    // {
    //     return Excel::download(new AlumniExport,'alumnies.xlsx');
    // }


    // TODO: IMPORT BẢNG ĐIÊM TỐT NGHIỆP
    public function import_graduate()
    {
        Excel::import(new RegisterGraduateImport,request()->file('file_graduate'));
        return back()->with('success','Thêm bảng điểm tốt nghiệp thành công!');
    }


    // TODO: Tìm kiếm
    // public function live_search(Request $request)
    // {
    //     if(request()->ajax())
    //     {
    //         $output = '';
    //         $query = $request->get('query');
    //         if($query != '')
    //         {
    //             $data = User::with('statuses')
    //                 ->where('code','like','%'.$query.'%')
    //                 ->orWhere('course','like','%'.$query.'%')
    //                 ->orWhere('name','like','%'.$query.'%')
    //                 ->orWhere('nation','like','%'.$query.'%')
    //                 ->orWhere('tel','like','%'.$query.'%')
    //                 ->orWhere('email','like','%'.$query.'%')
    //                 ->orWhere('gender','like','%'.$query.'%')
    //                 ->orWhere('birth','like','%'.$query.'%')
    //                 ->orWhere('address','like','%'.$query.'%')
    //                 ->orWhere('family_tel','like','%'.$query.'%')
    //                 ->orWhere('family_address','like','%'.$query.'%')
    //                 ->orWhere('status_id','like','%'.$query.'%')
    //                 ->orderBy('user_id','desc')
    //                 ->paginate(5);
    //         }
    //         else
    //         {
    //             $data = User::with('statuses')->orderBy('user_id','desc')->paginate(5);
    //             return view('pages.admins.alumnies.index',compact('users'))
    //             ->render();
    //         }
    //         $total_row = $data->count();
            
    //         if($total_row > 0)
    //         {
    //             foreach ($data as $row) {
    //                 $status_output = '';
    //                 foreach ($row->statuses as $status) {
    //                     $status_output .= '
    //                         <td>'.$status->status_name.'</td>
    //                         <td>'.$status->status_reason.'</td>
    //                     ';
    //                 }
    //                 $output .= '
    //                     <tr>
    //                         <td>'.$row->code.'</td>
    //                         <td>'.$row->name.'</td>
    //                         <td>'.$row->course.'</td>
    //                         <td>'.$row->nation.'</td>
    //                         <td>'.$row->tel.'</td>
    //                         <td>'.$row->email.'</td>
    //                         <td>'.$row->gender.'</td>
    //                         <td>'.$row->birth.'</td>
    //                         <td>'.$row->address.'</td>
    //                         '.$status_output.'
    //                         <td>      
    //                             <form onsubmit="return handleDelete()" action="'.route('alumnies.destroy',$row->user_id).'" method="post" class="delete_form">
                                            
    //                                 <a href="'.route('alumnies.show',$row->user_id).'" data-toggle="tooltip"  data-original-title="Show"><i class="icon-user"></i></a>
    //                                 <a href="'.route('alumnies.edit',$row->user_id).'" data-toggle="tooltip"  data-original-title="Edit"><i class="fa fa-pencil text-inverse m-r-10"></i></a>
    //                                 <button type="submit" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn" data-toggle="tooltip" data-original-title="Delete"><i class="ti-close" aria-hidden="true"></i></button>
    //                             </form>
    //                         </td>
    //                     </tr>
    //                 ';
                    
    //             }
    //         }
    //         else
    //         {
    //             $output .= '
    //                 <tr>
    //                     <td align"center" colspan="5">No Data Found</td>
    //                 </tr>
    //             ';
    //         }
    //         $data = array(
    //             'table_data'    => $output,
    //             'total_data'    => $total_row
    //         );
    //         echo json_encode($data);
    //     }
    // }
}
