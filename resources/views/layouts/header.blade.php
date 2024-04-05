@php
    $segment = Request::segment(1);
@endphp

<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item @if($segment == 'categories') bg-secondary @endif">
                    <a class="nav-link @if($segment == 'categories') text-light @else text-dark  @endif" href="{{ url('categories') }}">Category</a>
                </li>
                <li class="nav-item @if($segment == 'products') bg-secondary @endif">
                    <a class="nav-link @if($segment == 'products') text-light @else text-dark  @endif" href="{{ url('products') }}">Product</a>
                </li>
            </ul>
        </div>
    </div>
</nav>