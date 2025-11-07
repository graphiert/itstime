<div>
  <header>
    <div class="my-1">
      <x-state-task :task="$task" />
    </div>
    <flux:heading size="xl" level="1">"{{ $task->title }}"</flux:heading>
    <flux:text>Due at {{ \Carbon\Carbon::parse($task->due)->format('F d, Y H:i') }} @if($task->done) - Done at {{ \Carbon\Carbon::parse($task->done)->format('F d, Y H:i') }} @endif</flux:text>
  </header>
  <main class="my-4 max-w-xl">
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

    <form wire:submit="update" class="flex my-4 flex-col gap-4">
      <flux:input :disabled="$task->done !== null" label="Title" placeholder="Task title..." wire:model="form.title" />
      <flux:textarea :disabled="$task->done !== null" label="Description" placeholder="Task description..." wire:model="form.description" />
      <div class="flex w-full flex-row justify-end gap-4">
        @if($task->done == null)
        <flux:modal.trigger name="mark-done">
            <flux:button variant="primary" color="green" type="button">Mark as done</flux:button>
        </flux:modal.trigger>
        <flux:button type="submit">Update</flux:button>
        @else
        <flux:modal.trigger name="delete">
          <flux:button wire:navigate variant="danger" type="button">Delete</flux:button>
        </flux:modal.trigger>
        @endif
      </div>
    </form>

    <flux:modal name="mark-done" class="min-w-[22rem]">
      <div class="space-y-6">
        <div>
          <flux:heading size="lg">Mark this task done?</flux:heading>

          <flux:text class="mt-2">
              Once you mark this task done, you can't edit your task details. Only mark done if you really done with that.
          </flux:text>
        </div>

        <div class="flex gap-2">
          <flux:spacer />

          <flux:modal.close>
              <flux:button variant="ghost">Cancel</flux:button>
          </flux:modal.close>

          <flux:button wire:click="done" type="button" variant="primary" color="green">Mark as done</flux:button>
        </div>
      </div>
    </flux:modal>
    
    <flux:modal name="delete" class="min-w-[22rem]">
      <div class="space-y-6">
        <div>
          <flux:heading size="lg">Delete this task?</flux:heading>

          <flux:text class="mt-2">
              This action cannot be undone.
          </flux:text>
        </div>

        <div class="flex gap-2">
          <flux:spacer />

          <flux:modal.close>
              <flux:button variant="ghost">Cancel</flux:button>
          </flux:modal.close>

          <flux:button wire:click="delete" type="button" variant="danger">Delete</flux:button>
        </div>
      </div>
    </flux:modal>
  </main>
</div>
