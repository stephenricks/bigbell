window.sliderOption = {
	// dislike callback
    onDislike: function (item) {
	    // set the status text
        //$('#status').html('Dislike image ' + (item.index()+1));
        $(item).remove();
        showProduct();
    },
	// like callback
    onLike: function (item) {
	    // set the status text
        //$('#status').html('Like image ' + (item.index()+1));
        $(item).remove();
        showProduct();
        console.log(item);
    },
	animationRevertSpeed: 200,
	animationSpeed: 400,
	threshold: 1,
	likeSelector: '.like',
	dislikeSelector: '.dislike'
};

function swipeRefresh(option){
	
	option = option || sliderOption;

	$("#tinderslide").jTinder(option);
}

function showProduct(){
	product = $("#tinderslide li:last").data();
	console.log(product);
	$('.card .price').text(product.end_price);
	//$('.card .supplier').text();
	$('.card .description').text(product.name);
}

/**
 * Set button action to trigger jTinder like & dislike.
 */
$('.actions .like, .actions .dislike').click(function(e){
	e.preventDefault();
	swipeRefresh($(this).attr('class'));
});

$.get('sample-data.json', function(data,response){

	if(response == 'success'){

		$.each(data, function(i,d){
			template = $("#tinderslide li:last").clone();
			template.find('.img').css({'background-image':'url('+d.image1+')'});
			template.data(d);
			$("#tinderslide ul").append(template);
		});

		swipeRefresh();
		showProduct();
	}

});
