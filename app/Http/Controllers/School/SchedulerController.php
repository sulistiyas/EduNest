<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SchedulerController extends Controller
{
    public function index()
    {
        
        return view('schedule.index');
    }

    public function show($id){
        // 
    }

    public function store(Request $request){
        // 
    }

    public function update(Request $request, $id){
        // 
    }

    public function destroy($id){
        // 
    }
}
