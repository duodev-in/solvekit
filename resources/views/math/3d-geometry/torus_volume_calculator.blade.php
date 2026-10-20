<x-calc.page
    title="Torus Volume Calculator - SolveKit"
    description="Free torus volume calculator: V = 2π²Rr² for a doughnut shape, from the major and minor radius or the inner and outer radii."
    lede="Find the volume of a torus."
    about="A torus is a circle of radius r swept around an axis at distance R. By Pappus's theorem its volume is the circle's area times the distance travelled: πr² × 2πR = 2π²Rr²."
    :calc="['engine' => 'mt-shape', 'tool' => 'shape', 'fields' => ['given', 'unit', 'major', 'minor', 'outer', 'inner', 'vol', 'surf'], 'shape' => 'torus', 'want' => 'vol']"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'What is the volume of a torus with R = 4 and r = 1?', 'answer' => '78.95683521 cm³.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="given" label="I know" :options="['major_minor' => 'Major radius R (centre to tube centre) and minor radius r (tube)', 'outer_inner' => 'Outer radius R + r and inner (hole) radius R − r', 'vol_major' => 'Volume V and major radius R (centre to tube centre)', 'surf_major' => 'Surface area A and major radius R (centre to tube centre)']" selected="major_minor" />
        <x-calc.select name="unit" label="Unit" :options="['mm' => 'mm', 'cm' => 'cm', 'm' => 'm', 'km' => 'km', 'in' => 'in', 'ft' => 'ft', 'yd' => 'yd', 'mi' => 'mi', 'units' => 'No unit']" selected="cm" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:major_minor,vol_major,surf_major" hidden>
            <x-calc.field name="major" label="Major radius R (centre to tube centre)" value="4" min="0" step="any" />
        </div>
        <div data-show-when="given:major_minor" hidden>
            <x-calc.field name="minor" label="Minor radius r (tube)" value="1" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:outer_inner" hidden>
            <x-calc.field name="outer" label="Outer radius R + r" value="5" min="0" step="any" />
        </div>
        <div data-show-when="given:outer_inner" hidden>
            <x-calc.field name="inner" label="Inner (hole) radius R − r" value="3" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:vol_major" hidden>
            <x-calc.field name="vol" label="Volume V (unit³)" value="78.9568" min="0" step="any" />
        </div>
        <div data-show-when="given:surf_major" hidden>
            <x-calc.field name="surf" label="Surface area A (unit²)" value="157.914" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="Volume V" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['given' => 'major_minor', 'unit' => 'cm', 'major' => 4, 'minor' => 1, 'outer' => 5, 'inner' => 3, 'vol' => 78.9568, 'surf' => 157.914],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Diagram" name="diagram" />
        <x-calc.rows heading="Details" :rows="[
            'major' => ['label' => 'Major radius R (centre to tube centre)'],
            'minor' => ['label' => 'Minor radius r (tube)'],
            'outer' => ['label' => 'Outer radius R + r'],
            'inner' => ['label' => 'Inner (hole) radius R − r'],
            'vol' => ['label' => 'Volume V'],
            'surf' => ['label' => 'Surface area A'],
            'areas' => ['label' => 'Surface area in other units'],
            'volumes' => ['label' => 'Volume in other units'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>V = 2π²Rr²</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
