<?php
namespace weareenvoy\timeframe;

use craft\base\Plugin;
use craft\events\RegisterComponentTypesEvent;
use craft\services\Fields;
use yii\base\Event;

class Timeframe extends Plugin
{
    public function init()
    {
        Event::on(Fields::class,Fields::EVENT_REGISTER_FIELD_TYPES,function(RegisterComponentTypesEvent $event){
            $event->types[] = \weareenvoy\timeframe\fields\Timeframe::class;
        });

        parent::init();
    }
}