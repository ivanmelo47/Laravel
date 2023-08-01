<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function AdminDashboard()
    {
        
        return view('admin.index');
    } //End Method

    public function AdminLogout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/admin/login');
    } //End Method

    public function AdminLogin()
    {

        return view('admin.admin_login');
    } //End Method

    public function AdminProfile()
    {

        $currentDate = Carbon::now()->format('F d, Y');
        $id = Auth::user()->id;
        $profileData = User::find($id);

        return view('admin.admin_profile_view', compact('profileData', 'currentDate'));
    } //End Method

    public function AdminProfileStore(Request $request)
    {
        $id = Auth::user()->id;

        // Validaciónde los campos
        $validator = Validator::make($request->all(), [
            'username' => [
                'required',
                Rule::unique('users', 'username')->ignore($id, 'id'),
            ],
            'name' => [
                'required',
                Rule::unique('users', 'name')->ignore($id, 'id'),
            ],
            'email' => [
                'required','email',
                Rule::unique('users', 'email')->ignore($id, 'id'),
            ],

            'phone' => 'required|regex:/^[\d\s-]{7,20}$/',
            'address' => 'required|min:10',

            'photo' => [
                'nullable', // Permite que el campo esté vacío
                'image',
                'mimes:jpeg,png,jpg,gif',
                'max:2048',
            ]
        ]);

        // Comprueba si la validación falla
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        $data = User::find($id);
        $data->username = $request->username;
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;

        /* Images Control */
        if ($request->file('photo')) {
            //Obtener el archivo photo
            $photo = $request->file('photo');

            //Elimar la imagen anterior del servidor
            if ($data->photo) {
                $ruteOldPhoto = public_path('upload/admin_images/' . $data->photo);
                if (file_exists($ruteOldPhoto)) {
                    unlink($ruteOldPhoto);
                }
            }

            //Nombre de la nueva imagen
            $photoName = Str::random(30) . '_' . time() . '.' . $photo->getClientOriginalExtension();

            // Sube y actualiza el nombre de la nueva photo
            $directorio = public_path('upload/admin_images/');
            $imagenRecortada = Image::make($photo)->fit(600, 600);
            $imagenRecortada->save($directorio . $photoName);
            $data->photo = $photoName;
        }

        $data->update();

        $notification = array(
            'message' => 'Admin Profile Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    } //End Method
}