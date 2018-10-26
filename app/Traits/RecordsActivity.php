<?php 

namespace App\Traits;

/**
 * 
 */
trait RecordsActivity
{

    public static function bootRecordsActivity()
    {
        if(auth()->guest()) return;

        foreach(static::getActivitiesToRecord() as $event){
            static::$event(function ($model) use ($event) {
                $model->recordAcivity($event);
            });
        }
        
    }

    protected static function getActivitiesToRecord()
    {
        return ['created'];
    }

    public function recordAcivity($event)
    {
        $this->activity()->create([
            'user_id' => auth()->id(),
            'type' => $this->getActivityType($event),
        ]);
    }

    public function activity()
    {
        return $this->morphMany('App\Activity', 'subject');
    }

    public function getActivityType($event)
    {
        return $event . '_' . strtolower((new \ReflectionClass($this))->getShortName());
    }

}

