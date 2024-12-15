<div style="position: relative; background: radial-gradient(ellipse at bottom, #0d1d31 0%, #0c0d13 100%); min-height: 100vh; color: white; overflow: hidden; padding: 2rem;">

    <!-- Content -->
    <div style="max-width: 1200px; margin: 0 auto; position: relative; z-index: 1;">
        <!-- Header -->
        <div style="text-align: center; margin-bottom: 2.5rem;">
            <h1 style="font-size: 2.5rem; font-weight: bold;">{{ $competition->name }}</h1>
            <h2 style="font-size: 1.25rem; color: gray;">Genre: Ballad/R&B/OPM</h2>
        </div>

        <!-- Grid Layout -->
        <div style="display: flex; flex-wrap: wrap; gap: 2rem; justify-content: center;">
            <!-- Participant Card -->
            <div style="
    flex: 1;
    max-width: 400px;
    background: linear-gradient(to top, #2d3748, #1a202c);
    border-radius: 1rem;
    overflow: hidden;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
    position: relative;
    text-align: center;
    height: 450px; /* Fixed height for the card */
">

                <!-- Participant Image -->
                <img style="
        width: 100%;
        height: 100%;
        object-fit: cover;"
                     src="{{ Storage::url($currentParticipant->image) }}"
                     alt="Participant Photo">

                <!-- Participant Details Overlay -->
                <div style="
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        background: rgba(0, 0, 0, 0.6);
        padding: 1rem;
        color: white;
        text-align: left;">
                    <h2 style="font-size: 1rem; font-weight: bold; margin: 0;">{{ $currentParticipant->name }}</h2>
                    <p style="font-size: 0.875rem; margin: 0.25rem 0; color: #d1d5db;">{{ $currentParticipant->song }}</p>
                </div>

                <!-- Participant ID Badge -->
                <span style="
        position: absolute;
        bottom: 1rem;
        right: 1rem;
        display: flex;
        justify-content: center;
        align-items: center;
        width: 2.5rem;
        height: 2.5rem;
        background: white;
        color: black;
        font-size: 1rem;
        font-weight: bold;
        border-radius: 50%;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);">
        {{ $currentParticipant->id }}
    </span>
            </div>


            <!-- Scoring Section -->
            <div style="
                flex: 1;
                max-width: 600px;
                background: rgba(45, 55, 72, 0.7);
                border-radius: 1rem;
                padding: 1.5rem;
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);">
                <!-- Total Score -->
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                    <h3 style="font-size: 1.25rem; font-weight: bold;">Total</h3>
                    <span style="font-size: 2rem; color: #e53e3e; font-weight: bold;">{{ $totalScore }}%</span>
                </div>

                <!-- Score Sliders -->
                @foreach ([
                    ['label' => 'Voice Quality (Tonality, Genre Appropriateness, Technique)', 'range' => 60, 'key' => 'voice_quality'],
                    ['label' => 'Style and Performance (Rendition, Timing, Delivery)', 'range' => 30, 'key' => 'style_performance'],
                    ['label' => 'Audience Poll', 'range' => 10, 'key' => 'audience_poll']
                ] as $scoreItem)
                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; color: gray; margin-bottom: 0.5rem;">{{ $scoreItem['label'] }} - 0-{{ $scoreItem['range'] }}%</label>
                        <input type="range" min="0" max="{{ $scoreItem['range'] }}" step="1" style="width: 100%;"
                               wire:model="score.{{ $scoreItem['key'] }}" wire:input="calculateTotal">
                        <div style="display: flex; justify-content: space-between; color: gray; font-size: 0.875rem; margin-top: 0.25rem;">
                            <span>0</span>
                            <span>{{ $score[$scoreItem['key']] }}%</span>
                            <span>{{ $scoreItem['range'] }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Participant Navigation -->
        <div style="margin-top: 3rem; text-align: center;">
            <h3 style="font-size: 1rem; font-weight: bold; margin-bottom: 1rem;">Participants</h3>
            <div style="display: flex; justify-content: center; gap: 1rem;">
                @foreach ($participants as $participant)
                    <button style="
                        padding: 0.5rem 1rem;
                        border-radius: 999px;
                        font-weight: bold;
                        {{ $participant->id === $currentParticipant->id ? 'background: #805ad5; color: white;' : 'background: #4a5568; color: gray;' }}"
                            wire:click="changeParticipant({{ $participant->id }})">
                        {{ $participant->name }}
                    </button>
                @endforeach
            </div>
        </div>
    </div>
</div>
