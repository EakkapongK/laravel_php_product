<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Hi , {{Auth::user()->name}}
            <b class="float-end">
               <span> จำนวนผู้ใช้ระบบ {{count($Users)}} คน </span>
            </b>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                <div class="container">
                    <div class="row">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">ลำดับ</th>
                                    <th scope="col">ชื่อ</th>
                                    <th scope="col">อีเมล</th>
                                    <th scope="col">วันที่สร้าง</th>
                                    <th scope="col">เริ่มใช้งานระบบ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php($i = 1)
                                @foreach($Users as $row)
                                <tr>
                                    <th scope="row">{{$i++}}</th>
                                    <td>{{ $row->name }}</td>
                                    <td>{{ $row->email }}</td>
                                    <td>{{ $row->created_at }}</td>
                                    <td>{{ Carbon\Carbon::parse($row->created_at)->diffForHumans() }}</td>
                                    <!-- <td>{{ Carbon\Carbon::parse($row->created_at)->diffForHumans()}}</td> -->
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>


    </div>
</x-app-layout>