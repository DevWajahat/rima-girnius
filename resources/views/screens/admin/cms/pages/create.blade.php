@extends('layouts.admin.app') {{-- Assuming your main admin layout is layouts.admin.app --}}

@section('title', 'Add New CMS Page Section')

@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-sm-12 col-xl-8 offset-xl-2">
                <div class="bg-light rounded h-100 p-4">
                    <h6 class="mb-4">Define New CMS Page and Section</h6>

                    {{-- Display success messages --}}
                    @if (session('message'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('message') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    {{-- Form begins here --}}
                    <form method="POST" action="{{ route('admin.cms.store') }}" id="ajaxform">
                        @csrf

                        {{-- 1. Page Name (Field: page) --}}
                        <div class="mb-3">
                            <label for="page" class="form-label">Page Name</label>
                            <input
                                type="text"
                                class="form-control @error('page') is-invalid @enderror"
                                id="page"
                                name="page" {{-- CORRECTED: name="page" --}}
                                value="{{ old('page') }}"
                            >
                            @error('page')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- 2. Section Name (Field: type) --}}
                        <div class="mb-3">
                            <label for="type" class="form-label">Page Type / Section Name</label>
                            <input
                                type="text"
                                class="form-control @error('type') is-invalid @enderror"
                                id="type"
                                name="type" {{-- CORRECTED: name="type" --}}
                                value="{{ old('type') }}"
                            >
                            @error('type')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Create Page Section</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endsection
