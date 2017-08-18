# laravel-goodies
My collection of Laravel snippets/goodies/tricks/tips

-[Events](#events)
- [Add Whoops error handler](#whoops)
- [Use webpack with different public path+shared hosting](#webpack)
- [Trusted proxies without any packages](#proxies)


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
## Webpack
If you use different public folders (For example shared hosting) like public_html instead of public you can get JS,CSS files published in wrong path. There is easy workaround..But only on UNIX system. All you have to do is: create symbolic link to your real public folder. So Laravel will treat your different folder like public!
```bash
ln -s public_html public 
ls -al ./public #check it
npm run dev #now your files are published in right place
```
You can also put laravel in some different folder for example public_html/lara. This is useful o shared hosting! Example structure:

public_html/

    index.php
    
    lara/artisan
    
    lara/...all laravel framework stuff
    
 To make it work change paths in: public_html/index.php:
 
 ```php
 require __DIR__.'/lara/bootstrap/autoload.php';...
 $app = require_once __DIR__.'/lara/bootstrap/app.php';
 ```
 
 Also make symbolic link:
 ```bash
 cd public_html/lara
 ln -s ../ public 
 ls -al ./public #check it
 ```
 
## Proxies
Sometimes trusted proxy packages like fideloper/TrustedProxy cant help you, because you need to register trusted proxies earlier. Without any package you can do it in AppServiceProvider, so trusted proxies will be registered before middleware and just with 2 lines of code:
```php
 public function register()
    {
        $request=$this->app->make('request');
        $request->setTrustedProxies(['proxy ip']);
        //...
```
