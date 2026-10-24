<x-calc.page
    title="Timecode to Frames Calculator - SolveKit"
    description="Free timecode to frames calculator: frame count from SMPTE timecode, with drop-frame support."
    lede="Convert timecode to frames."
    about="Counting frames from timecode must skip the frame numbers that drop-frame timecode leaves out."
    :calc="['engine' => 'tc-photo', 'tool' => 'tc_frames', 'fields' => ['tc', 'rate'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'How many frames is 01:00:00;00 at 29.97 DF?', 'answer' => '107,892.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="tc" label="Timecode (HH:MM:SS:FF)" value="01:00:00;00" type="text" inputmode="text" />
        <x-calc.select name="rate" label="Frame rate" :options="['24' => '24 fps', '25' => '25 fps (PAL)', '30' => '30 fps', '50' => '50 fps', '60' => '60 fps', '23.976' => '23.976 fps', '29.97df' => '29.97 fps drop-frame (NTSC)', '29.97' => '29.97 fps non-drop', '59.94df' => '59.94 fps drop-frame', '59.94' => '59.94 fps non-drop']" selected="29.97df" />
    </div>

    <x-calc.result label="Frame count" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['tc' => '01:00:00;00', 'rate' => '29.97df'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'real' => ['label' => 'Real (clock) time'],
            'back' => ['label' => 'Check (back to timecode)'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
