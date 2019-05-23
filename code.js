function main(anno){
	var metallo, vetro, indifferenziato, umido, plastica, carta, raee;
		
	$.post( "chart.php", JSON.stringify({ "anno": anno }))
	.done(function(result){
		console.log(result);
		result = $.parseJSON(result);
		metallo = result.metallo;
		vetro = result.vetro;
		indifferenziato = result.indifferenziato;
		umido = result.umido;
		plastica = result.plastica;
		carta = result.carta;
		raee = result.raee;

		window.chartColors = {
			red: 'rgb(255, 99, 132)',
			orange: 'rgb(255, 159, 64)',
			yellow: 'rgb(255, 205, 86)',
			green: 'rgb(75, 192, 192)',
			blue: 'rgb(54, 162, 235)',
			purple: 'rgb(153, 102, 255)',
			grey: 'rgb(201, 203, 207)'
		};
		var barChartData = {
			labels: ['January', 'February', 'March', 'April',
					'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
			datasets: [{
                label: 'metallo',
                backgroundColor: window.chartColors.red,
                data: metallo
			}, {
                label: 'vetro',
                backgroundColor: window.chartColors.blue,
                data: vetro
			}, {
                label: 'indifferenziato',
                backgroundColor: window.chartColors.green,
                data: indifferenziato
			}, {
                label: 'umido',
                backgroundColor: window.chartColors.orange,
                data: umido
			}, {
                label: 'plastica',
                backgroundColor: window.chartColors.yellow,
                data: plastica
			}, {
                label: 'carta',
                backgroundColor: window.chartColors.purple,
                data: carta
			}, {
                label: 'raee',
                backgroundColor: window.chartColors.grey,
                data: raee
			}]

		};

		var ctx = document.getElementById('canvas').getContext('2d');
		window.myBar = new Chart(ctx, {
			type: 'bar',
			data: barChartData,
			options: {
                title: {
	                display: true,
	                text: 'Operazioni effettuate '
                },
                tooltips: {
	                mode: 'index',
	                intersect: false
                },
                responsive: true,
                scales: {
	                xAxes: [{
		                stacked: true,
	                }],
	                yAxes: [{
		                stacked: true,
		                ticks:{suggestedMax : 20}
	                }]
                }
			}
		});
	});
}
var anno = 2019;
main(anno);

$.get( "getyears.php", function(result){
	console.log(result);
	result = $.parseJSON(result);
	var select = document.getElementById("datepicker");
	select.innerHTML="";
	for (var option in result) {
		var newOption = document.createElement("option");
		newOption.value = result[option];
		newOption.innerHTML = result[option];
		select.options.add(newOption);
	}
});
function btn(){
	$('#canvas').remove(); // this is my <canvas> element
	$('#chart').append('<canvas id="canvas"></canvas>');
	

	var anno = $("#datepicker").val();
	console.log(anno);
	main(anno);
}