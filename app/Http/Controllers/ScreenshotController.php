<?php

namespace App\Http\Controllers;

use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class ScreenshotController extends Controller
{
    public function __construct()
    {
        $this->middleware(function($req, $next){
            if (!\RBAC::hasAnyPerm('تهیه عکس زائر')) {
                return redirect()->route('dashboard')->with('error', 'دسترسی غیر مجاز');
            }

            return $next($req);
        });
    }

    public function index()
    {
        return view('screenshot.index');
    }

    public function postIndex(Request $request)
    {
        $code = preg_replace("/[^0-9]/", "", $request->code);
        $type = $request->type;

        // Validation
        try {

            if (!in_array($type, ['داخل', 'خارج', ''])) {
                throw new \Exception("نوع تردد معتبر نیست");
            }

            if (empty($code)) {
                throw new \Exception("هیچ کدی ارسال نشده است");
            }

            $person = Person::where('code', $code)->orWhere('melli', $code)->first();

            if (!$person) {
                throw new \Exception("زائری با کد وارد شده یافت نشد");
            }

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }

        if (!empty($type)) {
            try {

                // Ban
                if (!is_null($person->ban)) {
                    $person->addError('مسدود');
                    throw new \Exception("");
                }

                // Status
                if ($type == "داخل") {
                    if ($person->isIn()) {
                        $person->addError('ورود');
                        throw new \Exception("خطای ورود. زائر قبلا وارد شده است");
                    }
                } else {
                    if (!$person->isIn()) {
                        $person->addError('خروج');
                        throw new \Exception("خطای خروج. زائر قبلا خارج شده است");
                    }
                }

                // Sabte Taradod
                $person->newTraffic($type);

            } catch (\Exception $e) {
                return response()->json([
                    'error'    => $e->getMessage(),
                    'personinfo' => View::make('components.personinfo-ajax', compact('person'))->render(),
                ]);
            }
        }

        // Message
        $message = "عکس با موفقیت ذخیره شد";
        if (!empty($type)) {
            $message .= " - " . ($type == "داخل" ? "ورود" : "خروج") . ' با موفقیت ثبت شد';
        }

        // Image
        if (!empty($request->image)) {
            if ($person->getFirstMedia()) {
                $person->getFirstMedia()->delete();
            }

            $file = base64ImageToUploadedFile($request->image);
            $person->copyMedia($file)->toMediaCollection();
            @unlink($file->getRealPath());
        }

        $image_url = $person->media()->first()->getUrl();

        return response()->json([
            'success'    => $message,
            'personinfo' => View::make('components.personinfo-ajax', compact('person', 'image_url'))->render(),
        ]);
    }
}
