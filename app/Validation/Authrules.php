<?php

namespace App\Validation;

use App\Models\Admin\PegawaiModel;

class Authrules
{
    // public function custom_rule(): bool
    // {
    //     return true;
    // }

    public function validateLogin(string $str, string $fields, array $data)
    {
        $model = new PegawaiModel();
        $user = $model->where('username', $data['username'])
            ->first();

        if (!$user) {
            return false;
        }

        return password_verify($data['password'], $user['password']);
    }
}
