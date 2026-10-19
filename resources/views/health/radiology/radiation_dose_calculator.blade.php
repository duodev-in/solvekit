<x-calc.page
    title="Radiation Dose Calculator - SolveKit"
    description="Free radiation dose calculator: your yearly radiation from radon at home, elevation, flights and medical imaging, against the US average of 6.2 mSv."
    lede="Estimate your yearly radiation dose."
    about="NCRP Report 160 (2009) puts the average US dose at 6.2 mSv a year: radon and thoron 2.28, cosmic 0.33, terrestrial 0.21 and internal 0.29 mSv, plus about 3 mSv from medical imaging. Cosmic radiation rises with altitude (ANS dose chart), flying adds about 0.005 mSv an hour, and home radon above 4 pCi/L (148 Bq/m³) is the EPA action level. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-misc', 'tool' => 'radiation_dose', 'fields' => ['radon', 'radon_unit', 'elevation', 'elevation_unit', 'flight_hours', 'xrays', 'ct']]"
    :how-to="[
        ['name' => 'Enter home radon if tested', 'text' => ''],
        ['name' => 'Enter elevation, flights and imaging', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the yearly dose at 500 ft with 20 flight hours and one X-ray?', 'answer' => '3.24 mSv a year.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="radon" label="Home radon (blank = US average)" value="" min="0" step="any" placeholder="1.3" />
        <x-calc.select name="radon_unit" label="Radon unit" :options="['pci' => 'pCi/L', 'bq' => 'Bq/m³']" selected="pci" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="elevation" label="Elevation where you live" value="500" min="0" step="any" />
        <x-calc.select name="elevation_unit" label="Elevation unit" :options="['ft' => 'feet', 'm' => 'metres']" selected="ft" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="flight_hours" label="Flight hours a year" value="20" min="0" step="any" suffix="h" />
        <x-calc.field name="xrays" label="X-rays a year" value="1" min="0" step="1" />
        <x-calc.field name="ct" label="CT scans a year" value="0" min="0" step="1" />
    </div>

    <x-calc.result label="Estimated annual dose" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['radon' => '', 'radon_unit' => 'pci', 'elevation' => 500, 'elevation_unit' => 'ft', 'flight_hours' => 20, 'xrays' => 1, 'ct' => 0],
        'Denver, high radon' => ['radon' => 6, 'radon_unit' => 'pci', 'elevation' => 1600, 'elevation_unit' => 'm', 'flight_hours' => 60, 'xrays' => 0, 'ct' => 1],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'radon' => ['label' => 'Radon'],
            'note' => ['label' => 'Note'],
            'source' => ['label' => 'Source'],
        ]" />
        <x-calc.grid heading="Sources" name="sources" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>dose = radon + cosmic + terrestrial + internal + flights + medical</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
