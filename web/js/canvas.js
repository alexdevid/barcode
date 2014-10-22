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

			this.setBarcodeImage();
			this.bindEvents();
		}

		Barcode.prototype.setBarcodeImage = function() {

			var BarcodeElement = document.getElementById('barcode');

			var _this = this;
			var BarcodeImage = fabric.Image.fromURL(barcodeSrc, function(Image) {
				Image.setOptions({
					left: (_this.Canvas.width) / 2,
					top: 50,
					width: BarcodeElement.width / _this.resizeRatio,
					height: BarcodeElement.height / _this.resizeRatio,
					lockScalingX: true,
					lockScalingY: true,
					hasControls: false,
					originX: 'center',
					originY: 'center'
				});

				_this.BarcodeImage = Image;
				_this.Canvas.add(Image);

			});
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

	if (document.getElementById('canvas')) {
		new Barcode('canvas', resizeRatio);
	}


	$('[data-toggle="popover"]').popover({container: 'body'});

})();