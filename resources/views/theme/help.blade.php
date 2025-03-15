@extends('theme.help.layout')

@section('metatags')
<title>{{$global_d['site_title']}}</title>
@endsection
@section('css')
<style>
    .category-block {
        width: 250px;
        height: 250px;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        transition: all 0.3s ease-in-out;
        border: 3px solid transparent;
        cursor: pointer;
    }

    .category-block:hover {
        transform: translateY(-5px);
        border-color: lightgreen;
        box-shadow: 0 6px 12px rgba(0, 128, 0, 0.2);
    }

    .category-icon {
        background: linear-gradient(45deg, rgb(30, 175, 81), green);
        color: white;
        font-size: 2.5rem;
        width: 70px;
        height: 70px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        transition: background 0.3s ease-in-out, transform 0.3s ease-in-out;
    }

    .category-block:hover .category-icon {
        background: linear-gradient(45deg, green, lightgreen);
        transform: rotate(10deg);
    }
</style>
@endsection
@section('search')

<div id="banner-panel" class="home" style="display: flex; justify-content: center; align-items: center; height: 30vh; text-align: center; color: #f8f9fa;">
    <div id="banner-content" style="max-width: 80%;">
        <p id="banner-title" style="font-size: 2rem; font-weight: bold; color: #ffffff;">
            Have Questions?
        </p>
        <p id="banner-subtitle" style="font-size: 1rem; color: #ffffff;">
            Find Your Answer Here!
        </p>
    </div>
</div>

@endsection

@section('content')

<div id="categories-block-container" style="padding: 2rem; background: #f9f9f9; display: flex; justify-content: center;">
    <div id="categories-block-wrapper" style="display: flex; flex-wrap: wrap; gap: 1.5rem; justify-content: center;">

        @foreach($categories as $category)
            <div class="category-block">
                <a href="{{ route('category.show', $category->id) }}" style="text-decoration: none; color: inherit; display: flex; flex-direction: column; align-items: center;">

                    <!-- Icon Section -->
                    <div class="category-icon">
                        @if(strtoupper($category->title) == 'CAR')
                            <i class="fas fa-car"></i>  <!-- Car Icon -->
                        @elseif(strtoupper($category->title) == 'ATTRACTIONS')
                        <i class="fa fa-umbrella-beach"></i>
                        @else
                            <i class="fas fa-folder"></i>  <!-- Default Icon -->
                        @endif
                    </div>

                    <!-- Category Details -->
                    <div class="category-details">
                        <div class="title" style="color: #373737; font-size: 18px; font-weight: bold; margin-top: 1rem;">
                            {{ strtoupper($category->title) }}
                        </div>
                        <div class="written-details" style="font-size: 14px;">
                            <span style="color: #2abd00; font-weight: bold;">
                                {{ $category->helpEntries->count() }} articles
                            </span>
                        </div>
                        <div class="time" style="color: #aaa; font-size: 12px; margin-top: 0.5rem;">
                            Last Update {{ $category->updated_at->diffForHumans() }}
                        </div>
                    </div>
                </a>
            </div>
        @endforeach

    </div>
</div>



@endsection