<?php

namespace App\Http\Controllers;

use App\Configuration;
use Illuminate\Http\Request;
use App\Dream;
use Illuminate\Support\Facades\File;

class ImagesUrlsController extends Controller
{
    const validImageTypes = [
        IMAGETYPE_GIF,
        IMAGETYPE_JPEG,
        IMAGETYPE_PNG,
        IMAGETYPE_BMP
    ];

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $baseImages = Dream::select(['image'])->get()->filter(function ($image) {
            return $this->isValidImage(public_path($image->image));
        });

        $configuration = Configuration::whereSlug('duplications')->first();

        $possibleImages = collect([]);

        for ($i = 0; $i <= $configuration->value; $i++) {
            $possibleImages->push($baseImages);
        }

        $possibleImages = $possibleImages->flatten();

        return $possibleImages;
    }

    protected function isValidImage($path)
    {
        if (!File::exists($path)) {
            return false;
        }

        $a = getimagesize($path);
        $image_type = $a[2];

        return in_array($image_type, self::validImageTypes);
    }
}
