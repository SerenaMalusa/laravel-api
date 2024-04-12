@extends('layouts.app')

@section('title', "Project's detail'")

@section('content')
    <section>
        <div class="container py-4">
            <div class="row justify-content-between align-items-center">
                <h1 class="mb-3 col-6">{{ $project->title }}</h1>
                <div class="col-2 text-end">
                    <a class="btn btn-primary" href="{{ route('projects.index')}}">Back to projects' list</a>
                </div>
            </div>

            <div class="row align-items-between">
                <div class="col-6">
                    @if($project->image)
                        <img src="{{ asset('storage/' . $project->image) }}" alt="#">
                    @else
                        <img src="https://static.vecteezy.com/system/resources/previews/016/916/479/original/placeholder-icon-design-free-vector.jpg" alt="placeholder">
                    @endif
                </div>

                <div class="col-6 row">
                    <div class="col row mb-3">
                        <div class="col-6">
                            <span class="h5 ms-2"><b>Type:</b></span>
                            @if ($project->type_id)
                                @guest
                                    {!! $project->type->getBadge() !!}
                                @endguest
                                @auth
                                    <a href="{{ route('admin.types.show', $project->type) }}">{!! $project->type->getBadge() !!}</a>
                                @endauth
                            @else 
                                None
                            @endif 
                        </div>

                        <div class="col-6">
                            <span class="h5 ms-2"><b>Repo:</b></span>
                            <span>{{ $project->repository }}</span>
                        </div>
                    </div>

                    <div class="col-12">
                        <span class="h5 ms-2"><b>Technologies:</b></span>
                            @if (sizeof($project->technologies) > 0 )
                                @guest
                                    {!! $project->getTechnologiesBadges() !!}
                                @endguest
                                @auth
                                    @foreach ($project->technologies as $technology)
                                        <a href="{{ route('admin.technologies.show', $technology) }}">{!! $technology->getBadge() !!}</a>
                                    @endforeach
                                @endauth
                            @else 
                                None
                            @endif 
                    </div>

                    <div class="col-12">
                        <h5 class="mt-3"><b>Description:</b></h5>
                        <p>{{ $project->description }}</p>  
                    </div>

                    <div class="col-12">
                        <p>
                            <b>Link: </b>
                            <a href="{{ $project->github_link }}"> {{ $project->github_link }}</a>
                        </p>
                    </div>

                    <div class="col row">

                        <div class="col-6">
                            <p><b>Creation's date: </b>{{ $project->creation_date }}</p>
                        </div>
                        <div class="col-6">
                            <p><b>Last commit's date: </b>{{ $project->last_commit }}</p>
                        </div>
                    </div>
                </div>

            </div>                                  

            <div class="row mt-3">

                @auth
                <div class="col-12">
                    <a class="btn btn-primary ms-2" href="{{ route('admin.projects.edit', $project) }}">Modify this project</a>
                    <form class="d-inline" action="{{ route('admin.projects.destroy', $project) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" id='delete-btn'>Delete this project</button>
                    </form>
                </div>
                <div class="col-12">
                @endauth
                    
                </div>
                    
            </div>
        </div>
    </section>
@endsection

@section('css')
    <style>
        img {
            width: 100%;
        }
    </style>
@endsection

@section('js')
    <script>
        const deleteBtn = document.querySelector('#delete-btn');
        if(deleteBtn) {
            deleteBtn.addEventListener('click', function (e) {
    
                if (!confirm(
`The delete action is not reversible.
Are you sure that you want to remove this project from the list?`
                )) {
                    e.preventDefault();
                } 
            });
        }
    </script>
@endsection