<?php

namespace App\Http\Controllers\Flow;

use App\Http\Controllers\Controller;
use App\Models\Milestone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ProgressInputController extends Controller
{
    public function progressInputUploadAttachment(Request $request)
    {
        $request->validate([
            "milestone_id" => "required",
        ]);

        $milestone =  Milestone::find($request->milestone_id);
        if ($milestone) {

            // return $milestone->milestone;

            if ($request->hasFile("attachment")) {

                //remove old attachemnt if it exists
                if (!empty($milestone->attachment) && $milestone->attachment != "") {
                    $filename = 'uploads/attachments/' . $milestone->attachment;
                    File::delete($filename);
                }

                $file = $request->file('attachment');

                $unique_id = uniqid();
                $filename = Str::slug($milestone->milestone) . "_" . $unique_id . "." . $file->getClientOriginalExtension();
                $file->move('uploads/attachments', $filename);

                $milestone->attachment = $filename;
                $milestone->save();
                return redirect()->back()->with("success-v2", "Uploaded attachement");
            } else {
                return redirect()->back()->with("error-v2", "Need attachement");
            }
        }

        return redirect()->back()->with("error-v2", "Unable to upload attachement");
    }
}
