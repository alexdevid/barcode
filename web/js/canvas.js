$(function() {


	var canvas = document.getElementById("canvas");
	var ctx = canvas.getContext("2d");

	var background = new Image();
	background.src = documentSrc;
	background.onload = function() {
		var barcode = new Image();
		barcode.onload = function() {
			var centerX = (background.width / resizeRatio) / 2 - (barcode.width / resizeRatio) / 2;
			var centerY = (background.height / resizeRatio) / 2 - (barcode.height / resizeRatio) / 2;
			
			ctx.drawImage(background, 0, 0, background.width / resizeRatio, background.height / resizeRatio);
			ctx.drawImage(barcode, centerX, centerY, barcode.width / resizeRatio, barcode.height / resizeRatio);
		};
		barcode.src = barcodeSrc;

		var canvasOffset = $("#canvas").offset();
		var offsetX = canvasOffset.left;
		var offsetY = canvasOffset.top;
		var canvasWidth = canvas.width;
		var canvasHeight = canvas.height;
		var isDragging = false;
		var canMouseX = 1;
		var canMouseY = 1;
		var coords = {x: 50, y: 50};

		function handleMouseDown(e) {
			canMouseX = parseInt(e.clientX - offsetX);
			canMouseY = parseInt(e.clientY - offsetY);
			// set the drag flag
			isDragging = true;
		}

		function handleMouseUp(e) {
			canMouseX = parseInt(e.clientX - offsetX);
			canMouseY = parseInt(e.clientY - offsetY);
			// clear the drag flag
			isDragging = false;
		}

		function handleMouseOut(e) {
			canMouseX = parseInt(e.clientX - offsetX);
			canMouseY = parseInt(e.clientY - offsetY);
			// user has left the canvas, so clear the drag flag
			//isDragging = false;
		}

		function handleMouseMove(e) {
			canMouseX = parseInt(e.clientX - offsetX);
			canMouseY = parseInt(e.clientY - offsetY);
			if (isDragging) {
				ctx.clearRect(0, 0, canvasWidth, canvasHeight);
				ctx.drawImage(background, 0, 0, background.width / resizeRatio, background.height / resizeRatio);
				coords = {x: canMouseX - barcode.width / resizeRatio / 2, y: canMouseY - barcode.height / resizeRatio / 2}
				ctx.drawImage(barcode, coords.x, coords.y, barcode.width / resizeRatio, barcode.height / resizeRatio);
			}
		}

		$("#canvas").mousedown(function(e) {
			handleMouseDown(e);
		});
		$("#canvas").mousemove(function(e) {
			handleMouseMove(e);
		});
		$("#canvas").mouseup(function(e) {
			handleMouseUp(e);
		});
		$("#canvas").mouseout(function(e) {
			handleMouseOut(e);
		});

		function getBarcodedImage() {
			var canvas = document.getElementById("hidden");
			var ctx = canvas.getContext("2d");
			var ratio = resizeRatio;
			ctx.drawImage(background, 0, 0, background.width, background.height);
			ctx.drawImage(barcode, coords.x * ratio, coords.y * ratio, barcode.width, barcode.height);
			return canvas.toDataURL("image/jpg");
		}

		$('#save').click(function(e) {
			var dataURL = getBarcodedImage();
			$('#save').attr('href', dataURL);
		});

		$('#print').click(function(e) {
			var dataURL = getBarcodedImage();
			var image = window.open();
			window.document.write('<img src="' + dataURL + '"/>');
			image.print();
		});
	};





});