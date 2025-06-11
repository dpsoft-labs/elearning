<?php

namespace App\Http\Controllers\Web\Back\Users\Invoices;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoicesController extends Controller
{
    /**
     * عرض الفواتير
     */
    public function index(Request $request)
    {
        $invoices = Invoice::where('user_id', auth()->user()->id)->get();

        return view('themes.default.back.users.invoices.invoices-list', [
            'invoices' => $invoices
        ]);
    }

    /**
     * عرض المقررات المتاحة للتسجيل
     */
    public function show(Request $request)
    {
        $invoice_id = decrypt($request->invoice_id);
        $invoice = Invoice::findOrFail($invoice_id);

        if($invoice->user_id != auth()->user()->id){
            return view('themes/default/back.permission-denied');
        }

        return view('themes.default.back.users.invoices.invoices-show', [
            'invoice' => $invoice,
        ]);
    }
}