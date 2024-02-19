@extends('auth.layouts')

@section('content')

<div class="row justify-content-center mt-5">
    <div class="col-md-8">

        <div class="card">
            <div class="card-header">BILLING ADDRESS AND PAYMENT</div>
            <div class="card-body">
                <form action="{{ route('addbillingaddress') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3 row">
                        <label for="customername" class="col-md-4 col-form-label text-md-end text-start">Customer Name</label>
                        <div class="col-md-6">
                        
                           <input type="hidden" name="product_id" value="{{ $product->id }}">
                       
                          <input type="text" class="form-control @error('customername') is-invalid @enderror" id="customername" name="customername" value="{{ old('customername') }}">
                            @if ($errors->has('customername'))
                                <span class="text-danger">{{ $errors->first('customername') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="customeremail" class="col-md-4 col-form-label text-md-end text-start">Customer Email</label>
                        <div class="col-md-6">
                          <input type="text" class="form-control @error('customeremail') is-invalid @enderror" id="customeremail" name="customeremail" value="{{ old('customeremail') }}">
                            @if ($errors->has('customeremail'))
                                <span class="text-danger">{{ $errors->first('customeremail') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="customeraddress" class="col-md-4 col-form-label text-md-end text-start">Customer Address</label>
                        <div class="col-md-6">
                          <input type="text" class="form-control @error('customeraddress') is-invalid @enderror" id="customeraddress" name="customeraddress" value="{{ old('customeraddress') }}">
                            @if ($errors->has('customeraddress'))
                                <span class="text-danger">{{ $errors->first('customeraddress') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="customerstate" class="col-md-4 col-form-label text-md-end text-start">Customer State</label>
                        <div class="col-md-6">
                         <select name="customerstate" id="customerstate" @error('customerstate') is-invalid @enderror" class="form-control">
                        <option value="madhyapradesh">Madhya Pradesh</option>
                        <option value="rajhasthan">Rajhasthan</option>
                        <option value="uttarpradesh">Uttar Pradesh</option>
                        <option value="punjab">Punjab</option>
                        </select>
                            @if ($errors->has('customerstate'))
                                <span class="text-danger">{{ $errors->first('customerstate') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="customerzipcode" class="col-md-4 col-form-label text-md-end text-start">Customer Zip Code</label>
                        <div class="col-md-6">
                          <input type="text" class="form-control @error('customerzipcode') is-invalid @enderror" id="customerzipcode" name="customerzipcode">
                            @if ($errors->has('customerzipcode'))
                                <span class="text-danger">{{ $errors->first('customerzipcode') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="nameoncard" class="col-md-4 col-form-label text-md-end text-start">Name on Card</label>
                        <div class="col-md-6">
                          <input type="text" class="form-control @error('nameoncard') is-invalid @enderror" id="nameoncard" name="nameoncard" value="{{ old('nameoncard') }}">
                            @if ($errors->has('nameoncard'))
                                <span class="text-danger">{{ $errors->first('nameoncard') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="creditcardnumber" class="col-md-4 col-form-label text-md-end text-start">Credit card number</label>
                        <div class="col-md-6">
                          <input type="text" class="form-control @error('creditcardnumber') is-invalid @enderror" id="creditcardnumber" name="creditcardnumber" value="{{ old('creditcardnumber') }}">
                            @if ($errors->has('creditcardnumber'))
                                <span class="text-danger">{{ $errors->first('creditcardnumber') }}</span>
                            @endif
                        </div>
                    </div>

                     <div class="mb-3 row">
                        <label for="expmonth" class="col-md-4 col-form-label text-md-end text-start">Exp Month</label>
                        <div class="col-md-6">
                          <input type="text" class="form-control @error('expmonth') is-invalid @enderror" id="expmonth" name="expmonth" value="{{ old('expmonth') }}">
                            @if ($errors->has('expmonth'))
                                <span class="text-danger">{{ $errors->first('expmonth') }}</span>
                            @endif
                        </div>
                    </div>

                     <div class="mb-3 row">
                        <label for="expyear" class="col-md-4 col-form-label text-md-end text-start">Exp Year</label>
                        <div class="col-md-6">
                          <input type="text" class="form-control @error('expyear') is-invalid @enderror" id="expyear" name="expyear" value="{{ old('expyear') }}">
                            @if ($errors->has('expyear'))
                                <span class="text-danger">{{ $errors->first('expyear') }}</span>
                            @endif
                        </div>
                    </div>

                     <div class="mb-3 row">
                        <label for="cvv" class="col-md-4 col-form-label text-md-end text-start">Cvv</label>
                        <div class="col-md-6">
                          <input type="text" class="form-control @error('cvv') is-invalid @enderror" id="cvv" name="cvv" value="{{ old('cvv') }}">
                            @if ($errors->has('cvv'))
                                <span class="text-danger">{{ $errors->first('cvv') }}</span>
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
