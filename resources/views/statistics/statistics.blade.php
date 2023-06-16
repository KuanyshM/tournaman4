@extends('layouts.app')
@section('content')

<div class="container">

    <div class="justify-content-center">
        @if (\Session::has('success'))
            <div class="alert alert-success">
                <p>{{ \Session::get('success') }}</p>
            </div>
        @endif

        <div class="card">
            <br>
            <div class="card-body">
                <table class="table table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>Title</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>General statistics</th>
                            <th>General statistics</th>
                        </tr>
                        <tr>
                            <th><a href="{{url("/events/statistics/$eventId/sessionsList")}}">By Session ID</a></th>
                            <th>By Session ID</th>
                        </tr>
                        <tr>
                            <th>By User ID</th>
                            <th>By User ID</th>
                        </tr>
                        <tr>
                            <th>Tracking date</th>
                            <th>Tracking date</th>
                        </tr>
                        <tr>
                            <th>Gender</th>
                            <th>Gender</th>
                        </tr>
                        <tr>
                            <th>IP</th>
                            <th>IP</th>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="container">
                <canvas id="lineChart"></canvas>
            </div>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // Data for the chart
                    var data = {
                        labels: {{$currentTime}},
                        datasets: [{
                            label: 'avg_angry',
                            data: {{$avg_angry}},
                            borderColor: 'red',
                            backgroundColor: 'red',
                            tension: 0.4
                        },
                            {
                                label: 'avg_disgusted',
                                data: {{$avg_disgusted}},
                                borderColor: 'Green',
                                backgroundColor: 'Green',
                                tension: 0.4
                            },
                            {
                                label: 'avg_fearful',
                                data: {{$avg_fearful}},
                                borderColor: 'Purple',
                                backgroundColor: 'Purple',
                                tension: 0.4
                            },
                            {
                                label: 'avg_happy',
                                data: {{$avg_happy}},
                                borderColor: 'Yellow',
                                backgroundColor: 'Yellow',
                                tension: 0.4
                            },
                            {
                                label: 'avg_neutral',
                                data: {{$avg_neutral}},
                                borderColor: 'Gray',
                                backgroundColor: 'Gray',
                                tension: 0.4
                            },
                            {
                                label: 'avg_sad',
                                data: {{$avg_sad}},
                                borderColor: 'Blue',
                                backgroundColor: 'Blue',
                                tension: 0.4
                            },
                            {
                                label: 'avg_angry',
                                data: {{$avg_surprised}},
                                borderColor: 'Orange',
                                backgroundColor: 'Orange',
                                tension: 0.4
                            },
                        ]
                    };

                    // Configuration options
                    var options = {
                        responsive: true,
                        maintainAspectRatio: false
                    };

                    // Create the line chart
                    var lineChart = new Chart(document.getElementById('lineChart'), {
                        type: 'line',
                        data: data,
                        options: options
                    });
                });
            </script>


        </div>
    </div>
</div>
@endsection
