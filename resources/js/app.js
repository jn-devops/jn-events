import './bootstrap';

window.addEventListener('EchoLoaded', () => {
    console.log('EchoLoaded');

    // Listen to the private channel
    window.Echo.private('poll-updates')
        .listen('.vote.updated', (event) => {
            console.log('Votes updated:', event);
            console.log('Poll ID:', event.poll_id);
            console.log('Votes ID:', event.vote);

            // Get the Livewire component's $wire object
            const livewireComponent = document.querySelector('[wire\\:id]');
            if (livewireComponent) {
                const wire = Livewire.find(livewireComponent.getAttribute('wire:id'));
                wire.dispatch('voteUpdated'); // Dispatch the event
            } else {
                console.error('Livewire component not found.');
            }
        })
        .on('subscription_succeeded', () => {
            console.log('Successfully subscribed to the private channel: poll-updates');
        });
});

