<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Data;
use Illuminate\Http\Request;

class DataController extends Controller
{
    public function all(){
        //$data = Data::all();
        $data = Data::paginate();
        return $this->success($data);
    }
}
