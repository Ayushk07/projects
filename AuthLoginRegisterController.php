<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Product;
use App\Models\BillingDetails;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AuthLoginRegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except([
            'logout', 'dashboard'
        ]);
    }

    public function register()
    {
        return view('auth.register');
    }

    public function createproduct()
    {
        return view('auth.createproduct');
    }
 

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:250',
            'email' => 'required|string|email:rfc,dns|max:250|unique:users,email',
            'password' => 'required|string|min:8|confirmed'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        $credentials = $request->only('email', 'password');
        Auth::attempt($credentials);
        $request->session()->regenerate();
        return redirect()->route('dashboard');
    }

    public function login()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if(Auth::attempt($credentials))
        {
            $request->session()->regenerate();
            // return redirect()->route('dashboard');
            // return response()->json([
            //     'message' => 'Login successful',
            //     'user' => Auth::user(),
            // ]);
            return redirect()->route('dashboard');
        } else {
            
            return response()->json([
                'message' => 'Invalid credentials',
            ], 401);
        }
    } 

    public function dashboard()
    {
        return view('auth.dashboard');
    } 

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('auth.login')
            ->withSuccess('You have logged out successfully!');
    }    

    
    public function createproductcontroller(Request $request){
        $request->validate([
            'productimage'        =>'required | image   | mimes:jpeg,png,jpg,gif|max:2048',
            'productname'        => 'required | Max:250 | string',
            'productquantity'    => 'required | Max:250 | string',
            'productsize'        => 'required | Max:250 | string',
            'productcolor'       => 'required | Max:250 | string',
            'productprice'       => 'required | Max:250 | string',
            'productdescription' => 'required | Max:250 | string',

        ]);
        $imageName = time() . '.' . $request->productimage->extension();
        $request->productimage->move(public_path('images'), $imageName);

        $product = Product::create([
           'productimage'       => $imageName, 
            'productname'       =>$request->productname,
            'productquantity'   =>$request->productquantity,
            'productsize'       =>$request->productsize,
            'productcolor'      =>$request->productcolor,
            'productprice'      =>$request->productprice,
            'productdescription'=>$request->productdescription,
            
        ]);
        // return redirect()->route('auth.dashboard')
        // ->withSuccess('you have succefully inserted product ');
        $products = DB::select('select * from products');
        return view('auth.dashboard', compact('products'));
    }
    public function show($id) {
        $product = Product::findOrFail($id); 
        return view('auth.billingproduct', compact('product'));
    }
    public function billingthankyou()
    {
        return view('auth.billingthankyou');
    } 
    public function billingproduct()
    {
        return view('auth.billingproduct/{$id}');
    } 

    public function addbillingaddress(Request $billingdetails)
    {
        $billingdetails->validate([
            'product_id'           => 'required | Max:250 | string',
            'customername'         => 'required | Max:250 | string',
            'customeremail'        => 'required | Max:250 | string',
            'customeraddress'      => 'required | Max:250 | string',
            'customerstate'        => 'required | Max:250 | string',
            'customerzipcode'      => 'required | Max:250 | string',
            'nameoncard'           => 'required | Max:250 | string',
            'creditcardnumber'     => 'required | Max:250 | string',
            'expmonth'             => 'required | Max:250 | string',
            'expyear'              => 'required | Max:250 | string',
            'cvv'                  => 'required | Max:250 | string',

        ]);
        $billing_details = BillingDetails::create([
            'product_id'           => $billingdetails->product_id, 
            'customername'         => $billingdetails->customername, 
            'customeremail'        => $billingdetails->customeremail,
            'customeraddress'      => $billingdetails->customeraddress,
            'customerstate'        => $billingdetails->customerstate,
            'customerzipcode'      => $billingdetails->customerzipcode,
            'nameoncard'           => $billingdetails->nameoncard,
            'creditcardnumber'     => $billingdetails->creditcardnumber,
            'expmonth'             => $billingdetails->expmonth,
            'expyear'              => $billingdetails->expyear,
            'cvv'                  => $billingdetails->cvv,
            
        ]);
         return redirect()->route('billingthankyou');
        // return view('auth.addbillingaddress');
    } 
}







