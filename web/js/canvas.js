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

				this.barcode.onload = (function() {

					var centerX = (this.background.width / this.resizeRatio) / 2 - (this.barcode.width / this.resizeRatio) / 2;
					var centerY = (this.background.height / this.resizeRatio) / 2 - (this.barcode.height / this.resizeRatio) / 2;

					this.ctx.drawImage(this.background, 0, 0, this.background.width / this.resizeRatio, this.background.height / this.resizeRatio);
					this.ctx.drawImage(this.barcode, centerX, centerY, this.barcode.width / this.resizeRatio, this.barcode.height / this.resizeRatio);

				}).apply(this);

				// !?
				this.canvasOffset = $("#canvas").offset();
				this.offsetX = this.canvasOffset.left;
				this.offsetY = this.canvasOffset.top;

				this.canvasWidth = canvas.width;
				this.canvasHeight = canvas.height;

				this.isDragging = false;
				this.canMouseX = 1;
				this.canMouseY = 1;
				this.coords = {x: 50, y: 50};
				this.angle = 0;

				this.bindEvents();

				var _this = this;
				window.setInterval(function() {
					_this.updateCanvas();
				}, 10);

			}).apply(this);
		}

		/**
		 *
		 * @returns {undefined}
		 */
		Barcode.prototype.bindEvents = function() {

			$('#canvas').mousedown($.proxy(function(e) {
				this.handleMouseDown(e);
			}, this));

			$('#canvas').mousemove($.proxy(function(e) {
				this.handleMouseMove(e);
			}, this));

			$('#canvas').mouseup($.proxy(function(e) {
				this.handleMouseUp(e);
			}, this));

			$('#canvas').mouseout($.proxy(function(e) {
				this.handleMouseOut(e);
			}, this));

			$('#save').click($.proxy(function(e) {
				var dataURL = this.getBarcodedImage();
				$(this).attr('href', dataURL);
			}, this));

			$('#print').click($.proxy(function(e) {
				var dataURL = this.getBarcodedImage();
				var image = window.open();
				window.document.write('<img src="' + dataURL + '"/>');
				image.print();
			}, this));

			$('#rotate').click($.proxy(function(e) {
				e.preventDefault();
				this.angle += 90;
				this.ctx.clearRect(0, 0, this.canvasWidth, this.canvasHeight);
				this.ctx.drawImage(this.background, 0, 0, this.background.width / this.resizeRatio, this.background.height / this.resizeRatio);
				this.ctx.save();
				this.ctx.translate(this.canvasWidth / 2, this.canvasHeight / 2);
				this.ctx.rotate(this.angle * Math.PI / 180);
				this.ctx.drawImage(this.barcode, -this.barcode.width / this.resizeRatio / 2, -this.barcode.height / this.resizeRatio / 2, this.barcode.width / this.resizeRatio, this.barcode.height / this.resizeRatio);
				this.ctx.restore();
			}, this));

		};

		/**
		 *
		 * @param {event} e
		 * @returns {undefined}
		 */
		Barcode.prototype.handleMouseDown = function(e) {
			this.canMouseX = parseInt(e.clientX - this.offsetX);
			this.canMouseY = parseInt(e.clientY - this.offsetY);

			this.isDragging = true;
		};

		/**
		 *
		 * @param {event} e
		 * @returns {undefined}
		 */
		Barcode.prototype.handleMouseUp = function(e) {
			this.canMouseX = parseInt(e.clientX - this.offsetX);
			this.canMouseY = parseInt(e.clientY - this.offsetY);

			this.isDragging = false;
		};

		/**
		 *
		 * @param {event} e
		 * @returns {undefined}
		 */
		Barcode.prototype.handleMouseOut = function(e) {
			this.canMouseX = parseInt(e.clientX - this.offsetX);
			this.canMouseY = parseInt(e.clientY - this.offsetY);
			
			this.isDragging = false;
		};

		/**
		 *
		 * @param {event} e
		 * @returns {undefined}
		 */
		Barcode.prototype.handleMouseMove = function(e) {

			if (this.isDragging) {
				this.canMouseX = parseInt(e.clientX - this.offsetX);
				this.canMouseY = parseInt(e.clientY - this.offsetY);
			}

		};

		/**
		 * Get Canvas image
		 * @returns {String}
		 */
		Barcode.prototype.getBarcodedImage = function() {
			var canvas = document.getElementById("hidden");
			var ctx = canvas.getContext("2d");
			var ratio = this.resizeRatio;
			this.ctx.drawImage(this.background, 0, 0, this.background.width, this.background.height);
			ctx.drawImage(this.barcode, this.coords.x * ratio, this.coords.y * ratio, this.barcode.width, this.barcode.height);
			return canvas.toDataURL("image/jpg");
		}

		/**
		 *
		 * @returns {undefined}
		 */
		Barcode.prototype.updateCanvas = function() {
			this.ctx.clearRect(0, 0, this.canvasWidth, this.canvasHeight);
			this.ctx.drawImage(this.background, 0, 0, this.background.width / this.resizeRatio, this.background.height / this.resizeRatio);
			this.ctx.save();
			this.ctx.translate(this.canvasWidth / 2, this.canvasHeight / 2);
			this.ctx.rotate(this.angle * Math.PI / 180);

			this.coords = {
				x: this.canMouseX - this.barcode.width / this.resizeRatio / 2,
				y: this.canMouseY - this.barcode.height / this.resizeRatio / 2
			};

			this.ctx.drawImage(this.barcode, this.coords.x, this.coords.y, this.barcode.width / this.resizeRatio, this.barcode.height / this.resizeRatio);
			this.ctx.restore();
		};

		return Barcode;
	})();

	var Screen = new Barcode('canvas', resizeRatio, backgroundSrc, barcodeSrc);

});