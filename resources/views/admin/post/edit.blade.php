@extends('layouts.backend.app')

@section('titile','Post')

@push('css')
<!-- JQuery DataTable Css -->
<link href="{{asset('assets/backend/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css')}}"
    rel="stylesheet">
<!-- Bootstrap Select Css -->
<link href="{{ asset('assets/backend/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" />
@endpush

@section('content')
<div class="container-fluid">
    <form action="{{ route('admin.post.update', $post->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row clearfix">
            <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                <div class="header">
                    <h2>Edit Post</h2>
                </div>
                <div class="card">
                    <div class="header">
                    </div>
                    <div class="body">

                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="text" value="{{ $post->title }}" id="title" name="title" class="form-control">
                                <label class="form-label">Post Title</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="image">Featured Image</label>
                            <input type="file" name="image">
                        </div>
                        <div class="form-group">
                            <input type="checkbox" id="publish" class="filled-in" name="status" value="1"

                            {{ $post->status == true ? 'checked' : '' }}>
                            <label for="publish"></label>
                        </div>
                    </div>
                </div>



            </div>
            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                <div class="header">
                    <h2>Categoris & Tags</h2>
                </div>
                <div class="card">
                    <div class="header">
                    </div>
                    <div class="body">

                        <div class="form-group form-float">
                            <div class="form-line{{$errors->has('categories') ? 'focused error' : ''}}">
                                <label>Select Category</label>
                                <select name="categories[]" id="category" class="form-control show-tick"
                                    data-live-search="true" multiple>
                                    @foreach ($categories as $category)

                                        <option
                                        @foreach ($post->categories as $postCategory)
                                            {{ $postCategory->id == $category->id ? 'selected' : '' }}
                                        @endforeach

                                        value="{{ $category->id }}">{{ $category->name }}
                                        </option>

                                    @endforeach

                                </select>
                            </div>
                        </div>
                        <div class="form-group form-float">
                            <div class="form-line{{$errors->has('tags') ? 'focused error' : ''}}">
                                <label>Select Tag</label>
                                <select name="tags[]" id="tag" class="form-control show-tick" data-live-search="true"
                                    multiple>
                                    @foreach ($tag as $tags)
                                    <option
                                        @foreach ($post->tags as $postTags)
                                            {{ $postTags->id == $tags->id ? 'selected' : '' }}
                                        @endforeach
                                        value="{{ $tags->id }}">{{ $tags->name }}

                                    </option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                        <a class="btn btn-danger m-t-15 waves-effect" href="{{ route('admin.post.index') }}">BACK</a>
                        <button type="submit" class="btn btn-primary m-t-15 waves-effect">SUBMIT</button>

                    </div>
                </div>



            </div>
        </div>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="header">
                    <h2>BODY</h2>
                </div>
                <div class="card">
                    <div class="header">
                    </div>
                    <div class="body">
                        <textarea name="body" id="tinymce">{{ $post->body }}</textarea>
                    </div>
                </div>



            </div>
        </div>
    </form>
    <!-- #END# Exportable Table -->
</div>
@endsection

@push('js')
<!-- Jquery DataTable Plugin Js -->
<script src="{{asset('assets/backend/plugins/jquery-datatable/jquery.dataTables.js')}}"></script>
<script src="{{asset('assets/backend/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js')}}"></script>
<script src="{{asset('assets/backend/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/backend/plugins/jquery-datatable/extensions/export/buttons.flash.min.js')}}"></script>
<script src="{{asset('assets/backend/plugins/jquery-datatable/extensions/export/jszip.min.js')}}"></script>
<script src="{{asset('assets/backend/plugins/jquery-datatable/extensions/export/pdfmake.min.js')}}"></script>
<script src="{{asset('assets/backend/plugins/jquery-datatable/extensions/export/vfs_fonts.js')}}"></script>
<script src="{{asset('assets/backend/plugins/jquery-datatable/extensions/export/buttons.html5.min.js')}}"></script>
<script src="{{asset('assets/backend/plugins/jquery-datatable/extensions/export/buttons.print.min.js')}}"></script>
<script src="{{asset('assets/backend/js/pages/tables/jquery-datatable.js')}}"></script>
<!-- Select Plugin Js -->
<script src="{{asset('assets/backend/plugins/bootstrap-select/js/bootstrap-select.js')}}"></script>
<!-- TinyMCE -->
<script src="{{asset('assets/backend/plugins/tinymce/tinymce.js')}}"></script>
<script>
    $(function () {
        //TinyMCE
        tinymce.init({
            selector: "textarea#tinymce",
            theme: "modern",
            height: 300,
            plugins: [
                'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                'searchreplace wordcount visualblocks visualchars code fullscreen',
                'insertdatetime media nonbreaking save table contextmenu directionality',
                'emoticons template paste textcolor colorpicker textpattern imagetools'
            ],
            toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
            toolbar2: 'print preview media | forecolor backcolor emoticons',
            image_advtab: true
        });
        tinymce.suffix = ".min";
        tinyMCE.baseURL = "{{ asset('assets/backend/plugins/tinymce') }}";
    });
</script>


@endpush
