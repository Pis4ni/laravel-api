# guida alla realizzazione di un api con Laravel

## Init project

1. Installa le dipendenze di frontend

```bash
npm install
```

2. Fai partire il compilatore per i file di frontend

```bash
npm run dev
```

3. Installa le dipendenze di backend in un nuovo terminale

```bash
composer install
```

4. Fai partire il server di sviluppo backend

```bash
php artisan serve
<!-- ! se si intende usare lo storage in local utilizzare il seguente comando per avviare il server: -->
php -S localhost:8000 -t public/
```

5. Crea il symbolic link per lo storage in locale

```bash
php artisan storage:link
```

5. Copia il file `.env.example` e chiamalo `.env`. Poi esegui il comando per generare la chiave

```bash
php artisan key:generate
```

## api.php

togliere l`autenticazione

e sostituire con:

```php

<!-- *imposrto il model -->
use App\Models\Project

<!-- *creo la rotta per l`api -->

Route::get("/projects", function (Request){
    $projects = Project::paginate(12);
    // orm filteder version:
    // $projects = Project::where('published', 1)->get()->paginate(12);
    
    // return response()->json([
    //     'project' => $projects,
    //     // piu di un parametro...
    //     // 'pagination' => ['']
    // ])

    // forma contratta, un solo array
    return response()->json($project)
});

```

## Controller API

spostiamoci ora sul terminale e lanciamo il comando che creerà il controller per le API da noi create:

```bash
php artisan make:controller Api/ProjectController --api
```

## riposizionamento codice!!

ora che abbiamo sia l`api controller che l`api, possiamo spostare le funzioni dela logica dell`api dal file api.php al ProjectController.php  (che si trova nella cartella api)

- api.php
```php
use App\Http\Controllers\Api\ProjectController;

// copio la funzione e la sostituisco con questo che crea tutte le rotte necessarie al resource api, only fa si che vengano create solo quelle che desideriamo
Route::apiResource("projects", ProjectController::class)->only(["index","show"]);

// per approfondire lezione al minuto 50
```
- ProjectController.php
```php
// importo il modello di Project con:
use App\Models\Projects

// metodo idnex:
public function index()
{
    $projects = Project::select('id','title','type','technologies','slug', 'cover_image')
    ->paginate(12);
    return response()->json($project);
}
```


