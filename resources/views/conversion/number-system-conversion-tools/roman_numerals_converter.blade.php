<x-tool-page-layout
    title="Roman Numerals Converter - SolveKit"
    description="Professional Roman numerals converter for historical and educational purposes. Convert between Roman numerals and decimal numbers with detailed rules and explanations."
>
    <x-slot name="toolUi">
        <div class="space-y-2">
            <section class="rounded-lg bg-white p-2.5 shadow-sm">
                <h1 class="text-sm font-semibold text-slate-900">Roman Numerals</h1>
                <p class="mt-0.5 text-[11px] text-slate-600">All controls and results are optimized to fit in the desktop viewport.</p>
            </section>

            <section class="rounded-lg bg-white p-3 shadow-sm">
                <div class="grid gap-3 lg:grid-cols-5">
                    <form id="calculatorForm" class="space-y-3 lg:col-span-3">
                        <div class="space-y-1">
                            <span class="block text-xs font-semibold text-slate-700">Conversion Mode</span>
                            <div class="grid grid-cols-2 gap-2">
                                <label class="flex items-center gap-2 rounded-md border border-slate-200 bg-slate-50 px-2 py-1.5">
                                    <input type="radio" name="mode" value="decimal-to-roman" class="text-indigo-600" checked>
                                    <span class="text-xs font-medium">Decimal to Roman</span>
                                </label>
                                <label class="flex items-center gap-2 rounded-md border border-slate-200 bg-slate-50 px-2 py-1.5">
                                    <input type="radio" name="mode" value="roman-to-decimal" class="text-indigo-600">
                                    <span class="text-xs font-medium">Roman to Decimal</span>
                                </label>
                            </div>
                        </div>

                        <div class="space-y-1">
                            <label for="inputValue" id="inputLabel" class="block text-xs font-semibold text-slate-700">Enter Decimal Number</label>
                            <input
                                type="text"
                                id="inputValue"
                                class="w-full rounded-md border border-slate-300 bg-white font-mono"
                                placeholder="e.g. 1994"
                                autocomplete="off"
                            >
                            <p id="inputHelp" class="text-[11px] text-slate-500">Use numbers between 1 and 3999.</p>
                        </div>

                        <div class="flex items-center justify-between gap-3 rounded-md border border-slate-200 bg-slate-50 px-2 py-1.5">
                            <p class="text-[11px] text-slate-500">Shortcut: Ctrl + M to switch mode</p>
                            <button
                                type="button"
                                id="clearButton"
                                class="rounded-md bg-indigo-100 px-3 py-1 text-xs font-semibold text-indigo-700"
                            >
                                Clear
                            </button>
                        </div>
                    </form>

                    <section class="space-y-2 rounded-md border border-slate-200 bg-slate-50 p-2.5 lg:col-span-2">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <p id="result-title" class="text-xs font-semibold text-slate-900">Roman Numeral</p>
                                <p id="result-description" class="text-[11px] text-slate-500">Converted output</p>
                            </div>
                            <div class="text-right">
                                <div id="output" class="font-serif text-3xl font-bold leading-none text-indigo-700">--</div>
                                <button type="button" id="copyResult" class="mt-1 text-xs font-medium text-indigo-600">Copy</button>
                            </div>
                        </div>

                        <div class="space-y-1.5 rounded-md border border-slate-200 bg-white p-2 text-sm text-slate-700">
                            <div class="flex items-center justify-between rounded-md bg-slate-50 px-2 py-1.5">
                                <span class="text-xs font-medium text-slate-600">Decimal</span>
                                <span id="decimalDisplay" class="text-sm font-semibold text-slate-900">--</span>
                            </div>
                            <div class="flex items-center justify-between rounded-md bg-slate-50 px-2 py-1.5">
                                <span class="text-xs font-medium text-slate-600">Roman</span>
                                <span id="romanDisplay" class="font-serif text-sm font-semibold text-indigo-700">--</span>
                            </div>
                            <div class="flex items-center justify-between rounded-md bg-slate-50 px-2 py-1.5">
                                <span class="text-xs font-medium text-slate-600">Symbols</span>
                                <span id="symbolsUsed" class="text-sm font-semibold text-slate-900">--</span>
                            </div>
                            <div class="flex items-center justify-between rounded-md bg-slate-50 px-2 py-1.5">
                                <span class="text-xs font-medium text-slate-600">Length</span>
                                <span id="symbolLength" class="text-sm font-semibold text-slate-900">--</span>
                            </div>
                            <div class="flex items-center justify-between rounded-md bg-slate-50 px-2 py-1.5">
                                <span class="text-xs font-medium text-slate-600">Clock</span>
                                <span id="clockFormat" class="text-sm font-semibold text-slate-900">--</span>
                            </div>
                            <div class="flex items-center justify-between rounded-md bg-slate-50 px-2 py-1.5">
                                <span class="text-xs font-medium text-slate-600">Chapter</span>
                                <span id="chapterFormat" class="text-sm font-semibold text-slate-900">--</span>
                            </div>
                            <div class="flex items-center justify-between rounded-md bg-slate-50 px-2 py-1.5">
                                <span class="text-xs font-medium text-slate-600">Year</span>
                                <span id="yearFormat" class="text-sm font-semibold text-slate-900">--</span>
                            </div>
                        </div>
                    </section>
                </div>
            </section>
        </div>
    </x-slot>


    <x-slot name="scripts">
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const inputValue = document.getElementById('inputValue');
                const modeRadios = document.getElementsByName('mode');
                const clearButton = document.getElementById('clearButton');
                const copyResult = document.getElementById('copyResult');

                if (!inputValue || !modeRadios.length || !clearButton || !copyResult) {
                    return;
                }

                const inputLabel = document.getElementById('inputLabel');
                const inputHelp = document.getElementById('inputHelp');
                const output = document.getElementById('output');
                const resultTitle = document.getElementById('result-title');
                const resultDescription = document.getElementById('result-description');
                const decimalDisplay = document.getElementById('decimalDisplay');
                const romanDisplay = document.getElementById('romanDisplay');
                const symbolsUsed = document.getElementById('symbolsUsed');
                const symbolLength = document.getElementById('symbolLength');
                const clockFormat = document.getElementById('clockFormat');
                const chapterFormat = document.getElementById('chapterFormat');
                const yearFormat = document.getElementById('yearFormat');

                const romanNumerals = [
                    { value: 1000, symbol: 'M' },
                    { value: 900, symbol: 'CM' },
                    { value: 500, symbol: 'D' },
                    { value: 400, symbol: 'CD' },
                    { value: 100, symbol: 'C' },
                    { value: 90, symbol: 'XC' },
                    { value: 50, symbol: 'L' },
                    { value: 40, symbol: 'XL' },
                    { value: 10, symbol: 'X' },
                    { value: 9, symbol: 'IX' },
                    { value: 5, symbol: 'V' },
                    { value: 4, symbol: 'IV' },
                    { value: 1, symbol: 'I' }
                ];

                const romanValues = {
                    I: 1,
                    V: 5,
                    X: 10,
                    L: 50,
                    C: 100,
                    D: 500,
                    M: 1000,
                };

                const strictRomanPattern = /^(M{0,3})(CM|CD|D?C{0,3})(XC|XL|L?X{0,3})(IX|IV|V?I{0,3})$/i;

                function getMode() {
                    return document.querySelector('input[name="mode"]:checked')?.value || 'decimal-to-roman';
                }

                function isValidDecimal(value) {
                    return /^\d+$/.test(value) && Number(value) >= 1 && Number(value) <= 3999;
                }

                function isValidRoman(value) {
                    const sanitized = value.trim().toUpperCase();
                    return sanitized !== '' && strictRomanPattern.test(sanitized);
                }

                function decimalToRoman(decimal) {
                    let num = Number(decimal);
                    let result = '';
                    const steps = [];

                    romanNumerals.forEach((entry) => {
                        while (num >= entry.value) {
                            result += entry.symbol;
                            steps.push(`${num} - ${entry.value} = ${num - entry.value} (add ${entry.symbol})`);
                            num -= entry.value;
                        }
                    });

                    return { roman: result, steps };
                }

                function romanToDecimal(roman) {
                    const value = roman.trim().toUpperCase();
                    let total = 0;
                    const steps = [];

                    for (let i = 0; i < value.length; i += 1) {
                        const current = romanValues[value[i]];
                        const next = romanValues[value[i + 1]];

                        if (next && current < next) {
                            const partial = next - current;
                            steps.push(`${value[i]}${value[i + 1]} = ${partial}`);
                            total += partial;
                            i += 1;
                        } else {
                            steps.push(`${value[i]} = ${current}`);
                            total += current;
                        }
                    }

                    return { decimal: total, steps };
                }

                function getUniqueSymbols(roman) {
                    const order = ['M', 'D', 'C', 'L', 'X', 'V', 'I'];
                    return [...new Set(roman.split(''))]
                        .sort((a, b) => order.indexOf(a) - order.indexOf(b))
                        .join(' ');
                }

                function getConversionRules(roman) {
                    const rules = [];

                    if (roman.includes('IV') || roman.includes('IX')) {
                        rules.push('I can appear before V or X for subtraction.');
                    }
                    if (roman.includes('XL') || roman.includes('XC')) {
                        rules.push('X can appear before L or C for subtraction.');
                    }
                    if (roman.includes('CD') || roman.includes('CM')) {
                        rules.push('C can appear before D or M for subtraction.');
                    }
                    if (/I{2,3}|X{2,3}|C{2,3}/.test(roman)) {
                        rules.push('I, X, and C can repeat up to three times.');
                    }
                    if (/M+/.test(roman)) {
                        rules.push('M repeats for thousands.');
                    }

                    return rules.length ? rules : ['Standard additive notation.'];
                }

                function updateInterface() {
                    if (getMode() === 'decimal-to-roman') {
                        inputLabel.textContent = 'Enter Decimal Number';
                        inputHelp.textContent = 'Use numbers between 1 and 3999.';
                        inputValue.placeholder = 'e.g. 1994';
                        resultTitle.textContent = 'Roman Numeral';
                        resultDescription.textContent = 'Converted output';
                    } else {
                        inputLabel.textContent = 'Enter Roman Numeral';
                        inputHelp.textContent = 'Use I, V, X, L, C, D, M.';
                        inputValue.placeholder = 'e.g. MCMXCIV';
                        resultTitle.textContent = 'Decimal Number';
                        resultDescription.textContent = 'Converted output';
                    }
                }

                function clearOutputs() {
                    output.textContent = '--';
                    decimalDisplay.textContent = '--';
                    romanDisplay.textContent = '--';
                    symbolsUsed.textContent = '--';
                    symbolLength.textContent = '--';
                    clockFormat.textContent = '--';
                    chapterFormat.textContent = '--';
                    yearFormat.textContent = '--';
                }

                function renderInvalid() {
                    clearOutputs();
                    inputValue.classList.add('border-red-500');
                    setTimeout(() => inputValue.classList.remove('border-red-500'), 1200);
                }

                function convert() {
                    const input = inputValue.value.trim();

                    if (!input) {
                        clearOutputs();
                        return;
                    }

                    const mode = getMode();
                    let decimal;
                    let roman;

                    if (mode === 'decimal-to-roman') {
                        if (!isValidDecimal(input)) {
                            renderInvalid();
                            return;
                        }

                        const converted = decimalToRoman(input);
                        decimal = Number(input);
                        roman = converted.roman;
                        output.textContent = roman;
                    } else {
                        if (!isValidRoman(input)) {
                            renderInvalid();
                            return;
                        }

                        const converted = romanToDecimal(input);
                        decimal = converted.decimal;
                        roman = input.toUpperCase();
                        output.textContent = String(decimal);
                    }

                    decimalDisplay.textContent = String(decimal);
                    romanDisplay.textContent = roman;
                    symbolsUsed.textContent = getUniqueSymbols(roman);
                    symbolLength.textContent = `${roman.length} chars`;
                    clockFormat.textContent = decimal <= 12 ? roman : 'N/A';
                    chapterFormat.textContent = `Chapter ${roman}`;
                    yearFormat.textContent = decimal >= 1000 ? `Year ${roman}` : 'N/A';
                }

                function clearAll() {
                    inputValue.value = '';
                    clearOutputs();
                    inputValue.focus();
                }

                inputValue.addEventListener('input', convert);
                modeRadios.forEach((radio) => radio.addEventListener('change', () => {
                    updateInterface();
                    clearAll();
                }));

                clearButton.addEventListener('click', clearAll);

                copyResult.addEventListener('click', function () {
                    const text = output.textContent;
                    if (!text || text === '--') {
                        return;
                    }
                    navigator.clipboard.writeText(text).then(() => {
                        copyResult.textContent = 'Copied';
                        setTimeout(() => {
                            copyResult.textContent = 'Copy';
                        }, 1200);
                    });
                });

                document.addEventListener('keydown', function (event) {
                    if (event.key === 'Escape') {
                        clearAll();
                        return;
                    }

                    if (event.ctrlKey && event.key.toLowerCase() === 'm') {
                        event.preventDefault();
                        const current = getMode();
                        const next = current === 'decimal-to-roman' ? 'roman-to-decimal' : 'decimal-to-roman';
                        const nextInput = document.querySelector(`input[name="mode"][value="${next}"]`);
                        if (nextInput) {
                            nextInput.checked = true;
                            updateInterface();
                            clearAll();
                        }
                    }
                });

                updateInterface();
                clearOutputs();
            });
        </script>
    </x-slot>
</x-tool-page-layout>
