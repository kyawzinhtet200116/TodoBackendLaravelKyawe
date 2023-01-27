<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\TodoRequest;
use App\Models\Todo;
use Illuminate\Support\Facades\Log;

class TodoController extends Controller
{
    public function index(){
        $page=1;
        if(!empty(request()->page)){
            $page=request()->page;
        }
        $todos=Todo::orderBy("created_at","desc")->paginate(10,page: $page);
        return view();
    }
    public function create(){
        return view();
    }
    public function save(TodoRequest $request){
        try{
            $task=$request->task;
            Todo::create([
                "task"=> $task
            ]);
            return redirect()->route("todo");
        }catch(\Exception $e){
            Log::debug("Hello world");
        }
        return redirect(route("todo.create"))->withInput($request->input());
    }
    public function update(){
        return view();
    }
    public function edit(TodoRequest $request){
        return view();
    }
}
