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
		function Barcode(canvasId, ratio, backgroundSrc) {

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
			fabric.Image.fromURL(BarcodeElement.src, function(Image) {
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

	if (runCanvas) {

		var Scenes = [];

		for (var i = 0; i < Images.length; i++) {
			Scenes.push(new Barcode('canvas_' + i, resizeRatio, Images[i]));
		}
		var ActiveScene = Scenes[0];

		$('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
			ActiveScene = Scenes[$(e.target).attr('data-id')];
		});

		/**
		 *
		 */
		$('#save').click(function(e) {
			e.preventDefault();
			var image = window.open();
			image.document.write('<img src="' + ActiveScene.getBarcodedImage() + '"/>');
		});

		/**
		 *
		 */
		$('#print').click(function(e) {
			e.preventDefault();
			var image = window.open();
			image.document.write('<img src="' + ActiveScene.getBarcodedImage() + '"/>');
			image.print();

		});

		/**
		 *
		 */
		$('#rotate').click(function(e) {
			e.preventDefault();

			ActiveScene.BarcodeImage.animate('angle', '+=90', {
				onChange: ActiveScene.Canvas.renderAll.bind(ActiveScene.Canvas),
				duration: 100
			});

		});

		$('#saveBulk').click(function(e) {
			e.preventDefault();

			var images = [];
			for (var i = 0; i < Scenes.length; i++) {
				images.push(Scenes[i].getBarcodedImage());
			}

			$.ajax({
				method: 'POST',
				url: '/system/save',
				data: {
					id: uid,
					images: images
				},
				success: function(data) {
					if (data.substr(data.length - 3) === 'zip') {
						document.getElementById("downloadFrame").src = data;
					} else {
						$('#saveBulk').addClass('disabled');
						console.log(data);
					}
				}
			});

		});
	}

	$('#uploadBtn').click(function(e) {
		e.preventDefault();
		$(this).find('.glyphicon').removeClass('glyphicon-upload').addClass('glyphicon-refresh').addClass('rotate');
		$('#upload-form').submit();
	});

	$('[data-toggle="popover"]').popover({container: 'body'});

})();