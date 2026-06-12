@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

    <style>
        .content-wrapper {
            background: white;
        }
    </style>
    <div class="about-section">


        <div class="">

            <div class="about-section-title">
                About
            </div>



            <div class="row">
                <div class="col-12 col-md-7">
                    <div class="head-title-container d-flex justify-content-start">
                        <img src="{{ asset('/images/logo/tdf_long.svg') }}" class="img-fluid" alt="Town Development Fund">
                        {{-- <div class="pjn">
                             Town Development Fund
                        </div> --}}

                    </div>

                    <div class="about-content">
                        <p>
                            Real-time project activities monitoring system (RTPAMS). Every year the cost of infrastructure
                            development will be spent by taking TDF. Because of this, there will be a system to follow up on
                            the financial progress and the financial progress of the projects. As a matter of fact, the
                            pre-adjustment system brought about the development of various aspects of the project.
                            <br>
                            <br>
                            * List of different Town Operational Plans for different Economic Years
                            <br>
                            * Intuitive information about the current state of the nature of projects.
                            <br>
                            * A detailed description of a single project. The tender price, agreement has started, the work is
                            completed, etc.
                            <br>
                            * Physical and financial progress of each project.
                            <br>
                            <br>
                        </p>
                    </div>
                </div>
                <div class="col-12 col-md-5">
                    <img src="{{ asset('/images/dashboard/dashboard.png') }}" class="img-fluid d-block m-auto"
                        alt="Town Development Fund">
                </div>
            </div>


        </div>



    </div>
@endsection
