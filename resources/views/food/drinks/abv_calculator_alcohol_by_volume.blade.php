<x-calc.page
    title="ABV Calculator (Alcohol by Volume) - SolveKit"
    description="Free ABV calculator: alcohol by volume of beer, wine or cider from original and final gravity or refractometer Brix readings, with alcohol by weight, attenuation and calories."
    lede="Find the alcohol content of your homebrew."
    about="Fermentation turns sugar into alcohol and CO₂, so the gravity falls. The standard homebrew formula is ABV = (OG − FG) × 131.25; above about 1.070 a more accurate formula is used. After fermentation alcohol skews refractometer readings, so final Brix is converted with Sean Terrill's formula. Calories per 12 fl oz use the ASBC formula from alcohol and real extract."
    :calc="['engine' => 'fd-drinks', 'tool' => 'abv', 'fields' => ['mode', 'og', 'fg', 'brix_start', 'brix_end']]"
    :how-to="[
        ['name' => 'Choose hydrometer or refractometer', 'text' => ''],
        ['name' => 'Enter the readings', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the ABV of a beer from 1.050 to 1.010?', 'answer' => '5.25%.'],
        ['question' => 'And a wine from 1.090 to 0.995?', 'answer' => '13.2%.'],
        ['question' => 'From 12.4 to 6.2 Brix on a refractometer?', 'answer' => '5.04% (OG 1.050, FG 1.012 (Terrill, wort correction 1.04)).'],
    ]"
>
    <x-calc.segmented name="mode" legend="Readings" :options="['gravity' => 'Hydrometer (SG)', 'brix' => 'Refractometer (Brix)']" selected="gravity" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="mode:gravity">
            <x-calc.field name="og" label="Original gravity" value="1.05" min="0.99" step="0.001" />
        </div>
        <div data-show-when="mode:gravity">
            <x-calc.field name="fg" label="Final gravity" value="1.01" min="0.98" step="0.001" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="mode:brix" hidden>
            <x-calc.field name="brix_start" label="Original Brix" value="12.4" min="0" step="0.1" />
        </div>
        <div data-show-when="mode:brix" hidden>
            <x-calc.field name="brix_end" label="Final Brix (uncorrected)" value="6.2" min="0" step="0.1" />
        </div>
    </div>

    <x-calc.result label="Alcohol by volume" />

    <x-calc.options :decimals="false" :examples="[
        'Pale ale' => ['mode' => 'gravity', 'og' => 1.05, 'fg' => 1.01, 'brix_start' => 12.4, 'brix_end' => 6.2],
        'Wine' => ['mode' => 'gravity', 'og' => 1.09, 'fg' => 0.995, 'brix_start' => 12.4, 'brix_end' => 6.2],
        'Refractometer' => ['mode' => 'brix', 'og' => 1.05, 'fg' => 1.01, 'brix_start' => 12.4, 'brix_end' => 6.2],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'standard' => ['label' => 'Standard formula'],
            'alternate' => ['label' => 'High-gravity formula'],
            'abw' => ['label' => 'Alcohol by weight'],
            'attenuation' => ['label' => 'Attenuation'],
            'calories' => ['label' => 'Calories'],
            'gravity' => ['label' => 'Gravity'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>ABV = (OG − FG) × 131.25</li>
            <li>ABV = 76.08 (OG − FG) ÷ (1.775 − OG) × FG ÷ 0.794</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
