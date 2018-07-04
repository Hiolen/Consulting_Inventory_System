@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row row-offcanvas row-offcanvas-right">

            @include('common.sidebar')

            <div class="col-xs-12 col-sm-9">
                <h1>Category Listing</h1>

                @include('common.session')

                <a href="{{ route('category.create') }}" class="btn btn-sm btn-primary">Create Category</a>
                <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <th>Name</th>
                            <th>Date Created</th>
                            <th>Actions</th>
                        </tr>
                        @foreach($categories as $category)
                            <tr>
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->created_at->toFormattedDateString()}}</td>
                                <td>
                                    <a href="{{ route('category.edit', ['id' => $category->id]) }}" class="btn btn-info btn-sm">Edit</a>
                                    <form method="post"action="@if (isset($category)){{ route('category.destroy', ['id' => $category->id]) }}@endif">
                                        {{ csrf_field() }}
                                        {{method_field('DELETE')}}

                                        <button type="submit" class="btn btn-sm btn-danger">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </table>

                    {{ $categories->links() }}
                </div> <!-- .table-responsive -->
            </div><!--/.col-xs-12.col-sm-9-->

        </div><!--/row-->

    </div><!--/.container-->

@endsection