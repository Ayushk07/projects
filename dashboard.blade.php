@extends('auth.layouts')

@section('content')

<div class="row justify-content-center mt-5">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Dashboard</div>
            <div class="card-body">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        {{ $message }}
                    </div>
                @else
                    <div class="alert alert-success">
                        You are logged in!
                    </div>       
                    <nav class="navbar navbar-inverse visible-xs">
                <div class="container-fluid">
                    <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>                        
                    </button>
                    <a class="navbar-brand" href="#"></a>
                    </div>
                    <div class="collapse navbar-collapse" id="myNavbar">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="#">Dashboard</a></li>
                        <li><a href="#">Acoount</a></li>
                    </ul>
                    </div>
                </div>
                </nav>
                <div class="container-fluid">
                <div class="row content">
                    <div class="col-sm-3 sidenav hidden-xs">
                    <h2>Dashboard</h2>
                    <ul class="nav nav-pills nav-stacked">
                        <li class="active"><a href="#section1">Dashboard</a></li>
                        <li><a href="/createproduct">Add Product</a></li>
                    </ul><br>
                    </div>
                    <br>
                    <div class="col-sm-9">
                    <div class="well">
                    <p>Already have an account? <a href="/auth/createproduct">Sign in</a></p>
                        <h4>Dashboard</h4>
                        <div class="image1">
                                <img src="{{ 'images/image1.jpg' }}" name="image1">            
                            </div>
                            <div class="content">
                                    <p>Naina Pandey</p> 
                                    <p>Ux / Ui Designer</p> 
                                    <p>jaipur, Rajhasthan</p> 
                                </div> 
                            <div class="discription">  
                                    <p>ABOUT ME
                                    Hi there! I'm Naina Pandey, a UX/UI designer who is passionate about building smooth enjoyable digital experiences. 
                                    I have a good sense of aesthetics as well as
                                    a solid understanding of user psychology, which enables me to create visually appealing interfaces that are also
                                    highly useful.</p>
                                </div>
                        </div>
                        <section class="section-container">
                            <div class="product-list-container">
                            <div class="product-list" id="productList">
                               @foreach($products as $product)
                                <div class="product-card">
                                    <img src="{{ asset('images/' . $product->productimage) }}" onclick="openModal();currentSlide(4)">  
                                    <h4 >{{ $product->productname }}</h4>
                                    <h3 >{{ $product->productprice }}</h3>
                                    <button class="btn btn-primary open-modal" data-productid="{{ $product->id }}">Open Product</button> <br><br>
                                    <a class="nextlink" id="nextlink" href="{{ route('show',$product->id) }}">Product Billing</a>                 
                                    <div id="myModal_{{ $product->id }}" class="modal">
                                        <div class="modal-content">
                                            <span class="close">&times;</span>
                                            <img src="{{ asset('images/' . $product->productimage) }}">  
                                            <h4>{{ $product->productname }}</h4>
                                            <h3>{{ $product->productprice }}</h3>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            </div>
                            <div id="scrollRight" class="scroll-icon">
                        <i class="fas fa-arrow-right"></i>
                        </div>
                        </div>
                    </section>
                    </div>
                    </div>
                @endif    
            </div>
        </div>
    </div>    
</div>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<script src="{{ asset('js/script.js')}}"></script>
@endsection
