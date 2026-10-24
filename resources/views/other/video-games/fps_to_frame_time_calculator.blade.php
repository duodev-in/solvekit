<x-calc.page
    title="FPS to Frame Time Calculator - SolveKit"
    description="Free FPS to frame time calculator: milliseconds per frame for any frame rate."
    lede="Convert FPS to frame time."
    about="Frame time is the time each frame takes: 1000 ÷ fps milliseconds."
    :calc="['engine' => 'ot-play', 'tool' => 'fps_frametime', 'fields' => ['fps'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What is the frame time at 144 fps?', 'answer' => '6.9444 ms.'],
    ]"
>
    <x-calc.field name="fps" label="Frames per second" value="144" min="0" step="any" />

    <x-calc.result label="Frame time" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['fps' => 144],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'refresh' => ['label' => 'Matching monitor refresh'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="Common rates" name="table" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
