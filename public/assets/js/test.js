$(document).ready(function () {
    //change colour when radio is selected
    $('#order_addresses input:radio').change(function () {
        // Only remove the class in the specific `box` that contains the radio
        $('div.click.click2').removeClass('click click2');
        $(this).closest('.form-check').addClass('click click2');
    });
});

$("#order_carriers_1").prop("checked", true);
$("#order_carriers .form-check").addClass('click_carrier click2_carrier');



