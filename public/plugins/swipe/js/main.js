window.currentPage = 1;
hasNext=true;
requesting=false;
slideTemplate = $('<li><div class="img"></div></li>');
window.sliderOption = {
	// dislike callback
    onDislike: function (item) {
    	count = $("#tinderslide li").length - 1;
        if(count < 2 && hasNext && !requesting){
        	getItems(currentPage);
        }
        showProduct();
    },
    onLike: function (item) {
    	count = $("#tinderslide li").length - 1;
        if(count < 2 && hasNext && !requesting){
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
	description = ['Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarks grove right at the coast of the Semantics, a large language ocean. A small river named Duden flows by their place and supplies it with the necessary regelialia. It is a paradisematic country, in which roasted parts of sentences fly into your mouth. Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic life One day however a small line of blind text by the name of Lorem Ipsum decided to leave for the far World of Grammar.', 'One morning, when Gregor Samsa woke from troubled dreams, he found himself transformed in his bed into a horrible vermin. He lay on his armour-like back, and if he lifted his head a little he could see his brown belly, slightly domed and divided by arches into stiff sections. The bedding was hardly able to cover it and seemed ready to slide off any moment. His many legs, pitifully thin compared with the size of the rest of him, waved about helplessly as he looked. "What\'s happened to me?" he thought. ', 'But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual teachings of the great explorer of the truth, the master-builder of human happiness. No one rejects, dislikes, or avoids pleasure itself, because it is pleasure, but because those who do not know how to pursue pleasure rationally encounter consequences that are extremely painful.'];
	currency = '<sup>PHP</sup>';
	text = Math.floor((Math.random() * 3));
	$('.card .price').html(product.end_price+currency);
	$('.card .description').text(description[text]);
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