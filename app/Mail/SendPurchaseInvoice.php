<?php

namespace App\Mail;

use App\Models\ERP\Settings\GeneralSetting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendPurchaseInvoice extends Mailable
{
    use Queueable, SerializesModels;

    public $purchaseInvoice;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($purchaseInvoice)
    {
        $this->purchaseInvoice = $purchaseInvoice;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $companyData = GeneralSetting::all()->first();
        return $this->subject(trans('emails.new_invoice'))->view('emails.send-purchase-invoice')
            ->attach(public_path('uploads/purchase-invoices-pdf/').$this->purchaseInvoice->inv_number.'.pdf')
            ->with([
                'purchaseInvoice' => $this->purchaseInvoice,
                'companyData' => $companyData
            ]);
    }
}
