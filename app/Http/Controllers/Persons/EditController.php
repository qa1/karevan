<?php

namespace App\Http\Controllers\Persons;

use App\Http\Controllers\Controller;
use App\Models\Person;
use Illuminate\Http\Request;

class EditController extends Controller
{
    public function index(Person $person)
    {
        return view('persons.edit', compact('person'));
    }

    public function postIndex(Request $request, Person $person)
    {
        $request->validate([
            'name'            => 'nullable|max:255',
            'father'          => 'nullable|max:255',
            'code'            => 'nullable|numeric|unique:persons,code,' . $person->id,
            'melli'           => 'nullable|numeric|unique:persons,melli,' . $person->id,
            'image'           => 'nullable|mimes:jpeg,jpg,bmp,png',
            'city_id'         => 'nullable|exists:cities,id',
            'modirkarevan_id' => 'nullable|exists:modirkarevans,id',
            'ban'             => 'nullable|max:255|min:5'
        ]);

        // Image
        if (!empty($request->person_camera_data)) {
        	if ($person->hasImage()) {
	        	$person->getFirstMedia()->delete();
        	}

            $file = base64ImageToUploadedFile($request->person_camera_data);
            $person->copyMedia($file)->toMediaCollection();
            @unlink($file->getRealPath());
        } else if ($request->image) {
        	if ($person->hasImage()) {
	        	$person->getFirstMedia()->delete();
        	}

            $person->copyMedia($request->image)->toMediaCollection();
        }

        $person->update([
            'name'            => $request->name ?: NULL,
            'father'          => $request->father ?: NULL,
            'code'            => $request->code ?: NULL,
            'melli'           => $request->melli ?: NULL,
            'city_id'         => $request->city_id ?: NULL,
            'modirkarevan_id' => $request->modirkarevan_id ?: NULL,
            'ban'             => $request->ban ?: NULL
        ]);

        return back()->with('success', 'با موفقیت ذخیره شد');
    }

    public function deleteImage(Person $person)
    {
    	if ($person->hasImage()) {
    		$person->getFirstMedia()->delete();
    	}

        return back()->with('success', 'با موفقیت حذف شد');
    }
}
