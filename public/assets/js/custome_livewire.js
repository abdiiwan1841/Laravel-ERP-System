//hide modal after save
window.addEventListener("closeModal", event => {
    $('.closeModal').modal('hide');
});

$(document).ready(function() {
    //this event is triggered when the modal is hidden
    $('.closeModal').on('hidden.bs.modal', function () {
        livewire.emit('forcedCloseModal');
    })
});

//Success Message sweet alert
window.addEventListener("MsgSuccess", event => {
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
        title: "<h5 style='color:white'>" + event.detail.title + "</h5>",
        background:'#51A351',
        iconColor: '#FFF',
    })
});

//Delete Confirmation sweet alert
window.addEventListener('Swal:DeleteRecordConfirmation', event => {
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
            window.livewire.emit('recordDeleted', event.detail.id)
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

// toastr liberary
window.addEventListener('toastr:info', event => {
    toastr.info(event.detail.message);
});

window.addEventListener("MsgError", event => {
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
        title: "<h5 style='color:white'>" + event.detail.title + "</h5>",
        background:'#e82b2b',
        iconColor: '#FFF',
    })
});

//refresh page
window.addEventListener('refresh-page', event => {
    window.location.reload(false);
})



