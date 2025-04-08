@extends('layouts.app')

@section('content')
<div class="flex h-screen bg-gray-50">
    <!-- Sidebar -->
    <x-sidebar-navigation />

    <!-- Main Content Area -->
    <main class="flex-1 ml-56">
        <div class="py-6">
            <div class="max-w-[1600px] mx-auto px-6">
                <!-- Back Button -->
                <div class="mb-6">
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center text-gray-600 hover:text-gray-900">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to Dashboard
                    </a>
                </div>

                <!-- Header -->
                <div class="text-center mb-12">
                    <h1 class="text-3xl font-bold text-gray-900">Choose Your Plan</h1>
                    <p class="mt-4 text-lg text-gray-600">Select the perfect plan for your content creation needs</p>
                </div>

                <!-- Billing Toggle -->
                <div class="flex justify-center mb-8">
                    <div class="relative flex items-center bg-white p-1 rounded-lg shadow-sm">
                        <button id="monthly" class="px-4 py-2 text-sm font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            Monthly
                        </button>
                        <button id="yearly" class="px-4 py-2 text-sm font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            Yearly (Save 50%)
                        </button>
                    </div>
                </div>

                <!-- Plans Grid -->
                <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
                    @foreach($subscriptions as $subscription)
                        <div class="bg-white rounded-lg shadow-lg overflow-hidden border border-gray-200 {{ $subscription->plan_type === 'free' ? 'border-indigo-500' : '' }}">
                            <div class="p-6">
                                <h3 class="text-2xl font-bold text-gray-900">{{ $subscription->name }}</h3>
                                <div class="mt-4">
                                    <span class="text-4xl font-bold text-gray-900 monthly-price">${{ $subscription->price }}</span>
                                    <span class="text-4xl font-bold text-gray-900 yearly-price hidden">${{ $subscription->calculateYearlyPrice() }}</span>
                                    <span class="text-gray-500">/{{ $subscription->billing_cycle }}</span>
                                </div>
                                <p class="mt-4 text-gray-600">{{ $subscription->credits }} credits per month</p>
                                
                                <ul class="mt-6 space-y-4">
                                    <li class="flex items-center">
                                        <svg class="h-5 w-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span class="ml-3 text-gray-600">AI-powered content generation</span>
                                    </li>
                                    <li class="flex items-center">
                                        <svg class="h-5 w-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span class="ml-3 text-gray-600">Customizable templates</span>
                                    </li>
                                    <li class="flex items-center">
                                        <svg class="h-5 w-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span class="ml-3 text-gray-600">Priority support</span>
                                    </li>
                                </ul>

                                <div class="mt-8">
                                    @if($subscription->plan_type === 'free')
                                        <a href="{{ route('subscription.trial', $subscription) }}" 
                                           class="block w-full text-center px-4 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            Start Free Trial
                                        </a>
                                    @else
                                        <a href="{{ route('subscription.purchase', $subscription) }}" 
                                           class="block w-full text-center px-4 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            Get Started
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- FAQ Section -->
                <div class="mt-16">
                    <h2 class="text-2xl font-bold text-gray-900 text-center mb-8">Frequently Asked Questions</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="bg-white p-6 rounded-lg shadow">
                            <h3 class="text-lg font-medium text-gray-900">How do credits work?</h3>
                            <p class="mt-2 text-gray-600">Each content generation uses 1 credit. Credits are refreshed monthly based on your subscription plan.</p>
                        </div>
                        <div class="bg-white p-6 rounded-lg shadow">
                            <h3 class="text-lg font-medium text-gray-900">Can I upgrade or downgrade?</h3>
                            <p class="mt-2 text-gray-600">Yes, you can change your plan at any time. The changes will take effect at the start of your next billing cycle.</p>
                        </div>
                        <div class="bg-white p-6 rounded-lg shadow">
                            <h3 class="text-lg font-medium text-gray-900">What happens after the trial?</h3>
                            <p class="mt-2 text-gray-600">After your trial, you'll need to choose a paid plan to continue using the service. Your data will be preserved.</p>
                        </div>
                        <div class="bg-white p-6 rounded-lg shadow">
                            <h3 class="text-lg font-medium text-gray-900">Is there a refund policy?</h3>
                            <p class="mt-2 text-gray-600">We offer a 14-day money-back guarantee for all paid plans. Contact support for refund requests.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const monthlyBtn = document.getElementById('monthly');
    const yearlyBtn = document.getElementById('yearly');
    const monthlyPrices = document.querySelectorAll('.monthly-price');
    const yearlyPrices = document.querySelectorAll('.yearly-price');

    monthlyBtn.addEventListener('click', function() {
        monthlyBtn.classList.add('bg-indigo-600', 'text-white');
        yearlyBtn.classList.remove('bg-indigo-600', 'text-white');
        monthlyPrices.forEach(price => price.classList.remove('hidden'));
        yearlyPrices.forEach(price => price.classList.add('hidden'));
    });

    yearlyBtn.addEventListener('click', function() {
        yearlyBtn.classList.add('bg-indigo-600', 'text-white');
        monthlyBtn.classList.remove('bg-indigo-600', 'text-white');
        yearlyPrices.forEach(price => price.classList.remove('hidden'));
        monthlyPrices.forEach(price => price.classList.add('hidden'));
    });

    // Set initial state
    monthlyBtn.classList.add('bg-indigo-600', 'text-white');
});
</script>
@endpush
@endsection 