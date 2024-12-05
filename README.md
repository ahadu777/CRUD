<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

<h1>Installation Instructions for Ahadu CRUD Package</h1>

<h2>Step 1: Add the Package</h2>
<p>Use Composer to add the Ahadu CRUD package to your Laravel project:</p>
<pre><code>composer require ahadu/crud</code></pre>

<h2>Step 2: Register the Service Provider</h2>
<p>After installing the package, you need to register the service provider in your Laravel application. Open the <code>config/app.php</code> file and add the following line to the <code>providers</code> array:</p>
<pre><code>'providers' => [
  // Other Service Providers

  ahadu\crud\CrudServiceProvider::class,
],</code></pre>

<h2>Step 3: Publish Configuration (if applicable)</h2>
<p>If your package has configuration options, you can publish them using the following command:</p>
<pre><code>php artisan vendor:publish --provider="ahadu\crud\CrudServiceProvider"</code></pre>

<h2>Step 4: Usage </h2>
<p>If you use the command (make sure you have a /pages directory inside your views)</p>
<pre><code>php artisan make:crud -name="ModelNameHere" --columns=" datatype:name "</code></pre>

<p>If you use it in a controller</p>
<pre><code> CRUD::make($modelName,$columnsWithTheirDataType) </code></pre>

<h2>Conclusion</h2>
<p>After completing these steps, the Ahadu CRUD package will be ready to use in your Laravel application. If you have any questions or need further assistance, please contact me with ahadu4321@gmail.com.</p>

</body>
</html>
