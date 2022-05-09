<?php

namespace App\Http\Services\Staff;

use App\Models\Staff;

class StaffService
{


    public function insert($user, $request)
    {
        Staff::create([
            'user_id' => $user->id,
            'name' => $request['first_name'] . $request['last_name'],
        ]);
        return true;
    }
}
