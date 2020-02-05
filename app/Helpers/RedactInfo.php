<?php

namespace App\Helpers;

use App\Models\User;

class RedactInfo
{
    public function redactInfo($data)
    {
        if(is_array($data)) {
            $data['bank'] = substr_replace($data['bank'], $this->makeStar($data['bank']), 3);
            $data['accnt_name'] = substr_replace($data['accnt_name'], $this->makeStar($data['accnt_name']), 3);
            $data['bsb'] = substr_replace($data['bsb'], $this->makeStar($data['bsb']), 3);
            $data['accnt_num'] = substr_replace($data['accnt_num'], $this->makeStar($data['accnt_num']), 3);
        }else {
            $data->bank = substr_replace($data->bank, $this->makeStar($data->bank), 3);
            $data->accnt_name = substr_replace($data->accnt_name, $this->makeStar($data->accnt_name), 3);
            $data->bsb = substr_replace($data->bsb, $this->makeStar($data->bsb), 3);
            $data->accnt_num = substr_replace($data->accnt_num, $this->makeStar($data->accnt_num), 3);
        }
        
        return $data;
    }

    public function makeStar($data)
    {
        $star = '';

        for($x = 0; $x < strlen($data)-3; $x++){
            $star .= '*';
        }

        return $star;
    }
}
