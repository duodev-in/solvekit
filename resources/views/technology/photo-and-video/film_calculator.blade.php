<x-calc.page
    title="Film Calculator - SolveKit"
    description="Free film calculator: film length for a running time (or the reverse) for 35 mm, 16 mm and Super 8."
    lede="Plan film stock."
    about="Each film format has a set number of frames per foot, so running time and film length are linked."
    :calc="['engine' => 'tc-photo', 'tool' => 'film', 'fields' => ['format', 'fps', 'mode', 'minutes', 'feet'], 'data' => ['units' => collect(config('units'))->only([])->all(), 'technology' => collect(config('technology_data'))->only(['film'])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'How much 35 mm film for 10 minutes at 24 fps?', 'answer' => '900 ft.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="format" label="Film format" :options="['35_4' => '35 mm (4-perf)', '35_3' => '35 mm (3-perf)', '16' => '16 mm', 'super8' => 'Super 8', 'r8' => 'Regular 8 mm']" selected="35_4" />
        <x-calc.field name="fps" label="Frame rate (fps)" value="24" min="1" step="any" />
        <x-calc.select name="mode" label="Find" :options="['length' => 'Film length for a running time', 'time' => 'Running time for a length']" selected="length" />
        <div data-show-when="mode:length">
            <x-calc.field name="minutes" label="Running time (minutes)" value="10" min="0" step="any" />
        </div>
        <div data-show-when="mode:time">
            <x-calc.field name="feet" label="Film length (feet)" value="400" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="Result" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['format' => '35_4', 'fps' => 24, 'mode' => 'length', 'minutes' => 10, 'feet' => 400],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'frames' => ['label' => 'Frames'],
            'metres' => ['label' => 'In metres'],
            'rolls' => ['label' => '400 ft rolls (100 ft for 8 mm formats)'],
            'perMin' => ['label' => 'Feet per minute'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
