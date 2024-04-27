<?php

namespace App\Http\Controllers\traits;

trait responseTrait
{
public function apiResponse($data=null,$status=null,$msg=null){
    $array=[
        'data'=>$data,
        'status'=>$status,
        'msg'=>$msg
    ];
    return response($array);

}
}
