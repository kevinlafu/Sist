function handle_calendar()
{
	$('.day a.add-event').click(function(){
		
		$('#add-event input[name=month]').val($(this).attr('data-month'))
		$('#add-event input[name=day]').val($(this).attr('data-day'))
		$('#add-event').modal('show');

		return false;
	});
}

$(document).ready(handle_calendar);