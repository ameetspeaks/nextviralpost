<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Complete Your Profile - NextViralPost</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f7ff;
        }
        .gradient-text {
            background: linear-gradient(90deg, #00C6FF 0%, #7B66FF 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .option-button {
            transition: all 0.2s ease;
        }
        .option-button.selected {
            background-color: #EEF2FF;
            border-color: #6366F1;
            color: #6366F1;
        }
    </style>
</head>
<body>
    <div class="min-h-screen flex">
        <!-- Left Side - Image -->
        <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-indigo-500/20 to-purple-500/20"></div>
            <img src="https://images.unsplash.com/photo-1600880292203-757bb62b4baf?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1770&q=80" 
                 class="object-cover w-full h-full" alt="People celebrating success">
            <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/60 to-transparent p-8">
                <div class="max-w-md">
                    <h3 class="text-white text-2xl font-bold mb-2">Join our community of creators</h3>
                    <p class="text-gray-200">Get personalized content recommendations and start creating viral content today.</p>
                </div>
            </div>
        </div>

        <!-- Right Side - Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8">
            <div class="w-full max-w-md">
                <h1 class="text-4xl font-bold mb-2">
                    <span class="gradient-text">Let's get to know you better!</span>
                </h1>
                <p class="text-gray-600 mb-8">Help us personalize your experience</p>

                <form id="onboardingForm" class="space-y-8">
                    @csrf
                    <!-- Role Selection -->
                    <div>
                        <label class="block text-lg font-semibold text-gray-900 mb-4">I am a...</label>
                        <div class="grid grid-cols-2 gap-3">
                            @foreach($roles as $role)
                            <button type="button" class="option-button text-left px-4 py-3 border-2 rounded-xl hover:border-indigo-600 hover:bg-indigo-50" data-role-id="{{ $role->id }}">
                                <span class="font-medium">{{ $role->name }}</span>
                            </button>
                            @endforeach
                        </div>
                    </div>

                    <!-- Industry Selection -->
                    <div>
                        <label for="industry" class="block text-lg font-semibold text-gray-900 mb-4">Your Industry</label>
                        <select id="industry" name="industry_id" class="w-full px-4 py-3 rounded-xl border-2 border-gray-300 focus:border-indigo-600 focus:ring-0">
                            <option value="">Select your industry</option>
                            @foreach($industries as $industry)
                            <option value="{{ $industry->id }}">{{ $industry->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Interest Selection -->
                    <div>
                        <label class="block text-lg font-semibold text-gray-900 mb-4">I want to go viral on...</label>
                        <div class="grid grid-cols-2 gap-3">
                            @foreach($interests as $interest)
                            <button type="button" class="option-button text-left px-4 py-3 border-2 rounded-xl hover:border-indigo-600 hover:bg-indigo-50" data-interest-id="{{ $interest->id }}">
                                <span class="font-medium">{{ $interest->name }}</span>
                            </button>
                            @endforeach
                        </div>
                    </div>

                    <div id="error-message" class="hidden text-red-500 text-sm text-center"></div>

                    <button type="submit" id="submit-button" class="w-full bg-indigo-600 text-white rounded-xl px-4 py-3 font-medium hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2 transition-colors">
                        Complete Profile
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Handle button selections
        document.querySelectorAll('.option-button').forEach(button => {
            button.addEventListener('click', function() {
                const isInterest = this.dataset.interestId !== undefined;
                if (!isInterest) {
                    // Single select for roles
                    document.querySelectorAll('[data-role-id]').forEach(btn => {
                        btn.classList.remove('selected');
                    });
                }
                this.classList.toggle('selected');
            });
        });

        // Handle form submission
        document.getElementById('onboardingForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const submitButton = document.getElementById('submit-button');
            const errorMessage = document.getElementById('error-message');
            
            // Get selected values
            const selectedRole = document.querySelector('.option-button[data-role-id].selected')?.dataset.roleId;
            const selectedIndustry = document.getElementById('industry').value;
            const selectedInterests = Array.from(document.querySelectorAll('.option-button[data-interest-id].selected'))
                .map(button => button.dataset.interestId);

            // Validate selections
            if (!selectedRole || !selectedIndustry || selectedInterests.length === 0) {
                errorMessage.textContent = 'Please complete all sections before proceeding.';
                errorMessage.classList.remove('hidden');
                return;
            }

            // Disable submit button and show loading state
            submitButton.disabled = true;
            submitButton.innerHTML = `
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Saving...
            `;

            // Create FormData object
            const formData = new FormData();
            formData.append('role_id', selectedRole);
            formData.append('industry_id', selectedIndustry);
            selectedInterests.forEach(interestId => {
                formData.append('interest_ids[]', interestId);
            });
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);

            // Submit data
            fetch('/onboarding', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    if (response.status === 419) {
                        throw new Error('CSRF token mismatch. Please refresh the page and try again.');
                    }
                    return response.json().then(data => {
                        throw new Error(data.message || 'An error occurred');
                    });
                }
                return response.json();
            })
            .then(data => {
                if (data.errors) {
                    errorMessage.textContent = Object.values(data.errors).flat().join(', ');
                    errorMessage.classList.remove('hidden');
                } else if (data.redirect) {
                    window.location.href = data.redirect;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                errorMessage.textContent = error.message || 'An error occurred. Please try again.';
                errorMessage.classList.remove('hidden');
            })
            .finally(() => {
                submitButton.disabled = false;
                submitButton.innerHTML = 'Complete Profile';
            });
        });
    </script>
</body>
</html> 