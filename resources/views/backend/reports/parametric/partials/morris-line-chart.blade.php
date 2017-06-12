<div id="morris-line-chart-input-{{$input->id}}"></div>
<script type="text/javascript">
	// var data = [];
	// $.each($({{{$input->events}}}), function (n, elem) {
	// 	data.push(elem.input_event_value);
	// });
	Morris.Line({
		element: 'morris-line-chart-input-{{{$input->id}}}',
		data: $({{{$input->events}}}),
		ykeys: 'input_event_value'
	});

</script>
