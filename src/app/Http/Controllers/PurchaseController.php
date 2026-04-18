<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Item;
use \App\Models\Order;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PurchaseRequest;
use App\Http\Requests\AddressRequest;

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
        Order::create([
            'item_id' => $item->id,
            'user_id' => Auth::id(),
            'payment_method' => $validated['payment_method'],
            'price' => $item->price,
            'shipping_postal_code' => $validated['shipping_postal_code'],
            'shipping_address' => $validated['shipping_address'],
            'shipping_building' => $validated['shipping_building'],
        ]);
        session()->forget('new_address');
        return redirect()->route('item.index');
    }
}