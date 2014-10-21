$(function() {

	/**
	 *
	 * @type Function|_L6.Barcode
	 */
	var Barcode = (function() {
		/**
		 * Constructor
		 * @param {type} message
		 * @returns {undefined}
		 */
		function Barcode(canvasId, resizeRatio, backgroundSrc, barcodeSrc) {

			this.canvasId = canvasId;
			this.resizeRatio = resizeRatio;
			this.background = new Image();
			this.barcode = new Image();
			this.canvas = document.getElementById(canvasId);
			this.ctx = this.canvas.getContext("2d");

			this.background.src = backgroundSrc;
			this.barcode.src = barcodeSrc;

			this.background.onload = (function() {

				// !?
				this.canvasOffset = $("#canvas").offset();
				this.offsetX = this.canvasOffset.left;
				this.offsetY = this.canvasOffset.top;

				this.canvasWidth = canvas.width;
				this.canvasHeight = canvas.height;

				this.isDragging = false;
				this.coords = {
					x: this.canvasWidth / 2 - this.barcode.width / this.resizeRatio / 2,
					y: 50
				};
				this.angle = 0;

				this.bindEvents().run();



			}).apply(this);
		}

		/**
		 *
		 * @returns {undefined}
		 */
		Barcode.prototype.run = function() {

			var _this = this;

			(function animloop() {
				requestAnimFrame(animloop);
				_this.updateCanvas();
			})();

			return this;
		};

		/**
		 *
		 * @returns {undefined}
		 */
		Barcode.prototype.bindEvents = function() {

			/**
			 *
			 */
			$('#canvas').mousedown($.proxy(function(e) {
				this.isDragging = true;
			}, this));
			/**
			 *
			 */
			$('#canvas').mouseup($.proxy(function(e) {
				this.isDragging = false;
			}, this));
			/**
			 *
			 */
			$('#canvas').mouseout($.proxy(function(e) {
				this.isDragging = false;
			}, this));
			/**
			 *
			 */
			$('#canvas').mousemove($.proxy(function(e) {
				if (this.isDragging) {
					$('#canvas').css('cursor', 'all-scroll');
					this.coords = {
						x: parseInt(e.clientX - this.offsetX + window.pageXOffset) - this.barcode.width / this.resizeRatio / 2,
						y: parseInt(e.clientY - this.offsetY + window.pageYOffset) - this.barcode.height / this.resizeRatio / 2
					};
				} else {
					$('#canvas').css('cursor', 'default');
				}
			}, this));

			/**
			 *
			 */
			$('#save').click($.proxy(function(e) {
				var dataURL = this.getBarcodedImage();
				$('#save').attr('href', dataURL);
			}, this));

			/**
			 *
			 */
			$('#print').click($.proxy(function(e) {
				e.preventDefault();
				var dataURL = this.getBarcodedImage();
				var image = window.open();
				image.document.write('<img src="' + dataURL + '"/>');
				image.print();
			}, this));

			/**
			 *
			 */
			$('#rotate').click($.proxy(function(e) {
				e.preventDefault();
				this.angle += 90;

				var canvas = document.getElementById('rotated');
				var ctx = canvas.getContext('2d')

				var width, height;
				var image = new Image();
				image.src = barcodeSrc;

				var _this = this;
				image.onload = function() {
					width = image.width;
					height = image.height;

					canvas.width = image.width;
					canvas.height = image.width;

					ctx.clearRect(0, 0, canvas.width, canvas.height);
					ctx.save();
					ctx.translate(canvas.width / 2, canvas.height / 2);
					ctx.rotate(_this.angle * Math.PI / 180);
					ctx.drawImage(image, -image.width / 2, -image.height / 2);
					ctx.restore();
				};


			}, this));

			return this;
		};

		/**
		 * Get Canvas image
		 * @returns {String}
		 */
		Barcode.prototype.getBarcodedImage = function() {
			var canvas = document.getElementById("hidden");
			var ctx = canvas.getContext("2d");

			ctx.drawImage(this.background, 0, 0, this.background.width, this.background.height);
			ctx.drawImage(
					this.barcode,
					this.coords.x * this.resizeRatio,
					this.coords.y * this.resizeRatio,
					this.barcode.width, this.barcode.height);

			return canvas.toDataURL("image/jpg");
		}

		/**
		 *
		 * @returns {undefined}
		 */
		Barcode.prototype.updateCanvas = function() {

			this.ctx.clearRect(0, 0, this.canvasWidth, this.canvasHeight);

			this.ctx.drawImage(
					this.background, 0, 0,
					this.background.width / this.resizeRatio,
					this.background.height / this.resizeRatio);

			this.ctx.save();

//			this.ctx.translate(this.coords.x + this.barcode.width / this.resizeRatio, this.coords.y + this.barcode.height / this.resizeRatio);
//			this.ctx.rotate(this.angle * Math.PI / 180);

			this.ctx.drawImage(
					this.barcode,
					this.coords.x, this.coords.y,
					this.barcode.width / this.resizeRatio,
					this.barcode.height / this.resizeRatio);

			this.ctx.restore();
		};

		return Barcode;
	})();

	var Screen = new Barcode('canvas', resizeRatio, backgroundSrc, barcodeSrc);

	$('[data-toggle="popover"]').popover({container: 'body'});

});

window.requestAnimFrame = (function() {
	return  window.requestAnimationFrame ||
			window.webkitRequestAnimationFrame ||
			window.mozRequestAnimationFrame ||
			function(callback) {
				window.setTimeout(callback, 1000 / 60);
			};
})();