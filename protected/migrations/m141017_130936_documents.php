<?php

class m141017_130936_documents extends CDbMigration
{
	public function up()
	{
		$this->createTable('{{document}}', [
			'id' => 'pk',
			'org_id' => 'string NOT NULL',
			'doc_id' => 'string NOT NULL',
			'document' => 'string NOT NULL',
			'created_at' => 'integer'
		]);
	}

	public function down()
	{
		$this->dropTable('{{document}}');
	}
}