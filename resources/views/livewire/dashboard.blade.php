<div>
  <header>
    <flux:heading size="xl" level="1">Hello, {{ $user->name }}</flux:heading>
    <flux:text>Welcome to ItsTime Dashboard.</flux:text>
  </header>
  <main class="my-4 max-w-xl">
    @if(!isset($user->channel_id))
    <div class="my-2">
      <flux:callout color="blue" icon="bell-alert">
        <flux:callout.heading>Destination channel has not set.</flux:callout.heading>
        <flux:callout.text>
            Check settings to configure your destination channel.
            <flux:callout.link wire:navigate :href="route('settings')">Learn more</flux:callout.link>
        </flux:callout.text>
      </flux:callout>
    </div>
    @endif
    
    <div class="my-2">
      <flux:callout variant="success" icon="check-circle" wire:show="alertIsShown">
        <flux:callout.heading>{{ $head }}</flux:callout.heading>
        <flux:callout.text>
          {{ $message }}
        </flux:callout.text>
        <x-slot name="controls">
          <flux:button icon="x-mark" variant="ghost" @click="$wire.alertIsShown = false" />
        </x-slot>
      </flux:callout>
    </div>

    <form wire:submit="save" class="flex my-4 flex-col gap-4">
      <flux:input label="Title" description="Your new task" placeholder="Task title..." wire:model="form.title" />
      <flux:textarea label="Description" description="Extra steps for your task" placeholder="Task description..." wire:model="form.description" />
      <flux:input label="Due" description="This task will be reminded at..." type="datetime-local" wire:model="form.due" min="{{ now()->addMinutes(30)->format('Y-m-d\TH:i') }}" />
      <div class="flex w-full flex-row justify-end gap-4">
        <flux:button type="submit">Add task</flux:button>
      </div>
    </form>
    
    <flux:separator variant="subtle" />
    
    <div class="flex flex-row my-4 mb-6 w-full gap-2">
      <flux:input icon="magnifying-glass" placeholder="Search tasks..." wire:model.live.debounce.500ms="term" />

      <flux:dropdown>
        <flux:button icon:trailing="chevron-down">
          {{ str()->ucfirst($filterStatus) }}
          <div class="ml-2 pt-1" wire:loading wire:target="filterStatus">
            <flux:icon.loading class="size-3" />
          </div>
        </flux:button>
        <flux:menu>
          <flux:menu.radio.group wire:model.live="filterStatus">
            <flux:menu.radio value="all">All</flux:menu.radio>
            <flux:menu.radio value="done">Done</flux:menu.radio>
            <flux:menu.radio value="ongoing">Ongoing</flux:menu.radio>
            <flux:menu.radio value="late">Late</flux:menu.radio>
            <flux:menu.radio value="overdue">Overdue</flux:menu.radio>
          </flux:menu.radio.group>
        </flux:menu>
      </flux:dropdown>

      <flux:dropdown>
        <flux:button icon:trailing="chevron-down">
          {{ str()->ucfirst($sortView) }}
          <div class="ml-2 pt-1" wire:loading wire:target="sortView">
            <flux:icon.loading class="size-3" />
          </div>
        </flux:button>
        <flux:menu>
          <flux:menu.radio.group wire:model.live="sortView">
            <flux:menu.radio value="latest">Latest</flux:menu.radio>
            <flux:menu.radio value="oldest">Oldest</flux:menu.radio>
            <flux:menu.separator />
            <flux:menu.radio value="nearest">Nearest</flux:menu.radio>
            <flux:menu.radio value="farthest">Farthest</flux:menu.radio>
          </flux:menu.radio.group>
        </flux:menu>
      </flux:dropdown>
    </div>

    <div class="w-full grid grid-cols-1 md:grid-cols-2 gap-4 my-4">
      @forelse($tasks as $task)
      <flux:callout>
        <div class="flex flex-col gap-4 p-2">
          <span class="text-sm font-medium flex w-full gap-2 items-center">
            <x-state-task :task="$task" />
            <flux:text>
              {{$task->due->isCurrentYear() ?
                $task->due->format('M d, H:i') :
                $task->due->format('M d, Y, H:i') }}
            </flux:text>
          </span>
          <flux:link :href="route('tasks.show', $task->id)" wire:navigate >
            <flux:heading size="lg">{{ $task->title }}</flux:heading>
          </flux:link>
          <flux:text>
              {{ str()->limit($task->description ?? "No description provided.", 80, preserveWords: true) }}
          </flux:text>
        </div>
      </flux:callout>
      @empty
      <flux:text class="text-center">No task written. Create a new task now!</flux:text>
      @endforelse
    </div>
  </main>
</div>
