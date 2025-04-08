@extends('layouts.superadmin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Edit Subscription Plan</h1>
        <a href="{{ route('admin.subscription-plans.index') }}" class="text-gray-600 hover:text-gray-900">
            Back to Plans
        </a>
    </div>

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white shadow-md rounded-lg p-6">
        <form action="{{ route('admin.subscription-plans.update', $plan) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Plan Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $plan->name) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                </div>

                <div>
                    <label for="plan_type" class="block text-sm font-medium text-gray-700">Plan Type</label>
                    <select name="plan_type" id="plan_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                        <option value="free" {{ old('plan_type', $plan->plan_type) == 'free' ? 'selected' : '' }}>Free</option>
                        <option value="paid" {{ old('plan_type', $plan->plan_type) == 'paid' ? 'selected' : '' }}>Paid</option>
                    </select>
                </div>

                <div>
                    <label for="duration" class="block text-sm font-medium text-gray-700">Duration (days)</label>
                    <input type="number" name="duration" id="duration" value="{{ old('duration', $plan->duration) }}" min="1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                </div>

                <div>
                    <label for="credits" class="block text-sm font-medium text-gray-700">Credits</label>
                    <input type="number" name="credits" id="credits" value="{{ old('credits', $plan->credits) }}" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                </div>

                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                    <input type="number" name="price" id="price" value="{{ old('price', $plan->price) }}" min="0" step="0.01" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                </div>

                <div>
                    <label for="billing_cycle" class="block text-sm font-medium text-gray-700">Billing Cycle</label>
                    <select name="billing_cycle" id="billing_cycle" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                        <option value="month" {{ old('billing_cycle', $plan->billing_cycle) == 'month' ? 'selected' : '' }}>Monthly</option>
                        <option value="year" {{ old('billing_cycle', $plan->billing_cycle) == 'year' ? 'selected' : '' }}>Yearly</option>
                    </select>
                </div>

                <div>
                    <label for="discount_percentage" class="block text-sm font-medium text-gray-700">Discount Percentage</label>
                    <input type="number" name="discount_percentage" id="discount_percentage" value="{{ old('discount_percentage', $plan->discount_percentage) }}" min="0" max="100" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div class="flex items-center">
                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $plan->is_active) ? 'checked' : '' }} class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="is_active" class="ml-2 block text-sm text-gray-900">Active Plan</label>
                </div>
            </div>

            <div class="mt-6 flex justify-between">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                    Update Plan
                </button>
                <button type="button" onclick="confirmDelete()" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors">
                    Delete Plan
                </button>
            </div>
        </form>

        <form id="delete-form" action="{{ route('admin.subscription-plans.destroy', $plan) }}" method="POST" class="hidden">
            @csrf
            @method('DELETE')
        </form>
    </div>
</div>

@push('scripts')
<script>
function confirmDelete() {
    if (confirm('Are you sure you want to delete this subscription plan? This action cannot be undone.')) {
        document.getElementById('delete-form').submit();
    }
}
</script>
@endpush
@endsection 