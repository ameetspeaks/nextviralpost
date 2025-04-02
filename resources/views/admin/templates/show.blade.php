@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Template Details</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th style="width: 200px;">Title</th>
                                    <td>{{ $template->title }}</td>
                                </tr>
                                <tr>
                                    <th>Post Type</th>
                                    <td>{{ $template->postType->name }}</td>
                                </tr>
                                <tr>
                                    <th>Tone</th>
                                    <td>{{ $template->tone->name }}</td>
                                </tr>
                                <tr>
                                    <th>Category</th>
                                    <td>{{ $template->category }}</td>
                                </tr>
                                <tr>
                                    <th>Post Goal</th>
                                    <td>{{ $template->post_goal }}</td>
                                </tr>
                                <tr>
                                    <th>Virality Factor</th>
                                    <td>{{ $template->virality_factor }}</td>
                                </tr>
                                <tr>
                                    <th>Version</th>
                                    <td>{{ $template->version }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        <span class="badge badge-{{ $template->is_active ? 'success' : 'danger' }}">
                                            {{ $template->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Created At</th>
                                    <td>{{ $template->created_at->format('Y-m-d H:i:s') }}</td>
                                </tr>
                                <tr>
                                    <th>Updated At</th>
                                    <td>{{ $template->updated_at->format('Y-m-d H:i:s') }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Content</h4>
                                </div>
                                <div class="card-body">
                                    <div class="bg-light p-3 rounded">
                                        {!! nl2br(e($template->content)) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('admin.templates.edit', $template) }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Edit Template
                        </a>
                        <a href="{{ route('admin.templates.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 