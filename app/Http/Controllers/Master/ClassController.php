<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MajorBranch;
use Carbon;
use App\Models\Classes;
use App\Models\Major;
use App\Models\Academy;

class ClassController extends Controller
{
    // Hàm khởi tạo.
    public function __construct()
    {
        parent::__construct();
    }

    // Hàm đỗ dữ liệu của một Lớp ra trang index
    public function index(Request $request)
    {
        $major_branch_name = MajorBranch::all();
        $config = [
            'model' => new Classes(),
            'request' => $request,
        ];
        $this->config($config);
        $data = $this->model->web_index($this->request);

        return view('pages.admins.class.index', ['data' => $data], ['major_branch_name' => $major_branch_name]);
    }

    // TODO: Mỗi function chỉ thực hiện 1 nhiệm vụ. Cho người khác dễ sửa chửa code của mình.
    // Hàm chỉ thực hiện đỗ ra trang Thêm
    public function create_render(Request $request)
    {
        $chuyennganh = MajorBranch::all();
        $nganh = Major::all();
        $khoa = Academy::all();

        return view('pages.admins.class.create', compact('chuyennganh', 'nganh', 'khoa'));
    }

    // Hàm chỉ thực hiện chức năng Thêm thông qua Method = POST
    public function create_submit(Request $request)
    {
        $config = [
            'model' => new Classes(),
            'request' => $request,
        ];
        $this->config($config);
        // $majorbranch=MajorBranch::where('major_branch_id',$this->request->major_branch_id)->first();
        // $major=Major::where('major_id',$majorbranch->major_id)->first();
        // $academy=Academy::where('academy_id',$major->academy_id)->first();

        // $class_code_old = $this->request->class_code;
        // $academycode = $academy->academy_code;
        // $getyear = substr(Carbon\Carbon::parse($this->request->class_begin)->format('Y'),2,2);
        // $majorcode = $major->major_code;
        // $strtoupper_classcode = strtoupper($this->request->class_code);
        // $classcode = $academycode.$getyear.$majorcode.$strtoupper_classcode;

        $data = $this->model->web_insert($this->request);
        // Classes::where('class_code', $class_code_old)->update([
        //     'class_code' => $classcode,
        // ]);

        // dd($data);
        return redirect('class')->with('success', 'Added Successfully');
    }

    public function show($id)
    {
        return view('pages.admins.class.show');
    }

    public function edit($class_id)
    {
        $chuyennganh = MajorBranch::all();
        $class = Classes::findOrFail($class_id);

        return view('pages.admins.class.edit', compact('class', 'class_id'), compact('chuyennganh'));
    }

    public function update(Request $request, $class_id)
    {
        $class = Major::find($class_id);
        //TODO:  Nhan du lieu tu form cu
        $class->class_id = $request->get('class_id');
        $class->class_code = $request->get('class_code');
        $class->class_name = $request->get('class_name');
        $class->class_begin = $request->get('class_begin');
        $class->class_end = $request->get('class_end');
        $class->major_branch_id = $request->get('major_branch_id');
        $class->save();
        // dd($major);
        return redirect('class')->with('success', 'Updated Successfully');
    }

    public function destroy($class_id)
    {
        $data = Classes::findOrFail($class_id);
        $data->delete();
        // dd($data);
        return redirect('class')->with('success', 'Deleted Successfully!');
    }
}
