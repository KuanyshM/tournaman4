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
                Статсистика по сессию {{$sessionId}}
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
