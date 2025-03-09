@extends('dashboards.users.layouts.user-dash-layout')

@section('title', __('research_projects.title'))

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>{{ __('research_projects.title') }}</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('researchProjects.create') }}">
                    {{ __('research_projects.add_button') }}
                </a>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <table class="table table-bordered">
        <tr>
            <th>{{ __('research_projects.no') }}</th>
            <th>{{ __('research_projects.project_name_th') }}</th>
            <th>{{ __('research_projects.project_name_en') }}</th>
            <th>{{ __('research_projects.project_start') }}</th>
            <th>{{ __('research_projects.project_end') }}</th>
            <th>{{ __('research_projects.funder') }}</th>
            <th>{{ __('research_projects.budget') }}</th>
            <th>{{ __('research_projects.note') }}</th>
            <th>{{ __('research_projects.head') }}</th>
            <th>{{ __('research_projects.member') }}</th>
            <th width="280px">{{ __('research_projects.action') }}</th>
        </tr>
        @foreach ($researchProjects as $researchProject)
        <tr>
            <td>{{ ++$i }}</td>
            <td>{{ $researchProject->Project_name_TH }}</td>
            <td>{{ $researchProject->Project_name_EN }}</td>
            <td>{{ $researchProject->Project_start }}</td>
            <td>{{ $researchProject->Project_end }}</td>
            <td>{{ $researchProject->Funder }}</td>
            <td>{{ $researchProject->Budget }}</td>
            <td>{{ $researchProject->Note }}</td>
            <td>
                @foreach($researchProject->user as $user)
                    @if ($user->pivot->role == 1)
                        {{ app()->getLocale() == 'th' ? $user->fname_th . ' ' . $user->lname_th : $user->fname_en . ' ' . $user->lname_en }}
                    @endif
                @endforeach
            </td>
            <td>
                @foreach($researchProject->user as $user)
                    @if ($user->pivot->role == 2)
                        {{ app()->getLocale() == 'th' ? $user->fname_th . ' ' . $user->lname_th : $user->fname_en . ' ' . $user->lname_en }}
                    @endif
                @endforeach
            </td>
            <td>
                <form action="{{ route('researchProjects.destroy',$researchProject->id) }}" method="POST">
                    <a class="btn btn-info" href="{{ route('researchProjects.show',$researchProject->id) }}">
                        {{ __('research_projects.view') }}
                    </a>
                    @can('editResearchProject')
                        <a class="btn btn-primary" href="{{ route('researchProjects.edit',$researchProject->id) }}">
                            {{ __('research_projects.edit') }}
                        </a>
                    @endcan

                    @csrf
                    @method('DELETE')
                    @can('deleteResearchProject')
                        <button type="submit" class="btn btn-danger">
                            {{ __('research_projects.delete') }}
                        </button>
                    @endcan
                </form>
            </td>
        </tr>
        @endforeach
    </table>

    {!! $researchProjects->links() !!}

</div>
@stop
