<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = \App\Models\Employee::all();
        dd($employees->toArray());
        return view('admins.index', compact('employees'));
    }
}
