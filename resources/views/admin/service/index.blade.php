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
                    @if(session("success"))
                    <div class="alert alert-success">{{session('success')}}</div>
                    @endif
                    <div class="card p-2">
                        <div class="header mb-2"><b> ตารางข้อมูลบริการ</b></div>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">ลำดับ</th>
                                    <th scope="col">ภาพประกอบ</th>
                                    <th scope="col">ชื่อบริการ</th>
                                    <th scope="col">วันที่สร้าง</th>
                                    <th scope="col">แก้ไข</th>
                                    <th scope="col">ลบ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php($i = 1)
                                @foreach($services as $row)
                                <tr>
                                    <th scope="row">{{ $services -> firstItem() +$loop -> index }}</th>
                                    <td>
                                        <img src="{{asset($row->service_image)}}" alt="" srcset="" width="100px" height="100px">
                                    </td>
                                    <td>{{ $row->service_name }}</td>
                                    <td>
                                        @if($row->created_at != null)
                                        {{ $row->created_at }}
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{url('/service/edit/'.$row->id)}}" class="btn btn-primary">แก้ไข</a>
                                    </td>
                                    <td>
                                        <a href="{{url('/service/delete/'.$row->id)}}" class="btn btn-warning" onclick="return confirm('คุณต้องการลบข้อมมูลหรือไม่?')">ลบ</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{$services->links()}}
                    </div>

                </div>
                <div class="col-md-4">
                    <div class="card p-2">
                        <div class="header mb-2"><b> แบบฟอร์มบริการ</b></div>
                        <div class="class-body">
                            <form action="{{route('addService')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="service_name">ชื่อบริการ</label>
                                    <input type="text" class="form-control" name="service_name">
                                </div>
                                @error('service_name')
                                <div class="my-2">
                                    <span class="text-danger">{{$message}}</span>
                                </div>
                                @enderror

                                <div class="form-group">
                                    <label for="service_image">ภาพประกอบ</label>
                                    <input type="file" class="form-control" name="service_image">
                                </div>
                                @error('service_image')
                                <div class="my-2">
                                    <span class="text-danger">{{$message}}</span>
                                </div>
                                @enderror
                                <br>
                                <input type="submit" value="บันทึก" class="btn btn-primary">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>