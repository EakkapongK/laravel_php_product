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
                    <!-- products
                   <pre>{{ json_encode($products, JSON_PRETTY_PRINT) }}</pre> -->

                    @if(session("success"))
                    <div class="alert alert-success">{{session('success')}}</div>
                    @endif
                    <div class="card p-2">
                        <div class="header mb-2"><b> ตารางข้อมูลสินค้า</b></div>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">ลำดับ</th>
                                    <th scope="col">รหัส</th>
                                    <th scope="col">ชื่อ</th>
                                    <th scope="col">จำนวน</th>
                                    <th scope="col">ราคา</th>
                                    <th scope="col">แก้ไข</th>
                                    <th scope="col">ลบ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $row)
                                <tr>
                                    <th>{{ $row -> itemNo }}</th>
                                    <th>{{ $row -> code }}</th>
                                    <td>{{ $row -> name }}</td>
                                    <td>{{ $row -> quantity }}</td>
                                    <td>{{ $row -> price }}</td>
                                    <td>
                                        <a href="{{url('/product/edit/'.$row->id)}}" class="btn btn-primary">แก้ไข</a>
                                    </td>
                                    <td>
                                        <a href="{{url('/product/delete/'.$row->id)}}" class="btn btn-danger" onclick="return confirm('คุณต้องการลบข้อมูลหรือไม่?')">ลบ</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card p-2">
                        <div class="header mb-2"><b> แบบฟอร์มสินค้า</b></div>
                        <div class="class-body">
                            <form action="{{route('addProduct')}}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="product_code">รหัสสินค้า</label>
                                    <input type="text" class="form-control" name="product_code">
                                </div>
                                @error('product_code')
                                <div class="my-2">
                                    <span class="text-danger">{{$message}}</span>
                                </div>
                                @enderror

                                <div class="form-group">
                                    <label for="product_name">ชื่อสินค้า</label>
                                    <input type="text" class="form-control" name="product_name">
                                </div>
                                @error('product_name')
                                <div class="my-2">
                                    <span class="text-danger">{{$message}}</span>
                                </div>
                                @enderror

                                <div class="form-group">
                                    <label for="product_price">ราคา</label>
                                    <input type="number" class="form-control" name="product_price" value="100">
                                </div>

                                <div class="form-group">
                                    <label for="product_quantity">จำนวน</label>
                                    <input type="number" class="form-control" name="product_quantity" value="1">
                                </div>

                                <div class="form-group">
                                    <label for="product_remark">หมายเหตุ</label>
                                    <input type="text" class="form-control" name="product_remark" value="">
                                </div>

                                <div class="form-group">
                                    <label for="product_itemNo">ลำดับแสดง</label>
                                    <input type="number" class="form-control" name="product_itemNo" value="1">
                                </div>

                                <!-- <div class="form-group">
                                    <label for="service_image">ภาพประกอบ</label>
                                    <input type="file" class="form-control" name="service_image">
                                </div>
                                @error('service_image')
                                <div class="my-2">
                                    <span class="text-danger">{{$message}}</span>
                                </div>
                                @enderror -->
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