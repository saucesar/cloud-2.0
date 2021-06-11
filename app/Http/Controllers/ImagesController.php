<?php

namespace App\Http\Controllers;

use App\Http\Requests\Image\StoreImage;
use App\Http\Requests\Image\UpdateImage;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ImagesController extends Controller
{
    public function index()
    {
        $data = [
            'images' => Image::paginate(10),
            'user_id' => Auth::user()->id,
            'title' => 'Images',
        ];

        return view('pages/images/index', $data);
    }

    public function create()
    {
        return view('pages/images/create');
    }

    public function store(StoreImage $request)
    {
        try {
            Image::create($request->all());
            return redirect()->route('images.index')->with('success', 'Image has be created!!!');
        } catch(\Exception $e) {
            return redirect()->route('images.index')->with('error', $e->getMessage());
        }
    }

    public function edit($id)
    {
        return view('pages/images/edit', ['image' => Image::firstWhere('id', $id)]);
    }

    public function update(UpdateImage $request, $id)
    {
        try {
            $image = Image::firstWhere('id', $id);
            $image->update($request->all());
            
            return redirect()->route('images.index')->with('success', 'Image has be updated!!!');
        } catch(\Exception $e) {
            return redirect()->route('images.index')->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $container = Image::firstWhere('id', $id);

        $container->delete();

        return redirect()->route('images.index')->with('success', 'Container deleted!!!');
    }
}
