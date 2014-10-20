<?php

/**
 * Description of BaseModel
 *
 * All tables should have 'date_edit' and 'date_create' columns
 * for making autotimestamps work properly
 *
 * In child models in beforeSave method you should use a `parent::beforeSave()`
 *
 * @author dev
 */
class BaseModel extends CActiveRecord
{

    /**
     * Setting datetime behavior for models
     */
    public function beforeValidate()
    {

        if ($this->isNewRecord) {
            $this->created_at = time();
        }

        return parent::beforeValidate();
    }

}
