<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use App\Models\Contact;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    function index(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        // print_r($data);
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response([
                'message' => ['These credentials do not match our records.']
            ], 404);
        }

        $token = $user->createToken('my-app-token')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }



    public function listcontact(Request $request)
    {

        if (auth()->user()->role == 2) {
            $contacts = Contact::where('user_id', '=', auth()->user()->id)->get();

            return response([
                'message' => $contacts
            ], 200);
        } else {
            return response([
                'message' => ['Not authorized']
            ], 401);
        }
    }




    public function addcontact(Request $request)
    {


        if (auth()->user()->role == 2) {


            // $validation = Validator::make($request->all(), [
            //     'name' => 'required|max:256',
            //     'number' => 'required|max:256',

            // ]);


            // if ($validation->fails()) {
            //     return $validation->errors();
            // }


            $input = $request->all();


            for ($i = 0; $i <= count($input); $i++) {
                if (empty($input[$i])) continue;


                $isInserted =   Contact::create([
                    'contact_name'   => $input[$i]['name'],
                    'contact_number' =>  $input[$i]['number'],
                    'user_id' => auth()->user()->id,
                    'created_at' => Carbon::now()
                ]);
            }




            return response([
                'message' => ['Contact has been added']
            ], 201);
        } else {
            return response([
                'message' => ['Not authorized, If you are admin please add from admin API']
            ], 401);
        }
    }


    public function editcontact(Request $request)
    {


        if (auth()->user()->role == 2) {


            $validated = array(
                'name' => 'required',
                'number' => 'required',

            );

            $validator = Validator::make($request->all(), $validated);


            if ($validator->fails()) {
                return $validator->errors();
            }

            $contact = Contact::where("id", "=", $request->id)->where('user_id', '=', auth()->user()->id)->update([
                'contact_name' => $request->name,
                'contact_number' => $request->number,
                'user_id' => auth()->user()->id,
                'updated_at' => Carbon::now()
            ]);


            if (empty($contact)) {
                return response([
                    'message' => ['Contact not found']
                ], 200);
            }

            return response([
                'message' => ['Contact has been updated']
            ], 200);
        } else {
            return response([
                'message' => ['Not authorized, If you are admin please update from admin API']
            ], 401);
        }
    }

    public function deletecontact(Request $request)
    {

        if (auth()->user()->role == 2) {
            $contact = Contact::where('user_id', '=', auth()->user()->id)->where("id", '=', $request->id)->delete();

            if (empty($contact)) {
                return response([
                    'message' => ['Contact not found']
                ], 200);
            }

            return response([
                'message' => ['Contact has been deleted']
            ], 200);
        } else {
            return response([
                'message' => ['Not authorized, If you are admin please delete from admin API']
            ], 401);
        }
    }
}
