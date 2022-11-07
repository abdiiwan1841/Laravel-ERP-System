@extends('layouts.admin.admin_layout')
@section('title', trans('applang.show_purchase_invoice'))

@section('vendor-css')
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets')}}/vendors/css/extensions/toastr.css">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets')}}/vendors/css/extensions/sweetalert2.min.css">
@endsection

@section('page-css')
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets')}}/css/plugins/extensions/toastr.css">
    <link rel="stylesheet" href="{{asset('app-assets/datepicker/css/bootstrap-datepicker3.standalone.min.css')}}">
    <!--Start of bootstrap-fileinput -->
    <link href="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.5/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />
    @if(app()->getLocale() == 'ar')
        <!-- if using RTL (Right-To-Left) orientation, load the RTL CSS file after fileinput.css by uncommenting below -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.9/css/fileinput-rtl.min.css" media="all" rel="stylesheet" type="text/css">
    @endif
    <!--End of bootstrap-fileinput -->
    <style>
        .file-caption-main{
            display: none;
        }
        .file-preview{
            background-color: #feffef;
        }
        .file-preview-frame{
            background-color: #FFFFFF;
        }

        .ck-editor__editable{
            min-height: 100px;
        }

        .table th, .table td {
            padding: 10px 15px !important;
            font-family: 'Nunito', sans-serif !important;
        }
        ul.day-view-entry-list li:not(:last-child){
            border-bottom: none !important;
        }

        table.user-view tr th, table.user-view tr td {
            padding: 10px 20px !important;
        }
        #modal_buttons .btn-sm, .btn-group-sm > .btn {
            padding: 8px 8px !important;
            font-size: 0.8rem;
            line-height: 1.4;
            border-radius: 0.267rem;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="content-body">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    @livewire('erp.purchases.show-purchase-invoice', ['purchaseInvoice' => $purchaseInvoice])
                </div>
            </div>
        </div>
    </div>
    <!-- purchase invoices Modals -->
    @include('erp.purchases.purchase_invoices.modals')

@endsection
<!-- END: Content-->

@section('page-vendor-js')
    <script src="{{asset('app-assets')}}/vendors/js/extensions/toastr.min.js"></script>
    <script src="{{asset('app-assets')}}/vendors/js/extensions/sweetalert2.all.min.js"></script>
@endsection

@section('page-js')
    <script src="{{asset('app-assets')}}/js/scripts/modal/components-modal.js"></script>
    <script src="{{asset('app-assets')}}/js/scripts/extensions/toastr.js"></script>

    <script type="text/javascript">
        @if (count($errors) > 0)
        $('#formModal').modal('show');
        @endif

            @if(Session::has('success'))
            toastr.options =
            {
                "closeButton" : true,
                "progressBar" : true,
                "positionClass": "{{app()->getLocale() == 'ar' ? 'toast-top-left' : 'toast-top-right'}}",
            }
        toastr.success("{{ session('success') }}");
        @endif

            @if ($errors->any())
            @foreach($errors->all() as $error)
            toastr.options =
            {
                "closeButton" : true,
                "progressBar" : true,
                "positionClass": "{{app()->getLocale() == 'ar' ? 'toast-top-left' : 'toast-top-right'}}",
            }
        toastr.error("{{$error}}");
        @endforeach
        @endif
    </script>
    <!--DatePicker js-->
    <script src="https://unpkg.com/bootstrap-datepicker@1.9.0/dist/js/bootstrap-datepicker.min.js"></script>
    <script src="https://unpkg.com/bootstrap-datepicker@1.9.0/dist/locales/bootstrap-datepicker.ar.min.js" charset="UTF-8"></script>
    <script>
        $('.datepicker_ar').datepicker({
            format: "yyyy-mm-dd",
            maxViewMode: 3,
            todayBtn: "linked",
            clearBtn: true,
            orientation: "bottom auto",
            autoclose: true,
            todayHighlight: true,
            language: "ar",
        });

        $('.datepicker_en').datepicker({
            format: "yyyy-mm-dd",
            maxViewMode: 3,
            todayBtn: "linked",
            clearBtn: true,
            orientation: "bottom auto",
            autoclose: true,
            todayHighlight: true,
        });
    </script>

    <!--Start of bootstrap-fileinput -->
    <!-- the main fileinput plugin file -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.9/js/fileinput.min.js"></script>
    <!-- following theme script is needed to use the Font Awesome 5.x theme (`fas`) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.9/themes/fas/theme.min.js"></script>
    @if(app()->getLocale() === 'ar')
        <!-- optionally if you need translation for your language then include the locale file as mentioned below (replace LANG.js with your language locale) -->
        <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.5/js/locales/ar.js"></script>
    @endif
    <script>
        // with plugin options
        $("#attachedDocuments").fileinput({
            rtl: true,
            language: 'ar',
            theme: "fas",
            showUpload: false,
            previewFileType: 'any',
            // allowedFileTypes: ['image'],
            allowedFileExtensions: ["jpg", "gif", "png", "jpeg", "txt", "xls", "xlsx","doc", "pdf", "txt"],
            maxTotalFileCount: 5,
            maxFileSize: 1024,
            layoutTemplates: {
                actions:
                    '<div class="file-actions">'+
                    '<div class="file-footer-buttons">'+
                    '<button type="button" class="kv-file-remove btn btn-sm btn-kv btn-outline-secondary" title="Remove file">'+
                    '<i class="bx bx-trash"></i>'+
                    '</button>'+
                    '<button type="button" class="kv-file-zoom btn btn-sm btn-kv btn-outline-secondary mr-50 ml-50" title="View Details">'+
                    '<i class="bx bx-search"></i>'+
                    '</button>'+
                    '</div>'+
                    '</div>'
            },
        });
    </script>
    <!--End of bootstrap-fileinput -->

    <!--Ckeditor-->
    <script src="{{asset('app-assets/ckeditor/build/ckeditor.js')}}"></script>
    <script>
        ClassicEditor
            .create( document.querySelector( '#editor' ), {
                removePlugins: [ 'SourceEditing','TextPartLanguage',"WordCount","SourceEditing","MediaEmbed","LinkImage","Image","ImageCaption","ImageStyle","ImageToolbar","ImageUpload","GeneralHtmlSupport","CloudServices","CKFinderUploadAdapter"],
                heading: {
                    options: [
                        { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                        { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                        { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                        { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
                    ]
                },
                language: '{{app()->getLocale() == "ar"? "ar": "en"}}',
            } )
            .catch( error => {
                console.log( error );
            } );
        // console.log(ClassicEditor.builtinPlugins.map( plugin => plugin.pluginName ));
    </script>

    <script>
        jQuery(($) => {
            $('#paid_to_supplier_checkbox').on('click', function (){
                if($(this).is(':checked')){
                    $('.down-div').addClass('hidden');
                }else{
                    $('.down-div').removeClass('hidden');
                }
            })

            if($('#paid_to_supplier_checkbox').is(':checked')){
                $('.down-div').addClass('hidden');
            }else{
                $('.down-div').removeClass('hidden');
            }
        });
    </script>

    <!--Prevent negative input-->
    <script>
        function restrictMinus(e) {
            const inputKeyCode = e.keyCode ? e.keyCode : e.which;
            if (inputKeyCode != null) {
                if (inputKeyCode === 45) e.preventDefault();
            }
        }
    </script>

    <script>
        @if(Session::has('MsgError'))
        const Toast = Swal.mixin({
            toast: true,
            position: document.dir === 'rtl' ? "top-start" : "top-end",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        Toast.fire({
            icon: 'error',
            title: "<h5 style='color:white'>" + '{{ session('MsgError') }}' + "</h5>",
            background:'#e82b2b',
            iconColor: '#FFF',
        })
        @endif
    </script>

    <script>
/*        function printInv() {
            var restorePage = document.body.innerHTML;
            var originalContents = document.getElementById("InvoicePreview");
            var printContents = document.getElementById("printArea").innerHTML;

            // const printContents = document.getElementById('certificate').innerHTML;
            // const originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = restorePage;
        }*/


        $("#printInv").click(function(){

            var myIframe = document.getElementById("InvoicePreview").contentWindow;

            myIframe.focus();

            myIframe.print();

            return false;

        });
    </script>

    <script>
        window.addEventListener('Swal:DeleteInvoiceConfirmation', event => {
            Swal.fire({
                title: event.detail.title,
                text: event.detail.text,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: document.dir === 'rtl' ? "إلغاء" : "Cancel",
                confirmButtonText: document.dir === 'rtl' ? "نعم" : "Yes"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.livewire.emit('invoiceDeleted', event.detail.id)
                    Swal.fire(
                        document.dir === 'rtl' ? "تم الحذف" : "Deleted",
                        document.dir === 'rtl' ? "تم حذف السجل بنجاح" : "Record Deleted Successfully",
                        'success'
                    )
                }else if(result.dismiss === Swal.DismissReason.cancel || result.dismiss === Swal.DismissReason.backdrop){
                    window.livewire.emit('CancelDeleted', event.detail.id)
                    Swal.fire(
                        document.dir === 'rtl' ? "تم إلغاء عملية الحذف" : "Delete Canceled",
                        document.dir === 'rtl' ? "السجلات المحددة لا تزال بقاعدة البيانات" : "Selected records still in database",
                        'error'
                    )
                }
            })
        });

        window.addEventListener('Swal:DeletePaymentConfirmation', event => {
            Swal.fire({
                title: event.detail.title,
                text: event.detail.text,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: document.dir === 'rtl' ? "إلغاء" : "Cancel",
                confirmButtonText: document.dir === 'rtl' ? "نعم" : "Yes"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.livewire.emit('paymentDeleted', event.detail.id)
                    Swal.fire(
                        document.dir === 'rtl' ? "تم الحذف" : "Deleted",
                        document.dir === 'rtl' ? "تم حذف السجل بنجاح" : "Record Deleted Successfully",
                        'success'
                    )
                }else if(result.dismiss === Swal.DismissReason.cancel || result.dismiss === Swal.DismissReason.backdrop){
                    window.livewire.emit('CancelDeleted', event.detail.id)
                    Swal.fire(
                        document.dir === 'rtl' ? "تم إلغاء عملية الحذف" : "Delete Canceled",
                        document.dir === 'rtl' ? "السجلات المحددة لا تزال بقاعدة البيانات" : "Selected records still in database",
                        'error'
                    )
                }
            })
        });
    </script>

    <script>
        $(document).ready(function () {
            //showDownPaymentModal-ajax
            var showDownPaymentModal = $('#formModalShowDownPayment');
            showDownPaymentModal.on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget)
                var purchaseInvoice_id = button.data('purchase_invoice_id');
                $.get("{{\Illuminate\Support\Facades\URL::to('/'.app()->getLocale().'/erp/purchases/purchase-invoice-show-down-payment-ajax')}}/"+purchaseInvoice_id , function (data) {
                    console.log(data);
                    var down_pmt_status = $('#down_pmt_status');
                    var down_deposit_payment_method = $('#down_deposit_payment_method');
                    var down_payment_amount = $('#down_payment_amount');
                    var down_transaction_id = $('#down_transaction_id');
                    var down_payment_date = $('#down_payment_date');
                    var down_added_by = $('#down_added_by');

                    if(data.purchaseInvoice.deposit_payment_method === 'cash'){
                        down_deposit_payment_method.text('{{trans('applang.cash')}}');
                    }else if(data.purchaseInvoice.deposit_payment_method === 'cheque'){
                        down_deposit_payment_method.text('{{trans('applang.cheque')}}');
                    }else if(data.purchaseInvoice.deposit_payment_method === 'bank_transfer'){
                        down_deposit_payment_method.text('{{trans('applang.bank_transfer')}}');
                    }

                    down_payment_amount.text(data.down_payment_amount+' {{$currency_symbol}}');
                    down_transaction_id.text(data.purchaseInvoice.deposit_transaction_id);
                    down_pmt_status.text('{{trans("applang.down_payment")}}');
                    down_payment_date.text(data.purchaseInvoice.issue_date);
                    down_added_by.text(data.user);


                });
            });

            //showPaymentModal-ajax
            var showPaymentModal = $('#formModalShowPayment');
            showPaymentModal.on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget)
                var payment_id = button.data('payment_id');
                var pmt_status = $('#payment_status');
                var deposit_payment_method = $('#deposit_payment_method');
                var pmt_amount = $('#payment_amount');
                var action_id = $('#transaction_id');
                var status = $('#pmt_status');
                var payment_date = $('#payment_date');
                var added_by = $('#added_by');

                $.get("{{\Illuminate\Support\Facades\URL::to('/'.app()->getLocale().'/erp/purchases/purchase-invoice-show-payment-transaction-ajax')}}/"+payment_id , function (data) {
                    // console.log(data);
                    $('#payment_id').text(data.payment.id);
                    if(data.payment.payment_status === 'completed'){
                        pmt_status.text('{{trans('applang.completed')}}');
                        pmt_status.addClass('badge-success-custom');
                    }else if(data.payment.payment_status === 'uncompleted'){
                        pmt_status.text('{{trans('applang.uncompleted')}}');
                        pmt_status.addClass('badge-danger');
                    }else if(data.payment.payment_status === 'under_revision'){
                        pmt_status.text('{{trans('applang.under_revision')}}');
                        pmt_status.addClass('badge-warning');
                    }else if(data.payment.payment_status === 'failed'){
                        pmt_status.text('{{trans('applang.failed')}}');
                        pmt_status.addClass('badge-danger');
                    }

                    if(data.payment.deposit_payment_method === 'cash'){
                        deposit_payment_method.text('{{trans('applang.cash')}}');
                    }else if(data.payment.deposit_payment_method === 'cheque'){
                        deposit_payment_method.text('{{trans('applang.cheque')}}');
                    }else if(data.payment.deposit_payment_method === 'bank_transfer'){
                        deposit_payment_method.text('{{trans('applang.bank_transfer')}}');
                    }

                    pmt_amount.text(data.payment.payment_amount+' {{$currency_symbol}}');
                    action_id.text(data.payment.transaction_id);
                    if(data.payment.payment_status === 'completed'){
                        status.text('{{trans('applang.completed')}}');
                    }else if(data.payment.payment_status === 'uncompleted'){
                        status.text('{{trans('applang.uncompleted')}}');
                    }else if(data.payment.payment_status === 'under_revision'){
                        status.text('{{trans('applang.under_revision')}}');
                    }else if(data.payment.payment_status === 'failed'){
                        status.text('{{trans('applang.failed')}}');
                    }

                    payment_date.text(data.payment.payment_date);
                    payment_date.text(data.payment.payment_date);
                    added_by.text(data.user);

                    if(data.payment.payment_status !== 'completed'){
                        $('#modal_buttons .confirm-completed').css('display', 'block')
                    }

                });

            });

            //resetPaymentModal-ajax
            showPaymentModal.on('hidden.bs.modal', function (event) {
                var pmt_status = $('#payment_status')
                pmt_status.removeClass('badge-success-custom');
                pmt_status.removeClass('badge-danger');
                pmt_status.removeClass('badge-warning');
                pmt_status.removeClass('badge-danger');
                $('#modal_buttons .confirm-completed').attr( "style", "display: none !important;" )
            });

            //editPaymentModal-ajax
            $('.edit-payment').on('click', function (e) {
                e.preventDefault()
                var pmt_id =$('#payment_id').text();
                showPaymentModal.modal("toggle");
                $.get("{{\Illuminate\Support\Facades\URL::to('/'.app()->getLocale().'/erp/purchases/purchase-invoice-edit-payment-transaction-ajax')}}/"+pmt_id , function (data) {
                    console.log(data)
                    $('#payment_id-edit').text(data.paymentEdit.id);
                    $('form #deposit_payment_method').val(data.paymentEdit.deposit_payment_method)
                    $('form #payment_amount').val(data.paymentEdit.payment_amount)
                    $('form #payment_date').val(data.paymentEdit.payment_date)
                    $('form #payment_status').val(data.paymentEdit.payment_status)
                    $('form #collected_by_id').val(data.paymentEdit.collected_by_id)
                    $('form #transaction_id').val(data.paymentEdit.transaction_id)
                    $('form #receipt_notes').text(data.paymentEdit.receipt_notes)
                    $('form #payment_id_input').val(data.paymentEdit.id)
                });
            });

            //printPaymentReceipt-ajax
            $('.print-receipt-ajax').on('click', function (e) {
                e.preventDefault()
                var pmt_id =$('#payment_id').text();
                $.get("{{\Illuminate\Support\Facades\URL::to('/'.app()->getLocale().'/erp/purchases/purchase-payment-receipt-print-ajax')}}/"+pmt_id , function (data) {
                    // console.log(data)
                    if(data.redirect_url){
                        // window.location = data.redirect_url;
                        window.open(data.redirect_url, '_blank');
                    }
                });
            });

            //completePaymentTransaction
            $('#check').on('click', function (e) {
                e.preventDefault();
                var pmt_id =$('#payment_id').text();
                $.get("{{\Illuminate\Support\Facades\URL::to('/'.app()->getLocale().'/erp/purchases/purchase-invoice-complete-payment-transaction')}}/"+pmt_id , function (data) {
                    console.log(data)
                    const Toast = Swal.mixin({
                        toast: true,
                        position: document.dir === 'rtl' ? "top-start" : "top-end",
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    })

                    Toast.fire({
                        icon: 'success',
                        title: "<h5 style='color:white'>" + '{{ trans('applang.confirm_completed_success') }}' + "</h5>",
                        background:'#42ba96',
                        iconColor: '#FFF',
                    })
                    setTimeout(function () {
                        location.reload();
                    }, 3000);
                });
            })
        })
    </script>

    <script>
        $(document).ready(function () {
            //editPaymentModal-ajax-direct
            $('#formModalEditPaymentDirect').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget)
                var payment_id = button.data('payment_id')
                var modal = $(this)
                $('#payment_id_edit_direct').text(payment_id);
                $.get("{{\Illuminate\Support\Facades\URL::to('/'.app()->getLocale().'/erp/purchases/purchase-invoice-edit-payment-transaction-ajax')}}/"+payment_id , function (data) {
                    console.log(data)
                    $('#payment_id-edit').text(data.paymentEdit.id);
                    $('form #deposit_payment_method_direct').val(data.paymentEdit.deposit_payment_method)
                    $('form #payment_amount_direct').val(data.paymentEdit.payment_amount)
                    $('form #payment_date_direct').val(data.paymentEdit.payment_date)
                    $('form #payment_status_direct').val(data.paymentEdit.payment_status)
                    $('form #collected_by_id_direct').val(data.paymentEdit.collected_by_id)
                    $('form #transaction_id_direct').val(data.paymentEdit.transaction_id)
                    $('form #receipt_notes_direct').text(data.paymentEdit.receipt_notes)
                    $('form #payment_id_input_direct').val(data.paymentEdit.id)
                });
            });
        });
    </script>

@endsection
