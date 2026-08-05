<div class="space-y-8">
    <article class="prose prose-zinc dark:prose-invert max-w-none">
        <h1>{{ $page?->title ?? $siteModule->label }}</h1>
        @if (filled($page?->content))
            <div>{!! $page->content !!}</div>
        @endif
    </article>

    <div class="space-y-6">
        @if ($submitted)
            <flux:callout variant="success" icon="check-circle">
                {{ __('Thanks for your message. We will get back to you soon.') }}
            </flux:callout>
        @endif

        <form wire:submit="submit" class="space-y-4">
            <flux:input wire:model="name" :label="__('Name')" type="text" required />
            <flux:input wire:model="email" :label="__('Email')" type="email" required />
            <flux:input wire:model="phone" :label="__('Phone')" type="text" required />
            <flux:input wire:model="subject" :label="__('Subject')" type="text" required />
            <flux:textarea wire:model="message" :label="__('Message')" rows="5" required />

            <flux:button type="submit" variant="primary">
                {{ __('Send message') }}
            </flux:button>
        </form>
    </div>
</div>
