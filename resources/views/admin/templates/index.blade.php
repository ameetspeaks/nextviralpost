@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Prompt Templates</h3>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <a href="{{ route('admin.templates.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Create New Template
                        </a>
                    </div>

                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Post Type</th>
                                <th>Tone</th>
                                <th>Category</th>
                                <th>Post Goal</th>
                                <th>Virality Factor</th>
                                <th>Version</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($templates as $template)
                            <tr>
                                <td>{{ $template->title }}</td>
                                <td>{{ $template->postType->name }}</td>
                                <td>{{ $template->tone->name }}</td>
                                <td>{{ $template->category }}</td>
                                <td>{{ $template->post_goal }}</td>
                                <td>{{ $template->virality_factor }}</td>
                                <td>{{ $template->version }}</td>
                                <td>
                                    <span class="badge badge-{{ $template->is_active ? 'success' : 'danger' }}">
                                        {{ $template->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.templates.edit', $template) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.templates.destroy', $template) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this template?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center">No templates found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{ $templates->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 