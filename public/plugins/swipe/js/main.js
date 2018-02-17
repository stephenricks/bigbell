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
	description = 'Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean. A small river named Duden flows by their place and supplies it with the necessary regelialia. It is a paradisematic country, in which roasted parts of sentences fly into your mouth. Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic life One day however a small line of blind text by the name of Lorem Ipsum decided to leave for the far World of Grammar.';
	currency = '<sup>PHP</sup>';
	$('.card .price').html(product.end_price+currency);
	$('.card .description').text(description);
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