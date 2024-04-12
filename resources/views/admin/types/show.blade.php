@extends('layouts.app')

@section('title', "Type's detail'")

@section('content')
    <section>
        <div class="container py-4">
            <div class="row justify-content-between align-items-center">
                <h1 class="mb-3 col-6">{{ $type->name }}</h1>
                <div class="col-2 d-flex justify-content-end">
                    <a class="btn btn-primary" href="{{ route('admin.types.index')}}">Types' list</a>
                </div>
                
                <div class="col-6 mb-3">
                    <div class="mb-3">
                        <span class="h2 ms-2">Badge:</span>
                        <span>{!! $type->getBadge() !!}</span>                    
                    </div>
                    
                    <div>
                        <p>{{ $type->description }}</p>
                    </div>            
                </div>
                
                <div class="col-6 d-flex justify-content-end">
                    <a class="btn btn-primary ms-2" href="{{ route('admin.types.edit', $type) }}">Modify this type</a>
                    <button type="submit" class="btn btn-danger" type="button" data-bs-toggle="modal" data-bs-target="#deleteModal">Delete this type</button>
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
            <form class="modal-content" action="{{ route('admin.types.destroy', $type) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-danger">Attention!</h1>
                </div>
                <div class="modal-body">
                    <p>
                        You are about to delete the {{ $type->name }} type. <br>
                        This action is <b>permanent</b>. <br>
                        If you want to continue plese decide how to proceed whith all the project related to this type.
                    </p>
                    <select name="project_action" id="project_action">
                        <option value="delete">Delete all</option>
                        @foreach($types as $_type)
                            @if($_type->id != $type->id)
                                <option value="{{ $_type->id }}">Assign to {{ $_type->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Back</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
@endsection

<form class="d-inline" action="#" method="POST">
    @csrf
    @method('DELETE')
    
</form>