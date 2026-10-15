@php
    $tables = [
        'Length' => config('units.weird_length'),
        'Time' => config('units.weird_time'),
        'Data' => config('units.weird_data'),
        'Mass' => config('units.weird_mass'),
    ];
    $units = [];
    $groups = [];
    foreach ($tables as $quantity => $table) {
        foreach ($table as $key => $unit) {
            $units[Str::slug($quantity).'.'.$key] = $unit;
            $groups[$quantity][] = Str::slug($quantity).'.'.$key;
        }
    }
@endphp

<x-calc.page
    title="Weird Units Converter - SolveKit"
    description="Fun weird units converter for unusual and unconventional measurements. Convert between Smoots, Beard-seconds, Bananas, Libraries of Congress, and other quirky measurement units."
    lede="Measure things in smoots, bananas, beard-seconds, floppy disks and other unusual units."
    about="These units are real in the sense that people use them, but most have no official definition. The values used are shown in each unit's name, such as a 7-inch banana or a 10 TB Library of Congress, so treat results as fun estimates. Units only convert within the same kind of quantity."
    :calc="['engine' => 'units', 'units' => $units, 'groups' => $groups, 'list' => array_keys($units), 'min' => 0]"
    :how-to="[
        ['name' => 'Pick a unit', 'text' => 'Length, time, data or mass; the target stays in the same kind.'],
        ['name' => 'Enter a value', 'text' => 'Every unit of that kind is listed beside the result.'],
    ]"
    :faqs="[
        ['question' => 'What is a smoot?', 'answer' => 'The height of Oliver Smoot, 1.7018 m. MIT students used him to measure the Harvard Bridge in 1958: 364.4 smoots.'],
        ['question' => 'What is a beard-second?', 'answer' => 'The length a beard grows in one second, usually taken as 5 nanometers.'],
        ['question' => 'How big is a Library of Congress?', 'answer' => 'An informal unit for a large amount of data, often quoted as about 10 terabytes of text.'],
    ]"
>
    <x-calc.unit-pair :units="$units" :groups="$groups" from="length.m" to="length.smoot" value="100" min="0" label="Value" />

    <x-calc.result label="Smoots">
        <p class="text-xs text-slate-500" data-ref="ratio"></p>
    </x-calc.result>

    <x-calc.options :examples="[
        'Harvard Bridge 620 m' => ['value' => 620, 'from' => 'length.m', 'to' => 'length.smoot'],
        'Film 4.7 GB' => ['value' => 4.7, 'from' => 'data.gb', 'to' => 'data.floppy'],
        'Car 1,500 kg' => ['value' => 1500, 'from' => 'mass.kg', 'to' => 'mass.penny'],
    ]" />

    <x-slot:panel>
        <x-calc.unit-list :units="$units" heading="In other units" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="grid grid-cols-2 gap-x-6 gap-y-1 font-mono text-[13px]">
            <li>1 smoot = 1.7018 m</li>
            <li>1 banana = 7 in</li>
            <li>1 microcentury ≈ 52.6 min</li>
            <li>1 floppy = 1,474,560 B</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
