window.sliderOption = {
	// dislike callback
    onDislike: function (item) {
	    // set the status text
        $('#status').html('Dislike image ' + (item.index()+1));
    },
	// like callback
    onLike: function (item) {
	    // set the status text
        $('#status').html('Like image ' + (item.index()+1));
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

/**
 * Set button action to trigger jTinder like & dislike.
 */
$('.actions .like, .actions .dislike').click(function(e){
	e.preventDefault();
	swipeRefresh($(this).attr('class'));
});

swipeRefresh();

$.get('sample-data.json', function(data,response){

	if(response == 'success'){

		$.each(data, function(i,d){
			template = $("#tinderslide li:last").clone();
			template.find('.img').css({'background-image':'url('+d.image1+')'});
			$("#tinderslide ul").append(template);
		});

		swipeRefresh();
	}

});