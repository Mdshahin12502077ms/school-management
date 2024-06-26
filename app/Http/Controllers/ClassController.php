<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\ClassModel;
class ClassController extends Controller
{
    public function list(){

        $data['getrecord']=ClassModel::getrecord();
        $data['header_title']="Class List";
        return view('admin.class.class_list',  $data);
    }

    public function add(){
        $data['header_title']="Add New Class";
        return view('admin.class.add_class',  $data);
    }

    public function insert(Request $request){
       $save=new ClassModel;
       $save->name=$request->name;
       $save->status=$request->status;
       $save->created_by=Auth::user()->id;
        $save->save();
        return redirect('class_list')->with('success','class successfully added');

    }
    //edit page show
    public function class_edit($id){
        $data['getRecord']=ClassModel::getSingle($id);
        if(!empty($data['getRecord'])){
        $data['header_title']="Edit Class";
        return view('admin.class.Edit_Class',  $data);
        }
        else{
            abort(404);
        }
    }

    //update successfully
    public function update(Request $request ,$id){
        $save=ClassModel::getSingle($id);
        $save->name=$request->name;
        $save->status=$request->status;
       
        $save->save();
        return redirect('class_list')->with('success','class successfully Edited');
    }
    //Delete
    public function delete($id){

        $save=ClassModel::getSingle($id);
        $save->is_delete=1;
        $save->save();
        return redirect('class_list')->with('success','class successfully Deleted');
    }

}
