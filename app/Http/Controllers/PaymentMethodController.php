<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $methods = PaymentMethod::all();
        return view('payment-method.list', compact('methods'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('payment-method.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            "name" => 'required|string|max:255|unique:payment_methods,name',
            "logo" => 'image|mimes:png,jpg,jpeg|max:512',
            'account_no' => 'required|numeric',
            'account_type' => 'nullable|string|max:255',
            'transaction_fee' => 'required|numeric|max:100',
            'status' => 'required|boolean',
        ]);

        $data = new PaymentMethod();
        $data->name = $request->name;
        $data->account_no = $request->account_no;
        $data->account_type = $request->account_type;
        $data->transaction_fee = $request->transaction_fee;
        $data->status = $request->status;
        if ($request->logo) {
            $des = 'payment_method';
            $path =  Helper::saveImage($des, $request->logo, 100, 30);
            $data->logo = $path;
        }
        if ($data->save()) {
            return redirect()->route('config.payment-method.index')->with('success', 'Payment Method created successfully.');
        } else {
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(PaymentMethod $paymentMethod)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PaymentMethod $paymentMethod)
    {

        return view('payment-method.edit', compact('paymentMethod'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PaymentMethod $paymentMethod)
    {
        $request->validate([
            "name" => 'required|string|max:255|unique:payment_methods,name,' . $paymentMethod->id,
            "logo" => 'image|mimes:png,jpg,jpeg|max:512',
            'account_no' => 'required|numeric',
            'account_type' => 'nullable|string|max:255',
            'transaction_fee' => 'required|numeric|max:100',
            'status' => 'required|boolean',
        ]);
        //dd($request->all());

        $paymentMethod->name = $request->name;
        $paymentMethod->account_no = $request->account_no;
        $paymentMethod->account_type = $request->account_type;
        $paymentMethod->transaction_fee = $request->transaction_fee;
        $paymentMethod->status = $request->status;
        if ($request->logo) {

            if ($paymentMethod->logo) {
                Helper::deleteFile($paymentMethod->logo);
            }
            $des = 'payment_method';
            $path =  Helper::saveImage($des, $request->logo, 100, 30);
            $paymentMethod->logo = $path;
        }
        if ($paymentMethod->save()) {
            return redirect()->route('config.payment-method.index')->with('success', 'Payment Method updated successfully.');
        } else {
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PaymentMethod $paymentMethod)
    {
        //
    }
}
