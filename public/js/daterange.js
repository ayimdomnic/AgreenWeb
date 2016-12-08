	$(document).ready(function() {
		var currentDateFirst = moment().startOf('day').format("YYYY/MM/DD H:m:s");
		var currentDateLast = moment().endOf('day').format("YYYY/MM/DD H:m:s");
		var currentMonthFirst = moment().startOf('month').format("YYYY/MM/DD H:m:s");
		var currentMonthLast = moment().endOf('month').format("YYYY/MM/DD H:m:s");
		var lastWeekFirst = moment().subtract(1, 'weeks').startOf('isoWeek')
		var lastWeekLast = moment().format("YYYY/MM/DD H:m:s");
		var lastMonthFirst = moment().subtract(1, 'month').startOf('month')
		var lastMonthEnd = moment().subtract(1, 'month').endOf('month')
		var last30Days = moment().subtract(30, 'days');
		var last7Days = moment().subtract(7, 'days');
		var yesterdayFirst = moment().subtract(1, 'day').startOf('day');
		var yesterdayLast = moment().subtract(1, 'day').endOf('day');
		$('#demo').daterangepicker({
			"timePicker": true,
			"timePicker24Hour": true,
			"ranges": {
				"Aujourd'hui": [
				currentDateFirst,
				currentDateLast
				],
				"Hier": [
				yesterdayFirst,
				yesterdayLast
				],
				"7 derniers jours": [
				last7Days,
				currentDateLast
				],
				"30 derniers jours": [
				last30Days,
				currentDateLast
				],
				"Ce mois-ci": [
				currentMonthFirst,
				currentMonthLast
				],
				"Le mois dernier": [
				lastMonthFirst,
				lastMonthEnd
				]
			},
			"locale": {
				"format": "YYYY/MM/DD H:m:s",
				"separator": " - ",
				"applyLabel": "Apply",
				"cancelLabel": "Cancel",
				"fromLabel": "From",
				"toLabel": "To",
				"customRangeLabel": "Custom",
				"weekLabel": "W",
				"daysOfWeek": [
				"Su",
				"Mo",
				"Tu",
				"We",
				"Th",
				"Fr",
				"Sa"
				],
				"monthNames": [
				"Janvier",
				"Fevrier",
				"Mars",
				"Avril",
				"Mai",
				"Juin",
				"Juillet",
				"Aout",
				"Septembre",
				"Octobre",
				"Novembre",
				"Decembre"
				],
				"firstDay": 1
			},
		}, function(start, end, label) {
			document.getElementById('dateStart').value = start.format('YYYY-MM-DD H:m:s');
			document.getElementById('dateEnd').value = end.format('YYYY-MM-DD H:m:s');
			console.log("New date range selected: ' + start.format('YYYY-MM-DD H:m:s') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')");
		});
	});