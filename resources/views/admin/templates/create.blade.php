@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Create New Template</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.templates.store') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required>
                            @error('title')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="post_type_id">Post Type</label>
                            <select name="post_type_id" id="post_type_id" class="form-control @error('post_type_id') is-invalid @enderror" required>
                                <option value="">Select Post Type</option>
                                @foreach($postTypes as $postType)
                                    <option value="{{ $postType->id }}" {{ old('post_type_id') == $postType->id ? 'selected' : '' }}>
                                        {{ $postType->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('post_type_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="tone_id">Tone</label>
                            <select name="tone_id" id="tone_id" class="form-control @error('tone_id') is-invalid @enderror" required>
                                <option value="">Select Tone</option>
                                @foreach($tones as $tone)
                                    <option value="{{ $tone->id }}" {{ old('tone_id') == $tone->id ? 'selected' : '' }}>
                                        {{ $tone->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('tone_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="category">Category</label>
                            <input type="text" name="category" id="category" class="form-control @error('category') is-invalid @enderror" value="{{ old('category') }}" required>
                            @error('category')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="post_goal">Post Goal</label>
                            <input type="text" name="post_goal" id="post_goal" class="form-control @error('post_goal') is-invalid @enderror" value="{{ old('post_goal') }}" required>
                            @error('post_goal')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="virality_factor">Virality Factor</label>
                            <input type="text" name="virality_factor" id="virality_factor" class="form-control @error('virality_factor') is-invalid @enderror" value="{{ old('virality_factor') }}" required>
                            @error('virality_factor')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="content">Content</label>
                            <textarea name="content" id="content" class="form-control @error('content') is-invalid @enderror" rows="10" required>{{ old('content') }}</textarea>
                            @error('content')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="is_active">Active</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Create Template</button>
                            <a href="{{ route('admin.templates.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 