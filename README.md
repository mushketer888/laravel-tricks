# laravel-goodies
My collection of Laravel snippets/goodies/tricks/tips

-[Events](#events)


## Events
Listen to all events. Put in EventServiceProvider boot()
```php
Event::listen('*',function($eventName, array $data){
    var_dump($eventName,$data);//dump event name + data in response
    if ($eventName!="Illuminate\Log\Events\MessageLogged")//without it it will be recursion!
        Log::info($eventName);
});
```
List of some events:
- laravel.done
- laravel.log
- laravel.query
- laravel.resolving
- laravel.composing: {viewname}
- laravel.started: {bundlename}
- laravel.controller.factory
- laravel.config.loader
- laravel.language.loader
- laravel.view.loader
- laravel.view.engine
- view.filter
- eloquent.saving
- eloquent.updated
- eloquent.created
- eloquent.saved
- eloquent.deleting
- eloquent.deleted
- eloquent.booted: {$model}
- eloquent.booting: {$model}
- 500
- 404
