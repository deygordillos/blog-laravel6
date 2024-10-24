@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create article</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="title">Title: <code>*</code></label>
                            <input type="text" name="title" class="form-control" id="title" required>
                        </div>
                        <div class="form-group">
                            <label for="file">Image</label>
                            <input type="file" name="file" id="file">
                        </div>
                        <div class="form-group">
                            <label for="title">Content: <code>*</code></label>
                            <textarea name="body" id="body" rows="6" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="title">Embed content:</label>
                            <textarea name="iframe" id="iframe" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            @csrf
                            <input type="submit" value="Send" class="btn btn-sm btn-primary">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
