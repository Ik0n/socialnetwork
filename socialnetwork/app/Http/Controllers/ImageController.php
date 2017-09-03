<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateImageRequest;
use App\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function __construct()
    {
        $this->disk = 'image_disk';
    }

    public function index() {
        return view('layouts.images.index', [
            'images' => Image::orderBy('id')->get()
        ]);
    }

    public function show($id) {

        return view('layouts.images.show', [
            'image' => Image::findOrFail($id)
        ]);
    }

    public function add() {

        return view('layouts.images.new', [
           'image' => new Image()
        ]);
    }

    public function create(CreateImageRequest $request) {

        var_dump($this->disk);
        $file = $request->file('file');
        $filename = $this->fixedStore($file, '', $this->disk);

        try {
            $image = Image::create([
                'filename' => $filename
            ]);
        } catch (\Exception $exception) {
            Storage::disk($this->disk)->delete($filename);
            throw $exception;
        }

        return redirect(route('images.show', [
            'id' => $image->id
        ]));
    }

    public function fixedStore($file, $path, $disk) {
        $folder = Storage::disk($disk)->getAdapter()->getPathPrefix();
        $temp = tempnam($folder, '');
        $filename = pathinfo($temp, PATHINFO_FILENAME);
        $extension = $file->extension();

        try {
            $basename = $file->storeAs($path, "$filename.$extension", $disk);
        } catch (\Exception $exception) {
            throw $exception;
        } finally {
            unlink($temp);
        }

        return $basename;
    }

    public function remove($id) {

        return view('layouts.images.remove', [
            'image' => Image::findOrFail($id)
        ]);
    }

    public function destroy($id) {
        $image = Image::findOrFail($id);
        Storage::disk($this->disk)->delete($image->filename);
        $image->delete();

        return redirect(route('images.index'));
    }
}
