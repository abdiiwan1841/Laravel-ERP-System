@extends('layouts.admin.admin_layout')
@section('title', trans('applang.edit_purchase_invoice'))

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
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="content-body">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <form action="{{route('purchase-invoices.update', $purchaseInvoice->id)}}" method="POST" enctype="multipart/form-data" autocomplete="off">
                        @csrf
                        @method('PATCH')
                        @livewire('erp.purchases.edit-purchase-invoice', ['purchaseInvoice' => $purchaseInvoice])
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- purchase invoices Modals -->
{{--    @include('erp.purchases.purchase_invoices.modals')--}}

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
@endsection
