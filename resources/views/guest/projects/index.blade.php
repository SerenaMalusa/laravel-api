@extends('layouts.app')

@section('title', $title = "Projects' list")

@section('content')
<section>
    <div class="container py-4">
      <div class="row justify-content-between align-items-center">
        <h1 class="mb-3 col-6">{{ $title }}</h1>
        @auth
            <div class="col-2 d-flex justify-content-end">
                <a class="btn btn-primary" href="{{ route('admin.projects.create') }}">Create a new Project</a>
            </div>
        @endauth    
    </div>

    @include('layouts.partials.projects_table', ['projects' => $projects])

    </div>
  </section>

@endsection

@section('js')
    <script>

      const deleteButtons = document.querySelectorAll('.delete-button');

        if(deleteButtons) {

          deleteButtons.forEach(button => {
          
            button.addEventListener('click', function (event) {

              if(!confirm('This action will permanently delete the post ' + this.dataset.title)) {

                event.preventDefault();

              }

            })
        });

      }

      // 
      

    </script>
@endsection