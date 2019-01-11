<?php

namespace App;

trait RecordsActivity {

    /**
     * Laravel is going to detect this and trigger it exactly as if you created boot method on model itself (for that we have to use this trait in that model)
     *
     * @return void
     */
    protected static function bootRecordsActivity() // naming will be (boot + RecordsActivity [Trait name])
    {
        foreach(static::getActivitiesToRecord() as $event){
            static::$event(function($model) use ($event){
                $model->recordActivity($event);
            }); 
            /* 
            this has been converted to dynamic as above
            static::created(function($thread){
                $thread->recordActivity('created');
            });  */
        }
        
    }

    /**
     * usingi this method in above boot method we can make it dynamic so that we can decide in model by orverriding this method to which event activity to record
     *
     * @return void
     */
    protected static function getActivitiesToRecord()
    {
        return ['created'];
    }

    protected function recordActivity($event)
    {
        $this->activity()->create([
            'user_id'       => auth()->id(),
            'type'          => $this->getActivityType($event),
        ]);
        /* 
        This can be refactored into Eloquent relation as activity() below and other 2 fields can be used as above
        Activity::create([
            'user_id'       => auth()->id(),
            'type'          => $this->getActivityType($event),
            'subject_id'    => $this->id,
            'subject_type'  => get_class($this)
        ]); */
    }

    public function activity(){
        return $this->morphMany(Activity::class, 'subject');
    }

    protected function getActivityType($event)
    {
         // this will give us, \App\Thread -> Thread -> thread
         $type = strtolower((new \ReflectionClass($this))->getShortName());
        return "{$event}_{$type}";
    }


}