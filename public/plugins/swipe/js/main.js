window.currentPage = 1;
hasNext=true;
requesting=false;
slideTemplate = $('<li><div class="img"></div></li>');
window.sliderOption = {
	// dislike callback
    onDislike: function (item) {
    	count = $("#tinderslide li").length - 1;
        if(count < 5 && hasNext && !requesting){
        	getItems(currentPage);
        }
        showProduct();
    },
    onLike: function (item) {
    	count = $("#tinderslide li").length - 1;
        if(count < 5 && hasNext && !requesting){
        	getItems(currentPage);
        }
        showProduct();
    },
	animationRevertSpeed: 200,
	animationSpeed: 400,
	threshold: 1,
	likeSelector: '.like',
	dislikeSelector: '.dislike'
};


function swipeRefresh(option){
	
	option = option || sliderOption;

	if($("#tinderslide").data('plugin_jTinder')){
		$("#tinderslide").data('plugin_jTinder').destroy();
	}

	$("#tinderslide").jTinder(option);
}

function showProduct(){
	product = $("#tinderslide li:last").data();
	$('.card .price').text(product.end_price);
	//$('.card .description').text();
	$('.card .title').text(product.name);
}

/**
 * Set button action to trigger jTinder like & dislike.
 */
$('.actions .like, .actions .dislike').click(function(e){
	e.preventDefault();
	swipeRefresh($(this).attr('class'));
});

function getItems(page){
		
	page = page || currentPage;
	requesting = true;

	$.get('/items/'+page, function(data,response){

		console.log(data, response)
		if(response == 'success'){

			if(!response.length) {
				hasNext = false;
			}

			$.each(data, function(i,d){
				template = slideTemplate.clone();
				template.find('.img').css({'background-image':'url('+d.image1+')'});
				template.data(d);
				$("#tinderslide ul").prepend(template);
			});

			currentPage++;
			swipeRefresh();
			showProduct();
			requesting = false;
		}

	});
}


getItems(1);