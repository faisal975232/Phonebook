<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Carbon\Carbon;
use App\Models\Contact;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{

    public function listuser(Request $request)
    {

        if (auth()->user()->role == 1) {
            $user = User::get();

            return response([
                'message' => $user
            ], 200);
        } else {
            return response([
                'message' => ['Not authorized']
            ], 401);
        }
    }


    public function registeruser(Request $request)
    {


        if (auth()->user()->role == 1) {


            $validated = array(
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required',
                'role' => 'required'
            );

            $validator = Validator::make($request->all(), $validated);


            if ($validator->fails()) {
                return $validator->errors();
            }


            $check =  User::where('email', '=', $request->email)->get();

            if (!$check->isEmpty()) {
                return response([
                    'message' => ['This email is already registered']
                ], 200);
            }

            $user = User::create(request(['name', 'email', 'password', 'role']));

            return response([
                'message' => ['User has been registered']
            ], 201);
        } else {
            return response([
                'message' => ['Not authorized']
            ], 401);
        }
    }

    public function edituser(Request $request)
    {
        if (auth()->user()->role == 1) {

            $validated = array(
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required',
                'role' => 'required'
            );

            $validator = Validator::make($request->all(), $validated);


            if ($validator->fails()) {
                return $validator->errors();
            }

            $user = User::where("id", '=', $request->id)->update(request(['name', 'email', 'password', 'role']));

            return response([
                'message' => ['User has been updated']
            ], 200);
        } else {
            return response([
                'message' => ['Not authorized']
            ], 401);
        }
    }


    public function deleteuser(Request $request)
    {

        if (auth()->user()->role == 1) {
            $user = User::where("id", '=', $request->id)->delete();

            return response([
                'message' => ['User has been deleted']
            ], 202);
        } else {
            return response([
                'message' => ['Not authorized']
            ], 401);
        }
    }


    public function listcontact(Request $request)
    {

        if (auth()->user()->role == 1) {
            $contacts = Contact::get();

            return response([
                'message' => $contacts
            ], 200);
        } else {
            return response([
                'message' => ['Not authorized']
            ], 401);
        }
    }


    //contacts

    public function addcontact(Request $request)
    {


        if (auth()->user()->role == 1) {


            $validated = array(
                'name' => 'required',
                'number' => 'required',
                'user_id' => 'required',


            );

            $validator = Validator::make($request->all(), $validated);


            if ($validator->fails()) {
                return $validator->errors();
            }

            $contact = Contact::create([
                'contact_name' => $request->name,
                'contact_number' => $request->number,
                'user_id' => $request->user_id,
                'created_at' => Carbon::now()
            ]);

            return response([
                'message' => ['Contact has been added']
            ], 201);
        } else {
            return response([
                'message' => ['Not authorized']
            ], 401);
        }
    }


    public function editcontact(Request $request)
    {


        if (auth()->user()->role == 1) {


            $validated = array(
                'name' => 'required',
                'number' => 'required',
                'user_id' => 'required',

            );

            $validator = Validator::make($request->all(), $validated);


            if ($validator->fails()) {
                return $validator->errors();
            }

            $contact = Contact::where("id", "=", $request->id)->update([
                'contact_name' => $request->name,
                'contact_number' => $request->number,
                'user_id' =>  $request->user_id,
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
                'message' => ['Not authorized']
            ], 401);
        }
    }

    public function deletecontact(Request $request)
    {

        if (auth()->user()->role == 1) {
            $contact = Contact::where("id", '=', $request->id)->delete();

            if (empty($contact)) {
                return response([
                    'message' => ['Contact not found']
                ], 200);
            }

            return response([
                'message' => ['Contact has been deleted']
            ], 202);
        } else {
            return response([
                'message' => ['Not authorized']
            ], 401);
        }
    }


    public function listcontactdashboard(Request $request)
    {

        if (auth()->user()->role == 1) {
            $contacts_total = Contact::get();
            $total_contacts = count($contacts_total);

            $contacts_today = Contact::whereDate('created_at', Carbon::now()->today())->get();
            $total_contacts_today = count($contacts_today);


            $contacts_perweek = Contact::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get();

            $total_contacts_week = count($contacts_perweek);

            $contacts_permonth = Contact::whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->get();

            $total_contacts_month = count($contacts_permonth);
            return response([
                'today' =>  $total_contacts_today,
                'this_week' =>  $total_contacts_week,
                'this_month' =>  $total_contacts_month,
                'total' =>  $total_contacts,

            ], 200);
        } else {
            return response([
                'message' => ['Not authorized']
            ], 401);
        }
    }
}
