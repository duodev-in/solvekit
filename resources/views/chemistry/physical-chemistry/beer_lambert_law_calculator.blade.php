<x-calc.page
    title="Beer–Lambert Law Calculator - SolveKit"
    description="Free Beer-Lambert law calculator: solve A = εcl for absorbance, molar absorptivity, concentration or path length."
    lede="Solve A = εcl for absorbance, ε, concentration or path length."
    about="The Beer–Lambert law says absorbance is proportional to concentration and path length. It holds best for absorbances of about 0.1 to 1; above that, dilute the sample."
    :calc="['engine' => 'lab', 'tool' => 'beer_lambert', 'fields' => ['solve', 'absorbance', 'epsilon', 'concentration', 'path']]"
    :how-to="[
        ['name' => 'Choose what to solve for', 'text' => 'Most often the concentration.'],
        ['name' => 'Enter the other three', 'text' => 'ε in M⁻¹cm⁻¹, c in M and l in cm.'],
    ]"
    :faqs="[
        ['question' => 'What is a typical path length?', 'answer' => '1 cm for a standard cuvette. Microvolume spectrophotometers use shorter paths and normalize to 1 cm.'],
        ['question' => 'What is ε for NADH?', 'answer' => '6,220 M⁻¹cm⁻¹ at 340 nm.'],
        ['question' => 'How do absorbance and transmittance relate?', 'answer' => 'T = 10⁻ᴬ, so A = 1 lets 10% of the light through.'],
    ]"
>
    <x-calc.select name="solve" label="Solve for" :options="['concentration' => 'Concentration c (M)', 'absorbance' => 'Absorbance A', 'epsilon' => 'Molar absorptivity ε', 'path' => 'Path length l']" selected="concentration" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="solve:epsilon,concentration,path">
            <x-calc.field name="absorbance" label="Absorbance A" value="0.5" min="0" />
        </div>
        <div data-show-when="solve:absorbance,concentration,path">
            <x-calc.field name="epsilon" label="Molar absorptivity ε" value="6220" min="0" suffix="M⁻¹cm⁻¹" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="solve:absorbance,epsilon,path" hidden>
            <x-calc.field name="concentration" label="Concentration c" value="0.0001" min="0" suffix="M" />
        </div>
        <div data-show-when="solve:absorbance,epsilon,concentration">
            <x-calc.field name="path" label="Path length l" value="1" min="0" suffix="cm" />
        </div>
    </div>

    <x-calc.result label="Result" />

    <x-calc.options :examples="[
        'NADH at 340 nm' => ['solve' => 'concentration', 'absorbance' => 0.5, 'epsilon' => 6220, 'path' => 1],
        'Absorbance of 50 µM' => ['solve' => 'absorbance', 'epsilon' => 6220, 'concentration' => 5e-05, 'path' => 1],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'transmittance' => ['label' => 'Transmittance'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>A = ε × c × l</li>
            <li>T = 10⁻ᴬ</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
