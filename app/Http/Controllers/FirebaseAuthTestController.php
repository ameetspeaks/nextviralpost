<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Auth as FirebaseAuth;
use Exception;

class FirebaseAuthTestController extends Controller
{
    protected $auth;

    public function __construct(FirebaseAuth $auth)
    {
        $this->auth = $auth;
    }

    public function testSignUp(Request $request)
    {
        try {
            $email = $request->input('email', 'test@example.com');
            $password = $request->input('password', 'password123');
            
            $userProperties = [
                'email' => $email,
                'emailVerified' => false,
                'password' => $password,
                'displayName' => 'Test User',
            ];

            $createdUser = $this->auth->createUser($userProperties);
            
            return response()->json([
                'status' => 'success',
                'message' => 'User created successfully',
                'user' => [
                    'uid' => $createdUser->uid,
                    'email' => $createdUser->email,
                    'displayName' => $createdUser->displayName
                ]
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function testSignIn(Request $request)
    {
        try {
            $email = $request->input('email', 'test@example.com');
            $password = $request->input('password', 'password123');
            
            $signInResult = $this->auth->signInWithEmailAndPassword($email, $password);
            
            return response()->json([
                'status' => 'success',
                'message' => 'User signed in successfully',
                'user' => [
                    'uid' => $signInResult->data()['localId'],
                    'email' => $signInResult->data()['email'],
                    'idToken' => $signInResult->data()['idToken']
                ]
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
} 