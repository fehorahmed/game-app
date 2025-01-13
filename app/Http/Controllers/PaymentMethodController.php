<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Resources\PaymentMethodResource;
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
            'limit_start' => 'required|numeric|min:0',
            'limit_end' => 'required|numeric|min:0',
            'withdraw_limit_start' => 'required|numeric|min:0',
            'withdraw_limit_end' => 'required|numeric|min:0',
            'manual_text' => 'required|string|max:65000',
        ]);

        $data = new PaymentMethod();
        $data->name = $request->name;
        $data->account_no = $request->account_no;
        $data->account_type = $request->account_type;
        $data->transaction_fee = $request->transaction_fee;
        $data->limit_start = $request->limit_start;
        $data->limit_end = $request->limit_end;
        $data->withdraw_limit_start = $request->withdraw_limit_start;
        $data->withdraw_limit_end = $request->withdraw_limit_end;
        $data->manual_text = $request->manual_text;
        $data->status = $request->status;
        if ($request->logo) {
            $des = 'payment_method';
            $path =  Helper::saveImage($des, $request->logo, 100, 100);
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
            'limit_start' => 'required|numeric|min:0',
            'limit_end' => 'required|numeric|min:0',
            'withdraw_limit_start' => 'required|numeric|min:0',
            'withdraw_limit_end' => 'required|numeric|min:0',
            'manual_text' => 'required|string|max:65000',
        ]);
        //dd($request->all());

        $paymentMethod->name = $request->name;
        $paymentMethod->account_no = $request->account_no;
        $paymentMethod->account_type = $request->account_type;
        $paymentMethod->transaction_fee = $request->transaction_fee;
        $paymentMethod->limit_start = $request->limit_start;
        $paymentMethod->limit_end = $request->limit_end;
        $paymentMethod->withdraw_limit_start = $request->withdraw_limit_start;
        $paymentMethod->withdraw_limit_end = $request->withdraw_limit_end;
        $paymentMethod->manual_text = $request->manual_text;
        $paymentMethod->status = $request->status;
        if ($request->logo) {

            if ($paymentMethod->logo) {
                Helper::deleteFile($paymentMethod->logo);
            }
            $des = 'payment_method';
            $path =  Helper::saveImage($des, $request->logo, 100, 100);
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
    public function getApiPaymentMethod()
    {
        return response(PaymentMethodResource::collection(PaymentMethod::where('status',1)->get()));
    }
}
