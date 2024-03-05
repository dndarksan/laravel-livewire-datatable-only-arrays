<h2>Laravel Livewire Datatables <small>only arrays</small></h2>
<p>Primera version de la tabla de tipo datatable con Livewire v2 y Bootstrap 4 (4.6.3)</p>

<h3>Instalacion del paquete</h3>
<li>Tener instalado y configurado correctamente el Livewire en su version 2</li>
<li>Correr el comando composer para instalar el paquete</li>
<code>composer require dndarksan/laravel-livewire-datatable-only-arrays</code>

<h3>Modo de Uso</h3>
<p>Usar el comando de artisan <code>php artisan make:dt-table NombreClase </code></p>
<p>Esto creara la clase componente de livewire NombreClase en la carpeta destinada de livewire (default: /app/Http/Livewire)</p>
<p>Una vez hecho este paso ya se encuentra disponible para hacerle render en la vista con el nombre en modo slug <code>@livewire('nombre-clase')</code></p>

<h3>Configuracion del Componente</h3>
<p>El Componente creado tendra un ejemplo de que es lo que puede tener la tabla</p>
<p>SIEMPRE! es necesario tener las tres funciones principales</p>
<code>public function encabezados(): array</code>
<p>Indice 0 del arreglo (<code>["Indice 0"]</code>) es el titulo de la tabla, Si no tiene nada extra solo saldra el titulo<br>
  <code>sorteable'=>true</code> Activara la forma de hacer un orden en la columna determinada, Para que esto funcione es necesario el indice "campo" con el nombre de la columna a ordenar<br>
  <code>searchable'=>true</code> Activara la forma de hacer busqueda en la columna determinada, Para que esto funcione es necesario el indice "campo" con el nombre de la columna a buscar<br>
</p>

<code>public function columnas(): array</code>
<p>Indice 0 del arreglo (<code>["Indice 0"]</code>) es el nombre de la llave a buscar en el arreglo<br>
  <code>class'=>""</code> Activara la manera de poner clases en cada celda de la tabla
</p>

<code>public function registros(): array</code>
<p>Arreglo con el resultado de la tabla, es necesario pasar un arreglo directo con los nombres de las llaves determinadas en los campos</p>
