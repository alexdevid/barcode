(function() {

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
		function Barcode(canvasId, ratio) {

			this.BarcodeImage = null;
			this.Canvas = null;
			this.resizeRatio = ratio;
			this.angle = 0;
			this.resizeRatio = ratio;

			this.Canvas = new fabric.Canvas(canvasId);

			this.Canvas.setBackgroundImage(backgroundSrc, this.Canvas.renderAll.bind(this.Canvas), {
				width: this.Canvas.width,
				height: this.Canvas.height
			});

			this.BarcodeImage = this.barcodeImage();
			this.Canvas.add(this.BarcodeImage);

			this.bindEvents();
		}

		Barcode.prototype.barcodeImage = function() {

			var BarcodeElement = document.getElementById('barcode');
			var BarcodeImage = new fabric.Image(BarcodeElement, {
				left: (this.Canvas.width) / 2,
				top: 50,
				width: BarcodeElement.width / this.resizeRatio,
				height: BarcodeElement.height / this.resizeRatio,
				lockScalingX: true,
				lockScalingY: true,
				hasControls: false,
				originX: 'center',
				originY: 'center'
			});

			return BarcodeImage;
		};

		/**
		 *
		 * @returns {undefined}
		 */
		Barcode.prototype.bindEvents = function() {

			/**
			 *
			 */
			$('#save').click($.proxy(function(e) {
				e.preventDefault();
				var image = window.open();
				image.document.write('<img src="' + this.getBarcodedImage() + '"/>');
			}, this));

			/**
			 *
			 */
			$('#print').click($.proxy(function(e) {
				e.preventDefault();
				var image = window.open();
				image.document.write('<img src="' + this.getBarcodedImage() + '"/>');
				image.print();

			}, this));

			/**
			 *
			 */
			$('#rotate').click($.proxy(function(e) {
				e.preventDefault();

				this.BarcodeImage.animate('angle', '+=90', {
					onChange: this.Canvas.renderAll.bind(this.Canvas),
					duration: 100
				});

			}, this));

			return this;
		};

		/**
		 * Get Canvas image
		 * @returns {String}
		 */
		Barcode.prototype.getBarcodedImage = function() {
			return this.Canvas.toDataURL({
				format: 'jpeg',
				quality: 1,
				multiplier: this.resizeRatio
			});
		};

		return Barcode;
	})();

	new Barcode('canvas', resizeRatio);

	$('[data-toggle="popover"]').popover({container: 'body'});

})();