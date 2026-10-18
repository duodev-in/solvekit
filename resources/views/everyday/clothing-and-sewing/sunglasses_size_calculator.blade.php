<x-calc.page
    title="Sunglasses Size Calculator - SolveKit"
    description="Free sunglasses size calculator: frame width to fit your face, and the total width of a frame from its lens-bridge-temple numbers."
    lede="Find the sunglasses frame width that fits your face."
    about="Frames are marked lens width – bridge – temple length in mm (e.g. 52-18-140). Total frame width ≈ 2 × lens + bridge + about 8 mm for the hinges. A good fit is within about 5 mm of the width across your face at the temples. Small, medium and large are rough groupings that vary by brand."
    :calc="['engine' => 'ev-clothing', 'tool' => 'sunglasses', 'fields' => ['face', 'lens', 'bridge', 'temple', 'endpieces'], 'unitFields' => ['face' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all()]]"
    :how-to="[
        ['name' => 'Measure your face width', 'text' => 'Between the temples, with a ruler in a mirror.'],
        ['name' => 'Enter a frame you own', 'text' => 'From the numbers inside the arm.'],
    ]"
    :faqs="[
        ['question' => 'What does 52-18-140 mean?', 'answer' => '52 mm lenses, an 18 mm bridge and 140 mm arms.'],
        ['question' => 'How wide is a 52-18 frame?', 'answer' => 'About 130 mm.'],
        ['question' => 'How do I measure my face width?', 'answer' => 'Across the face at the temples, just beside the eyes.'],
    ]"
>
    <x-calc.field name="face" label="Face width at the temples (optional)" value="13.5" min="0" placeholder="Face width at the temples (optional)">
        <label for="calc-face-unit" class="sr-only">Face width at the temples (optional) unit</label>
        <select id="calc-face-unit" name="face-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
            @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
            @endforeach
        </select>
    </x-calc.field>

    <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">
        <x-calc.field name="lens" label="Lens width" value="52" min="30" max="80" suffix="mm" />
        <x-calc.field name="bridge" label="Bridge" value="18" min="10" max="30" suffix="mm" />
        <x-calc.field name="temple" label="Temple" value="140" min="100" max="170" suffix="mm" />
        <x-calc.field name="endpieces" label="Hinges (both)" value="8" min="0" max="20" suffix="mm" />
    </div>

    <x-calc.result label="Frame width to look for" />

    <x-calc.options :decimals="false" :examples="[
        'Face 13.5 cm, 52-18-140' => ['face' => 13.5, 'face-unit' => 'cm', 'lens' => 52, 'bridge' => 18, 'temple' => 140, 'endpieces' => 8],
        'Frame only 58-14' => ['face' => '', 'face-unit' => 'cm', 'lens' => 58, 'bridge' => 14, 'temple' => 135, 'endpieces' => 8],
        'Wide face' => ['face' => 5.75, 'face-unit' => 'in', 'lens' => 55, 'bridge' => 18, 'temple' => 145, 'endpieces' => 8],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'size' => ['label' => 'Size group'],
            'frame' => ['label' => 'Your frame'],
            'temple' => ['label' => 'Temple length'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>frame ≈ 2 × lens + bridge + hinges</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
