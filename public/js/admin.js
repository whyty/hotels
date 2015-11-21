$(document).ready(function () {
	
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
});

