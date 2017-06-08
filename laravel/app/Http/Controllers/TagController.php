<?php

namespace App\Http\Controllers;

use App\Http\Requests\TagRequest;
use App\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{

    public function create() {
        $tag = new Tag();

        return view('layouts.tags.create', [
            'entity' => $tag
        ]);
    }

    public function store(TagRequest $request) {
        $attributes = $request->only(['title']);
        Tag::create($attributes);
        return redirect(route('tags.index'));
    }

    public function edit($id) {
        $tag = Tag::findOrFail($id);

        return view('layouts.tags.edit' , [
            'entity' => $tag
        ]);
    }

    public function update(TagRequest $request, $id) {
        $tag = Tag::findOrFail($id);
        $attributes = $request->only('title');
        $tag->update($attributes);

        /* return redirect(route('tags.edit', [
            'id' => $tag->id
        ])); */

        return redirect(route('tags.index'));
    }

    public function delete($id) {
        $tag = Tag::findOrFail($id);

        return view('layouts.tags.delete', [
            'entity' => $tag
        ]);

    }

    public function destroy($id) {
        $tag = Tag::findOrFail($id);
        $tag->delete($id);

        return redirect(route('tags.index'));

    }

    public function index() {

        return view('layouts.tags.index', [
            'tags' => Tag::orderBy('title', 'ASC')
                            ->get()
        ]);

    }
}
