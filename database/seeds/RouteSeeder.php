<?php

use Illuminate\Database\Seeder;

class RouteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
        
        //  Account
        [
           'route_link'     => 'accounts/profile',
           'route_name'     => 'Thông tin cá nhân',
           
        ],
        [
            'route_link'    => 'accounts/update_profile',
            'route_name'    => 'Cật nhật thông tin người dùng',
        ],
        [
            'route_link'    => 'accounts/logout',
            'route_name'    => 'Đăng xuất',
        ],
        [
            'route_link'    => 'accounts/jobs',
            'route_name'    => 'Thông tin việc làm của người dùng',
        ],
        [
            'route_link'    => 'accounts/add_work_submit',
            'route_name'    => 'Thêm công việc của người dùng',
        ],
        [
            'route_link'    => 'accounts/show_work_yourself',
            'route_name'    => 'Hiển thị tất cả công việc của người dùng',
        ],
        [
            'route_link'    => 'accounts/resign_ajax',
            'route_name'    => 'Xử lý button nghỉ việc của người dugnf',
        ],
        [
            'route_link'    => 'accounts/show_current_work_and_resign',
            'route_name'    => 'Hiển thị công việc gần đây nhất và button nghỉ việc',
        ],
        [
            'route_link'    => 'account/change_password',
            'route_name'    => 'Thay đổi mật khẩu người dùng',
        ],
        [
            'route_link'    => 'accounts/update_password',
            'route_name'    => 'Cập nhật mật khẩu',
        ],

        // Alumni
        [
            'route_link'    => 'alumnies/index',
            'route_name'    => 'Giao diện cựu sinh viên',
        ],
        [
            'route_link'    => 'alumnies/create',
            'route_name'    => 'Thêm cựu sinh viên',
        ],
        [
            'route_link'    => 'alumnies/store',
            'route_name'    => 'Lưu cựu sinh viên',
        ],
        [
            'route_link'    => 'alumnies/edit',
            'route_name'    => 'Sửa cựu sinh viên',
        ],
        [
            'route_link'    => 'alumnies/update',
            'route_name'    => 'Cập nhật cựu sinh viên',
        ],
        [
            'route_link'    => 'alumnies/show',
            'route_name'    => 'Hiển thị thông tin chi tiết cựu sinh viên',
        ],
        [
            'route_link'    => 'alumnies/destroy',
            'route_name'    => 'Xóa 1 cựu sinh viên',
        ],
        [
            'route_link'    => 'alumnies/import',
            'route_name'    => 'Import danh sách cựu sinh viên',
        ],
        [
            'route_link'    => 'alumnies/import_register_graduate',
            'route_name'    => 'Import danh sách bảng diểm tốt nghiệp',
        ],
        [
            'route_link'    => 'alumnies/show_details_work',
            'route_name'    => 'Hiển thị chi tiết công việc của cựu sinh viên',
        ],

    );
        DB::table('routes')->insert($data);
    }
}
