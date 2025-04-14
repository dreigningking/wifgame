@extends('backend.layouts.dashboard')
@push('styles')
<!--begin::Vendor Stylesheets(used for this page only)-->
<link href="{{asset('plugins/custom/summernote/summernote-bs5.css')}}" rel="stylesheet">
<style>
    .note-editor.note-frame, .note-editor.note-airframe{
        border:1px solid var(--bs-gray-300);
    }
    .note-btn{
        border:1px solid var(--bs-gray-300) !important;
    }
    .note-toolbar{
        justify-content: start !important;
        padding-right: 5px !important;
        padding-left: 5px !important;
    }
</style>
<!--end::Vendor Stylesheets-->
@endpush
@section('main')
    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Toolbar-->
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <!--begin::Toolbar container-->
            <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                <!--begin::Page title-->
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <!--begin::Title-->
                    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">Article Create</h1>
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">
                            <a href="index.html" class="text-muted text-hover-primary">Home</a>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">Blog</li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">Articles</li>
                        <!--end::Item-->
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                
            </div>
            <!--end::Toolbar container-->
        </div>
        <!--end::Toolbar-->
        <!--begin::Content-->
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container container-xxl">
                <!--begin::Form-->
                <form action="{{ route('admin.posts.update') }}" method="post" class="form d-flex flex-column flex-lg-row" enctype="multipart/form-data">@csrf
                    <input type="hidden" name="post_id" value="{{$post->id}}">
                    <!--begin::Aside column-->
                    <div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10">
                        <!--begin::Thumbnail settings-->
                        <div class="card card-flush py-4">
                            <!--begin::Card header-->
                            <div class="card-header">
                                <!--begin::Card title-->
                                <div class="card-title">
                                    <h2>Thumbnail</h2>
                                </div>
                                <!--end::Card title-->
                            </div>
                            <!--end::Card header-->
                            <!--begin::Card body-->
                            <div class="card-body text-center pt-0">
                                <!--begin::Image input-->
                                <!--begin::Image input placeholder-->
                                <style>
                                    @if($post->photo)
                                    .image-input-placeholder {
                                        background-image: url({{asset('storage/'.$post->photo)}});
                                    }

                                    [data-bs-theme="dark"] .image-input-placeholder {
                                        background-image: url({{asset('storage/'.$post->photo)}});
                                    }
                                    @else  
                                    .image-input-placeholder {
                                        background-image: url({{asset('media/svg/files/blank-image.svg')}});
                                    }

                                    [data-bs-theme="dark"] .image-input-placeholder {
                                        background-image: url({{asset('media/svg/files/blank-image-dark.svg')}});
                                    }
                                    @endif
                                </style>
                                <!--end::Image input placeholder-->
                                <div class="image-input image-input-empty image-input-outline image-input-placeholder mb-3" data-kt-image-input="true">
                                    <!--begin::Preview existing avatar-->
                                    <div class="image-input-wrapper w-150px h-150px"></div>
                                    <!--end::Preview existing avatar-->
                                    <!--begin::Label-->
                                    <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change avatar">
                                        <i class="ki-duotone ki-pencil fs-7">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                        <!--begin::Inputs-->
                                        <input type="file" name="photo" accept=".png, .jpg, .jpeg" />
                                        <!-- <input type="hidden" name="avatar_remove" /> -->
                                        <!--end::Inputs-->
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Cancel-->
                                    <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">
                                        <i class="ki-duotone ki-cross fs-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </span>
                                    <!--end::Cancel-->
                                    <!--begin::Remove-->
                                    <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove avatar">
                                        <i class="ki-duotone ki-cross fs-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </span>
                                    <!--end::Remove-->
                                </div>
                                <!--end::Image input-->
                                <!--begin::Description-->
                                <div class="text-muted fs-7">Set the article thumbnail image. Only *.png, *.jpg and *.jpeg image files are accepted</div>
                                <!--end::Description-->
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Thumbnail settings-->
                        <!--begin::Status-->
                        <div class="card card-flush py-4">
                            <!--begin::Card header-->
                            <div class="card-header">
                                <!--begin::Card title-->
                                <div class="card-title">
                                    <h2>Status</h2>
                                </div>
                                <!--end::Card title-->
                                <!--begin::Card toolbar-->
                                <div class="card-toolbar">
                                    <div class="rounded-circle bg-success w-15px h-15px" id="kt_ecommerce_add_product_status"></div>
                                </div>
                                <!--begin::Card toolbar-->
                            </div>
                            <!--end::Card header-->
                            <!--begin::Card body-->
                            <div class="card-body pt-0">
                                <!--begin::Select2-->
                                <select name="status" class="form-select mb-2" data-control="select2" data-hide-search="true" data-placeholder="Select an option" id="article_status">
                                    <option></option>
                                    <option value="1" @if($post->status) selected @endif>Published</option>
                                    <option value="0" @if(!$post->status) selected @endif>Draft</option>
                                   
                                    
                                </select>
                                <!--end::Select2-->
                                <!--begin::Description-->
                                <div class="text-muted fs-7">Set the article status.</div>
                                
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Status-->
                        <div class="card-body pt-0 categorization">
                            <!--begin::Label-->
                            <label class="form-label d-block">Tags</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <select name="tags[]" required class="form-select mb-2" multiple data-control="select2" data-tags="true" data-placeholder="Add Tags" data-allow-clear="true">
                                @foreach($tags as $tag)
                                    <option value="{{ $tag }}" selected>{{$tag}}</option>
                                @endforeach
                            </select>
                            
                            <div class="text-muted fs-7">Add tags to article.</div>
                            
                        </div>
                        
                            
                        
                        
                       
                    </div>
                    <!--end::Aside column-->
                    <!--begin::Main column-->
                    <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                        <div class="d-flex flex-column gap-7 gap-lg-10">
                            <!--begin::General options-->
                            <div class="card card-flush py-4">
                                <!--begin::Card header-->
                                <div class="card-header">
                                    <div class="card-title">
                                        <h2>Article Details</h2>
                                    </div>
                                </div>
                                <!--end::Card header-->
                                <!--begin::Card body-->
                                <div class="card-body pt-0">
                                    <!--begin::Input group-->
                                    <div class="mb-10 fv-row">
                                        <!--begin::Label-->
                                        <label class="required form-label">Article Title</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="text" name="title" value="{{ $post->title }}" maxlength="80" class="form-control mb-2" placeholder="Article title" value="" />
                                        <!--end::Input-->
                                        <!--begin::Description-->
                                        <div class="text-muted fs-7">An article name is required and recommended to be unique.</div>
                                        <!--end::Description-->
                                    </div>

                                    <div class="mb-10 fv-row">
                                        <!--begin::Label-->
                                        <label class="form-label">Summary</label>
                                        <!--end::Label-->
                                        <!--begin::Editor-->
                                        <textarea name="summary" class="form-control mb-2">{{$post->summary}}</textarea>
                                        <!--end::Editor-->
                                        <!--begin::Description-->
                                        <div class="text-muted fs-7">Brief Summary of Post</div>
                                        <!--end::Description-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div>
                                        <!--begin::Label-->
                                        <label class="form-label">Description</label>
                                        <!--end::Label-->
                                        <!--begin::Editor-->
                                        <textarea name="body" class="summernote-editor min-h-200px mb-2">{!! $post->body !!}</textarea>
                                        <!--end::Editor-->
                                        <!--begin::Description-->
                                        <div class="text-muted fs-7">Set a description to the article for better visibility.</div>
                                        <!--end::Description-->
                                    </div>
                                    <!--end::Input group-->
                                </div>
                                <!--end::Card header-->
                            </div>
                            
                            <div class="card card-flush py-4">
                                <!--begin::Card header-->
                                <div class="card-header">
                                    <div class="card-title flex-column">
                                        <h2>SEO </h2>
                                        <div class="text-muted fs-7">Set meta description and focus phrases</div>
                                    </div>
                                </div>
                                <!--end::Card header-->
                                <!--begin::Card body-->
                                <div class="card-body pt-0">

                                    <div class="fv-row mb-5">
                                        <!--begin::Label-->
                                        <label class="required form-label">Meta Description</label>
                                        <input type="text" name="meta_description" value="{{ $post->meta_description }}" maxlength="140" id="meta_description" class="form-control mb-2" />
                                        
                                        <!--end::Description-->
                                    </div>
                                    <div class="fv-row mb-5">
                                        <!--begin::Label-->
                                        <label class="required form-label">Main Key Phrase</label>
                                        <input type="text" name="main_keyphrase" value="{{ $post->main_keyphrase }}" maxlength="50" id="main_keyphrase" class="form-control mb-2" />
                                        <div class="text-muted fs-7">Set the main focus key phrase for this article.</div>
                                        <!--end::Description-->
                                    </div>
                                    <div class="fv-row mb-5">
                                        <!--begin::Label-->
                                        <label class="required form-label">Related Key Phrases (comma separated) </label>
                                        <input type="text" name="related_keyphrases" value="{{ $post->related_keyphrases }}" maxlength="140" id="related_keyphrases" class="form-control mb-2" />
                                        <div class="text-muted fs-7">Other key phrases that may be related to this article.</div>
                                        <!--end::Description-->
                                    </div>

                                    
                                </div>
                                <!--end::Card header-->
                            </div>
                            
                            
                            
                            
                        </div>

                        <div class="d-flex justify-content-end">
                            
                            <button type="reset" id="reset" class="btn btn-light me-5">
                                <span class="indicator-label">Cancel</span>
                                
                            </button>
                            
                            
                            <button type="submit" id="kt_ecommerce_add_product_submit" class="btn btn-primary">
                                <span class="indicator-label">Save Changes</span>
                                <span class="indicator-progress">Please wait...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                            </button>
                            
                        </div>
                        
                    </div>
                    
                </form>
                
            </div>
            
        </div>
        
    </div>
@endsection
@push('scripts')
<!--begin::Vendors Javascript(used for this page only)-->
<script src="{{asset('plugins/custom/summernote/summernote-bs5.js')}}"></script>
<script src="{{asset('plugins/custom/formrepeater/formrepeater.bundle.js')}}"></script>

<script>
    
    // Summernote editor
    $(document).ready(function(){
        $('.summernote-editor').summernote({
            focus: true,
            height: 300,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold','italic','underline', 'clear','fontsize','strikethrough', 'superscript', 'subscript']],
                ['color', ['color']],
                ['table', ['table']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link', 'picture', 'video']],
                
            ]
        })
    })
    
</script>

@endpush