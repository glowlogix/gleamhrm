<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index()
     {
        
        return view('admin.attendance.index');
    }

}
