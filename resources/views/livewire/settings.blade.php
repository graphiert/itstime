<div>
  <header>
    <flux:heading size="xl" level="1">Settings</flux:heading>
    <flux:text>Configure your ItsTime preferences.</flux:text>
  </header>
  <main class="my-4 max-w-md">
    <flux:callout variant="success" icon="check-circle" wire:show="alertIsShown">
      <flux:callout.heading>{{ $head }}</flux:callout.heading>
      <flux:callout.text>
        {{ $message }}
      </flux:callout.text>
      <x-slot name="controls">
        <flux:button icon="x-mark" variant="ghost" @click="$wire.alertIsShown = false" />
      </x-slot>
    </flux:callout>
    
    <section class="my-6 flex flex-col gap-2">
      <flux:heading size="lg">ItsTime theme</flux:heading>
      <flux:text>Set your ItsTime look between light or dark mode.</flux:text>
      <div class="mt-1">
        <flux:radio.group x-data variant="segmented" x-model="$flux.appearance">
            <flux:radio value="light" icon="sun">Light</flux:radio>
            <flux:radio value="dark" icon="moon">Dark</flux:radio>
            <flux:radio value="system" icon="computer-desktop">System</flux:radio>
        </flux:radio.group>
      </div>
    </section>
    
    <section class="my-6 flex flex-col gap-2">
      <flux:heading size="lg">Update user details</flux:heading>
      <flux:text>When you update your Discord avatar, nickname, username or email, ItsTime won't automatically update your details. You need to re-login your Discord account to ItsTime.</flux:text>
      <form method="post" action="{{ route('logout') }}" class="max-w-md mt-1">
        @csrf
        <flux:button type="submit">Logout</flux:button>
      </form>
    </section>
    
    <section class="my-6 flex flex-col gap-2">
      <flux:heading size="lg">Channel destination</flux:heading>
      <flux:text>You'll need to authorize <span class="underline">ItsTime Discord bot</span> to add to your server or by Direct Message.</flux:text>
      <div class="mt-1">
        <flux:input.group>
          <flux:input readonly variant="filled" wire:model="destination" />
          <flux:button :href="route('invite')">Invite bot</flux:button>
        </flux:input.group>
      </div>
      <flux:text>After authorizing the bot, run <span class="font-mono">/setdm</span> on Direct Message or <span class="font-mono">/setchannel</span> on channel you desired and make sure you have permission to manage that server. Otherwise, this command won't work. Refresh this page after running the command.</flux:text>
      @if($user->guild_id)
      <flux:switch wire:model.live="everyone" label="Mention everyone" description="If your channel destination on a server, you can activate this to mention everyone on your server." />
      @endif
    </section>
    
    <flux:separator variant="subtle" />
    
    <section class="my-6 flex flex-col gap-2">
      <flux:heading size="lg">Delete ItsTime account</flux:heading>
      <flux:text>We don't know why did you stop using ItsTime. But if you want to come back, we're ready to welcome you.</flux:text>
      <div class="my-1">
        <flux:modal.trigger name="delete-account">
          <flux:button variant="danger">Delete account</flux:button>
        </flux:modal.trigger>
      </div>
      <flux:text class="text-sm">Think again if you want to delete your account.</flux:text>
    </section>
    <flux:modal name="delete-account" class="min-w-[22rem]">
        <div class="space-y-6">
          <div>
            <flux:heading size="lg">Are you sure you want to delete your ItsTime account?</flux:heading>
            <flux:text class="mt-2">
                Make sure you have backed up your tasks. After deleting your account, your tasks and your personal information will be deleted. This action cannot be undone.
            </flux:text>
          </div>
          
          <div class="my-4">
            <flux:input wire:model.live.debounce.500ms="emailConfirmation" type="email" label="Please confirm your email address." description="To make sure it's you, enter your email address that associated with your Discord account." />
          </div>
  
          <div class="flex gap-2">
            <flux:spacer />

            <flux:modal.close>
                <flux:button variant="ghost">Cancel</flux:button>
            </flux:modal.close>
            
            <form method="post" action="{{ route('account.delete') }}">
              @csrf
              <flux:button type="submit" variant="danger" :disabled="$emailConfirmation !== $userEmail">Delete account</flux:button>
            </form>
          </div>
        </div>
      </flux:modal>
  </main>
</div>
