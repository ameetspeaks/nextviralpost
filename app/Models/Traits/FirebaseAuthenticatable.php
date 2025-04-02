<?php

namespace App\Models\Traits;

use Kreait\Firebase\Contract\Auth;

trait FirebaseAuthenticatable
{
    /**
     * Get the Firebase Auth instance.
     *
     * @return Auth
     */
    protected function getFirebaseAuth()
    {
        return app('firebase.auth');
    }

    /**
     * Create a new Firebase user.
     *
     * @param array $data
     * @return \Kreait\Firebase\Auth\UserRecord
     */
    public function createFirebaseUser(array $data)
    {
        $userProperties = [
            'email' => $data['email'],
            'emailVerified' => false,
            'password' => $data['password'],
            'displayName' => $data['full_name'] ?? null,
            'disabled' => false,
        ];

        return $this->getFirebaseAuth()->createUser($userProperties);
    }

    /**
     * Update the Firebase user.
     *
     * @param array $data
     * @return \Kreait\Firebase\Auth\UserRecord
     */
    public function updateFirebaseUser(array $data)
    {
        $updates = [];

        if (isset($data['email'])) {
            $updates['email'] = $data['email'];
        }

        if (isset($data['password'])) {
            $updates['password'] = $data['password'];
        }

        if (isset($data['full_name'])) {
            $updates['displayName'] = $data['full_name'];
        }

        if (isset($data['email_verified'])) {
            $updates['emailVerified'] = $data['email_verified'];
        }

        return $this->getFirebaseAuth()->updateUser($this->firebase_uid, $updates);
    }

    /**
     * Delete the Firebase user.
     *
     * @return void
     */
    public function deleteFirebaseUser()
    {
        $this->getFirebaseAuth()->deleteUser($this->firebase_uid);
    }
} 