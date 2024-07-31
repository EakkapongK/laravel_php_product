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
                        <div class="header mb-2"><b> แบบฟอร์มแก้ไขสินค้า</b></div>
                        <!-- <pre>{{ json_encode($product, JSON_PRETTY_PRINT) }}</pre> -->
                        <div class="class-body">
                            <form action="{{url('/product/update/'.$product->id)}}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="product_code">รหัสสินค้า</label>
                                    <input type="text" class="form-control" name="product_code" value="{{$product->code}}">
                                </div>
                                @error('product_code')
                                <div class="my-2">
                                    <span class="text-danger">{{$message}}</span>
                                </div>
                                @enderror

                                <div class="form-group">
                                    <label for="product_name">ชื่อสินค้า</label>
                                    <input type="text" class="form-control" name="product_name" value="{{$product->name}}">
                                </div>
                                @error('product_name')
                                <div class="my-2">
                                    <span class="text-danger">{{$message}}</span>
                                </div>
                                @enderror

                                <div class="form-group">
                                    <label for="product_price">ราคา</label>
                                    <input type="number" class="form-control" name="product_price" value="{{$product->price}}">
                                </div>

                                <div class="form-group">
                                    <label for="product_quantity">จำนวน</label>
                                    <input type="number" class="form-control" name="product_quantity" value="{{$product->quantity}}">
                                </div>

                                <div class="form-group">
                                    <label for="product_remark">หมายเหตุ</label>
                                    <input type="text" class="form-control" name="product_remark" value="{{$product->remark}}">
                                </div>

                                <div class="form-group">
                                    <label for="product_itemNo">ลำดับแสดง</label>
                                    <input type="number" class="form-control" name="product_itemNo" value="{{$product->itemNo}}">
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