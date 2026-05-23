<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class MobileUploadController extends Controller
{
    public function page($token)
    {
        $photos = Cache::get('mobileupload_' . $token, []);
        return view('vendor.mobile-upload', compact('token', 'photos'));
    }

    public function upload(Request $request, $token)
    {
        $request->validate(['photo' => 'required|image|max:10240']);

        $file   = $request->file('photo');
        $pubPath = public_path('storage/auctions');
        if (!is_dir($pubPath)) mkdir($pubPath, 0755, true);

        $fn = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move($pubPath, $fn);

        $path   = 'auctions/' . $fn;
        $photos = Cache::get('mobileupload_' . $token, []);

        if (count($photos) >= 6) {
            return response()->json(['error' => 'Máximo 6 fotos'], 422);
        }

        $photos[] = $path;
        Cache::put('mobileupload_' . $token, $photos, now()->addHours(2));

        return response()->json(['ok' => true, 'path' => $path, 'total' => count($photos)]);
    }

    public function status($token)
    {
        $photos = Cache::get('mobileupload_' . $token, []);
        return response()->json(['photos' => $photos]);
    }

    public function delete(Request $request, $token)
    {
        $idx    = $request->input('index');
        $photos = Cache::get('mobileupload_' . $token, []);
        if (isset($photos[$idx])) {
            @unlink(public_path('storage/' . $photos[$idx]));
            array_splice($photos, $idx, 1);
            Cache::put('mobileupload_' . $token, $photos, now()->addHours(2));
        }
        return response()->json(['ok' => true, 'photos' => $photos]);
    }
}
