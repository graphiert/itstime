<div>
  <header>
    <flux:heading size="xl" level="1">Settings</flux:heading>
    <flux:text>Configure your ItsTime preferences.</flux:text>
  </header>
  <main class="my-4 max-w-md">
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
      <flux:text>When you update your Discord avatar, nickname, username or email, ItsTime won't automatically update your details after you logged in again to ItsTime. You need to logout from ItsTime.</flux:text>
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
          <flux:button href="/bot/invite">Invite bot</flux:button>
        </flux:input.group>
      </div>
      <flux:text>After authorizing the bot, run <span class="font-mono">/setdm</span> on Direct Message or <span class="font-mono">/setchannel</span> on channel you desired and make sure you have permission to manage that server. Otherwise, this command won't work. Refresh this page after running the command.</flux:text>
    </section>
  </main>
</div>
