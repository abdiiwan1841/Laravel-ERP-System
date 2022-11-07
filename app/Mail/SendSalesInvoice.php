<?php

namespace App\Mail;

use App\Models\ERP\Settings\GeneralSetting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendSalesInvoice extends Mailable
{
    use Queueable, SerializesModels;

    public $salesInvoice;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($salesInvoice)
    {
        $this->salesInvoice = $salesInvoice;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $companyData = GeneralSetting::all()->first();
        return $this->subject(trans('emails.new_invoice'))->view('emails.send-sales-invoice')
            ->attach(public_path('uploads/sales-invoices-pdf/').$this->salesInvoice->inv_number.'.pdf')
            ->with([
                'salesInvoice' => $this->salesInvoice,
                'companyData' => $companyData
            ]);
    }
}
