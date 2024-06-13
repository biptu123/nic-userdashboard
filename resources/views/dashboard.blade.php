@extends('layouts.dashboard')

@section('title', 'Dashboard - Home')

@section('content')
    <div class="w-full h-full bg-gray-200 p-10">
        <div class="max-w-full rounded-lg overflow-hidden flex content-between gap-3" id="dashboard">
            <div class="md:flex w-full shadow-2xl bg-white rounde">
                <div class="w-full p-4">
                    <h2 class="text-center text-3xl font-bold text-gray-900 mb-4">
                        Last&nbsp; 10&nbsp; days&nbsp; uploads&nbsp; count
                    </h2>
                    {{-- Canvas for the Bar Chart --}}
                    <canvas id="documentsChart" width="400" height="200"></canvas>
                </div>
            </div>
            <div class="flex flex-col w-1/4 gap-2" id="cards">
                <!-- Card 1: Total Files Uploaded -->

                <div class="bg-blue-500 text-white p-4 rounded-lg shadow-lg">
                    <h2 class="text-xl font-bold">Total Files</h2>
                    <p class="text-lg">{{ $totalFilesUploaded }}</p>
                </div>


                <!-- Card 1: Total Files Uploaded Today-->

                <div class="bg-green-500 text-white p-4 rounded-lg shadow-lg">
                    <h2 class="text-xl font-bold">Uploaded Today</h2>
                    <p class="text-lg">{{ $totalUploadedToday }}</p>
                </div>


            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var ctx = document.getElementById('documentsChart').getContext('2d');
            var documentsChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: @json(array_column($documentsPerDayData, 'date')),
                    datasets: [{
                        label: 'Number of Documents',
                        data: @json(array_column($documentsPerDayData, 'count')),
                        backgroundColor: 'rgba(219, 234, 254, .5)',
                        borderColor: 'rgba(150, 150, 254, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
@endsection
