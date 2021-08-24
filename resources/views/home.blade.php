@extends('layouts.app')

@section('content')

    <div id="homepage" class="vh-100 ">

        <div class="upper-panel">
            <div class="homepage-img text-center ">
                <img src="{{url('storage/images/system/homepage/building.png')}}" alt="" class="img-fluid mx-auto" >    
            </div>
    
            <div class="brand-title text-center">
                Song of Joy Resort                
            </div>
            
        </div>
        <p class="text-center mt-2 w-75 mx-auto">
            Is located on sabang beach, Puerto Galera. Experience the wonders of the philippines, which offer relaxed and friendly asian vacation. At SOJ Dive and Beach Resort you will enjoy true Filipino hospitality in a beautiful tropical destination..
        </p>

        <hr>

        <div class="container text-center">

            <div class="row">

                <div class="col-sm">
                    <div class="border border-secondary m-2 p-4 text-center">
                        <img src="{{url('storage/images/system/homepage/puerto.png')}}" alt="" class="learn-more-img">
                        <p class="mx-auto">
                            Puerto Galera
                        </p>
                        <a href="" class="border border-dark text-center p-2 text-dark" > Learn More</a>
                    </div>
                </div>

                <div class="col-sm">
                    <div class="border border-secondary m-2 p-4 text-center">
                        <img src="{{url('storage/images/system/homepage/building2.png')}}" alt="" class="learn-more-img">
                            <p class="mx-auto">
                                Resort
                            </p>
                            <a href="" class="border border-dark text-center p-2 text-dark" > Learn More</a>
                    </div>
                </div>

                <div class="col-sm">
                    <div class="border border-secondary m-2 p-4 text-center">
                        <img src="{{url('storage/images/system/homepage/restau.png')}}" alt="" class="learn-more-img">
                            <p class="mx-auto">
                                Restaurant
                            </p>

                            <a href="" class="border border-dark text-center p-2 text-dark" > Learn More</a>
                    </div>
                </div>

            </div>

        </div>        

                
    </div>

@endsection

