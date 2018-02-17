window.currentPage = 1;
hasNext=true;
window.sliderOption = {
	// dislike callback
    onDislike: function (item) {
    	count = $("#tinderslide li").length;
        if(count < 3 && hasNext){
        	getItems(currentPage);
        }
        showProduct();
    },
    onLike: function (item) {
    	count = $("#tinderslide li").length;
        if(count < 3 && hasNext){
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

	$("#tinderslide").jTinder(option);
}

function showProduct(){
	product = $("#tinderslide li:last").data();
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

function getItems(page){
		
	page = page || currentPage;

	$.get('/items/'+page, function(data,response){

		if(response == 'success'){

			if(response.length < 1) {
				hasNext = false;
			}

			$.each(data, function(i,d){
				template = $("#tinderslide li:last").clone();
				template.find('.img').css({'background-image':'url('+d.image1+')'});
				template.data(d);
				$("#tinderslide ul").prepend(template);
			});

			currentPage++;
			swipeRefresh();
			showProduct();
		}

	});
}


getItems(1);