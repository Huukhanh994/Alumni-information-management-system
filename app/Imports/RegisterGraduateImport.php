<?php

namespace App\Imports;

use App\Models\RegisterGraduate;
use Maatwebsite\Excel\Concerns\ToModel;

class RegisterGraduateImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new RegisterGraduate([
            'register_graduate_id'                      => $row[0],
            'register_graduate_phase'                   => $row[1],
            'register_graduate_academy'                 => $row[2],
            'register_graduate_decision'                => $row[3],
            'register_graduate_date'                    => date('Y-m-d H:i:s', strtotime($row[4])),
            'register_graduate_code'                    => $row[5],
            'register_graduate_name'                    => $row[6],
            'register_graduate_birth'                   => date('Y-m-d H:i:s', strtotime($row[7])),
            'register_graduate_gender'                  => $row[8],
            'register_graduate_place_of_birth'          => $row[9],
            'register_graduate_class_code'              => $row[10],
            'register_graduate_AUN'                     => $row[11],
            'register_graduate_major_name'              => $row[12],
            'register_graduate_major_branch_name'       => $row[13],
            'register_graduate_GPA'                     => $row[14],
            'register_graduate_DRL'                     => $row[15],
            'register_graduate_TCTL'                    => $row[16],
            'register_graduate_ranked'                  => $row[17],
            'register_graduate_note'                    => $row[18],
            'register_graduate_nation'                  => $row[19],
            'register_graduate_year_begin'              => $row[20],
            'register_graduate_course'                  => $row[21],
            'register_graduate_degree'                  => '',
            'register_graduate_type_of_tranning'        => '',
        ]);
    }
}
