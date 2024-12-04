<?php

namespace Ahadu\Crud;

use Illuminate\Support\Facades\Artisan;

class CRUD
{
    public function make($name, $columns)
    {
        $fields = explode(',', $columns);

        $values = [];

        foreach ($fields as $column) {
            list($key, $value) = explode(':', $column);
            $values[$key] = $value;
        };
        $table = null;
        $th = null;
        $td = null;
        $input = null;
        $fillable = null;
        foreach ($values as $key => $value) {
            $table = $table . '$table->' . trim($key) . "('" . trim($value) . "');";
            $th = $th . '<th>' . $value . "</th>";
            $td = $td . '<td>{{$d->' . $value . "}}</td>";
            $input = $input . '<input class="form-control" placeholder="' . $value . '" name="' . $value . '" />';
            $fillable = $fillable . "'" . trim($value) . "',";
        }

        $controllerPath = 'app/Http/Controllers/' . $name . 'Controller.php';
        $controllerContent = '<?php

            namespace App\Http\Controllers;

            use App\Models\\' . $name . ';
            use Illuminate\Http\Request;

            class ' . $name . 'Controller extends Controller
                
            {

            public function index(){
                $data=' . $name . '::all();
            return view("pages.' . $name . '" ,compact("data"));
            }

             public function create(){

            return view("pages.' . $name . '-create" );
            }

            public function store(Request $request){
            ' . $name . '::create($request->all());
            return redirect()->route(\'' . strtolower($name) . '.index\')->with("success","creation successful");
            }

            }';


        $modelPath = 'app/Models/' . $name . '.php';
        $modelContent = '<?php
        namespace App\Models;
        use Illuminate\Database\Eloquent\Factories\HasFactory;
        use Illuminate\Foundation\Auth\User as Authenticatable;
        use Illuminate\Notifications\Notifiable;
        use Laravel\Sanctum\HasApiTokens;
        use Spatie\Permission\Traits\HasRoles;
        use Spatie\Activitylog\Traits\LogsActivity;

        class ' . $name . ' extends Authenticatable
        {
            use HasApiTokens, HasRoles, HasFactory, Notifiable,LogsActivity;

            protected $table=' . "'" . strtolower($name) . "'" . ';
            protected $fillable = [' . $fillable . '];
            
        }';



        $migrationPath = 'database/migrations/' . "2024_11_20_0000000_create_" . strtolower($name) . '_table.php';

        $migrationContent = '<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Create' . $name . 'Table extends Migration
{
   
    public function up()
    {
        Schema::create(' . "'" . strtolower($name) . "'" . ', function (Blueprint $table) {
            $table->id();' . $table . '          
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists(' . "'" . strtolower($name) . "'" . ');
    }
}
';

        $routePath = 'routes/web.php';
        $routeToBeAdded = "\nRoute::resource('" . strtolower($name) . "', App\Http\Controllers\\" . $name . 'Controller::class);';


        $numberOfFields = count(explode(',', $columns));
        $bladePath = 'resources/views/pages/' . $name . '.blade.php';
        $bladeContetnt = "@extends('layouts.admin', ['activePage' => '.$name.', 'titlePage' => __('.$name.')])

        @section('content')
        <div class='row card'>
        <div class='d-lg-flex'>
        <h3>" .
            $name
            . "</h3>
 
             <a href={{ route('home') }}
                        class='ms-5 fs-6 mt-2'>
                        <i class='fa fa-arrow-left fa-1x'></i>
                        </a>
                        <a href={{ route('" . strtolower($name) . ".index') }}
                        class='ms-5 fs-6 mt-2'>
                        <i class='fa fa-redo fa-1x'></i> </a> 
                        <a href={{ route('" . strtolower($name) . ".create') }}
                        class='ms-5 fs-6 mt-2'>
                        <i class='fa fa-plus fa-1x'></i>   
                        </a>
          
        </div>

        <div class='card-body'>
        <table class='table'>
        <thead class='table-light'>" . $th . "
        </thead>
        <tbody>
        @foreach(\$data as \$d)
        <tr colspan='.$numberOfFields.'>
       $td
        <tr>

        
        @endforeach
        </tbody>
        </table>


        </div>
        </div>

        @endsection
        ";
        $createBladePath = 'resources/views/pages/' . $name . '-create.blade.php';
        $createBladeContent = "@extends('layouts.admin', ['activePage' => '.$name.', 'titlePage' => __('.$name.')])

        @section('content')
        <div class='row card'>
        <div class='d-lg-flex'>
        <h4> Create " .
            $name
            . "</h4>
 
             <a href={{ route('" . strtolower($name) . ".index') }}
                        class='ms-5 fs-6 mt-2'>
                        <i class='fa fa-arrow-left fa-1x'></i>
                        </a>
                        <a href={{ route('" . strtolower($name) . ".create') }}
                        class='ms-5 fs-6 mt-2'>
                        <i class='fa fa-redo fa-1x'></i> </a>           
        </div>

        <div class='card-body'>
       <form action={{ route('" . strtolower($name) . ".store') }} method='post'>
       @csrf
       <div class='form-group'>
       '.$input.'
       <input class='btn btn-primary float-end' type='submit' value='submit'/>
       </div>
       </form>


        </div>
        </div>

        @endsection
        ";

        file_put_contents($routePath, $routeToBeAdded, FILE_APPEND);
        file_put_contents($modelPath, $modelContent);
        file_put_contents($migrationPath, $migrationContent);
        file_put_contents($controllerPath, $controllerContent);
        file_put_contents($bladePath, $bladeContetnt);
        file_put_contents($createBladePath, $createBladeContent);
        Artisan::call('migrate');
    }
}
