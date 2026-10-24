<x-calc.page
    title="Frames to Timecode Calculator - SolveKit"
    description="Free frames to timecode calculator: SMPTE timecode from a frame count, with drop-frame at 29.97 and 59.94 fps."
    lede="Convert frames to timecode."
    about="Timecode labels every frame as hours:minutes:seconds:frames. Drop-frame timecode keeps NTSC rates in step with the clock."
    :calc="['engine' => 'tc-photo', 'tool' => 'frames_tc', 'fields' => ['frames', 'rate'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What timecode is frame 107,892 at 29.97 DF?', 'answer' => '01:00:00;00 (one hour).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="frames" label="Frame count" value="107892" min="0" step="any" />
        <x-calc.select name="rate" label="Frame rate" :options="['24' => '24 fps', '25' => '25 fps (PAL)', '30' => '30 fps', '50' => '50 fps', '60' => '60 fps', '23.976' => '23.976 fps', '29.97df' => '29.97 fps drop-frame (NTSC)', '29.97' => '29.97 fps non-drop', '59.94df' => '59.94 fps drop-frame', '59.94' => '59.94 fps non-drop']" selected="29.97df" />
    </div>

    <x-calc.result label="Timecode" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['frames' => 107892, 'rate' => '29.97df'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'real' => ['label' => 'Real (clock) time'],
            'nominal' => ['label' => 'Frames per second used for counting'],
            'back' => ['label' => 'Check (back to frames)'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
