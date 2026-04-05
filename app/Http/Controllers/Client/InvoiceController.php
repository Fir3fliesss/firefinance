<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Response;
use Illuminate\View\View;
use XanderID\QrisDynamicify\QrisDynamicify;

class InvoiceController extends Controller
{
    public function show(Invoice $invoice): View
    {
        $this->authorize($invoice);

        $invoice->load('order.items.service', 'order.user');

        $staticQris = config('services.qris.static');
        $dynamicQris = null;

        if ($staticQris && $invoice->status === 'unpaid') {
            try {
                $dynamicQris = (string) QrisDynamicify::fromString($staticQris)
                    ->setPrice((int) $invoice->order->total_amount);
            } catch (\Exception $e) {
                logger()->error('QRIS Generation failed: ' . $e->getMessage());
            }
        }

        return view('client.invoices.show', compact('invoice', 'dynamicQris'));
    }

    public function print(Invoice $invoice): View
    {
        $this->authorize($invoice);

        $invoice->load('order.items.service', 'order.user');

        $staticQris = config('services.qris.static');
        $dynamicQris = null;

        if ($staticQris && $invoice->status === 'unpaid') {
            try {
                $dynamicQris = (string) QrisDynamicify::fromString($staticQris)
                    ->setPrice((int) $invoice->order->total_amount);
            } catch (\Exception $e) {
                logger()->error('QRIS Generation failed: ' . $e->getMessage());
            }
        }

        return view('client.invoices.print', compact('invoice', 'dynamicQris'));
    }

    private function authorize(Invoice $invoice): void
    {
        if ($invoice->order->user_id !== auth()->id()) {
            abort(403);
        }
    }
}
