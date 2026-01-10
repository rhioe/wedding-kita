<div style="border: 5px solid green; padding: 20px;">
    <h1>TEST COMPONENT WORKING!</h1>
    <p>Message: {{ $message }}</p>
    <button wire:click="$set('message', 'Clicked!')">Click Me</button>
</div>