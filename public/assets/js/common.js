$(document).on('input', '.max_val_check',function(e){
	var val = Number($(this).val());
    var max = Number($(this).attr('max'));
	if (val > max) {
		$(this).val(max);
        $(this).change();
    }
});
$(document).on('input', '.min_val_check',function(e){
    var val = Number($(this).val());
    var min = Number($(this).attr('min'));
    if (val < min) {
        $(this).val(min);
        // $(this).change();
    }
});


$(document).on("wheel", ".max_val_check", function (e) {
    $(this).blur();
});
$(document).on("wheel", "input[type='number']", function (e) {
    $(this).blur();
});


$(document).on('submit', '.prev_duplicat_frm', function (e) {
    // $(this).find('.prev_duplicat').attr('disabled',true);
})

$(document).on('keyup', '.remove_first_zero', function(e) {
    if((this.value+'').match(/^0/)) {
        this.value = (this.value+'').replace(/^0+/g, '');
    }
});
$(document).on('input', '.number-only', function (e) {
    this.value = this.value.replace(/[^0-9\.]/g,'');

})


