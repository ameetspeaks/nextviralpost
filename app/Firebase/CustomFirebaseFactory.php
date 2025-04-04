<?php

namespace App\Firebase;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Auth;
use Kreait\Firebase\Database;
use GuzzleHttp\Client;

class CustomFirebaseFactory
{
    /**
     * Create a new Firebase Auth instance.
     *
     * @param string $credentialsPath
     * @param string $projectId
     * @return \Kreait\Firebase\Auth
     */
    public static function createAuth($credentialsPath, $projectId)
    {
        $factory = (new Factory)
            ->withServiceAccount($credentialsPath)
            ->withProjectId($projectId)
            ->withVerifyHost(false)
            ->withDisabledCertificateVerification();
            
        return $factory->createAuth();
    }
    
    /**
     * Create a new Firebase Database instance.
     *
     * @param string $credentialsPath
     * @param string $projectId
     * @return \Kreait\Firebase\Database
     */
    public static function createDatabase($credentialsPath, $projectId)
    {
        $factory = (new Factory)
            ->withServiceAccount($credentialsPath)
            ->withProjectId($projectId)
            ->withVerifyHost(false)
            ->withDisabledCertificateVerification();
            
        return $factory->createDatabase();
    }
} 