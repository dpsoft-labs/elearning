<?php

namespace App\Http\Controllers\Web\Back\Admins\Invoices;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
class InvoicesController extends Controller
{
    /**
     * عرض الفواتير
     */
    public function index(Request $request)
    {
        if (!Gate::allows('show invoices')) {
            return view('themes/default/back.permission-denied');
        }

        $invoices = Invoice::all();

        return view('themes.default.back.admins.invoices.invoices-list', [
            'invoices' => $invoices
        ]);
    }

    /**
     * عرض المقررات المتاحة للتسجيل
     */
    public function show(Request $request)
    {
        if (!Gate::allows('show invoices')) {
            return view('themes/default/back.permission-denied');
        }

        $invoice_id = decrypt($request->invoice_id);
        $invoice = Invoice::findOrFail($invoice_id);

        return view('themes.default.back.admins.invoices.invoices-show', [
            'invoice' => $invoice,
        ]);
    }

    /**
     * حذف الفواتير
     */
    public function delete(Request $request)
    {
        if (!Gate::allows('delete invoices')) {
            return view('themes/default/back.permission-denied');
        }

        $invoice_id = decrypt($request->invoice_id);
        $invoice = Invoice::findOrFail($invoice_id);
        $invoice->delete();

        return redirect()->back()->with('success', __('l.Invoice deleted successfully'));
    }

    /**
     * حذف الفواتير المحددة
     */
    public function deleteSelected(Request $request)
    {
        if (!Gate::allows('delete invoices')) {
            return view('themes/default/back.permission-denied');
        }

        $invoice_ids = $request->invoice_ids;
        Invoice::whereIn('id', $invoice_ids)->delete();

        return redirect()->back()->with('success', __('l.Invoice deleted successfully'));
    }
}
