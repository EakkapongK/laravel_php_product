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
                        <div class="header mb-2"><b> ตารางข้อมูลแผนก</b></div>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">ลำดับ</th>
                                    <th scope="col">ชื่อแผนก</th>
                                    <th scope="col">พนักงาน</th>
                                    <th scope="col">วันที่สร้าง</th>
                                    <th scope="col">แก้ไข</th>
                                    <th scope="col">ลบ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php($i = 1)
                                @foreach($departments as $row)
                                <tr>
                                    <th scope="row">{{ $departments -> firstItem() +$loop -> index }}</th>
                                    <td>{{ $row->department_name }}</td>
                                    <td>{{ $row->user->name }}</td>
                                    <td>
                                        @if($row->created_at != null)
                                        {{ $row->created_at }}
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{url('/department/edit/'.$row->id)}}" class="btn btn-primary">แก้ไข</a>
                                    </td>
                                    <td>
                                        <a href="{{url('/department/softdelete/'.$row->id)}}" class="btn btn-warning">ลบ</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{$departments->links()}}
                    </div>
                    @if (count($trashDepartments) > 0)
                    <div class="card p-2 mt-2">
                        <div class="header mb-2"><b> ถังขยะ</b></div>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">ลำดับ</th>
                                    <th scope="col">ชื่อแผนก</th>
                                    <th scope="col">พนักงาน</th>
                                    <th scope="col">วันที่สร้าง</th>
                                    <th scope="col">กู้คืนข้อมูล</th>
                                    <th scope="col">ลบถาวร</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php($i = 1)
                                @foreach($trashDepartments as $row)
                                <tr>
                                    <th scope="row">{{ $trashDepartments -> firstItem() +$loop -> index }}</th>
                                    <td>{{ $row->department_name }}</td>
                                    <td>{{ $row->user->name }}</td>
                                    <td>
                                        @if($row->created_at != null)
                                        {{ $row->created_at }}
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{url('/department/restore/'.$row->id)}}" class="btn btn-primary">กู้คืน</a>
                                    </td>
                                    <td>
                                        <a href="{{url('/department/delete/'.$row->id)}}" class="btn btn-danger">ลบถาวร</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{$trashDepartments->links()}}
                    </div>
                    @endif
                </div>
                <div class="col-md-4">
                    <div class="card p-2">
                        <div class="header mb-2"><b> แบบฟอร์ม</b></div>
                        <div class="class-body">
                            <form action="{{route('addDepartment')}}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="department_name">ชื่อแผนก</label>
                                    <input type="text" class="form-control" name="department_name">
                                </div>
                                @error('department_name')
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