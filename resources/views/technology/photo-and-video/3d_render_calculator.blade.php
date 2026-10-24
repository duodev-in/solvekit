<x-calc.page
    title="3D Render Calculator - SolveKit"
    description="Free 3D render time calculator: total render time and cloud cost from frames, time per frame and machines."
    lede="Estimate render time."
    about="Render time is the number of frames times the time per frame, shared between machines."
    :calc="['engine' => 'tc-photo', 'tool' => 'render', 'fields' => ['by', 'frames', 'seconds', 'fps', 'perFrame', 'machines', 'price'], 'data' => ['units' => collect(config('units'))->only([])->all()], 'currency' => 'USD']"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'How long does a 60-second animation at 4 minutes a frame take?', 'answer' => '4 d 0 h 00 min 00 s on one machine.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="by" label="Length given as" :options="['frames' => 'Number of frames', 'time' => 'Duration and frame rate']" selected="time" />
        <div data-show-when="by:frames">
            <x-calc.field name="frames" label="Frames" value="1440" min="1" step="any" />
        </div>
        <div data-show-when="by:time">
            <x-calc.field name="seconds" label="Animation length (s)" value="60" min="0" step="any" />
        </div>
        <div data-show-when="by:time">
            <x-calc.field name="fps" label="Frame rate (fps)" value="24" min="1" step="any" />
        </div>
        <x-calc.field name="perFrame" label="Render time per frame (minutes)" value="4" min="0" step="any" />
        <x-calc.field name="machines" label="Machines (render nodes)" value="1" min="1" step="any" />
        <x-calc.field name="price" label="Price per machine-hour (cloud, optional)" value="0.9" min="0" step="any" suffix="$" />
    </div>

    <x-calc.result label="Total render time" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['by' => 'time', 'frames' => 1440, 'seconds' => 60, 'fps' => 24, 'perFrame' => 4, 'machines' => 1, 'price' => 0.9],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'frames' => ['label' => 'Frames'],
            'machineHours' => ['label' => 'Machine-hours'],
            'cost' => ['label' => 'Cloud cost'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
