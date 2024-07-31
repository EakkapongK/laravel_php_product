<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::paginate(5);
        return view('admin.service.index', compact('services'));
    }


    public function add(Request $request)
    {
        //ตรวจสอบข้อมูล
        $request->validate([
            'service_name' => 'required|unique:services|max:255',
            'service_image' => 'required|mimes:jpg,jpge,png'
        ], [
            'service_name.required' => 'กรุณาระบุชื่อบริการด้วยครับ',
            'service_name.max' => 'ระบุได้ไม่เกิน 255 ตัวอักษร',
            'service_name.unique' => 'มีข้อมูลชื่อบริการนี้ในฐานข้อมูลแล้ว',

            'service_image.required' => 'กรุณาระบุภาพประกอบด้วยครับ',
            'service_image.mimes' => 'กรุณาเลือกเป็นรูปภาพ jpg, jpge, png',
        ]);

        //การเข้ารหัสรูปภาพ
        $service_image = $request->file('service_image');
        //genชื่อใหม่
        $name_gen = hexdec(uniqid());
        //ดึงนามสกุลภาพ
        $img_ext = strtolower($service_image->getClientOriginalExtension());
        $img_name = $name_gen . '.' . $img_ext;
        //อัพโหลดภาพ
        $upload_location = 'image/services/';
        $full_path = $upload_location . $img_name;

        $service_image->move($upload_location, $img_name);

        //บันทึกข้อมูล แบบมีmodel
        $service = new Service;
        $service->service_name = $request->service_name;
        $service->service_image  = $full_path;
        $service->save();

        // //บันทึกข้อมูล แบบไม่มีmodel
        // $data = array();
        // $data["service_name"] = $request -> service_name;
        // $data["service_image"] = $full_path;
        // $data["created_at"] = now();
        // $data["updated_at"] = now();
        // DB::table("departments") ->insert($data);

        return redirect()->back()->with('success', 'บันทึกข้อมูลเรียบร้อย');
    }


    public function edit($id)
    {
        $service = Service::find($id);
        return view('admin.service.edit', compact('service'));
    }

    public function update(Request $request, $id)
    {
        //ตรวจสอบข้อมูล
        $request->validate([
            'service_name' => 'required|max:255',
        ], [
            'service_name.required' => 'กรุณาระบุชื่อบริการด้วยครับ',
            'service_name.max' => 'ระบุได้ไม่เกิน 255 ตัวอักษร',
        ]);

        $service_image = $request->file('service_image');
        if ($service_image) {
            //dd("อัพเดทภาพ");
            //genชื่อใหม่
            $name_gen = hexdec(uniqid());
            //ดึงนามสกุลภาพ
            $img_ext = strtolower($service_image->getClientOriginalExtension());
            $img_name = $name_gen . '.' . $img_ext;
            //อัพโหลดภาพ
            $upload_location = 'image/services/';
            $full_path = $upload_location . $img_name;

            $old_image = $request -> old_image;
            unlink($old_image); //ลบภาพเดิม

            $service_image->move($upload_location, $img_name);
            
            $service = Service::find($id) ->update([
                'service_name' => $request -> service_name,
                'service_image' => $full_path
            ]); 
        } else {
            $service = Service::find($id) ->update([
                'service_name' => $request -> service_name
            ]); 
        }
       
        return redirect()->route('service')->with('success','อัพเดทข้อมูลเรียบร้อย');
    }


    public function delete($id)
    {
        $image = Service::find($id);
        $path_image = $image->service_image;
        unlink($path_image); //ลบภาพ

        $delete = Service::find($id)->delete();
        return redirect()->route('service')->with('success','ลบข้อมูลเรียบร้อย');
    }
}
