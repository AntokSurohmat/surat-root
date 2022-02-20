<?php

namespace App\Controllers\Admin;

use App\Models\Admin\PangolModel;

use App\Controllers\BaseController;

class PangolController extends BaseController
{
    public function index(){

        $data = array(
            'title' => 'PANGKAT & GOLONGAN',
            'parent' => 2,
            'pmenu' => 2.2,
        );
        return view('admin/pangol/v-pangol', $data);
    }

    public function load_data(){

        if (!$this->request->isAJAX()) {
			exit('No direct script is allowed');
		}
        $model = new PangolModel();

        $csrfToken = csrf_token();
        $csrfHash = csrf_hash();

        $list = $model->get_datatables();
        $count_all = $model->count_all();
        $count_filter = $model->count_filter();

        $data = array();
        $no = $_POST['start'];
        foreach ($list as $key) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $key->kode;
            $row[] = $key->nama_pangol;
            $row[] = '
            <a style="margin-right:5px;" href="javascript:void(0)" id="" data-rel="tooltip" data-placement="top" title="[ Detail Data ]"><i class="fas fa-info-circle text-info"></i></a>
            <a style="margin-right:5px;" href="javascript:void(0)" id="" data-rel="tooltip" data-placement="top" title="[ Update Data ]"><i class="fas fa-edit text-warning"></i></a>
            <a style="margin-right:5px;" href="javascript:void(0)" id="" data-rel="tooltip" data-placement="top" title="[ Delete Data ]"><i class="fas fa-trash text-danger"></i></a>
            ';
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $count_all->total,
            "recordsFiltered" => $count_filter->total,
            "data" => $data
        );

        $output[$csrfToken] = $csrfHash;
        echo json_encode($output);
    }

    function create(){
        if (!$this->request->isAJAX()) {
			exit('No direct script is allowed');
		}

        $validation = \Config\Services::validation();

        $valid = $this->validate([
            'kode' => [
                'label'     => 'Kode Pangkat & Golongan',
                'rules'     => 'required|is_unique[etbl_pangol.kode]',
                'errors'    => [
                    'required'  => '{field} tidak boleh Kosong',
                    'is_unique' => '{field} Telah Digunakan'
                ]
            ],
            'nama_pangol' => [
                'label' => 'Nama Pangkat & Golongan',
                'rules' => 'required'
            ]
        ]);

        if(!$valid){
            $data['msg'] = $validation->getErrors();
        }
        // print_r($validation->getErrors());die();
        $data['success'] = false;
        echo json_encode($data);

    }
}
