<x-calc.page
    title="Minecraft End Portal Finder - SolveKit"
    description="Free Minecraft end portal finder: locate a stronghold from two Eye of Ender throws."
    lede="Find the stronghold."
    about="Two throws of an Eye of Ender from different places give two lines that cross near the stronghold."
    :calc="['engine' => 'ot-play', 'tool' => 'mc_portal', 'fields' => ['x1', 'z1', 'a1', 'x2', 'z2', 'a2'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'Where is the stronghold in the example?', 'answer' => 'Near X 998, Z 1496.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="x1" label="Throw 1: X" value="0" step="any" />
        <x-calc.field name="z1" label="Throw 1: Z" value="0" step="any" />
        <x-calc.field name="a1" label="Throw 1: facing angle (F3 yaw, °)" value="-33.7" step="any" />
        <x-calc.field name="x2" label="Throw 2: X" value="600" step="any" />
        <x-calc.field name="z2" label="Throw 2: Z" value="-200" step="any" />
        <x-calc.field name="a2" label="Throw 2: facing angle (°)" value="-13.2" step="any" />
    </div>

    <x-calc.result label="Estimated stronghold" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['x1' => 0, 'z1' => 0, 'a1' => -33.7, 'x2' => 600, 'z2' => -200, 'a2' => -13.2],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'distance' => ['label' => 'Distance from throw 2'],
            'nether' => ['label' => 'Nether coordinates (÷ 8)'],
            'quality' => ['label' => 'Reliability'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
