<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TodoRequest;
use App\Models\Todo;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
class ApiTodoController extends Controller
{
    public function index(){
        $page=1;
        $name = request()->name;
        if(!empty(request()->page)){
            $page=request()->page;
        }
        $query=Todo::orderBy("created_at","desc");
        if ($name != null)
            $query->where('task', $name);
        $todos=$query->paginate(10,page: $page);
        // $todos=Todo::orderBy("created_at","desc")->get();
        return response()->json(['status'=>'OK','data'=>$todos]);
    }
    public function save(TodoRequest $request){
        try{
            $task=$request->task;
            Todo::create([
                "task"=> $task
            ]);
            return response()->json(["status"=>"OK","message"=>"Created Successfully"]);
        }catch(\Exception $e){
            Log::debug("Hello world");
        }
        return response()->json(["status"=>"ER","message"=> "DB Error"]);
    }
    public function getOne(int $id){
        try{
            $task=Todo::where('id',$id)->first();
            
            return response()->json(["status"=>"OK","data"=>$task]);
        }catch(\Exception $e){
            Log::debug("Hello world");
        }
        return response()->json(["status"=>"ER","message"=> "DB Error"]);
    }
    public function edit(TodoRequest $request,int $id){
        try{
            $todo=Todo::find($id);
            if($todo){
                $todo->task=$request->task;
                $todo->save();
                return response()->json(["status"=>"OK","message"=>"Updated Successfully"]);
            }
        }catch(\Exception $e){
            Log::debug("Hello world");
        }
        return response()->json(["status"=>"ER","message"=> "DB Error"]);
    }
    public function delete(int $id){
        try{
            $todo=Todo::find($id);
            if($todo){
                $todo->delete();
                return response()->json(["status"=>"OK","message"=>"Deleted Successfully"]);
            }
        }catch(\Exception $e){
            Log::debug("Hello world");
        }
        return response()->json(["status"=>"ER","message"=> "DB Error"]);
    }
    public function autocomplete(){
        try{
            $todo = Todo::where("task", "like", !empty(request()->name)? request()->name:""  . "%")->get();
            return response()->json(["status" => "OK", "data" => $todo]);
        }catch(\Exception $e){
            return response()->json(["status" => "NG", "message" => "Bad Request"]);
        }
    }
}
