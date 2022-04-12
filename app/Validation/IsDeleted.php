<?php

namespace App\Validation;
use App\Models\Admin\PegawaiModel;

class IsDeleted
{
    // public function custom_rule(): bool
    // {
    //     return true;
    // }

    public function IsDeleted(string $str, string $fields, array $data)
	{

        $model = new PegawaiModel();
        $pegawai = $model->where('nip', $data['namaPegawaiAddEditForm'])->where('deleted_at', null)->first();

        if ($pegawai == null) {
			return false;
		} else {
			return true;
		}
	}
}
