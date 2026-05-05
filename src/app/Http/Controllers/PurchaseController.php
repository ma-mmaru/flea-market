<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Item;
use \App\Models\Order;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PurchaseRequest;
use App\Http\Requests\AddressRequest;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class PurchaseController extends Controller
{
    public function show(Request $request, Item $item)
    {
        $user = Auth::user();
        $address = session('new_address', [
            'postal_code' => $user->postal_code ?? '',
            'address' => $user->address ?? '',
            'building' => $user->building ?? '',
        ]);
        $address = array_merge([
            'postal_code' => '',
            'address' => '',
            'building' => '',
        ], (array)$address);
        $selectedPayment = $request->input('payment_method') ?? old('payment_method') ?? session('selected_payment');
        return view('purchase', compact('item', 'address', 'selectedPayment'));
    }
    public function editAddress(Item $item)
    {
        $user = Auth::user();
        $address = session('new_address', [
            'postal_code' => $user->postal_code ?? '',
            'address' => $user->address ?? '',
            'building' => $user->building ?? '',
        ]);
        $address = array_merge([
            'postal_code' => '',
            'address' => '',
            'building' => '',
        ], (array)$address);
        return view('address_edit', compact('item', 'address'));
    }
    public function updateAddress(AddressRequest $request, Item $item)
    {
        session(['new_address' => $request->validated()]);
        return redirect()->route('purchase.show', ['item' => $item->id]);
    }
    public function store(PurchaseRequest $request, Item $item)
    {
        $validated = $request->validated();
        session(['pending_order' => [
            'item_id' => $item->id,
            'payment_method' => $validated['payment_method'],
            'shipping_postal_code' => $validated['shipping_postal_code'],
            'shipping_address' => $validated['shipping_address'],
            'shipping_building' => $validated['shipping_building'],
        ]]);
        Stripe::setApiKey(config('services.stripe.secret'));
        $paymentMethodType = ($validated['payment_method'] === 'コンビニ支払い') ? 'konbini' : 'card';
        $checkout_session = Session::create([
            'payment_method_types' => [$paymentMethodType],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'jpy',
                    'product_data' => [
                        'name' => $item->name,
                    ],
                    'unit_amount' => $item->price,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('purchase.success', ['item => $item->id']),
            'cancel_url' => route('purchase.show', ['item' => $item->id]),
        ]);
        return redirect($checkout_session->url, 303);
    }
    public function success(Item $item)
    {
        $pendingOrder = session('pending_order');
        if(!$pendingOrder || $pendingOrder['item_id'] !== $item->id)
            {
                return redirect()->route('item.show', $item)->with('error', '決済情報が見つかりませんでした。');
            }
        Order::create([
            'item_id' => $item->id,
            'user_id' => Auth::id(),
            'payment_method' => $pendingOrder['payment_method'],
            'price' => $item->price,
            'shipping_postal_code' => $pendingOrder['shipping_postal_code'],
            'shipping_address' => $pendingOrder['shipping_address'],
            'shipping_building' => $pendingOrder['shipping_building'] ?? null,
        ]);
        session()->forget(['pending_order', 'new_address']);
        return redirect()->route('item.index')->with('message', '購入が完了しました。');
    }
}