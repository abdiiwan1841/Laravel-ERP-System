<?php

namespace App\Http\Livewire\Erp\Sales\SalesInvoices;

use App\Models\ERP\Sales\SalesInvoice;
use App\Models\ERP\Sales\SalesInvoiceAttachments;
use App\Models\ERP\Sales\SalesInvoicePayment;
use App\Models\ERP\Settings\GeneralSetting;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class ShowSalesInvoice extends Component
{
    public $salesInvoice;
    public $companyData;
    public $currency_symbol;
    public $basic_currency;
    public $invoiceValue;
    public $completedPayments;
    public $allPayments;
    public $due_after_payments;
    public $down_payment;

    protected $listeners = ['recordDeleted' => 'deleteFile', 'invoiceDeleted' => 'deleteSalesInvoice', 'paymentDeleted' => 'deletePayment'];

    public function mount($salesInvoice)
    {
        $this->salesInvoice = $salesInvoice;
        //get general settings currency
        $this->companyData = GeneralSetting::all()->first();
        if(app()->getLocale() == 'ar'){
            $this->currency_symbol = $this->companyData->basic_currency_symbol;
        }else{
            $this->currency_symbol = $this->companyData->basic_currency;
        }

        $this->basic_currency = $this->companyData->basic_currency;

        $paid_to_supplier_inv = (int)preg_replace("/[^0-9]/", "", $salesInvoice->paid_to_supplier_inv);
        $this->down_payment = (int)preg_replace("/[^0-9]/", "", $salesInvoice->down_payment_inv);
        if($salesInvoice->paid_to_supplier_inv == null){
            $this->completedPayments = SalesInvoicePayment::where(['sales_invoice_id'=> $salesInvoice->id, 'payment_status' => 'completed'])->pluck('payment_amount')->toArray();
            $this->allPayments = $this->down_payment+(int)array_sum($this->completedPayments);
            $this->invoiceValue = (int)$salesInvoice->total_inv;
            $this->due_after_payments = ($this->invoiceValue-$this->allPayments);
        }else{
            $this->allPayments = $paid_to_supplier_inv;
            $this->invoiceValue = (int)$salesInvoice->total_inv;
            $this->due_after_payments = ($this->invoiceValue-$this->allPayments);
        }
    }

    public function confirmDelete($file_id, $file_name)
    {
        $this->dispatchBrowserEvent('Swal:DeleteRecordConfirmation', [
            'title' => "<span>".trans('applang.swal_confirm_delete_msg')."<span class='text-danger'>(".$file_name .")</span>"."</span>",
            'id'    => $file_id
        ]);
    }
    public function deleteFile($file_id)
    {
        $file = SalesInvoiceAttachments::find($file_id); //Single Delete

        $salesInvoice = $file->salesInvoice;
        $folder_date = $salesInvoice->created_at->format('m-Y');
        $filePath = 'uploads/sales_invoices_attachments/'. $folder_date.'/'.$salesInvoice->inv_number.'/'.$file->attachments;
        $invoiceNumberFolder = Storage::disk('public_uploads')->path('sales_invoices_attachments/'.$folder_date.'/'.$salesInvoice->inv_number);
        $dateFolder = Storage::disk('public_uploads')->path('sales_invoices_attachments/'.$folder_date);

        File::delete(public_path($filePath));

        $FileSystem = new Filesystem();
        //Check if the invoiceNumberFolder exists.
        if ($FileSystem->exists($invoiceNumberFolder)) {
            // Get all files in this invoiceNumberFolder.
            $files = $FileSystem->files($invoiceNumberFolder);
            // Check if invoiceNumberFolder is empty.
            if (empty($files)) {
                // Yes, delete the invoiceNumberFolder.
                $FileSystem->deleteDirectory($invoiceNumberFolder);
            }
        }

        //Check if the dateFolder exists.
        if ($FileSystem->exists($dateFolder )) {
            // Get all folders in this dateFolder.
            $folders = $FileSystem->directories($dateFolder);
            // Check if dateFolder is empty.
            if (empty($folders)) {
                // Yes, delete the dateFolder.
                $FileSystem->deleteDirectory($dateFolder);
            }
        }
        $file->delete();
        $this->dispatchBrowserEvent('refresh-page');
    }

    public function confirmDeleteInvoice($invoice_id, $invoice_number)
    {
        $this->dispatchBrowserEvent('Swal:DeleteInvoiceConfirmation', [
            'title' => "<span>".trans('applang.swal_confirm_delete_msg')."<span class='text-danger'>(".$invoice_number .")</span>"."</span>",
            'id'    => $invoice_id
        ]);
    }
    public function deletesSalesInvoice($salesInvoice_id)
    {
        $salesInvoice = SalesInvoice::find($salesInvoice_id); //Single Delete
        if($salesInvoice->receiving_status == '1'){
            $salesInvoice->delete();
            return redirect()->route('sales-invoices.index');
        }else{
            $this->dispatchBrowserEvent('MsgError', ['title' => trans('applang.sales_invoice_received')]);
        }
    }

    public function confirmDeletePayment($payment_id, $invoice_number)
    {
        $this->dispatchBrowserEvent('Swal:DeletePaymentConfirmation', [
            'title' => "<span>".trans('applang.swal_confirm_delete_payment_msg')."<span class='text-danger'>(".$payment_id .")</span>".trans('applang.for_invoice_number')."<span class='text-danger'>(".$invoice_number .")</span>"."</span>",
            'id'    => $payment_id
        ]);
    }
    public function deletePayment($payment_id)
    {
        $payment = SalesInvoicePayment::find($payment_id); //Single Delete
        $payment->delete();

        $paid_to_supplier_inv = (int)preg_replace("/[^0-9]/", "", $this->salesInvoice->paid_to_supplier_inv);
        $this->down_payment = (int)preg_replace("/[^0-9]/", "", $this->salesInvoice->down_payment_inv);
        if($this->salesInvoice->paid_to_supplier_inv == null){
            $this->completedPayments = SalesInvoicePayment::where(['sales_invoice_id'=> $this->salesInvoice->id, 'payment_status' => 'completed'])->pluck('payment_amount')->toArray();
            $this->allPayments = $this->down_payment+(int)array_sum($this->completedPayments);
            $this->invoiceValue = (int)$this->salesInvoice->total_inv;
            $this->due_after_payments = ($this->invoiceValue-$this->allPayments);
            $this->salesInvoice->update([
                'payments_total' => (int)array_sum($this->completedPayments),
                'due_amount_after_payments' => $this->due_after_payments
            ]);
        }else{
            $this->allPayments = $paid_to_supplier_inv;
            $this->invoiceValue = (int)$this->salesInvoice->total_inv;
            $this->due_after_payments = ($this->invoiceValue-$this->allPayments);
        }

        if($this->salesInvoice->due_amount_after_payments == $this->salesInvoice->total_inv){
            $this->salesInvoice->update([
                'payment_status' => 1,
            ]);
        }elseif($this->salesInvoice->due_amount_after_payments > 0.00 && $this->salesInvoice->due_amount_after_payments < $this->salesInvoice->total_inv){
            $this->salesInvoice->update([
                'payment_status' => 2,
            ]);
        }elseif($this->salesInvoice->due_amount_after_payments == 0.00){
            $this->salesInvoice->update([
                'payment_status' => 3,
            ]);
        }

        $this->dispatchBrowserEvent('refresh-page');
    }

    public function render()
    {
        return view('livewire.erp.sales.sales-invoices.show-sales-invoice');
    }
}
