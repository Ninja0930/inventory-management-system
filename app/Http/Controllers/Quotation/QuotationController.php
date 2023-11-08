<?php

namespace App\Http\Controllers\Quotation;

use App\Http\Requests\Quotation\StoreQuotationRequest;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Quotation;
use App\Http\Controllers\Controller;
use App\Models\QuotationDetails;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\DB;

class QuotationController extends Controller
{
    public function index()
    {
        $row = (int) request('row', 10);

        if ($row < 1 || $row > 100) {
            abort(400, 'The per-page parameter must be an integer between 1 and 100.');
        }

        $quotations = Quotation::with(['customer'])
            ->sortable()
            ->paginate($row)
            ->appends(request()->query());

        return view('quotations.index', [
            'quotations' => $quotations
        ]);
    }

    public function create()
    {
        Cart::instance('quotation')->destroy();

        return view('quotations.create', [
            'cart' => Cart::content('quotation'),
            'products' => Product::all(),
            'customers' => Customer::all()
        ]);
    }

    public function store(StoreQuotationRequest $request)
    {
//        dd($request);

        DB::transaction(function () use ($request) {
            $quotation = Quotation::create([
                'date' => $request->date,
                'reference' => $request->reference,
                'customer_id' => $request->customer_id,
                'customer_name' => Customer::findOrFail($request->customer_id)->name,
                'tax_percentage' => $request->tax_percentage,
                'discount_percentage' => $request->discount_percentage,
                'shipping_amount' => $request->shipping_amount * 100,
                'total_amount' => $request->total_amount * 100,
                'status' => $request->status,
                'note' => $request->note,
                'tax_amount' => Cart::instance('quotation')->tax() * 100,
                'discount_amount' => Cart::instance('quotation')->discount() * 100,
            ]);

            foreach (Cart::instance('quotation')->content() as $cart_item) {
                QuotationDetails::create([
                    'quotation_id' => $quotation->id,
                    'product_id' => $cart_item->id,
                    'product_name' => $cart_item->name,
                    'product_code' => $cart_item->options->code,
                    'quantity' => $cart_item->qty,
                    'price' => $cart_item->price * 100,
                    'unit_price' => $cart_item->options->unit_price * 100,
                    'sub_total' => $cart_item->options->sub_total * 100,
                    'product_discount_amount' => $cart_item->options->product_discount * 100,
                    'product_discount_type' => $cart_item->options->product_discount_type,
                    'product_tax_amount' => $cart_item->options->product_tax * 100,
                ]);
            }

            Cart::instance('quotation')->destroy();
        });

        //toast('Quotation Created!', 'success');

        return redirect()
            ->route('quotations.index')
            ->with('success', 'Quotation Created!');
    }

    public function show()
    {

    }

    public function edit()
    {

    }

    public function update()
    {

    }

    public function destroy(Quotation $quotation)
    {
        $quotation->delete();

        return redirect()
            ->route('quotations.index');
    }
}
