<x-tool-page-layout
    title="Pressure Converter - ConvertPro"
    description="Professional pressure converter for engineering applications. Convert between Pascal, Bar, PSI, ATM, Torr, and other pressure units with precision."
>
    <x-slot name="toolUi">
        <!-- Calculator Card -->
                        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-visible">
                            
                            <!-- Calculator Header -->
                            <div class="border-b border-slate-200 bg-slate-900 px-5 py-3">
                                <h1 class="text-lg font-semibold text-white">Pressure Converter</h1>
                            </div>

                            <!-- Calculator Body -->
                            <div class="p-5 sm:p-6">
                                
                                <div class="grid gap-6 lg:grid-cols-12">
                                    <div class="lg:col-span-5">
                                        <form class="space-y-5 rounded-xl border border-slate-200 bg-white p-4 shadow-sm focus-within:ring-2 focus-within:ring-slate-200 lg:sticky lg:top-24 lg:z-20 lg:max-h-[calc(100vh-7.5rem)] lg:overflow-y-auto" id="calculatorForm">

                                                                            <!-- Input Value -->
                                                                            <div class="space-y-2">
                                                                                <label for="inputValue" class="block text-sm font-semibold text-gray-700">
                                                                                    Enter Pressure Value
                                                                                </label>
                                                                                <div class="relative">
                                                                                    <input 
                                                                                        type="number" 
                                                                                        id="inputValue" 
                                                                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium" 
                                                                                        placeholder="Enter pressure value"
                                                                                        step="any"
                                                                                    >
                                                                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                        <span class="text-gray-500 text-sm font-medium" id="inputUnitDisplay">--</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Unit Selection -->
                                                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                                                <div class="space-y-2">
                                                                                    <label for="fromUnit" class="block text-sm font-semibold text-gray-700">
                                                                                        Convert From
                                                                                    </label>
                                                                                    <select 
                                                                                        id="fromUnit" 
                                                                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium bg-white"
                                                                                    >
                                                                                        <optgroup label="Metric Units">
                                                                                            <option value="pascal">Pascal (Pa)</option>
                                                                                            <option value="kpa">Kilopascal (kPa)</option>
                                                                                            <option value="mpa">Megapascal (MPa)</option>
                                                                                            <option value="bar">Bar</option>
                                                                                            <option value="mbar">Millibar (mbar)</option>
                                                                                        </optgroup>
                                                                                        <optgroup label="Imperial Units">
                                                                                            <option value="psi">PSI (pounds/sq inch)</option>
                                                                                            <option value="psf">PSF (pounds/sq foot)</option>
                                                                                            <option value="inhg">inHg (inches of mercury)</option>
                                                                                            <option value="inh2o">inH2O (inches of water)</option>
                                                                                        </optgroup>
                                                                                        <optgroup label="Other Units">
                                                                                            <option value="atm">Atmosphere (atm)</option>
                                                                                            <option value="torr">Torr</option>
                                                                                            <option value="mmhg">mmHg (millimeters of mercury)</option>
                                                                                            <option value="mmh2o">mmH2O (millimeters of water)</option>
                                                                                        </optgroup>
                                                                                    </select>
                                                                                </div>
                                                                                <div class="space-y-2">
                                                                                    <label for="toUnit" class="block text-sm font-semibold text-gray-700">
                                                                                        Convert To
                                                                                    </label>
                                                                                    <select 
                                                                                        id="toUnit" 
                                                                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium bg-white"
                                                                                    >
                                                                                        <optgroup label="Metric Units">
                                                                                            <option value="pascal">Pascal (Pa)</option>
                                                                                            <option value="kpa" selected>Kilopascal (kPa)</option>
                                                                                            <option value="mpa">Megapascal (MPa)</option>
                                                                                            <option value="bar">Bar</option>
                                                                                            <option value="mbar">Millibar (mbar)</option>
                                                                                        </optgroup>
                                                                                        <optgroup label="Imperial Units">
                                                                                            <option value="psi">PSI (pounds/sq inch)</option>
                                                                                            <option value="psf">PSF (pounds/sq foot)</option>
                                                                                            <option value="inhg">inHg (inches of mercury)</option>
                                                                                            <option value="inh2o">inH2O (inches of water)</option>
                                                                                        </optgroup>
                                                                                        <optgroup label="Other Units">
                                                                                            <option value="atm">Atmosphere (atm)</option>
                                                                                            <option value="torr">Torr</option>
                                                                                            <option value="mmhg">mmHg (millimeters of mercury)</option>
                                                                                            <option value="mmh2o">mmH2O (millimeters of water)</option>
                                                                                        </optgroup>
                                                                                    </select>
                                                                                </div>
                                                                            </div>



                                                                            <!-- Precision Level -->
                                                                            <div class="space-y-2">
                                                                                <label class="block text-sm font-semibold text-gray-700">
                                                                                    Precision Level
                                                                                </label>
                                                                                <div class="grid grid-cols-4 gap-2">
                                                                                    <label class="flex items-center space-x-2 p-2 border border-gray-200 rounded-lg hover:border-red-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="precision" value="2" class="text-red-600 focus:ring-slate-200">
                                                                                        <span class="text-xs font-medium">2 decimals</span>
                                                                                    </label>
                                                                                    <label class="flex items-center space-x-2 p-2 border border-gray-200 rounded-lg hover:border-red-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="precision" value="4" class="text-red-600 focus:ring-slate-200">
                                                                                        <span class="text-xs font-medium">4 decimals</span>
                                                                                    </label>
                                                                                    <label class="flex items-center space-x-2 p-2 border border-gray-200 rounded-lg hover:border-red-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="precision" value="6" class="text-red-600 focus:ring-slate-200" checked>
                                                                                        <span class="text-xs font-medium">6 decimals</span>
                                                                                    </label>
                                                                                    <label class="flex items-center space-x-2 p-2 border border-gray-200 rounded-lg hover:border-red-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="precision" value="auto" class="text-red-600 focus:ring-slate-200">
                                                                                        <span class="text-xs font-medium">Auto</span>
                                                                                    </label>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Unit Swap Button -->
                                                                            <div class="flex justify-center">
                                                                                <button 
                                                                                    type="button" 
                                                                                    id="swapUnits"
                                                                                    class="inline-flex items-center px-4 py-2 bg-red-100 hover:bg-red-200 text-red-700 font-medium rounded-lg transition-colors duration-200"
                                                                                >
                                                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                                                                                    </svg>
                                                                                    Swap Units
                                                                                </button>
                                                                            </div>

                                                                        </form>
                                    </div>
                                    <div class="space-y-4 lg:col-span-7">
                                        <!-- Results Display -->
                                                                        <div class="mt-8 space-y-4">
                                                                            <h3 class="text-lg font-semibold text-gray-800 text-center mb-4">Converted Value</h3>

                                                                            <!-- Primary Result -->
                                                                            <div class="p-6 bg-gradient-to-r from-red-50 to-gray-50 rounded-xl border-l-4 border-red-500">
                                                                                <div class="flex items-center justify-between">
                                                                                    <div>
                                                                                        <h4 class="text-lg font-semibold text-gray-800 mb-1" id="result-title">Converted Pressure</h4>
                                                                                        <p class="text-sm text-gray-600" id="result-description">Target pressure unit</p>
                                                                                    </div>
                                                                                    <div class="text-right">
                                                                                        <div class="text-2xl font-bold text-red-600 font-mono" id="output">--</div>
                                                                                        <div class="text-sm text-gray-500 font-medium" id="outputUnitDisplay">--</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Common Pressure Units -->
                                                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                                                <div class="p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg border-l-4 border-blue-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Pascal (Pa)</h4>
                                                                                        <div class="text-lg font-bold text-blue-600 font-mono" id="pascalOutput">--</div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="p-4 bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg border-l-4 border-green-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">PSI</h4>
                                                                                        <div class="text-lg font-bold text-green-600 font-mono" id="psiOutput">--</div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="p-4 bg-gradient-to-r from-purple-50 to-violet-50 rounded-lg border-l-4 border-purple-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Bar</h4>
                                                                                        <div class="text-lg font-bold text-purple-600 font-mono" id="barOutput">--</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Additional Units -->
                                                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                                                <div class="p-4 bg-gradient-to-r from-orange-50 to-red-50 rounded-lg border-l-4 border-orange-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Atmosphere</h4>
                                                                                        <div class="text-lg font-bold text-orange-600 font-mono" id="atmOutput">--</div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="p-4 bg-gradient-to-r from-cyan-50 to-blue-50 rounded-lg border-l-4 border-cyan-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Torr</h4>
                                                                                        <div class="text-lg font-bold text-cyan-600 font-mono" id="torrOutput">--</div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="p-4 bg-gradient-to-r from-yellow-50 to-amber-50 rounded-lg border-l-4 border-yellow-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">mmHg</h4>
                                                                                        <div class="text-lg font-bold text-yellow-600 font-mono" id="mmhgOutput">--</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Conversion Formula -->
                                                                            <div class="p-4 bg-gray-50 rounded-lg">
                                                                                <h4 class="text-sm font-semibold text-gray-700 mb-2 text-center">Conversion Formula</h4>
                                                                                <div class="text-center text-sm text-gray-600 font-mono" id="conversionFormula">
                                                                                    Select units to see conversion formula
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
    

        <div class="mt-6 space-y-4">
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <!-- Quick Unit Swaps -->
                                                    <div class="space-y-2">
                                                        <label class="block text-sm font-semibold text-gray-700">
                                                            Quick Unit Presets
                                                        </label>
                                                        <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                                                            <button type="button" class="unit-preset px-3 py-2 text-sm bg-gray-100 hover:bg-red-100 text-gray-700 hover:text-red-700 rounded-lg transition-colors" data-from="pascal" data-to="psi">Pa → PSI</button>
                                                            <button type="button" class="unit-preset px-3 py-2 text-sm bg-gray-100 hover:bg-red-100 text-gray-700 hover:text-red-700 rounded-lg transition-colors" data-from="bar" data-to="psi">Bar → PSI</button>
                                                            <button type="button" class="unit-preset px-3 py-2 text-sm bg-gray-100 hover:bg-red-100 text-gray-700 hover:text-red-700 rounded-lg transition-colors" data-from="atm" data-to="mmhg">ATM → mmHg</button>
                                                            <button type="button" class="unit-preset px-3 py-2 text-sm bg-gray-100 hover:bg-red-100 text-gray-700 hover:text-red-700 rounded-lg transition-colors" data-from="psi" data-to="kpa">PSI → kPa</button>
                                                        </div>
                                                    </div>
            </div>
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <!-- Quick Reference -->
                                                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                                                    <h4 class="text-sm font-semibold text-gray-700 mb-2">Pressure Reference</h4>
                                                    <div class="grid grid-cols-2 gap-2 text-xs text-gray-600">
                                                        <div>• 1 bar = 100,000 Pa</div>
                                                        <div>• 1 psi = 6,894.76 Pa</div>
                                                        <div>• 1 atm = 101,325 Pa</div>
                                                        <div>• 1 torr = 133.322 Pa</div>
                                                    </div>
                                                </div>
            </div>
        </div>
</x-slot>

    <x-slot name="aboutContent">
        <!-- Additional Information -->
                        <div class="mt-8 bg-white rounded-xl shadow-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">About Pressure Conversion</h3>
                            <div class="grid md:grid-cols-2 gap-6 text-sm text-gray-600">
                                <div>
                                    <h4 class="font-semibold text-gray-700 mb-2">Engineering Applications</h4>
                                    <p>Pressure conversion is essential in engineering, manufacturing, HVAC systems, hydraulics, pneumatics, and scientific research. Different industries use different pressure units based on regional standards and specific applications.</p>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-700 mb-2">Unit Standards</h4>
                                    <p>Pascal (Pa) is the SI unit for pressure. PSI is common in the US, while Bar is widely used in Europe. Atmospheric pressure units like mmHg and Torr are used in meteorology and vacuum applications.</p>
                                </div>
                            </div>
                            <div class="mt-4 p-3 bg-red-50 rounded-lg border border-red-200">
                                <p class="text-sm text-red-800">
                                    <strong>Engineering Note:</strong> Always verify pressure unit requirements for your specific application, as incorrect units can lead to system failures!
                                </p>
                            </div>
                        </div>

                        <!-- Common Pressure Examples -->
                        <div class="mt-6 bg-white rounded-xl shadow-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Common Pressure Examples</h3>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                <div class="text-center p-3 bg-gray-50 rounded-lg">
                                    <div class="font-semibold text-gray-700">Sea Level</div>
                                    <div class="text-red-600 cursor-pointer hover:text-red-800 transition-colors" data-value="101325" data-unit="pascal">101,325 Pa</div>
                                    <div class="text-xs text-gray-500 mt-1">≈ 1 atm</div>
                                </div>
                                <div class="text-center p-3 bg-gray-50 rounded-lg">
                                    <div class="font-semibold text-gray-700">Car Tire</div>
                                    <div class="text-red-600 cursor-pointer hover:text-red-800 transition-colors" data-value="32" data-unit="psi">32 PSI</div>
                                    <div class="text-xs text-gray-500 mt-1">≈ 2.2 bar</div>
                                </div>
                                <div class="text-center p-3 bg-gray-50 rounded-lg">
                                    <div class="font-semibold text-gray-700">Vacuum Pump</div>
                                    <div class="text-red-600 cursor-pointer hover:text-red-800 transition-colors" data-value="1" data-unit="torr">1 Torr</div>
                                    <div class="text-xs text-gray-500 mt-1">≈ 133 Pa</div>
                                </div>
                                <div class="text-center p-3 bg-gray-50 rounded-lg">
                                    <div class="font-semibold text-gray-700">Hydraulic System</div>
                                    <div class="text-red-600 cursor-pointer hover:text-red-800 transition-colors" data-value="3000" data-unit="psi">3000 PSI</div>
                                    <div class="text-xs text-gray-500 mt-1">≈ 207 bar</div>
                                </div>
                            </div>
                        </div>
    </x-slot>

    <x-slot name="scripts">
        <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const inputValue = document.getElementById('inputValue');
                        const fromUnit = document.getElementById('fromUnit');
                        const toUnit = document.getElementById('toUnit');
                        const inputUnitDisplay = document.getElementById('inputUnitDisplay');
                        const outputUnitDisplay = document.getElementById('outputUnitDisplay');
                        const precisionRadios = document.getElementsByName('precision');
                        const swapUnits = document.getElementById('swapUnits');
                        const output = document.getElementById('output');
                        const resultTitle = document.getElementById('result-title');
                        const resultDescription = document.getElementById('result-description');
                        const pascalOutput = document.getElementById('pascalOutput');
                        const psiOutput = document.getElementById('psiOutput');
                        const barOutput = document.getElementById('barOutput');
                        const atmOutput = document.getElementById('atmOutput');
                        const torrOutput = document.getElementById('torrOutput');
                        const mmhgOutput = document.getElementById('mmhgOutput');
                        const conversionFormula = document.getElementById('conversionFormula');

                        // All conversion factors relative to Pascal (Pa)
                        const units = {
                            pascal: 1,                    // Pascal
                            bar: 100000,                  // Bar
                            psi: 6894.76,                 // PSI
                            atm: 101325,                  // Atmosphere
                            torr: 133.322,                // Torr
                            mmhg: 133.322,                // mmHg
                            inhg: 3386.39,                // inHg
                            kpa: 1000,                    // Kilopascal
                            mpa: 1000000,                 // Megapascal
                            psf: 47.8803,                 // PSF
                            mbar: 100,                    // Millibar
                            mmh2o: 9.80665,               // mmH2O
                            inh2o: 249.089                // inH2O
                        };

                        const unitNames = {
                            pascal: 'Pascals',
                            bar: 'Bars',
                            psi: 'PSI',
                            atm: 'Atmospheres',
                            torr: 'Torr',
                            mmhg: 'mmHg',
                            inhg: 'inHg',
                            kpa: 'Kilopascals',
                            mpa: 'Megapascals',
                            psf: 'PSF',
                            mbar: 'Millibars',
                            mmh2o: 'mmH2O',
                            inh2o: 'inH2O'
                        };

                        const unitSymbols = {
                            pascal: 'Pa',
                            bar: 'bar',
                            psi: 'psi',
                            atm: 'atm',
                            torr: 'torr',
                            mmhg: 'mmHg',
                            inhg: 'inHg',
                            kpa: 'kPa',
                            mpa: 'MPa',
                            psf: 'psf',
                            mbar: 'mbar',
                            mmh2o: 'mmH2O',
                            inh2o: 'inH2O'
                        };

                        function getPrecision() {
                            const selected = document.querySelector('input[name="precision"]:checked').value;
                            return selected === 'auto' ? 'auto' : parseInt(selected);
                        }

                        function formatNumber(num, precision = 'auto') {
                            if (precision === 'auto') {
                                if (num >= 1000000) {
                                    return Number(num.toPrecision(5)).toExponential();
                                } else if (num >= 1000) {
                                    return num.toLocaleString(undefined, { maximumFractionDigits: 2 });
                                } else if (num >= 1) {
                                    return num.toLocaleString(undefined, { maximumFractionDigits: 4 });
                                } else if (num !== 0 && Math.abs(num) < 0.000001) {
                                    return Number(num.toPrecision(4)).toExponential();
                                } else {
                                    return num.toLocaleString(undefined, { maximumSignificantDigits: 6 });
                                }
                            } else {
                                if (num !== 0 && Math.abs(num) < 0.5 * Math.pow(10, -precision)) {
                                    return Math.abs(num) < 0.000001 ? Number(num.toPrecision(4)).toExponential() : num.toLocaleString(undefined, { maximumSignificantDigits: 4 });
                                }
                                return num.toLocaleString(undefined, { maximumFractionDigits: precision });
                            }
                        }

                        function updateUnitDisplays() {
                            inputUnitDisplay.textContent = unitSymbols[fromUnit.value];
                            outputUnitDisplay.textContent = unitSymbols[toUnit.value];
                            resultTitle.textContent = `Pressure in ${unitNames[toUnit.value]}`;
                            resultDescription.textContent = 'Converted pressure value';
                        }

                        function updateConversionFormula() {
                            const fromSymbol = unitSymbols[fromUnit.value];
                            const toSymbol = unitSymbols[toUnit.value];
                            const fromFactor = units[fromUnit.value];
                            const toFactor = units[toUnit.value];
                            
                            if (fromUnit.value === toUnit.value) {
                                conversionFormula.textContent = `1 ${fromSymbol} = 1 ${toSymbol}`;
                            } else {
                                const conversionFactor = fromFactor / toFactor;
                                conversionFormula.textContent = `1 ${fromSymbol} = ${formatNumber(conversionFactor, 6)} ${toSymbol}`;
                            }
                        }

                        function convert() {
                            const inputVal = parseFloat(inputValue.value);
                            const fromUnitVal = fromUnit.value;
                            const toUnitVal = toUnit.value;
                            const precision = getPrecision();

                            if (!isNaN(inputVal)) {
                                // Convert to Pascal first, then to target unit
                                const inPascal = inputVal * units[fromUnitVal];
                                const result = inPascal / units[toUnitVal];
                                
                                output.textContent = formatNumber(result, precision);

                                // Update all common units
                                pascalOutput.textContent = formatNumber(inPascal / units.pascal, precision) + ' Pa';
                                psiOutput.textContent = formatNumber(inPascal / units.psi, precision) + ' psi';
                                barOutput.textContent = formatNumber(inPascal / units.bar, precision) + ' bar';
                                atmOutput.textContent = formatNumber(inPascal / units.atm, precision) + ' atm';
                                torrOutput.textContent = formatNumber(inPascal / units.torr, precision) + ' torr';
                                mmhgOutput.textContent = formatNumber(inPascal / units.mmhg, precision) + ' mmHg';
                            } else {
                                output.textContent = '--';
                                pascalOutput.textContent = '--';
                                psiOutput.textContent = '--';
                                barOutput.textContent = '--';
                                atmOutput.textContent = '--';
                                torrOutput.textContent = '--';
                                mmhgOutput.textContent = '--';
                            }
                        }

                        function swapUnitsFunction() {
                            const tempValue = fromUnit.value;
                            fromUnit.value = toUnit.value;
                            toUnit.value = tempValue;
                            updateUnitDisplays();
                            updateConversionFormula();
                            convert();
                        }

                        // Event listeners
                        inputValue.addEventListener('input', convert);
                        fromUnit.addEventListener('change', () => {
                            updateUnitDisplays();
                            updateConversionFormula();
                            convert();
                        });
                        toUnit.addEventListener('change', () => {
                            updateUnitDisplays();
                            updateConversionFormula();
                            convert();
                        });
                        precisionRadios.forEach(radio => {
                            radio.addEventListener('change', convert);
                        });
                        swapUnits.addEventListener('click', swapUnitsFunction);

                        // Unit preset buttons
                        const unitPresets = document.querySelectorAll('.unit-preset');
                        unitPresets.forEach(button => {
                            button.addEventListener('click', function() {
                                const fromVal = this.getAttribute('data-from');
                                const toVal = this.getAttribute('data-to');
                                
                                fromUnit.value = fromVal;
                                toUnit.value = toVal;
                                updateUnitDisplays();
                                updateConversionFormula();
                                convert();
                                
                                // Update button styles
                                unitPresets.forEach(btn => btn.classList.remove('bg-red-100', 'text-red-700'));
                                unitPresets.forEach(btn => btn.classList.add('bg-gray-100', 'text-gray-700'));
                                this.classList.remove('bg-gray-100', 'text-gray-700');
                                this.classList.add('bg-red-100', 'text-red-700');
                            });
                        });

                        // Add clickable functionality to examples
                        const examples = document.querySelectorAll('[data-value][data-unit]');
                        examples.forEach(element => {
                            element.addEventListener('click', function() {
                                const value = this.getAttribute('data-value');
                                const unit = this.getAttribute('data-unit');
                                
                                fromUnit.value = unit;
                                inputValue.value = value;
                                updateUnitDisplays();
                                updateConversionFormula();
                                convert();
                                inputValue.focus();
                            });
                        });

                        // Initialize
                        inputValue.focus();
                        updateUnitDisplays();
                        updateConversionFormula();

                        // Keyboard shortcuts
                        document.addEventListener('keydown', function(e) {
                            if (e.key === 'Escape') {
                                inputValue.value = '';
                                convert();
                                inputValue.focus();
                            } else if (e.ctrlKey && (e.key || '').toLowerCase() === 's') {
                                e.preventDefault();
                                swapUnitsFunction();
                            }
                        });

                        // Initialize conversion
                        convert();
                    });
                </script>
    </x-slot>
</x-tool-page-layout>
