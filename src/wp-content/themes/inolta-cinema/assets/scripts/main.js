$(function() {
	$('#filter').submit(function(){
		var filter = $('#filter');
		$.ajax({ 
			url:filter.attr('action'),
			data:filter.serialize(),
			type:filter.attr('method'),
			beforeSend:function(xhr){
				filter.find('button').text('Поиск...');
			},
			success:function(data){
				filter.find('button').text('Поиск фильмов');
				$('#response-data').html(data); 
			}
		});
		return false;
	});
});