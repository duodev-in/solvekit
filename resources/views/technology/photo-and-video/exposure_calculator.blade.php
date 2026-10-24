<x-calc.page
    title="Exposure Calculator - SolveKit"
    description="Free exposure calculator: exposure value from aperture, shutter and ISO, or the missing setting for an EV."
    lede="Work out exposure settings."
    about="Exposure value combines aperture and shutter speed; equal EVs give the same brightness."
    :calc="['engine' => 'tc-photo', 'tool' => 'exposure', 'fields' => ['solve', 'n', 't', 'iso', 'ev'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What EV is f/8 at 1/250 s, ISO 100?', 'answer' => 'EV 14.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="solve" label="Find" :options="['ev' => 'Exposure value (EV)', 'shutter' => 'Shutter speed', 'aperture' => 'Aperture', 'iso' => 'ISO']" selected="ev" />
        <div data-show-when="solve:ev,shutter,iso">
            <x-calc.field name="n" label="Aperture (f-number)" value="8" min="0" step="any" />
        </div>
        <div data-show-when="solve:ev,aperture,iso">
            <x-calc.field name="t" label="Shutter speed (1/x s; e.g. 250)" value="250" min="0" step="any" />
        </div>
        <div data-show-when="solve:ev,shutter,aperture">
            <x-calc.field name="iso" label="ISO" value="100" min="0" step="any" />
        </div>
        <div data-show-when="solve:shutter,aperture,iso">
            <x-calc.field name="ev" label="Exposure value at ISO 100 (EV₁₀₀)" value="15" step="any" />
        </div>
    </div>

    <x-calc.result label="Result" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['solve' => 'ev', 'n' => 8, 't' => 250, 'iso' => 100, 'ev' => 15],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'ev100' => ['label' => 'EV at ISO 100'],
            'scene' => ['label' => 'Typical scene'],
            'equivalents' => ['label' => 'Equivalent exposures'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
