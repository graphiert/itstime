<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
    <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Cabin:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">
      <title>{{ $title . ' - ItsTime' ?? 'ItsTime'}}</title>
      @fluxAppearance
      @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite('resources/css/app.css')
      @endif
    </head>
  <body class="dark min-h-screen bg-white dark:bg-zinc-800">
      <flux:sidebar sticky collapsible="mobile" class="bg-zinc-50 dark:bg-zinc-900 border-r border-zinc-200 dark:border-zinc-700">
          <flux:sidebar.header>
              <flux:sidebar.brand
                  href="{{ route('dashboard') }}"
                  logo="/img/logo.png"
                  name="ItsTime"
              />
  
              <flux:sidebar.collapse class="lg:hidden" />
          </flux:sidebar.header>
  
          <flux:sidebar.nav>
              <flux:sidebar.item wire:navigate icon="home" href="/dashboard">Dashboard</flux:sidebar.item>
              <flux:sidebar.item wire:navigate icon="cog-6-tooth" href="/settings">Settings</flux:sidebar.item>
          </flux:sidebar.nav>
  
          <flux:sidebar.spacer />
  
          <flux:dropdown position="top" align="start">
              <flux:sidebar.profile circle avatar="{{ auth()->user()->avatar }}" name="{{ auth()->user()->name }}" />
              <flux:menu>
                  <form method="post" action="{{ route('logout') }}">
                    @csrf
                    <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle">Logout</flux:menu.item>
                  </form>
              </flux:menu>
          </flux:dropdown>
      </flux:sidebar>
  
      <flux:header class="lg:hidden">
          <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />
  
          <flux:spacer />
      </flux:header>
  
      <flux:main>
          {{ $slot }}
      </flux:main>
  
      @fluxScripts
  </body>
</html>
