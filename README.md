# laravel-goodies
My collection of Laravel snippets/goodies/tricks/tips

-[Events](#events)


## Events
Listen to all events. Put in EventServiceProvider boot()
```
Event::listen('*',function(){

});
```
