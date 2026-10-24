<x-calc.page
    title="Time Lapse Calculator - SolveKit"
    description="Free time-lapse calculator: clip length, shooting interval or event duration, with photos and card space."
    lede="Plan a time-lapse."
    about="A time-lapse turns long events into short clips: the interval between shots sets the speed-up."
    :calc="['engine' => 'tc-photo', 'tool' => 'time_lapse', 'fields' => ['solve', 'duration', 'interval', 'clip', 'fps', 'fileMb'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'How long is the clip from 2 hours at 5 s intervals?', 'answer' => '60 s of video.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="solve" label="Find" :options="['clip' => 'Clip length', 'interval' => 'Interval between shots', 'duration' => 'Event duration to shoot']" selected="clip" />
        <div data-show-when="solve:clip,interval">
            <x-calc.field name="duration" label="Event duration (minutes)" value="120" min="0" step="any" />
        </div>
        <div data-show-when="solve:clip,duration">
            <x-calc.field name="interval" label="Interval between shots (s)" value="5" min="0" step="any" />
        </div>
        <div data-show-when="solve:interval,duration">
            <x-calc.field name="clip" label="Clip length (s)" value="30" min="0" step="any" />
        </div>
        <x-calc.field name="fps" label="Playback frame rate (fps)" value="24" min="1" step="any" />
        <x-calc.field name="fileMb" label="Size of one photo (MB, optional)" value="25" min="0" step="any" />
    </div>

    <x-calc.result label="Result" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['solve' => 'clip', 'duration' => 120, 'interval' => 5, 'clip' => 30, 'fps' => 24, 'fileMb' => 25],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'frames' => ['label' => 'Photos'],
            'speedup' => ['label' => 'Speed-up'],
            'storage' => ['label' => 'Card space'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
