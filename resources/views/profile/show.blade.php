<x-app-layout>
    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Profile Settings</h1>
            <button id="editToggleBtn" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2 transition-colors">
                Edit Profile
            </button>
        </div>

        <!-- Profile Form -->
        <form id="profileForm" action="{{ route('profile.update') }}" method="POST" class="space-y-8">
            @csrf
            @method('patch')
            
            <!-- Basic Information -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <h2 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Basic Information
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                        <input type="text" id="name" name="name" value="{{ $user->name }}" disabled
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 bg-gray-50 text-gray-700 focus:ring-indigo-500 focus:border-indigo-500">
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                        <input type="email" id="email" name="email" value="{{ $user->email }}" disabled
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 bg-gray-50 text-gray-700 focus:ring-indigo-500 focus:border-indigo-500">
                        <x-input-error class="mt-2" :messages="$errors->get('email')" />
                    </div>
                </div>
            </div>

            <!-- Professional Information -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <h2 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    Professional Information
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="role_id" class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                        <select id="role_id" name="role_id" disabled
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 bg-gray-50 text-gray-700 focus:ring-indigo-500 focus:border-indigo-500">
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ $userPreferences?->role_id == $role->id ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('role_id')" />
                    </div>
                    <div>
                        <label for="industry_id" class="block text-sm font-medium text-gray-700 mb-1">Industry</label>
                        <select id="industry_id" name="industry_id" disabled
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 bg-gray-50 text-gray-700 focus:ring-indigo-500 focus:border-indigo-500">
                            @foreach($industries as $industry)
                                <option value="{{ $industry->id }}" {{ $userPreferences?->industry_id == $industry->id ? 'selected' : '' }}>
                                    {{ $industry->name }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('industry_id')" />
                    </div>
                </div>
            </div>

            <!-- Interests -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <h2 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                    Interests
                </h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach($interests as $interest)
                        <label class="relative flex items-start p-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                            <div class="flex items-center h-5">
                                <input type="checkbox" name="interest_ids[]" value="{{ $interest->id }}"
                                    {{ in_array($interest->id, $userInterests) ? 'checked' : '' }}
                                    disabled
                                    class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            </div>
                            <div class="ml-3 text-sm">
                                <span class="text-gray-700">{{ $interest->name }}</span>
                            </div>
                        </label>
                    @endforeach
                </div>
                <x-input-error class="mt-2" :messages="$errors->get('interest_ids')" />
            </div>

            <!-- Change Password -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <h2 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    Change Password
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">Current Password</label>
                        <input type="password" id="current_password" name="current_password" disabled
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 bg-gray-50 text-gray-700 focus:ring-indigo-500 focus:border-indigo-500">
                        <x-input-error class="mt-2" :messages="$errors->get('current_password')" />
                    </div>
                    <div>
                        <label for="new_password" class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                        <input type="password" id="new_password" name="new_password" disabled
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 bg-gray-50 text-gray-700 focus:ring-indigo-500 focus:border-indigo-500">
                        <x-input-error class="mt-2" :messages="$errors->get('new_password')" />
                    </div>
                    <div>
                        <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password</label>
                        <input type="password" id="new_password_confirmation" name="new_password_confirmation" disabled
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 bg-gray-50 text-gray-700 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                </div>
            </div>

            <!-- Error Message -->
            <div id="error-message" class="hidden bg-red-50 text-red-600 p-4 rounded-lg border border-red-200"></div>

            <!-- Success Message -->
            <div id="success-message" class="hidden bg-green-50 text-green-600 p-4 rounded-lg border border-green-200"></div>

            <!-- Submit Button - Hidden by default -->
            <div id="submitButtonContainer" class="flex justify-end hidden">
                <button type="submit" class="px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2 transition-colors flex items-center">
                    <span class="loading-spinner hidden mr-2">
                        <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </span>
                    <span class="button-text">Save Changes</span>
                </button>
            </div>
        </form>

        <!-- Delete Account Section - Hidden -->
        <div class="mt-8 bg-white rounded-lg shadow-sm p-6 hidden">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Delete Account</h2>
            <p class="text-gray-600 mb-4">Once your account is deleted, all of its resources and data will be permanently deleted.</p>
            <button id="deleteAccountBtn" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-600 focus:ring-offset-2 transition-colors">
                Delete Account
            </button>
        </div>

        <!-- Delete Account Modal -->
        <div id="deleteAccountModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center hidden z-50">
            <div class="bg-white rounded-lg p-6 max-w-md w-full">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Are you sure you want to delete your account?</h3>
                <p class="text-gray-600 mb-6">This action cannot be undone. All your data will be permanently deleted.</p>
                <form method="post" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('delete')
                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <input type="password" id="password" name="password" required
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                        <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" id="cancelDeleteBtn" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2 transition-colors">
                            Cancel
                        </button>
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-600 focus:ring-offset-2 transition-colors">
                            Delete Account
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const editToggleBtn = document.getElementById('editToggleBtn');
        const submitButtonContainer = document.getElementById('submitButtonContainer');
        const formInputs = document.querySelectorAll('#profileForm input:not([type="hidden"]), #profileForm select');
        const deleteAccountBtn = document.getElementById('deleteAccountBtn');
        const deleteAccountModal = document.getElementById('deleteAccountModal');
        const cancelDeleteBtn = document.getElementById('cancelDeleteBtn');
        const profileForm = document.getElementById('profileForm');
        const errorMessage = document.getElementById('error-message');
        const successMessage = document.getElementById('success-message');
        
        let isEditMode = false;
        
        // Toggle edit mode
        editToggleBtn.addEventListener('click', function() {
            isEditMode = !isEditMode;
            
            if (isEditMode) {
                // Enable form inputs
                formInputs.forEach(input => {
                    input.disabled = false;
                    input.classList.remove('bg-gray-50');
                    input.classList.add('bg-white');
                });
                
                // Show submit button
                submitButtonContainer.classList.remove('hidden');
                
                // Change button text
                editToggleBtn.textContent = 'Cancel Editing';
                editToggleBtn.classList.remove('bg-indigo-600');
                editToggleBtn.classList.add('bg-gray-600');
            } else {
                // Disable form inputs
                formInputs.forEach(input => {
                    input.disabled = true;
                    input.classList.remove('bg-white');
                    input.classList.add('bg-gray-50');
                });
                
                // Hide submit button
                submitButtonContainer.classList.add('hidden');
                
                // Change button text
                editToggleBtn.textContent = 'Edit Profile';
                editToggleBtn.classList.remove('bg-gray-600');
                editToggleBtn.classList.add('bg-indigo-600');
                
                // Reset form
                profileForm.reset();
            }
        });
        
        // Handle form submission
        profileForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Show loading state
            const submitButton = submitButtonContainer.querySelector('button');
            const buttonText = submitButton.querySelector('.button-text');
            const loadingSpinner = submitButton.querySelector('.loading-spinner');
            
            buttonText.textContent = 'Saving...';
            loadingSpinner.classList.remove('hidden');
            submitButton.disabled = true;
            
            // Hide any previous messages
            errorMessage.classList.add('hidden');
            successMessage.classList.add('hidden');
            
            // Submit form
            fetch(profileForm.action, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify(Object.fromEntries(new FormData(profileForm)))
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success message
                    successMessage.textContent = 'Profile updated successfully!';
                    successMessage.classList.remove('hidden');
                    
                    // Exit edit mode
                    editToggleBtn.click();
                    
                    // Reload page after 2 seconds
                    setTimeout(() => {
                        window.location.reload();
                    }, 2000);
                } else {
                    // Show error message
                    if (data.errors) {
                        const errorMessages = Object.values(data.errors).flat().join(', ');
                        errorMessage.textContent = errorMessages;
                    } else {
                        errorMessage.textContent = 'An error occurred while updating your profile.';
                    }
                    errorMessage.classList.remove('hidden');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                errorMessage.textContent = 'An error occurred while updating your profile.';
                errorMessage.classList.remove('hidden');
            })
            .finally(() => {
                // Reset button state
                buttonText.textContent = 'Save Changes';
                loadingSpinner.classList.add('hidden');
                submitButton.disabled = false;
            });
        });
        
        // Show delete account modal
        deleteAccountBtn.addEventListener('click', function() {
            deleteAccountModal.classList.remove('hidden');
        });
        
        // Hide delete account modal
        cancelDeleteBtn.addEventListener('click', function() {
            deleteAccountModal.classList.add('hidden');
        });
        
        // Close modal when clicking outside
        deleteAccountModal.addEventListener('click', function(e) {
            if (e.target === deleteAccountModal) {
                deleteAccountModal.classList.add('hidden');
            }
        });
    });
    </script>
    @endpush
</x-app-layout> 