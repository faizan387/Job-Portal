@extends('layouts.admin.main')

@section('title', 'My Jobs List')

@section('content')

<div class="container mt-5">
    <div class="row justify-content-center">
        <h1>All jobs</h1>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Your jobs
                @if (Session::has('successMessage'))
                <div class="alert alert-success">{{Session::get('successMessage')}}</div>
                @endif
            </div>
            <div class="card-body">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Created on</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Title</th>
                            <th>Created on</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($jobs as $job)
                        <tr>
                            <td>{{$job->title}}</td>
                            <td>{{$job->created_at->format('Y-m-d')}}</td>
                            <td><a href="{{route('job.edit', [$job->id])}}">Edit</a></td>
                            <td><a href="#" data-bs-toggle="modal" data-bs-target="#deleteModal{{$job->id}}">Delete</a></td>
                        </tr>
                        <div class="modal fade" id="deleteModal{{$job->id}}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                            <form action="{{route('job.delete', [$job->id])}}" method="POST">@csrf
                                @method('delete')
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="deleteModalLabel">Delete confirmation</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Are you sure you want to delete this job post?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
