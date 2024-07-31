<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Hi , {{Auth::user()->name}}
            <b class="float-end">
            </b>
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="card p-2">
                        <div class="header mb-2"><b> แบบฟอร์มแก้ไขข้อมูล</b></div>
                        <div class="class-body">
                            <form action="{{url('/service/update/'.$service->id)}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="service_name">ชื่อบริการ</label>
                                    <input type="text" class="form-control" name="service_name" value="{{$service->service_name}}">
                                </div>
                                @error('service_name')
                                <div class="my-2">
                                    <span class="text-danger">{{$message}}</span>
                                </div>
                                @enderror

                                <div class="form-group">
                                    <label for="service_image">ภาพประกอบ</label>
                                    <input type="file" class="form-control" name="service_image" value="{{$service->service_image}}">
                                </div>
                                @error('service_image')
                                <div class="my-2">
                                    <span class="text-danger">{{$message}}</span>
                                </div>
                                @enderror
                                <div class="form-group mt-2">
                                    <input type="hidden" name="old_image" value="{{$service->service_image}}">
                                    <img src="{{asset($service->service_image)}}" alt="" srcset="" width="100px" height="100px">
                                </div>
                                <br>
                                <input type="submit" value="อัพเดท" class="btn btn-primary">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>