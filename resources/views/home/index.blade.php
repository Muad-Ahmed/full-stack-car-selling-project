<x-app-layout title="Home Page">

    <!-- Home Slider -->
    <section class="hero-slider">
        <!-- Carousel wrapper -->
        <div class="hero-slides">
            <!-- Item 1 -->
            <div class="hero-slide">
                <div class="container">
                    <div class="slide-content">
                        <h1 class="hero-slider-title">
                            Buy <strong>The Best Cars</strong> <br />
                            in your region
                        </h1>
                        <div class="hero-slider-content">
                            <p>
                                Use powerful search tool to find your desired cars based on
                                multiple search criteria: Make, Model, Year, Price Range, Car
                                Type, etc...
                            </p>

                            <a href="{{ route('car.search') }}" class="btn btn-hero-slider">Find the car</a>
                        </div>
                    </div>
                    <div class="slide-image">
                        <img src="/img/car-png-39071.png" alt="" class="img-responsive" />
                    </div>
                </div>
            </div>
            <!-- Item 2 -->
            <div class="hero-slide">
                <div class="flex container">
                    <div class="slide-content">
                        <h2 class="hero-slider-title">
                            Do you want to <br />
                            <strong>sell your car?</strong>
                        </h2>
                        <div class="hero-slider-content">
                            <p>
                                Submit your car in our user friendly interface, describe it,
                                upload photos and the perfect buyer will find it...
                            </p>

                            <a href="{{ route('car.create') }}" class="btn btn-hero-slider">Add Your Car</a>
                        </div>
                    </div>
                    <div class="slide-image">
                        <img src="/img/car-png-39071.png" alt="" class="img-responsive" />
                    </div>
                </div>
            </div>
            <button type="button" class="hero-slide-prev">
                <svg style="width: 18px" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 6 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 1 1 5l4 4" />
                </svg>
                <span class="sr-only">Previous</span>
            </button>
            <button type="button" class="hero-slide-next">
                <svg style="width: 18px" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 6 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 9 4-4-4-4" />
                </svg>
                <span class="sr-only">Next</span>
            </button>
        </div>
    </section>
    <!--/ Home Slider -->
    <main>
        <x-search-form />
        <!-- New Cars -->
        <section>
            <div class="container">
                <h2>Latest Added Cars</h2>
                @if ($cars->count() > 0)
                    <div class="car-items-listing">
                        @foreach ($cars as $car)
                            <x-car-item :$car :is-in-watchlist="$car->favouredUsers->contains(\Illuminate\Support\Facades\Auth::user())" />
                        @endforeach
                    </div>
                @else
                    <div class="text-center p-large">
                        There are no published cars.
                    </div>
                @endif
            </div>
        </section>
        <!--/ New Cars -->
        {{-- Find More Section --}}
        <section class="find-more-section">
            <div class="container">
                <h2>Didn't find what you're looking for?</h2>
                <p>Explore our full inventory with hundreds of cars.</p>
                <a href="{{ route('car.search') }}" class="btn btn-hero-slider">Browse All Cars</a>
            </div>
        </section>
        {{-- End Find More Section --}}

        {{-- Search Icon in Mobile --}}
        <a href="{{ route('car.search') }}" class="floating-search-btn" id="floatingSearchBtn">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
            </svg>
        </a>
        {{--End Search Icon in Mobile --}}

    </main>

</x-app-layout>
