# laravel-goodies
My collection of Laravel snippets/goodies/tricks/tips

-[Events](#events)
- [Add Whoops error handler](#whoops)


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

## Whoops
```bash
composer require filp/whoops
```
Add these methods to file: app/Exceptions/Handler.php
```php
public function render($request, Exception $e)
    {
        if ($this->isHttpException($e))
        {
            return $this->renderHttpException($e);
        }


        if (config('app.debug'))
        {
            return $this->renderExceptionWithWhoops($e);
        }
        return parent::render($request, $e);
    }
    protected function renderExceptionWithWhoops(Exception $e)
    {
        $whoops = new \Whoops\Run;
        $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler());

        return new \Illuminate\Http\Response(
            $whoops->handleException($e),
            $e->getStatusCode(),
            $e->getHeaders()
        );
    }
```
