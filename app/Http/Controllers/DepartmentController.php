<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use App\Http\Controllers\DateTime;

class DepartmentController extends Controller
{
    public function index(){
        // $departments = Department::all(); //ดึงข้อมูลจาก models        
        $departments = Department::paginate(5); //ดึงข้อมูลจาก models  <td>{{ $row->user->name }}</td> เอาข้อมูลอีกtable
        $trashDepartments = Department::onlyTrashed()-> paginate(3);

        // $departments = DB::table('departments') ->get();
        // $departments = DB::table('departments') ->paginate(5);        
        // $departments = DB::table('departments') 
        //     -> join('users','departments.user_id','users.id')
        //     -> select('departments.*','users.name') -> paginate(5);

        return view('admin.department.index',compact('departments','trashDepartments'));
    }

    public function add(Request $request){
        //ตรวจสอบข้อมูล
        $request -> validate([
            'department_name'=>'required|unique:departments|max:255'
        ],[
            'department_name.required'=>'กรุณาระบุชื่อแผนกด้วยครับ',
            'department_name.max'=>'ระบุได้ไม่เกิน 255 ตัวอักษร',
            'department_name.unique'=>'มีข้อมูลชื่อแผนกนี้ในฐานข้อมูลแล้ว'
        ]);

        // dd($request -> department_name );   //debug
        // //บันทึกข้อมูล แบบมีmodel
        // $department = new Department;   
        // $department -> department_name = $request -> department_name ;
        // $department -> user_id  = Auth::user()->id;
        // $department -> save();
        
        //บันทึกข้อมูล แบบไม่มีmodel
        $data = array();
        $data["department_name"] = $request -> department_name;
        $data["user_id"] = Auth::user()->id;
        $data["created_at"] = now();
        $data["updated_at"] = now();
        DB::table("departments") ->insert($data);

        return redirect()->back()->with('success','บันทึกข้อมูลเรียบร้อย');
    }

    public function edit($id){
        // dd($id );   //debug
        $department = Department::find($id);
        // dd($department -> department_name ); 
        // dd($department ); 
        return view('admin.department.edit',compact('department')); 
    }
    
    public function update(Request $request, $id){
        // dd($id ,$request->department_name);
        //ตรวจสอบข้อมูล
        $request -> validate([
            'department_name'=>'required|unique:departments|max:255'
        ],[
            'department_name.required'=>'กรุณาระบุชื่อแผนกด้วยครับ',
            'department_name.max'=>'ระบุได้ไม่เกิน 255 ตัวอักษร',
            'department_name.unique'=>'มีข้อมูลชื่อแผนกนี้ในฐานข้อมูลแล้ว'
        ]);

        $department = Department::find($id) ->update([
            'department_name' => $request -> department_name,
            'user_id'  => Auth::user()->id
        ]);        
        return redirect()->route('department')->with('success','อัพเดทข้อมูลเรียบร้อย');
    }

    public function softdelete($id){
        $delete = Department::find($id)->delete();
        return redirect()->route('department')->with('success','ลบข้อมูลเรียบร้อย');
    }
    
    public function restore($id){
        $restore = Department::withTrashed()->find($id)->restore();
        return redirect()->route('department')->with('success','กู้คืนข้อมูลเรียบร้อย');
    }
    
    public function delete($id){
        $restore = Department::onlyTrashed()->find($id)->forceDelete();
        return redirect()->route('department')->with('success','ลบข้อมูลถาวรเรียบร้อย');
    }
    
}
