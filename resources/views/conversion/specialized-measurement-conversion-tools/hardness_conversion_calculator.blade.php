@php
    $scales = config('hardness.scales');
@endphp

<x-calc.page
    title="Hardness Conversion Calculator - SolveKit"
    description="Professional hardness conversion calculator for materials testing. Convert between Rockwell, Brinell, Vickers, Shore, and other hardness scales with precision."
    lede="Convert steel hardness between Rockwell C, Vickers, Brinell and Rockwell A."
    about="Hardness scales measure different things (indent depth, indent size, load), so there is no exact formula between them. This calculator uses the ASTM E140 table of approximate equivalents for non-austenitic steels and interpolates between its rows. Results outside HRC 20 to 68 are not given, and other materials or scales such as Shore need their own tables."
    :calc="['engine' => 'hardness', 'scales' => $scales, 'rows' => config('hardness.rows')]"
    :how-to="[
        ['name' => 'Enter the measured hardness', 'text' => 'Choose the scale it was measured on.'],
        ['name' => 'Choose the target scale', 'text' => 'All four scales are listed beside the result.'],
    ]"
    :faqs="[
        ['question' => 'What is HRC 60 in Vickers?', 'answer' => 'About 697 HV, and about 81 HRA.'],
        ['question' => 'Are hardness conversions exact?', 'answer' => 'No. They are empirical equivalents for steel. For acceptance testing, measure on the scale the specification names.'],
        ['question' => 'Why is there no Brinell value above HRC 59?', 'answer' => 'Above about 650 HBW the standard Brinell test is outside its valid range.'],
        ['question' => 'Can I convert Shore hardness?', 'answer' => 'Not with this table. Shore scales are for rubbers and plastics and do not map reliably to metal scales.'],
    ]"
>
    <x-calc.unit-pair :units="$scales" from="hrc" to="hv" value="60" label="Hardness" />

    <x-calc.result label="Vickers" />

    <x-calc.options :examples="[
        'Knife blade 58 HRC' => ['value' => 58, 'from' => 'hrc'],
        'Tool steel 700 HV' => ['value' => 700, 'from' => 'hv'],
        'Mild steel 250 HBW' => ['value' => 250, 'from' => 'hb'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="On every scale" :grow="true" :rows="collect($scales)->mapWithKeys(fn ($scale, $key) => [$key => ['label' => $scale['name'], 'unit' => $scale['symbol']]])->all()" />
    </x-slot:panel>

    <x-slot:formula>
        <p>Equivalents from ASTM E140, Table 1 (non-austenitic steels), interpolated linearly between rows.</p>
        <ul class="grid grid-cols-2 gap-x-6 gap-y-1 font-mono text-[13px]">
            <li>HRC 60 ≈ 697 HV ≈ 81.2 HRA</li>
            <li>HRC 50 ≈ 513 HV ≈ 481 HBW</li>
            <li>HRC 40 ≈ 392 HV ≈ 371 HBW</li>
            <li>HRC 20 ≈ 238 HV ≈ 226 HBW</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
