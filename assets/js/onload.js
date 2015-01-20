$(document).ready(function() {

    if ($("#enviarFoto").length) {
    	$("#enviarFotoLink").click(
    		function(event) 
    		{
    			event.preventDefault();

    			$("#enviarFoto").click();
    		}
		);

		$("#enviarFoto").on('change', function() {
			var value = $(this).val();
			if (value != "") {
				$(this).parent("form").submit();
			}
		});
	}

	// jCrop responsável por selecionar área de corte em uma nova foto
	if ($("#cropbox").length) {

		var imgHeight = $("#cropbox").height();
		var imgWidth = $("#cropbox").width();

        var leftPos = (imgWidth - imgHeight) / 2;

		var size = 500;
		if (imgHeight < 500) {
            var size = imgHeight;
		}

		var options = {
			aspectRatio: 1,
		 	minSize: [size, size],
		 	maxSize: [size, size],
		 	bgOpacity: .2,
		 	setSelect: [size, size, leftPos, 0],
		 	allowSelect: false,
		 	onSelect: updateCoords
		}

		console.log(options);

		var jcrop_api;
		$('#cropbox').Jcrop(options, function() {
		  jcrop_api = this;
		});

		jcrop_api.animateTo([size, size, leftPos, 0]);

	    var scale = jcrop_api.tellScaled();
	    updateCoords(scale);
	}

	// Funções ao clicar no botão de "abrirMenu"
	if ($("#menu").length) {

		$("#abrirMenu").click(
			function(event) 
			{
				event.preventDefault();

				if ($("#menu").css('right') == "-280px") {
					openMenu();
				} else {
					closeMenu();
				}
			}
		);

	}

});

function openMenu()
{
	$("#menu").animate({
		right: "0px"
	}, 500);

	$("body").animate({
		right: "280px"
	}, 500);
}

function closeMenu()
{
	$("#menu").animate({
		right: "-280px"
	}, 500);

	$("body").animate({
		right: "0px"
	}, 500);
}

function updateCoords(c) 
{ 
	$('#x').val(c.x); 
	$('#y').val(c.y); 
	$('#w').val(c.w); 
	$('#h').val(c.h); 
} 

function checkCoords() { 
	if (parseInt($('#w').val())) return true;
	alert('Selecione a área para recorte.'); 
	return false; 
}