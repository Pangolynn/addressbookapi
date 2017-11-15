<?php

namespace App\Http\Controllers;

use Auth;

use Illuminate\Http\Request;

use App\Http\Requests\UpdateContact;
use App\Http\Requests\StoreContact;

use App\Contact;
use App\User;
use JWTAuth;


class ContactController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.auth');
    }

    /**
     * Display a listing of the contacts.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = $this->getAuthenticatedUser()->getData();
        $user_id = $user->id;
        $contacts = User::findOrFail($user_id)->contacts;
        
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
    public function store(StoreContact $request)
    {
        $name = $request->input('name');
        $phone_number= $request->input('phone_number');
        $email= $request->input('email');

        $user = $this->getAuthenticatedUser()->getData();
        $user_id = $user->id;

        $user = User::findOrFail($user_id);
        
        $contact = new Contact([
            'name' => $name,
            'phone_number' => $phone_number,
            'email' => $email,
        ]);

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
        $user = $this->getAuthenticatedUser()->getData();
        $user_id = $user->id;
        $contact = User::findOrFail($user_id)->contacts()->where('id', $id)->firstOrFail();

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
    public function update(UpdateContact $request, $id)
    {
        $name = $request->input('name');
        $phone_number= $request->input('phone_number');
        $email= $request->input('email');
        
        $user = $this->getAuthenticatedUser()->getData();
        $user_id = $user->id;
        $contact = User::findOrFail($user_id)->contacts()->where('id', $id)->firstOrFail();

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
        $contact = Contact::findOrFail($id);

        $user = $this->getAuthenticatedUser()->getData();
        $user_id = $user->id;

        // Check if contact belongs to user.
        if($contact->user->id != $user_id) {
            return response()->json(['msg' => 'Contact does not belong to user'], 401);
        }

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

    /**
     * The name says it all
     * @return \Illuminate\Http\Response
     */
    public function getAuthenticatedUser()
    {
        try {
            if(! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['token_absent'], $e->getStatusCode());
        }

        // token is valid, found user via sub claim
        return response()->json($user, 200);
    }

}
