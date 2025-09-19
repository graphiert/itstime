<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Cabin:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">
        <title>@yield('title', 'ItsTime')</title>
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
    </head>
    <body>
        <div x-data="{ showSidebar: false }" class="font-sans relative flex w-full flex-col md:flex-row">
            <!-- This allows screen readers to skip the sidebar and go directly to the main content. -->
            <a class="sr-only" href="#main-content">skip to the main content</a>
        
            <!-- dark overlay for when the sidebar is open on smaller screens  -->
            <div x-cloak x-show="showSidebar" class="fixed inset-0 z-10 bg-neutral-950/10 backdrop-blur-xs md:hidden" aria-hidden="true" x-on:click="showSidebar = false" x-transition.opacity ></div>
        
            <nav x-cloak class="fixed left-0 z-20 flex h-svh w-60 shrink-0 flex-col border-r border-neutral-300 bg-neutral-50 p-4 transition-transform duration-300 md:w-64 md:translate-x-0 md:relative dark:border-neutral-700 dark:bg-neutral-900" x-bind:class="showSidebar ? 'translate-x-0' : '-translate-x-60'" aria-label="sidebar navigation">
                <!-- logo  -->
                <a href="#" class="ml-2 w-fit text-2xl font-bold text-neutral-900 dark:text-white">
                  ItsTime
                </a>

                <!-- sidebar links  -->
                <div class="flex grow flex-col gap-2 overflow-y-auto pb-6 mt-6">
                    <a href="/dashboard" class="flex items-center rounded-sm gap-2 px-2 py-1.5 text-sm font-medium underline-offset-2 focus-visible:underline focus:outline-hidden
                    {{ request()->is('dashboard') ? 'bg-black/10 text-neutral-900 dark:bg-white/10 dark:text-white' : 'text-neutral-600 hover:text-neutral-900 dark:text-neutral-300 dark:hover:bg-white/5 dark:hover:text-white' }}">
                        <span>Dashboard</span>
                    </a>
                    <a href="/settings" class="flex items-center rounded-sm gap-2 px-2 py-1.5 text-sm font-medium underline-offset-2 focus-visible:underline focus:outline-hidden
                    {{ request()->is('settings') ? 'bg-black/10 text-neutral-900 dark:bg-white/10 dark:text-white' : 'text-neutral-600 hover:text-neutral-900 dark:text-neutral-300 dark:hover:bg-white/5 dark:hover:text-white' }}">
                        <span>Settings</span>
                    </a>
                </div>
                
                <div class="flex items-center rounded-sm gap-2 px-2 py-1.5 text-sm font-medium text-neutral-600 underline-offset-2 dark:text-neutral-300">
                  <img class="w-8 h-8 rounded-full" src="{{ auth()->user()->avatar }}" alt="{{ auth()->user()->name }}"/>
                  <div class="flex flex-col flex-grow">
                    <span class="text-md font-bold">{{ auth()->user()->name }}</span>
                    <span class="text-xs">{{ auth()->user()->username }}</span>
                  </div>
                  <form action="/logout" method="post">
                    @csrf
                    <button class="rounded-sm flex items-center justify-center h-6 w-6 hover:bg-black/5 hover:text-neutral-900 focus-visible:underline focus:outline-hidden dark:hover:bg-white/5 dark:hover:text-white" type="submit">
                      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0z"/>
                        <path fill-rule="evenodd" d="M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708z"/>
                      </svg>
                    </button>
                  </form>
                </div>
            </nav>
        
            <!-- main content  -->
            <div id="main-content" class="h-svh w-full overflow-y-auto p-4 bg-white dark:bg-neutral-950">
                @yield('content')
            </div>
        
            <!-- toggle button for small screen  -->
            <button class="fixed right-4 top-4 z-20 rounded-full bg-black p-4 md:hidden text-neutral-100 dark:bg-white dark:text-black" x-on:click="showSidebar = ! showSidebar">
                <svg x-show="showSidebar" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-5" aria-hidden="true">
                    <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/>
                </svg>
                <svg x-show="! showSidebar" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-5" aria-hidden="true">
                    <path d="M0 3a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm5-1v12h9a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1zM4 2H2a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h2z"/>
                </svg>
                <span class="sr-only">sidebar toggle</span>
            </button>
        </div>
    </body>
</html>
