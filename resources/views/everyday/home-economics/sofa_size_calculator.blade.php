<x-calc.page
    title="Sofa Size Calculator - SolveKit"
    description="Free sofa size calculator: the right sofa length for a wall and whether a sofa fits through your door."
    lede="Choose a sofa length that suits your wall, and check it fits through the door."
    about="Designers often suggest a sofa about two-thirds the length of its wall, and at least half. To get a sofa through a door, its depth or height (whichever is smaller) must be less than the door's clear width; hallways and turns are not checked here."
    :calc="['engine' => 'ev-home', 'tool' => 'sofa', 'fields' => ['wall', 'depth', 'height', 'door_width'], 'unitFields' => ['wall' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'depth' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'height' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'door_width' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all()]]"
    :how-to="[
        ['name' => 'Enter the wall length', 'text' => 'Where the sofa will go.'],
        ['name' => 'Enter the sofa and door', 'text' => 'To check it fits through.'],
    ]"
    :faqs="[
        ['question' => 'How long a sofa for a 12 ft wall?', 'answer' => 'About 8 ft (96 in), and at least 6 ft.'],
        ['question' => 'Will a 36 in deep sofa fit through a 32 in door?', 'answer' => 'Not if its back is also over 32 in tall; removing the legs or the door may help.'],
        ['question' => 'What is a standard door width?', 'answer' => 'Often 30–36 inches; measure the clear opening.'],
    ]"
>
    <x-calc.field name="wall" label="Wall length" value="12" min="0" placeholder="Wall length">
        <label for="calc-wall-unit" class="sr-only">Wall length unit</label>
        <select id="calc-wall-unit" name="wall-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
            @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
            @endforeach
        </select>
    </x-calc.field>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="depth" label="Sofa depth (optional)" value="36" min="0" placeholder="Sofa depth (optional)">
            <label for="calc-depth-unit" class="sr-only">Sofa depth (optional) unit</label>
            <select id="calc-depth-unit" name="depth-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="height" label="Sofa back height" value="34" min="0" placeholder="Sofa back height">
            <label for="calc-height-unit" class="sr-only">Sofa back height unit</label>
            <select id="calc-height-unit" name="height-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="door_width" label="Door clear width" value="32" min="0" placeholder="Door clear width">
            <label for="calc-door_width-unit" class="sr-only">Door clear width unit</label>
            <select id="calc-door_width-unit" name="door_width-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Sofa length (about two-thirds of the wall)" />

    <x-calc.options :examples="[
        '12 ft wall, 32 in door' => ['wall' => 12, 'wall-unit' => 'ft', 'depth' => 36, 'depth-unit' => 'in', 'height' => 34, 'height-unit' => 'in', 'door_width' => 32, 'door_width-unit' => 'in'],
        'Fits through' => ['wall' => 10, 'wall-unit' => 'ft', 'depth' => 34, 'depth-unit' => 'in', 'height' => 30, 'height-unit' => 'in', 'door_width' => 32, 'door_width-unit' => 'in'],
        'Metric' => ['wall' => 3.6, 'wall-unit' => 'm', 'depth' => 90, 'depth-unit' => 'cm', 'height' => 85, 'height-unit' => 'cm', 'door_width' => 80, 'door_width-unit' => 'cm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'range' => ['label' => 'Good range'],
            'door' => ['label' => 'Through the door'],
            'note' => ['label' => 'Note'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>length ≈ ⅔ × wall</li>
            <li>fits if min(depth, height) ≤ door width</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
