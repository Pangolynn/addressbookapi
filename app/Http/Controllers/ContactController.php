<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contact;
use Auth;
use App\User;

class ContactController extends Controller
{
    public function __construct()
    {
        // This middleware applies to all actions.
        // $this->middleware('name');
    }

    /**
     * Display a listing of the contacts.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contacts = Contact::all();

        foreach ($contacts as $contact) {
            // Add property to each contact with 
            // the correct url to view them
            $contact->view_contact = [
                'href' => 'api/v1/contact/' . $contact->id,
                'method' => 'GET'
            ];
        }

        $response = [
            'msg' => 'Contact Index',
            'contacts' => $contacts
        ];

        return response()->json($response, 200);
    }

    /**
     * Store a newly created contact in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

        $name = $request->input('name');
        $phone_number= $request->input('phone_number');
        $email= $request->input('email');

        $user = User::find(1);

        $contact = new Contact([
            'name' => $name,
            'phone_number' => $phone_number,
            'email' => $email,
        ]);


        if($user) {
            if($user->contacts()->save($contact)) {
                $contact->view_contact = [
                    'href' => 'api/v1/contact/' . $contact->id,
                    'method' => 'GET'
                ];

                $message = [
                    'msg' => 'Contact created!',
                    'contact' => $contact
                ];


                return response()->json($message, 201);
            }
        }
        $response = [
            'msg' => 'An error occured during contact creation.',
        ];

        return response()->json($response, 404);
    }

    /**
     * Display the specified contact.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $contact = Contact::findOrFail($id);

        $response = [
            'msg' => 'Contact information',
            'contact' => $contact
        ];

        return response()->json($response, 200);
    }

    /**
     * Update the specified contact in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

        $name = $request->input('name');
        $phone_number= $request->input('phone_number');
        $email= $request->input('email');
        $user_id = $request->input('user_id');

        $contact = Contact::findOrFail($id);

        // Check if user owns contact
        if($contact->user->id != $user_id) {
            return response()->json(['msg' => 'contact does not belong to user'], 401);
        }

        $contact->name = $name;
        $contact->phone_number = $phone_number;
        $contact->email = $email;

        if(!$contact->update()) {
            return response()->json(['msg' => 'Error during update'], 404);
        }

        $contact->view_contact = [
            'href' => 'api/v1/contact/'. $contact->id,
            'method' => 'GET'
        ];

        $response = [
            'msg' => 'Contact updated!',
            'contact' => $contact
        ];

        return response()->json($response, 201);
    }

    /**
     * Remove the specified contact from the database.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // TODO: Make sure to check if user owns contact

        $contact = Contact::findOrFail($id);

        if(!$contact->delete()) {
            return response()->json(['msg' => 'Delete failed'], 404);
        }

        $response = [
            'msg' => 'Contact deleted!',
            'create' => [
                'href' => 'api/v1/contact',
                'method' => 'POST',
                'params' => 'name, phone_number, email'
            ]
        ];

        return response()->json($response, 200);
    }
}
