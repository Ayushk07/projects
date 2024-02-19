@extends('auth.layouts')

@section('content')

<div class="row justify-content-center mt-5">
    <div class="col-md-8">

        <div class="card">
            <div class="card-header">Add Product</div>
            <div class="card-body">
                <form action="{{ route('createproductcontroller') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3 row">
                        <label for="productimage" class="col-md-4 col-form-label text-md-end text-start">Product Image</label>
                        <div class="col-md-6">
                          <input type="file" class="form-control @error('productimage') is-invalid @enderror" id="productimage" name="productimage" value="{{ old('productimage') }}">
                            @if ($errors->has('productimage'))
                                <span class="text-danger">{{ $errors->first('productimage') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="productname" class="col-md-4 col-form-label text-md-end text-start">Product Name</label>
                        <div class="col-md-6">
                          <input type="text" class="form-control @error('productname') is-invalid @enderror" id="productname" name="productname" value="{{ old('productname') }}">
                            @if ($errors->has('productname'))
                                <span class="text-danger">{{ $errors->first('productname') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="productquantity" class="col-md-4 col-form-label text-md-end text-start">product Quantity</label>
                        <div class="col-md-6">
                          <input type="number" class="form-control @error('productquantity') is-invalid @enderror" id="productquantity" name="productquantity" value="{{ old('productquantity') }}">
                            @if ($errors->has('productquantity'))
                                <span class="text-danger">{{ $errors->first('productquantity') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="productsize" class="col-md-4 col-form-label text-md-end text-start">Product Size</label>
                        <div class="col-md-6">
                         <select name="productsize" id="productsize" @error('productsize') is-invalid @enderror" class="form-control">
                        <option value="small">Small</option>
                        <option value="medium">Medium</option>
                        <option value="large">Large</option>
                        <option value="extralarge">Extra Large</option>
                        </select>
                            @if ($errors->has('productsize'))
                                <span class="text-danger">{{ $errors->first('productsize') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="productcolor" class="col-md-4 col-form-label text-md-end text-start">Product Color</label>
                        <div class="col-md-6">
                        <select name="productcolor" id="productcolor" @error('productcolor') is-invalid @enderror" class="form-control">
                        <option value="red">Red</option>
                        <option value="yellow">Yellow</option>
                        <option value="green">Green</option>
                        <option value="blue">Blue</option>
                        </select>
                            @if ($errors->has('productcolor'))
                                <span class="text-danger">{{ $errors->first('productcolor') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="productprice" class="col-md-4 col-form-label text-md-end text-start">Product Price</label>
                        <div class="col-md-6">
                          <input type="text" class="form-control @error('productprice') is-invalid @enderror" id="productprice" name="productprice">
                            @if ($errors->has('productprice'))
                                <span class="text-danger">{{ $errors->first('productprice') }}</span>
                            @endif
                        </div>
                    </div>
                     <div class="mb-3 row">
                        <label for="productdescription" class="col-md-4 col-form-label text-md-end text-start">Product Description</label>
                        <div class="col-md-6">
                          <input type="text" class="form-control @error('productdescription') is-invalid @enderror" id="productdescription" name="productdescription">
                            @if ($errors->has('productdescription'))
                                <span class="text-danger">{{ $errors->first('productdescription') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <input type="submit" class="col-md-3 offset-md-5 btn btn-primary" value="Register">
                    </div>
                    
                </form>
            </div>
        </div>
    </div>    
</div>
    
@endsection
