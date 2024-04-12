@extends('layouts.app')

@section('title', $title = "Technologies' list")

@section('content')
    <section>
        <div class="container py-4">
            <div class="row justify-content-between align-items-center">
                <h1 class="mb-3 col-6">{{ $title }}</h1>
                    <div class="col-2 d-flex justify-content-end">
                        <a class="btn btn-primary" href="{{ route('admin.technologies.create') }}">Create a new Technology</a>
                    </div>
            </div>

            <table class="table table-striped text-center">
                <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Name</th>
                        <th scope="col">Colour</th>
                        <th scope="col">Total related projects</th>
                        <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($technologies as $technology)
                    <tr>
                        <td>{{ $technology->id }}</th>
                        <td>{{ $technology->name }}</th>
                        <td>{!! $technology->getColour() !!}</td>
                        <td>{{ sizeof($technology->projects) }}</td>
                        <td class="text-center">
                            <a href="{{ route('admin.technologies.show', $technology) }}">
                                <i class="fa-solid fa-circle-info"></i>
                            </a>
                            <a href="{{ route('admin.technologies.edit', $technology) }}">
                                <i class="fa-solid fa-file-pen"></i>
                            </a>
                            <div class="d-inline-block">
                                <button class="border border-0 delete-button" type="button" data-bs-toggle="modal" data-bs-target="#deleteModal-id{{ $technology->id }}" data-title='{{ $technology->name }}'>
                                    <i class="fa-solid fa-trash-can text-danger"></i>
                                </button>                              
                            </div>
                          </td>
                    </tr>
                    @endforeach
                  </tbody>
            </table>

            {{ $technologies->links() }}
        </div>
    </section>
@endsection

@section('modals')
    @foreach($technologies as $technology)
        <div class="modal fade mt-5" id="deleteModal-id{{ $technology->id }}" tabindex="-1" aria-labelledby="deleteModal-id{{ $technology->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <form class="modal-content" action="{{ route('admin.technologies.destroy', $technology) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-header">
                        <h1 class="modal-title fs-5 text-danger">Attention!</h1>
                    </div>
                    <div class="modal-body">
                        <p>
                            You are about to delete the {{ $technology->name }} technology. <br>
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
    @endforeach
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        button.delete-button {
          padding: 0;
          margin: 0;
          background: none;
          display: flex;
          align-items: flex-start;
        }
      </style>
@endsection