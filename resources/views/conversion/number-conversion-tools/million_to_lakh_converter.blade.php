<x-tool-page-layout title="Million to Lakh Converter - SolveKit"
    description="Professional million to lakh converter for cross-cultural business. Convert between Western millions and Indian lakhs with precision.">
    <x-slot name="toolUi">
        <!-- Calculator Card -->
        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-visible">

            <!-- Calculator Header -->
            <div class="border-b border-slate-200 bg-slate-900 px-5 py-3">
                <h1 class="text-lg font-semibold text-white">Million to Lakh</h1>
            </div>

            <!-- Calculator Body -->
            <div class="p-5 sm:p-6">

                <div class="grid gap-6 lg:grid-cols-12">
                    <div class="lg:col-span-5">
                        <form
                            class="space-y-5 rounded-xl border border-slate-200 bg-white p-4 shadow-sm focus-within:ring-2 focus-within:ring-slate-200 lg:sticky lg:top-24 lg:z-20 lg:max-h-[calc(100vh-7.5rem)] lg:overflow-y-auto"
                            id="calculatorForm">

                            <!-- Conversion Mode -->
                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-700">
                                    Conversion Mode
                                </label>
                                <div class="grid grid-cols-2 gap-2">
                                    <label
                                        class="flex items-center space-x-2 p-3 border border-gray-200 rounded-lg hover:border-rose-300 transition-colors cursor-pointer bg-rose-50 border-rose-300">
                                        <input type="radio" name="mode" value="million-to-lakh"
                                            class="text-rose-600 focus:ring-slate-200" checked>
                                        <span class="text-sm font-medium">Million → Lakh</span>
                                    </label>
                                    <label
                                        class="flex items-center space-x-2 p-3 border border-gray-200 rounded-lg hover:border-rose-300 transition-colors cursor-pointer">
                                        <input type="radio" name="mode" value="lakh-to-million"
                                            class="text-rose-600 focus:ring-slate-200">
                                        <span class="text-sm font-medium">Lakh → Million</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Input Value -->
                            <div class="space-y-2">
                                <label for="inputValue" class="block text-sm font-semibold text-gray-700"
                                    id="inputLabel">
                                    Enter Millions
                                </label>
                                <div class="relative">
                                    <input type="number" id="inputValue"
                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium"
                                        placeholder="Enter value" step="any" min="0">
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                        <span class="text-gray-500 text-sm font-medium" id="inputUnit">Million</span>
                                    </div>
                                </div>
                                <p class="text-xs text-gray-500" id="inputHelp">Enter the number of millions to convert
                                    to lakhs</p>
                            </div>

                            <div class="hidden" aria-hidden="true">
                                <select id="region">
                                    <option value="global" selected>Global Business</option>
                                </select>
                            </div>

                            <div class="hidden" aria-hidden="true">
                                <input type="radio" name="application" value="investment" checked>
                                <input type="radio" name="application" value="revenue">
                                <input type="radio" name="application" value="valuation">
                                <input type="radio" name="application" value="salary">
                                <input type="radio" name="currency" value="none" checked>
                                <input type="radio" name="currency" value="USD-INR">
                                <input type="radio" name="currency" value="GBP-INR">
                                <input type="radio" name="precision" value="1">
                                <input type="radio" name="precision" value="2" checked>
                                <input type="radio" name="precision" value="3">
                                <input type="radio" name="precision" value="auto">
                            </div>



                            <!-- Clear Button -->
                            <div class="flex justify-center">
                                <button type="button" id="clearButton"
                                    class="inline-flex items-center px-4 py-2 bg-rose-100 hover:bg-rose-200 text-rose-700 font-medium rounded-lg transition-colors duration-200">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                        </path>
                                    </svg>
                                    Clear
                                </button>
                            </div>

                        </form>
                    </div>
                    <div class="space-y-4 lg:col-span-7">
                        <!-- Results Display -->
                        <div class="mt-8 space-y-4">
                            <h3 class="text-lg font-semibold text-gray-800 text-center mb-4">Converted Value</h3>

                            <!-- Primary Result -->
                            <div
                                class="p-6 bg-gradient-to-r from-rose-50 to-pink-50 rounded-xl border-l-4 border-rose-500">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h4 class="text-lg font-semibold text-gray-800 mb-1" id="result-title">Lakhs
                                        </h4>
                                        <p class="text-sm text-gray-600" id="result-description">Converted value</p>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-2xl font-bold text-rose-600 font-mono" id="output">--
                                        </div>
                                        <button class="text-xs text-rose-600 hover:text-rose-800 mt-1"
                                            id="copyResult">Copy Result</button>
                                    </div>
                                </div>
                            </div>

                            <div class="hidden" aria-hidden="true">
                                <span id="millionDisplay">--</span>
                                <span id="lakhDisplay">--</span>
                            </div>

                            <!-- Extended Denominations -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <!-- Thousands -->
                                <div
                                    class="p-4 bg-gradient-to-r from-purple-50 to-violet-50 rounded-lg border-l-4 border-purple-500">
                                    <div class="text-center">
                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Thousands</h4>
                                        <div class="text-lg font-bold text-purple-600 font-mono" id="thousandDisplay">
                                            --</div>
                                    </div>
                                </div>

                                <!-- Crores -->
                                <div
                                    class="p-4 bg-gradient-to-r from-orange-50 to-red-50 rounded-lg border-l-4 border-orange-500">
                                    <div class="text-center">
                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Crores</h4>
                                        <div class="text-lg font-bold text-orange-600 font-mono" id="croreDisplay">--
                                        </div>
                                    </div>
                                </div>

                                <!-- Billions -->
                                <div
                                    class="p-4 bg-gradient-to-r from-cyan-50 to-blue-50 rounded-lg border-l-4 border-cyan-500">
                                    <div class="text-center">
                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Billions</h4>
                                        <div class="text-lg font-bold text-cyan-600 font-mono" id="billionDisplay">--
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Currency Conversion Display -->
                            <div class="p-4 bg-gradient-to-r from-yellow-50 to-amber-50 rounded-lg border border-yellow-200"
                                id="currencyDisplay" style="display: none;">
                                <h4 class="text-sm font-semibold text-yellow-800 mb-2 text-center">Currency Context
                                </h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                    <div class="text-center">
                                        <span class="text-gray-600 block">Western Format:</span>
                                        <span class="font-mono text-yellow-700 text-lg" id="westernCurrency">--</span>
                                    </div>
                                    <div class="text-center">
                                        <span class="text-gray-600 block">Indian Format:</span>
                                        <span class="font-mono text-yellow-700 text-lg" id="indianCurrency">--</span>
                                    </div>
                                </div>
                            </div>



                        </div>
                    </div>
                </div>
            </div>


    </x-slot>


    <x-slot name="scripts">
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const inputValue = document.getElementById('inputValue');
                const region = document.getElementById('region');
                const modeRadios = document.getElementsByName('mode');
                const applicationRadios = document.getElementsByName('application');
                const currencyRadios = document.getElementsByName('currency');
                const precisionRadios = document.getElementsByName('precision');
                const clearButton = document.getElementById('clearButton');
                const inputLabel = document.getElementById('inputLabel');
                const inputUnit = document.getElementById('inputUnit');
                const inputHelp = document.getElementById('inputHelp');

                // Output elements
                const output = document.getElementById('output');
                const resultTitle = document.getElementById('result-title');
                const resultDescription = document.getElementById('result-description');
                const millionDisplay = document.getElementById('millionDisplay');
                const lakhDisplay = document.getElementById('lakhDisplay');
                const thousandDisplay = document.getElementById('thousandDisplay');
                const croreDisplay = document.getElementById('croreDisplay');
                const billionDisplay = document.getElementById('billionDisplay');
                const currencyDisplay = document.getElementById('currencyDisplay');
                const westernCurrency = document.getElementById('westernCurrency');
                const indianCurrency = document.getElementById('indianCurrency');
                const copyResult = document.getElementById('copyResult');

                // Currency symbols
                const currencySymbols = {
                    'none': {
                        western: '',
                        indian: ''
                    },
                    'USD-INR': {
                        western: '$',
                        indian: '₹'
                    },
                    'GBP-INR': {
                        western: '£',
                        indian: '₹'
                    }
                };

                function getPrecision() {
                    const selected = document.querySelector('input[name="precision"]:checked').value;
                    return selected === 'auto' ? 'auto' : parseInt(selected);
                }

                function getMode() {
                    return document.querySelector('input[name="mode"]:checked').value;
                }

                function getCurrency() {
                    return document.querySelector('input[name="currency"]:checked').value;
                }

                function formatNumber(num, precision = 'auto') {
                    if (!Number.isFinite(num)) {
                        return '--';
                    }

                    const absolute = Math.abs(num);
                    if (absolute >= 1e21 || (absolute !== 0 && absolute < 1e-9)) {
                        return num.toExponential(4).replace(/\.?0+e/, 'e');
                    }

                    if (absolute !== 0 && absolute < 1) {
                        return num.toLocaleString(undefined, { maximumSignificantDigits: 6 });
                    }

                    const fractionDigits = precision === 'auto' ? 6 : precision;
                    return num.toLocaleString(undefined, { maximumFractionDigits: fractionDigits });
                }

                function updateInterface() {
                    const mode = getMode();
                    const selectedCurrency = getCurrency();

                    // Show/hide currency display
                    currencyDisplay.style.display = selectedCurrency !== 'none' ? 'block' : 'none';

                    if (mode === 'million-to-lakh') {
                        inputLabel.textContent = 'Enter Millions';
                        inputUnit.textContent = 'Million';
                        inputHelp.textContent = 'Enter the number of millions to convert to lakhs';
                        resultTitle.textContent = 'Lakhs';
                        resultDescription.textContent = 'Converted to lakhs';
                    } else {
                        inputLabel.textContent = 'Enter Lakhs';
                        inputUnit.textContent = 'Lakh';
                        inputHelp.textContent = 'Enter the number of lakhs to convert to millions';
                        resultTitle.textContent = 'Millions';
                        resultDescription.textContent = 'Converted to millions';
                    }
                }

                function convert() {
                    const inputVal = parseFloat(inputValue.value);
                    const mode = getMode();
                    const precision = getPrecision();
                    const selectedCurrency = getCurrency();

                    if (!isNaN(inputVal) && inputVal >= 0) {
                        let millions, lakhs, thousands, crores, billions;

                        if (mode === 'million-to-lakh') {
                            millions = inputVal;
                            lakhs = millions * 10;
                            thousands = millions * 1000;
                            crores = millions / 10;
                            billions = millions / 1000;

                            output.textContent = formatNumber(lakhs, precision);
                        } else {
                            lakhs = inputVal;
                            millions = lakhs / 10;
                            thousands = lakhs * 100;
                            crores = lakhs / 100;
                            billions = millions / 1000;

                            output.textContent = formatNumber(millions, precision);
                        }

                        // Update all displays
                        millionDisplay.textContent = formatNumber(millions, precision);
                        lakhDisplay.textContent = formatNumber(lakhs, precision);
                        thousandDisplay.textContent = formatNumber(thousands, precision);
                        croreDisplay.textContent = formatNumber(crores, precision);
                        billionDisplay.textContent = formatNumber(billions, precision);

                        // Currency displays
                        if (selectedCurrency !== 'none') {
                            const symbols = currencySymbols[selectedCurrency];
                            westernCurrency.textContent = `${symbols.western}${formatNumber(millions, precision)} M`;
                            indianCurrency.textContent = `${symbols.indian}${formatNumber(lakhs, precision)} L`;
                        }

                    } else {
                        clearOutputs();
                    }
                }

                function clearOutputs() {
                    output.textContent = '--';
                    millionDisplay.textContent = '--';
                    lakhDisplay.textContent = '--';
                    thousandDisplay.textContent = '--';
                    croreDisplay.textContent = '--';
                    billionDisplay.textContent = '--';
                    westernCurrency.textContent = '--';
                    indianCurrency.textContent = '--';
                }

                function clearAll() {
                    inputValue.value = '';
                    region.value = 'global';
                    document.querySelector('input[name="currency"][value="none"]').checked = true;
                    clearOutputs();
                    updateInterface();
                    inputValue.focus();
                }

                // Event listeners
                inputValue.addEventListener('input', convert);
                region.addEventListener('change', () => {
                    updateInterface();
                    convert();
                });

                modeRadios.forEach(radio => {
                    radio.addEventListener('change', () => {
                        updateInterface();
                        convert();
                    });
                });

                applicationRadios.forEach(radio => {
                    radio.addEventListener('change', () => {
                        updateInterface();
                        convert();
                    });
                });

                currencyRadios.forEach(radio => {
                    radio.addEventListener('change', () => {
                        updateInterface();
                        convert();
                    });
                });

                precisionRadios.forEach(radio => {
                    radio.addEventListener('change', convert);
                });

                clearButton.addEventListener('click', clearAll);

                // Copy functionality
                copyResult.addEventListener('click', function() {
                    const text = output.textContent;
                    if (text !== '--') {
                        navigator.clipboard.writeText(text).then(() => {
                            this.textContent = 'Copied!';
                            setTimeout(() => {
                                this.textContent = 'Copy Result';
                            }, 2000);
                        });
                    }
                });

                // Cultural example buttons
                const culturalExamples = document.querySelectorAll('.cultural-example');
                culturalExamples.forEach(button => {
                    button.addEventListener('click', function() {
                        const value = this.getAttribute('data-value');
                        const context = this.getAttribute('data-context');

                        inputValue.value = value;
                        convert();

                        // Update button styles
                        culturalExamples.forEach(btn => btn.classList.remove('bg-rose-100',
                            'text-rose-700'));
                        culturalExamples.forEach(btn => btn.classList.add('bg-gray-100',
                            'text-gray-700'));
                        this.classList.remove('bg-gray-100', 'text-gray-700');
                        this.classList.add('bg-rose-100', 'text-rose-700');
                    });
                });

                // Initialize
                updateInterface();
                inputValue.focus();
                convert();

                // Keyboard shortcuts
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape') {
                        clearAll();
                    } else if (e.ctrlKey && (e.key || '').toLowerCase() === 'm') {
                        e.preventDefault();
                        const currentMode = getMode();
                        const newMode = currentMode === 'million-to-lakh' ? 'lakh-to-million' :
                            'million-to-lakh';
                        document.querySelector(`input[value="${newMode}"]`).checked = true;
                        updateInterface();
                        convert();
                    }
                });
            });
        </script>
    </x-slot>
</x-tool-page-layout>
