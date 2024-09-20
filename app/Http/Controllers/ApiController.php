<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\About;
use App\Models\Order;
use App\Models\Contact;
use App\Models\Product;
use App\Models\Category;
use App\Events\InquiryEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{

    // ----------------------Contact API-------------------
    
   public function indexInquiry(Request $request)
    {
        try {
            $validation = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'email|required',
                'message' => 'required',
                'user_id' => 'nullable',
            ]);


            if ($validation->fails()) {
                return response()->json(['statusCode' => 401, 'error' => true, 'error_message' => $validation->errors(), 'message' => 'Please fill the input field properly']);
            }
            Contact::create($request->all());

        Broadcast(new InquiryEvent($request->all()));

           
            return response()->json([
                "statusCode" => 200,
                "error" => false,
                'message' => 'Thank you, your enquiry has been submitted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json(['statusCode' => 401, 'error' => true, 'message' => $e->getMessage()]);
        }
    }


// -----------------------------Category API---------------------------
public function categoryIndex()
{
    try {
        $categories = Category::with('product')->get();

        // Iterate through categories and update the image path for each product
        foreach ($categories as $category) {
            foreach ($category->product as $product) {
                $product['image'] = asset('storage/' . $product->image);
            }
        }

        return response()->json([
            "statusCode" => 200,
            "error" => false,
            'data' => $categories
        ]);
    } catch (\Exception $e) {
        return response()->json(['statusCode' => 401, 'error' => true, 'message' => $e->getMessage()]);
    }
}


// -------------------------SINGLE CATEGORY API---------------------------
public function categorysingle($id)
{
    try {
        $category = Category::with('product')->findOrFail($id);

        // Update the image path for each product in this category
        foreach ($category->product as $product) {
            $product['image'] = asset('storage/' . $product->image);
        }

        return response()->json([
            "statusCode" => 200,
            "error" => false,
            'data' => $category
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'statusCode' => 404, 
            'error' => true, 
            'message' => 'Category not found'
        ]);
    }
}



// --------------------------------About API--------------------------
public function aboutIndex()
    {
        try {
            
           $abouts=About::get();
           foreach ($abouts as $key => $about) {
            $about['image']=asset('storage/' . $about->image);
           }
            return response()->json([
                "statusCode" => 200,
                "error" => false,
                'date' => $abouts
            ]);
        } catch (\Exception $e) {
            return response()->json(['statusCode' => 401, 'error' => true, 'message' => $e->getMessage()]);
        }
    }
// ---------------------------POST Cart API------------------------------
public function cart(Request $request)
    {
        try {
            $validation = Validator::make($request->all(), [
                'user_id' => 'required',
                'product_id' => 'required',
                'quantity' => 'required'
            ]);
           

            if ($validation->fails()) {
                return response()->json(['statusCode' => 401, 'error' => true, 'error_message' => $validation->errors(), 'message' => 'Please fill the input field properly']);
            }
            Cart::create($request->all());
           
            return response()->json([
                "statusCode" => 200,
                "error" => false,
                'message' => 'Thank you, your enquiry has been submitted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json(['statusCode' => 401, 'error' => true, 'message' => $e->getMessage()]);
        }
    }
// --------------------------Get Cart API----------------------------
    public function getCart()
    {
        try {
            
           $carts=Cart::with('product','user')->get();
            return response()->json([
                "statusCode" => 200,
                "error" => false,
                'date' => $carts
            ]);
        } catch (\Exception $e) {
            return response()->json(['statusCode' => 401, 'error' => true, 'message' => $e->getMessage()]);
        }
    }




    //------------------------ Get Single User Cart--------------------
    public function singleUserCart($id)
    {
        try {
            // Fetch cart items with related product details for the authenticated user
            $cartItems = Cart::with('product','user')->where('user_id', $id)->get();

            // Check if the cart is empty
            if ($cartItems->isEmpty()) {
                return response()->json([
                    'statusCode' => 404,
                    'error' => true,
                    'message' => 'No items found in your cart',
                    'data' => []
                ], 404);
            }

            // Return the cart items as JSON
            return response()->json([
                'statusCode' => 200,
                'error' => false,
                'message' => 'Cart items retrieved successfully',
                'data' => $cartItems
            ], 200);

        } catch (\Exception $e) {
            // Handle errors
            return response()->json([
                'statusCode' => 500,
                'error' => true,
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }

// --------------------------UPDATE Cart-------------------------

public function updateCartItem(Request $request, $id)
{
    try {
        // Validate the input
        $validation = Validator::make($request->all(), [
            'quantity' => 'required|integer|min:1'
        ]);

        if ($validation->fails()) {
            return response()->json([
                'statusCode' => 400,
                'error' => true,
                'message' => $validation->errors()
            ]);
        }

        // Find the cart item by ID
        $cartItem = Cart::find($id);

        // Check if the cart item exists
        if (!$cartItem) {
            return response()->json([
                'statusCode' => 404,
                'error' => true,
                'message' => 'Cart item not found'
            ], 404);
        }

        // Update the cart item quantity
        $cartItem->update($request->all());
        

        return response()->json([
            'statusCode' => 200,
            'error' => false,
            'message' => 'Cart item updated successfully'
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'statusCode' => 500,
            'error' => true,
            'message' => 'An error occurred: ' . $e->getMessage()
        ], 500);
    }
}

// -----------------------------DELETE Cart-------------------------------


public function deleteCartItem($id)
{
    try {
        // Find the cart item by ID
        $cartItem = Cart::find($id);

        // Check if the cart item exists
        if (!$cartItem) {
            return response()->json([
                'statusCode' => 404,
                'error' => true,
                'message' => 'Cart item not found'
            ], 404);
        }

        // Delete the cart item
        $cartItem->delete();

        return response()->json([
            'statusCode' => 200,
            'error' => false,
            'message' => 'Cart item deleted successfully'
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'statusCode' => 500,
            'error' => true,
            'message' => 'An error occurred: ' . $e->getMessage()
        ], 500);
    }
}


// ----------------------POST Order API------------------------

public function order(Request $request)
{
    try {
        // Validate the input
        $validation = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'statusCode' => 401,
                'error' => true,
                'error_message' => $validation->errors(),
                'message' => 'Please fill the input field properly'
            ]);
        }

        // Fetch the cart items for the user
        $cartItems = Cart::where('user_id', $request->user_id)->with('product')->get();

        if ($cartItems->isEmpty()) {
            return response()->json([
                'statusCode' => 400,
                'error' => true,
                'message' => 'Cart is empty'
            ]);
        }

        // Calculate the total price
        $total = $cartItems->sum(function ($cartItem) {
            return $cartItem->product->price * $cartItem->quantity;
        });

        // Create the order
        $order = Order::create([
            'user_id' => $request->user_id,
            'total' => $total,
            'status' => 'pending',
            'invoice' => time(),
        ]);

        // Attach products to the order and clear the cart
        foreach ($cartItems as $cartItem) {
            $order->orderItems()->create([
                'product_id' => $cartItem->product_id,
                'quantity' => $cartItem->quantity,
                'price' => $cartItem->product->price,
            ]);
        }

        // Clear the cart
        Cart::where('user_id', $request->user_id)->delete();

        return response()->json([
            "statusCode" => 200,
            "error" => false,
            'message' => 'Order placed successfully',
            'order' => $order
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'statusCode' => 401,
            'error' => true,
            'message' => $e->getMessage()
        ]);
    }
}

    // ------------------------------GET Order API---------------------
    public function getOrder()
    {
        try {
            $orders = Order::with('user', 'product')->get();
            return response()->json([
                "statusCode" => 200,
                "error" => false,
                'data' => $orders
            ]);
        } catch (\Exception $e) {
            return response()->json(['statusCode' => 401, 'error' => true, 'message' => $e->getMessage()]);
        }
    }

    // ----------------getProduct  API----------------------


    public function productsIndex()
    {
        try {
            $products = Product::with('category')->get();
            foreach ($products as $key => $product) {
                $product['image']=asset('storage/' . $product->image);
            }
            return response()->json([
                "statusCode" => 200,
                "error" => false,
                'data' => $products
            ]);
        } catch (\Exception $e) {
            return response()->json(['statusCode' => 401, 'error' => true, 'message' => $e->getMessage()]);
        }
    }


    public function productSingle($id)
{
    try {
        $product = Product::with('category')->findOrFail($id);
         $product['image']=asset('storage/' . $product->image);
        return response()->json([
            "statusCode" => 200,
            "error" => false,
            'data' => $product
        ]);
    } catch (\Exception $e) {
        return response()->json(['statusCode' => 404, 'error' => true, 'message' => 'Product not found']);
    }
}

}