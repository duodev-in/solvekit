<x-calc.page
    title="Angle of Depression Calculator - SolveKit"
    description="Free angle of depression calculator: the downward angle from a height to a point, or the horizontal distance from the angle and height, with line of sight."
    lede="Work out an angle of depression, or the distance from it."
    about="Looking down from a height h to a point a horizontal distance d away, tan θ = h ÷ d. The angle of depression from the top equals the angle of elevation from the bottom."
    :calc="['engine' => 'con-trig', 'tool' => 'angle_of_depression', 'fields' => ['mode', 'height', 'distance', 'angle'], 'unitFields' => ['height' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'distance' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all()]]"
    :how-to="[
        ['name' => 'Choose what to find', 'text' => 'Angle or distance.'],
        ['name' => 'Enter the height', 'text' => 'And the distance or angle.'],
    ]"
    :faqs="[
        ['question' => 'What is the angle from 50 ft up to a point 120 ft away?', 'answer' => '22.6°.'],
        ['question' => 'Is depression the same as elevation?', 'answer' => 'Numerically yes: they are alternate angles.'],
        ['question' => 'How far is a point 25° down from 50 ft?', 'answer' => 'About 107 ft.'],
    ]"
>
    <x-calc.segmented name="mode" legend="Find" :options="['angle' => 'Angle', 'distance' => 'Distance']" selected="angle" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="height" label="Height" value="50" min="0" placeholder="Height">
            <label for="calc-height-unit" class="sr-only">Height unit</label>
            <select id="calc-height-unit" name="height-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <div data-show-when="mode:angle">
            <x-calc.field name="distance" label="Horizontal distance" value="120" min="0" placeholder="Horizontal distance">
                <label for="calc-distance-unit" class="sr-only">Horizontal distance unit</label>
                <select id="calc-distance-unit" name="distance-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
    </div>

    <div data-show-when="mode:distance" hidden>
        <x-calc.field name="angle" label="Angle of depression" value="25" min="0.01" max="89.99" suffix="°" />
    </div>

    <x-calc.result label="Angle of depression" />

    <x-calc.options :examples="[
        '50 ft up, 120 ft out' => ['mode' => 'angle', 'height' => 50, 'height-unit' => 'ft', 'distance' => 120, 'distance-unit' => 'ft'],
        '25° from 50 ft' => ['mode' => 'distance', 'height' => 50, 'height-unit' => 'ft', 'angle' => 25],
        'Drone 100 m, 300 m' => ['mode' => 'angle', 'height' => 100, 'height-unit' => 'm', 'distance' => 300, 'distance-unit' => 'm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'angle' => ['label' => 'Angle'],
            'height' => ['label' => 'Height'],
            'distance' => ['label' => 'Distance'],
            'sight' => ['label' => 'Line of sight'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>tan θ = height ÷ distance</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
