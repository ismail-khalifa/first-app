<?php

namespace App\Models;
use App\Models\Task;
use Illuminate\Database\Eloquent\Model;

use App\Http\Requests\TaskRequest;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
  return redirect()->route('tasks.index');
});

Route::get('/tasks', function () { 
  $tasks=Task::paginate(2);
   return view('index',compact('tasks'));
})->name('tasks.index');

Route::view('/tasks/create','create') 
  ->name('tasks.create');

  Route::get('/tasks/{task}/edit', function (Task $task) {
    return view('edit',[
      'task'=> $task
    ]);
  })->name('tasks.edit');

Route::get('/tasks/{task}', function (Task $task) {
  return view('show',[
    'task'=> $task
  ]);
})->name('tasks.show');

Route::post('/tasks', function (TaskRequest $request) {
        $task = Task::create($request->validated());

    return redirect()->route('tasks.show',['task'=>$task->id])
    ->with('success','Task created successully!');
})->name('tasks.store');

Route::put('/tasks/{task}', function (Task $task, TaskRequest $request) {
    $task->update($request->validated());

return redirect()->route('tasks.show',['task'=>$task->id])
->with('success','Task updated successully!');
})->name('tasks.update');

Route::delete('/tasks/{task}', function (Task $task) {
  $task->delete();

return redirect()->route('tasks.index')
->with('success','Task deleted successully!');
})->name('tasks.destroy');

Route::put('tasks/{task}/toggle-complete',function(task $task) { 
   $task->toggleComplete();

  return redirect()->back()->with('success','Task updated successfully!');
})->name('tasks.toggle-complete');

//Route::get('/xxx', function () {
    //return 'Hello';
//})->name('Hello');

//Route::get('/hallo', function () {
    //return redirect()->route('hello');
//});

//Route::get('/greet/{name}', function ($name) {
  //return 'Hello'. $name . '!';
//});

Route::fallback(function() {
  return 'Still got samewhere';
});




Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
