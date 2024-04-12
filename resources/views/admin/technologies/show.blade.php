@extends('layouts.app')

@section('title', "Type's detail'")

@section('content')
    <section>
        <div class="container py-4">
            <div class="row justify-content-between align-items-center">
                <h1 class="mb-3 col-6">{{ $technology->name }}</h1>
                <div class="col-2 d-flex justify-content-end">
                    <a class="btn btn-primary" href="{{ route('admin.technologies.index')}}">Technologies' list</a>
                </div>
                
                <div class="col-6 mb-3">
                    <div class="mb-3">
                        <span class="h2 ms-2">Badge:</span>
                        <span>{!! $technology->getBadge() !!}</span>                    
                    </div>
                    
                    <div>
                        <p>{{ $technology->description }}</p>
                    </div>            
                </div>
                
                <div class="col-6 d-flex justify-content-end">
                    <a class="btn btn-primary ms-2" href="{{ route('admin.technologies.edit', $technology) }}">Modify this technology</a>
                    <button type="submit" class="btn btn-danger" type="button" data-bs-toggle="modal" data-bs-target="#deleteModal">Delete this technology</button>
                </div>
            </div>

            <h2>Related projects:</h2>
            
            @include('layouts.partials.projects_table', ['projects' => $related_projects])
            
        </div>
    </section>
@endsection

@section('modals')
    <div class="modal fade mt-5" id="deleteModal" tabindex="-1" aria-labelledby="deleteModa" aria-hidden="true">
        <div class="modal-dialog">
            <form class="modal-content" action="{{ route('admin.technologies.destroy', $technology) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-danger">Attention!</h1>
                </div>
                <div class="modal-body">
                    <p>
                        You are about to delete the {{ $technology->name }} type. <br>
                        This action is <b>permanent</b>. <br>
                        Please confirm if you want to proceed.
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Back</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
@endsection

