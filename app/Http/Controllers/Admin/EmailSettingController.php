<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmailTemplate;

use App\Models\Category;
use App\Models\ProductReview;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\URL;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class EmailSettingController extends Controller
{
    /**
     * Email templates ka list show karne ka function
     */
    // public function index()
    // {
    //     $templates = EmailTemplate::all();
    //     return view('admin.email_templates.index', compact('templates'));
    // }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = EmailTemplate::select('id', 'name', 'subject', 'updated_at')->get();

            $data = [];
            foreach ($query as $value) {
                // Edit Button
                $editUrl = route('admin.email_templates.edit', $value->id);
                $action = '<a class="btn btn-sm btn-info" href="' . $editUrl . '">
                            <i class="fas fa-edit"></i> Edit
                        </a>';

                $data[] = [
                    'id' => $value->id,
                    'name' => $value->name,
                    'subject' => $value->subject,
                    'updated_at' => $value->updated_at->format('Y-m-d H:i:s'),
                    'action' => $action,
                ];
            }

            return response()->json([
                "draw" => intval($request->draw),
                "recordsTotal" => count($query),
                "recordsFiltered" => count($query),
                'data' => $data,
            ]);
        }

        return view('admin.email_templates.index');
    }

    public function edit($id)
    {
        $template = EmailTemplate::findOrFail($id);
        return view('admin.email_templates.edit', compact('template'));
    }

    /**
     * Email template update karne ka function
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'content' => 'required',
        ]);

        $template = EmailTemplate::findOrFail($id);
        $template->update([
            'subject' => $request->subject,
            'body' => $request->content,
        ]);

        return redirect()->route('admin.email.index')->with('success', 'Email Template Updated Successfully');
    }
}
