<div class="card-body blog">
    <h4 class="text-gray-800 mb-4">Related Articles</h4>
    <div class="list-group">
        @foreach ($posts as $post)
        <a href="#" class="list-group-item list-group-item-action">
            <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-1">{{ $post->title }}</h5>
                <small class="text-muted">{{ $post->created_at->diffForHumans() }}</small>
            </div>
            <p class="mb-1">{{ $post->summary }}</p>
        </a>
        @endforeach
    </div>
</div>