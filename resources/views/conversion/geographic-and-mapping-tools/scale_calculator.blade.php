@php
    $lengthUnits = collect(config('units.length'))->only(['mm', 'cm', 'm', 'km', 'in', 'ft', 'yd', 'mi'])->all();
    $unitSelect = 'h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40';
@endphp

<x-calc.page
    title="Scale Calculator - SolveKit"
    description="Professional scale calculator for maps, drawings and models. Calculate map scales, ratios and convert between different scale representations."
    lede="Find a map or drawing scale, or use a scale to convert between map and real distances."
    about="A scale of 1:N means one unit on the map or drawing is N of the same units in reality. The scale is the real distance divided by the map distance, once both are in the same unit. Enlargements, such as a 5:1 detail drawing, are shown the other way round."
    :calc="['engine' => 'scale', 'lengthUnits' => $lengthUnits]"
    :how-to="[
        ['name' => 'Choose what to find', 'text' => 'The scale, a real distance or a map distance.'],
        ['name' => 'Fill in the two known values', 'text' => 'Distances can use different units; they are converted first.'],
    ]"
    :faqs="[
        ['question' => 'What does 1:25,000 mean?', 'answer' => '1 cm on the map is 25,000 cm (250 m) on the ground, so 4 cm is 1 km.'],
        ['question' => 'Is 1:10,000 a large or small scale?', 'answer' => 'Large: the fraction 1/10,000 is larger than 1/1,000,000, so more detail is shown.'],
        ['question' => 'How do I find a model\'s scale?', 'answer' => 'Divide the real length by the model\'s length in the same unit. A 4.5 m car modelled at 25 cm is 1:18.'],
    ]"
>
    <x-calc.segmented name="mode" legend="Find" :options="['scale' => 'Scale', 'real' => 'Real distance', 'map' => 'Map distance']" selected="scale" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="mode:scale,real">
            <x-calc.field name="map" label="Map distance" value="4" min="0" placeholder="Map">
                <label for="calc-map-unit" class="sr-only">Map distance unit</label>
                <select id="calc-map-unit" name="map-unit" class="{{ $unitSelect }}">
                    @foreach($lengthUnits as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:scale,map">
            <x-calc.field name="real" label="Real distance" value="1" min="0" placeholder="Real">
                <label for="calc-real-unit" class="sr-only">Real distance unit</label>
                <select id="calc-real-unit" name="real-unit" class="{{ $unitSelect }}">
                    @foreach($lengthUnits as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'km')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:real,map" hidden>
            <x-calc.field name="ratio" label="Scale 1 :" value="25000" min="0" placeholder="e.g. 25000" />
        </div>
    </div>

    <x-calc.result label="Scale" />

    <x-calc.options :examples="[
        'Hiking map 1:25,000' => ['mode' => 'real', 'ratio' => 25000, 'map' => 7.5, 'map-unit' => 'cm', 'real-unit' => 'km'],
        'Model car 25 cm vs 4.5 m' => ['mode' => 'scale', 'map' => 25, 'map-unit' => 'cm', 'real' => 4.5, 'real-unit' => 'm'],
        'Floor plan 1:50' => ['mode' => 'map', 'ratio' => 50, 'real' => 6, 'real-unit' => 'm', 'map-unit' => 'cm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="This scale" :rows="[
            'ratio' => ['label' => 'Ratio'],
            'cm' => ['label' => '1 cm on the map is'],
            'in' => ['label' => '1 in on the map is'],
            'km' => ['label' => '1 km is drawn as'],
            'mi' => ['label' => '1 mi is drawn as'],
            'type' => ['label' => 'Kind of scale'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>N = real distance ÷ map distance (same units)</li>
            <li>real = map × N · map = real ÷ N</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
