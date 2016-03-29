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
    dataEdit: function(e, selector){
       var data = jQuery.parseJSON($(e.currentTarget).attr('data-edit'));
       if(data){
           $(e.currentTarget).parents(".list-group").find(".list-group-item").show();
           $(e.currentTarget).closest(".list-group-item").hide();
           for(var key in data){
               $(selector + " [name='" + key + "']").val(data[key]);
           }
             $(selector).closest(".form-group").find(".add_data").removeClass('hide');
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
    $(".multiselect").change(function(){
       var children = $(this).children(), values = $(this).val();
       if(!values) $(this).children().removeAttr('selected');
       children.each(function(){
           var val = $(this).attr('value');
           if(values && values.indexOf(val) != -1){
               $(this).attr('selected','selected');
           }else{
               $(this).removeAttr('selected');
           }
       });
    });
    
    $('button.export').click(function(e){
        var ids = [];
        $('[name="vacationSelected[]"]').each(function() {
            if($(this).is(':checked')) ids.push($(this).val());            
        });
        if(ids.length){
            $.ajax({
                url: '/admin/exportData',
                method: "post",
                data: {data: ids}
            });
            $(".alert-group").removeClass("hide");
            $('[name="vacationSelected[]"]').removeAttr('checked');
        }
    });
    $("#vacationCountry").change(function(){
        var country = $(this).val();
        $.ajax({
            url: "/admin/searchCountry",
            method: 'POST',
            data:{ country: country},
            success: function(result){
                $("#vacationHotels").multiselect('destroy');
                $('#vacationHotels').find('option').remove();
                if(result.status == '1'){
                    for(var i = 0; i < result.hotels.length; i++){
                        $("#vacationHotels").append('<option value="'+result.hotels[i]['id']+'">'+result.hotels[i]['name']+'</option>');
                    }
                }else{
                    $("#vacationHotels").append('<option value="">No hotels</option>');
                }
                $("#vacationHotels").multiselect();
            }
        });
    });
    $(".pagination a").trigger('click');
    
});
    $('.pagination').on('click', 'a', function(e) {
	var page = this.id;
	var pagination = '';
	
	$('.collection').html('<i class="fa fa-spinner fa-pulse"></i>');
	var data = {page: page, perPage: 10, model: $(this).attr('data-model')};
	
	$.ajax({
		type: 'POST',
		url: '/admin/paginate',
		data: data,
		dataType: 'json',
		success: function(data) {
			$('.collection').html(data.itemsList);
			
			if (page == 1) pagination += '<li class="disabled"><span>First</span></li><li class="disabled"><span>Previous</span></li>';
			else pagination += '<li><a href="javascript:void(0)" id="1" data-model="'+data.model+'">First</a></li><li><a href="javascript:void(0)" id="' + (page - 1) + '" data-model="'+data.model+'">Previous</span></a></li>';
 
			for (var i=parseInt(page)-3; i<=parseInt(page)+3; i++) {
				if (i >= 1 && i <= data.numPage) {
					pagination += '<li';
					if (i == page) pagination += ' class="active"><span>' + i + '</span>';
					else pagination += '><a href="javascript:void(0)" id="' + i + '" data-model="'+data.model+'">' + i + '</a>';
					pagination += '<li>';
				}
			}
 
			if (page == data.numPage) pagination += '<li class="disabled"><span>Next</span></li><li class="disabled"><span>Last</span></li>';
			else pagination += '<li><a href="javascript:void(0)" id="' + (parseInt(page) + 1) + '" data-model="'+data.model+'">Next</a></li><li><a href="javascript:void(0)" id="' + data.numPage + '" data-model="'+data.model+'">Last</span></a></li>';
			
			$('.pagination').html(pagination);
		},
		error: function() {
		}
	});
	return false;
    });
$(document).mouseup(function (e)
{
    var container = $(".export-alert");

    if (!container.is(e.target) 
        && container.has(e.target).length === 0)
    {
        container.addClass("hide");
    }
});
