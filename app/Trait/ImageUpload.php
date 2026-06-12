<?php

namespace App\Trait;
use Illuminate\Support\Str;
use Image;
use File;


trait ImageUpload {


	public static function singleImageUpload($file, $path){

		$ext  = $file->extension();
		$pics = Image::make($file);

		if(!File::exists($path)){ File::makeDirectory($path); }

		$file_name = 'physical-progress-images-'.strtolower(Str::random(30)).'.'.$ext;

        $pics->save($path.$file_name);

        return $file_name;

	}


}
