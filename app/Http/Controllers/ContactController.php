<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $contacts = Contact::all();
        return view('contact.index');
        //
    }


    public function store(Request $request)
    {
        $request->validate([
            'your-name'     => 'required|string|max:255',
            'your-email'    => 'required|email|string|max:255',
            'your-subject'  => 'required|string|max:255',
            'your-message'  => 'nullable|string|max:2000',
        ], [
            'your-name.required'    => 'Vui lòng nhập Tên của bạn.',
            'your-name.max'         => 'Tên không được vượt quá 255 ký tự.',
            'your-email.required'   => 'Vui lòng nhập Email.',
            'your-email.email'      => 'Địa chỉ Email không hợp lệ.',
            'your-subject.required' => 'Vui lòng nhập Tiêu đề.',
            'your-message.max'      => 'Nội dung không được vượt quá 2000 ký tự.',
        ]);

        return redirect()->route('contact.index')->with('success', '✅ Đăng ký nhận tin thành công');
    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */

    public function show(Contact $contact)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contact $contact)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contact $contact)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {
        //
    }
}
