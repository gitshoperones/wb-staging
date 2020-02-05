<?php

namespace App\Helpers;

class MailChimp
{
    public function mailchimp_request($url, $data, $type = 'post')
    {
        $api_key = env('MAILCHIMP_API_KEY', 'eaf825a4986255612168a9838268d56c-us16');
        $encoded_pfb_data = json_encode($data);
    
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERPWD, 'user:' . $api_key);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        if($type == 'post') {
            curl_setopt($ch, CURLOPT_POST, 1);
        }else {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
        }
        curl_setopt($ch, CURLOPT_POSTFIELDS, $encoded_pfb_data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
        $result['result_info'] = curl_exec($ch); // store response
        $result['response'] = curl_getinfo($ch, CURLINFO_HTTP_CODE); // get HTTP CODE
        $result['errors'] = curl_error($ch); // store errors
    
        curl_close($ch);

        return $result;
    }

    public function manageTag($account, $email, $tag_name, $status)
    {
        $list_id = ($account == 'couple') ? env('MAILCHIMP_LIST_COUPLE', '6f3b22af8f') : env('MAILCHIMP_LIST_BUSINESS', '2206f03c63');
        $email = md5($email);
        
        $url = "https://us16.api.mailchimp.com/3.0/lists/$list_id/members/$email/tags";

        $tags = is_array($tag_name)
            ? array_map(function($tag) use ($status) {
                return [
                    'name' => $tag,
                    'status' => $status
                ];
            }, $tag_name)
            : [
                [
                    'name' => $tag_name,
                    'status' => $status
                ]
            ];

        $data = array(
            'tags' => $tags
        );

        return $this->mailchimp_request($url, $data);
    }
}