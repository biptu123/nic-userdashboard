<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>@yield('title', 'Dashboard')</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"
        integrity="sha512-r22gChDnGvBylk90+2e/ycr3RVrDi8DIOkIGNhJlKfuyQM4tIRAI062MaV8sfjQKYVGjOBaZBOA87z+IhZE9DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        @import url("https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap");

        html {
            font-family: "Poppins", sans-serif !important;
        }

        body {
            display: flex;
            overflow-x: hidden;
            max-height: 100vh;
        }

        aside {
            width: 10%;
            height: 100vh;
            min-width: 200px;
            background-color: #333;
            color: #fff;
            padding: 20px;
            box-sizing: border-box;
        }

        main {
            flex-grow: 1;
            box-sizing: border-box;
            overflow-x: auto;
        }

        #hamburger {
            display: none;
        }

        @media (max-width: 1150px) {
            #dashboard {
                flex-direction: column;
            }

            #cards {
                width: 100%;
                flex-direction: row;
                justify-content: space-around;
                flex-wrap: wrap;
            }

            #cards>div {
                width: 40%;
                min-width: 200px;
            }
        }

        @media (max-width: 768px) {
            #hamburger {
                position: absolute;
                display: block;
                top: 0;
                right: 0;
                padding: 17px;
            }

            body {
                flex-direction: row;
                flex-wrap: wrap;
            }

            aside {
                width: 100vw;
                height: 80px !important;
                padding: 20px;
            }

            main {
                width: 100vw;
                padding: 20px;
            }

            #dropdown {
                background: #333;
                position: relative;
                z-index: 1000;
                margin-bottom: 15px;
                display: none;
            }

            #settings {
                background: #333;
                margin: 0;
                position: relative;
                z-index: 1000;
                display: none;
            }

            .show {
                display: block;
            }
        }
    </style>

</head>

<body>

    <!-- Sidebar -->
    <aside class="bg-gray-800 text-white h-screen ">
        <div class="py-1" id="wrapper">
            <div class="flex items-center mb-4 gap-2">
                <div
                    class="w-1/3 aspect-square bg-gray-300 hidden md:flex items-center justify-center rounded-full cursor-pointer text-gray-800 text-xl font-bold">

                    {{ collect(explode(' ', auth()->user()->name))->pipe(function ($parts) {
                        return substr($parts->first(), 0, 1) . substr($parts->last(), 0, 1);
                    }) }}


                </div>

                <h1 class="text-2xl font-light md:hidden">{{ auth()->user()->name }}</h1>
                <h1 class="hidden text-md font-light md:block w-2/3 overflow-x-hidden break-words">
                    {{ auth()->user()->name }}</h1>
            </div>

            <ul class="mt-4" id="dropdown">
                <li class="py-2">
                    <a href="{{ route('dashboard') }}" @class([
                        'flex gap-5 px-4 py-2 rounded hover:bg-gray-700 ',
                        'bg-gray-700 ' => Request::is('dashboard'),
                    ])><svg
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                        </svg>Home
                    </a>
                </li>
                <li class="py-2">
                    <a href="{{ route('files') }}" @class([
                        'flex gap-5 px-4 py-2 rounded hover:bg-gray-700 ',
                        'bg-gray-700 ' => Request::is('files'),
                    ])><svg xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25M9 16.5v.75m3-3v3M15 12v5.25m-4.5-15H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                        </svg>
                        Files</a>
                </li>
                <li class="py-2">
                    <a href="{{ route('upload') }}" @class([
                        'flex gap-5 px-4 py-2 rounded hover:bg-gray-700 ',
                        'bg-gray-700 ' => Request::is('upload'),
                    ])><svg xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M7.5 7.5h-.75A2.25 2.25 0 0 0 4.5 9.75v7.5a2.25 2.25 0 0 0 2.25 2.25h7.5a2.25 2.25 0 0 0 2.25-2.25v-7.5a2.25 2.25 0 0 0-2.25-2.25h-.75m0-3-3-3m0 0-3 3m3-3v11.25m6-2.25h.75a2.25 2.25 0 0 1 2.25 2.25v7.5a2.25 2.25 0 0 1-2.25 2.25h-7.5a2.25 2.25 0 0 1-2.25-2.25v-.75" />
                        </svg>
                        Upload</a>
                </li>

            </ul>
            <ul class="absolute bottom-5" id="settings">
                <li class="py-2 mt-auto">
                    <p class = 'flex gap-2  py-2 rounded '>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />

                        </svg>
                        SETTINGS
                        <hr class="">
                    </p>
                </li>
                <li class="py-2 mt-auto">
                    <a href="{{ route('profile') }}" @class([
                        'flex gap-5 px-4 py-2 rounded hover:bg-gray-700 ',
                        'bg-gray-700 ' => Request::is('profile'),
                    ])><svg
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M10.5 6h9.75M10.5 6a1.5 1.5 0 1 1-3 0m3 0a1.5 1.5 0 1 0-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-9.75 0h9.75" />
                        </svg>

                        Profile</a>
                </li>
                <li class="py-2">
                    <a href="{{ route('logout') }}" @class([
                        'flex gap-5 px-4 py-2 rounded hover:bg-gray-700 ',
                        'bg-gray-700 ' => Request::is('logout'),
                    ])><svg xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15" />
                        </svg>
                        Logout</a>
                </li>
            </ul>

        </div>
        <div id="hamburger" class="text-white cursor-pointer hover:text-gray-400" onclick="toggle()">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                class="w-10 h-10">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
            </svg>
        </div>
    </aside>

    <!-- Content area -->
    <main class="bg-gray-100">
        @yield('content')
    </main>

</body>
<script>
    const dropdown = document.getElementById("dropdown");
    const settings = document.getElementById("settings");

    function toggle() {
        dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
        settings.style.display = settings.style.display === "block" ? "none" : "block";
    }
</script>

</html>
