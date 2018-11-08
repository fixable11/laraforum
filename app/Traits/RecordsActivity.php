<?php 

namespace App\Traits;

/**
 * 
 */
trait RecordsActivity
{

    /**
     * Boot the trait.
     */
    public static function bootRecordsActivity()
    {
        if(auth()->guest()) return;

        foreach(static::getActivitiesToRecord() as $event){
            static::$event(function ($model) use ($event) {
                $model->recordAcivity($event);
            });
        }

        static::deleting(function($model){
            $model->activity()->delete();
        });
        
    }

    /**
     * Fetch all model events that require activity recording.
     *
     * @return array
     */
    protected static function getActivitiesToRecord()
    {
        return ['created'];
    }

    /**
     * Record new activity for the model.
     *
     * @param string $event
     */
    public function recordActivity($event)
    {
        $this->activity()->create([
            'user_id' => auth()->id(),
            'type' => $this->getActivityType($event),
        ]);
    }

    /**
     * Determine the activity type.
     *
     * @param  string $event
     * @return string
     */
    public function activity()
    {
        return $this->morphMany('App\Activity', 'subject');
    }

    /**
     * Determine the activity type.
     *
     * @param  string $event
     * @return string
     */
    public function getActivityType($event)
    {
        return $event . '_' . strtolower((new \ReflectionClass($this))->getShortName());
    }

}

