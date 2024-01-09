<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    public function isVerified(Request $request)
    {
        return response()->json(!is_null($request->user()->email_verified_at));
    }

    public function afterVerify(Request $request)
    {
        return redirect('/complete_profile/');
    }

    public function export()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }
}
