<?php

use Illuminate\Http\Request;

/*
Create, Update, Delete contact, Get list of all contacts, get individual contact

Create contact - 
    send: first name, user id, last name, email, phone number, 
    respond: contact url, message, summary

update contact - 
    send: first name, user id, contact id, last name, email,  phone number,
    respond: message, contact url, summary

delete contact -
    send: contact id, user id, 
    respond: message

get list of contacts - 
    send: nothing
    respond: contact info, links to individual contacts

get data about individual contact -
    send: contact id,
    respond: contact info, link to list of contacts
create user - 
    send: first name, last name, email, password
    respond: message, summary
*/

Route::group(['prefix' => 'v1'], function() {
    Route::resource('contact', 'ContactController', [
        'except' => ['edit', 'create']
    ]);
    
    Route::post('user', [
        'uses' => 'AuthController@store'
    ]);
    
    Route::post('user/signin', [
        'uses' => 'AuthController@signin'
    ]);
});