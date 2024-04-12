@if(sizeof($projects) == 0)
        <h3>0</h3>
@else
  <table class="table table-striped">
      <thead>
        <tr>
          <th scope="col">Title</th>
          <th scope="col">Type</th>
          <th scope="col">Repository</th>
          <th scope="col">Technologies</th>
          <th scope="col">Last commit</th>
          <th class="text-center">Actions</th>
        </tr>
      </thead>    
      
      <tbody>
        @foreach ($projects as $project)
          <tr>
            <td>
              <a href={{ $project->github_link }} target="_blank">{{ $project->title }}</a>
            </td>
            <td>
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
            </td>
            <td>{{ $project->repository }}</td>
            <td>
              @if (sizeof($project->technologies) > 0 )
                @guest
                  {!! $project->getTechnologiesBadges() !!}
                @endguest
                @auth
                  @foreach( $project->technologies as $technology )
                    <a href="{{ route('admin.technologies.show', $technology) }}">
                      {!! $technology->getBadge() !!}
                    </a>
                  @endforeach
                @endauth
              @else 
                None
              @endif 
            </td>
            <td>{{ $project->last_commit }}</td>
            <td class="text-center">
              <a href="{{ route('projects.show', $project )}}">
                  <i class="fa-solid fa-circle-info"></i>
              </a>
              @auth
                <a href="{{ route('admin.projects.edit' , $project)}}">
                  <i class="fa-solid fa-file-pen"></i>
                </a>
                <form class="d-inline-block" action="{{ route('admin.projects.destroy', $project) }}" method="POST">
                @csrf
                @method('DELETE')
                <button class="border border-0 delete-button" type="submit" data-title='{{ $project->title }}'>
                    <i class="fa-solid fa-trash-can text-danger"></i>
                </button>
                </form>
              @endauth
            </td>
          </tr>
        @endforeach
      </tbody>
  </table>
      
  {{ $projects->links() }}
@endif

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