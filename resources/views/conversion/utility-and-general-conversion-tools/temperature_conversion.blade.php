<x-tool-page-layout
    title="Temperature Conversion - SolveKit"
    description="Professional temperature conversion calculator for Celsius, Fahrenheit, Kelvin, and Rankine. Convert temperatures with weather applications, cooking conversions, and scientific calculations."
>
    <x-slot name="toolUi">
        <!-- Calculator Card -->
                        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-visible">
                            
                            <!-- Calculator Header -->
                            <div class="border-b border-slate-200 bg-slate-900 px-5 py-3">
                                <h1 class="text-lg font-semibold text-white">Temperature Conversion</h1>
                            </div>

                            <!-- Calculator Body -->
                            <div class="p-5 sm:p-6">
                                
                                <div class="grid gap-6 lg:grid-cols-12">
                                    <div class="lg:col-span-5">
                                        <form class="space-y-5 rounded-xl border border-slate-200 bg-white p-4 shadow-sm focus-within:ring-2 focus-within:ring-slate-200 lg:sticky lg:top-24 lg:z-20 lg:max-h-[calc(100vh-7.5rem)] lg:overflow-y-auto" id="calculatorForm">

                                                                            <!-- Temperature Value and Scales -->
                                                                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                                                                                <div class="min-w-0 space-y-2">
                                                                                    <label for="temperatureValue" class="block text-sm font-semibold text-gray-700">
                                                                                        Temperature
                                                                                    </label>
                                                                                    <input 
                                                                                        type="number" 
                                                                                        id="temperatureValue" 
                                                                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-mono" 
                                                                                        placeholder="e.g., 25"
                                                                                        step="any"
                                                                                    >
                                                                                </div>

                                                                                <div class="min-w-0 space-y-2">
                                                                                    <label for="inputScale" class="block text-sm font-semibold text-gray-700">
                                                                                        From Scale
                                                                                    </label>
                                                                                    <select 
                                                                                        id="inputScale" 
                                                                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium bg-white"
                                                                                    >
                                                                                        <option value="celsius" selected>Celsius (°C)</option>
                                                                                        <option value="fahrenheit">Fahrenheit (°F)</option>
                                                                                        <option value="kelvin">Kelvin (K)</option>
                                                                                        <option value="rankine">Rankine (°R)</option>
                                                                                        <option value="delisle">Delisle (°De)</option>
                                                                                        <option value="newton">Newton (°N)</option>
                                                                                        <option value="reaumur">Réaumur (°Ré)</option>
                                                                                        <option value="romer">Rømer (°Rø)</option>
                                                                                    </select>
                                                                                </div>

                                                                                <div class="min-w-0 space-y-2">
                                                                                    <label for="outputScale" class="block text-sm font-semibold text-gray-700">
                                                                                        To Scale
                                                                                    </label>
                                                                                    <select 
                                                                                        id="outputScale" 
                                                                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium bg-white"
                                                                                    >
                                                                                        <option value="celsius">Celsius (°C)</option>
                                                                                        <option value="fahrenheit" selected>Fahrenheit (°F)</option>
                                                                                        <option value="kelvin">Kelvin (K)</option>
                                                                                        <option value="rankine">Rankine (°R)</option>
                                                                                        <option value="delisle">Delisle (°De)</option>
                                                                                        <option value="newton">Newton (°N)</option>
                                                                                        <option value="reaumur">Réaumur (°Ré)</option>
                                                                                        <option value="romer">Rømer (°Rø)</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Clear Button -->
                                                                            <div class="flex justify-center">
                                                                                <button 
                                                                                    type="button" 
                                                                                    id="clearButton"
                                                                                    class="inline-flex items-center px-4 py-2 bg-red-100 hover:bg-red-200 text-red-700 font-medium rounded-lg transition-colors duration-200"
                                                                                >
                                                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                                                    </svg>
                                                                                    Clear
                                                                                </button>
                                                                            </div>

                                                                        </form>
                                    </div>
                                    <div class="space-y-4 lg:col-span-7">
                                        <!-- Results Display -->
                                                                        <div class="mt-8 space-y-4">
                                                                            <h3 class="text-lg font-semibold text-gray-800 text-center mb-4">Temperature Conversion Results</h3>

                                                                            <!-- Primary Result -->
                                                                            <div class="p-6 bg-gradient-to-r from-red-50 to-orange-50 rounded-xl border-l-4 border-red-500">
                                                                                <div class="flex items-center justify-between">
                                                                                    <div>
                                                                                        <h4 class="text-lg font-semibold text-gray-800 mb-1" id="result-title">Temperature Conversion</h4>
                                                                                        <p class="text-sm text-gray-600" id="result-description">Selected temperature conversion</p>
                                                                                    </div>
                                                                                    <div class="text-right">
                                                                                        <div class="text-2xl font-bold text-red-600 font-mono" id="output">--</div>
                                                                                        <button class="text-xs text-red-600 hover:text-red-800 mt-1" id="copyResult">Copy Result</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                    </div>
                                    </div>
                                </div>
                            </div>
    

        <div class="mt-6 space-y-4">
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <!-- Quick Temperature Examples -->
                                                    <div class="space-y-2">
                                                        <label class="block text-sm font-semibold text-gray-700">
                                                            Quick Temperature Examples
                                                        </label>
                                                        <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                                                            <button type="button" class="example-btn px-3 py-2 text-sm bg-gray-100 hover:bg-red-100 text-gray-700 hover:text-red-700 rounded-lg transition-colors" data-temp="0" data-scale="celsius">0°C (Freezing)</button>
                                                            <button type="button" class="example-btn px-3 py-2 text-sm bg-gray-100 hover:bg-red-100 text-gray-700 hover:text-red-700 rounded-lg transition-colors" data-temp="100" data-scale="celsius">100°C (Boiling)</button>
                                                            <button type="button" class="example-btn px-3 py-2 text-sm bg-gray-100 hover:bg-red-100 text-gray-700 hover:text-red-700 rounded-lg transition-colors" data-temp="98.6" data-scale="fahrenheit">98.6°F (Body)</button>
                                                            <button type="button" class="example-btn px-3 py-2 text-sm bg-gray-100 hover:bg-red-100 text-gray-700 hover:text-red-700 rounded-lg transition-colors" data-temp="273.15" data-scale="kelvin">273.15K (Freezing)</button>
                                                        </div>
                                                    </div>
            </div>
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <!-- Reference Information -->
                                                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                                                    <h4 class="text-sm font-semibold text-gray-700 mb-2">Temperature Scale Reference</h4>
                                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-2 text-xs text-gray-600">
                                                        <div><strong>Absolute Zero:</strong> -273.15°C</div>
                                                        <div><strong>Water freezes:</strong> 0°C / 32°F</div>
                                                        <div><strong>Room temperature:</strong> 20-25°C / 68-77°F</div>
                                                        <div><strong>Body temperature:</strong> 37°C / 98.6°F</div>
                                                        <div><strong>Water boils:</strong> 100°C / 212°F</div>
                                                        <div><strong>Oven temperature:</strong> 180-220°C / 350-425°F</div>
                                                        <div><strong>Kelvin = Celsius + 273.15</strong></div>
                                                        <div><strong>Rankine = Fahrenheit + 459.67</strong></div>
                                                        <div><strong>Celsius invented:</strong> 1742</div>
                                                        <div><strong>Fahrenheit invented:</strong> 1724</div>
                                                        <div><strong>Kelvin invented:</strong> 1848</div>
                                                        <div><strong>SI base unit:</strong> Kelvin (K)</div>
                                                    </div>
                                                </div>
            </div>
        </div>
</x-slot>


    <x-slot name="scripts">
        <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const temperatureValue = document.getElementById('temperatureValue');
                        const inputScale = document.getElementById('inputScale');
                        const outputScale = document.getElementById('outputScale');
                        const clearButton = document.getElementById('clearButton');

                        // Output elements
                        const output = document.getElementById('output');
                        const resultTitle = document.getElementById('result-title');
                        const resultDescription = document.getElementById('result-description');
                        const copyResult = document.getElementById('copyResult');

                        const scales = {
                            celsius: { name: 'Celsius', symbol: '°C' },
                            fahrenheit: { name: 'Fahrenheit', symbol: '°F' },
                            kelvin: { name: 'Kelvin', symbol: 'K' },
                            rankine: { name: 'Rankine', symbol: '°R' },
                            delisle: { name: 'Delisle', symbol: '°De' },
                            newton: { name: 'Newton', symbol: '°N' },
                            reaumur: { name: 'Réaumur', symbol: '°Ré' },
                            romer: { name: 'Rømer', symbol: '°Rø' }
                        };

                        function formatNumber(num) {
                            if (num === 0 || Object.is(num, -0)) {
                                return '0';
                            }

                            const absolute = Math.abs(num);

                            if (absolute >= 1e15 || absolute < 1e-6) {
                                return num.toExponential(3);
                            }

                            if (absolute < 0.01) {
                                return num.toLocaleString(undefined, { maximumSignificantDigits: 3 });
                            }

                            return num.toLocaleString(undefined, { maximumFractionDigits: 2 });
                        }

                        function formatTemperature(value, scale) {
                            const symbol = scales[scale].symbol;

                            return symbol === 'K' ? `${formatNumber(value)} K` : `${formatNumber(value)}${symbol}`;
                        }

                        function toCelsius(value, scale) {
                            switch (scale) {
                                case 'fahrenheit':
                                    return (value - 32) * 5 / 9;
                                case 'kelvin':
                                    return value - 273.15;
                                case 'rankine':
                                    return (value - 491.67) * 5 / 9;
                                case 'delisle':
                                    return 100 - value * 2 / 3;
                                case 'newton':
                                    return value * 100 / 33;
                                case 'reaumur':
                                    return value * 5 / 4;
                                case 'romer':
                                    return (value - 7.5) * 40 / 21;
                                default:
                                    return value;
                            }
                        }

                        function fromCelsius(celsius, scale) {
                            switch (scale) {
                                case 'fahrenheit':
                                    return celsius * 9 / 5 + 32;
                                case 'kelvin':
                                    return celsius + 273.15;
                                case 'rankine':
                                    return (celsius + 273.15) * 9 / 5;
                                case 'delisle':
                                    return (100 - celsius) * 3 / 2;
                                case 'newton':
                                    return celsius * 33 / 100;
                                case 'reaumur':
                                    return celsius * 4 / 5;
                                case 'romer':
                                    return celsius * 21 / 40 + 7.5;
                                default:
                                    return celsius;
                            }
                        }

                        function calculate() {
                            const value = parseFloat(temperatureValue.value);
                            const from = inputScale.value;
                            const to = outputScale.value;

                            if (isNaN(value)) {
                                clearOutputs();
                                return;
                            }

                            const celsius = toCelsius(value, from);
                            resultTitle.textContent = scales[to].name;

                            // Guard against floating point noise just below absolute zero.
                            if (celsius < -273.15 - 1e-9) {
                                output.textContent = '--';
                                resultDescription.textContent = `${formatTemperature(value, from)} is below absolute zero`;
                                return;
                            }

                            const result = fromCelsius(celsius, to);

                            output.textContent = formatTemperature(result, to);
                            resultDescription.textContent = `${formatTemperature(value, from)} = ${formatTemperature(result, to)}`;
                        }

                        function clearOutputs() {
                            output.textContent = '--';
                            resultTitle.textContent = scales[outputScale.value].name;
                            resultDescription.textContent = 'Enter a temperature to convert';
                        }

                        function clearAll() {
                            temperatureValue.value = '';
                            inputScale.value = 'celsius';
                            outputScale.value = 'fahrenheit';
                            clearOutputs();
                            temperatureValue.focus();
                        }

                        // Event listeners
                        temperatureValue.addEventListener('input', calculate);
                        inputScale.addEventListener('change', calculate);
                        outputScale.addEventListener('change', calculate);
                        clearButton.addEventListener('click', clearAll);

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

                        const exampleBtns = document.querySelectorAll('.example-btn');
                        exampleBtns.forEach(button => {
                            button.addEventListener('click', function() {
                                temperatureValue.value = this.getAttribute('data-temp');
                                inputScale.value = this.getAttribute('data-scale');

                                if (inputScale.value === outputScale.value) {
                                    outputScale.value = inputScale.value === 'celsius' ? 'fahrenheit' : 'celsius';
                                }

                                calculate();

                                exampleBtns.forEach(btn => btn.classList.remove('bg-red-100', 'text-red-700'));
                                exampleBtns.forEach(btn => btn.classList.add('bg-gray-100', 'text-gray-700'));
                                this.classList.remove('bg-gray-100', 'text-gray-700');
                                this.classList.add('bg-red-100', 'text-red-700');
                            });
                        });

                        // Initialize
                        clearOutputs();
                        temperatureValue.focus();

                        document.addEventListener('keydown', function(e) {
                            if (e.key === 'Escape') {
                                clearAll();
                            }
                        });
                    });
                </script>
    </x-slot>
</x-tool-page-layout>
