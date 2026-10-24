<x-calc.page
    title="Chmod Calculator - SolveKit"
    description="Free chmod calculator: convert Unix permissions between octal (755) and symbolic (rwxr-xr-x), with the command."
    lede="Work out file permissions."
    about="Unix permissions give read, write and execute rights to the owner, the group and everyone else."
    :calc="['engine' => 'tc-text', 'tool' => 'chmod', 'fields' => ['mode'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What is chmod 755?', 'answer' => 'rwxr-xr-x: the owner can read, write and run it; others can read and run it.'],
    ]"
>
    <x-calc.field name="mode" label="Permissions (755, 0644, 4755 or rwxr-xr-x)" value="755" type="text" inputmode="text" />

    <x-calc.result label="chmod" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mode' => '755'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'octal' => ['label' => 'Octal'],
            'symbolic' => ['label' => 'Symbolic'],
            'command' => ['label' => 'Command'],
            'owner' => ['label' => 'Owner'],
            'group' => ['label' => 'Group'],
            'others' => ['label' => 'Others'],
            'special' => ['label' => 'Special bits'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
