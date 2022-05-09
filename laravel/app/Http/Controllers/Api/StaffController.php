<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Staff\StaffCollection;
use App\Http\Resources\Staff\StaffResource;
use App\Models\Staff;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function index()
    {
        $staffs = Staff::where('id', '!=', 1)->get();
        $data = new StaffCollection(StaffResource::collection($staffs));
        return response()->json($data);
    }
}
