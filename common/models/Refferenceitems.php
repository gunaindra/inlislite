<?php

namespace common\models;

use Yii;
use \common\models\base\Refferenceitems as BaseRefferenceitems;

/**
 * This is the model class for table "refferenceitems".
 */
class Refferenceitems extends BaseRefferenceitems
{

	public function findByRefferenceId($id) {
		$model = BaseRefferenceitems::findBySql('SELECT Code,CONCAT(Code," - ",Name) AS Name FROM refferenceitems  WHERE Refference_id = '.$id.'  ORDER BY CODE')->all();
		return $model;
	}
}
