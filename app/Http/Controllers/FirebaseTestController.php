<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Firebase\CustomFirebaseFactory;
use Exception;

class FirebaseTestController extends Controller
{
    public function testConnection()
    {
        try {
            // Initialize Firebase using our custom factory
            $auth = CustomFirebaseFactory::createAuth(
                storage_path('app/firebase/firebase_credentials.json'),
                'viralpost-d4d25'
            );
            
            // Try to list users (limited to 1) to test connection
            $users = $auth->listUsers(1);
            
            // Count users using the correct method
            $userCount = 0;
            foreach ($users as $user) {
                $userCount++;
            }
            
            return response()->json([
                'status' => 'success',
                'message' => 'Firebase connection successful',
                'project_id' => 'viralpost-d4d25',
                'users_count' => $userCount
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Firebase connection failed: ' . $e->getMessage(),
                'project_id' => 'viralpost-d4d25',
                'credentials_path' => storage_path('app/firebase/firebase_credentials.json')
            ], 500);
        }
    }
} 