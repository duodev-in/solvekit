<x-calc.page
    title="ASCII Converter - SolveKit"
    description="Free ASCII converter: text to ASCII codes in decimal, hex, binary or octal, and codes back to text."
    lede="Convert text and ASCII codes."
    about="ASCII gives each English letter, digit and symbol a number from 0 to 127. Characters beyond ASCII use their Unicode code point."
    :calc="['engine' => 'tc-text', 'tool' => 'ascii', 'fields' => ['mode', 'text', 'codes', 'base'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What are the ASCII codes of “Hello!”?', 'answer' => '72 101 108 108 111 33.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="mode" label="Convert" :options="['toCodes' => 'Text → codes', 'toText' => 'Codes → text']" selected="toCodes" />
        <x-calc.textarea name="text" label="Text" value="Hello!" rows="3" />
        <x-calc.textarea name="codes" label="Codes (decimal, or 0x hex / 0b binary)" value="72 101 108 108 111 33" rows="3" />
        <x-calc.select name="base" label="Show codes in" :options="['2' => 'Binary', '8' => 'Octal', '10' => 'Decimal', '16' => 'Hexadecimal']" selected="10" />
    </div>

    <x-calc.result label="Converted" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mode' => 'toCodes', 'text' => 'Hello!', 'codes' => '72 101 108 108 111 33', 'base' => '10'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'count' => ['label' => 'Characters'],
            'ascii' => ['label' => 'Pure ASCII?'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="Character table" name="table" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
