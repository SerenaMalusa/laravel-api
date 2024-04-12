@extends('layouts.app')

@section('title') 
    @if(isset($technology->id))
        {{ $title = "Modify " . $technology->name }}
    @else
        {{ $title = 'Create new technology'}}
    @endif

@endsection

@section('content')

    <section>
        <div class="container py-4">
            <h1 class="mb-5">{{ $title }}</h1>

            <form action="@if(!isset($technology->id)) {{ route('admin.technologies.store') }} @else {{ route('admin.technologies.update', $technology) }} @endif" method="POST">
                @csrf
                @if(isset($technology->id))
                    @method('PATCH')
                @endif

                <div class="row flex-wrap mb-2">
                    <div class="col-6 mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') ?? $technology->name ?? '' }}"/>
                        @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="col-6 mb-3">
                        <label for="colour" class="form-label">Colour</label>
                        <input type="color" class="form-control @error('colour') is-invalid @enderror" id="colour" name="colour" value="{{ old('colour') ?? $technology->colour ?? '#000000' }}"/>
                        @error('colour')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Save</button>
            </form>

        </div>
    </section> 

@endsection
