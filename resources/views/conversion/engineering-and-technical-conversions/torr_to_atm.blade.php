<x-tool-page-layout
    title="Torr to atm Converter - SolveKit"
    description="Professional Torr to atmosphere converter for vacuum and pressure applications. Convert between Torr, atm, mmHg and other pressure units with precision."
>
    <x-slot name="toolUi">
        <!-- Calculator Card -->
                        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-visible">
                            
                            <!-- Calculator Header -->
                            <div class="border-b border-slate-200 bg-slate-900 px-5 py-3">
                                <h1 class="text-lg font-semibold text-white">Torr to atm</h1>
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
                                                                                        <span class="text-gray-500 text-sm font-medium" id="inputUnitDisplay">Torr</span>
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
                                                                                        <optgroup label="Vacuum Units">
                                                                                            <option value="torr" selected>Torr</option>
                                                                                            <option value="mmhg">mmHg (millimeters of mercury)</option>
                                                                                            <option value="mtorr">Millitorr (mTorr)</option>
                                                                                            <option value="micron">Micron (μm Hg)</option>
                                                                                            <option value="inhg">inHg (inches of mercury)</option>
                                                                                        </optgroup>
                                                                                        <optgroup label="Atmospheric Units">
                                                                                            <option value="atm">Atmosphere (atm)</option>
                                                                                            <option value="bar">Bar</option>
                                                                                            <option value="mbar">Millibar (mbar)</option>
                                                                                            <option value="psi">PSI (pounds per sq inch)</option>
                                                                                        </optgroup>
                                                                                        <optgroup label="SI Units">
                                                                                            <option value="pascal">Pascal (Pa)</option>
                                                                                            <option value="kpa">Kilopascal (kPa)</option>
                                                                                            <option value="mpa">Megapascal (MPa)</option>
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
                                                                                        <optgroup label="Vacuum Units">
                                                                                            <option value="torr">Torr</option>
                                                                                            <option value="mmhg">mmHg (millimeters of mercury)</option>
                                                                                            <option value="mtorr">Millitorr (mTorr)</option>
                                                                                            <option value="micron">Micron (μm Hg)</option>
                                                                                            <option value="inhg">inHg (inches of mercury)</option>
                                                                                        </optgroup>
                                                                                        <optgroup label="Atmospheric Units">
                                                                                            <option value="atm" selected>Atmosphere (atm)</option>
                                                                                            <option value="bar">Bar</option>
                                                                                            <option value="mbar">Millibar (mbar)</option>
                                                                                            <option value="psi">PSI (pounds per sq inch)</option>
                                                                                        </optgroup>
                                                                                        <optgroup label="SI Units">
                                                                                            <option value="pascal">Pascal (Pa)</option>
                                                                                            <option value="kpa">Kilopascal (kPa)</option>
                                                                                            <option value="mpa">Megapascal (MPa)</option>
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
                                                                                    <label class="flex items-center space-x-2 p-2 border border-gray-200 rounded-lg hover:border-gray-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="precision" value="3" class="text-gray-600 focus:ring-slate-200">
                                                                                        <span class="text-xs font-medium">3 decimals</span>
                                                                                    </label>
                                                                                    <label class="flex items-center space-x-2 p-2 border border-gray-200 rounded-lg hover:border-gray-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="precision" value="6" class="text-gray-600 focus:ring-slate-200" checked>
                                                                                        <span class="text-xs font-medium">6 decimals</span>
                                                                                    </label>
                                                                                    <label class="flex items-center space-x-2 p-2 border border-gray-200 rounded-lg hover:border-gray-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="precision" value="9" class="text-gray-600 focus:ring-slate-200">
                                                                                        <span class="text-xs font-medium">9 decimals</span>
                                                                                    </label>
                                                                                    <label class="flex items-center space-x-2 p-2 border border-gray-200 rounded-lg hover:border-gray-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="precision" value="scientific" class="text-gray-600 focus:ring-slate-200">
                                                                                        <span class="text-xs font-medium">Scientific</span>
                                                                                    </label>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Unit Swap Button -->
                                                                            <div class="flex justify-center">
                                                                                <button 
                                                                                    type="button" 
                                                                                    id="swapUnits"
                                                                                    class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-colors duration-200"
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
                                                                            <div class="p-6 bg-gradient-to-r from-gray-50 to-slate-50 rounded-xl border-l-4 border-gray-500">
                                                                                <div class="flex items-center justify-between">
                                                                                    <div>
                                                                                        <h4 class="text-lg font-semibold text-gray-800 mb-1" id="result-title">Converted Pressure</h4>
                                                                                        <p class="text-sm text-gray-600" id="result-description">Target pressure unit</p>
                                                                                    </div>
                                                                                    <div class="text-right">
                                                                                        <div class="text-2xl font-bold text-gray-600 font-mono" id="output">--</div>
                                                                                        <div class="text-sm text-gray-500 font-medium" id="outputUnitDisplay">atm</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Common Vacuum Units -->
                                                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                                                <div class="p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg border-l-4 border-blue-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Torr</h4>
                                                                                        <div class="text-lg font-bold text-blue-600 font-mono" id="torrOutput">--</div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="p-4 bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg border-l-4 border-green-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Atmosphere</h4>
                                                                                        <div class="text-lg font-bold text-green-600 font-mono" id="atmOutput">--</div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="p-4 bg-gradient-to-r from-purple-50 to-violet-50 rounded-lg border-l-4 border-purple-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">mmHg</h4>
                                                                                        <div class="text-lg font-bold text-purple-600 font-mono" id="mmhgOutput">--</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Additional Units -->
                                                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                                                <div class="p-4 bg-gradient-to-r from-orange-50 to-red-50 rounded-lg border-l-4 border-orange-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Pascal</h4>
                                                                                        <div class="text-lg font-bold text-orange-600 font-mono" id="pascalOutput">--</div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="p-4 bg-gradient-to-r from-cyan-50 to-blue-50 rounded-lg border-l-4 border-cyan-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">mTorr</h4>
                                                                                        <div class="text-lg font-bold text-cyan-600 font-mono" id="mtorrOutput">--</div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="p-4 bg-gradient-to-r from-yellow-50 to-amber-50 rounded-lg border-l-4 border-yellow-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Bar</h4>
                                                                                        <div class="text-lg font-bold text-yellow-600 font-mono" id="barOutput">--</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Vacuum Level Indicator -->
                                                                            <div class="p-4 bg-gradient-to-r from-indigo-50 to-purple-50 rounded-lg border border-indigo-200">
                                                                                <h4 class="text-sm font-semibold text-indigo-800 mb-2 text-center">Vacuum Level Classification</h4>
                                                                                <div class="text-center">
                                                                                    <div class="text-lg font-bold text-indigo-700" id="vacuumLevel">Enter pressure value</div>
                                                                                    <div class="text-xs text-indigo-600 mt-1" id="vacuumDescription">--</div>
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
                                                            Quick Vacuum Conversions
                                                        </label>
                                                        <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                                                            <button type="button" class="unit-preset px-3 py-2 text-sm bg-gray-100 hover:bg-gray-200 text-gray-700 hover:text-gray-800 rounded-lg transition-colors" data-from="torr" data-to="atm">Torr → atm</button>
                                                            <button type="button" class="unit-preset px-3 py-2 text-sm bg-gray-100 hover:bg-gray-200 text-gray-700 hover:text-gray-800 rounded-lg transition-colors" data-from="atm" data-to="torr">atm → Torr</button>
                                                            <button type="button" class="unit-preset px-3 py-2 text-sm bg-gray-100 hover:bg-gray-200 text-gray-700 hover:text-gray-800 rounded-lg transition-colors" data-from="mtorr" data-to="torr">mTorr → Torr</button>
                                                            <button type="button" class="unit-preset px-3 py-2 text-sm bg-gray-100 hover:bg-gray-200 text-gray-700 hover:text-gray-800 rounded-lg transition-colors" data-from="torr" data-to="pascal">Torr → Pa</button>
                                                        </div>
                                                    </div>
            </div>
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <!-- Quick Reference -->
                                                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                                                    <h4 class="text-sm font-semibold text-gray-700 mb-2">Vacuum Pressure Reference</h4>
                                                    <div class="grid grid-cols-2 gap-2 text-xs text-gray-600">
                                                        <div>• 1 atm = 760 Torr</div>
                                                        <div>• 1 Torr = 1 mmHg</div>
                                                        <div>• 1 mTorr = 0.001 Torr</div>
                                                        <div>• 1 Torr = 133.322 Pa</div>
                                                    </div>
                                                </div>
            </div>
        </div>
</x-slot>

    <x-slot name="aboutContent">
        <!-- Additional Information -->
                        <div class="mt-8 bg-white rounded-xl shadow-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">About Vacuum Pressure Conversion</h3>
                            <div class="grid md:grid-cols-2 gap-6 text-sm text-gray-600">
                                <div>
                                    <h4 class="font-semibold text-gray-700 mb-2">Vacuum Technology</h4>
                                    <p>Vacuum pressure measurements are critical in scientific research, semiconductor manufacturing, vacuum coating, mass spectrometry, and many industrial processes. Torr and mmHg are traditional vacuum units still widely used.</p>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-700 mb-2">Pressure Ranges</h4>
                                    <p>Different vacuum levels require different measurement techniques and units. Rough vacuum (1-760 Torr), high vacuum (10⁻³-1 Torr), ultra-high vacuum (10⁻⁹-10⁻³ Torr), and extreme high vacuum (< 10⁻⁹ Torr).</p>
                                </div>
                            </div>
                            <div class="mt-4 p-3 bg-gray-50 rounded-lg border border-gray-200">
                                <p class="text-sm text-gray-800">
                                    <strong>Vacuum Note:</strong> Torr units are named after Evangelista Torricelli, inventor of the barometer. 1 Torr = 1/760 atmosphere at standard conditions!
                                </p>
                            </div>
                        </div>

                        <!-- Common Vacuum Examples -->
                        <div class="mt-6 bg-white rounded-xl shadow-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Common Vacuum Examples</h3>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                <div class="text-center p-3 bg-gray-50 rounded-lg">
                                    <div class="font-semibold text-gray-700">Sea Level</div>
                                    <div class="text-gray-600 cursor-pointer hover:text-gray-800 transition-colors" data-value="760" data-unit="torr">760 Torr</div>
                                    <div class="text-xs text-gray-500 mt-1">= 1 atm</div>
                                </div>
                                <div class="text-center p-3 bg-gray-50 rounded-lg">
                                    <div class="font-semibold text-gray-700">Vacuum Pump</div>
                                    <div class="text-gray-600 cursor-pointer hover:text-gray-800 transition-colors" data-value="0.1" data-unit="torr">0.1 Torr</div>
                                    <div class="text-xs text-gray-500 mt-1">High vacuum</div>
                                </div>
                                <div class="text-center p-3 bg-gray-50 rounded-lg">
                                    <div class="font-semibold text-gray-700">Lab Vacuum</div>
                                    <div class="text-gray-600 cursor-pointer hover:text-gray-800 transition-colors" data-value="0.001" data-unit="torr">1 mTorr</div>
                                    <div class="text-xs text-gray-500 mt-1">Ultra-high vacuum</div>
                                </div>
                                <div class="text-center p-3 bg-gray-50 rounded-lg">
                                    <div class="font-semibold text-gray-700">Space Simulation</div>
                                    <div class="text-gray-600 cursor-pointer hover:text-gray-800 transition-colors" data-value="0.000001" data-unit="torr">1 μTorr</div>
                                    <div class="text-xs text-gray-500 mt-1">Extreme vacuum</div>
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
                        const torrOutput = document.getElementById('torrOutput');
                        const atmOutput = document.getElementById('atmOutput');
                        const mmhgOutput = document.getElementById('mmhgOutput');
                        const pascalOutput = document.getElementById('pascalOutput');
                        const mtorrOutput = document.getElementById('mtorrOutput');
                        const barOutput = document.getElementById('barOutput');
                        const vacuumLevel = document.getElementById('vacuumLevel');
                        const vacuumDescription = document.getElementById('vacuumDescription');
                        const conversionFormula = document.getElementById('conversionFormula');

                        // All conversion factors relative to Torr
                        const units = {
                            torr: 1,                      // Torr
                            atm: 760,                     // Atmosphere
                            mmhg: 1,                      // mmHg (same as Torr)
                            inhg: 25.4,                   // inHg
                            mbar: 0.750062,               // Millibar
                            pascal: 0.00750062,           // Pascal
                            kpa: 7.50062,                 // Kilopascal
                            mpa: 7500.62,                 // Megapascal
                            psi: 51.7149,                 // PSI
                            bar: 750.062,                 // Bar
                            mtorr: 0.001,                 // Millitorr
                            micron: 0.001                 // Micron
                        };

                        const unitNames = {
                            torr: 'Torr',
                            atm: 'Atmospheres',
                            mmhg: 'mmHg',
                            inhg: 'inHg',
                            mbar: 'Millibars',
                            pascal: 'Pascals',
                            kpa: 'Kilopascals',
                            mpa: 'Megapascals',
                            psi: 'PSI',
                            bar: 'Bars',
                            mtorr: 'Millitorr',
                            micron: 'Microns of Mercury'
                        };

                        const unitSymbols = {
                            torr: 'Torr',
                            atm: 'atm',
                            mmhg: 'mmHg',
                            inhg: 'inHg',
                            mbar: 'mbar',
                            pascal: 'Pa',
                            kpa: 'kPa',
                            mpa: 'MPa',
                            psi: 'psi',
                            bar: 'bar',
                            mtorr: 'mTorr',
                            micron: 'μm Hg'
                        };

                        function getPrecision() {
                            const selected = document.querySelector('input[name="precision"]:checked').value;
                            return selected;
                        }

                        function formatNumber(num, precision = 'auto') {
                            if (precision === 'scientific') {
                                return Number(num.toPrecision(5)).toExponential();
                            } else if (precision === 'auto') {
                                if (num >= 1000000 || (num !== 0 && Math.abs(num) < 0.0001)) {
                                    return Number(num.toPrecision(5)).toExponential();
                                } else if (num >= 1000) {
                                    return num.toLocaleString(undefined, { maximumFractionDigits: 2 });
                                } else if (Math.abs(num) < 1) {
                                    return num.toLocaleString(undefined, { maximumSignificantDigits: 6 });
                                } else {
                                    return num.toLocaleString(undefined, { maximumFractionDigits: 6 });
                                }
                            } else {
                                const decimals = parseInt(precision);
                                if (num !== 0 && Math.abs(num) < 0.5 * Math.pow(10, -decimals)) {
                                    return Math.abs(num) < 0.000001 ? Number(num.toPrecision(4)).toExponential() : num.toLocaleString(undefined, { maximumSignificantDigits: 4 });
                                }
                                return num.toLocaleString(undefined, { maximumFractionDigits: decimals });
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
                                conversionFormula.textContent = `1 ${fromSymbol} = ${formatNumber(conversionFactor, '6')} ${toSymbol}`;
                            }
                        }

                        function classifyVacuum(torrValue) {
                            if (torrValue >= 760) {
                                return { level: 'Atmospheric Pressure', description: 'Standard atmospheric conditions' };
                            } else if (torrValue >= 1) {
                                return { level: 'Rough Vacuum', description: 'Low vacuum range' };
                            } else if (torrValue >= 0.001) {
                                return { level: 'High Vacuum', description: 'Good vacuum for most applications' };
                            } else if (torrValue >= 0.000001) {
                                return { level: 'Ultra-High Vacuum', description: 'Excellent vacuum for research' };
                            } else {
                                return { level: 'Extreme High Vacuum', description: 'Space-like conditions' };
                            }
                        }

                        function convert() {
                            const inputVal = parseFloat(inputValue.value);
                            const fromUnitVal = fromUnit.value;
                            const toUnitVal = toUnit.value;
                            const precision = getPrecision();

                            if (!isNaN(inputVal)) {
                                // Convert to Torr first, then to target unit
                                const inTorr = inputVal * units[fromUnitVal];
                                const result = inTorr / units[toUnitVal];
                                
                                output.textContent = formatNumber(result, precision);

                                // Update all common units
                                torrOutput.textContent = formatNumber(inTorr, precision) + ' Torr';
                                atmOutput.textContent = formatNumber(inTorr / units.atm, precision) + ' atm';
                                mmhgOutput.textContent = formatNumber(inTorr / units.mmhg, precision) + ' mmHg';
                                pascalOutput.textContent = formatNumber(inTorr / units.pascal, precision) + ' Pa';
                                mtorrOutput.textContent = formatNumber(inTorr / units.mtorr, precision) + ' mTorr';
                                barOutput.textContent = formatNumber(inTorr / units.bar, precision) + ' bar';

                                // Update vacuum level classification
                                const vacuum = classifyVacuum(inTorr);
                                vacuumLevel.textContent = vacuum.level;
                                vacuumDescription.textContent = vacuum.description;
                            } else {
                                output.textContent = '--';
                                torrOutput.textContent = '--';
                                atmOutput.textContent = '--';
                                mmhgOutput.textContent = '--';
                                pascalOutput.textContent = '--';
                                mtorrOutput.textContent = '--';
                                barOutput.textContent = '--';
                                vacuumLevel.textContent = 'Enter pressure value';
                                vacuumDescription.textContent = '--';
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
                                unitPresets.forEach(btn => btn.classList.remove('bg-gray-200', 'text-gray-800'));
                                unitPresets.forEach(btn => btn.classList.add('bg-gray-100', 'text-gray-700'));
                                this.classList.remove('bg-gray-100', 'text-gray-700');
                                this.classList.add('bg-gray-200', 'text-gray-800');
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
