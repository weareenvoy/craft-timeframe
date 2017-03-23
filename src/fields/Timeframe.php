<?php
/**
 * Created by PhpStorm.
 * User: Envoy
 * Date: 3/22/17
 * Time: 10:44 AM
 */

namespace weareenvoy\timeframe\fields;


use craft\base\ElementInterface;
use craft\helpers\DateTimeHelper;
use craft\helpers\Db;
use craft\helpers\Json;
use weareenvoy\timeframe\models\Timeframe as TimeframeModel;
use craft\base\Field;
use yii\db\Schema;

class Timeframe extends Field
{
    public static function displayName(): string
    {
        return \Craft::t('timeframe', 'Timeframe');
    }



    public function getContentColumnType(): string
    {
        return Schema::TYPE_TEXT;
    }

    public function getInputHtml($value, ElementInterface $element = null): string
    {
        $variables = [
            'id' => \Craft::$app->getView()->formatInputId($this->handle),
            'name' => $this->handle,
            'value' => $value,
            'minuteIncrement' => 30
        ];

        return \Craft::$app->getView()->renderTemplate('timeframe'
            .DIRECTORY_SEPARATOR
            .'_components'
            .DIRECTORY_SEPARATOR
            .'fields'
            .DIRECTORY_SEPARATOR
            .'timeframe_input', $variables);
    }

    public function normalizeValue($value, ElementInterface $element = null)
    {
        if (is_string($value) && !empty($value)) {
            $value = Json::decode($value);
            $startTime = DateTimeHelper::toDateTime($value['startTime']);
            $endTime = DateTimeHelper::toDateTime($value['endTime']);
            return new TimeframeModel(['startTime' => $startTime, 'endTime' => $endTime]);
        }elseif($value && ($startTime = DateTimeHelper::toDateTime(['time' => $value['time']['start'], 'timezone' => $value['timezone']])) !== false && ($endTime = DateTimeHelper::toDateTime(['time' => $value['time']['end'], 'timezone' => $value['timezone']])) !== false) {
            return new TimeframeModel(['startTime' => $startTime, 'endTime' => $endTime]);
        }

        return null;
    }

    public function serializeValue($value, ElementInterface $element = null)
    {
        if($value){
            $value->startTime = Db::prepareDateForDb($value->startTime);
            $value->endTime = Db::prepareDateForDb($value->endTime);
        }

        if (is_object($value) || is_array($value)) {
            return Json::encode($value);
        }

        return $value;
    }

    public function getSearchKeywords($value, ElementInterface $element): string
    {
        return '';
    }


}