<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Wishlist;
use App\Models\Cart;
use App\Models\State;
use Illuminate\Support\Str;
use Helper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    protected $product = null;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function addToCart(Request $request)
    {
        // dd($request->all());
        if (empty($request->slug)) {
            request()->session()->flash('error', 'Invalid Products');
            return back();
        }

        $product = Product::where('slug', $request->slug)->first();


        // return $product;
        if (empty($product)) {
            request()->session()->flash('error', 'Invalid Products');
            return back();
        }

        $already_cart = Cart::where('user_id', auth()->user()->id)->where('order_id', null)->where('product_id', $product->id)->first();
        // return $already_cart;
        if ($already_cart) {
            // dd($already_cart);
            $already_cart->quantity = $already_cart->quantity + 1;
            $already_cart->amount = $product->price + $already_cart->amount;
            // return $already_cart->quantity;
            if ($already_cart->product->stock < $already_cart->quantity || $already_cart->product->stock <= 0) return back()->with('error', 'Stock not sufficient!.');
            $already_cart->save();
        } else {

            $cart = new Cart;
            $cart->user_id = auth()->user()->id;
            $cart->product_id = $product->id;
            $cart->price = ($product->price - ($product->price * $product->discount) / 100);
            $cart->quantity = 1;
            $cart->amount = $cart->price * $cart->quantity;
            if ($cart->product->stock < $cart->quantity || $cart->product->stock <= 0) return back()->with('error', 'Stock not sufficient!.');
            $cart->save();
            $wishlist = Wishlist::where('user_id', auth()->user()->id)->where('cart_id', null)->update(['cart_id' => $cart->id]);
        }


        if ($request->ajax()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Product successfully added to cart',
                'cartCount' => Helper::cartCount(),
                'cartItems' => Helper::getAllProductFromCart(),
                'cartTotal' => Helper::totalCartPrice(),
            ]);
        }

        request()->session()->flash('success', 'Product successfully added to cart');
        return back();
    }

    public function singleAddToCart(Request $request)
    {
        $request->validate([
            'slug'      =>  'required',
            'quant'      =>  'required',
        ]);
        // dd($request->quant[1]);


        $product = Product::where('slug', $request->slug)->first();
        if ($product->stock < $request->quant[1]) {
            return back()->with('error', 'Out of stock, You can add other products.');
        }
        if (($request->quant[1] < 1) || empty($product)) {
            request()->session()->flash('error', 'Invalid Products');
            return back();
        }

        $already_cart = Cart::where('user_id', auth()->user()->id)->where('order_id', null)->where('product_id', $product->id)->first();

        // return $already_cart;

        if ($already_cart) {
            $already_cart->quantity = $already_cart->quantity + $request->quant[1];
            // $already_cart->price = ($product->price * $request->quant[1]) + $already_cart->price ;
            $already_cart->amount = ($product->price * $request->quant[1]) + $already_cart->amount;

            if ($already_cart->product->stock < $already_cart->quantity || $already_cart->product->stock <= 0) return back()->with('error', 'Stock not sufficient!.');

            $already_cart->save();
        } else {

            $cart = new Cart;
            $cart->user_id = auth()->user()->id;
            $cart->product_id = $product->id;
            $cart->price = ($product->price - ($product->price * $product->discount) / 100);
            $cart->quantity = $request->quant[1];
            $cart->amount = ($product->price * $request->quant[1]);
            if ($cart->product->stock < $cart->quantity || $cart->product->stock <= 0) return back()->with('error', 'Stock not sufficient!.');
            // return $cart;
            $cart->save();
        }
        request()->session()->flash('success', 'Product successfully added to cart.');
        return back();
    }

    public function cartDelete(Request $request)
    {
        $cart = Cart::find($request->id);
        if ($cart) {
            $cart->delete();
            request()->session()->flash('success', 'Cart successfully removed');
            return back();
        }
        request()->session()->flash('error', 'Error please try again');
        return back();
    }

    public function cartUpdate(Request $request)
    {
        // dd($request->all());
        if ($request->quant) {
            $error = array();
            $success = '';
            // return $request->quant;
            foreach ($request->quant as $k => $quant) {
                // return $k;
                $id = $request->qty_id[$k];
                // return $id;
                $cart = Cart::find($id);
                // return $cart;
                if ($quant > 0 && $cart) {
                    // return $quant;

                    if ($cart->product->stock < $quant) {
                        request()->session()->flash('error', 'Out of stock');
                        return back();
                    }
                    $cart->quantity = ($cart->product->stock > $quant) ? $quant  : $cart->product->stock;
                    // return $cart;

                    if ($cart->product->stock <= 0) continue;
                    $after_price = ($cart->product->price - ($cart->product->price * $cart->product->discount) / 100);
                    $cart->amount = $after_price * $quant;
                    // return $cart->price;
                    $cart->save();
                    $success = 'Cart successfully updated!';
                } else {
                    $error[] = 'Cart Invalid!';
                }
            }
            return back()->with($error)->with('success', $success);
        } else {
            return back()->with('Cart Invalid!');
        }
    }


    public function checkout(Request $request)
    { 
        $user = auth()->user();

        // Get user's last order for address pre-filling
        $lastOrder = null;
        if ($user) {
            $lastOrder = \App\Models\Order::where('user_id', $user->id)
                ->where('payment_status', 'paid')
                ->orderBy('created_at', 'DESC')
                ->first();
        }
        
         $product = Product::where('slug', $request->slug)->first();

        // Split user name into first and last name
        $nameParts = $user ? explode(' ', $user->name, 2) : ['', ''];
        $firstName = $nameParts[0] ?? '';
        $lastName = $nameParts[1] ?? '';


        $states = State::where('status',1)->get();

        return view('frontend.pages.checkout', compact('states','user', 'lastOrder', 'firstName', 'lastName','product'));
    }

    public function checkoutSuccess()
    {
        return view('frontend.pages.checkout-success');
    }


    public function codCheckout(Request $request)
    {
        
        return view('frontend.pages.cart');
        if (!Auth::check()) {
            return redirect()->guest(route('login.form'));
        }

        if (empty($request->slug)) {
            request()->session()->flash('error', 'Invalid Products');
            return back();
        }

        $user = auth()->user();

        $product = Product::where('slug', $request->slug)->first();


        $already_cart = Cart::where('user_id', auth()->user()->id)->where('order_id', null)->where('product_id', $product->id)->first();

        // return $already_cart;
        if (!$already_cart) {

            $cart = new Cart;
            $cart->user_id = auth()->user()->id;
            $cart->product_id = $product->id;
            $cart->price = ($product->price - ($product->price * $product->discount) / 100);
            $cart->quantity = 1;
            $cart->amount = $cart->price * $cart->quantity;
            if ($cart->product->stock < $cart->quantity || $cart->product->stock <= 0) return back()->with('error', 'Stock not sufficient!.');
            $cart->save();

            $wishlist = Wishlist::where('user_id', auth()->user()->id)->where('cart_id', null)->update(['cart_id' => $cart->id]);
        }

        return view('frontend.pages.cart');
    }

    // // In your CartController
    // public function updateQuantity(Request $request)
    // {
    //     $cart = Cart::find($request->cart_id);

    //     if (!$cart) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'Cart item not found'
    //         ]);
    //     }

    //     $cart->quantity = $request->quantity;
    //     $cart->amount = $cart->price * $request->quantity;
    //     $cart->save();

    //     // Check stock
    //     if ($cart->product->stock < $cart->quantity) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'Stock not sufficient!'
    //         ]);
    //     }

    //     return response()->json([
    //         'status' => 'success',
    //         'message' => 'Cart updated successfully',
    //         'cartCount' => Helper::cartCount(),
    //         'cartItems' => Helper::getAllProductFromCart(),
    //         'cartTotal' => Helper::totalCartPrice(),
    //     ]);
    // }

    // Update cart quantity
    public function updateQuantity(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = Cart::where('user_id', auth()->id())
            ->where('order_id', null)
            ->where('product_id', $request->product_id)
            ->first();

        if (!$cart) {
            return response()->json([
                'status' => 'error',
                'message' => 'Cart item not found'
            ]);
        }

        $product = Product::find($request->product_id);

        // Check stock
        if ($product->stock < $request->quantity) {
            return response()->json([
                'status' => 'error',
                'message' => 'Stock not sufficient! Only ' . $product->stock . ' available'
            ]);
        }

        $cart->quantity = $request->quantity;
        $cart->amount = $cart->price * $request->quantity;
        $cart->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Cart updated successfully',
            'cartCount' => Helper::cartCount(),
            'cartItems' => Helper::getAllProductFromCart(),
            'cartTotal' => Helper::totalCartPrice(),
            'cartItem' => $cart
        ]);
    }

    // Remove product from cart
    public function removeProduct(Request $request)
    {
        $request->validate([
            'product_id' => 'required'
        ]);

        $cart = Cart::where('user_id', auth()->id())
            ->where('order_id', null)
            ->where('product_id', $request->product_id)
            ->first();

        if (!$cart) {
            return response()->json([
                'status' => 'error',
                'message' => 'Cart item not found'
            ]);
        }

        $cart->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Product removed from cart',
            'cartCount' => Helper::cartCount(),
            'cartItems' => Helper::getAllProductFromCart(),
            'cartTotal' => Helper::totalCartPrice()
        ]);
    }

    public function getCityByStateId($state_id)
    {
        $cities = DB::table('cities')
        ->where('state_id', $state_id)
        ->get();
        
        return response()->json($cities);
    }
}
