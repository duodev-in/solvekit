<x-calc.page
    title="Visual Acuity Converter - SolveKit"
    description="Free visual acuity converter: convert Snellen (20/x or 6/x), decimal and logMAR vision scores, with the WHO vision impairment category."
    lede="Convert vision test results."
    about="Snellen fractions compare the distance you read a line at with the distance a typical eye can: 20/40 (6/12 in metres) means you see at 20 ft what typical eyes see at 40. Decimal acuity = numerator ÷ denominator; logMAR = −log₁₀(decimal). WHO categories: mild impairment worse than 6/12, moderate worse than 6/18, severe worse than 6/60. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-life', 'tool' => 'acuity', 'fields' => ['scale', 'snellen', 'value', 'value2']]"
    :how-to="[
        ['name' => 'Choose the scale', 'text' => ''],
        ['name' => 'Enter the value', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is 20/40 in metres and logMAR?', 'answer' => '6/12.0 metric, decimal 0.50, logMAR 0.30.'],
        ['question' => 'What is 6/60?', 'answer' => '20/200.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="scale" label="You have" :options="['snellen' => 'Snellen (20/40 or 6/12)', 'decimal' => 'Decimal', 'logmar' => 'logMAR']" selected="snellen" />
        <div data-show-when="scale:snellen">
            <x-calc.field name="snellen" label="Snellen" value="20/40" type="text" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="scale:decimal" hidden>
            <x-calc.field name="value" label="Decimal acuity" value="0.5" step="any" />
        </div>
        <div data-show-when="scale:logmar" hidden>
            <x-calc.field name="value2" label="logMAR" value="0.3" step="any" />
        </div>
    </div>

    <x-calc.result label="Snellen (feet)" />

    <x-calc.options :decimals="false" :examples="[
        '20/40' => ['scale' => 'snellen', 'snellen' => '20/40', 'value' => 0.5, 'value2' => 0.3],
        '6/60' => ['scale' => 'snellen', 'snellen' => '6/60', 'value' => 0.5, 'value2' => 0.3],
        'Decimal 0.8' => ['scale' => 'decimal', 'snellen' => '20/40', 'value' => 0.8, 'value2' => 0.3],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'metric' => ['label' => 'Metric Snellen'],
            'decimal' => ['label' => 'Decimal'],
            'logmar' => ['label' => 'logMAR'],
            'band' => ['label' => 'WHO category'],
            'driving' => ['label' => 'Driving'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>logMAR = log₁₀(denominator ÷ numerator)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
