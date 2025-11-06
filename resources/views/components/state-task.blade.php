<div>
  @if(isset($task->done))
    @if($task->done->gt($task->due))
    <flux:badge size="sm" variant="pill" color="orange">Late</flux:badge>
    @else
    <flux:badge size="sm" variant="pill" color="green">Done</flux:badge>
    @endif
  @else
    @if(now()->gt($task->due))
    <flux:badge size="sm" variant="pill" color="red">Overdue</flux:badge>
    @else
    <flux:badge size="sm" variant="pill" color="orange">Ongoing</flux:badge>
    @endif
  @endif
</div>