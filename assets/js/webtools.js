window.onload = function(){
    tinymce.init({
        height: 350,
        selector: "#descrip",
        plugins: "lists paste",
        toolbar: "bold italic underline numlist bullist",
        branding: false,
        menubar: false,
        paste_webkit_styles: 'all'

    });
}

$(document).ready(function(){
    $( ".datepicker" ).datepicker({ 
        dateFormat: 'dd MM yy',
        minDate: -365
    });
    $(".timepicker").timepicker({
            timeFormat: 'HH:mm'
        });

    $( ".datetimepicker" ).datepicker({ 
            dateFormat: 'yy-mm-dd 00:00:00',
            minDate: 0 
        });
    $( ".datetimepickerall" ).datepicker({ 
            dateFormat: 'yy-mm-dd 00:00:00'
        });

    $("#podcast-type").on("change", function() {
        if ($(this).val() === "1") {
            $("#youtube-picker").show();
            $("#youtube-picker2").show();
            $("#audio-picker").hide();
            $("#audio-picker2").hide();
            $("#youtube-pick").attr('required', '');
            $("#audio-pick").removeAttr('required');
        }
        else {
            $("#youtube-picker").hide();
            $("#audio-picker").show();
            $("#youtube-picker2").hide();
            $("#audio-picker2").show();
            $("#audio-pick").attr('required', '');
            $("#youtube-pick").removeAttr('required');
        }
    });

    $("#select-year").on("change", function() {
        var year = $(this).val();
        window.location.replace(baseurl+"news/index/y/"+year);
    });

    $("#select-year-reporter").on("change", function() {
        var year = $(this).val();
        window.location.replace(baseurl+"newsreporter/index/y/"+year);
    });

    $(".top-order").on("change", function() {
        var idx = $(this).data('id');
        var order = $(this).val();

        $.ajax({
            type : 'get',
            url  : baseurl+'expert/change_order/'+idx+'/'+order,
            dataType : 'json',
            success : function(d) {
                console.log(d);
                if(d.code == 200) {
                    location.reload();
                } else {
                    alert('Failed to change order');
                }	
            },
            error : function(e) {
                console.log(e);
                swal("Error!", "Unknown error occured, try again later !", "error");
            }
        });

        if ($(this).val() === "1") {
            $("#youtube-picker").show();
            $("#youtube-picker2").show();
            $("#audio-picker").hide();
            $("#audio-picker2").hide();
            $("#youtube-pick").attr('required', '');
            $("#audio-pick").removeAttr('required');
        }
        else {
            $("#youtube-picker").hide();
            $("#audio-picker").show();
            $("#youtube-picker2").hide();
            $("#audio-picker2").show();
            $("#audio-pick").attr('required', '');
            $("#youtube-pick").removeAttr('required');
        }
    });

    $('#add-word').click(function(){
        var obj = $('#elm .list-word').clone();
        obj.appendTo('#list-word');

        $('.datepick').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            locale: {
                format: 'DD/MM/YYYY'
                }
        });
    });

    $('#list-word').on('click','.list-word button',function(){
        $(this).closest('.list-word').remove();
    });
});