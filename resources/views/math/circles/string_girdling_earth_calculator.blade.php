<x-calc.page
    title="String Girdling Earth Calculator - SolveKit"
    description="String girdling Earth calculator: add a little string to a loop around the Earth and see how high it lifts (extra ÷ 2π), or how high it rises when pulled up at one point."
    lede="Lift a string around the Earth."
    about="Wrap a string tightly around the equator, add 1 m, and spread the slack evenly: the gap is 1/(2π) ≈ 16 cm all the way round, whatever the size of the sphere. Pulled up at a single point instead, the same 1 m lifts it about 121 m. Also known as rope around the Earth calculator."
    :calc="['engine' => 'mt-tri', 'tool' => 'girdle', 'fields' => ['r', 'extra', 'unit']]"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'How high does 1 m of extra string lift a loop around the Earth?', 'answer' => '0.1591549431 m everywhere, or 121.4607232 m if pulled up at one point.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="r" label="Radius of the sphere" value="6371000" min="0" step="any" />
        <x-calc.field name="extra" label="Extra string" value="1" min="0" step="any" />
        <x-calc.select name="unit" label="Unit" :options="['mm' => 'mm', 'cm' => 'cm', 'm' => 'm', 'km' => 'km', 'in' => 'in', 'ft' => 'ft', 'yd' => 'yd', 'mi' => 'mi', 'units' => 'No unit']" selected="m" />
    </div>

    <x-calc.result label="Even gap" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['r' => 6371000, 'extra' => 1, 'unit' => 'm'],
        'Football' => ['r' => 0.11, 'extra' => 1, 'unit' => 'm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'gap' => ['label' => 'Even gap'],
            'peak' => ['label' => 'Height if pulled up at one point'],
            'circ' => ['label' => 'Original circumference'],
            'reverse' => ['label' => 'Reverse'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>h = extra ÷ 2π</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
