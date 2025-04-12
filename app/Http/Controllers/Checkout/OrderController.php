<?php

namespace App\Http\Controllers\Checkout;

use Str;
use App\Models\Link;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use Cartalyst\Stripe\Stripe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $link = Link::whereCode($request->input('code'))->first();

        DB::beginTransaction();

        $order = new Order();

        try {
            $order->first_name = $request->input('first_name');
            $order->last_name = $request->input('last_name');
            $order->email = $request->input('email');
            $order->code = $link->code;
            $order->user_id = $link->user->id;
            $order->influencer_email = $link->user->email;
            $order->address = $request->input('address');
            $order->address2 = $request->input('address2');
            $order->city = $request->input('city');
            $order->country = $request->input('country');
            $order->zip = $request->input('zip');

            $order->save();

            $LineItems = [];

            foreach ($request->input('items') as $item) {
                $product = Product::find($item['product_id']);

                $orderItem = new OrderItem();
                $orderItem->order_id = $order->id;
                $orderItem->product_title = $product->title;
                $orderItem->price = $product->price;
                $orderItem->quantity = $item['quantity'];
                $orderItem->influencer_revenue = 0.1 * $product->price * $item['quantity'];
                $orderItem->admin_revenue = 0.9 * $product->price * $item['quantity'];

                $orderItem->save();

                $LineItems[] = [
                    'name' => $product->title,
                    'description' => $product->description,
                    'amount' => $product->price * 100,
                    'currency' => 'usd',
                    'quantity' => $orderItem->quantity,
                    'images' => [$product->image],
                ];
            }

            $stripe = Stripe::make(env('STRIPE_SECRET'));
            $source = $stripe->checkout()->sessions()->create([
                'payment_method_types' => ['card'],
                'line_items' => $LineItems,
                'mode' => 'payment',
                'success_url' => env('CHECKOUT_URL') . '/success?source={CHECKOUT_SESSION_ID}',
                'cancel_url' => env('CHECKOUT_URL') . '/error',
            ]);

            $order->transaction_id = $source['id'];
            $order->save();

            DB::commit();

            return $source;

            // return compact(['order', 'orderItem']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Order creation failed'], 500);
        }
    }

    public function confirm(Request $request)
    {
        if (!$order = Order::whereTransactionId($request->input('source'))->first()) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        $order->complete = true;
        $order->save();

        return response()->json(['message' => 'Order confirmed successfully'], 200);
    }
}
