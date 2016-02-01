var Travel = {
    confirmDelete: function (e) {
        e.preventDefault();
        var url = $(e.currentTarget).attr('href');
        if (confirm("This item will be deleted. Do you want to do this?") == true) {
            window.location.href = url;
        }
        return false;
    },
    adminSave: function (e) {
        e.preventDefault();
        if (confirm("Do you want to save this?") == true) {
            $('[role="form"]').submit();
        }
        return false;
    },
    intervalEdit: function(e){
       var data = jQuery.parseJSON($(e.currentTarget).attr('data-edit'));
       if(data){
           $(e.currentTarget).closest(".list-group-item").hide();
           for(var key in data){
               $("#intervalForm input[name='" + key + "']").val(data[key]);
           }
             $("#intervalForm").closest(".form-group").find(".add_interval").removeClass('hide');
       }
    }
}

$(document).ready(function () {
    $('[from-date]').click(function () {
        $('#from_date').data("DateTimePicker").toggle();
    });
    
    $('[to-date]').click(function () {
        $('#to_date').data("DateTimePicker").toggle();
    });
    $('#from_date').datetimepicker({format: 'YYYY-MM-DD'});
    $('#to_date').datetimepicker({
        format: 'YYYY-MM-DD',
        useCurrent: false //Important! See issue #1075
    });
    $("#from_date").on("dp.change", function (e) {
        $('#to_date').data("DateTimePicker").minDate(e.date);
    });
    $("#to_date").on("dp.change", function (e) {
        $('#from_date').data("DateTimePicker").maxDate(e.date);
    });
    $("#add_data").click(function(){
        $(".add_data").removeClass("hide");
    });
    $(".multiselect").multiselect();
});

