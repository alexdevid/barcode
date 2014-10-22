<?php

/**
 * This is the model class for table "{{document}}".
 *
 * The followings are the available columns in table '{{document}}':
 * @property integer $id
 * @property string $org_id
 * @property string $doc_id
 * @property string $document
 * @property integer $created_at
 */
class Document extends BaseModel
{

	const FILE_DIR = '/userfiles/';
	const TYPE_PDF = 'application/pdf';
	const TYPE_PNG = 'image/png';
	const TYPE_JPEG = 'image/jpeg';
	const DIMENSIONS = 1500;

	public $displayWidth = 500;
	public $barcode = NULL;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{document}}';
	}

	public function saveDocument()
	{
		mkdir($this->getDocumentDir(), 0777);

		$this->document->saveAs($this->getDocumentDir() . $this->document);

		if ($this->isPDF()) {
			$this->savePDF();
		} else {
			$this->saveJPEG();
		}
	}

	public function saveJPEG()
	{
		$image = new Imagick($this->getDocumentPath());
		$image->scaleImage(self::DIMENSIONS, self::DIMENSIONS, true);
		$image->writeimage($this->getDocumentDir() . 'page[0]' . '.jpg');
	}

	public function savePDF()
	{
		$im = new imagick($this->getDocumentDir() . $this->document);
		$im->setresolution(300, 300);

		$num_pages = $im->getNumberImages();


		for ($i = 0; $i < $num_pages; $i++) {
			$im->readimage($this->getDocumentDir() . $this->document . '[' . $i . ']');
			$im->setImageCompression(imagick::COMPRESSION_LOSSLESSJPEG);
			$im->setImageCompressionQuality(100);
			$im->setImageFormat('jpg');

			$im->writeImage($this->getDocumentDir() . 'page[' . $i . '].jpg');

			$image = new Imagick($this->getDocumentDir() . 'page[' . $i . '].jpg');
			$image->scaleImage(self::DIMENSIONS, self::DIMENSIONS, true);
			$image->writeimage($this->getDocumentDir() . 'page[' . $i . '].jpg');
		}


		$im->clear();
		$im->destroy();

		return $this->document;
	}

	public function getImages()
	{
		$iterator = new DirectoryIterator($this->getDocumentDir());
		$images = [];
		foreach ($iterator as $file) {
			if ($file->isDot()) {
				continue;
			}

			if (substr($file->getFilename(), 0, 4) === "page") {
				$images[] = $this->getDocumentWebDir() . $file->getFilename();
			}
		}

		return array_reverse($images);
	}

	public function getImage($index)
	{
		return $this->getDocumentWebDir() . 'page[' . $index . '].jpg';
	}

	public function getResizeRatio()
	{
		return $this->getDocumentWidth() / $this->displayWidth;
	}

	public function isPDF()
	{
		return pathinfo($this->getDocumentDir() . $this->document, PATHINFO_EXTENSION) == 'pdf';
	}

	public function getDocumentWidth()
	{
		$size = getimagesize($this->getDocumentDir() . 'page[0].jpg');
		return $size[0];
	}

	public function getDocumentHeight()
	{
		$size = getimagesize($this->getDocumentDir() . 'page[0].jpg');
		return $size[1];
	}

	public function getDocumentWebDir()
	{
		return self::FILE_DIR . $this->id . DIRECTORY_SEPARATOR;
	}

	public function getBarcodeImage()
	{
		return self::FILE_DIR . $this->id . DIRECTORY_SEPARATOR . 'barcode.png';
	}

	public function getDocumentPath()
	{
		return $this->getDocumentDir() . $this->document;
	}

	public function getDocumentDir()
	{
		return Yii::getPathOfAlias('webroot') . Document::FILE_DIR . $this->id . DIRECTORY_SEPARATOR;
	}

	public function generateBarcode()
	{
		$height = 120;
		$fontSize = 12;
		$barcode = new Barcode($this->generateCode(), $height, Yii::getPathOfAlias('webroot.web.fonts') . '/OpenSans-Regular.ttf', $fontSize);
		$barcode->setPixelWidth(1);
		$barcode->saveBarcode(Yii::getPathOfAlias('webroot') . Document::FILE_DIR . $this->id . DIRECTORY_SEPARATOR . 'barcode.png');
	}

	/**
	 * @return string
	 */
	public function generateCode()
	{
		$code = "";
		if (strlen($this->doc_id) > 10) {
			$code = substr($this->doc_id, 0, 5) . substr($this->doc_id, -5) . $this->org_id;
		} else {
			$code = $this->doc_id . $this->org_id;
		}

		return $code;
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('org_id, doc_id, document', 'required'),
			array('created_at', 'numerical', 'integerOnly' => true),
			array('org_id, doc_id, document', 'length', 'max' => 255),
			array('document', 'file', 'types' => 'jpg, png, pdf'),
			array('org_id, doc_id', 'match',
				'pattern' => '/^[a-zA-Z0-9-_\s]+$/',
				'message' => '{attribute} может содержать только латинские буквы и цифры'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, org_id, doc_id, document, created_at', 'safe', 'on' => 'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'doc_id' => 'Номер кредитного договора',
			'org_id' => 'Код организации',
			'document' => 'Файл документа',
			'created_at' => 'Created At',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('org_id', $this->org_id, true);
		$criteria->compare('doc_id', $this->doc_id, true);
		$criteria->compare('document', $this->document, true);
		$criteria->compare('created_at', $this->created_at);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Document the static model class
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

}
