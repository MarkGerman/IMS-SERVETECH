<div>
    @foreach ($levels as $item)
    <li class="nav-item">
        <a href="{{ route('level.classes.show',$item->slug) }}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>{{ $item->name }}</p>
        </a>
    </li>
    @endforeach
</div>