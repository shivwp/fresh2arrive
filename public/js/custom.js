$(document).ready(function(){
    
    $(document).on('click', 'input', function(){

        $(this).next('span.invalid-feedback.form-invalid').css('display','none');
        // console.log($(this).next('span.invalid-feedback.form-invalid'));

        // $(this).closest('span.invalid-feedback.form-invalid').css('display','none');
        // console.log($(this).closest('span.invalid-feedback.form-invalid'));
    });

    $(document).on('click', 'select', function(){

        $(this).next('span.invalid-feedback.form-invalid').css('display','none');
        // console.log($(this).next('span.invalid-feedback.form-invalid'));

        // $(this).closest('span.invalid-feedback.form-invalid').css('display','none');
        // console.log($(this).closest('span.invalid-feedback.form-invalid'));
    });

    // setTimeout(function() {
    //     $('.invalid-feedback.form-invalid').addClass('d-none');
    // },5000);


    // script for jQuery form validation start
    $('#basic-form').validate();
    // script for jQuery form validation end

    // script for tooltip start
    $("[data-toggle=tooltip").tooltip();
    // script for tooltip end

    // script for filter based on role start
    $(document).on('change', '#role', function(){
        $(this).closest('form').submit();
    });
    // script for filter based on role end

    // script for filter based on category start
    $(document).on('change', '#category', function(){
        $(this).closest('form').submit();
    });
    // script for filter based on category end

    // script for filter based on status start
    $(document).on('change', '#status', function(){
        $(this).closest('form').submit();
    });
    // script for filter based on status end

    // script for total items per page start
    $(document).on('change', '#items', function(){
        $(this).closest('form').submit();
    });
    // script for total items per page end

    // script for change status using ajax start
    $(document).on('click', '.change-status', function(){

        $this= $(this);
        var route = $this.attr('route');

        $.ajax({
            method: 'GET',
            url: route,
            success: function(response){
                if(response.success == true ) {
                    if(response.status == true ) {
                        $this.html('Active');
                        $this.addClass('btn-success').removeClass('btn-danger');
                    }
                    else {
                        $this.html('In-Active');
                        $this.removeClass('btn-success').addClass('btn-danger');
                    }
                }
                else if(response.success == false) {
                    swal({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong, please try again!',
                    });
                }
            },
            error: function(response) { 
                swal({
                    icon: 'error',
                    title: 'Oops...',
                    text: response.responseJSON.message,
                });
            }
        });
    });
    // script for change status end

    // script for delete alert popup start
    $('.delete-record').on('click', function(event){
        var route = $(this).attr("route");
        // console.log(route);

        swal({
            title: "You want to delete?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            closeOnClickOutside: false,
        })
        .then((willDelete) => {
            // console.log("route",route);
            if (willDelete) {
                $.ajax({
                    headers: {'x-csrf-token': $('meta[name="csrf-token"]').attr('content')},
                    method: "DELETE",
                    url: route,
                    success: function (response) {
                        if(response.success == true) {
                            location.reload();
                        }
                        else if(response.success == false) {
                            swal({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Something went wrong, please try again!',
                            });
                        }
                    },
                    error: function(response) { 
                        console.log(response);
                        swal({
                            icon: 'error',
                            title: 'Oops...',
                            text: response.responseJSON.message,
                        });

                    }
                })
            }
            return false;
        });
    });
    // script for delete alert popup end

});