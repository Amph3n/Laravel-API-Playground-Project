<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Client\Events\ResponseReceived;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return Inertia::render('Todo/Index', [

            // We cant get the user id if we haven't specified belongsto, in model
            // ::with does so we run two queries. When which gets all todos records, and one for todos with relationship to the current user.
            'todos' => Todo::with('user:id,name')->latest()->get(),

        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'todo' => 'required|string|max:255',
            'description' => 'string|max:255',
        ]);

        $request->user()->todo()->create($validated);

        return redirect(route('todo.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Todo $todo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Todo $todo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Todo $todo)
    {
        $validated = $request->validate([
            'todo' => 'required|string|max:255',
            'description' => 'string|max:255',
        ]);

        $todo->update($validated);

        return to_route('todo.index');
    }

    public function updateCheckmark(Request $request, Todo $todo)
    {
        $validated = $request->validate([
            'done' => 'required',
        ]);

        $todo->update($validated);

        return to_route('todo.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Todo $todo): RedirectResponse
    {
        $todo->delete();

        return redirect(route('todo.index'));
    }
}
