<x-calc.page
    title="UUID Generator - SolveKit"
    description="Free UUID generator: random version 4 or time-ordered version 7 UUIDs."
    lede="Generate UUIDs."
    about="A UUID is a 128-bit identifier that is practically unique without a central registry."
    :calc="['engine' => 'tc-text', 'tool' => 'uuid', 'fields' => ['count', 'version', 'caseOut'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'Are these UUIDs safe to use as IDs?', 'answer' => 'Yes: they use your browser’s cryptographic random source (RFC 9562).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="count" label="How many" value="5" min="1" step="any" />
        <x-calc.select name="version" label="Version" :options="['v4' => 'Version 4 (random)', 'v7' => 'Version 7 (time-ordered)']" selected="v4" />
        <x-calc.select name="caseOut" label="Letters" :options="['lower' => 'lowercase', 'upper' => 'UPPERCASE']" selected="lower" />
    </div>

    <x-calc.result label="UUIDs" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['count' => 5, 'version' => 'v4', 'caseOut' => 'lower'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'version' => ['label' => 'Version'],
            'bits' => ['label' => 'Random bits each'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
