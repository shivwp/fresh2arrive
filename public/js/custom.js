$('document').ready(function(){
    
    $(document).on("change",".is_driver", function(){

        if(this.checked == true) {
            $('.driverInfoSection').removeClass("hide");
            $('.driverInfoSection .is_required').attr('required',"required");
        } 
        else {
            $('.driverInfoSection').addClass("hide");
            $('.driverInfoSection .is_required').removeAttr('required');
        }

    });

    if($('.is_driver').is(":checked") == true) {
        $('.driverInfoSection').removeClass("hide");
    }
    else {
        $('.driverInfoSection').addClass("hide");
    }

    $(document).on('change','.is_vendor', function(){

        if(this.checked == true) {
            $('.vendorInfoSection').removeClass("hide");
            $('.vendorInfoSection .is_required').attr('required',"required");
        } 
        else {
            $('.vendorInfoSection').addClass("hide");
            $('.vendorInfoSection .is_required').removeAttr('required');
        }

    });

    if($('.is_vendor').is(":checked") == true) {
        $('.driverInfoSection').removeClass("hide");
    }
    else {
        $('.driverInfoSection').addClass("hide");
    }
    
});