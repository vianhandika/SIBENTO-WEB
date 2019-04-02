<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\SessionToken;
use App\User;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Exceptions\InvalidTokenException;
use App\Transformers\SessionTransformers;
use App\Transformers\UserTransformers;
use App\Exceptions\InvalidCredentialException;
use Hash;
use App\Events\SessionRefresh;

class SessionController extends RestController
{
    protected $transformer = SessionTransformers::class;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request)
    {
        try {
            $user = $this->validateUser($request->get('username'), $request->get('password'));
            $now = Carbon::now();

            $session = new SessionToken;

            $session->id_user=$user->id_user;
            $session->encrypt_username=str_random(32);
            $session->encrypt_password=str_random(32);
            $session->save();

            $response = $this->generateItem($session, new SessionTransformers);
            
            return $this->sendResponse($response);

        } catch (InvalidCredentialExcpetion $e) {
            return $this->sendNotAuthorizeResponse($e->getMessage());
        } catch (\Exception $e) {
            throw $e;
        }
    }
    public function mobileauthenticate(Request $request)
    {
        try {
            $user = $this->validateUser($request->get('username'), $request->get('password'));

            $response = $this->generateItem($user,UserTransformers::class);

            return $this->sendResponse($response, 201);

        } catch (InvalidCredentialExcpetion $e) {
            return $this->sendNotAuthorizeResponse($e->getMessage());
        } catch (\Exception $e) {
            throw $e;
        }
    }
    public function validateUser($username,$password)
    {
        try{
            $user = User::where('username',$username)->firstOrFail();

            if(!password_verify($password, $user->password)){
                throw new InvalidCredentialException();
            }

            return $user;
        } catch(ModelNotFoundException $e) {
            return $this->sendIseResponse($e->getMessage());
        }
    }

    public function validateSession(Request $request)
    {
        try {
            $header = $request->header('Authorization');
            list($type, $payload) = explode(" ", $header);
            list($username, $password) = explode(":", base64_decode($payload));
            $session = SessionToken::where('encrypt_username', $username)->first();
            $user = User::find($session->id_user);
            event(new SessionRefresh($session));
            $item = $this->generateItem($user,UserTransformers::class);

            return $this->sendResponse($item);

        } catch (InvalidTokenException $e) {
            throw $e; 
        } catch (\Exception $e) {
            throw $e;
            return $this->sendNotAuthorizeResponse($e->getMessage());
        } 
    }

    public function index()
    {
        $session = SessionToken::all();
        $response = $this->generateCollection($session);
        return $this->sendResponse($response);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
